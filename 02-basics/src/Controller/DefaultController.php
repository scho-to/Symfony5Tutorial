<?php

namespace App\Controller;

use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $entityManager = $doctrine->getManager();
        $videos = $entityManager->getRepository(Video::class)->findAll();
        dump($videos);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/login",name="login")
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
