CREATE TABLE `sa_users` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `username` VARCHAR(100) NOT NULL ,
    `email` VARCHAR(100) NOT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`username`),
    UNIQUE (`email`))
ENGINE = InnoDB;