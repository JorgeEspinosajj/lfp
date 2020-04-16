<?php

namespace App\Repository;

use App\Entity\Entrenador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Entrenador|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrenador|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrenador[]    findAll()
 * @method Entrenador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrenadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrenador::class);
    }

    // /**
    //  * @return Entrenador[] Returns an array of Entrenador objects
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
    public function findOneBySomeField($value): ?Entrenador
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
