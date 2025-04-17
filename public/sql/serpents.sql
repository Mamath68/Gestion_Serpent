-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           9.1.0 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour snakes_db
CREATE DATABASE IF NOT EXISTS `snakes_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `snakes_db`;

-- Listage de la structure de table snakes_db. snakes
CREATE TABLE IF NOT EXISTS `snakes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `lifespan` int DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `breed` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` enum('Mâle','Femelle') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `father_id` int DEFAULT NULL,
  `mother_id` int DEFAULT NULL,
  `is_dead` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table snakes_db.snakes : ~16 rows (environ)
DELETE FROM `snakes`;
INSERT INTO `snakes` (`id`, `name`, `weight`, `lifespan`, `birth_date`, `breed`, `gender`, `father_id`, `mother_id`, `is_dead`) VALUES
	(1, 's1', 10, 20, '2020-04-16 09:00:00', 'Alsophis ater', 'Mâle', NULL, NULL, 0),
	(2, 's2', 10, 10, '2020-04-16 09:00:00', 'Alsophis ater', 'Femelle', NULL, NULL, 0),
	(3, 'noodle', 40.6, 12, '2025-04-16 09:21:00', 'Alsophis ater', 'Mâle', 2, 5, 0),
	(4, 'aa1', 10, 150, '2020-07-16 12:36:00', 'Anaconda à taches sombres', 'Femelle', NULL, NULL, 0),
	(5, 'aa2', 50, 150, '2020-02-16 12:36:00', 'Anaconda à taches sombres', 'Mâle', NULL, NULL, 0),
	(6, 'baby_Sphinx_795', 36.2, 15, '2025-04-16 09:37:11', 'Anaconda à taches sombres', 'Femelle', 11, 10, 0),
	(7, 'Slytherin', 2, 15, NULL, 'Python Royal', 'Mâle', NULL, NULL, 1),
	(8, 'Slytherin', 1, 25, NULL, 'Serpent des blés', 'Mâle', NULL, NULL, 1),
	(9, 'Slytherin', 2, 10, NULL, 'Cobra Royal', 'Femelle', NULL, NULL, 0),
	(10, 'Anaconda', 6, 25, NULL, 'Cobra Royal', 'Mâle', NULL, NULL, 0),
	(11, 'Python', 8, 10, NULL, 'Cobra Royal', 'Mâle', NULL, NULL, 0),
	(12, 'Python', 1, 15, NULL, 'Cobra Royal', 'Femelle', NULL, NULL, 0),
	(13, 'Slytherin', 6, 10, NULL, 'Serpent des blés', 'Femelle', NULL, NULL, 1),
	(14, 'Python', 8, 10, NULL, 'Serpent des blés', 'Mâle', NULL, NULL, 1),
	(15, 'Anaconda', 4, 5, NULL, 'Anaconda Vert', 'Mâle', NULL, NULL, 0),
	(16, 'Viper', 5, 10, NULL, 'Serpent des blés', 'Mâle', NULL, NULL, 1),
	(17, 'Mathieu Stamm', 500, 15, '2025-04-16 21:00:00', 'Python Royal', 'Mâle', NULL, NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
