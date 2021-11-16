<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\NewTaskFormType;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAllByUserId($user->getId());

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/admin_tasks", name="admin_tasks")
     */
    public function adminTasks(): Response
    {
        $user = $this->getUser();
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $roles = $user->getRoles();
        if($roles[0] == "ROLE_ADMIN" || $roles[1] == "ROLE_ADMIN"){
            $tasks = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();
        }
        
        return $this->render('task/admin.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks,
            'users' => $users,
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

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */
    public function delete(int $id)
    {

 
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $entityManager->remove($task);
        $entityManager->flush();
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task_new", name="task_new")
     */
    public function new()
    {
        $task = new Task();
        // ...

        $form = $this->createForm(NewTaskFormType::class, $task);

        return $this->renderForm('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/task_create", name="task_create")
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $user_id = $user->getId();
        $request = Request::createFromGlobals();
        $new_task_form = $request->request->get('new_task_form');
        $title = $new_task_form['title'];
        $content = $new_task_form['content'];
        $datetime = $date = new \DateTime('@'.strtotime('now'));


        $task = new Task();
        $task->setTitle($title);
        $task->setContent($content);
        $task->setUserId($user_id);
        $task->setCreatedAt($datetime);
        $task->setIsDone(0);
        $entityManager->persist($task);
        $entityManager->flush();


        return $this->redirect($this->generateUrl('tasks'));
    }

}
