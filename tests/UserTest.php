<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class UserTest extends TestCase{

    public function testTestsAreWorking(){
        $this->assertEquals(2, 1+1);
    }

    public function testUserCreate(){
        $user = new User(); // Create User object.
        $user->setEmail("user.test@email.com");
        $user->setRoles(array('ROLE_USER'));
        
        $this->assertEquals("user.test@email.com", $user->getEmail());
        $this->assertEquals(array('ROLE_USER'), $user->getRoles());
        $this->assertEquals(NULL, $user->getId());

    }


}