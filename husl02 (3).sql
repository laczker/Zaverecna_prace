-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Čtv 03. čen 2021, 13:46
-- Verze serveru: 10.3.22-MariaDB-log
-- Verze PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `husl02`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `kategorie`
--

CREATE TABLE `kategorie` (
  `kategorie_id` smallint(6) NOT NULL,
  `nazev` text COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `popis` text COLLATE utf8mb4_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `kategorie`
--

INSERT INTO `kategorie` (`kategorie_id`, `nazev`, `popis`) VALUES
(1, 'MTB', 'Horské kolo – zkratka z anglického mountain bike'),
(2, 'Gravel bike', 'Typ silničního kola podobný těm, které se používají v cyklokrosu, ale zaměřený na štěrkové cesty\r\n');

-- --------------------------------------------------------

--
-- Struktura tabulky `komentar`
--

CREATE TABLE `komentar` (
  `komentar_id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `produkt_id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_czech_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `produkt`
--

CREATE TABLE `produkt` (
  `produkt_id` int(11) NOT NULL,
  `nazev` varchar(256) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `popis` text COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `cena` decimal(10,2) NOT NULL,
  `kategorie_id` smallint(6) NOT NULL,
  `vyrobce_id` int(11) NOT NULL,
  `parametry` text COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `cas_posledniho_updatu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cas_posledni_upravy` timestamp NULL DEFAULT NULL,
  `posledni_upravu_provedl` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `nazev`, `popis`, `cena`, `kategorie_id`, `vyrobce_id`, `parametry`, `cas_posledniho_updatu`, `cas_posledni_upravy`, `posledni_upravu_provedl`) VALUES
(1, 'Testovací kolo1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, aliquam venenatis tortor. Nulla placerat et sem a lobortis. Praesent vel dapibus nunc, imperdiet semper velit. Morbi id interdum turpis. Vestibulum finibus finibus velit id consectetur. Proin tortor tellus, sagittis eu nisl ac, pharetra facilisis mi. Morbi euismod egestas convallis. Phasellus sit amet libero leo.\r\n\r\n', '100000.00', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, \r\n\r\n', '2021-06-01 12:25:45', NULL, NULL),
(2, 'Testovací kolo2', 'Lorem ipsubxgfbgbbyfgbm dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, aliquam venenatis tortor. Nulla placerat et sem a lobortis. Praesent vel dapibus nunc, imperdiet semper velit. Morbi id interdum turpis. Vestibulum finibus finibus velit id consectetur. Proin tortor tellus, sagittis eu nisl ac, pharetra facilisis mi. Morbi euismod egestas convallis. Phasellus sit amet libero leo.\r\n\r\n', '100000.00', 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, \r\n\r\nyfgb', '2021-06-01 16:42:28', NULL, NULL),
(3, 'Testovací kolo3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, aliquam venenatis tortor. Nulla placerat et sem a lobortis. Praesent vel dapibus nunc, imperdiet semper velit. Morbi id interdum turpis. Vestibulum finibus finibus velit id consectetur. Proin tortor tellus, sagittis eu nisl ac, pharetra facilisis mi. Morbi euismod egestas convallis. Phasellus sit amet libero leo.\r\n\r\n', '100000.00', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, \r\n\r\n', '2021-06-01 16:40:07', NULL, NULL),
(4, 'Testovací kolo4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, aliquam venenatis tortor. Nulla placerat et sem a lobortis. Praesent vel dapibus nunc, imperdiet semper velit. Morbi id interdum turpis. Vestibulum finibus finibus velit id consectetur. Proin tortor tellus, sagittis eu nisl ac, pharetra facilisis mi. Morbi euismod egestas convallis. Phasellus sit amet libero leo.\r\n\r\n', '100000.00', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, \r\n\r\n', '2021-06-01 16:40:07', NULL, NULL),
(5, 'Testovací kolo11', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, aliquam venenatis tortor. Nulla placerat et sem a lobortis. Praesent vel dapibus nunc, imperdiet semper velit. Morbi id interdum turpis. Vestibulum finibus finibus velit id consectetur. Proin tortor tellus, sagittis eu nisl ac, pharetra facilisis mi. Morbi euismod egestas convallis. Phasellus sit amet libero leo.\r\n\r\n', '100000.00', 1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et scelerisque diam. Nullam purus risus, sagittis id malesuada sit amet, pharetra et tellus. Sed in fermentum nulla. Phasellus arcu quam, hendrerit accumsan urna sed, \r\n\r\n', '2021-06-02 20:52:44', NULL, NULL),
(7, 'jaj', 'adsfasdfadsfasdfasdfsdfasdfasdfasdfasdfasdfasdfeeeeeeeeeeeeeeeeeeeee', '500.00', 2, 2, 'gadfgadfgafgdafgda', '2021-06-03 09:29:02', NULL, NULL),
(8, 'Pokus pridat 2', 'sdfafasdasdasd', '9.00', 2, 2, 'asdadsaaaaaaaaaaaaaaaa', '2021-06-03 09:29:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `uzivatel_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `role` set('user','admin') COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`uzivatel_id`, `email`, `heslo`, `role`) VALUES
(1, 'admin@eshop.tld', '$2y$10$DCtYAC.O37LSd3qyKF3sa.m2EZrimftbAzj0Xc5aablC1cpM2XERS', 'admin'),
(6, 'l.hustik@seznam.cz', '$2y$10$cvOjRWAIN3vZgMHGpPpYqu7PwqsFHlR6d5i8vwpcaX.nN9QCrBphi', 'user'),
(7, 'test@test.cz', '$2y$10$JORv5byCNSKHDi9GKYGTT.DugN9A7Zm7qrZVAJqdbuAPt7D7EMyFC', 'user');

-- --------------------------------------------------------

--
-- Struktura tabulky `vyrobce`
--

CREATE TABLE `vyrobce` (
  `vyrobce_id` int(11) NOT NULL,
  `nazev` text COLLATE utf8mb4_czech_ci NOT NULL,
  `popis` text COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `vyrobce`
--

INSERT INTO `vyrobce` (`vyrobce_id`, `nazev`, `popis`) VALUES
(1, 'Cannondale', 'Cannondale Bicycle Corporation je americká divize kanadského konglomerátu Dorel Industries, která dodává jízdní kola. Její sídlo je ve Wiltonu v Connecticutu s výrobními a montážními zařízeními na Tchaj-wanu'),
(2, 'GT', 'GT Bicycles navrhuje a vyrábí kola BMX, horská a silniční kola. GT je divize kanadského konglomerátu Dorel Industries, která také prodává značky jízdních kol Cannondale, Schwinn, Mongoose, IronHorse, DYNO a RoadMaster; vše vyrobené v Asii');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategorie_id`);

--
-- Klíče pro tabulku `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `uzivatel_id` (`uzivatel_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Klíče pro tabulku `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`produkt_id`),
  ADD KEY `kategorie_id` (`kategorie_id`),
  ADD KEY `vyrobce_id` (`vyrobce_id`);

--
-- Klíče pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`uzivatel_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Klíče pro tabulku `vyrobce`
--
ALTER TABLE `vyrobce`
  ADD PRIMARY KEY (`vyrobce_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategorie_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `uzivatel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `vyrobce`
--
ALTER TABLE `vyrobce`
  MODIFY `vyrobce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatel` (`uzivatel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`vyrobce_id`) REFERENCES `vyrobce` (`vyrobce_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`kategorie_id`) REFERENCES `kategorie` (`kategorie_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
