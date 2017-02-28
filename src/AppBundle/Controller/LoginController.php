<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of LoginController
 *
 * @author loic
 */
class LoginController extends Controller {

    /**
     * @Route("/")
     * @param Request $r
     */
    public function red(Request $r){
        return $this->redirectToRoute("homepage");
    }
    
    
    /**
     * @Route("/login")
     */
    public function loginAction(){
         return $this->render('default/login.html.twig');
    }
    
    /**
     * @Route("/login_check",name="log")
     * @param \AppBundle\Controller\Request $r
     */
    public function loginCheck(Request $r){
        
    }
    
    
    /**
     * @Route("/logout")
     */
    public function logout(Request $r) {
        return new Response("", 401);
    }
    
/**
     * Fonction qui permettre de déconnecter l'utilisateur  en base de données
     * A la fin du traitement on est rediriger la page d'accueil
     * @Route("/disconnect/{id}")
     */
    public function disconnect(Request $r,$id){
        /* J'initialise ma variable Entity Manager */
        $em = $this->getDoctrine()->getManager();
        /*Creaction d'une classe id*/
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        /*Utilisateur est sur false donc déconnecter*/
        $user->setConnected(false);
        /* enrengistrement et envoie à la base de donnée*/
        $em->persist($user);
        $em->flush();
        /*Redirection sur la route "homepage"*/
        return $this->redirectToRoute("homepage");
    }
}
