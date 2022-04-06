<?php

namespace App\Controller;

use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @var Greeting
     */
    private $greeting;

    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * @Route("/", name="blog_index")
     */
    public function index(Request $request)
    {
       return $this->render(view: 'base.html.twig', [
           'message' => $this->greeting->greet($request->get(key: 'name'))
       ]);
    }
}