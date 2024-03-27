<?php

namespace App\Repository;

use App\Entity\ProjectsCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectsCategories>
 *
 * @method ProjectsCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectsCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectsCategories[]    findAll()
 * @method ProjectsCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectsCategories::class);
    }

    //    /**
    //     * @return ProjectsCategories[] Returns an array of ProjectsCategories objects
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

    //    public function findOneBySomeField($value): ?ProjectsCategories
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
