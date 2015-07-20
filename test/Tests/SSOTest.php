<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO,
		\Zumba\VanillaJsConnect\Config,
		\Zumba\VanillaJsConnect\Request,
		\Zumba\VanillaJsConnect\Response
		\Zumba\VanillaJsConnect\User,
		\Zumba\VanillaJsConnect\ErrorResponse;

class SSOTest extends \PHPUnit_Framework_TestCase {

		public function testGetResponse() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response', $sso->getResponse());
		}

		public function testClientIDMissing() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->expects($this->once())
				->method('getClientID')
				->will($this->returnValue(null));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\ClientIDMissing', $sso->getResponse());

		}

		public function testInvalidClientID() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('xyz'));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\InvalidClient', $sso->getResponse());

		}

		public function testUnsignedResponse() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

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

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(null));

			$request
				->method('getSignature')
				->will($this->returnValue(null));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\Unsigned', $sso->getResponse());

		}

		public function testIfTimestampMissing() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('foobar'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(null));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\InvalidOrMissingTimeStamp', $sso->getResponse());

		}

		public function testIfTimestampNotANumber() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('foobar'));

			$request
				->method('getTimestamp')
				->will($this->returnValue('AlphaNumeric1'));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\InvalidOrMissingTimeStamp', $sso->getResponse());

		}

		public function testMissingSignature() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue(null));

			$request
				->method('getTimestamp')
				->will($this->returnValue(1234));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\MissingSignature', $sso->getResponse());
		}

		public function testIsSignatureValid() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->setMethods(['getSecret', 'getClientID'])
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('foobar'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(1));

			$config
				->method('getSecret')
				->will($this->returnValue('secret'));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = $this->getMockBuilder('\Zumba\VanillaJsConnect\SSO')
				->setConstructorArgs([$request, $user, $config])
				->setMethods(['getTime'])
				->getMock();

			$sso
			  ->expects($this->any())
				->method('getTime')
				->will($this->returnValue(1500));

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\InvalidTimestamp', $sso->getResponse());

		}

		public function testInvalidSignature() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->setMethods(['getSecret', 'getClientID'])
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('50b92ec1d11742afc6b983ec1650c418nope'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(0));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$config
				->method('getSecret')
				->will($this->returnValue('foobar'));

			$sso = $this->getMockBuilder('\Zumba\VanillaJsConnect\SSO')
				->setConstructorArgs([$request, $user, $config])
				->setMethods(['getTime'])
				->getMock();

			$sso
				->method('getTime')
				->will($this->returnValue(1));

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse\AccessDenied', $sso->getResponse());
		}

		public function testHandleValidatorsFailing() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->setMethods(['getSecret', 'getClientID'])
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('0ad79caf88876ade6152c4eb5187c240'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(0));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$config
				->method('getSecret')
				->will($this->returnValue('foobar'));

			$sso = $this->getMockBuilder('\Zumba\VanillaJsConnect\SSO')
				->setConstructorArgs([$request, $user, $config])
				->setMethods(['getTime'])
				->getMock();

			$sso
				->method('getTime')
				->will($this->returnValue(1));

			$validatorOne = function() use ($request) {
				$error = new ErrorResponse($request);
				$error->setError("some error");
				$error->setMessage("some message");
				return $error;
			};

			$sso->addCustomValidator($validatorOne);
			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ErrorResponse', $sso->getResponse());
		}

		public function testHandleValidatorsPassing() {
			$config = $this->getMockBuilder('\Zumba\VanillaJsConnect\Config')
				->setMethods(['getSecret', 'getClientID'])
				->disableOriginalConstructor()
				->getMock();

			$request = $this->getMockBuilder('\Zumba\VanillaJsConnect\Request')
				->disableOriginalConstructor()
				->getMock();

			$user = $this->getMockBuilder('\Zumba\VanillaJsConnect\User')
				->disableOriginalConstructor()
				->getMock();

			$request
				->method('getClientID')
				->will($this->returnValue('abc'));

			$request
				->method('getSignature')
				->will($this->returnValue('0ad79caf88876ade6152c4eb5187c240'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(0));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$config
				->method('getSecret')
				->will($this->returnValue('foobar'));

			$sso = $this->getMockBuilder('\Zumba\VanillaJsConnect\SSO')
				->setConstructorArgs([$request, $user, $config])
				->setMethods(['getTime'])
				->getMock();

			$sso
				->method('getTime')
				->will($this->returnValue(1));

			$validatorOne = function() {
				//I do nothing
			};

			$sso->addCustomValidator($validatorOne);
			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response', $sso->getResponse());
		}
}
