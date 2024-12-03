-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para smc_test
CREATE DATABASE IF NOT EXISTS `smc_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `smc_test`;

-- Volcando estructura para tabla smc_test.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla smc_test.categorias: ~4 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `nombre`) VALUES
	(1, 'Personal'),
	(2, 'Trabajo'),
	(3, 'Estudio'),
	(4, 'Hogar');

-- Volcando estructura para tabla smc_test.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int NOT NULL,
  `nivel` int NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `categoria_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla smc_test.tareas: ~9 rows (aproximadamente)
INSERT INTO `tareas` (`id`, `nombre`, `descripcion`, `estado`, `nivel`, `fecha_vencimiento`, `categoria_id`) VALUES
	(1, 'test', 'test', 0, 1, '2024-12-02', 3),
	(2, 'braille printer', 'terminar prototipop', 1, 2, '2024-11-27', 2),
	(3, 'subir app', 'cmpiminet politicas google', 0, 3, '2024-12-11', 1),
	(4, 'pagar cuentas', 'pago ctas', 0, 3, '2024-12-04', 1),
	(5, 'comprar llave', 'cotizar', 1, 2, '2024-12-06', 4),
	(6, 'nueva2', 'asdas', 1, 2, '2024-12-19', 3);

-- Volcando estructura para tabla smc_test.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla smc_test.users: ~3 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
	(1, 'Felipe', 'asd@qwe.com', '$2y$10$yTsGMuRaL0d4MGC0mZMlWuwT5c.bhS.lsfyHnOd8Y92h77mZWcvgu'),
	(2, 'Ignacio', 'qwe@qwe.com', '$2y$10$yTsGMuRaL0d4MGC0mZMlWuwT5c.bhS.lsfyHnOd8Y92h77mZWcvgu'),
	(6, 'qweqw', 'qweqwe@qweqwe.com', '$2y$10$lBEYFO3AS6r/T.2BZyDTU.OtvOLd55zK7WO88LsPO9zBrRSsYG0Vm');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
