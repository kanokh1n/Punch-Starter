<?php

namespace App\Repository;

use App\Entity\UsersMessages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersMessages>
 *
 * @method UsersMessages|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersMessages|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersMessages[]    findAll()
 * @method UsersMessages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersMessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersMessages::class);
    }

    //    /**
    //     * @return UsersMessages[] Returns an array of UsersMessages objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UsersMessages
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
