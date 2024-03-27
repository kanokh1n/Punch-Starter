<?php

namespace App\Repository;

use App\Entity\Pledges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pledges>
 *
 * @method Pledges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pledges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pledges[]    findAll()
 * @method Pledges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PledgesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pledges::class);
    }

    //    /**
    //     * @return Pledges[] Returns an array of Pledges objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pledges
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
