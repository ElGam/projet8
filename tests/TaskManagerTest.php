<?php

namespace App\Tests;
use App\Entity\Task;
use App\Services\TaskManager;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class TaskManagerTest extends TestCase
{
    public function testCreate(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class); //Simuler entityManager
        $taskManager = new TaskManager($entityManager);

        
        $task = new Task();
        $task->setTitle("Titre");
        $task->setContent("Contenu");

        $task = $taskManager->create($task, 1);

        //Tests
        $this->assertSame("Titre", $task->getTitle());
        $this->assertSame("Contenu", $task->getContent());
        $this->assertSame(1, $task->getUserId());

    }

    public function testDelete(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class); //Simuler entityManager
        $taskManager = new TaskManager($entityManager);
        
        $task = new Task();
        $task->setTitle("Titre");
        $task->setContent("Contenu");

        $task_deleted = $taskManager->delete($task);

        //Tests
        $this->assertSame(true, $task_deleted);

    }

    public function testChangeStatus(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class); //Simuler entityManager
        $taskManager = new TaskManager($entityManager);

        
        $task = new Task();
        $task->setTitle("Titre");
        $task->setContent("Contenu");
        $task->setIsDone(0);

        $task = $taskManager->changeStatus($task, 1);

        //Tests
        $this->assertSame(true, $task->getIsDone());

    }

    public function testChangeContent(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class); //Simuler entityManager
        $taskManager = new TaskManager($entityManager);

        
        $task = new Task();
        $task->setTitle("Titre");
        $task->setContent("Contenu");

        $task = $taskManager->changeContent($task, "Nouveau Contenu");

        //Tests
        $this->assertSame("Nouveau Contenu", $task->getContent());

    }

    public function testChangeTitle(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class); //Simuler entityManager
        $taskManager = new TaskManager($entityManager);

        
        $task = new Task();
        $task->setTitle("Nouveau Titre");
        $task->setContent("Contenu");

        $task = $taskManager->changeTitle($task, "Nouveau Titre");

        //Tests
        $this->assertSame("Nouveau Titre", $task->getTitle());

    }

}
