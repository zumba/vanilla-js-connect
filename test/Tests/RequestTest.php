<?php

namespace Tests;

use \Zumba\VanillaJsConnect\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function testGetToken() {
        $token = 'eyJhb';
        $request = new Request($token);
        $this->assertEquals($token, $request->getToken());
    }
}
