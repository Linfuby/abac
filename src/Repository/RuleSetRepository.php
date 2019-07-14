<?php

namespace App\Repository;

use App\Entity\RuleSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RuleSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method RuleSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method RuleSet[]    findAll()
 * @method RuleSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RuleSetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RuleSet::class);
    }

    // /**
    //  * @return RuleSet[] Returns an array of RuleSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RuleSet
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
