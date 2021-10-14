<?php

namespace App\Repository;

use App\Entity\PauseTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PauseTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method PauseTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method PauseTime[]    findAll()
 * @method PauseTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PauseTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PauseTime::class);
    }

    // /**
    //  * @return PauseTime[] Returns an array of PauseTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PauseTime
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
