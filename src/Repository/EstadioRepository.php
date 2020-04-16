<?php

namespace App\Repository;

use App\Entity\Estadio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Estadio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estadio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estadio[]    findAll()
 * @method Estadio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estadio::class);
    }

    // /**
    //  * @return Estadio[] Returns an array of Estadio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estadio
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
