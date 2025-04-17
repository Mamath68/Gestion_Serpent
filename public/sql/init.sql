CREATE DATABASE IF NOT EXISTS snakes_db;
USE snakes_db;

CREATE TABLE `snakes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `lifespan` int(11) DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `gender` enum('mâle','femelle') DEFAULT NULL,
  `parent_male_id` int(11) DEFAULT NULL,
  `parent_female_id` int(11) DEFAULT NULL,
  `is_dead` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `snakes`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `snakes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;