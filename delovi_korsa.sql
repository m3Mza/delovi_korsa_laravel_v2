-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 05, 2025 at 06:21 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delovi_korsa`
--

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `ime` varchar(100) NOT NULL,
  `prezime` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `tip_korisnika` enum('kupac','admin') NOT NULL DEFAULT 'kupac',
  `telefon` varchar(20) DEFAULT NULL,
  `adresa` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `lozinka`, `tip_korisnika`, `telefon`, `adresa`, `created_at`, `updated_at`) VALUES
(4, 'Admin', 'Administrator', 'admin@delovi-korsa.com', 'admin123', 'admin', '123456789', 'Admin Address', '2025-11-05 15:09:33', '2025-11-05 15:17:40'),
(5, 'Mirko', 'Benic', 'mirko@test.com', 'mirko123', 'kupac', '231231245124', 'dasdasdasda', '2025-11-05 14:38:53', '2025-11-05 14:38:53');

-- --------------------------------------------------------

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_25_185655_add_image_to_proizvodi_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--

CREATE TABLE `proizvodi` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`id`, `name`, `price`, `category`, `brand`, `image`) VALUES
(1, 'Set Kočionih Ploča', '2500', 'Kočnice', 'Brembo', 'img/brembo_kocione_plocice.png\r\n'),
(2, 'Filter Ulja', '800', 'Filteri', 'Mann', 'img/mann_filter_ulja.jpg\r\n'),
(3, 'Svećice (4 kom)', '1200', 'Motor', 'NGK', 'img/ngk_svecice.jpg\r\n'),
(4, 'Filter Vazduha', '1500', 'Filteri', 'Bosch', 'img/bosch_filter_vazduha.jpg\r\n'),
(5, 'Disk Kočnice (2 kom)', '4500', 'Kočnice', 'ATE', 'img/ate_disk_kocnice.jpg\r\n'),
(6, 'Zupčasti Kaiš', '3200', 'Motor', 'Gates', 'img/gates_zupcasti_kais.jpg\r\n'),
(7, 'Akumulator 12V 60Ah', '8900', 'Elektrika', 'Varta', 'img/varta_akumulator.jpg\r\n'),
(8, 'Alternator', '12500', 'Elektrika', 'Bosch', NULL),
(9, 'Set Kvačila', '9800', 'Transmisija', 'Sachs', 'img/sachs_set_kvacila.jpg\r\n'),
(10, 'Filter Goriva', '950', 'Filteri', 'Mann', 'img/mann_filter_goriva.png\r\n'),
(11, 'Anlaser', '11200', 'Elektrika', 'Valeo', 'img/valeo_anlaser.jpg\r\n'),
(12, 'Pumpa za Vodu', '3800', 'Motor', 'SKF', 'img/skf_pumpa_za_vodu.jpg\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `proizvod_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `korisnik_id`, `proizvod_id`, `created_at`) VALUES
(1, 4, 1, '2025-11-05 16:55:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`korisnik_id`,`proizvod_id`);


--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
