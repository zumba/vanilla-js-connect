<?php

namespace Tests;

use Firebase\JWT\JWT;
use LogicException;
use PHPUnit\Framework\TestCase;
use Zumba\VanillaJsConnect\Config;
use Zumba\VanillaJsConnect\Request;
use Zumba\VanillaJsConnect\Response as Response;
use Zumba\VanillaJsConnect\User;

class ResponseTest extends TestCase {

    /**
     * Test case toArray is called on an error response
     */
    public function testInvalidSignatureResponse() {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expectedResult = json_encode([
            'error' => 'access_denied',
            'message' => 'Signature invalid.'
        ]);

        $errorResponse = new Response\InvalidSignature($request);

        $this->assertEquals($expectedResult, (string)$errorResponse);
    }

    public function testUnsignedResponse() {

        $config = new Config([
            'clientID' => '1234',
            'secret' => 's3cr3t',
        ]);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getToken'])
            ->getMock();
        $request->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('encoded_token'));

        $user = $this->getMockBuilder(User::class)
            ->setConstructorArgs([[]])
            ->getMock();

        $mockUnsignedResponse = $this->getMockBuilder(Response\UnsignedRequest::class)
            ->setConstructorArgs([$request, $user, $config])
            ->setMethods(['decodeToken', 'getTimestamp'])
            ->getMock();

        $mockUnsignedResponse->expects($this->any())
            ->method('getTimestamp')
            ->will($this->returnValue(1000));

        $decodedToken = [
            'st' => ['tokenStateRandom'],
        ];
        $mockUnsignedResponse->expects($this->any())
            ->method('decodeToken')
            ->with('encoded_token')
            ->will($this->returnValue($decodedToken));

        $encodedResponse = $mockUnsignedResponse->encodeResponse();

        $this->assertNotEmpty($encodedResponse);

        list(, $payload) = explode('.', $encodedResponse);
        $decodedPayload = json_decode(JWT::urlsafeB64Decode($payload), true);

        $expectedResult = [
            'v' => 'php:3',
            'iat' => 1000,
            'exp' => 1600,
            'u' => [],
            'st' => [
                'tokenStateRandom',
            ],
        ];

        $this->assertEquals($expectedResult, $decodedPayload);
    }

    public function testInvalidClientResponse() {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expectedResult = json_encode([
            'error' => 'invalid_client',
            'message' => 'Unknown client Agent Smith.'
        ]);

        $errorResponse = new Response\InvalidClientID($request);
        $errorResponse->setClientID('Agent Smith');

        $this->assertEquals($expectedResult, (string)$errorResponse);
    }

    public function testValidResponse() {
        $config = new Config([
            'clientID' => '1234',
            'secret' => 's3cr3t',
        ]);

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getToken'])
            ->getMock();
        $request->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('encoded_request_token'));

        $user = $this->getMockBuilder(User::class)
            ->setConstructorArgs([[
                'uniqueId' => 'unique-id',
                'name' => 'User Name',
                'email' => 'user@example.com',
                'photoUrl' => 'https://example.com/photo.jpg',
            ]])
            ->getMock();

        $mockResponse = $this->getMockBuilder(Response::class)
            ->setConstructorArgs([$request, $user, $config])
            ->setMethods(['decodeToken', 'getRedirectUrl'])
            ->getMock();

        $decodedToken = [
            'st' => ['tokenStateRandom'],
        ];
        $mockResponse->expects($this->any())
            ->method('decodeToken')
            ->with('encoded_request_token')
            ->will($this->returnValue($decodedToken));
        $mockResponse->expects($this->once())
            ->method('getRedirectUrl')
            ->will($this->returnValue('http://example.com#?jwt=newJwtToken'));

        $this->assertEquals('http://example.com#?jwt=newJwtToken', (string)$mockResponse);
    }

    public function testAddProperties() {
        $this->markTestIncomplete('needs to be refactored');
        $request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
            ->disableOriginalConstructor()
            ->getMock();
        $user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
            ->disableOriginalConstructor()
            ->getMock();
        $config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
            ->disableOriginalConstructor()
            ->getMock();

        $user
            ->method('toArray')
            ->will($this->returnValue(['name' => 'Foo', 'photourl' => 'imgur']));

        $config
            ->method('getSecret')
            ->will($this->returnValue('cake'));

        $config
            ->method('getClientID')
            ->will($this->returnValue('Bar007'));

        $response = new Response($request, $user, $config);
        $response->addProperties(['test' => 'more', 'cake' => 'lie']);

        $queryArray = [
            'cake' => 'lie',
            'name' => 'Foo',
            'photourl' => 'imgur',
            'test' => 'more'
        ];

        $signature = md5(http_build_query($queryArray, NULL, '&') . 'cake');
        $expectedResult = json_encode([
            'cake' => 'lie',
            'name' => 'Foo',
            'photourl' => 'imgur',
            'test' => 'more',
            'client_id' => 'Bar007',
            'signature' => $signature,
        ]);

        $this->assertEquals($expectedResult, (string)$response);
    }

    public function testEncodeResponseNoConfig() {
        $request = new Request('jwt');
        $response = new Response($request);

        // Should not try to encode response if there is no config
        $this->expectException(LogicException::class);
        $response->encodeResponse();
    }

    public function testGetRedirectUrlNoConfig() {
        $request = new Request('jwt');
        $response = new Response($request);

        // Should not try to get redirect url if there is no config
        $this->expectException(LogicException::class);
        $response->getRedirectUrl();
    }

}
