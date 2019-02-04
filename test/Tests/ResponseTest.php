<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO,
		\Zumba\VanillaJsConnect\Config,
		\Zumba\VanillaJsConnect\Request,
		\Zumba\VanillaJsConnect\Response as Response,
		\Zumba\VanillaJsConnect\User;

class ResponseTests extends \PHPUnit\Framework\TestCase {

  /**
   * Test case toArray is called on an error response
   *
   */
	public function testToArrayWithErrorClass() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
			->disableOriginalConstructor()
			->getMock();

		$expectedResult = json_encode([
				'error' => 'access_denied',
				'message' => 'Signature invalid.'
		]);

		$errorResponse = new Response\InvalidSignature($request);

		$this->assertEquals($expectedResult, (string)$errorResponse);
	}

	public function testToArrayOverrideUnsignedResponse() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
			->disableOriginalConstructor()
			->getMock();

		$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
			->disableOriginalConstructor()
			->getMock();

		$user
			->method('getName')
			->will($this->returnValue('BLT'));

		$user
			->method('getPhotoUrl')
			->will($this->returnValue('food.'));

		$expectedResult = json_encode([
				'name' => 'BLT',
				'photourl' => 'food.',
				'signedin' => true
		]);

		$errorResponse = new Response\UnsignedRequest($request, $user);
		$this->assertEquals($expectedResult, (string)$errorResponse);
	}

	public function testToArrayEmptyUser() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
			->disableOriginalConstructor()
			->getMock();

		$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
			->disableOriginalConstructor()
			->getMock();

		$user
			->method('getName')
			->will($this->returnValue(''));

		$user
			->method('getPhotoUrl')
			->will($this->returnValue(''));

		$expectedResult = json_encode([
				'name' => '',
				'photourl' => ''
		]);

		$errorResponse = new Response\UnsignedRequest($request, $user);

		$this->assertEquals($expectedResult, (string)$errorResponse);
	}

	public function testToArrayOverrideInvalidClientResponse() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
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

	public function testToArrayWithValid() {
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

		$expectedResult = json_encode([
				'name' => 'Foo',
				'photourl' => 'imgur',
				'client_id' => 'Bar007',
				'signature' => 'd8174f110c2e4cb0811099b4a9ce819e'
		]);

		$this->assertEquals($expectedResult, (string)$response);
	}

	public function testAddProperties() {
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

		$signature = md5(http_build_query($queryArray, NULL, '&').'cake');
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

	public function testAddPropertiesWithError() {
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
			->method('getName')
			->will($this->returnValue(''));

		$user
			->method('getPhotoUrl')
			->will($this->returnValue(''));

		$config
			->method('getSecret')
			->will($this->returnValue('cake'));

		$config
			->method('getClientID')
			->will($this->returnValue('Bar007'));

		$response = new Response\UnsignedRequest($request, $user, $config);
		$response->addProperties(['test' => 'more', 'cake' => 'lie']);

		$expectedResult = json_encode([
				'name' => '',
				'photourl' => '',
		]);

		$this->assertEquals($expectedResult, (string)$response);
	}

	public function testCallback() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
			->disableOriginalConstructor()
			->getMock();
		$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
			->disableOriginalConstructor()
			->getMock();
		$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
			->disableOriginalConstructor()
			->getMock();

		$request
			->method('getCallback')
			->will($this->returnValue('Promise'));

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

		$expectedResult = "Promise(".
			json_encode([
				'name' => 'Foo',
				'photourl' => 'imgur',
				'client_id' => 'Bar007',
				'signature' => 'd8174f110c2e4cb0811099b4a9ce819e'
				]).
			")";

		$this->assertEquals($expectedResult, (string)$response);
	}

    public function testCallbackXSS() {
		$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
			->disableOriginalConstructor()
			->getMock();
		$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
			->disableOriginalConstructor()
			->getMock();
		$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
			->disableOriginalConstructor()
			->getMock();

		$request
			->method('getCallback')
			->will($this->returnValue('Promise'));

		$user
			->method('toArray')
			->will($this->returnValue(['name' => 'Foo', 'photourl' => '</script><script>doSomethingEvil()</script>']));

		$config
			->method('getSecret')
			->will($this->returnValue('cake'));

		$config
			->method('getClientID')
			->will($this->returnValue('Bar007'));

		$response = new Response($request, $user, $config);

		$expectedResult = "Promise(".
			json_encode([
				'name' => 'Foo',
				'photourl' => '&lt;/script&gt;&lt;script&gt;doSomethingEvil()&lt;/script&gt;',
				'client_id' => 'Bar007',
				'signature' => '7687b5439495d371feff3dc39587c661'
				]).
			")";

		$this->assertEquals($expectedResult, (string)$response);
	}
}
