<?php

namespace App\Repository;

use App\Entity\Drenddn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Drenddn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drenddn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drenddn[]    findAll()
 * @method Drenddn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrenddnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drenddn::class);
    }

    // /**
    //  * @return Drenddn[] Returns an array of Drenddn objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Drenddn
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
