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
use mysqli_stmt;

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

    /** @var mysqli */
    private $connection;
    /** @var mysqli_stmt */
    private $query;
    /** @var int */
    public $queryCount = 0;
    /** @var string */
    private $charset = 'urf8';

    /**
     * DbManager constructor.
     */
    private function __construct()
    {
        $params = include __DIR__ . '/../../config/parameters.php';

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
     * @param string $query
     * @param array ...$additionalParams
     *
     * @return DbManager
     *
     * @throws Exception
     */
    public function executeSql($query, ...$additionalParams)
    {
        $this->connection = new mysqli('localhost', $this->dbUser, $this->dbPassword, $this->dbName);

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
        $this->connection->set_charset($this->charset);

        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_getType($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types .= $this->_getType($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }
            $this->query->execute();
            if ($this->query->errno) {
                throw new \Exception(sprintf('Unable to process MySQL query (check your params) - %s', $this->query->error));
            }

            $this->queryCount++;
        } else {
            throw new \Exception(sprintf('Unable to prepare statement (check your syntax) - %s', $this->connection->error));
        }

        return $this;
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            $result[] = $r;
        }
        $this->query->close();
        return $result;
    }

    /**
     * @return array
     */
    public function fetchArray()
    {
        $params = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }
        $this->query->close();
        return $result;
    }

    /**
     * @param mixed $var
     *
     * @return string
     */
    private function _getType($var)
    {
        if (is_string($var)) {
            return 's';
        }

        if (is_float($var)) {
            return 'd';
        }

        if (is_int($var)) {
            return 'i';
        }

        return 'b';
    }
}