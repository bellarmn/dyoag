<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ben\UserBundle\Form\Type\ProfileFormType;
use Ben\UserBundle\Form\Type\ProfileProFormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Mgilet\NotificationBundle\Model\AbstractNotification;
use Mgilet\NotificationBundle\Model\UserNotificationInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * moncompte controller.
 *
 * @Route("/dashboard")
 */
class MoncompteController extends Controller {

    /**
     * @Route("/moncompte", name="dasboard_moncompteindex")
     * @Template()
     * @Cache(smaxage="600", public="true")
     */
    public function indexAction(Request $request) {
        return $this->render('dashboard/moncompte/index.html.twig');
    }

    /**
     * Displays a form to edit an existing user entity.
     * @Route("/moncompte/profile", name="dasboard_moncompte_profile")
     * @Template()
     * @Cache(smaxage="600", public="true")
     *
     * @Route("/{id}/edit", name="vente_edit")
     * @Method({"GET", "POST"})
     */
    public function profileAction(Request $request) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $formType = $this->getFormType($user->getProfil());
        $form = $this->get('form.factory')->create($formType, $user, [
            "method" => "post",
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager->updateUser($user);
        }
        return $this->render('dashboard/moncompte/profile.html.twig', array(
                    'form' => $form->createView(),
            'notifications' => $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationDemand' => true), array( 'date' => 'DESC'))
        ));
    }

    private function getFormType($user_profile) {
        switch ($user_profile) {
            case 'Professionnel':
                return ProfileProFormType::class;
            default:
                return ProfileFormType::class;
        }
    }

    /**
     * @Route("/moncompte/setting", name="dasboard_moncompte_setting")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function settingAction(Request $request) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
//        $userManager = $this->get('fos_user.user_manager');
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createFormBuilder($user)
                ->add('notificationVente', CheckboxType::class, array('required' => false,))
                ->add('notificationDemand', CheckboxType::class, array('required' => false,))
                ->add('notificationSupply', CheckboxType::class, array('required' => false,))
                ->add('notificationOrder', CheckboxType::class, array('required' => false,))
                ->getForm();

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            // }
        }

        return $this->render('dashboard/moncompte/setting.html.twig', array(
                    'form' => $form->createView(),
            'notifications' => $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationDemand' => true), array( 'date' => 'DESC'))
        ));
    }

    /**
     * List of all notifications
     *
     * @Route("/notification/notifications_list", name="notifications_list_dash")
     * @Method("GET")
     * @throws \LogicException
     */
    public function listAction()
    {
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' => $this->get('mgilet.notification')->getUserNotifications($this->getUser())
        ));
        
//        return $this->render('MgiletNotificationBundle::notifications.html.twig', array(
//            'notifications' => $this->get('mgilet.notification')->getUserNotifications($this->getUser())
//        ));
    }

    /**
     * Set a Notification as seen
     *
     * @Route("moncompte/{notification}/mark_as_seen", name="notification_markAsSeen")
     * @Method("GET")
     * @param AbstractNotification $notification
     * @return JsonResponse
     * @throws \LogicException
     */
    public function markAsSeenAction($notification)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $notification = $this->get('mgilet.notification')->getNotificationById($notification);
        $notification->setSeen(true);
        $em->persist($notification);
        $em->flush();
         return $this->redirect($notification->getLink());
//        return new JsonResponse(true);
        
    }

    /**
     * Set all Notifications for a User as seen
     *
     * @Route("moncompte/markAllAsSeen", name="notification_markAllAsSeen_dash")
     * @Method("GET")
     * @throws \LogicException
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationException
     */
    public function markAllAsSeenAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserNotificationInterface) {
            throw new AuthenticationException('This user does not have access to this section.');
        }
        $notifications = $this->get('mgilet.notification')->getUnseenUserNotifications($user);
        foreach ($notifications as $notification) {
            $notification->setSeen(true);
            $em->persist($notification);
        }
        $em->flush();
        
        return $this->redirectToRoute('dasboard_moncompte_notifications');
    }

    /**
     * @Route("/moncompte/notifications", name="dasboard_moncompte_notifications")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function notificationsAction(Request $request) {
        
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' =>  $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser()), array( 'date' => 'DESC'))
        ));
        
    }

    /**
     * @Route("/moncompte/notificationsoffre", name="dasboard_moncompte_notificationsoffre")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function notificationsoffreAction(Request $request) {
        
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' => $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationVente' => true), array( 'date' => 'DESC')))
                );
        
    }

    /**
     * @Route("/moncompte/notificationsdemand", name="dasboard_moncompte_notificationsdemand")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function notificationsdemandAction(Request $request) {
        
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' => $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationDemand' => true), array( 'date' => 'DESC')))
                );
        
    }

    /**
     * @Route("/moncompte/notificationssupply", name="dasboard_moncompte_notificationssupply")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function notificationssupplyAction(Request $request) {
        
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' =>  $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationSupply' => true), array( 'date' => 'DESC')))
                );
        
    }

    /**
     * @Route("/moncompte/notificationsorder", name="dasboard_moncompte_notificationsorder")
     * @Template()
     * @Cache(smaxage="600", public="true")
     * @Method({"GET", "POST"})
     */
    public function notificationsorderAction(Request $request) {
        
        return $this->render('dashboard/moncompte/notification.html.twig'
         , array(
            'notifications' => $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Notification')
                ->findBy(array('user' => $this->getUser(), 'notificationOrder' => true), array( 'date' => 'DESC')))
                );
        
    }

}
