<?php

namespace AppBundle\Entity;

/**
 * CourseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * find course by pillar
     *
     * @return Course
     */
    public function findByPillar($pillar, $level, $status) {
        $courses = $this->createQueryBuilder('c')
            ->andWhere('c.pillar = :pillar')
            ->andWhere('c.level = :level')
            ->andWhere('c.status = :status')
            ->setParameter('pillar', $pillar)
            ->setParameter('level', $level)
            ->setParameter('status', $status)
            ->orderBy('c.name ')
            ->getQuery()
            ->getResult();
        return $courses;
    }

    /**
     * find course by status
     *
     * @return Course
     */
    public function findByStatus($status) {
        $courses = $this->createQueryBuilder('c')
          ->andWhere('c.status = :status')
          ->setParameter('status', $status)
          ->orderBy('c.name ')
          ->getQuery()
          ->getResult();
        return $courses;
    }

    /**
     * find all courses
     *
     * @return Course
     */
    public function findAllSorted() {
        $courses = $this->createQueryBuilder('c')
          ->orderBy('c.name')
          ->getQuery()
          ->getResult();
        return $courses;
    }
}
