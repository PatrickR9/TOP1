-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 06. Dez 2024 um 14:52
-- Server-Version: 11.3.2-MariaDB
-- PHP-Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `rio_local`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `author_contracts`
--

DROP TABLE IF EXISTS `author_contracts`;
CREATE TABLE IF NOT EXISTS `author_contracts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sign_date` datetime DEFAULT NULL,
  `signed_pdf` varchar(500) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bible_books`
--

DROP TABLE IF EXISTS `bible_books`;
CREATE TABLE IF NOT EXISTS `bible_books` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `bible_version_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `bible_books`
--

INSERT INTO `bible_books` (`id`, `api_id`, `name`, `position`, `bible_version_id`, `created_at`, `updated_at`) VALUES
(1, 'GEN', '1. Mose', 1, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(2, 'EXO', '2. Mose', 2, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(3, 'LEV', '3. Mose', 3, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(4, 'NUM', '4. Mose', 4, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(5, 'DEU', '5. Mose', 5, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(6, 'JOS', 'Josua', 6, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(7, 'JDG', 'Richter', 7, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(8, 'RUT', 'Rut', 8, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(9, '1SA', '1. Samuel', 9, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(10, '2SA', '2. Samuel', 10, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(11, '1KI', '1. Könige', 11, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(12, '2KI', '2. Könige', 12, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(13, '1CH', '1. Chronik', 13, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(14, '2CH', '2. Chronik', 14, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(15, 'EZR', 'Esra', 15, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(16, 'NEH', 'Nehemia', 16, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(17, 'EST', 'Ester', 17, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(18, 'JOB', 'Hiob', 18, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(19, 'PSA', 'Psalm', 19, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(20, 'PRO', 'Sprichwörter', 20, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(21, 'ECC', 'Kohelet', 21, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(22, 'SNG', 'Hohelied', 22, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(23, 'ISA', 'Jesaja', 23, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(24, 'JER', 'Jeremia', 24, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(25, 'LAM', 'Klagelieder', 25, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(26, 'EZK', 'Ezechiel', 26, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(27, 'DAN', 'Daniel', 27, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(28, 'HOS', 'Hosea', 28, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(29, 'JOL', 'Joel', 29, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(30, 'AMO', 'Amos', 30, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(31, 'OBA', 'Obadja', 31, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(32, 'JON', 'Jona', 32, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(33, 'MIC', 'Micha', 33, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(34, 'NAM', 'Nahum', 34, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(35, 'HAB', 'Habakuk', 35, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(36, 'ZEP', 'Zefanja', 36, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(37, 'HAG', 'Haggai', 37, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(38, 'ZEC', 'Sacharja', 38, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(39, 'MAL', 'Maleachi', 39, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(40, 'MAT', 'Matthäus', 40, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(41, 'MRK', 'Markus', 41, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(42, 'LUK', 'Lukas', 42, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(43, 'JHN', 'Johannes', 43, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(44, 'ACT', 'Apostelgeschichte', 44, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(45, 'ROM', 'Römer', 45, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(46, '1CO', '1. Korinther', 46, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(47, '2CO', '2. Korinther', 47, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(48, 'GAL', 'Galater', 48, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(49, 'EPH', 'Epheser', 49, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(50, 'PHP', 'Philipper', 50, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(51, 'COL', 'Kolosser', 51, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(52, '1TH', '1. Thessalonicher', 52, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(53, '2TH', '2. Thessalonicher', 53, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(54, '1TI', '1. Timotheus', 54, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(55, '2TI', '2. Timotheus', 55, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(56, 'TIT', 'Titus', 56, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(57, 'PHM', 'Philemon', 57, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(58, 'HEB', 'Hebräer', 58, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(59, 'JAS', 'Jakobus', 59, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(60, '1PE', '1. Petrus', 60, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(61, '2PE', '2. Petrus', 61, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(62, '1JN', '1. Johannes', 62, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(63, '2JN', '2. Johannes', 63, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(64, '3JN', '3. Johannes', 64, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(65, 'JUD', 'Judas', 65, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(66, 'REV', 'Offenbarung', 66, 1, '2024-11-12 11:58:01', '2024-11-12 11:58:01'),
(67, 'GEN', '1 Mose/Genesis', 1, 3, '2024-11-12 11:58:33', '2024-11-12 11:58:33'),
(68, 'EXO', '2 Mose/Exodus', 2, 3, '2024-11-12 11:58:33', '2024-11-12 11:58:33'),
(69, 'LEV', '3 Mose/Levitikus', 3, 3, '2024-11-12 11:58:33', '2024-11-12 11:58:33'),
(70, 'NUM', '4 Mose/Numeri', 4, 3, '2024-11-12 11:58:33', '2024-11-12 11:58:33'),
(71, 'DEU', '5 Mose/Deuteronomium', 5, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(72, 'JOS', 'Josua', 6, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(73, 'JDG', 'Richter', 7, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(74, 'RUT', 'Rut', 8, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(75, '1SA', '1 Samuel', 9, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(76, '2SA', '2 Samuel', 10, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(77, '1KI', '1 Könige', 11, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(78, '2KI', '2 Könige', 12, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(79, '1CH', '1 Chronik', 13, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(80, '2CH', '2 Chronik', 14, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(81, 'EZR', 'Esra', 15, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(82, 'NEH', 'Nehemia', 16, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(83, 'EST', 'Ester', 17, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(84, 'JOB', 'Ijob', 18, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(85, 'PSA', 'Psalm', 19, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(86, 'PRO', 'Sprichwörter', 20, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(87, 'ECC', 'Kohelet/Prediger', 21, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(88, 'SNG', 'Hohelied', 22, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(89, 'ISA', 'Jesaja', 23, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(90, 'JER', 'Jeremia', 24, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(91, 'LAM', 'Klagelieder', 25, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(92, 'EZK', 'Ezechiël', 26, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(93, 'DAN', 'Daniel', 27, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(94, 'HOS', 'Hosea', 28, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(95, 'JOL', 'Joël', 29, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(96, 'AMO', 'Amos', 30, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(97, 'OBA', 'Obadja', 31, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(98, 'JON', 'Jona', 32, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(99, 'MIC', 'Micha', 33, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(100, 'NAM', 'Nahum', 34, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(101, 'HAB', 'Habakuk', 35, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(102, 'ZEP', 'Zefanja', 36, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(103, 'HAG', 'Haggai', 37, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(104, 'ZEC', 'Sacharja', 38, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(105, 'MAL', 'Maleachi', 39, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(106, 'TOB', 'Tobit', 40, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(107, 'JDT', 'Judit', 41, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(108, 'ESG', 'Ester, griechisch', 42, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(109, '1MA', '1 Makkabäer', 43, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(110, '2MA', '2 Makkabäer', 44, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(111, 'WIS', 'Weisheit', 45, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(112, 'SIR', 'Sirach', 46, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(113, 'BAR', 'Baruch', 47, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(114, 'LJE', 'Brief Jeremias', 48, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(115, 'DAG', 'Zusätze zu Daniel', 49, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(116, 'MAN', 'Gebet Manasses', 50, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(117, 'MAT', 'Matthäus', 51, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(118, 'MRK', 'Markus', 52, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(119, 'LUK', 'Lukas', 53, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(120, 'JHN', 'Johannes', 54, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(121, 'ACT', 'Apostelgeschichte', 55, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(122, 'ROM', 'Römer', 56, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(123, '1CO', '1 Korinther', 57, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(124, '2CO', '2 Korinther', 58, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(125, 'GAL', 'Galater', 59, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(126, 'EPH', 'Epheser', 60, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(127, 'PHP', 'Philipper', 61, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(128, 'COL', 'Kolosser', 62, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(129, '1TH', '1 Thessalonicher', 63, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(130, '2TH', '2 Thessalonicher', 64, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(131, '1TI', '1 Timotheus', 65, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(132, '2TI', '2 Timotheus', 66, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(133, 'TIT', 'Titus', 67, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(134, 'PHM', 'Philemon', 68, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(135, 'HEB', 'Hebräer', 69, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(136, 'JAS', 'Jakobus', 70, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(137, '1PE', '1 Petrus', 71, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(138, '2PE', '2 Petrus', 72, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(139, '1JN', '1 Johannes', 73, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(140, '2JN', '2 Johannes', 74, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(141, '3JN', '3 Johannes', 75, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(142, 'JUD', 'Judas', 76, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(143, 'REV', 'Offenbarung', 77, 3, '2024-11-12 11:58:34', '2024-11-12 11:58:34'),
(144, 'GEN', '1. Mose', 1, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(145, 'EXO', '2. Mose', 2, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(146, 'LEV', '3. Mose', 3, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(147, 'NUM', '4. Mose', 4, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(148, 'DEU', '5. Mose', 5, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(149, 'JOS', 'Josua', 6, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(150, 'JDG', 'Richter', 7, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(151, 'RUT', 'Ruth', 8, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(152, '1SA', '1. Samuel', 9, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(153, '2SA', '2. Samuel', 10, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(154, '1KI', '1. Könige', 11, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(155, '2KI', '2. Könige', 12, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(156, '1CH', '1. Chonik', 13, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(157, '2CH', '2. Chronik', 14, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(158, 'EZR', 'Esra', 15, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(159, 'NEH', 'Nehemia', 16, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(160, 'EST', 'Esther', 17, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(161, 'JOB', 'Hiob', 18, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(162, 'PSA', 'Psalmen', 19, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(163, 'PRO', 'Sprüche', 20, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(164, 'ECC', 'Prediger', 21, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(165, 'SNG', 'Hohelied', 22, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(166, 'ISA', 'Jesaja', 23, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(167, 'JER', 'Jeremia', 24, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(168, 'LAM', 'Klagelieder', 25, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(169, 'EZK', 'Hesekiel', 26, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(170, 'DAN', 'Daniel', 27, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(171, 'HOS', 'Hosea', 28, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(172, 'JOL', 'Joel', 29, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(173, 'AMO', 'Amos', 30, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(174, 'OBA', 'Obadja', 31, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(175, 'JON', 'Jona', 32, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(176, 'MIC', 'Micha', 33, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(177, 'NAM', 'Nahum', 34, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(178, 'HAB', 'Habakuk', 35, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(179, 'ZEP', 'Zephanja', 36, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(180, 'HAG', 'Haggai', 37, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(181, 'ZEC', 'Sacharja', 38, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(182, 'MAL', 'Maleachi', 39, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(183, 'MAT', 'Matthäus', 40, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(184, 'MRK', 'Markus', 41, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(185, 'LUK', 'Lukas', 42, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(186, 'JHN', 'Johannes', 43, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(187, 'ACT', 'Apostelgeschichte', 44, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(188, 'ROM', 'Römer', 45, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(189, '1CO', '1. Korinther', 46, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(190, '2CO', '2. Korinther', 47, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(191, 'GAL', 'Galater', 48, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(192, 'EPH', 'Epheser', 49, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(193, 'PHP', 'Philipper', 50, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(194, 'COL', 'Kolosser', 51, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(195, '1TH', '1. Thessalonicher', 52, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(196, '2TH', '2. Thessalonicher', 53, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(197, '1TI', '1. Timotheus', 54, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(198, '2TI', '2. Timotheus', 55, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(199, 'TIT', 'Titus', 56, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(200, 'PHM', 'Philemon', 57, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(201, 'HEB', 'Hebräer', 58, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(202, 'JAS', 'Jakobus', 59, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(203, '1PE', '1. Petrus', 60, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(204, '2PE', '2. Petrus', 61, 6, '2024-11-12 11:58:41', '2024-11-12 11:58:41'),
(205, '1JN', '1. Johannes', 62, 6, '2024-11-12 11:58:42', '2024-11-12 11:58:42'),
(206, '2JN', '2. Johannes', 63, 6, '2024-11-12 11:58:42', '2024-11-12 11:58:42'),
(207, '3JN', '3. Johannes', 64, 6, '2024-11-12 11:58:42', '2024-11-12 11:58:42'),
(208, 'JUD', 'Judas', 65, 6, '2024-11-12 11:58:42', '2024-11-12 11:58:42'),
(209, 'REV', 'Offenbarung', 66, 6, '2024-11-12 11:58:42', '2024-11-12 11:58:42');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bible_chapters`
--

DROP TABLE IF EXISTS `bible_chapters`;
CREATE TABLE IF NOT EXISTS `bible_chapters` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_id` varchar(191) NOT NULL,
  `number` varchar(191) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `bible_book_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bible_verses`
--

DROP TABLE IF EXISTS `bible_verses`;
CREATE TABLE IF NOT EXISTS `bible_verses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_id` varchar(191) NOT NULL,
  `number` varchar(191) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `bible_chapter_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bible_versions`
--

DROP TABLE IF EXISTS `bible_versions`;
CREATE TABLE IF NOT EXISTS `bible_versions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `api_id` varchar(191) NOT NULL,
  `name_local` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `bible_versions`
--

INSERT INTO `bible_versions` (`id`, `api_id`, `name_local`, `created_at`, `updated_at`) VALUES
(1, '9c11d46ebbfba585-01', 'BasisBibel', '2024-08-28 11:29:45', '2024-08-28 11:29:45'),
(3, 'fdefabd3e4554ee7-01', 'GNB Abfolge', '2024-08-28 11:29:45', '2024-08-28 11:29:45'),
(6, '926aa5efbc5e04e2-01', 'Lutherbibel 1912 mit Strongs', '2024-08-28 11:29:45', '2024-08-28 11:29:45');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content2_contents`
--

DROP TABLE IF EXISTS `content2_contents`;
CREATE TABLE IF NOT EXISTS `content2_contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `child_content_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content2_meta_fields`
--

DROP TABLE IF EXISTS `content2_meta_fields`;
CREATE TABLE IF NOT EXISTS `content2_meta_fields` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `content_meta_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` text DEFAULT NULL,
  `version_type` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `content2_meta_fields`
--

INSERT INTO `content2_meta_fields` (`id`, `content_id`, `content_meta_field_id`, `value`, `version_type`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '[\"Textauszug\"]', 0, '2024-12-02 09:32:16', '2024-12-03 13:54:43'),
(2, 1, 4, '[\"Vorschau\"]', 0, '2024-12-02 09:32:16', '2024-12-02 10:17:33'),
(3, 1, 6, '[\"12\",\"23\"]', 0, '2024-12-02 09:32:16', '2024-12-02 10:17:33'),
(4, 1, 8, '[\"34\",\"45\"]', 0, '2024-12-02 09:32:16', '2024-12-02 10:17:33'),
(5, 1, 10, '[\"\"]', 0, '2024-12-02 09:32:16', '2024-12-02 09:32:16'),
(6, 1, 11, '[\"\"]', 0, '2024-12-02 09:32:16', '2024-12-02 09:32:16'),
(7, 1, 12, '[[3]]', 0, '2024-12-02 09:32:16', '2024-12-02 10:20:40'),
(8, 1, 13, '[\"\"]', 0, '2024-12-02 09:32:16', '2024-12-02 09:32:16'),
(9, 1, 14, '[\"restricted\"]', 0, '2024-12-02 09:32:16', '2024-12-02 10:17:33'),
(10, 1, 15, '[\"2024-12-10\",\"10:00\"]', 0, '2024-12-02 09:32:16', '2024-12-03 14:14:01'),
(11, 1, 16, '[\"active\"]', 0, '2024-12-02 09:32:16', '2024-12-02 10:17:33'),
(12, 1, 17, '[[\"6\"]]', 0, '2024-12-02 09:32:16', '2024-12-04 09:27:58'),
(13, 1, 18, '[[\"1\"]]', 0, '2024-12-02 09:32:16', '2024-12-03 14:22:42'),
(14, 1, 19, '[[]]', 0, '2024-12-02 09:32:16', '2024-12-04 09:27:41'),
(15, 1, 20, '[\"3\"]', 0, '2024-12-02 09:32:16', '2024-12-04 06:23:46'),
(16, 1, 21, '[\"2024-12-26\"]', 0, '2024-12-03 12:13:33', '2024-12-04 08:20:06'),
(18, 2, 2, '[\"Titel 2\"]', 0, '2024-12-04 08:49:33', '2024-12-04 08:49:33'),
(17, 1, 2, '[\"Einheit 1\"]', 0, '2024-12-04 08:41:34', '2024-12-04 08:41:34'),
(19, 2, 19, '[\"\"]', 0, '2024-12-04 08:49:48', '2024-12-04 08:49:48'),
(20, 2, 3, '[\"Text\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(21, 2, 4, '[\"Vorschau\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(22, 2, 6, '[\"1\",\"2\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(23, 2, 8, '[\"1\",\"2\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(24, 2, 10, '[\"\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(25, 2, 11, '[\"\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(26, 2, 12, '[[1]]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(27, 2, 13, '[\"copyright\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(28, 2, 14, '[\"restricted\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(29, 2, 15, '[\"2024-12-05\",\"12:00\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(30, 2, 16, '[\"draft\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(31, 2, 17, '[[\"1\"]]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(32, 2, 18, '[[\"2\"]]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(33, 2, 20, '[\"3\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(34, 2, 21, '[\"2024-12-11\"]', 0, '2024-12-04 08:52:05', '2024-12-04 08:52:05'),
(35, 3, 2, '[\"Einheit 3\"]', 0, '2024-12-04 09:08:08', '2024-12-04 09:08:08'),
(36, 3, 19, '[\"\"]', 0, '2024-12-04 09:08:12', '2024-12-04 09:08:12');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content2_meta_fields_autosaves`
--

DROP TABLE IF EXISTS `content2_meta_fields_autosaves`;
CREATE TABLE IF NOT EXISTS `content2_meta_fields_autosaves` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autosave_version` tinyint(4) NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `content_meta_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` text DEFAULT NULL,
  `version_type` tinyint(4) NOT NULL DEFAULT 0,
  `sort` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contents`
--

DROP TABLE IF EXISTS `contents`;
CREATE TABLE IF NOT EXISTS `contents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('thema','einheit','element','konzept') DEFAULT NULL,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `editorial_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `contents`
--

INSERT INTO `contents` (`id`, `type`, `organisation_id`, `editorial_id`, `author_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 1, NULL, NULL, NULL),
(2, NULL, 1, 1, 1, NULL, NULL, NULL),
(3, NULL, 1, 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_groups`
--

DROP TABLE IF EXISTS `content_groups`;
CREATE TABLE IF NOT EXISTS `content_groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_has_content_groups`
--

DROP TABLE IF EXISTS `content_has_content_groups`;
CREATE TABLE IF NOT EXISTS `content_has_content_groups` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `content_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_has_group_categories`
--

DROP TABLE IF EXISTS `content_has_group_categories`;
CREATE TABLE IF NOT EXISTS `content_has_group_categories` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `group_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_has_organisation_categories`
--

DROP TABLE IF EXISTS `content_has_organisation_categories`;
CREATE TABLE IF NOT EXISTS `content_has_organisation_categories` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `organisation_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_has_rio_categories`
--

DROP TABLE IF EXISTS `content_has_rio_categories`;
CREATE TABLE IF NOT EXISTS `content_has_rio_categories` (
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `rio_category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_meta_fields`
--

DROP TABLE IF EXISTS `content_meta_fields`;
CREATE TABLE IF NOT EXISTS `content_meta_fields` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `title_field` tinyint(4) NOT NULL DEFAULT 0,
  `text_before_field` varchar(255) DEFAULT NULL,
  `text_after_field` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `required` varchar(191) NOT NULL DEFAULT '["0"]',
  `type` text NOT NULL,
  `data_source` text DEFAULT NULL,
  `css_class` varchar(255) NOT NULL,
  `code_to_insert` text DEFAULT NULL,
  `display` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `contribution_check` text DEFAULT NULL,
  `contribution_warnings` text DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `content_meta_fields`
--

INSERT INTO `content_meta_fields` (`id`, `label`, `title_field`, `text_before_field`, `text_after_field`, `description`, `required`, `type`, `data_source`, `css_class`, `code_to_insert`, `display`, `active`, `contribution_check`, `contribution_warnings`, `sort`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Einheitstyp', 0, NULL, NULL, NULL, '[1]', '[\"enum\"]', '[\"Thema\",\"Einheit\",\"Element\",\"Konzept\"]', 'flex_cell_100', NULL, 1, 1, '{\"required\":true}', NULL, 0, NULL, NULL, NULL),
(2, 'Titel', 1, NULL, NULL, NULL, '[1]', '[\"text\"]', NULL, 'flex_cell_100', NULL, 1, 1, '{\"required\":true}', NULL, 0, NULL, NULL, NULL),
(3, 'Textauszug', 0, '[\"Kurzbeschreibung/Inhaltsangabe: Bitte beschreibe den Inhalt deines Beitrags in ca. 150 Zeichen.\"]', NULL, NULL, '[1]', '[\"longtext\"]', NULL, 'flex_cell_100', 'metadata.content-preview', 4, 1, '{\"required\":true, \"min_length\":150, \"max_length\":350}', '{\"required\":\"Inhalt fehlt\",\"expected\":\"Warnung: min. Länge 150\",\"href\":\"content/#contentid#/content\"}', 0, NULL, NULL, NULL),
(4, 'Vorschautext', 0, '[\"Die Vorschau dient dem \\\"Probelesen\\\". Bitte kopiere ca. 12-15% des Textes in die Vorschau!<br>Dieser wird als Klartext im Artikel angezeigt, solange dieser noch nicht gekauft wurde.\"]', NULL, NULL, '[1]', '[\"longtext\"]', NULL, 'flex_cell_100', 'metadata.content-preview', 4, 1, '{\"required\":true, \"min_length_percent\":12, \"max_length_percent\":15}', '{\"required\":\"Vorschautext fehlt\",\"expected\":\"Warnung min. Länge 12%, max Länge 15 vom Text\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(5, 'exzerpt', 0, NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, 'flex_cell_100', NULL, 4, 0, NULL, NULL, 0, NULL, NULL, NULL),
(6, 'Zeitaufwand Vorbereitung', 0, '[\"Ca.\", \"bis\"]', NULL, NULL, '[1,0]', '[\"unsigned_integer\", \"unsigned_integer\"]', NULL, 'flex_cell_25', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(8, 'Dauer Durchführung', 0, '[\"Ca.\", \"bis\"]', NULL, NULL, '[1,0]', '[\"unsigned_integer\", \"unsigned_integer\"]', NULL, 'flex_cell_25', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(10, 'Bezug zur Hauptbibelstelle', 0, '[\"Suche nach der passenden Bibelstelle zu deinem Eintrag.\"]', NULL, NULL, '[0]', '[\"livewire\"]', NULL, 'flex_cell_100 flex_column', 'metadata.bible-main-passage', 4, 1, '{\"expected\":true}', '{\"expected\":\"eine Bibelstelle erwartet\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(11, 'additional_bible_passages', 0, NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, 'flex_cell_100', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(12, 'Medienform', 0, NULL, NULL, NULL, '[0]', '[\"livewire\"]', NULL, 'flex_cell_100', 'metadata.badge-selection', 4, 1, '{\"required\":true, \"min\":1,\"max\":1}', '{\"required\":\"Medientype angeben\",\"expected\":\"bitte 1 Medientype angeben\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(13, 'Copyrights', 0, NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, '', NULL, 4, 1, '{\"expected\":true}', '{\"expected\":\"Copyrightinfo fehlt\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(14, 'visibility', 0, NULL, NULL, NULL, '[0]', '[\"enum\"]', '[\"free\",\"restricted\"]', '', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(15, 'visibility_date', 0, NULL, NULL, NULL, '[0]', '[\"date\", \"time\"]', NULL, '', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(16, 'status', 0, NULL, NULL, NULL, '[0]', '[\"enum\"]', '[\"draft\",\"for_correction\",\"corrected\",\"active\"]', '', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(17, 'Thema', 0, NULL, NULL, NULL, '[1]', '[\"livewire\"]', NULL, 'flex_cell_33', 'metadata.topic-selection', 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(18, 'Zielgruppen', 0, NULL, NULL, NULL, '[1]', '[\"livewire\"]', NULL, 'flex_cell_33', 'metadata.target-group-selection', 4, 1, '{\"required\":true,\"min\":1,\"max\":3}', '{\"required\":\"Zielgruppe angeben\",\"expected\":\"min 1, max 3 Gruppe angeben\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(19, 'Materialart', 0, NULL, NULL, NULL, '[1]', '[\"livewire\"]', NULL, 'flex_cell_33', 'metadata.autocomplete-deep-search', 3, 1, '{\"required\":true,\"min\":1,\"max\":1}', '{\"required\":\"Materie angeben\",\"expected\":\"bitte 1 Materialart wählen\",\"href\":\"content/#contentid#/properties\"}', 0, NULL, NULL, NULL),
(20, 'Beitragsbild', 0, '[\"Wähle ein Beitragsbild für deine Einheit aus.\"]', NULL, NULL, '[0]', '[\"image\"]', NULL, 'flex_cell_100 flex_column', NULL, 4, 1, NULL, NULL, 0, NULL, NULL, NULL),
(21, 'Wiedervorlage', 0, NULL, NULL, NULL, '[\"0\"]', '[\"date\"]', NULL, 'flex_cell_33', NULL, 4, 1, NULL, NULL, 30, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contracts`
--

DROP TABLE IF EXISTS `contracts`;
CREATE TABLE IF NOT EXISTS `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `status` enum('draft','active') DEFAULT NULL,
  `contract` longtext DEFAULT NULL,
  `representative_name` varchar(250) DEFAULT NULL,
  `representative_sing_image` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `editorials`
--

DROP TABLE IF EXISTS `editorials`;
CREATE TABLE IF NOT EXISTS `editorials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(80) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` varchar(250) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `logo_for_light_bg` varchar(500) DEFAULT NULL,
  `logo_for_dark_bg` varchar(500) DEFAULT NULL,
  `cd_colors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cd_colors`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `editorials`
--

INSERT INTO `editorials` (`id`, `organisation_id`, `title`, `description`, `short_description`, `logo`, `logo_for_light_bg`, `logo_for_dark_bg`, `cd_colors`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Redaktion 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-22 11:56:18', '2024-11-22 11:56:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `editorial_has_content_groups`
--

DROP TABLE IF EXISTS `editorial_has_content_groups`;
CREATE TABLE IF NOT EXISTS `editorial_has_content_groups` (
  `editorial_id` bigint(20) UNSIGNED NOT NULL,
  `content_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `editorial_members`
--

DROP TABLE IF EXISTS `editorial_members`;
CREATE TABLE IF NOT EXISTS `editorial_members` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `editorial_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('guest','author','corrector','editor','administrator') DEFAULT NULL,
  `status` enum('invited','active') DEFAULT NULL,
  `invitation_code` varchar(150) DEFAULT NULL,
  `invitation_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `editorial_members`
--

INSERT INTO `editorial_members` (`id`, `user_id`, `editorial_id`, `role`, `status`, `invitation_code`, `invitation_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `group_categories`
--

DROP TABLE IF EXISTS `group_categories`;
CREATE TABLE IF NOT EXISTS `group_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `content_group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE IF NOT EXISTS `materials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `material_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `materials`
--

INSERT INTO `materials` (`id`, `name`, `material_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Material 1', 3, NULL, NULL, NULL),
(2, 'Datenschutz', 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `material_types`
--

DROP TABLE IF EXISTS `material_types`;
CREATE TABLE IF NOT EXISTS `material_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Materialtyp 1', NULL, NULL, NULL),
(2, 'Materialtyp 1_1', 1, NULL, NULL),
(3, 'Materialtyp 1_1_1', 2, NULL, NULL),
(4, 'Hintergrundartikel', NULL, NULL, NULL),
(5, 'Rechtliches', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mediapools`
--

DROP TABLE IF EXISTS `mediapools`;
CREATE TABLE IF NOT EXISTS `mediapools` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mediapool_category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(510) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `uploaded_to` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `mediapools`
--

INSERT INTO `mediapools` (`id`, `mediapool_category_id`, `user_id`, `filename`, `label`, `author`, `uploaded_to`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'Bild (2).png', NULL, NULL, NULL, '2024-12-03 07:17:53', '2024-12-03 07:17:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mediapool_categories`
--

DROP TABLE IF EXISTS `mediapool_categories`;
CREATE TABLE IF NOT EXISTS `mediapool_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL,
  `organisation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `source` enum('protected','public') NOT NULL DEFAULT 'protected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `mediapool_categories`
--

INSERT INTO `mediapool_categories` (`id`, `parent_id`, `organisation_id`, `name`, `source`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'root', 'public', '2024-11-22 11:55:51', '2024-11-22 11:55:51'),
(2, NULL, 1, '', 'protected', '2024-11-22 11:56:06', '2024-11-22 11:56:06'),
(3, NULL, 2, '', 'protected', '2024-12-02 10:02:48', '2024-12-02 10:02:48');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `media_types`
--

DROP TABLE IF EXISTS `media_types`;
CREATE TABLE IF NOT EXISTS `media_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `media_types`
--

INSERT INTO `media_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Audio und Podcast', NULL, NULL, NULL),
(2, 'Video und Film', NULL, NULL, NULL),
(3, 'Bild und Grafik', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_05_21_100000_create_teams_table', 1),
(7, '2020_05_21_200000_create_team_user_table', 1),
(8, '2020_05_21_300000_create_team_invitations_table', 1),
(9, '2024_02_28_091556_create_uservalues_table', 1),
(10, '2024_02_28_105210_create_usersites_table', 1),
(11, '2024_02_28_105233_create_siteblocks_table', 1),
(12, '2024_03_01_084935_create_userroles_table', 1),
(13, '2024_03_01_090913_create_user2roles_table', 1),
(14, '2024_03_19_132336_create_organisations_table', 1),
(15, '2024_05_03_144033_create_mediapools_table', 1),
(16, '2024_05_03_144554_create_mediapool_categories_table', 1),
(17, '2024_05_15_085258_create_contents_table', 1),
(18, '2024_07_18_141708_create_contracts_table', 1),
(19, '2024_07_18_142312_create_author_contracts_table', 1),
(20, '2024_08_08_061701_create_content_groups_table', 1),
(21, '2024_08_08_061701_create_editorials_table', 1),
(22, '2024_08_08_061701_create_group_categories_table', 1),
(23, '2024_08_08_061701_create_organisation_categories_table', 1),
(24, '2024_08_08_061701_create_rio_categories_table', 1),
(25, '2024_08_08_062206_create_editorial_members_table', 1),
(26, '2024_08_08_062312_create_content_has_rio_categories_table', 1),
(27, '2024_08_08_062359_create_content_has_organisation_categories_table', 1),
(28, '2024_08_08_062457_create_editorial_has_content_groups_table', 1),
(29, '2024_08_08_062520_create_content_has_content_groups_table', 1),
(30, '2024_08_08_073326_create_content_has_group_categories_table', 1),
(31, '2024_08_21_063536_create_bible_versions_table', 1),
(32, '2024_08_21_065635_create_bible_books_table', 1),
(33, '2024_08_21_093011_create_bible_chapters_table', 1),
(34, '2024_08_23_135328_create_bible_verses_table', 1),
(35, '2024_10_28_124916_create_material_types_table', 1),
(36, '2024_11_13_091449_create_materials_table', 1),
(37, '2024_11_13_092337_create_topics_table', 1),
(38, '2024_11_13_131446_create_content_meta_fields_table', 1),
(39, '2024_11_13_133758_create_content2_meta_fields_table', 1),
(40, '2024_11_13_144511_create_topic_types_table', 1),
(41, '2024_11_13_145627_create_target_groups_table', 1),
(42, '2024_11_13_150013_create_target_group_types_table', 1),
(43, '2024_11_15_172427_create_siteblocks_autosaves_table', 1),
(44, '2024_11_19_092941_create_media_types_table', 1),
(47, '2024_11_20_152230_create_content2_meta_fields_autosaves_table', 2),
(46, '2024_11_20_153231_create_content2_contents_table', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `organisations`
--

DROP TABLE IF EXISTS `organisations`;
CREATE TABLE IF NOT EXISTS `organisations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `short_title` varchar(45) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `logo_for_light_bg` varchar(500) DEFAULT NULL,
  `logo_for_dark_bg` varchar(500) DEFAULT NULL,
  `cd_colors` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `organisations`
--

INSERT INTO `organisations` (`id`, `team_id`, `title`, `short_title`, `street`, `zip`, `city`, `country`, `email`, `website`, `logo`, `logo_for_light_bg`, `logo_for_dark_bg`, `cd_colors`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Verband 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-22 11:56:06', '2024-11-22 11:56:06'),
(2, 1, 'Verband 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-02 10:02:48', '2024-12-02 10:02:48');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `organisation_categories`
--

DROP TABLE IF EXISTS `organisation_categories`;
CREATE TABLE IF NOT EXISTS `organisation_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rio_categories`
--

DROP TABLE IF EXISTS `rio_categories`;
CREATE TABLE IF NOT EXISTS `rio_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `parent` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0WV6m75FKuoheaREB6ldWeFvD8C2tdYkXACKhGjH', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoienNNbTdGWnJNUVNiWEhMZkcyajhKYlNJa3VsSWE2cGozRWgwaWhZNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIwOiJzaWRlTmF2aWdhdGlvblN0YXR1cyI7czo2OiJvcGVuZWQiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vcmlvLmxvY2FsL2NvbnRlbnQvMi9zZXR0aW5ncyI7fX0=', 1733496204),
('abAjLCuMDOLWenE1zZx2Dfquk4GvqeWGvcC86VgA', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUXlsT3pLM2h5N3QxTFF5YjJIdHA2cHRINXh4enZXbE8wUVRBNlIyUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9yaW8ubG9jYWwvbG9jYWwtYXV0aCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjA6InNpZGVOYXZpZ2F0aW9uU3RhdHVzIjtzOjY6Im9wZW5lZCI7fQ==', 1733316439),
('fV75FyG6UIFiGmFUHB6wv7REJD88MtG9KicRITCC', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRXY4VlVzaXQ5ZzBpbXBpQ3poN0hQSXllT1hHZ0lMYUMzWWlyWnJ6YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1733324930);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `siteblocks`
--

DROP TABLE IF EXISTS `siteblocks`;
CREATE TABLE IF NOT EXISTS `siteblocks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usersite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` longtext NOT NULL,
  `tag` varchar(50) NOT NULL DEFAULT '',
  `attribs` text NOT NULL,
  `editor_id` varchar(100) NOT NULL DEFAULT '',
  `editor_attribs` text NOT NULL,
  `sort` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `version_number` tinyint(4) NOT NULL DEFAULT 0,
  `version_type` tinyint(4) NOT NULL DEFAULT 0,
  `template` tinyint(4) NOT NULL DEFAULT 0,
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `siteblocks_autosaves`
--

DROP TABLE IF EXISTS `siteblocks_autosaves`;
CREATE TABLE IF NOT EXISTS `siteblocks_autosaves` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autosave_version` tinyint(4) NOT NULL DEFAULT 0,
  `siteblock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `usersite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` longtext NOT NULL,
  `tag` varchar(50) NOT NULL DEFAULT '',
  `attribs` text NOT NULL,
  `editor_id` varchar(100) NOT NULL DEFAULT '',
  `editor_attribs` text NOT NULL,
  `sort` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `version_number` tinyint(4) NOT NULL DEFAULT 0,
  `version_type` tinyint(4) NOT NULL DEFAULT 0,
  `template` tinyint(4) NOT NULL DEFAULT 0,
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `target_groups`
--

DROP TABLE IF EXISTS `target_groups`;
CREATE TABLE IF NOT EXISTS `target_groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `target_group_type_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `target_groups`
--

INSERT INTO `target_groups` (`id`, `name`, `target_group_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Zielgruppe 1', 1, NULL, NULL, NULL),
(2, 'Zielgruppe 2', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `target_group_types`
--

DROP TABLE IF EXISTS `target_group_types`;
CREATE TABLE IF NOT EXISTS `target_group_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `target_group_types`
--

INSERT INTO `target_group_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Zielgruppentyp 1', NULL, NULL, NULL),
(2, 'Zielgruppentyp 2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team_invitations`
--

DROP TABLE IF EXISTS `team_invitations`;
CREATE TABLE IF NOT EXISTS `team_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team_user`
--

DROP TABLE IF EXISTS `team_user`;
CREATE TABLE IF NOT EXISTS `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `topic_type_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `topics`
--

INSERT INTO `topics` (`id`, `name`, `topic_type_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Thema 1a', 1, NULL, NULL, NULL),
(2, 'Thema 1b', 1, NULL, NULL, NULL),
(3, 'Thema 1c', 1, NULL, NULL, NULL),
(4, 'Thema 2a', 2, NULL, NULL, NULL),
(5, 'Thema 2b', 2, NULL, NULL, NULL),
(6, 'Thema 2c', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topic_types`
--

DROP TABLE IF EXISTS `topic_types`;
CREATE TABLE IF NOT EXISTS `topic_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `topic_types`
--

INSERT INTO `topic_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Thementyp 1', NULL, NULL, NULL),
(2, 'Thementyp 2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user2roles`
--

DROP TABLE IF EXISTS `user2roles`;
CREATE TABLE IF NOT EXISTS `user2roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `userrole_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userroles`
--

DROP TABLE IF EXISTS `userroles`;
CREATE TABLE IF NOT EXISTS `userroles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `keycloak_id` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_keycloak_id_unique` (`keycloak_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `keycloak_id`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test@example.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usersites`
--

DROP TABLE IF EXISTS `usersites`;
CREATE TABLE IF NOT EXISTS `usersites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'new site',
  `url` varchar(1000) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `parentid` bigint(20) DEFAULT NULL,
  `ordernr` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `uservalues`
--

DROP TABLE IF EXISTS `uservalues`;
CREATE TABLE IF NOT EXISTS `uservalues` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `country` varchar(2) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uservalues_user_id_unique` (`user_id`),
  UNIQUE KEY `uservalues_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
