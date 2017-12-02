<?php

namespace UserBundle\Repository;

use AppBundle\Entity\MemberStatus;
use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * @param MemberStatus[] $memberStatuses
     * @return User[]
     */
    public function findByMemberStatuses(array $memberStatuses)
    {
        return $this->createQueryBuilder('user')
            ->innerJoin('user.memberStatuses', 'memberStatuses')
            ->where('memberStatuses IN (:memberStatuses)')
            ->setParameter('memberStatuses', $memberStatuses)
            ->getQuery()
            ->getResult();
    }
}
