<?php

namespace App\Repository;

use App\Entity\Iepp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Iepp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iepp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iepp[]    findAll()
 * @method Iepp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IeppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iepp::class);
    }

    // /**
    //  * @return Iepp[] Returns an array of Iepp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Iepp
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */




    public function searchiepp($dren,$data, $page = 0, $max = NULL, $getResult = true)
    {
        $qb = $this->_em->createQueryBuilder();
        $query = isset($data['query']) && $data['query']?$data['query']:null;

        $qb
            ->select('i')
            ->from('App\Entity\Iepp', 'i')
            ->where("i.drenddn=:drenddn ")


            ->setParameter('drenddn', $dren)





        ;

        if ($query) {
            $qb
                ->andWhere('i.id like :query')
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
