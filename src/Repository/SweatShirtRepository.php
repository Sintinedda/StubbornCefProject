<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\SweatShirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SweatShirt>
 */
class SweatShirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SweatShirt::class);
    }

    /**
     * @return SweatShirt[] Returns an array of SweatShirt objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
      }

      public function findSearch(SearchData $search): array
      {
        $query = $this
            ->createQueryBuilder('sweat')
            ->select('sweat');

        if (!empty($search->min)) {
            $query = $query
                ->andWhere('sweat.price >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('sweat.price <= :max')
                ->setParameter('max', $search->max);
        }

        return $query->getQuery()->getResult();
      }

    //    public function findOneBySomeField($value): ?SweatShirt
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
