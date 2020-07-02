<?php

namespace Tests;

use \Zumba\VanillaJsConnect\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase {

    /**
    * @expectedException \LogicException
    */
    public function testConfigExpectNonEmptyArray() {
        $config = new Config([]);
    }

    /**
    * @dataProvider expectedKeysProvider
    */
    public function testArrayContainsExpectedKeys(array $options, $expectedException) {
        $this->expectException($expectedException);
        $config = new Config($options);
    }

    public function expectedKeysProvider() {
        return [
            'missingClientID' => [['secret' => 1234], \DomainException::class],
            'missingSecret' => [['clientID' => 1234], \DomainException::class]
        ];
    }

    public function testGetClientID() {
        $config = new Config(['clientID' => 1234, 'secret' => 'abcde']);

        $this->assertEquals(1234, $config->getClientID());
    }

    public function testGetSecret() {
        $config = new Config(['clientID' => 1234, 'secret' => 'abcde']);

        $this->assertEquals('abcde', $config->getSecret());
    }

    public function testDefaultJsTimeout() {
        $config = new Config(['clientID' => 1234, 'secret' => 'abcde']);

        $this->assertEquals(Config::DEFAULT_JS_TIMEOUT, $config->getJsTimeout());
    }

    public function testSetJsTimeout() {
        $config = new Config(['clientID' => 1234, 'secret' => 'abcde', 'jsTimeout' => 2]);

        $this->assertEquals(2, $config->getJsTimeout());
    }
}
