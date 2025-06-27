-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Jún 27. 11:26
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `idopontfoglalo`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ertekelesek`
--

CREATE TABLE `ertekelesek` (
  `id` int(11) NOT NULL,
  `foglalasok_id` int(11) NOT NULL,
  `ertekeles` tinyint(4) NOT NULL CHECK (`ertekeles` between 1 and 5),
  `velemeny` text DEFAULT NULL,
  `datum` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(10) NOT NULL,
  `nev` char(100) NOT NULL,
  `szerepkor` char(50) NOT NULL,
  `email` char(100) NOT NULL,
  `jelszo` char(255) NOT NULL,
  `reg_datum` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `nev`, `szerepkor`, `email`, `jelszo`, `reg_datum`) VALUES
(1, 'Kovacs Bela', 'felhasznalo', 'bela@example.com', 'titok456', '2025-06-05 14:54:59'),
(2, 'Kiss Dalma', 'admin', 'dalma@example.com', 'titok789', '2025-06-05 14:56:09'),
(3, 'Orosz Kristóf', 'felhasznalo', 'kristof.orosz.11@gmail.com', 'titok123', '2025-06-17 13:14:26'),
(4, 'Kiss János', 'felhasznalo', 'janos@example.hu', 'titok147', '2025-06-26 10:49:01'),
(5, 'Kiss János', 'admin', 'janos2@example.hu', 'TITOK258', '2025-06-26 10:50:07'),
(6, 'Nagy János', 'admin', 'janosnagy@example.hu', 'titok', '2025-06-26 12:28:54'),
(7, 'Kiss János', 'felhasznalo', 'janoskiss@example.hu', 'titok2', '2025-06-26 12:41:41');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foglalasok`
--

CREATE TABLE `foglalasok` (
  `id` int(11) NOT NULL,
  `felhasznalok_id` int(10) NOT NULL,
  `idopontok_id` int(10) NOT NULL,
  `foglalasi_ido` datetime DEFAULT current_timestamp(),
  `allapot` char(50) NOT NULL,
  `megjegyzes` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `foglalasok`
--

INSERT INTO `foglalasok` (`id`, `felhasznalok_id`, `idopontok_id`, `foglalasi_ido`, `allapot`, `megjegyzes`) VALUES
(7, 2, 2, '2025-06-11 11:11:52', 'lemondva', 'Mégsem jó ez az időpont.'),
(9, 2, 4, '2025-06-11 11:11:52', 'lefoglalt', 'Sürgős esetre.'),
(10, 1, 5, '2025-06-11 11:11:52', 'lefoglalt', 'fff'),
(30, 3, 22, '2025-06-20 12:13:27', 'lefoglalt', NULL),
(35, 1, 40, '2025-06-20 15:42:38', 'lefoglalt', NULL),
(37, 4, 133, '2025-06-26 10:55:36', 'lefoglalt', 'Nem megfelelő az időpont.'),
(38, 7, 76, '2025-06-26 12:44:09', 'lemondás alatt.', 'Szeretném ezt az időpontot lemondani');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `idopontok`
--

CREATE TABLE `idopontok` (
  `id` int(10) NOT NULL,
  `szolgaltatok_id` int(255) NOT NULL,
  `datum` date NOT NULL,
  `ido` time NOT NULL,
  `foglalhato` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `idopontok`
--

INSERT INTO `idopontok` (`id`, `szolgaltatok_id`, `datum`, `ido`, `foglalhato`) VALUES
(2, 1, '2025-06-10', '10:00:00', 1),
(3, 1, '2025-06-10', '11:00:00', 1),
(4, 1, '2025-06-10', '12:00:00', 1),
(5, 1, '2025-06-10', '13:00:00', 1),
(6, 2, '2025-06-10', '09:00:00', 1),
(8, 2, '2025-06-10', '11:00:00', 1),
(9, 2, '2025-06-10', '12:00:00', 1),
(10, 2, '2025-06-10', '13:00:00', 0),
(11, 3, '2025-06-10', '09:00:00', 1),
(12, 3, '2025-06-20', '14:00:00', 0),
(13, 3, '2025-06-10', '11:00:00', 1),
(14, 3, '2025-06-10', '12:00:00', 1),
(15, 3, '2025-06-10', '13:00:00', 1),
(16, 4, '2025-06-10', '09:00:00', 0),
(17, 4, '2025-06-10', '10:00:00', 1),
(18, 4, '2025-06-10', '11:00:00', 0),
(19, 4, '2025-06-10', '12:00:00', 1),
(20, 4, '2025-06-10', '13:00:00', 0),
(21, 5, '2025-06-10', '09:00:00', 0),
(22, 5, '2025-06-10', '10:00:00', 0),
(24, 5, '2025-06-10', '12:00:00', 0),
(25, 5, '2025-06-10', '13:00:00', 0),
(26, 1, '2025-06-10', '09:00:00', 0),
(31, 7, '2025-06-10', '09:00:00', 1),
(32, 7, '2025-06-10', '10:00:00', 1),
(33, 7, '2025-06-10', '11:00:00', 1),
(34, 7, '2025-06-10', '12:00:00', 1),
(35, 7, '2025-06-10', '13:00:00', 1),
(36, 8, '2025-06-10', '09:00:00', 1),
(37, 8, '2025-06-10', '10:00:00', 0),
(38, 8, '2025-06-10', '11:00:00', 1),
(39, 8, '2025-06-10', '12:00:00', 1),
(40, 8, '2025-06-10', '13:00:00', 0),
(42, 9, '2025-06-10', '10:00:00', 1),
(43, 9, '2025-06-10', '11:00:00', 1),
(44, 9, '2025-06-10', '12:00:00', 1),
(45, 9, '2025-06-10', '13:00:00', 1),
(46, 10, '2025-06-10', '09:00:00', 1),
(47, 10, '2025-06-10', '10:00:00', 1),
(48, 10, '2025-06-10', '11:00:00', 1),
(49, 10, '2025-06-10', '12:00:00', 1),
(50, 10, '2025-06-10', '13:00:00', 1),
(51, 11, '2025-06-10', '09:00:00', 1),
(52, 11, '2025-06-10', '10:00:00', 1),
(53, 11, '2025-06-10', '11:00:00', 1),
(54, 11, '2025-06-10', '12:00:00', 1),
(55, 11, '2025-06-10', '13:00:00', 1),
(56, 12, '2025-06-10', '09:00:00', 1),
(57, 12, '2025-06-10', '10:00:00', 1),
(58, 12, '2025-06-10', '11:00:00', 1),
(59, 12, '2025-06-10', '12:00:00', 1),
(60, 12, '2025-06-10', '13:00:00', 1),
(62, 1, '2025-06-10', '10:00:00', 1),
(66, 14, '2025-06-10', '09:00:00', 1),
(67, 14, '2025-06-10', '10:00:00', 1),
(68, 14, '2025-06-10', '11:00:00', 1),
(69, 14, '2025-06-10', '12:00:00', 1),
(70, 14, '2025-06-10', '13:00:00', 1),
(71, 15, '2025-06-10', '09:00:00', 1),
(72, 15, '2025-06-10', '10:00:00', 1),
(73, 15, '2025-06-10', '11:00:00', 1),
(74, 15, '2025-06-10', '12:00:00', 1),
(75, 15, '2025-06-10', '13:00:00', 1),
(76, 16, '2025-06-10', '09:00:00', 0),
(77, 16, '2025-06-10', '10:00:00', 1),
(78, 16, '2025-06-10', '11:00:00', 1),
(79, 16, '2025-06-10', '12:00:00', 1),
(81, 17, '2025-06-10', '09:00:00', 1),
(82, 17, '2025-06-10', '10:00:00', 1),
(83, 17, '2025-06-10', '11:00:00', 1),
(84, 17, '2025-06-10', '12:00:00', 1),
(85, 17, '2025-06-10', '13:00:00', 1),
(86, 18, '2025-06-10', '09:00:00', 1),
(87, 18, '2025-06-10', '10:00:00', 1),
(88, 18, '2025-06-10', '11:00:00', 1),
(89, 18, '2025-06-10', '12:00:00', 1),
(90, 18, '2025-06-10', '13:00:00', 1),
(91, 19, '2025-06-10', '09:00:00', 1),
(92, 19, '2025-06-10', '10:00:00', 1),
(93, 19, '2025-06-10', '11:00:00', 1),
(94, 19, '2025-06-10', '12:00:00', 1),
(95, 19, '2025-06-10', '13:00:00', 1),
(96, 20, '2025-06-10', '09:00:00', 1),
(97, 20, '2025-06-10', '10:00:00', 1),
(98, 20, '2025-06-10', '11:00:00', 1),
(99, 20, '2025-06-10', '12:00:00', 1),
(100, 20, '2025-06-10', '13:00:00', 1),
(101, 26, '2025-06-10', '09:00:00', 1),
(102, 26, '2025-06-10', '10:00:00', 1),
(103, 26, '2025-06-10', '11:00:00', 1),
(104, 26, '2025-06-10', '12:00:00', 1),
(105, 26, '2025-06-10', '13:00:00', 1),
(106, 27, '2025-06-10', '09:00:00', 1),
(107, 27, '2025-06-10', '10:00:00', 1),
(108, 27, '2025-06-10', '11:00:00', 1),
(109, 27, '2025-06-10', '12:00:00', 1),
(110, 27, '2025-06-10', '13:00:00', 1),
(111, 28, '2025-06-10', '09:00:00', 1),
(112, 28, '2025-06-10', '10:00:00', 1),
(113, 28, '2025-06-10', '11:00:00', 1),
(114, 28, '2025-06-10', '12:00:00', 1),
(115, 28, '2025-06-10', '13:00:00', 1),
(117, 29, '2025-06-10', '10:00:00', 1),
(118, 29, '2025-06-10', '11:00:00', 1),
(119, 29, '2025-06-10', '12:00:00', 1),
(120, 29, '2025-06-10', '13:00:00', 1),
(121, 30, '2025-06-10', '09:00:00', 1),
(122, 30, '2025-06-10', '10:00:00', 1),
(123, 30, '2025-06-10', '11:00:00', 1),
(124, 30, '2025-06-10', '12:00:00', 1),
(125, 30, '2025-06-10', '13:00:00', 1),
(130, 4, '2025-06-18', '21:00:00', 1),
(133, 13, '2025-06-19', '20:14:00', 1),
(134, 1, '2025-06-19', '17:51:00', 1),
(136, 13, '2025-06-29', '22:05:00', 1),
(138, 13, '2025-06-26', '10:56:00', 1),
(139, 13, '2025-06-27', '13:00:00', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szolgaltatas_tipusok`
--

CREATE TABLE `szolgaltatas_tipusok` (
  `id` int(10) NOT NULL,
  `nev` char(100) NOT NULL,
  `leiras` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `szolgaltatas_tipusok`
--

INSERT INTO `szolgaltatas_tipusok` (`id`, `nev`, `leiras`) VALUES
(1, 'Fogászat', 'Fogászati kezelések és vizsgálatok'),
(2, 'Szépségápolás', 'Arckezelések, manikűr/pedikűr szolgáltatások'),
(3, 'Fitness', 'Személyi edzés és csoportos alakformáló órák'),
(4, 'Fodrászat', 'Női és férfi hajvágás, hajfestés, styling szolgáltatások'),
(5, 'Elektronika', 'Mobiltelefon- és számítógép-javítás, szoftveres beállítások'),
(6, 'Egészségügy', 'Kórházi kezelések és szakrendelések'),
(7, 'Autóápolás', 'Külső-belső tisztítás, polírozás, waxolás és motorápolás'),
(8, 'Autóápolás', 'Külső-belső tisztítás, polírozás, waxolás és motorápolás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szolgaltatok`
--

CREATE TABLE `szolgaltatok` (
  `id` int(10) NOT NULL,
  `szolgaltatas_tipusok_id` int(50) NOT NULL,
  `nev` char(100) NOT NULL,
  `leiras` char(255) DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `szolgaltatok`
--

INSERT INTO `szolgaltatok` (`id`, `szolgaltatas_tipusok_id`, `nev`, `leiras`, `aktiv`) VALUES
(1, 2, 'SmileDent', 'Budapesti rendelő', 0),
(2, 2, 'SmileDent Rendelő', 'Teljeskörű szolgáltatás újdonságokkal. friss', 1),
(3, 7, 'EuroFogász Klinika', 'Modern implantológia és esztétikai fogászat', 1),
(4, 1, 'DentalArt Kft.', 'Gyermekfogászat és fogszabályozás profi csapattal', 1),
(5, 1, 'CityFogászat Centrum', 'Fogkő-eltávolítás, fogfehérítés gyors időpontfoglalással', 1),
(7, 2, 'Nails&Hairs Stúdió', 'Manikűr, pedikűr és balayage hajfestés egy helyen', 1),
(8, 2, 'Elegance Spa', 'Arc- és testkezelések luxus-környezetben', 1),
(9, 2, 'PerfectBeauty Kft.', 'Kozmetikai tanácsadás, sminkoktatás, SPA csomagok', 1),
(10, 3, 'ProGym Edzőterem', 'Személyi edzés, crossfit és súlyzós edzés profi edzőkkel', 1),
(11, 3, 'FitLife Csoportos', 'Csoportos alakformáló órák: zumba, pilates, jóga', 1),
(12, 3, 'IronClub Terem', 'Erőemelő szekció, funkcionális tréning és erőnléti programok', 1),
(13, 3, 'Cardio4U Fitness', 'Kardiógépek, aerob és spinning órák, táplálkozási tanácsadás', 1),
(14, 4, 'HairStyle Műhely', 'Férfi- és női hajvágás, profi vágók és fodrászok', 1),
(15, 4, 'ColorMaster Stúdió', 'Különleges hajfestés, balayage és tonális festések', 1),
(16, 4, 'TrendHair Salon', 'Legújabb trendek szerinti férfi- és női styling', 1),
(17, 5, 'MobilMester Szerviz', 'Gyorstelefon-javítás, kijelzőcsere, akkumulátor csere', 1),
(18, 5, 'PCPlus Számítástechnika', 'Laptop és asztali gép javítás, szoftveres telepítések', 1),
(19, 5, 'GépDoktor Kft.', 'Garanciális és garancián túli javítások, szoftverlendítés', 1),
(20, 6, 'Orvosi Centrum', 'Belgyógyászati és kardiológiai szakrendelések', 1),
(26, 8, 'Expressz Autómosás', 'Gyors külső mosás, kézi szárítás, viaszvédés nélkül', 1),
(27, 8, 'Full Service Autóápolás', 'Külső-belső takarítás, kárpittisztítás, motor tisztítás', 1),
(28, 8, 'Nanopolírozás', 'Nanotechnológiás polírozás, felületvédelem és UV-védelem', 1),
(29, 8, 'Motor- és Alvázmosás', 'Nagynyomású mosás motor- és alvázterületre, rozsda ellen védve', 1),
(30, 4, 'Prémium Fodrászat', 'Új leírás a 30-as szolgáltatónak', 0),
(40, 4, 'Autóipar Kft.', 'Minden ami autó.', 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `ertekelesek`
--
ALTER TABLE `ertekelesek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foglalasok_id` (`foglalasok_id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `foglalasok`
--
ALTER TABLE `foglalasok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idopontok_id` (`idopontok_id`),
  ADD KEY `felhasznalok_id` (`felhasznalok_id`);

--
-- A tábla indexei `idopontok`
--
ALTER TABLE `idopontok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szolgaltatok_id` (`szolgaltatok_id`);

--
-- A tábla indexei `szolgaltatas_tipusok`
--
ALTER TABLE `szolgaltatas_tipusok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `szolgaltatok`
--
ALTER TABLE `szolgaltatok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szolgaltatas_tipusok_id` (`szolgaltatas_tipusok_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `ertekelesek`
--
ALTER TABLE `ertekelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `foglalasok`
--
ALTER TABLE `foglalasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT a táblához `idopontok`
--
ALTER TABLE `idopontok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT a táblához `szolgaltatas_tipusok`
--
ALTER TABLE `szolgaltatas_tipusok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `szolgaltatok`
--
ALTER TABLE `szolgaltatok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `ertekelesek`
--
ALTER TABLE `ertekelesek`
  ADD CONSTRAINT `ertekelesek_ibfk_1` FOREIGN KEY (`foglalasok_id`) REFERENCES `foglalasok` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `foglalasok`
--
ALTER TABLE `foglalasok`
  ADD CONSTRAINT `foglalasok_ibfk_1` FOREIGN KEY (`felhasznalok_id`) REFERENCES `felhasznalok` (`id`),
  ADD CONSTRAINT `foglalasok_ibfk_2` FOREIGN KEY (`idopontok_id`) REFERENCES `idopontok` (`id`);

--
-- Megkötések a táblához `idopontok`
--
ALTER TABLE `idopontok`
  ADD CONSTRAINT `idopontok_ibfk_1` FOREIGN KEY (`szolgaltatok_id`) REFERENCES `szolgaltatok` (`id`);

--
-- Megkötések a táblához `szolgaltatok`
--
ALTER TABLE `szolgaltatok`
  ADD CONSTRAINT `szolgaltatok_ibfk_1` FOREIGN KEY (`szolgaltatas_tipusok_id`) REFERENCES `szolgaltatas_tipusok` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
