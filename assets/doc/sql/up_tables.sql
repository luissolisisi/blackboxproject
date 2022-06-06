CREATE TABLE `cat_listas` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`clave_tipo` VARCHAR(255) NULL DEFAULT NULL,
	`clave_pertenece` VARCHAR(255) NULL DEFAULT NULL,
	`nombre` VARCHAR(255) NULL DEFAULT NULL,
	`considerado` INT(11) NULL DEFAULT NULL,
	`status` ENUM('active','inactive') NULL DEFAULT NULL,
	`date` DATE NULL DEFAULT NULL,
	`liga` VARCHAR(100) NULL DEFAULT NULL,
	`numero` INT(100) NULL DEFAULT NULL,
	`id_entidad` INT(50) NULL DEFAULT NULL,
	`pais` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=33
;


CREATE TABLE `access_listas` (
	`id` INT(50) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80) NULL DEFAULT NULL,
	`lastname` VARCHAR(80) NULL DEFAULT NULL,
	`email` VARCHAR(80) NULL DEFAULT NULL,
	`pwd` VARCHAR(255) NULL DEFAULT NULL,
	`status` ENUM('active','inactive') NULL DEFAULT NULL,
	`roll` INT(11) NULL DEFAULT NULL,
	`empresa` VARCHAR(50) NULL DEFAULT NULL,
	`idEntidad` VARCHAR(50) NULL DEFAULT NULL,
	`pais` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=19
;