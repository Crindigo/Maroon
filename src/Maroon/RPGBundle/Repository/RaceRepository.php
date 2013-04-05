<?php

namespace Maroon\RPGBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Created by IntelliJ IDEA.
 * User: steven
 * Date: 4/3/13
 * Time: 2:01 AM
 * To change this template use File | Settings | File Templates.
 */
class RaceRepository extends EntityRepository
{
    public function findWithGendersAndJobs()
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT r, g, j FROM MaroonRPGBundle:Race r
            JOIN r.selectableGenders g
            JOIN r.selectableJobs j
            ORDER BY r.name ASC
        ');

        return $query->getResult();
    }
}
