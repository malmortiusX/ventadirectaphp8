DROP TABLE IF EXISTS `tbl_clientes_vd`;
CREATE TABLE `tbl_clientes_vd` (
	`id_cliente_vd` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_usuario` BIGINT(20) UNSIGNED NOT NULL,
	`nombres` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`apellidos` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`cedula` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci',
	`telefono` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`correo_electronico` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci',
	`direccion` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`barrio` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci',
	`id_ciudad` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`id_cliente_vd`) USING BTREE
)
COLLATE='utf8mb4_spanish_ci'
ENGINE=InnoDB
;

DROP TABLE IF EXISTS `tbl_login_tokens`;
CREATE TABLE `tbl_login_tokens` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_usuario` BIGINT(20) UNSIGNED NOT NULL,
	`token` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_spanish_ci',
	`created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_spanish_ci'
ENGINE=InnoDB
;

/* De aquí para abajo ya está en producción*/

ALTER TABLE `tbl_usuario`
	ADD COLUMN `cc_nit_usuario` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `descuento_volumen`;

ALTER TABLE `tbl_comercial`
	ADD COLUMN `id_cliente_vd` INT(11) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `estado_pedido`,
    ADD COLUMN `nombre_cliente_vd` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `id_cliente_vd`,
    ADD COLUMN `cedula_cliente_vd` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `nombre_cliente_vd`,
	ADD COLUMN `telefono_cliente_vd` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `cedula_cliente_vd`,
	ADD COLUMN `direccion_cliente_vd` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `telefono_cliente_vd`,
	ADD COLUMN `ciudad_cliente_vd` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_spanish_ci' AFTER `direccion_cliente_vd`;

UPDATE `tbl_usuario`
	SET `nivel` = 'u_callcenter', `cc_nit_usuario` = '800000276.00'
	WHERE `nombres` = 'CALL';