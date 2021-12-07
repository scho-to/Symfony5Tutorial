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
        $user = $doctrine->getRepository(User::class)->find(1);
        $entityManager = $doctrine->getManager();

        $video = $doctrine->getRepository(Video::class)->find(1);
        $user->removeVideo($video);
        $entityManager->flush();

        foreach ($user->getVideos() as $video) {
            dump($video->getTitle());
        }

        // $entityManager->remove($user);
        // $entityManager->flush();
        // $dump($user);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
