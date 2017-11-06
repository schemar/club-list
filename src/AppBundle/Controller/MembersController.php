<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MembersController extends Controller
{
    /**
     * @Route("/members", name="members_list")
     * @Template()
     * @return array
     */
    public function membersAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        /** @var User[] $users */
        $users = $userManager->findUsers();

        return [
            'users' => $users
        ];
    }

    /**
     * @Route("/members/{email}", name="member_details")
     * @Template()
     * @param string $email
     * @return array
     */
    public function memberAction($email)
    {
        $userManager = $this->get('fos_user.user_manager');
        /** @var User $user */
        $user = $userManager->findUserByEmail($email);

        return [
            'user' => $user
        ];
    }
}
