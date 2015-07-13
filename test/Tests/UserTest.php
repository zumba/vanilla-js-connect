<?php

namespace Tests;

use \Zumba\VanillaJsConnect\User;

class UserTest extends \PHPUnit_Framework_TestCase {

    public function testGetName() {
      $user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photourl' => 'imgur.com/ARST',
        'uniqueId' => 'foobar123'
      ]);

      $this->assertEquals('Foo Bar', $user->getName());
    }

    public function testGetPhotoUrl() {
      $user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photoUrl' => 'imgur.com/ARST',
        'uniqueId' => 'foobar123'
      ]);

      $this->assertEquals('imgur.com/ARST', $user->getPhotoUrl());
    }

    public function testGetNameWithEmpty() {
      $user = new User([]);

      $this->assertEquals('', $user->getName());
    }

    public function testGetPhotoUrlWithEmpty() {
      $user = new User([]);

      $this->assertEquals('', $user->getPhotoUrl());
    }

    public function testToArray() {
      $user = new User([
        'email' => 'foo@bar.baz',
        'name' => 'Foo Bar',
        'photoUrl' => 'imgur.com/ARST',
        'uniqueId' => 'foobar123'
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
