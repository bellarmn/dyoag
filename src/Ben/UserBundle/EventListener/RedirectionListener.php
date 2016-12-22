<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ben\UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RedirectionListener {

    /**
     * RedirectionListener constructor.
     * @param ContainerInterface $container
     * @param Session $session
     */
    public function __construct(ContainerInterface $container) {
        $this->session = $container->get('session');
        $this->router = $container->get('router');
        $this->security = $container->get('security.token_storage');
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        $list_route = array('order_new', 'vente_show', 'demand_show', 'vente_new', 'demand_new', 'supply_new', 'dashboard_index');
        $route = $request->attributes->get('_route');
        $route_params = $request->attributes->get('_route_params');

        if (in_array($route, $list_route)) {
            $this->setRouteSession($request, $route, $route_params);
        }
//        if ($route == "order_new") {
//            if ($this->session->has('venteId')) {
////                if (count($this->session->get('cart')) == 0) {
////                    $this->session->getFlashBag()->add('info', 'Votre panier étant vide, vous ne pouvez pas continuer le processus d\'achat ');
////                    $event->setResponse(new RedirectResponse($this->router->generate('_cart')));
////                }
//                $event->setResponse(new RedirectResponse($this->router->generate('vente_show', array('id' => $this->session->get('vente_show')))));
//            }
//            if (!is_object($this->security->getToken()->getUser())) {
//                $this->session->getFlashBag()->add('info', 'Vous devez vous identifier');
//                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
//            }
//        }
//        if ($route === "vente_new") {
//            $event->setResponse(new RedirectResponse($this->router->generate('vente_new')));
//        } elseif ($route == "demand_new") {
//            $event->setResponse(new RedirectResponse($this->router->generate('demand_new')));
//        }
//        if (!is_object($this->security->getToken()->getUser())) {
//            $this->session->getFlashBag()->add('info', 'Vous devez vous identifier');
//            $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
//        }
    }

    /**
     * @param $request
     * @param $route
     * @param null $param
     */
    private function setRouteSession($request, $route, $param) {
        $session = $request->getSession();
        $session->set('lastPath', array(
            'route' => $route,
            'params' => $param
        ));
    }

}
