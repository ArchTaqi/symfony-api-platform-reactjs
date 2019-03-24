<?php

namespace App\Repository;

use App\Entity\BadWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BadWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method BadWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method BadWord[]    findAll()
 * @method BadWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BadWordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BadWord::class);
    }

    // /**
    //  * @return BadWord[] Returns an array of BadWord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BadWord
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
