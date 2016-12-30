<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Commande;
use AppBundle\Form\CommandeType;

/**
 * Commande controller.
 *
 * @Route("/commande")
 */
class CommandeController extends Controller
{
    /**
     * Lists all Commande entities.
     *
     * @Route("/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('AppBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new Commande entity.
     *
     * @Route("/new", name="commande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        //notification interne de l'action
            if ( $commande->getVente()->getUser()->getNotificationOrder() ) {
                    $this->sendNotification($this->getUser(), $commande->getVente()->getUser(), 'BeAgrio - Nouvelle commande ', 'Une nouvelle commande vous a été adressée. Cliquez ici : ', $this->generateUrl('dashboard_commandesviews'), 'order');
             $this->notifierMessageExterne('contact@beagrio.com', $commande->getVente()->getUser()->getEmail(), 'BeAgrio - Nouvelle commande ', 'Cliquez ici '.$this->generateUrl('dashboard_commandesviews').' pour voir le détail');
                    
            }
            
        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commande entity.
     *
     * @Route("/{id}", name="commande_show")
     * @Method("GET")
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Commande entity.
     *
     * @Route("/{id}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Commande entity.
     *
     * @Route("/{id}", name="commande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a Commande entity.
     *
     * @param Commande $commande The Commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
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
