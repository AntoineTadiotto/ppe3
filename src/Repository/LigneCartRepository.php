<?php

namespace App\Repository;

use App\Entity\LigneCart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LigneCart|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCart|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCart[]    findAll()
 * @method LigneCart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCartRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LigneCart::class);
    }

//    /**
//     * @return LigneCart[] Returns an array of LigneCart objects
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
    public function findOneBySomeField($value): ?LigneCart
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
