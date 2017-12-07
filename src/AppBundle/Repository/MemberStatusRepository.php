<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MemberStatusRepository
 */
class MemberStatusRepository extends EntityRepository
{
    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        if (is_null($orderBy)) {
            $orderBy = ['priority' => 'DESC'];
        }

        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
