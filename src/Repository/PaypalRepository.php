<?php

namespace App\Repository;

use App\Entity\Paypal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Paypal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paypal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paypal[]    findAll()
 * @method Paypal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaypalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Paypal::class);
    }

//    /**
//     * @return Paypal[] Returns an array of Paypal objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paypal
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
