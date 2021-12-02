<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Services\GiftsService;

class DefaultController extends AbstractController
{

    // public function __construct(GiftsService $gifts) {
    //     $gifts->gifts = ['a', 'b', 'c', 'd'];
    // }

    #[Route('/', name: 'default')]
    public function index(GiftsService $gifts): Response
    {
        //$users = ['Adam', 'Robert', 'John', 'Susan'];
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        
        $this->addFlash(
           'notice',
           'Your changes were saved!'
        );
        $this->addFlash(
            'warning',
            'Your changes were saved!'
         );
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'random_gift' => $gifts->gifts
        ]);
    }

    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */
    public function index2(): Response
    {
        return new Response("Optional parameters in url and requirements for parameters");
    }

    /**
     * @Route(
     *  "/articles/{_locale}/{year}/{slug}/{category}", 
     *  defaults={"category": "computers"},
     *  requirements={
     *      "_locale"="en|fr|de",
     *      "category"="computers|rtv",
     *      "year"="\d+"
     *  },
     *  name="articles"
     * )
     */
    public function index3(): Response
    {
        return new Response("an advanced route example");
    }

    /**
     * @Route({
     *      "nl": "/over-ons",
     *      "en": "/about-us"
     * }, name="about_us")
     */
    public function index4(): Response
    {
        return new Response("language Paths");
    }
}
