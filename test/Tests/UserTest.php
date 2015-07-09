<?php

namespace Tests;

use \Zumba\VanillaJsConnect\User;

class UserTest extends \PHPUnit_Framework_TestCase {

		public function testGetEmail() {
			$user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photourl' => 'imgur.com/ARST',
        'uniqueid' => 'foobar123'
      ]);

			$this->assertEquals('foo@bar.baz', $user->getEmail());
		}

    public function testGetName() {
			$user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photourl' => 'imgur.com/ARST',
        'uniqueid' => 'foobar123'
      ]);

			$this->assertEquals('Foo Bar', $user->getName());
		}

    public function testGetPhotoUrl() {
			$user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photoUrl' => 'imgur.com/ARST',
        'username' => 'foobar123'
      ]);

			$this->assertEquals('imgur.com/ARST', $user->getPhotoUrl());
		}

    public function testGetUniqueID() {
			$user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photoUrl' => 'imgur.com/ARST',
        'username' => 'foobar123'
      ]);

			$this->assertEquals('foobar123', $user->getUniqueId());
		}

    public function testToArray() {
			$user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photoUrl' => 'imgur.com/ARST',
        'username' => 'foobar123'
      ]);

      $expectedArray = [
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photourl' => 'imgur.com/ARST',
        'uniqueid' => 'foobar123'
      ];

			$this->assertEquals($expectedArray, $user->toArray());
		}

}
