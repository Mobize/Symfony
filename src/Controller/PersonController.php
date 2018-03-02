<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function dump;


/**
 * Toutes les routes de ce contrôleur sont prefixées par /person
 * @Route("/person")
 */
class PersonController extends Controller
{
    /**
     * Le chemin complet de la route est/person/list
     * @Route("/list")
     */
    public function index()
    {
        //gestionnaire d'entités de Doctrine
        $em = $this->getDoctrine()->getManager();
        //repository de la class Person
        dump(Person::class);
        $personRepository = $em->getRepository(Person::class);
        
        //Le repository permet de requêter la bdd
        //ici un select * from person
        $persons = $personRepository->findAll();
        dump($persons);
        
        return $this->render(
                'person/index.html.twig', 
                [
                    'persons' =>$persons
                ]
        );
    }
    
    /**
     * L'id doit etre un nombre (\d+ en expression régulière)
     * @Route("/{id}", requirements={"id": "\d+"})
     * @param int $id
     */
    public function detail($id){
        
        $em = $this->getDoctrine()->getManager();
        $personRepository = $em->getRepository(Person::class);
        
        //retourn un objet Par sa clé primaire
        //ou null s'il n'y a pas de resultat        
        $person = $personRepository->find($id);
        
        // s'il n'y a pas de personne avec l'id reçu dans l'url
        if (is_null($person)){
            throw new NotFoundHttpException();
        }
        
        return $this->render(
                'person/detail.html.twig',
                [
                    'person' =>$person
                ]
        );
    }
    
    /**
     * @Route("/search")
     */
    public function search(Request $request)
    {
        $person = null;
        
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $personRepository = $em->getRepository(Person::class);
            
            $person = $personRepository->findOneBy([
                'email' => $request->request->get('email')
            ]);
        }
        
        return $this->render(
                'person/search.html.twig',
                [
                    'person' =>$person
                ]
        );        
    }
    
    /**
     * @Route("/search/lastname")
     *      * 
     */
    public function searchByLastname(Request $request)
    {
        $persons = [];
        
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $personRepository = $em->getRepository(Person::class);
            
            $persons = $personRepository->findBy([
                'lastname' => $request->request->get('lastname')
            ]);
        }
        
        return $this->render(
                'person/search_by_lastname.html.twig',
                [
                    'persons' =>$persons
                ]
        );        
    }
}
