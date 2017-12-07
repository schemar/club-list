<?php

namespace AppBundle\Controller;

use AppBundle\Form\MemberStatusSelectionFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;

/**
 * @Route("/members")
 */
class MembersController extends Controller
{
    /**
     * @Route("", name="members_list")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function membersAction(Request $request)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->get('user.repository.user');

        $form = $this->createForm(MemberStatusSelectionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            /** @var ArrayCollection $memberStatuses */
            $memberStatuses = $data['memberStatuses'];

            if ($memberStatuses->count()) {
                $users = $userRepository->findByMemberStatuses($memberStatuses->toArray());
            } else {
                /** @var User[] $users */
                $users = $userRepository->findAll();
            }
        } else {
            /** @var User[] $users */
            $users = $userRepository->findAll();
        }

        return [
            'users' => $users,
            'member_statuses_form' => $form->createView(),
        ];
    }

    /**
     * @Route("/{email}", name="member_details")
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
