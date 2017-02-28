<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Utilisateur;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/tchat")
 */
class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        /* creation d'un user*/
        $user = $this->getUser();
        /*user est connecté*/
        $user->setConnected(true);
        /*appel de l'entity manager */
        $em = $this->getDoctrine()->getManager();
        /*envoie et sauvergarde dans ka base de donnée*/
        $em->persist($user);
        $em->flush();
        /*l'utilisateur est en session via la clef usr , une id est ajouter a la varibale user*/
        $request->getSession()->set("usr", $user->getId());
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/users")
     */
    public function getUsers() {

        return new JsonResponse($this->getDoctrine()->getRepository(Utilisateur::class)->findBy(array("connected" => "1")));
//        return new JsonResponse($this->getDoctrine()->getRepository(Utilisateur::class)->findAll());
    }

    /**
     * @Route("/messages")
     */
    public function getMessages() {

        return new JsonResponse($this->getDoctrine()->getRepository(Message::class)->findAll());
    }

    /**
     * @Route("/message/add")
     * @param Request $r
     */
    public function addMessage(Request $r) {
        $user = $this->getUser();
        $message = new Message();
        $message->setMessage($r->get("msg"));
        $message->setUtilisateur($user);
        $d = new DateTime();
        $d->setTimestamp(time());
        $d->format('Y-m-d H:i:s');
        $message->setHeure($d);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        return new Response("ok");
    }



}
