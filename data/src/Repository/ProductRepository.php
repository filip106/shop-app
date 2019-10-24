<?php

namespace src\Repository;

use src\Database\DbManager;

class ProductRepository
{
    /**
     * @param int $limit
     *
     * @return array
     * @throws \Exception
     */
    public function getNewestProducts(int $limit = 5)
    {
        $sql = 'SELECT * FROM sa_products p ORDER BY p.created_at LIMIT ?';

        return DbManager::getInstance()->executeSql($sql, $limit)->fetchAll();
    }
}