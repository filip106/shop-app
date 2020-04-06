<?php
/**
 * Created by PhpStorm.
 * User: Aleksandra
 * Date: 31-Aug-19
 * Time: 12:27 PM
 */

namespace src\Database\Migration;

/**
 * Class CreateUser
 * @package src\Database\Migration
 */
class CreateUser
{
    /**
     *
     */
    public function up()
    {
        $sql = 'CREATE TABLE `sa_users` (
                    `id` INT NOT NULL AUTO_INCREMENT ,
                    `username` VARCHAR(100) NOT NULL ,
                    `email` VARCHAR(100) NOT NULL ,
                    PRIMARY KEY (`id`),
                    UNIQUE (`username`),
                    UNIQUE (`email`))
                ENGINE = InnoDB;';
    }

    /**
     *
     */
    public function down()
    {
        $sql = 'DROP TABLE sa_users';
    }
}