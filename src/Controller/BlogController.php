<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/", name="index")
     */
    public function index()
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
            'title' => 'Some Random Title '. rand(1, 500),
            'text' => 'Some random text number : '. rand(1, 500),
            'date' => new DateTime()
        ];
        $this->session->set('posts', $posts);

        return new RedirectResponse($this->generateUrl('blog_index'));
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
        
        return $this->render('blog/post.html.twig', [
            'id' => $id,
            'post' => $posts[$id]
        ]);
    }
}