<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ben\UserBundle\Handler;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    private $router;

    public function __construct(ContainerInterface $container) {
        $this->router = $container->get('router');
        $this->security = $container->get('security.authorization_checker');
    }

//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
//        if ($request->isXmlHttpRequest()) {
//            // Handle XHR here
//        } else {
//            // Create a flash message with the authentication error message
//            $request->getSession()->getFlashBag()->set('error', $exception->getMessage());
//            $url = $this->router->generate('user_login');
//
//            return new RedirectResponse($url);
//        }
//    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        $referer = $request->headers->get('referer');
        $request->getSession()->getFlashBag()->set('LoginError', $exception->getMessage());

        return new RedirectResponse($referer);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $session = $request->getSession();
        if (!$session->has('lastPath')) {
            $route = 'dashboard_index';
            return new RedirectResponse($this->router->generate($route));
        } else {
            $route = $session->get('lastPath');
            //var_dump($request->getSession()->get('_security.main.target_path'));
        }

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('easyadmin'));
        } else {
            if ($route['params'] != null) {
                $response = new RedirectResponse($this->router->generate($route['route'], $route['params']));
            } else {
                $response = new RedirectResponse($this->router->generate($route['route']));
            }
        }
        //$session->getFlashBag()->add('success', 'Connexion réussi !');
        return $response;
    }

//    public function onLogoutSuccess(Request $request) {
//        $referer = $request->headers->get('referer');
//        return new RedirectResponse($referer);
//    }
}
