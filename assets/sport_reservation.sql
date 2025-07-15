-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 14, 2025 at 03:19 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sport_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `date_heures_fermees`
--

DROP TABLE IF EXISTS `date_heures_fermees`;
CREATE TABLE IF NOT EXISTS `date_heures_fermees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `terrain_id` int NOT NULL,
  `date` date NOT NULL,
  `debut_fermeture` time NOT NULL,
  `fin_fermeture` time NOT NULL,
  `motif` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_date_heures_fermees_terrains` (`terrain_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `date_heures_fermees`
--

INSERT INTO `date_heures_fermees` (`id`, `terrain_id`, `date`, `debut_fermeture`, `fin_fermeture`, `motif`) VALUES
(8, 7, '2025-07-08', '21:00:00', '23:00:00', 'Repain');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `terrain_id` int NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `statut` enum('en attente','confirmée','annulée') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reservation_utilisateur` (`user_id`),
  KEY `fk_reservation_terrains` (`terrain_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `user_id`, `terrain_id`, `date`, `heure_debut`, `heure_fin`, `statut`) VALUES
(5, 23, 7, '2025-07-06', '19:00:00', '20:00:00', 'confirmée'),
(6, 21, 17, '2025-07-07', '13:00:00', '14:00:00', 'annulée'),
(7, 23, 18, '2025-07-06', '10:00:00', '11:00:00', 'en attente'),
(8, 25, 7, '2025-07-08', '22:00:00', '23:00:00', 'annulée'),
(9, 25, 7, '2025-07-08', '19:00:00', '20:00:00', 'en attente'),
(10, 25, 7, '2025-07-08', '12:00:00', '13:00:00', 'en attente'),
(11, 25, 7, '2025-07-08', '16:00:00', '17:00:00', 'confirmée'),
(12, 25, 7, '2025-07-08', '14:00:00', '15:00:00', 'confirmée'),
(13, 25, 15, '2025-07-07', '21:00:00', '22:00:00', 'annulée'),
(15, 20, 20, '2025-07-07', '20:00:00', '21:00:00', 'en attente'),
(17, 20, 20, '2025-07-16', '21:00:00', '22:00:00', 'en attente');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

DROP TABLE IF EXISTS `sports`;
CREATE TABLE IF NOT EXISTS `sports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `nom`) VALUES
(1, 'Soccer'),
(5, 'Rugby'),
(7, 'Swimming'),
(10, 'Basketball'),
(11, 'Tennis'),
(16, 'Handball'),
(20, 'Table Tennis'),
(22, 'Cricket'),
(23, 'Hockey'),
(24, 'Volleyball'),
(26, 'Baseball'),
(27, 'Golf'),
(28, 'Badminton');

-- --------------------------------------------------------

--
-- Table structure for table `terrains`
--

DROP TABLE IF EXISTS `terrains`;
CREATE TABLE IF NOT EXISTS `terrains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `addresse` text NOT NULL,
  `sport_id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_terrains_sports` (`sport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `terrains`
--

INSERT INTO `terrains` (`id`, `addresse`, `sport_id`, `nom`, `image`) VALUES
(7, '12 Football Way', 1, 'Greenfield Arena', 'soccer1.png'),
(8, '78 Tackle Street', 5, 'Thunder Park Rugby Grounds', 'rugby1.png'),
(9, '500 Courtline Avenue', 10, 'SlamDunk Indoor Court', 'basketball1.png'),
(10, '62 Sportsweg', 16, 'Velocity Handball Hall', 'handball1.png'),
(11, '14 Paddle Street', 20, 'SpinPoint Table Tennis Center', 'pingpong1.png'),
(12, '100 Boundary Lane', 22, 'Royal Willow Cricket Ground', 'cricket1.png'),
(13, '32 Icebreak Blvd', 23, 'Glacier Edge Hockey', 'hockey1.png'),
(14, '22 Netline Rd', 24, 'Sky Spike Volleyball Arena', 'volleyball1.png'),
(15, '301 Home Run Ave', 26, 'Diamond Field Park', 'baseball1.png'),
(16, '245 Ocean Drive', 7, 'Blue Wave Aquatic Center', 'swimming1.png'),
(17, '90 Wimbledon Rd', 11, 'Grand Ace Tennis Club', 'tennis1.png'),
(18, '88 Fairway Drive', 27, 'Emerald Hills Golf Club', 'golf1.png'),
(20, '19 Feather Street', 28, 'Shuttle Smash Badminton Hall', 'badminton1.png');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','client') NOT NULL,
  `created_at` date NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `password_hash`, `role`, `created_at`, `avatar`) VALUES
(20, 'John Doe', 'johndoe@gmail.com', '$2y$10$b3exSsvR8zDohKVDjTb/zus6RztlFRxrbd1LQ0SlXCAI3QO.fPe9m', 'client', '0000-00-00', 'avatar-7.jpg'),
(21, 'Adnane R.', 'adnane@gmail.com', '$2y$10$EsBBvljo2ATnVSxPXFxZguz5GWXmXi8OQA5EYtM0qxoTI5tws2Yx6', 'client', '0000-00-00', 'avatar-5.jpg'),
(22, 'Admin', 'admin@admin.com', '$2y$10$iZHEnl147J.8/xbQ.xGS6Oe37it.Zt60DBGKBkrjW6inNrWtYCSAu', 'admin', '0000-00-00', 'avatar-5.jpg'),
(23, 'Ahmed Benzemrou', 'ahmed@gmail.com', '$2y$10$.0g131HB8m/KFZAv7/CGhenSIcxb4zumX/XPVVviqsrF4bcoFfzmS', 'client', '2025-07-03', 'avatar-1.jpg'),
(24, 'Yahya Aloui', 'yahya@gmail.com', '$2y$10$lLDJHX/F9MQZylUL4piA3.26tjLEkZnYaWwJ8.puNkD3eADwPLvRO', 'client', '2025-07-05', ''),
(25, 'Oussama Ben', 'oussama@gmail.com', '$2y$10$X1zBlbYSFIAj6f1./gC2qugwbZVmJPCs4WqqMG9x9EHYqS5wnirry', 'client', '2025-07-05', 'avatar-4.jpg'),
(27, 'Sarah Johnson', 'sarah@gmail.com', '$2y$10$NMON2wediKk1rWlwS7MHc.GJ3dNaT8.52IgITk8s1jgBf7jEX7lN6', 'client', '2025-07-09', 'avatar-1.jpg'),
(28, 'Ron Mistake', 'ron@gmail.com', '$2y$10$E3jBtRkiYDAIMc.9Q2dsVO2MAJXPUO/p7uRaEmTruoVWqU2Hyt.i2', 'client', '2025-07-09', 'avatar-1.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `date_heures_fermees`
--
ALTER TABLE `date_heures_fermees`
  ADD CONSTRAINT `fk_date_heures_fermees_terrains` FOREIGN KEY (`terrain_id`) REFERENCES `terrains` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_terrains` FOREIGN KEY (`terrain_id`) REFERENCES `terrains` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `terrains`
--
ALTER TABLE `terrains`
  ADD CONSTRAINT `fk_terrains_sports` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
