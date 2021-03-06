<?php

namespace AppBundle\Entity;

/**
 * FacultyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacultyRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Find faculty
     *
     * @return Faculty
     */
    public function findAllSorted()
    {
        $faculty = $this->createQueryBuilder('f')
          ->addOrderBy('f.lastname')
          ->getQuery()
          ->getResult();
        return $faculty;
    }
}
