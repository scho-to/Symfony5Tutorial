<?php

namespace App\Controller;

use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Events\VideoCreatedEvent;
use stdClass;
use App\Form\VideoFormType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    private ?EventDispatcherInterface $dispatcher = null;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine, Request $request)
    {
        $entityManager = $doctrine->getManager();
        $videos = $entityManager->getRepository(Video::class)->findAll();
        dump($videos);
        $video = new Video();
        //$video->setTitle("Wrtie a blog post");
        //$video->setCreatedAt(new DateTime("tomorrow"));
        //$video = $entityManager->getRepository(Video::class)->find(1);

        $form = $this->createForm(VideoFormType::class, $video);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView()
        ]);
    }
}
