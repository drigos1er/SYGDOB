<?php

namespace App\Repository;

use App\Entity\SigesUser;
use App\Entity\SygdobUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SygdobUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SygdobUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SygdobUser[]    findAll()
 * @method SygdobUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SygdobUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SygdobUser::class);
    }

    // /**
    //  * @return SigesUser[] Returns an array of SigesUser objects
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
    public function findOneBySomeField($value): ?SigesUser
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
