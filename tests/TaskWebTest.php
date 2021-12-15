<?php
namespace App\Tests;

use App\Repository\UserRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskWebTest extends WebTestCase
{

    //Test de la page "Mes Tâches" en étant connecté
    public function testTasksPageWhenLogged()
    {
        //Création du client
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Test (Fixture)
        $testUser = $userRepository->findOneByEmail('user0@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mes Tâches');
    }


    //Test de la page "Nouvelle Tâche" en étant connecté
    public function testNewTaskPageWhenLogged()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Test (Fixture)
        $testUser = $userRepository->findOneByEmail('user0@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/task_create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nouvelle Tâche');
    }

    //Test Change:Title
    public function testChangeTitle(){

        //Création du client
        $client = static::createClient();

        //Recherche des Fixtures
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneByTitle('Task 0');

        //Test de la page profil
        $client->request('POST', '/task/changeTitle/' . $task->getId(), [], [], [], json_encode(["title" => "New Title"]));
        $this->assertResponseIsSuccessful();

        $task = $taskRepository->findOneByTitle('New Title');
        $this->assertEquals("New Title", $task->getTitle());
        $client->request('POST', '/task/changeTitle/' . $task->getId(), [], [], [], json_encode(["title" => "Task 0"]));

    }

    //Test Change:Title
    public function testChangeContent(){

        //Création du client
        $client = static::createClient();

        //Recherche des Fixtures
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneByTitle('Task 0');

        //Test de la page profil
        $client->request('POST', '/task/changeContent/' . $task->getId(), [], [], [], json_encode(["content" => "New Content"]));
        $this->assertResponseIsSuccessful();

        $task = $taskRepository->findOneByContent('New Content');
        $this->assertEquals("New Content", $task->getContent());
        $client->request('POST', '/task/changeContent/' . $task->getId(), [], [], [], json_encode(["content" => "New Content"]));

    }

    //Test: Change Status
    public function testChangeStatus(){
        //Création du client
        $client = static::createClient();

        //Recherche des Fixtures
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneByTitle('Task 0');

        //Test de la page profil
        $client->request('POST', '/task/changeStatus/' . $task->getId(), [], [], [], json_encode(["status" => 1]));
        $this->assertResponseIsSuccessful();

        $task = $taskRepository->findOneByTitle('Task 0');
        $this->assertEquals(1, $task->getIsDone());
        $client->request('POST', '/task/changeStatus/' . $task->getId(), [], [], [], json_encode(["status" => 0]));

    }

    //Test: Administration des Tâches
    public function testAdminTasks(){
        //Création du client
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Admin Test (Fixture)
        $testUser = $userRepository->findOneByEmail('admin@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/admin_tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Gestion des Tâches');
    }

    //Test: Administration des Tâches [ROLE USER]
    public function testAdminTasksForbidden(){
        //Création du client
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Admin Test (Fixture)
        $testUser = $userRepository->findOneByEmail('user0@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/admin_tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testDelete(){
        //Création du client
        $client = static::createClient();

        //Recherche des Fixtures
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneByTitle('Task 0');

        //Test de la page profil
        $client->request('GET', '/task/delete/' . $task->getId());
        $this->assertResponseIsSuccessful();
        $this->assertEquals('{"success":true}', $client->getResponse()->getContent());
    }

}