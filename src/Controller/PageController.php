<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;


class PageController extends AbstractController
{
    public function index(NewsRepository $newsRepository): Response
    {
        $data = simplexml_load_file("http://rss.cnn.com/rss/edition_world.rss");

        if(!empty($data)){
            $rss = $data;
        }

        return $this->render('page/index.html.twig',[
                'news' => $newsRepository->findByDateThree(), 'fluxRss' => $rss
            ]
        );
    }

    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    public function service(): Response
    {
        return $this->render('page/service.html.twig');
    }

    public function single(NewsRepository $newsRepository): Response
    {
        return $this->render('page/single.html.twig',[
            'news' => $newsRepository->findByDate(),
            ]
        );
    }

    public function blog(NewsRepository $newsRepository): Response
    {
        return $this->render('page/blog.html.twig',[
            'news' => $newsRepository->findByDateSix()
            ]);
    }
}
