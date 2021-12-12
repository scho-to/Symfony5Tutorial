<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Events\VideoCreatedEvent;
use stdClass;

class DefaultController extends AbstractController
{
    private ?EventDispatcherInterface $dispatcher = null;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine)
    {
        //$entityManager = $doctrine->getManager();

        $video = new stdClass();
        $video->title = "Funny movie!!";
        $video->category = "funny";

        $event = new VideoCreatedEvent($video);
        $this->dispatcher->dispatch($event, 'video.created.event');

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
