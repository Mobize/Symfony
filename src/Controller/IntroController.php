<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
                'intro/twig.html.twig',
                [
                    'now' => new \DateTime()
                ]
        );
    }
    
    /**
     * @Route("/request")
     * 
     * @param Request $request
     * @return Response
     */
    public function request(Request $request)
    {
     //$_GET['test'], null si $_GET['test'] n'existe pas 
        dump($request->query->get('test'));
        
        // valeur par défaut si $_GET['test'] n'existe pas
        dump($request->query->get('test','valeur par défaut'));
        
        //$_GET
        dump($request->query->all());
        
        //GET ou POST
        dump($request->getmethod());
        
        // si un formulaire en POST à été envoyé
        if($request->isMethod('POST')){
            
            //$_POST['test']
            dump($request->request->get('test'));
            
            //$_POST
            dump($request->request->all());
        }
        
        return $this->render('intro/request.html.twig');
    }
    
    /**
     * @Route("/response")
     * @param Request $request
     */
    public function response(Request $request)
    {
        if ($request->query->get('found') == 'no'){
            //pour renvoyer une 404
            throw new NotFoundHttpException();
        }
        
        if ($request->query->get('redirect') == 'intro'){
            //redirection vers la route dont le nom est intro
            return $this->redirectToRoute('intro');
        }
        
        //if isset() en php
        if ($request->query->has('name')){
            $name = $request->query->get('name');
            // redirection vers IntroController::hello
            return $this->redirectToRoute(
                    'app_intro_hello',
                    [
                        'name' => $name
                    ]
            );
        }
    }
    
    /**
     * @Route("/session")
     * @param Request $request
     */
    public function session(Request $request)
    {
        $session = $request->getSession();
        
        //S_SESSION['foo'] = 'FOO';
        $session->set('foo','FOO');
        $session->set('bar','BAR');
        
        dump($session->get('foo'));
        
        //supprime un élément de la session
        //unset($_SESSION['bar']);
        $session->remove('bar');
        
        if ($request->query->get('redirect') == 'flash'){
            //ajoute un message flash de type success
            $session->getFlashBag()->add('success','Message de confirmation');
            
            return $this->redirectToRoute('app_intro_flash');
        }
        
        return $this->render('intro/session.html.twig');
    }
    
    /**
     * @Route("/flash")
     */
    public function flash()
    {//http://127.0.0.1:8000/session?redirect=flash
        return $this->render('intro/flash.html.twig');
    }
}
