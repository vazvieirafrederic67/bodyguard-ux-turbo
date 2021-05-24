<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="app_sitemap", defaults={"_format":"xml"})
     */
    public function index(Request $request): Response
    {

        $hostname = $request->getSchemeAndHttpHost();

        //Urls statiques
        $urls = [];
        
        $urls[] = ['loc' => $this->generateUrl('app_home')];
        $urls[] = ['loc' => $this->generateUrl('app_contact')];
        $urls[] = ['loc' => $this->generateUrl('app_about')];
        $urls[] = ['loc' => $this->generateUrl('app_service')];
        $urls[] = ['loc' => $this->generateUrl('app_single')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('app_logout')];
        $urls[] = ['loc' => $this->generateUrl('news_index')];
        $urls[] = ['loc' => $this->generateUrl('news_new')];
 

        //Urls dynamiques
        foreach($this->getDoctrine()->getRepository(News::class)->findAll() as $new){
            $urls[] = ['loc' => $this->generateUrl( 'news_show' , [ 'id' => $new->getId()])];
            $urls[] = ['loc' => $this->generateUrl( 'news_edit' , [ 'id' => $new->getId()])];
            $urls[] = ['loc' => $this->generateUrl( 'news_delete' , [ 'id' => $new->getId()])];
        }

        
        $response = new Response(
            $this->renderView('sitemap/index.html.twig',[
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        $response->headers->set( 'Content-type' , 'text/xml' );

        return $response;

    }
}
