-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 09, 2021 at 11:48 AM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 7.2.25-1+0~20191128.32+debian8~1.gbp108445

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WebDiP2020x060`
--

-- --------------------------------------------------------

--
-- Table structure for table `cesta`
--

CREATE TABLE `cesta` (
  `ID_cesta` int(11) NOT NULL,
  `oznaka` varchar(15) NOT NULL,
  `pocetak_dionice` varchar(45) NOT NULL,
  `zavrsetak_dionice` varchar(45) NOT NULL,
  `broj_kilometara` double NOT NULL,
  `stanje` varchar(15) NOT NULL,
  `ID_kategorija` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cesta`
--

INSERT INTO `cesta` (`ID_cesta`, `oznaka`, `pocetak_dionice`, `zavrsetak_dionice`, `broj_kilometara`, `stanje`, `ID_kategorija`) VALUES
(1, 'A2', 'Macelj', 'Zagreb', 60, 'otvorena', 1),
(2, 'A4', 'Goričan', 'Zagreb', 96.9, 'otvorena', 1),
(3, 'A3', 'Bregana', 'Lipovac', 306.4, 'zatvorena', 1),
(4, 'D1', 'Macelj', 'Split', 418.6, 'zatvorena', 2),
(5, 'D20', 'Čakovec', 'Koprivnica', 50.4, 'otvorena', 2),
(6, 'D36', 'Karlovac', 'Popovača', 110.5, 'otvorena', 2),
(7, '2022', 'Belica', 'Orehovica', 2.8, 'otvorena', 3),
(8, '2054', 'Šemovec', 'Tuhovec', 12.03, 'otvorena', 3),
(9, '2065', 'Tužno', 'Pece', 5.04, 'zatvorena', 3),
(10, '25195', 'Petrijanec', 'Hraščica', 6.79, 'otvorena', 4),
(11, '25014', 'Osonjak', 'Vrbno', 1.61, 'zatvorena', 4),
(23, 'A1', 'Zagreb', 'Dubrovnik', 480.15, 'otvorena', 1),
(24, '30303', 'Kučan Marof', 'Zbelava', 5.04, 'otvorena', 4),
(25, '2029', 'Varaždin', 'Sračinec', 7.09, 'otvorena', 3);

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik_rada`
--

CREATE TABLE `dnevnik_rada` (
  `ID_dnevnik` int(11) NOT NULL,
  `radnja` text NOT NULL,
  `sql_upit` text,
  `datum_vrijeme_aktivnosti` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_korisnik` int(11) DEFAULT NULL,
  `ID_tip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dnevnik_rada`
--

INSERT INTO `dnevnik_rada` (`ID_dnevnik`, `radnja`, `sql_upit`, `datum_vrijeme_aktivnosti`, `ID_korisnik`, `ID_tip`) VALUES
(1148, '/WebDiP/2020_projekti/WebDiP2020x060/statistika.php', ' ', '2021-06-08 19:21:30', 1, 3),
(1149, '/WebDiP/2020_projekti/WebDiP2020x060/statistika.php', ' ', '2021-06-08 19:22:15', 1, 3),
(1150, '/WebDiP/2020_projekti/WebDiP2020x060/statistika.php', ' ', '2021-06-08 19:22:27', 1, 3),
(1151, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:22:42', 1, 1),
(1152, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:22:42', 1, 1),
(1153, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:23:04', 6, 3),
(1154, '/WebDiP/2020_projekti/WebDiP2020x060/privatno/korisnici.php', ' ', '2021-06-08 19:23:10', 6, 3),
(1155, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:23:12', 6, 3),
(1156, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:23:14', 6, 3),
(1157, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php?pocetak=Macelj&zavrsetak=Zagreb&submit=Pretra%C5%BEi', 'SELECT oznaka, broj_kilometara FROM cesta WHERE `pocetak_dionice`=\'Macelj\' AND `zavrsetak_dionice`=\'Zagreb\' AND`stanje`=\'otvorena\'', '2021-06-08 19:23:22', 6, 2),
(1158, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:24:04', 6, 3),
(1159, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php?iddolazak=7&obrisi=Obrisi+obilazak', 'DELETE FROM obilazak WHERE obilazak_ID = 7', '2021-06-08 19:24:31', 6, 2),
(1160, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:24:34', 6, 3),
(1161, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:25:38', 6, 3),
(1162, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', 'INSERT INTO dokument (naziv_dokumenta, vrsta_dokumenta, status, ID_korisnik, ID_cesta) VALUES(\'Promet.pdf\',\'application/pdf\',\'nije potvrđeno\',6,23);', '2021-06-08 19:25:38', 6, 2),
(1163, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:25:39', 6, 3),
(1164, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:25:48', 6, 1),
(1165, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:25:48', 6, 1),
(1166, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:25:49', 2, 3),
(1167, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:26:28', 2, 3),
(1168, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:26:57', 2, 3),
(1169, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:26:59', 2, 3),
(1170, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:27:05', 2, 3),
(1171, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:27:28', 2, 3),
(1172, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php?kategorija=%C5%BEupanijska+cesta&oznaka=2029&poc=Vara%C5%BEdin&zav=Sra%C4%8Dinec&brkm=7.09&dodajdionicu=Dodaj+dionicu', 'INSERT INTO cesta (oznaka, pocetak_dionice, zavrsetak_dionice, broj_kilometara, stanje, ID_kategorija) VALUES (\'2029\', \'Varaždin\', \'Sračinec\', 7.09, \'otvorena\', 3);', '2021-06-08 19:28:31', 2, 2),
(1173, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php?pocetak=Vara%C5%BEdin&zavrsetak=Sra%C4%8Dinec&submit=Pretra%C5%BEi', 'SELECT oznaka, broj_kilometara FROM cesta WHERE `pocetak_dionice`=\'Varaždin\' AND `zavrsetak_dionice`=\'Sračinec\' AND`stanje`=\'otvorena\'', '2021-06-08 19:29:00', 2, 2),
(1174, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:29:21', 2, 3),
(1175, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:29:24', 2, 3),
(1176, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php?naziv=Promet.pdf&status=potvr%C4%91eno&promijenistatus=Promijeni+status', 'UPDATE dokument SET status = \'potvrđeno\' WHERE naziv_dokumenta = \'Promet.pdf\'', '2021-06-08 19:29:31', 2, 2),
(1177, '/WebDiP/2020_projekti/WebDiP2020x060/problemi.php', ' ', '2021-06-08 19:29:33', 2, 3),
(1178, '/WebDiP/2020_projekti/WebDiP2020x060/problemi.php?oznaka=2065&stanje=zatvorena&spremi=Spremi+promjene', 'UPDATE cesta SET stanje = \'zatvorena\' WHERE oznaka = \'2065\'', '2021-06-08 19:29:45', 2, 2),
(1179, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:29:49', 2, 1),
(1180, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:29:49', 2, 1),
(1181, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:29:50', 1, 3),
(1182, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:29:56', 1, 3),
(1183, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:30:04', 1, 3),
(1184, '/WebDiP/2020_projekti/WebDiP2020x060/problemi.php', ' ', '2021-06-08 19:30:05', 1, 3),
(1185, '/WebDiP/2020_projekti/WebDiP2020x060/statistika.php', ' ', '2021-06-08 19:30:11', 1, 3),
(1186, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:30:14', 1, 3),
(1187, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:30:20', 1, 3),
(1188, '/WebDiP/2020_projekti/WebDiP2020x060/kategorije.php', ' ', '2021-06-08 19:30:26', 1, 3),
(1189, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:54:06', 1, 3),
(1190, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:54:14', 1, 3),
(1191, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php?oznaka=A1&dodajobilazak=Dodaj+obilazak', 'INSERT INTO obilazak (ID_korisnik, ID_cesta) VALUES(1, 23);', '2021-06-08 19:54:18', 1, 2),
(1192, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:54:18', 1, 3),
(1193, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:55:41', 1, 3),
(1194, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:55:48', 1, 3),
(1195, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 19:56:42', 1, 3),
(1196, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:56:43', 1, 3),
(1197, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 19:58:28', 1, 3),
(1198, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:58:28', 1, 3),
(1199, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:58:30', 1, 3),
(1200, '/WebDiP/2020_projekti/WebDiP2020x060/obilasci.php', ' ', '2021-06-08 19:58:32', 1, 3),
(1201, '/WebDiP/2020_projekti/WebDiP2020x060/dokumenti.php', ' ', '2021-06-08 19:58:40', 1, 3),
(1202, '/WebDiP/2020_projekti/WebDiP2020x060/kategorije.php', ' ', '2021-06-08 19:58:50', 1, 3),
(1203, '/WebDiP/2020_projekti/WebDiP2020x060/statistika.php', ' ', '2021-06-08 19:59:03', 1, 3),
(1204, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:59:25', 1, 1),
(1205, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 19:59:25', 1, 1),
(1206, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:00:17', NULL, 3),
(1207, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:00:19', NULL, 1),
(1208, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:00:53', 1, 3),
(1209, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:00:56', 1, 1),
(1210, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:00:56', 1, 1),
(1211, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/registracija.php', ' ', '2021-06-08 20:01:08', NULL, 3),
(1212, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:01:10', NULL, 3),
(1213, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 20:01:11', NULL, 3),
(1214, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:01:13', NULL, 1),
(1215, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:01:44', NULL, 3),
(1216, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:01:45', NULL, 1),
(1217, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/registracija.php', ' ', '2021-06-08 20:01:49', NULL, 3),
(1218, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:01:51', NULL, 1),
(1219, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:02:17', NULL, 3),
(1220, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:02:21', NULL, 3),
(1221, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:02:27', NULL, 3),
(1222, '/WebDiP/2020_projekti/WebDiP2020x060/privatno/korisnici.php', ' ', '2021-06-08 20:02:35', NULL, 3),
(1223, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:02:55', NULL, 3),
(1224, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:03:30', NULL, 3),
(1225, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:03:41', NULL, 3),
(1226, '/WebDiP/2020_projekti/WebDiP2020x060/index.php', ' ', '2021-06-08 20:03:44', NULL, 3),
(1227, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php', ' ', '2021-06-08 20:03:46', NULL, 3),
(1228, '/WebDiP/2020_projekti/WebDiP2020x060/dionice.php?pocetak=Zagreb&zavrsetak=Dubrovnik&submit=Pretra%C5%BEi', 'SELECT oznaka, broj_kilometara FROM cesta WHERE `pocetak_dionice`=\'Zagreb\' AND `zavrsetak_dionice`=\'Dubrovnik\' AND`stanje`=\'otvorena\'', '2021-06-08 20:04:08', NULL, 2),
(1229, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:04:14', NULL, 1),
(1230, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/registracija.php', ' ', '2021-06-08 20:04:20', NULL, 3),
(1231, '/WebDiP/2020_projekti/WebDiP2020x060/obrasci/prijava.php', ' ', '2021-06-08 20:04:23', NULL, 1),
(1232, '/WebDiP/2020_projekti/WebDiP2020x060/', ' ', '2021-06-09 09:07:47', NULL, 3),
(1233, '/WebDiP/2020_projekti/WebDiP2020x060/', ' ', '2021-06-09 09:07:53', NULL, 3),
(1234, '/WebDiP/2020_projekti/WebDiP2020x060/', ' ', '2021-06-09 09:08:00', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `dokument`
--

CREATE TABLE `dokument` (
  `ID_dokument` int(11) NOT NULL,
  `naziv_dokumenta` text NOT NULL,
  `vrsta_dokumenta` varchar(45) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'nije potvrđeno',
  `ID_korisnik` int(11) NOT NULL,
  `ID_cesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dokument`
--

INSERT INTO `dokument` (`ID_dokument`, `naziv_dokumenta`, `vrsta_dokumenta`, `status`, `ID_korisnik`, `ID_cesta`) VALUES
(1, 'automobilska_nesreca.jpg', '', 'potvrđeno', 4, 1),
(2, 'kolona_na_autocesti.jpeg', '', 'odbijeno', 5, 2),
(3, 'obilazak.jpg', '', 'odbijeno', 5, 10),
(4, 'odron_na_putu.jpg', '', 'odbijeno', 6, 8),
(5, 'radovi-na-cesti.jpg', '', 'potvrđeno', 4, 1),
(6, 'zaledena-cesta.jpg', '', 'potvrđeno', 4, 5),
(7, 'SampleVideo.mp4', '', 'nije potvrđeno', 6, 4),
(9, 'guzva.jpg', 'image/jpeg', 'potvrđeno', 1, 24),
(10, 'Promet.pdf', 'application/pdf', 'potvrđeno', 6, 23);

-- --------------------------------------------------------

--
-- Table structure for table `dz4_korisnik`
--

CREATE TABLE `dz4_korisnik` (
  `ID_korisnik` int(11) NOT NULL,
  `ime` varchar(45) DEFAULT NULL,
  `prezime` varchar(45) DEFAULT NULL,
  `korisnicko_ime` varchar(25) NOT NULL,
  `lozinka` varchar(25) NOT NULL,
  `lozinka_sha256` char(64) NOT NULL,
  `email` varchar(45) NOT NULL,
  `uvjeti` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `ID_uloga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dz4_korisnik`
--

INSERT INTO `dz4_korisnik` (`ID_korisnik`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `lozinka_sha256`, `email`, `uvjeti`, `status`, `ID_uloga`) VALUES
(1, 'Petar', 'Mihalić', 'pmihalic', 'admin_pmihalic', 'b9bb5303b6bb857495a314e5775c6d620a599e04', 'pmihalic@foi.hr', '2021-04-11 12:00:00', 0, 1),
(2, 'Ivo', 'Ivić', 'iivic', 'mod_iivic', '0c05cb6837ea6f6c62bdec41e86d13cf72f8b10d', 'iivic@mail.hr', '2021-04-11 05:00:00', 0, 2),
(3, 'Ana', 'Anić', 'aanic', 'mod_aanic', 'dabbab5ab8fdf1638bc7f8f0919949359eca6efc', 'aanic@mail.hr', '2021-04-11 13:00:00', 0, 2),
(4, 'Lovro', 'Lovrić', 'llovric', 'reg_llovric', '80370447c59d8275bfc0b923c13d7fff724bb79d', 'llovric@mail.hr', '2021-04-11 14:00:00', 0, 3),
(5, 'Anton', 'Antić', 'aantic', 'reg_aantic', 'b1d113c72f863f400709c8e51704d4b38ff9ec8e', 'aanitc@mail.hr', '2021-04-11 15:00:00', 0, 3),
(6, 'Sara', 'Sarić', 'ssaric', 'reg_ssaric', 'e66e38de1de5421d3932b6189668c261833b3eae', 'ssaric@email.hr', '2021-04-11 20:00:00', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `dz4_ocjena`
--

CREATE TABLE `dz4_ocjena` (
  `ID_ocjena` int(11) NOT NULL,
  `sezona` int(11) NOT NULL,
  `epizoda` int(11) NOT NULL,
  `poveznica` varchar(250) NOT NULL,
  `najbolji_lik` varchar(100) NOT NULL,
  `karakteristike` varchar(50) NOT NULL,
  `ocjena` int(11) NOT NULL,
  `datum` text NOT NULL,
  `vrijeme` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dz4_ocjena`
--

INSERT INTO `dz4_ocjena` (`ID_ocjena`, `sezona`, `epizoda`, `poveznica`, `najbolji_lik`, `karakteristike`, `ocjena`, `datum`, `vrijeme`) VALUES
(1, 1, 1, 'https://www.imdb.com/title/tt2471500/?ref_=ttep_ep1', 'Thomas Shelby', 'drama', 8, '2021-03-15', '10:44:15'),
(2, 1, 6, 'https://www.imdb.com/title/tt2461638/?ref_=ttep_ep6', 'Thomas Shelby, Inspector Campbell', 'akcija', 9, '2021-03-17', '22:11:49'),
(3, 2, 3, 'https://www.imdb.com/title/tt3683572/?ref_=ttep_ep3', 'Alfie Solomons', 'drama', 9, '2021-03-17', '14:18:09'),
(4, 3, 2, 'https://www.imdb.com/title/tt4370544/?ref_=ttep_ep2', 'Thomas Shelby', 'ljubav', 9, '2021-03-24', '20:12:09'),
(5, 4, 6, 'https://www.imdb.com/title/tt6056650/?ref_=ttep_ep6', 'Thomas Shelby', 'drama, akcija', 10, '2021-03-21', '07:14:43'),
(6, 4, 6, 'https://www.imdb.com/title/tt6056650/?ref_=ttep_ep6', 'Thomas Shelby, Alfie Solomons', 'drama, napetost', 10, '2021-03-26', '16:16:43'),
(7, 5, 2, 'https://www.imdb.com/title/tt6227902/?ref_=ttep_ep2', 'Thomas Shelby', 'obitelj, drama', 9, '2021-03-26', '14:12:24'),
(8, 6, 2, 'https://www.imdb.com/title/tt5756000/?ref_=ttep_ep1', 'Thomas Shelby, Finn Shelby, Michael Gray', 'drama, obitelj', 9, '2021-05-23', '22:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `dz4_uloga`
--

CREATE TABLE `dz4_uloga` (
  `ID_uloga` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL,
  `opis` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dz4_uloga`
--

INSERT INTO `dz4_uloga` (`ID_uloga`, `naziv`, `opis`) VALUES
(1, 'Administrator', 'Upravlja kategorijama, dodjeljuje moderatore.'),
(2, 'Moderator', 'Upravlja cestama, potvrđuje/odbija dokumente.'),
(3, 'Registrirani korisnik', 'Evidentira obilazak, dodaje dokumente.'),
(4, 'Neregistrirani korisnik', 'Vidi statistiku problema, popis dionica itd.');

-- --------------------------------------------------------

--
-- Table structure for table `kategorija_ceste`
--

CREATE TABLE `kategorija_ceste` (
  `ID_kategorija` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `opis` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategorija_ceste`
--

INSERT INTO `kategorija_ceste` (`ID_kategorija`, `naziv`, `opis`) VALUES
(1, 'autocesta', 'Autoceste su ceste koje povezuju cjelokupni prostor Republike Hrvatske i integriraju ga u europsku mrežu cesta, a namijenjene su prometu na velikim daljinama, sa dva traka na svakoj strani odvojena ogradom, te zaustavnim trakom.'),
(2, 'državna cesta', 'Mrežu državnih cesta čine ceste koje povezuju cjelokupni prostor Republike Hrvatske i integriraju ga u europsku mrežu cesta, a namijenjene su prometu na velikim daljinama.'),
(3, 'županijska cesta', 'Županijske ceste povezuju naselja i lokalitete unutar županije i integriraju cjelokupni prostor županije u mrežu cesta Republike Hrvatske.'),
(4, 'lokalna cesta', 'Lokalne ceste povezuju naselja i lokalitete unutar općine i integriraju cjelokupni prostor općine u mrežu cesta Republike Hrvatske.');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID_korisnik` int(11) NOT NULL,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `korisnicko_ime` varchar(25) NOT NULL,
  `lozinka` varchar(25) NOT NULL,
  `lozinka_sha256` char(64) NOT NULL,
  `email` varchar(45) NOT NULL,
  `uvjeti` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `ID_uloga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID_korisnik`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `lozinka_sha256`, `email`, `uvjeti`, `status`, `ID_uloga`) VALUES
(1, 'Petar', 'Mihalić', 'pmihalic', 'admin_pmihalic', 'b9bb5303b6bb857495a314e5775c6d620a599e04', 'pmihalic@foi.hr', '2021-04-11 12:00:00', 0, 1),
(2, 'Ivo', 'Ivić', 'iivic', 'mod_iivic', '0c05cb6837ea6f6c62bdec41e86d13cf72f8b10d', 'iivic@mail.hr', '2021-04-11 05:00:00', 0, 2),
(3, 'Ana', 'Anić', 'aanic', 'mod_aanic', 'dabbab5ab8fdf1638bc7f8f0919949359eca6efc', 'aanic@mail.hr', '2021-04-11 13:00:00', 0, 2),
(4, 'Lovro', 'Lovrić', 'llovric', 'reg_llovric', '80370447c59d8275bfc0b923c13d7fff724bb79d', 'llovric@mail.hr', '2021-04-11 14:00:00', 0, 3),
(5, 'Anton', 'Antić', 'aantic', 'reg_aantic', 'b1d113c72f863f400709c8e51704d4b38ff9ec8e', 'aanitc@mail.hr', '2021-04-11 15:00:00', 0, 3),
(6, 'Sara', 'Sarić', 'ssaric', 'reg_ssaric', 'e66e38de1de5421d3932b6189668c261833b3eae', 'ssaric@email.hr', '2021-04-11 20:00:00', 1, 3),
(7, 'Marko', 'Markovic', 'mmarkovic', 'marko1985', 'b4ea5ff8fa3e6277be182c2985332c2fcc951c0e5273fbec71b2f549b1413509', 'mmarkovic@gmail.com', NULL, 0, 3),
(8, 'Tomek', 'Tomic', 'ttomic', 'ttomic09', '8454e9ca49d8ee47f65ec8f2f720f4f500e093a88c926af3e1c1a4b78a9049e9', 'ttomic@gmail.com', NULL, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `obilazak`
--

CREATE TABLE `obilazak` (
  `obilazak_ID` int(11) NOT NULL,
  `datum_vrijeme_pocetka` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_korisnik` int(11) NOT NULL,
  `ID_cesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `obilazak`
--

INSERT INTO `obilazak` (`obilazak_ID`, `datum_vrijeme_pocetka`, `ID_korisnik`, `ID_cesta`) VALUES
(1, '2021-04-11 02:00:00', 4, 6),
(2, '2021-04-09 22:00:00', 4, 8),
(3, '2021-04-11 15:00:00', 4, 11),
(4, '2021-04-09 22:00:00', 5, 7),
(5, '2021-04-10 08:23:00', 5, 3),
(6, '2021-04-09 03:30:15', 6, 1),
(8, '2021-04-11 04:00:00', 5, 3),
(16, '2021-06-04 19:39:48', 6, 1),
(17, '2021-06-04 19:39:54', 6, 7),
(18, '2021-06-05 20:34:30', 6, 23),
(19, '2021-06-08 13:05:16', 1, 24),
(21, '2021-06-08 13:25:39', 2, 1),
(22, '2021-06-08 13:28:24', 6, 24),
(23, '2021-06-08 14:59:15', 1, 2),
(24, '2021-06-08 14:59:31', 1, 5),
(25, '2021-06-08 14:59:41', 1, 23),
(26, '2021-06-08 19:54:18', 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

CREATE TABLE `problem` (
  `ID_problem` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `opis` varchar(45) NOT NULL,
  `datum_vrijeme` datetime NOT NULL,
  `ID_korisnik` int(11) NOT NULL,
  `ID_cesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `problem`
--

INSERT INTO `problem` (`ID_problem`, `naziv`, `opis`, `datum_vrijeme`, `ID_korisnik`, `ID_cesta`) VALUES
(1, 'radovi', 'radovi na cesti, kolona 3 km', '2021-04-11 00:00:00', 4, 6),
(2, 'radovi', 'zatvorena cesta zbog radova', '2021-04-11 10:00:00', 5, 9),
(3, 'prometna nesreća', 'kolona 5 km zbog prometne netreće', '2021-04-11 10:00:00', 6, 3),
(4, 'odron kamenja', 'zatvorena cesta se ne ukloni opasnost', '2021-04-11 07:00:00', 4, 1),
(5, 'prometna nesreća', 'ulančani sudar, kolona 7 km', '2021-04-11 09:00:00', 5, 4),
(6, 'održavanje utrka', 'zatvorena cesta od 12 do 14h', '2021-04-10 11:23:00', 5, 8),
(9, 'Radovi na cesti', 'Zatvorena cesta zbog gradnje kružnog toka', '2021-06-04 21:39:00', 6, 11),
(10, 'Radovi na cesti', 'Zatvorena cesta zbog gradnje kružnog toka', '2021-06-05 22:34:00', 6, 23),
(11, 'gužva', 'kolona, dugo se čeka', '2021-06-08 15:08:00', 1, 23),
(12, 'semafor', 'ne rade semafori', '2021-06-08 15:26:00', 2, 1),
(13, 'automobilska nesreca', 'nesreca, zatvorena cesta', '2021-06-08 15:30:00', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tip`
--

CREATE TABLE `tip` (
  `ID_tip` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tip`
--

INSERT INTO `tip` (`ID_tip`, `naziv`) VALUES
(1, 'prijava/odjava'),
(2, 'rad s bazom'),
(3, 'ostale radnje');

-- --------------------------------------------------------

--
-- Table structure for table `uloga`
--

CREATE TABLE `uloga` (
  `ID_uloga` int(11) NOT NULL,
  `naziv` varchar(25) NOT NULL,
  `opis` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uloga`
--

INSERT INTO `uloga` (`ID_uloga`, `naziv`, `opis`) VALUES
(1, 'Administrator', 'Upravlja kategorijama, dodjeljuje moderatore.'),
(2, 'Moderator', 'Upravlja cestama, potvrđuje/odbija dokumente.'),
(3, 'Registrirani korisnik', 'Evidentira obilazak, dodaje dokumente.'),
(4, 'Neregistrirani korisnik', 'Vidi statistiku problema, popis dionica itd.');

-- --------------------------------------------------------

--
-- Table structure for table `upravlja`
--

CREATE TABLE `upravlja` (
  `ID_korisnik` int(11) NOT NULL,
  `ID_kategorija` int(11) NOT NULL,
  `datum_vrijeme` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `upravlja`
--

INSERT INTO `upravlja` (`ID_korisnik`, `ID_kategorija`, `datum_vrijeme`) VALUES
(1, 1, '2021-04-11 01:00:00'),
(1, 2, '2021-04-11 06:00:00'),
(1, 3, '2021-04-11 13:00:00'),
(1, 4, '2021-04-11 16:00:00'),
(2, 1, '2021-06-06 10:24:36'),
(2, 2, '2021-06-06 11:20:15'),
(2, 3, '2021-06-06 10:38:19'),
(3, 3, '2021-06-08 13:22:37'),
(3, 4, '2021-06-06 10:47:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cesta`
--
ALTER TABLE `cesta`
  ADD PRIMARY KEY (`ID_cesta`),
  ADD KEY `fk_cesta_kategorija_ceste1_idx` (`ID_kategorija`);

--
-- Indexes for table `dnevnik_rada`
--
ALTER TABLE `dnevnik_rada`
  ADD PRIMARY KEY (`ID_dnevnik`) USING BTREE,
  ADD KEY `fk_dnevnik_korisnik1_idx` (`ID_korisnik`),
  ADD KEY `fk_dnevnik_tip1_idx` (`ID_tip`);

--
-- Indexes for table `dokument`
--
ALTER TABLE `dokument`
  ADD PRIMARY KEY (`ID_dokument`),
  ADD KEY `fk_dokument_korisnik1_idx` (`ID_korisnik`),
  ADD KEY `fk_dokument_cesta1_idx` (`ID_cesta`);

--
-- Indexes for table `dz4_korisnik`
--
ALTER TABLE `dz4_korisnik`
  ADD PRIMARY KEY (`ID_korisnik`),
  ADD KEY `fk_dz4_korisnik_dz4_uloga_idx` (`ID_uloga`);

--
-- Indexes for table `dz4_ocjena`
--
ALTER TABLE `dz4_ocjena`
  ADD PRIMARY KEY (`ID_ocjena`);

--
-- Indexes for table `dz4_uloga`
--
ALTER TABLE `dz4_uloga`
  ADD PRIMARY KEY (`ID_uloga`);

--
-- Indexes for table `kategorija_ceste`
--
ALTER TABLE `kategorija_ceste`
  ADD PRIMARY KEY (`ID_kategorija`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID_korisnik`),
  ADD KEY `fk_korisnik_uloga_idx` (`ID_uloga`);

--
-- Indexes for table `obilazak`
--
ALTER TABLE `obilazak`
  ADD PRIMARY KEY (`obilazak_ID`,`ID_cesta`,`ID_korisnik`),
  ADD KEY `fk_obilazak_korisnik1_idx` (`ID_korisnik`),
  ADD KEY `fk_obilazak_cesta1_idx` (`ID_cesta`);

--
-- Indexes for table `problem`
--
ALTER TABLE `problem`
  ADD PRIMARY KEY (`ID_problem`,`ID_cesta`),
  ADD KEY `fk_problem_korisnik1_idx` (`ID_korisnik`),
  ADD KEY `fk_problem_cesta1_idx` (`ID_cesta`);

--
-- Indexes for table `tip`
--
ALTER TABLE `tip`
  ADD PRIMARY KEY (`ID_tip`);

--
-- Indexes for table `uloga`
--
ALTER TABLE `uloga`
  ADD PRIMARY KEY (`ID_uloga`);

--
-- Indexes for table `upravlja`
--
ALTER TABLE `upravlja`
  ADD PRIMARY KEY (`ID_korisnik`,`ID_kategorija`),
  ADD KEY `fk_korisnik_has_kategorija_ceste_kategorija_ceste1_idx` (`ID_kategorija`),
  ADD KEY `fk_korisnik_has_kategorija_ceste_korisnik1_idx` (`ID_korisnik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cesta`
--
ALTER TABLE `cesta`
  MODIFY `ID_cesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `dnevnik_rada`
--
ALTER TABLE `dnevnik_rada`
  MODIFY `ID_dnevnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;
--
-- AUTO_INCREMENT for table `dokument`
--
ALTER TABLE `dokument`
  MODIFY `ID_dokument` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dz4_korisnik`
--
ALTER TABLE `dz4_korisnik`
  MODIFY `ID_korisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `dz4_ocjena`
--
ALTER TABLE `dz4_ocjena`
  MODIFY `ID_ocjena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `dz4_uloga`
--
ALTER TABLE `dz4_uloga`
  MODIFY `ID_uloga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kategorija_ceste`
--
ALTER TABLE `kategorija_ceste`
  MODIFY `ID_kategorija` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID_korisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `obilazak`
--
ALTER TABLE `obilazak`
  MODIFY `obilazak_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `problem`
--
ALTER TABLE `problem`
  MODIFY `ID_problem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tip`
--
ALTER TABLE `tip`
  MODIFY `ID_tip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uloga`
--
ALTER TABLE `uloga`
  MODIFY `ID_uloga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cesta`
--
ALTER TABLE `cesta`
  ADD CONSTRAINT `fk_cesta_kategorija_ceste1` FOREIGN KEY (`ID_kategorija`) REFERENCES `kategorija_ceste` (`ID_kategorija`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dnevnik_rada`
--
ALTER TABLE `dnevnik_rada`
  ADD CONSTRAINT `fk_dnevnik_korisnik1` FOREIGN KEY (`ID_korisnik`) REFERENCES `korisnik` (`ID_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dnevnik_tip1` FOREIGN KEY (`ID_tip`) REFERENCES `tip` (`ID_tip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokument`
--
ALTER TABLE `dokument`
  ADD CONSTRAINT `fk_dokument_cesta1` FOREIGN KEY (`ID_cesta`) REFERENCES `cesta` (`ID_cesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dokument_korisnik1` FOREIGN KEY (`ID_korisnik`) REFERENCES `korisnik` (`ID_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dz4_korisnik`
--
ALTER TABLE `dz4_korisnik`
  ADD CONSTRAINT `fk_dz4_korisnik_dz4_uloga` FOREIGN KEY (`ID_uloga`) REFERENCES `dz4_uloga` (`ID_uloga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `fk_korisnik_uloga` FOREIGN KEY (`ID_uloga`) REFERENCES `uloga` (`ID_uloga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `obilazak`
--
ALTER TABLE `obilazak`
  ADD CONSTRAINT `fk_obilazak_cesta1` FOREIGN KEY (`ID_cesta`) REFERENCES `cesta` (`ID_cesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_obilazak_korisnik1` FOREIGN KEY (`ID_korisnik`) REFERENCES `korisnik` (`ID_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `problem`
--
ALTER TABLE `problem`
  ADD CONSTRAINT `fk_problem_cesta1` FOREIGN KEY (`ID_cesta`) REFERENCES `cesta` (`ID_cesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_problem_korisnik1` FOREIGN KEY (`ID_korisnik`) REFERENCES `korisnik` (`ID_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upravlja`
--
ALTER TABLE `upravlja`
  ADD CONSTRAINT `fk_korisnik_has_kategorija_ceste_kategorija_ceste1` FOREIGN KEY (`ID_kategorija`) REFERENCES `kategorija_ceste` (`ID_kategorija`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_korisnik_has_kategorija_ceste_korisnik1` FOREIGN KEY (`ID_korisnik`) REFERENCES `korisnik` (`ID_korisnik`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
