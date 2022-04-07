<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/{name}", name="index")
     */
    public function index($name)
    {
       return $this->render('blog/index.html.twig', [
           'posts' => $this->session->get('posts')
       ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add()
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'A Random Title '. rand(1, 500),
            'text' => 'Some random text number : '. rand(1, 500)
        ];
        $this->session->set('posts', $posts);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');

        if(!$posts || !isset($posts[$id]))
        {
            throw new NotFoundHttpException('Post not found');
        }
        
        $this->render('blog/post.html.twig', [
            'id' => $id,
            'post' => $posts[$id]
        ]);
    }
}