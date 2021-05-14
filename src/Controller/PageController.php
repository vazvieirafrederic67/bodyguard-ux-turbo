<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    public function contact(): Response
    {
        return $this->render('page/contact.html.twig');
    }

    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    public function guard(): Response
    {
        return $this->render('page/guard.html.twig');
    }

    public function service(): Response
    {
        return $this->render('page/service.html.twig');
    }

    public function single(): Response
    {
        return $this->render('page/single.html.twig');
    }

    public function blog(): Response
    {
        return $this->render('page/blog.html.twig');
    }
}
