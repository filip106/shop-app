<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;
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