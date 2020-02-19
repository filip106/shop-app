<?php


namespace src\Service;


use Delight\Auth\Auth;

class SecurityService
{
    /** @var SecurityService */
    private static $instance;

    /** @var Auth */
    private $auth;

    /**
     * MailService constructor.
     */
    private function __construct()
    {
        $db = new \PDO(sprintf(
            'mysql:dbname=%s;host=%s;charset=utf8mb4',
            getenv('DATABASE_DBNAME'),
            getenv('DATABASE_HOST')
        ), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));

        $this->auth = new Auth($db, null, 'sa_', !APP_DEBUG);
    }

    /**
     * @return Auth
     */
    public function getAuth(): Auth
    {
        return $this->auth;
    }

    /**
     * @return SecurityService
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new SecurityService();
        }

        return self::$instance;
    }
}