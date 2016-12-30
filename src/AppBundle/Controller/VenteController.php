<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Vente;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;

/**
 * Vente controller.
 *
 * @Route("/market/sale")
 */
class VenteController extends Controller {

    /**
     * Lists all Vente entities.
     *
     * @Route("/", name="vente_index")
     * @Method("GET")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $filter = array();
        $form = $this->createForm('AppBundle\Form\FilterType', $filter);
        $form->handleRequest($request);
        $dql = "SELECT v FROM AppBundle:Vente v  WHERE v.published = 1 ORDER BY v.createAt DESC";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, //
                $request->query->getInt('page', 1), // page number
                $this->getParameter('max_data_per_page')// limit per page
        );
        return $this->render('vente/index.html.twig', array(
                    'pagination' => $pagination,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Vente entity.
     *
     * @Route("/new", name="vente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $vente = new Vente();
        $form = $this->createForm('AppBundle\Form\VenteType', $vente);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            //check if the submit is draft or publish
            if (null !== $request->request->get('publish')) {
                $vente->setPublished(true);
            }
            $em = $this->getDoctrine()->getManager();
            if (null === $vente->getImageName()) {
                $vente->setImageName($vente->getProduct()->getImageName());
            }
            $vente->setUser($user);
            $em->persist($vente);
            $em->flush();
            $this->addFlash(
                    'success', "Votre offre de produit a été bien enregistré!"
            );
           //notification interne de l'action
            $users = $em->getRepository('AppBundle\Entity\User\User')
                     ->findBy(array('enabled' => true, 'notificationVente' => true));
            foreach ($users as $user) {
                    $this->sendNotification($this->getUser(), $user, 'BeAgrio - Nouvelle Publication d\'offre ', 'Une offre a été Publiée. ', $this->generateUrl('vente_show', array('id' => $vente->getId())), 'offre');
                    $this->notifierMessageExterne('contact@beagrio.com', $user->getEmail(), 'BeAgrio - Nouvelle Publication d\'offre ', 'Cliquez ici '.$this->generateUrl('vente_show', array('id' => $vente->getId())).' pour voir le détail');
                    
            }
            return $this->redirectToRoute('market_index');
        }

        return $this->render('vente/new.html.twig', array(
                    'vente' => $vente,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Order entity.
     *
     * @Route("/order/new/", name="order_new")
     * @Method({"POST"})
     */
    public function newOrderAction(Request $request) {
        $user = $this->getUser();

        $username = $user->getUsername();
        $email = $user->getEmail();

        $commande = new Order();
        $form = $this->createForm('AppBundle\Form\OrderType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commande->setUser($user);
            $venteId = $request->request->get('vente_id');
            $vente = $em->getRepository('AppBundle:Vente')->find($venteId);
            $commande->setVente($vente);
            $em->persist($commande);
            $em->flush();
            $this->addFlash(
                    'success_dash', "Votre commande a été bien enregistrée!"
            );
            
            //notification interne de l'action
            if ( $commande->getVente()->getUser()->getNotificationOrder() ) {
                    $this->sendNotification($this->getUser(), $commande->getVente()->getUser(), 'BeAgrio - Nouvelle commande ', 'Un client a envoyé une nouvelle commande. Cliquez ici : ', $this->generateUrl('dashboard_commandesviews'), 'order');
             $this->notifierMessageExterne('contact@beagrio.com', $commande->getVente()->getUser()->getEmail(), 'BeAgrio - Nouvelle commande ', 'Cliquez ici '.$this->generateUrl('dashboard_commandesviews').' pour voir le détail');
                    
            }
            return $this->redirectToRoute('dashboard_commandesviews');
        }

        return $this->redirectToRoute('market_index');
    }

    /**
     * Finds and displays a Vente entity.
     *
     * @Route("/{id}", name="vente_show")
     * @Method("GET")
     */
    public function showAction(Vente $vente) {
        $commande = new Order();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\OrderType', $commande);
        $relativeVentes = $em->getRepository('AppBundle:Vente')->getVentesByProductId($vente->getProduct()->getId());
        return $this->render('vente/show.html.twig', array(
                    'vente' => $vente,
                    'relativeVentes' => $relativeVentes,
                    'form' => $form->createView(),
                  ));
    }

    /**
     * Displays a form to edit an existing Vente entity.
     *
     * @Route("/{id}/edit", name="vente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vente $vente) {
        $deleteForm = $this->createDeleteForm($vente);
        $editForm = $this->createForm('AppBundle\Form\VenteType', $vente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute('vente_edit', array('id' => $vente->getId()));
        }

        return $this->render('vente/edit.html.twig', array(
                    'vente' => $vente,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vente entity.
     *
     * @Route("/{id}/recap", name="vente_edit")
     * @Method({"GET", "POST"})
     */
    public function recapitulationAction(Request $request, Vente $vente) {
        $deleteForm = $this->createDeleteForm($vente);
        $editForm = $this->createForm('AppBundle\Form\VenteRecapType', $vente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute('vente_show', array('id' => $vente->getId()));
        }

        return $this->render('vente/recapitulation.html.twig', array(
                    'vente' => $vente,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Vente entity.
     *
     * @Route("/{id}", name="vente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vente $vente) {
        $form = $this->createDeleteForm($vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vente);
            $em->flush();
        }

        return $this->redirectToRoute('vente_index');
    }

    /**
     * Creates a form to delete a Vente entity.
     *
     * @param Vente $vente The Vente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vente $vente) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vente_delete', array('id' => $vente->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * @Route("/select/mesures", name="vente_select_measures")
     */
    public function measuresAction(Request $request) {
        $product_id = $request->request->get('product_id');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->getMeasures($product_id);
        return new JsonResponse($product);
    }

    /**
     * Search a Vente entity.
     *
     * @Route("/search", name="vente_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $query = $request->get('query');

        if (!$query) {
            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($this->generateUrl('market_index'));
            } else {
                return new JsonResponse('No results.');
            }
        }

        $ventes = $em->getRepository('AppBundle:Vente')->getForLuceneQuery($query);
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $ventes, //
                $request->query->getInt('page', 1), // page number
                $this->getParameter('max_data_per_page')// limit per page
        );

        if ($request->isXmlHttpRequest()) {
            if ('*' == $query || !$ventes || $query == '') {
                return new JsonResponse('No results.');
            }
            return $this->render('vente/searchAjax.html.twig', array(
                        'pagination' => $pagination,
                        'categories' => $categories
            ));
        }

        return $this->render('vente/search.html.twig', array(
                    'pagination' => $pagination,
                    'categories' => $categories
        ));
    }

    /**
     * Filter by (Category)
     *
     * @Route("/filter", name="vente_filter")
     * @Method("POST")
     */
    public function filterAction(Request $request) {
        $filter = $request->request->get('filter');
        $em = $this->getDoctrine()->getManager();
        $ventes = $em->getRepository('AppBundle:Vente')->getOffresByCategory($filter);

        if (!$ventes) {
            return new JsonResponse('No results.');
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $ventes, //
                $request->query->getInt('page', 1), // page number
                $this->getParameter('max_data_per_page')// limit per page
        );

        return $this->render('vente/searchAjax.html.twig', array(
                    'pagination' => $pagination
        ));
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
