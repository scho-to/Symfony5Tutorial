<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{

    public function __construct($logger) {
        //use $logger defined in services.yaml in config folder
    }

    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //$users = ['Adam', 'Robert', 'John', 'Susan'];
        //$manager = $doctrine->getManager();
        //$users = $manager->getRepository(User::class)->findAll();
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }

    public function mostPopularPosts($number = 3){
        $posts = [];
        for($i = 1; $i <= $number; $i++){
            $posts[] = "Post ".$i;
        }
        return $this->render('default/most_pupular_posts.html.twig', [
            'posts' => $posts
        ]);
    }
}
