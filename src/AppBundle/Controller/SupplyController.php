<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Supply;
use AppBundle\Form\SupplyType;

/**
 * Supply controller.
 *
 * @Route("/market/supply")
 */
class SupplyController extends Controller {

    /**
     * Lists all Supply entities.
     *
     * @Route("/", name="supply_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $supplys = $em->getRepository('AppBundle:Supply')->findAll();

        return $this->render('supply/index.html.twig', array(
                    'supplys' => $supplys,
        ));
    }

    /**
     * Creates a new Supply entity.
     *
     * @Route("/new", name="supply_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {

        $user = $this->getUser();

        $supply = new Supply();
        $form = $this->createForm('AppBundle\Form\SupplyType', $supply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $supply->setUser($user);
            $demandId = $request->request->get('demand_id');
            $demand = $em->getRepository('AppBundle:Demand')->find($demandId);
            $supply->setDemand($demand);
            $em->persist($supply);
            $this->addFlash(
                    'success_dash', "Votre offre d'approvisionnement a été bien enregistrée!"
            );

            //notification interne de l'action
            if ( $supply->getDemand()->getUser()->getNotificationSupply() ) {
                    $this->sendNotification($this->getUser(), $supply->getDemand()->getUser(), 'BeAgrio - Nouvelle souscription ', 'Une souscription a été effectuée. Cliquez ici : ', $this->generateUrl('dashboard_souscriptionsdemande', array('id' => $supply->getDemand()->getId())), 'supply');
             $this->notifierMessageExterne('contact@beagrio.com', $supply->getDemand()->getUser()->getEmail(), 'BeAgrio - Nouvelle souscription ', 'Cliquez ici '.$this->generateUrl('dashboard_souscriptionsdemande', array('id' => $supply->getDemand()->getId())).' pour voir le détail');
                    
            }
            $em->flush();

            return $this->redirectToRoute('dashboard_souscriptionsviews');
        }

        //return $this->redirectToRoute('demand_index');
    }
    
      private function sendNotification($emetteur, $recepteur, $title, $contenu, $link, $type) {

        //notification interne
        $manager = $this->get('mgilet.notification');
        $notif = $manager->generateNotification($title);
        $notif->setMessage($contenu);
        $notif->setEmetteur($emetteur);

        if ($type == 'offre') {
            $notif->setNotificationVente(true);
        }
        if ($type == 'demand') {
            $notif->setNotificationDemand(true);
        }
        if ($type == 'order') {
            $notif->setNotificationOrder(true);
        }
        if ($type == 'supply') {
            $notif->setNotificationSupply(true);
        }

        $notif->setLink($link);
        $manager->addNotification($recepteur, $notif);

        return;
    }

    private function notifierMessageInterne($recepteur, $title, $contenu, $type) {
        //notification interne
        // Créer le message
        $composer = $this->get('fos_message.composer');
        $message = $composer->newThread()
                ->setSender($this->getUser())
                ->addRecipient($recepteur)
                ->setSubject($title);
//                if($type=='offre'){ $message->setIsoffre(true);}
//                if($type=='demand'){ $message->setIsdemand(true);}
//                if($type=='order'){ $message->setIsorder(true);}
//                if($type=='supply'){ $message->setIssupply(true);}
        $message->setBody($contenu)
                ->getMessage();
        // Envoie le message
        $sender = $this->get('fos_message.sender');
        $sender->send($message);
        return;
    }

    private function notifierMessageExterne($experditeur, $recepteur, $title, $contenu) {

        //notification externe
        //envoi d'email
        $message = \Swift_Message::newInstance()
                ->setSubject($title)
                ->setFrom(array($experditeur => "BeAgrio"))
                ->setTo($recepteur)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->renderView('dashboard/moncompte/sendNotification.html.twig', array('contenu' => $contenu)));
        $this->get('mailer')->send($message);
        //fin d'envoi d'email
    }

}
