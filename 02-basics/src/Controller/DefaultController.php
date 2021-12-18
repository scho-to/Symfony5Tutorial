<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine, Request $request, Swift_Mailer $mailer)
    {
        $entityManager = $doctrine->getManager();

        $message = (new Swift_Message('Hello Email'))
            ->setFrom("send@example.com")
            ->setTo("receipant@receive.com")
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['name' => 'Robert']
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
