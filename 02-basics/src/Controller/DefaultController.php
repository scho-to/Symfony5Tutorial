<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine, Request $request, MailerInterface $mailer)
    {
        $entityManager = $doctrine->getManager();

        // $message = (new Swift_Message('Hello Email'))
        //     ->setFrom("send@example.com")
        //     ->setTo("receipant@receive.com")
        //     ->setBody(
        //         $this->renderView(
        //             'emails/registration.html.twig',
        //             ['name' => 'Robert']
        //         ),
        //         'text/html'
        //     )
        // ;

        // $mailer->send($message);

        $email = (new Email())
            ->from("send@example.com")
            ->to("receipant@receive.com")
            ->subject("Thanks for registration!")
            ->html(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['name' => 'Robert']
                )
            )
        ;

        $mailer->send($email);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
