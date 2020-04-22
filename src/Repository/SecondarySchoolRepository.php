<?php

namespace App\Repository;

use App\Entity\SecondarySchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecondarySchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondarySchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecondarySchool[]    findAll()
 * @method SecondarySchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecondarySchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondarySchool::class);
    }

    // /**
    //  * @return SecondarySchool[] Returns an array of SecondarySchool objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecondarySchool
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
