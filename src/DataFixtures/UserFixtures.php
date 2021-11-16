<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\Security\Core\Encoder\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
            $user = new User();
            $user->setEmail("admin@functional-test.fr");
            $user->setPassword("fixture_test");
            $user->setRoles(array('ROLE_ADMIN'));
            $manager->persist($user);

        for($i=0; $i < 10; $i++){
            $user = new User();
            $user->setEmail("user$i@functional-test.fr");
            $user->setPassword("fixture_test");
            $user->setRoles(array('ROLE_USER'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
