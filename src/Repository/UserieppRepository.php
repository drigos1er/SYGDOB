<?php

namespace App\Repository;

use App\Entity\Useriepp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Useriepp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Useriepp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Useriepp[]    findAll()
 * @method Useriepp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserieppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Useriepp::class);
    }

    // /**
    //  * @return Useriepp[] Returns an array of Useriepp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Useriepp
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
