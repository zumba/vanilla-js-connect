<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO,
		\Zumba\VanillaJsConnect\Config,
		\Zumba\VanillaJsConnect\Request,
		\Zumba\VanillaJsConnect\Response
		\Zumba\VanillaJsConnect\User,
		\Zumba\VanillaJsConnect\Response;

class SSOTest extends \PHPUnit\Framework\TestCase {

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

		public function testMissingClientID() {
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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\MissingClientID', $sso->getResponse());

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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\InvalidClientID', $sso->getResponse());

		}

		public function testUnsignedRequest() {
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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\UnsignedRequest', $sso->getResponse());

		}

		public function testMissingTimestamp() {
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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\InvalidTimestamp', $sso->getResponse());

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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\InvalidTimestamp', $sso->getResponse());

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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\MissingSignature', $sso->getResponse());
		}

		public function testExpiredTimestamp() {
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

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\ExpiredTimestamp', $sso->getResponse());

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
				->will($this->returnValue('fail'));

			$request
				->method('getTimestamp')
				->will($this->returnValue(time()));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$config
				->method('getSecret')
				->will($this->returnValue('foobar'));

			$sso = new SSO($request, $user, $config);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\InvalidSignature', $sso->getResponse());
		}

		public function testAddValidator() {
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
				->will($this->returnValue(md5(time().'foobar')));

			$request
				->method('getTimestamp')
				->will($this->returnValue(time()));

			$config
				->method('getClientID')
				->will($this->returnValue('abc'));

			$config
				->method('getSecret')
				->will($this->returnValue('foobar'));

			$sso = new SSO($request, $user, $config);

			$validator = function($request, $user, $config) {
				return new Response\UnsignedRequest($request, $user);
			};

			$sso->addValidator($validator);

			$this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\UnsignedRequest', $sso->getResponse());
		}

}
