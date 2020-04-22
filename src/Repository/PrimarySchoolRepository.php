<?php

namespace App\Repository;

use App\Entity\PrimarySchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrimarySchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrimarySchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrimarySchool[]    findAll()
 * @method PrimarySchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimarySchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrimarySchool::class);
    }

    // /**
    //  * @return PrimarySchool[] Returns an array of PrimarySchool objects
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
    public function findOneBySomeField($value): ?PrimarySchool
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
