<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Supply controller.
 *
 * @Route("/market")
 */
class MarketController extends Controller {

    /**
     * Lists all Supply entities.
     *
     * @Route("/", name="market_index")
     * @Method("GET")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $filter = array();
        $form = $this->createForm('AppBundle\Form\FilterType', $filter);
        $form->handleRequest($request);
        return $this->render('market/index.html.twig', array(
                    'form' => $form->createView(),
            
        ));
    }

    /**
     * @Route("/list", name="market_list")
     * @Method("GET")
     */
    public function listAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException('You can access this only using Ajax!');
        }
        $type = $request->query->get('type');
        //$type = $request->request->get('type');
        $em = $this->getDoctrine()->getManager();
        if ($type == 'demand') {
            $dqlDemand = "SELECT d FROM AppBundle:Demand d WHERE d.published = 1 ORDER BY d.createAt DESC";
            $query = $em->createQuery($dqlDemand);
        } else {
            $dqlVente = "SELECT v FROM AppBundle:Vente v WHERE v.published = 1 ORDER BY v.createAt DESC";
            $query = $em->createQuery($dqlVente);
        }
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
                $query, // query NOT result
                $request->query->getInt('page', 1), //page number
                $this->getParameter('max_data_per_page') // limit per page
        );
        return $this->render($type . '/list.html.twig', array(
                    'pagination' => $pagination,
        ));
    }

    /**
     * @Route("/list/filter", name="market_list_lister")
     * @Method("GET")
     */
    public function filterAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException('You can access this only using Ajax!');
        }
        $type = $request->query->get('type');
        $key1 = $request->query->get('key1');
        $value1 = $request->query->get('value1');
        $key2 = $request->query->get('key2');
        $value2 = $request->query->get('value2');
        $em = $this->getDoctrine()->getManager();
        if ($type == 'demand') {
            if ($value2 && !$value1)
                $query = $em->getRepository('AppBundle:Demand')->getDemandsByProductId($value2);
            elseif ($value1 && !$value2)
                $query = $em->getRepository('AppBundle:Demand')->getDemandsByCityId($value1, $value2);
            elseif ($value1 && $value2)
                $query = $em->getRepository('AppBundle:Demand')->getDemandsByCityProductId($value1, $value2);
            else {
                $dql = "SELECT d FROM AppBundle:Demand d WHERE d.published = 1 ORDER BY d.createAt DESC";
                $query = $em->createQuery($dql);
            }
        } else {
            if ($value2 && !$value1)
                $query = $em->getRepository('AppBundle:Vente')->getVentesByProductId($value2);
            elseif ($value1 && !$value2)
                $query = $em->getRepository('AppBundle:Vente')->getVentesByCityId($value1, $value2);
            elseif ($value1 && $value2)
                $query = $em->getRepository('AppBundle:Vente')->getVentesByCityProductId($value1, $value2);
            else {
                $dql = "SELECT v FROM AppBundle:Vente v WHERE v.published = 1 ORDER BY v.createAt DESC";
                $query = $em->createQuery($dql);
            }
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, // query NOT result
                $request->query->getInt('page', 1), //page number
                $this->getParameter('max_data_per_page') // limit per page
        );
        return $this->render($type . '/list.html.twig', array(
                    'pagination' => $pagination,
        ));
    }

}
