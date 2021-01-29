<?php

namespace App\Repository;

use App\Entity\Appreciations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Appreciations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appreciations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appreciations[]    findAll()
 * @method Appreciations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppreciationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appreciations::class);
    }

    // /**
    //  * @return Appreciations[] Returns an array of Appreciations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appreciations
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
