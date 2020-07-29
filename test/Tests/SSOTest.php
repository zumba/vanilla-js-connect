<?php

namespace Tests;

use \Zumba\VanillaJsConnect\SSO;
use \Zumba\VanillaJsConnect\Config;
use \Zumba\VanillaJsConnect\Request;
use \Zumba\VanillaJsConnect\User;
use \Zumba\VanillaJsConnect\Response;

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

    protected function setProtectedProperty($object, $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
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

        $invalidClientIdValidator = $this->getMockBuilder(\Zumba\VanillaJsConnect\Response\InvalidClientID::class)
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();
        $invalidClientIdValidator->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new \Zumba\VanillaJsConnect\Response\InvalidClientID($request, $user, $config)));

        $sso = new SSO($request, $user, $config);
        $this->setProtectedProperty($sso, 'validators', [$invalidClientIdValidator]);

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

        $unsignedRequestValidator = $this->getMockBuilder(\Zumba\VanillaJsConnect\Response\UnsignedRequest::class)
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();
        $unsignedRequestValidator->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(new \Zumba\VanillaJsConnect\Response\UnsignedRequest($request, $user, $config)));

        $sso = new SSO($request, $user, $config);
        $this->setProtectedProperty($sso, 'validators', [$unsignedRequestValidator]);

        $this->assertInstanceOf('\Zumba\VanillaJsConnect\Response\UnsignedRequest', $sso->getResponse());

    }
}
