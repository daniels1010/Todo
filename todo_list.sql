-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 06:32 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `card_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `isChecked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`card_id`, `title`, `description`, `isChecked`, `created_at`) VALUES
(1, 'Pamosties', 'Pamosties 9:00', 1, '2021-06-09 18:28:41'),
(2, 'Brokastis', 'Paēst brokastis', 1, '2021-06-09 18:28:51'),
(3, 'Savākties', 'nomazgāties, izmazgāt zobus un saģērbties', 1, '2021-06-09 18:28:58'),
(4, 'Eksamens', 'Eksamens Tīmekļa tehnoloģijās 11:00', 0, '2021-06-09 18:29:11'),
(5, 'Mācīties', 'Sagatavoties rītdienas Inofrmācijas Sistēmu eksamenam', 0, '2021-06-09 18:29:19'),
(6, 'Pabeigt Todo', 'Pabeigt ToDo List', 0, '2021-06-09 18:29:36'),
(7, 'Skriet', 'Vakara skrējiens 19:00', 0, '2021-06-09 18:29:43'),
(8, 'Iznest miskasti', '', 0, '2021-06-09 18:29:54'),
(9, 'Aiziet uz hidroelektrostaciju, kur vakar atrada pundurbruņurupucīti', 'Šis is piemērs kartiņai ar garu virsrakstu', 0, '2021-06-09 18:30:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
