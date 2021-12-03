<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Services\GiftsService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    public function __construct($logger) {
        //use $logger defined in services.yaml in config folder
    }

    #[Route('/', name: 'default')]
    public function index(GiftsService $gifts, ManagerRegistry $doctrine): Response
    {
        //$users = ['Adam', 'Robert', 'John', 'Susan'];
        $manager = $doctrine->getManager();
        $users = $manager->getRepository(User::class)->findAll();
        
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

    /**
     * @Route("/generate-url/{param?}", name="generate_route")
     */
    public function generate_url($param=10): Response
    {
        exit($this->generateUrl(
            'generate_route',
            array('param' => $param),
            UrlGeneratorInterface::ABSOLUTE_URL
        ));
    }

    /**
     * @Route("/download", name="dwnld")
     */
    public function download(): Response
    {
        $path = $this->getParameter('download_directory');
        return $this->file($path.'test.txt');
    }

    /**
     * @Route("/redirect-test", name="red-test")
     */
    public function redirect_test(): Response
    {
        return $this->redirectToRoute('generate_route', array('param' => 221));
    }
}
