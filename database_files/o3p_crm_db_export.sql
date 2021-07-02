-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2020 at 07:18 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `o3p_crm`
--
CREATE DATABASE IF NOT EXISTS `o3p_crm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `o3p_crm`;

-- --------------------------------------------------------

--
-- Table structure for table `adrese`
--

CREATE TABLE IF NOT EXISTS `adrese` (
  `adresa_id` int NOT NULL AUTO_INCREMENT,
  `naziv_ulice` varchar(45) DEFAULT NULL,
  `ulicni_broj` varchar(20) NOT NULL,
  `grad_naselje` varchar(45) NOT NULL,
  `drzava` varchar(45) NOT NULL,
  `postanski_broj` varchar(45) NOT NULL,
  PRIMARY KEY (`adresa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `akcije_azuriranja`
--

CREATE TABLE IF NOT EXISTS `akcije_azuriranja` (
  `korisnicka_akcija_id` int NOT NULL,
  `naziv_atributa` varchar(45) NOT NULL,
  `stara_vrijednost` varchar(255) NOT NULL,
  `nova_vrijednost` varchar(45) NOT NULL,
  `datum_vrijeme` timestamp(3) NOT NULL,
  `detalji` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`korisnicka_akcija_id`),
  KEY `fk_akcije_azuriranja_korisnici_korisnicke_akcije1_idx` (`korisnicka_akcija_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE IF NOT EXISTS `korisnici` (
  `korisnik_id` int NOT NULL,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `oib` char(11) NOT NULL,
  `datum_rodenja` date NOT NULL,
  `spol_flag` char(1) NOT NULL,
  `mobilni_telefon` varchar(45) DEFAULT NULL,
  `fiksni_telefon` varchar(45) DEFAULT NULL,
  `zanimanje` varchar(45) DEFAULT NULL,
  `bracni_status_flag` char(1) DEFAULT NULL,
  `prima_obavijesti_flag` char(1) DEFAULT NULL,
  `zeli_aktivno_sudjelovati_flag` char(1) DEFAULT NULL,
  `potvrdeno_clanstvo_flag` char(1) DEFAULT NULL,
  `korisnicko_ime` varchar(45) DEFAULT NULL,
  `lozinka_sol` varchar(45) DEFAULT NULL,
  `lozinka_SHA256` varchar(65) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `adrese_adresa_id` int NOT NULL,
  `razine_obrazovanja_razina_obrazovanja_id` int NOT NULL,
  `uloge_uloga_id` int NOT NULL,
  `korisnici_roditelj_1` int NOT NULL,
  `korisnici_roditelj_2` int NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  UNIQUE KEY `oib_UNIQUE` (`oib`),
  UNIQUE KEY `korisnicko_ime_UNIQUE` (`korisnicko_ime`),
  KEY `fk_korisnici_adrese_idx` (`adrese_adresa_id`),
  KEY `fk_korisnici_razine_obrazovanja1_idx` (`razine_obrazovanja_razina_obrazovanja_id`),
  KEY `fk_korisnici_uloge1_idx` (`uloge_uloga_id`),
  KEY `fk_korisnici_korisnici1_idx` (`korisnici_roditelj_1`),
  KEY `fk_korisnici_korisnici1_idx1` (`korisnici_roditelj_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici_korisnicke_akcije`
--

CREATE TABLE IF NOT EXISTS `korisnici_korisnicke_akcije` (
  `korisnicka_akcija_id` int NOT NULL AUTO_INCREMENT,
  `detalji` varchar(255) DEFAULT NULL,
  `datum_vrijeme` timestamp(3) NOT NULL,
  `vrsta_korisnicke_akcije_id` int NOT NULL,
  `korisnici_korisnik_id` int NOT NULL,
  PRIMARY KEY (`korisnicka_akcija_id`),
  KEY `fk_korisnici_korisnicke_akcije_vrste_korisnickih_akcija1_idx` (`vrsta_korisnicke_akcije_id`),
  KEY `fk_korisnici_korisnicke_akcije_korisnici1_idx` (`korisnici_korisnik_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `razine_obrazovanja`
--

CREATE TABLE IF NOT EXISTS `razine_obrazovanja` (
  `razina_obrazovanja_id` int NOT NULL AUTO_INCREMENT,
  `razina_obrazovanja_opis` varchar(45) NOT NULL,
  PRIMARY KEY (`razina_obrazovanja_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `razine_obrazovanja`
--

INSERT INTO `razine_obrazovanja` (`razina_obrazovanja_id`, `razina_obrazovanja_opis`) VALUES
(1, 'osnovna škola'),
(2, 'srednja škola'),
(3, 'viša stručna sprema / bakalaureat (BA)'),
(4, 'visoka stručna sprema / magistar struke (MA)'),
(5, 'poslijediplomski specijalistički studij'),
(6, 'magisterij znanosti (mr. sc.)'),
(7, 'doktorat znanosti (dr. sc.)');

-- --------------------------------------------------------

--
-- Table structure for table `uloge`
--

CREATE TABLE IF NOT EXISTS `uloge` (
  `uloga_id` int NOT NULL AUTO_INCREMENT,
  `uloga_opis` varchar(45) NOT NULL,
  PRIMARY KEY (`uloga_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uloge`
--

INSERT INTO `uloge` (`uloga_id`, `uloga_opis`) VALUES
(1, 'roditelj'),
(2, 'dijete'),
(3, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `vrste_korisnickih_akcija`
--

CREATE TABLE IF NOT EXISTS `vrste_korisnickih_akcija` (
  `vrsta_korisnicke_akcije` int NOT NULL AUTO_INCREMENT,
  `opis_korisnicke_akcije` varchar(45) NOT NULL,
  PRIMARY KEY (`vrsta_korisnicke_akcije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akcije_azuriranja`
--
ALTER TABLE `akcije_azuriranja`
  ADD CONSTRAINT `fk_akcije_azuriranja_korisnici_korisnicke_akcije1` FOREIGN KEY (`korisnicka_akcija_id`) REFERENCES `korisnici_korisnicke_akcije` (`korisnicka_akcija_id`);

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `fk_korisnici_adrese` FOREIGN KEY (`adrese_adresa_id`) REFERENCES `adrese` (`adresa_id`),
  ADD CONSTRAINT `fk_korisnici_korisnici_rod1` FOREIGN KEY (`korisnici_roditelj_1`) REFERENCES `korisnici` (`korisnik_id`),
  ADD CONSTRAINT `fk_korisnici_korisnici_rod2` FOREIGN KEY (`korisnici_roditelj_2`) REFERENCES `korisnici` (`korisnik_id`),
  ADD CONSTRAINT `fk_korisnici_razine_obrazovanja1` FOREIGN KEY (`razine_obrazovanja_razina_obrazovanja_id`) REFERENCES `razine_obrazovanja` (`razina_obrazovanja_id`),
  ADD CONSTRAINT `fk_korisnici_uloge1` FOREIGN KEY (`uloge_uloga_id`) REFERENCES `uloge` (`uloga_id`);

--
-- Constraints for table `korisnici_korisnicke_akcije`
--
ALTER TABLE `korisnici_korisnicke_akcije`
  ADD CONSTRAINT `fk_korisnici_korisnicke_akcije_korisnici1` FOREIGN KEY (`korisnici_korisnik_id`) REFERENCES `korisnici` (`korisnik_id`),
  ADD CONSTRAINT `fk_korisnici_korisnicke_akcije_vrste_korisnickih_akcija1` FOREIGN KEY (`vrsta_korisnicke_akcije_id`) REFERENCES `vrste_korisnickih_akcija` (`vrsta_korisnicke_akcije`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
