-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql24j10.db.hostpoint.internal
-- Erstellungszeit: 21. Dez 2024 um 11:22
-- Server-Version: 10.6.19-MariaDB-log
-- PHP-Version: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `flawasch_iot`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `configname` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `app_id` text NOT NULL,
  `dev_id` text NOT NULL,
  `ttn_timestamp` text NOT NULL,
  `gtw_id` text NOT NULL,
  `gtw_rssi` float NOT NULL,
  `gtw_snr` float NOT NULL,
  `dev_raw_payload` text NOT NULL,
  `dev_value_1` float NOT NULL,
  `dev_value_2` float DEFAULT NULL,
  `dev_value_3` float DEFAULT NULL,
  `dev_value_4` float NOT NULL,
  `dev_value_5` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `data_openmeteo`
--

CREATE TABLE `data_openmeteo` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `temperature` int(11) NOT NULL,
  `humidity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sensor`
--

CREATE TABLE `sensor` (
  `id` int(11) NOT NULL,
  `dev_id` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dev_place` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dev_type` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dev_brand` text NOT NULL,
  `dev_model` text NOT NULL,
  `value_1` text NOT NULL,
  `value_1_name` text NOT NULL,
  `value_2` text NOT NULL,
  `value_2_name` text NOT NULL,
  `value_3` text NOT NULL,
  `value_3_name` text NOT NULL,
  `value_5` text NOT NULL,
  `value_5_name` text NOT NULL,
  `displayWeather` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `data_openmeteo`
--
ALTER TABLE `data_openmeteo`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dev_id` (`dev_id`) USING HASH;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `data_openmeteo`
--
ALTER TABLE `data_openmeteo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sensor`
--
ALTER TABLE `sensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
