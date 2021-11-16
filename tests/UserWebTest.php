<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserWebTest extends WebTestCase
{

    //Test de la page de connexion
    public function testLoginForm()
    {
        //Test de la page Connexion
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }
    
    //Test de la page d'inscription
    public function testRegisterForm(){
        //Test de la page Connexion
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscription');
    }

    //Test de la page "Mon Profil" en étant connecté
    public function testProfilePageWhenLogged()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Test (Fixture)
        $testUser = $userRepository->findOneByEmail('user0@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/profile');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mon Profil');
    }

    //Test de la page "Deconnexion" en étant connecté
    public function testLogoutPageWhenLogged()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        //Recherche du User Test (Fixture)
        $testUser = $userRepository->findOneByEmail('user0@functional-test.fr');

        //Simulation de Login
        $client->loginUser($testUser);

        //Test de la page profil
        $client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(302); //found
    }

}