-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2019 at 12:54 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adboxadm_apym54`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad3xp_estados`
--

CREATE TABLE `ad3xp_estados` (
  `estado_id` int(2) DEFAULT NULL,
  `clave` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `nombre` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `abrev` varchar(16) COLLATE utf8_spanish2_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `ad3xp_estados`
--

INSERT INTO `ad3xp_estados` (`estado_id`, `clave`, `nombre`, `abrev`, `id`) VALUES
(1, '2', 'Aguascalientes', 'Ags.', 1),
(2, '3', 'Baja California', 'BC', 2),
(3, '4', 'Baja California Sur', 'BCS', 3),
(4, '5', 'Campeche', 'Camp.', 4),
(5, '6', 'Coahuila de Zaragoza', 'Coah.', 5),
(6, '7', 'Colima', 'Col.', 6),
(7, '8', 'Chiapas', 'Chis.', 7),
(8, '9', 'Chihuahua', 'Chih.', 8),
(9, '1', 'Ciudad de México', 'CDMX', 9),
(10, '10', 'Durango', 'Dgo.', 10),
(11, '11', 'Guanajuato', 'Gto.', 11),
(12, '12', 'Guerrero', 'Gro.', 12),
(13, '13', 'Hidalgo', 'Hgo.', 13),
(14, '14', 'Jalisco', 'Jal.', 14),
(15, '15', 'México', 'Mex.', 15),
(16, '16', 'Michoacán de Ocampo', 'Mich.', 16),
(17, '17', 'Morelos', 'Mor.', 17),
(18, '18', 'Nayarit', 'Nay.', 18),
(19, '19', 'Nuevo León', 'NL', 19),
(20, '20', 'Oaxaca', 'Oax.', 20),
(21, '21', 'Puebla', 'Pue.', 21),
(22, '22', 'Querétaro', 'Qro.', 22),
(23, '23', 'Quintana Roo', 'Q. Roo', 23),
(24, '24', 'San Luis Potosí', 'SLP', 24),
(25, '25', 'Sinaloa', 'Sin.', 25),
(26, '26', 'Sonora', 'Son.', 26),
(27, '27', 'Tabasco', 'Tab.', 27),
(28, '28', 'Tamaulipas', 'Tamps.', 28),
(29, '29', 'Tlaxcala', 'Tlax.', 29),
(30, '30', 'Veracruz de Ignacio de la Llave', 'Ver.', 30),
(31, '31', 'Yucatán', 'Yuc.', 31),
(32, '32', 'Zacatecas', 'Zac.', 32);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad3xp_estados`
--
ALTER TABLE `ad3xp_estados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad3xp_estados`
--
ALTER TABLE `ad3xp_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
