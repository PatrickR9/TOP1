-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 14. Nov 2024 um 07:21
-- Server-Version: 10.10.2-MariaDB
-- PHP-Version: 8.2.0

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `rio-dev`
--

--
-- Daten für Tabelle `content_meta_fields`
--

INSERT INTO `content_meta_fields` (`id`, `label`, `text_before_field`, `text_after_field`, `description`, `required`, `type`, `data_source`, `css_class`, `code_to_insert`, `active`, `contribution_check`, `contribution_warnings`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Einheitstyp', NULL, NULL, NULL, '[1]', '[\"enum\"]', '\'Thema\',\'Einheit\',\'Element\',\'Konzept\'', 'flex_cell_100', NULL, 1, '{\"required\":true}', NULL, NULL, NULL, NULL),
(2, 'Titel', NULL, NULL, NULL, '[1]', '[\"text\"]', NULL, 'flex_cell_100', NULL, 1, '{\"required\":true}', NULL, NULL, NULL, NULL),
(3, 'Textauszug', '[\"Kurzbeschreibung/Inhaltsangabe: Bitte beschreibe den Inhalt deines Beitrags in min. 150 Zeichen.\"]', NULL, NULL, '[1]', '[\"longtext\"]', NULL, 'flex_cell_100', NULL, 1, '{\"required\":true, \"min_length\":150, \"max_length\":350}', '{\"required\":\"Inhalt fehlt\",\"expected\":\"Warnung: min. Länge 150\",\"href\":\"content/#contentid#/content\"}', NULL, NULL, NULL),
(4, 'Vorschautext', '[\"Die Vorschau dient dem \\\"Probelesen\\\". Bitte kopiere ca. 12-15% des Textes in die Vorschau!\r\nDieser wird als Klartext im Artikel angezeigt, solange dieser noch nicht gekauft wurde.\"]', NULL, NULL, '[1]', '[\"text\"]', NULL, 'flex_cell_100', NULL, 1, '{\"required\":true, \"min_length_percent\":12, \"max_length_percent\":15}', '{\"required\":\"Vorschautext fehlt\",\"expected\":\"Warnung min. Länge 12%, max Länge 15 vom Text\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL),
(5, 'exzerpt', NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, 'flex_cell_100', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'Zeitaufwand Vorbereitung', '[\"Ca.\",\"bis\"]', NULL, NULL, '[1,0]', '[\"unsigned_integer\",\"unsigned_integer\"]', NULL, 'flex_cell_25', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(8, 'Dauer Durchführung', '[\"Ca.\".\"bis\"]', NULL, NULL, '[1,0]', '[\"unsigned_integer\",\"unsigned_integer\"]', NULL, 'flex_cell_25', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(10, 'Bezug zur Hauptbibelstelle', NULL, NULL, NULL, '[0]', '[\"bible_passage\"]', NULL, 'flex_cell_100', NULL, 1, '{\"expected\":true}', '{\"expected\":\"eine Bibelstelle erwartet\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL),
(11, 'additional_bible_passages', NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, 'flex_cell_100', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(12, 'Medienform', NULL, NULL, NULL, '[0]', '[\"media\"]', NULL, 'flex_cell_100', NULL, 1, '{\"required\":true, \"min\":1,\"max\":1}', '{\"required\":\"Medientype angeben\",\"expected\":\"bitte 1 Medientype angeben\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL),
(13, 'Copyrights', NULL, NULL, NULL, '[0]', '[\"longtext\"]', NULL, '', NULL, 1, '{\"expected\":true}', '{\"expected\":\"Copyrightinfo fehlt\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL),
(14, 'visibility', NULL, NULL, NULL, '[0]', '[\"enum\"]', '\'free\',\'restricted\'', '', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(15, 'visibility_date', NULL, NULL, NULL, '[0]', '[\"datetime\"]', NULL, '', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(16, 'status', NULL, NULL, NULL, '[0]', '[\"enum\"]', '\'draft\',\'for_correction\',\'corrected\',\'active\'', '', NULL, 1, NULL, NULL, NULL, NULL, NULL),
(17, 'Thema', NULL, NULL, NULL, '[1]', '[\"theme_component\"]', NULL, 'flex_cell_33', NULL, 0, NULL, NULL, NULL, NULL, NULL),
(18, 'Zielgruppen', NULL, NULL, NULL, '[1]', '[\"target_group_component\"]', NULL, 'flex_cell_33', NULL, 0, '{\"required\":true,\"min\":1,\"max\":3}', '{\"required\":\"Zielgruppe angeben\",\"expected\":\"min 1, max 3 Gruppe angeben\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL),
(19, 'Materialart', NULL, NULL, NULL, '[1]', '[\"material_component\"]', NULL, 'flex_cell_100', NULL, 0, '{\"required\":true,\"min\":1,\"max\":1}', '{\"required\":\"Materie angeben\",\"expected\":\"bitte 1 Materialart wählen\",\"href\":\"content/#contentid#/properties\"}', NULL, NULL, NULL);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
