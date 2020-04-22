<?php

namespace App\Repository;

use App\Entity\SocialConditions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocialConditions|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialConditions|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialConditions[]    findAll()
 * @method SocialConditions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialConditionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialConditions::class);
    }

    // /**
    //  * @return SocialConditions[] Returns an array of SocialConditions objects
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
    public function findOneBySomeField($value): ?SocialConditions
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
