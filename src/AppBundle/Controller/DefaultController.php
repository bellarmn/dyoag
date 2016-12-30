<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;
use AppBundle\Form\ContactHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @Template()
     * @Cache(smaxage="600", public="true")
     */
    public function indexAction(Request $request) {
        //  Message a envoyer en cas d'erreur
        $msg = '';
        //  Le formulaire

        $form = $this->createForm('AppBundle\Form\ContactType');

        $formHandler = new ContactHandler($form, $request, $this->container);
        //  On exécute le traitement du formulaire. S'il retourne true, alors le formulaire a bien été traité
        if ($formHandler->process()) {
            // On récupère le service translator
            $translator = $this->get('translator');
            $msg = $translator->trans('Message envoyé. Merci !');
        }

        return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
                    'form' => $form->createView(),
                    'msg' => $msg,
             
        ]);
    }
    
    /**
     * @Route("/apropos", name="apropos")
     * @Template()
     * @Cache(smaxage="600", public="true")
     */
    public function aproposAction(Request $request) {
        //  Message a envoyer en cas d'erreur
        
        return $this->render('default/apropos.html.twig');
    }
    
    /**
     * @Route("/conditions", name="conditions")
     * @Template()
     * @Cache(smaxage="600", public="true")
     */
    public function conditionsAction(Request $request) {
        //  Message a envoyer en cas d'erreur
        
        return $this->render('default/conditions.html.twig');
    }

//implementation of Server Sent Event (SSE) with StreamedResponse
    public function notificationAction() {
        $response = new StreamedResponse(function() {
            while (true) {
                $message = "";

                $messagesNotification = $this->get('session')->getFlashBag()->get('message_notification');
                ; // code that search notifications from session
                if (count($messagesNotification) > 0) {
                    foreach ($messagesNotification as $messageNotification) {
                        $message .= "data: " . messageNotification . PHP_EOL;
                    }
                    $message .= PHP_EOL;
                    echo $message;
                    ob_flush();
                    flush();
                }
                $this->get('session')->save();
                sleep(8);
            };
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }

//TODO in Js:
//    var path = '/path';
//    var source = new EventSource(path);
//    source.onmessage = function(e) {
//        // notification html
//    };
//    source.onerror = function(e) {
//        // notification html
//    };
}
