<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;

class TaskTest extends WebTestCase{

    public function testTestsAreWorking(){
        $this->assertEquals(2, 1+1);
    }

    public function testTaskCreate(){
        $task = new Task(); // Create User object.
        $task->setTitle("Example Title");
        $task->setContent("Example Content");
        
        $this->assertEquals("Example Title", $task->getTitle());
        $this->assertEquals("Example Content", $task->getContent());
        $this->assertEquals(NULL, $task->getId());
    }

    public function testChangeTitle(){
        //
        $client = static::createClient();
        $task = new Task();
        $task->setTitle("gg");
        //$client->request('POST', '/task/changeTitle/1', ($task));
        
        //$this->assertEquals("Ranger la maison", "tiit");
    }


}