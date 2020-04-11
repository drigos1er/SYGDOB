<?php

namespace App\Repository;

use App\Entity\SigesRole;
use App\Entity\SygdobRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SygdobRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method SygdobRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method SygdobRole[]    findAll()
 * @method SygdobRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SygdobRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SygdobRole::class);
    }

    // /**
    //  * @return SigesRole[] Returns an array of SigesRole objects
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
    public function findOneBySomeField($value): ?SigesRole
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
