<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;
use src\Model\Product;

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

    /**
     * @param $page
     * @param $offset
     *
     * @return array
     */
    public function getProductsAsArray($page, $offset)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->setMaxResults($offset)->setFirstResult(($page - 1) * $offset);
        $qb->orderBy('p.id', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param Product $product
     *
     * @return Product
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Product $product)
    {
        $this->_em->persist($product);
        $this->_em->flush($product);

        return $product;
    }
}