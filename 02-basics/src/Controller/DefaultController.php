<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    public function __construct($logger) {
        //use $logger defined in services.yaml in config folder
    }

    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        // $user = new User();
        // $user->setName("Robert");

        // for ($i=1; $i <= 3; $i++) { 
        //     $video = new Video();
        //     $video->setTitle("VideoTitle".$i);
        //     $user->addVideo($video);
        //     $entityManager->persist($video);
        // }

        // $entityManager->persist($user);
        
        $user = $entityManager->getRepository(User::class)->findWithVideos(1);
        dump($user);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
