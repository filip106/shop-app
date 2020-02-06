<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 31-Aug-19
 * Time: 12:15 PM
 */

namespace src\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class DbManager
 */
class DbManager
{
    /**
     * @var DbManager
     */
    private static $instance;

    /**
     * @var EntityManager
     */
    public $em;

    /**
     * DbManager constructor.
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct()
    {
        $connectionOptions = array(
            'driver' => getenv('DATABASE_DRIVER'),
            'host' => getenv('DATABASE_HOST'),
            'dbname' => getenv('DATABASE_DBNAME'),
            'user' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASSWORD')
        );

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../Model'), APP_DEBUG, null, null, false);

        $this->em = EntityManager::create($connectionOptions, $config);
    }

    /**
     * @return DbManager
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @return EntityManager
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public static function initEntityManager()
    {
        self::$instance = new DbManager();

        return self::$instance->em;
    }
}