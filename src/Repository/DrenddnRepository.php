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






    public function searchdren($data, $page = 0, $max = NULL, $getResult = true)
    {
        $qb = $this->_em->createQueryBuilder();
        $query = isset($data['query']) && $data['query']?$data['query']:null;

        $qb
            ->select('d')
            ->from('App\Entity\Drenddn', 'd')









        ;

        if ($query) {
            $qb
                ->andWhere('d.id like :query')
                ->setParameter('query', "%".$query."%")
            ;
        }

        if ($max) {
            $preparedQuery = $qb->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max)
            ;
        } else {
            $preparedQuery = $qb->getQuery();
        }

        return $getResult?$preparedQuery->getResult():$preparedQuery;
    }




}
