<?php

namespace OSModel\Repository;

use OSModel\Entity\OSModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class OSModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OSModel::class);
    }

    public function getSearchQuery(array $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder('o');

        if ($criteria['osType']) {
            $qb->andWhere('o.osType = :osType')
                ->setParameter('osType', $criteria['osType'])
            ;
        }

        return $qb;
    }
}
