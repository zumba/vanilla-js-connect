<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO,
		\Zumba\VanillaJsConnect\Config,
		\Zumba\VanillaJsConnect\Request,
		\Zumba\VanillaJsConnect\Response
		\Zumba\VanillaJsConnect\User;

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

			$sso = new SSO($request, $config, $user);

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

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\ClientIDMissingResponse', $sso->getResponse());

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

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\InvalidClientResponse', $sso->getResponse());

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

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\UnsignedResponse', $sso->getResponse());

		}

		public function testIsValidTimestampIfMissingTime() {
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

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\InvalidOrMissingTimeStampResponse', $sso->getResponse());

		}

		public function testValidTimestampIfNotNubmer() {
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

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\InvalidOrMissingTimeStampResponse', $sso->getResponse());

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
				->will($this->returnValue('1234'));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $config, $user);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\MissingSignatureResponse', $sso->getResponse());

		}

		public function testIsSignatureValid() {
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
				->will($this->returnValue('123'));

			$config
				->method('getSecret')
				->will($this->returnValue('secret'));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$sso = new SSO($request, $config, $user);
			//@todo
			$this->assertInstanceOf('\Zumba\VanillaJsConnect\InvalidTimestamp', $sso->getResponse());

		}

}
