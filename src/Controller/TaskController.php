<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function index(): Response
    {

        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/changeTitle/{id}", name="task_change_title")
     */
    public function changeTitle(int $id)
    {

        $request = Request::createFromGlobals();
        $title = json_decode($request->getContent())->title;
 
        if(strlen($title) < 2){ $title = "Untitled"; }

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $task->setTitle($title);
        $entityManager->flush();
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task/changeContent/{id}", name="task_change_content")
     */
    public function changeContent(int $id)
    {

        $request = Request::createFromGlobals();
        $content = json_decode($request->getContent())->content;
 
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $task->setContent($content);
        $entityManager->flush();
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task/changeStatus/{id}", name="task_change_status")
     */
    public function changeStatus(int $id)
    {

        $request = Request::createFromGlobals();
        $status = json_decode($request->getContent())->status;
 
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $task->setIsDone($status);
        $entityManager->flush();
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

}
