<?php

namespace AppBundle\Controller;

use AppBundle\Form\MemberStatusSelectionFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

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
        $form = $this->getForm($request);
        $query = $this->getQuery($form);
        $pagination = $this->getPagination($request, $query);

        return [
            'pagination' => $pagination,
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

    /**
     * @param Request $request
     * @return Form
     */
    private function getForm(Request $request)
    {
        $form = $this->createForm(
            MemberStatusSelectionFormType::class,
            null,
            [
                'method' => 'GET',
            ]
        );
        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param Form $form
     * @return QueryBuilder
     */
    private function getQuery(Form $form)
    {
        $query = $this->get('doctrine.orm.entity_manager')
            ->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user');

        if ($form->isSubmitted()) {
            $data = $form->getData();
            /** @var ArrayCollection $memberStatuses */
            $memberStatuses = $data['memberStatuses'];

            if ($memberStatuses->count()) {
                $query->innerJoin('user.memberStatuses', 'memberStatuses')
                    ->where('memberStatuses IN (:memberStatuses)')
                    ->setParameter('memberStatuses', $memberStatuses->toArray());
            }
        }

        return $query;
    }

    /**
     * @param Request $request
     * @param QueryBuilder $query
     * @return PaginationInterface
     */
    private function getPagination(Request $request, QueryBuilder $query)
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            15
        );

        return $pagination;
    }
}
