<?php

namespace AppBundle\Entity;

/**
 * StatusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StatusRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * find status by status name
     *
     * @return Status
     */
    public function findByName($name) {
        $status = $this->createQueryBuilder('s')
            ->andWhere('s.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleResult();
        return $status;
    }

}
