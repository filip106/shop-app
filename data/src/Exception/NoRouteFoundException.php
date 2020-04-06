<?php
/**
 * Created by PhpStorm.
 * User: Aleksandra
 * Date: 01-Sep-19
 * Time: 6:15 PM
 */

namespace src\Exception;

/**
 * Class NoRouteFoundException
 * @package src\Exception
 */
class NoRouteFoundException extends \Exception
{
    /**
     * NoRouteFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Route is not defined', 404);
    }
}