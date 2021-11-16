<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskWebTest extends WebTestCase
{

    //Test de la page "Mes Tâches" en étant connecté
    public function testTasksPageWhenLogged()
    {
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

    //Test de la page "Gestion des Tâches" en étant connecté en tant qu'Admin
    public function testAdminTasksPageWhenLoggedAsAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Test (Fixture)
        $testUser = $userRepository->findOneByEmail('admin@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/admin_tasks');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Gestion des Tâches');
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
        $client->request('GET', '/task_new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nouvelle Tâche');
    }

}