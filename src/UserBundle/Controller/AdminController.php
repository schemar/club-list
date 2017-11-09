<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Form\RegisterFormType;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/register", name="admin_register")
     * @Template()
     * @param Request $request
     * @return array|Response
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        /** @var User $user */
        $user = $userManager->createUser();
        $form = $this->createForm(RegisterFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPlainPassword(uniqid());
            $user->setEnabled(true);
            $userManager->updateUser($user);

            $request->request->set('username', $user->getUsername());

            return $this->forward('FOSUserBundle:Resetting:sendEmail', ['request' => $request]);
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
