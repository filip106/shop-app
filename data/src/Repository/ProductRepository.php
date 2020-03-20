<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use src\Model\Category;
use src\Model\Product;

class ProductRepository extends EntityRepository
{

    /**
     * @param int $id
     *
     * @return bool|\Doctrine\Common\Proxy\Proxy|object|null
     */
    public function getReference($id)
    {
        try {
            return $this->_em->getReference(Product::class, $id);
        } catch (ORMException $e) {
            return null;
        }
    }

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
     * @return int|mixed
     */
    public function getProductsAsArrayCount()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select($qb->expr()->count('p.id'));

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
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

    /**
     * @param Category $category
     *
     * @return mixed
     */
    public function findAllForCategory(Category $category)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->innerJoin('p.categories', 'pc');
        $qb->where($qb->expr()->eq('pc.category', $category->getId()));

        $qb->setMaxResults(6);
        $qb->orderBy('p.price', 'DESC');

        return $qb->getQuery()->getResult();
    }
}