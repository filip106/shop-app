<?php

namespace src\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use src\Model\Order;

/**
 * Class OrderRepository
 * @package src\Repository
 */
class OrderRepository extends EntityRepository
{
    /**
     * @param string $sessionId
     *
     * @return mixed
     */
    public function getLastOrderForUser($sessionId)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->where($qb->expr()->like('o.sessionId', $qb->expr()->literal($sessionId)));
        $qb->orderBy('o.id', 'DESC');
        $qb->setMaxResults(1);

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    /**
     * @param Order $order
     *
     * @return Order
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveOrder($order)
    {
        $this->_em->persist($order);
        $this->_em->flush();

        return $order;
    }
}