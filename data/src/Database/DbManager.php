<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 31-Aug-19
 * Time: 12:15 PM
 */

namespace src\Database;

use Exception;
use mysqli;

/**
 * Class DbManager
 */
class DbManager
{
    /** @var string */
    private $dbName;
    /** @var string */
    private $dbUser;
    /** @var string */
    private $dbPassword;
    /** @var DbManager */
    private static $instance = null;

    /**
     * DbManager constructor.
     */
    private function __construct()
    {
        $params = include __DIR__.'/../../config/parameters.php';

        $this->dbName = $params['db_name'];
        $this->dbUser = $params['db_user'];
        $this->dbPassword = $params['db_password'];
    }

    /**
     * @return DbManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new DbManager();
        }

        return self::$instance;
    }


    /**
     * @param string $sql
     *
     * @return array|bool|\mysqli_result
     *
     * @throws Exception
     */
    public function executeSql($sql)
    {
        $conn = new mysqli('localhost', $this->dbUser, $this->dbPassword, $this->dbName);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($sql);
        if (false === $result) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $conn->close();

        return $result;
    }
}