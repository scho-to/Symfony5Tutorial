<?php

namespace App\Controller;

use App\Entity\Address;
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

        $user = new User();
        $user->setName("Tobias");
        $address = new Address();
        $address->setStreet("street");
        $address->setNumber(1);
        $user->setAddress($address);

        $entityManager->persist($user);
        //$entityManager->persist($address);

        $entityManager->flush();
        dump($user->getAddress()->getStreet());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
