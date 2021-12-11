<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $cache = new TagAwareAdapter(
            new FilesystemAdapter()
        );

        $acer = $cache->getItem("acer");
        $dell = $cache->getItem("dell");
        $ibm = $cache->getItem("ibm");
        $apple = $cache->getItem("apple");

        if(!$acer->isHit())
        {
            $acer_from_db = "acer laptop";
            $acer->set($acer_from_db);
            $acer->tag(["computers", "laptops", "acer"]);
            $cache->save($acer);
            dump("acer laptop from database ...");
        }
        if(!$dell->isHit())
        {
            $dell_from_db = "acer laptop";
            $dell->set($dell_from_db);
            $dell->tag(["computers", "laptops", "dell"]);
            $cache->save($dell);
            dump("dell laptop from database ...");
        }
        if(!$ibm->isHit())
        {
            $ibm_from_db = "ibm desktop";
            $ibm->set($ibm_from_db);
            $ibm->tag(["computers", "desktops", "ibm"]);
            $cache->save($ibm);
            dump("ibm desktop from database ...");
        }
        if(!$apple->isHit())
        {
            $apple_from_db = "apple desktop";
            $apple->set($apple_from_db);
            $apple->tag(["computers", "desktops", "apple"]);
            $cache->save($apple);
            dump("apple desktop from database ...");
        }

        //$cache->invalidateTags(["ibm"]);
        //$cache->invalidateTags(["desktops"]);
        //$cache->invalidateTags(["laptops"]);
        $cache->invalidateTags(["computers"]);

        dump($acer->get());
        dump($dell->get());
        dump($ibm->get());
        dump($apple->get());

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }
}
