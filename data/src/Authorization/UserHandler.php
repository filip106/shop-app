<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 26-Sep-19
 * Time: 11:07 PM
 */

namespace src\Authorization;

use src\Model\UserInterface;

class UserHandler
{
    /** @var UserInterface */
    static private $currentUser;

    /**
     * @return UserInterface
     */
    public static function getCurrentUser()
    {
        return self::$currentUser;
    }

}