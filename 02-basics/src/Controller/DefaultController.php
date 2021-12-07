<?php

namespace App\Controller;

use App\Entity\User;
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

        // for ($i=1; $i <= 4; $i++) { 
        //     $user = new User();
        //     $user->setName("User - ".$i);
        //     $entityManager->persist($user);
        // }

        // $entityManager->flush();
        // dump("last user id - ".$user->getId());

        $user1 = $entityManager->getRepository(User::class)->find(1);
        // $user2 = $entityManager->getRepository(User::class)->find(2);
        // $user3 = $entityManager->getRepository(User::class)->find(3);
        $user4 = $entityManager->getRepository(User::class)->find(4);

        // $user1->addFollowed($user2);
        // $user1->addFollowed($user3);
        // $user1->addFollowed($user4);
        // $entityManager->flush();

        dump($user1->getFollowed()->count());
        dump($user1->getFollowing()->count());
        dump($user4->getFollowing()->count());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
