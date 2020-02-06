<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @param int $limit
     *
     * @return array
     * @throws \Exception
     */
    public function getNewestProducts(int $limit = 5)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->orderBy('p.createdAt');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}