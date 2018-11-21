<?php

namespace App\Repository;

use App\Entity\LivraisonOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LivraisonOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivraisonOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivraisonOrder[]    findAll()
 * @method LivraisonOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivraisonOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LivraisonOrder::class);
    }

//    /**
//     * @return LivraisonOrder[] Returns an array of LivraisonOrder objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivraisonOrder
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
