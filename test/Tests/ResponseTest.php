<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO,
		\Zumba\VanillaJsConnect\Config,
		\Zumba\VanillaJsConnect\Request,
		\Zumba\VanillaJsConnect\Response,
		\Zumba\VanillaJsConnect\User,
		\Zumba\VanillaJsConnect\AccessDeniedResponse,
		\Zumba\VanillaJsConnect\UnsignedResponse,
		\Zumba\VanillaJsConnect\InvalidClientResponse;

class ResponseTests extends \PHPUnit_Framework_TestCase {

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

		$errorResponse = new AccessDeniedResponse($request);

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

		$errorResponse = new UnsignedResponse($request, $user);

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

		$errorResponse = new InvalidClientResponse($request);
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
		$response->addProperties(['test' => 'poop', 'cake' => 'lie']);

		$expectedResult = json_encode([
				'name' => 'Foo',
				'photourl' => 'imgur',
				'client_id' => 'Bar007',
				'signature' => 'd8174f110c2e4cb0811099b4a9ce819e',
				'test' => 'poop',
				'cake' => 'lie'
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
}
