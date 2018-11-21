<?php

namespace App\Repository;

use App\Entity\ModeLivraison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModeLivraison|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeLivraison|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeLivraison[]    findAll()
 * @method ModeLivraison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeLivraisonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModeLivraison::class);
    }

//    /**
//     * @return ModeLivraison[] Returns an array of ModeLivraison objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeLivraison
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
