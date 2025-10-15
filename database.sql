-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kalingga_brownies
DROP DATABASE IF EXISTS `kalingga_brownies`;
CREATE DATABASE IF NOT EXISTS `kalingga_brownies` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kalingga_brownies`;

-- Dumping structure for table kalingga_brownies.admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kalingga_brownies.admins: ~1 rows (approximately)
DELETE FROM `admins`;
INSERT INTO `admins` (`id`, `username`, `password_hash`) VALUES
	(1, 'admin', '$2y$10$zh8s1ae9Z6X9k8BcqhZmTua77GrIzf4CxuAHWqsID5T80IEludbW.');

-- Dumping structure for table kalingga_brownies.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kalingga_brownies.categories: ~13 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`) VALUES
	(1, 'Brownies', NULL, NULL),
	(2, 'Cakes', NULL, NULL),
	(3, 'Pies', NULL, NULL),
	(4, 'Hampers', NULL, NULL),
	(9, 'Baked Brownies', NULL, 1),
	(10, 'Steamed Brownies', NULL, 1),
	(11, 'Brownies in Jar', NULL, 1),
	(12, 'Stick Brownies', NULL, 1),
	(13, 'Wedding Cakes', NULL, 2),
	(14, 'Birthday Cakes', NULL, 2),
	(15, 'Rollcakes', NULL, 2),
	(18, 'Eid Hampers', NULL, 4),
	(19, 'Wedding Hampers', NULL, 4);

-- Dumping structure for table kalingga_brownies.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kalingga_brownies.customers: ~2 rows (approximately)
DELETE FROM `customers`;
INSERT INTO `customers` (`id`, `name`, `email`, `password_hash`, `created_at`) VALUES
	(1, 'Allyya Novita', 'aliyaliyaa00@gmail.com', '$2y$10$bnouze1/nskoS8yE5g2yneYaed0Zivsa9f/lIpdJW5jvTSA9Ia8yO', '2025-10-15 08:22:08'),
	(2, 'Customer Satu', 'cust@email.com', '$2y$10$wc7fFy9cNtITaNIsTg/J3.nyIwBx1I7C8RGyMyq1zyX9T4Nhjn5gW', '2025-10-15 08:25:58');

-- Dumping structure for table kalingga_brownies.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kalingga_brownies.products: ~5 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category_id`, `created_at`) VALUES
	(1, 'Triple Coat Fudgy Brownie', 'An intensely rich brownie made with dark chocolate, enrichened with milo block chocolate, sliced almonds, and countless chocochips', 63000.00, '/img/brownies1.png', 9, '2025-10-05 17:54:36'),
	(2, 'Strawberry Frosted Brownies', 'trust me it\'s tasty!!', 55000.00, '/img/68e7de7d2febb_Strawberry_Frosted_Brownies.jpg', 1, '2025-10-09 16:10:37'),
	(4, 'Custard Pie', 'sooo tastyyyy', 46000.00, '/img/68efb7578a2a7_Custard_Pien.jpg', 3, '2025-10-15 15:01:43'),
	(5, 'Fruit Tarts', 'sooo milkyyyy', 48000.00, '/img/68efbe046955b_Classic_Fruit_Tarts.jpg', 3, '2025-10-15 15:30:12'),
	(6, 'Pistachico Brownies', 'pistachio and melting chocolate', 67000.00, '/img/68efbeba39524_Ferrero__Pistachio_and_Bueno______brownies___.jpg', 1, '2025-10-15 15:32:40');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
