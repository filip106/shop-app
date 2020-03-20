<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use src\Model\Category;

class CategoryRepository extends EntityRepository
{

    /**
     * @param $page
     * @param $offset
     *
     * @return array
     */
    public function getCategoriesAsArray($page, $offset)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->setMaxResults($offset)->setFirstResult(($page - 1) * $offset);
        $qb->orderBy('c.id', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return int|mixed
     */
    public function getCategoriesAsArrayCount()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select($qb->expr()->count('c.id'));

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * @param Category $category
     *
     * @return Category
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category)
    {
        $this->_em->persist($category);
        $this->_em->flush();

        return $category;
    }
}