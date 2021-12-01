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
use App\Services\TaskManager;

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
    public function changeTitle(int $id, Request $request, TaskManager $taskManager)
    {

        //Récupération du titre
        $title = json_decode($request->getContent())->title;
 
        if(strlen($title) < 2){ $title = "Untitled"; }

        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        $taskManager->changeTitle($task, $title);
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task/changeContent/{id}", name="task_change_content")
     */
    public function changeContent(int $id, Request $request, TaskManager $taskManager)
    {

        $content = json_decode($request->getContent())->content;
 
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        //Service: TaskManager : ChangeStatus
        $taskManager->changeContent($task, $content);
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task/changeStatus/{id}", name="task_change_status")
     */
    public function changeStatus(int $id, Request $request, TaskManager $taskManager)
    {

        //Récupération du status
        $status = json_decode($request->getContent())->status;
 
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        //Service: TaskManager : ChangeStatus
        $taskManager->changeStatus($task, $status);
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */
    public function delete(int $id, TaskManager $taskManager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        //Service: TaskManager : Delete
        $taskManager->delete($task);
        
        $response = new JsonResponse(['success' => true]);
        return $response;
    }

    /**
     * @Route("/task_create", name="task_create")
     */
    public function create(Request $request, TaskManager $taskManager): Response
    {
        $task = new Task();
        $user = $this->getUser();

        //Récupération du formulaire
        $form = $this->createForm(NewTaskFormType::class, $task);

        //Vérification des données
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();


            //Service : TaskManager
            $taskManager->create($task, $user->getId());

            //Redirection vers route
            return $this->redirect($this->generateUrl('tasks'));
        }

        //Redirection vers la vue
        return $this->renderForm('task/new.html.twig', [
            'form' => $form,
        ]);
    }

}
