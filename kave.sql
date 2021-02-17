-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2021 at 05:48 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kave`
--

-- --------------------------------------------------------

--
-- Table structure for table `kavek`
--

CREATE TABLE `kavek` (
  `id` int(11) NOT NULL,
  `nev` varchar(256) NOT NULL,
  `ar` int(11) NOT NULL,
  `tejese` tinyint(1) NOT NULL,
  `leiras` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kavek`
--

INSERT INTO `kavek` (`id`, `nev`, `ar`, `tejese`, `leiras`) VALUES
(1, 'frappe', 600, 1, 'görög eredetű kávé,\r\nhideg, habosított, instant kávé, amihez jégkockákat adnak'),
(2, 'presso', 300, 0, 'egy jó erös, fekete kotyogos kávé'),
(3, 'cappuccino', 450, 1, 'egy olasz presso alapu kávé'),
(4, 'Tejes kávé', 430, 1, 'presso kávé tejjel'),
(5, 'Ír kávé', 1000, 0, ' erősebb kávé whiskyvel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kavek`
--
ALTER TABLE `kavek`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kavek`
--
ALTER TABLE `kavek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
