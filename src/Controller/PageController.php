<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\SendMailService;
use Symfony\Component\Form\Forms;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\Stream\TurboStreamResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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

    public function contact(SendMailService $mailService, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $blankForm = clone $form;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $contactName = $form->get('name')->getData();


            if (TurboStreamResponse::STREAM_FORMAT === $request->getPreferredFormat()) {
                
                $formSend = $form->getData();
                $mailService->sendMailContact($contact);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();
                
                return $this->render('contact/_success_contact_form.stream.html.twig', [
                    'contactName' => $contactName,
                    'form' => $blankForm->createView(),
                ], new TurboStreamResponse());
            }

            $formSend = $form->getData();
            $mailService->sendMailContact($contact);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
           
            $this->addFlash('success', $formSend->getFirstname().', your message has been sent!');

            return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);

        }

        if ($form->isSubmitted() && !$form->isValid()) {

            $content = $this->renderView('pages/contact.html.twig',[
                'form' => $form->createView(), 
            ]);

            return new Response($content, Response::HTTP_UNPROCESSABLE_ENTITY);
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
