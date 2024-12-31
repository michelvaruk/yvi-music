<?php

namespace App\Repository;

use App\Entity\Calendar;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calendar>
 */
class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendar::class);
    }

    /**
    * @return Calendar[] Returns an array of Calendar objects
    */
    public function findFuture(?int $max = 50): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date > :val')
            ->andWhere('c.active = 1')
            ->setParameter('val', new DateTime('now'))
            ->orderBy('c.date', 'ASC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }

        /**
    * @return Calendar[] Returns an array of Calendar objects
    */
    public function findFutureByProject(int $project): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date > :val')
            ->andWhere('c.active = 1')
            ->andWhere('c.project = :p')
            ->setParameter('val', new DateTime('now'))
            ->setParameter('p', $project)
            ->orderBy('c.date', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Calendar
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
