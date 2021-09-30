<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\ProfileFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profileUpdate", name="profile_update")
     */
    public function update(UserPasswordEncoderInterface $encoder): Response
    {

        $user = $this->getUser();
        $request = Request::createFromGlobals();
        $password = $request->request->get('password');
        $email = $request->request->get('email');
        $role = $request->request->get('role'); //admin / user

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($user->getId());

        $user->setEmail($email);
        $password_encoded = $encoder->encodePassword($user, $password);
        $user->setPassword($password_encoded);
        if($role == 'admin'){ $user->setRoles(array('ROLE_ADMIN')); }
        if($role == 'user'){ $user->setRoles(array('ROLE_USER')); }
        
        $entityManager->flush();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profileDelete_{id}", name="profile_delete")
     */
    public function delete(int $id)
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if($user->getId() == $id || $roles[0] == "ROLE_ADMIN" || $roles[1] == "ROLE_ADMIN")
        {
            $user_id = $user->getId();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id); 
            
            if((int) $user_id == (int) $id){
                $this->container->get('security.token_storage')->setToken(null);
                $em->remove($user);
                $em->flush();
                return $this->render('accueil/index.html.twig', [
                    'controller_name' => 'UserController',
                ]);
            }else{
                return $this->redirect($this->generateUrl('admin_users'));
            }
            
        }        
    }

    /**
     * @Route("/admin_users", name="admin_users")
    */
    public function adminUsers(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        if($roles[0] == "ROLE_ADMIN" || $roles[1] == "ROLE_ADMIN"){
            
            $em = $this->getDoctrine()->getManager();
            $users = $em->getRepository(User::class)->findAll(); 
            return $this->render('user/list.html.twig', [
                'users' => $users,
            ]);
        }

        return $this->render('accueil/index.html.twig', [
        ]);
        
    }

}
