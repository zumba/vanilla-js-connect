<?php

namespace Tests;

use \Zumba\VanillaJsConnect\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

		/**
		 * @dataProvider getMethodsProvider
		 */

		public function testGetMethods($args, $expectedValue, $method) {
			$request = new Request($args);

			$this->assertEquals($expectedValue, $request->$method());
		}

		public function getMethodsProvider() {

			return [
				'getClientID' => [['client_id' => 1234], 1234, 'getClientID'],
				'getTimestamp' => [['timestamp' => 9001], 9001, 'getTimestamp'],
				'getSignature' => [['signature' => 'foobar'], 'foobar', 'getSignature'],
				'getCallback' => [['callback' => 'functionName'], 'functionName', 'getCallback']
				];
		}
	}
