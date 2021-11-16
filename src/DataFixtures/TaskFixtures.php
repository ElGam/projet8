<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i=0; $i < 10; $i++){
            $task = new Task();
            $task->setTitle("Task $i");
            $task->setContent("Ma tâche n°$i");
            $task->setCreatedAt(new \DateTime('@'.strtotime('now')));
            $task->setIsDone(rand(0,1));
            $task->setUserId(1);
            $manager->persist($task);
        }
        $manager->flush();
    }
}
