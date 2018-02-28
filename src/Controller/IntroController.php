<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntroController extends Controller
{
    /**
     * @Route("/intro", name="intro")
     */
    public function index()
    {
        return $this->render('intro/index.html.twig', [
            'controller_name' => 'IntroController',
        ]);
    }
    
    /**
     * @Route("/test")
     */
    public function test()
    {
        return new Response('test');
    }
    
    /**
     * @Route("/")
     */
    public function indexBis()
    {
        return $this->render('intro/index.html.twig', [
            'controller_name' => 'My Controller',
        ]);
    }
    
    /**
     * @Route("/hello/{name}")
     */
    public function hello($name)
    {
        return $this->render(
                'intro/hello.html.twig',
                [
                    'nom' => $name
                ]
            );
                
    }
    
    /**
     * La route contient 2 parametres dont 1 optionnel
     * @Route("/hi/{firstname}-{lastname}",defaults={"lastname":""})
     */
    public function hi($firstname,$lastname)
    {
        $name = $firstname;
        
        if (!empty($lastname)){
            $name .= " $lastname";
        }
        
        return $this->render(
                'intro/hello.html.twig',
                [
                    'nom' => $name
                ]
            );
                
    }
    
    /**
     * @Route("/twig")
     */
    public function twig()
    {
        return $this->render(
                'intro/twig.html.twig'
                );
    }
}
