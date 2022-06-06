CREATE TABLE `fuentes_informacion` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_entidad` INT(11) NULL DEFAULT 0,
	`clave` VARCHAR(255) NULL DEFAULT NULL,
	`nombre` VARCHAR(255) NULL DEFAULT NULL,
	`estatus` ENUM('active','inactive') NULL DEFAULT NULL,
	`url` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` DATE NULL DEFAULT NULL,
	`pais` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;
