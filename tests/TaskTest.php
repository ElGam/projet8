<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;

class TaskTest extends WebTestCase{

    public function testTaskCreate(){
        $task = new Task(); // Create Task object.
        $task->setTitle("Example Title");
        $task->setContent("Example Content");
        
        $this->assertEquals("Example Title", $task->getTitle());
        $this->assertEquals("Example Content", $task->getContent());
        $this->assertEquals(NULL, $task->getId());
    }


}