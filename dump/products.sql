CREATE TABLE `sa_products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `short_description` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `base_image` VARCHAR(255) NULL,
    `created_at` DATETIME NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;