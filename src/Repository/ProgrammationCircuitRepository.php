<?php

namespace App\Repository;

use App\Entity\ProgrammationCircuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgrammationCircuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgrammationCircuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgrammationCircuit[]    findAll()
 * @method ProgrammationCircuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammationCircuitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgrammationCircuit::class);
    }

//    /**
//     * @return ProgrammationCircuit[] Returns an array of ProgrammationCircuit objects
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
    public function findOneBySomeField($value): ?ProgrammationCircuit
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
