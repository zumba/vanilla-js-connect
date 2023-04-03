<?php

namespace Tests;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Zumba\VanillaJsConnect\Config;

/**
 * Test to ensure Firebase JWT's interfaces work as expected.
 */
class JWTTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testEncode(array $payload, string $key, string $encodedExpected)
    {
        $encoded = JWT::encode($payload, $key, Config::ALG_HS256);
        $this->assertSame($encodedExpected, $encoded);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testDecode(array $payloadExpected, string $key, string $encoded)
    {
        $payload = (array)JWT::decode($encoded, new Key($key, Config::ALG_HS256));
        $this->assertSame($payloadExpected, $payload);
    }

    public function dataProvider()
    {
        return [
            [
                'payload' => ['name' => 'John', 'surname' => 'Doe'],
                'key' => 'abc123',
                'encoded' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiSm9obiIsInN1cm5hbWUiOiJEb2UifQ.vXqTTM3hFUiquzjEmqr_P0vFojaMJ0sOfhqUNGkW-fE',
            ]
        ];
    }
}
