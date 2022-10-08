<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
         // ... e.g. get the user data from a registration form
         $entityManager = $doctrine->getManager();
         $user = new User();
         $user->setEmail("admin@admin.com");
         //$user->setEmail("visitor@admin.com");
         $plaintextPassword ="12345";
 
         // hash the password (based on the security.yaml config for the $user class)
         $hashedPassword = $passwordHasher->hashPassword(
             $user,
             $plaintextPassword
         );
         $user->setPassword($hashedPassword);
         // $user->setRoles(["ROLE_MODERATOR"]);
        $user->setRoles(["ROLE_ADMIN"]);
         $entityManager->persist($user);
         $entityManager->flush();
        return new Response("Successfully registered");
    }
}
