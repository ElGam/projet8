<?php
namespace App\Services;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function create(Task $task, $user_id)
    {

        $datetime = $date = new \DateTime('@'.strtotime('now'));

        $task->setCreatedAt($datetime);
        $task->setIsDone(0);
        $task->setUserId($user_id);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function delete(Task $task)
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return true;
    }

    public function changeStatus(Task $task, int $status)
    {

        $task->setIsDone($status);
        $this->entityManager->flush();

        return $task;
    }

    public function changeContent(Task $task, $content)
    {

        $task->setContent($content);
        $this->entityManager->flush();

        return $task;
    }

    public function changeTitle(Task $task, $title)
    {

        $task->setTitle($title);
        $this->entityManager->flush();

        return $task;
    }

}