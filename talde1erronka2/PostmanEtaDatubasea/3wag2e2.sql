-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2024 a las 09:35:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `3wag2e2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bezero_fitxa`
--

CREATE TABLE `bezero_fitxa` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `abizena` varchar(200) NOT NULL,
  `telefonoa` varchar(9) DEFAULT NULL,
  `azal_sentikorra` char(1) DEFAULT 'E',
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erabiltzailea`
--

CREATE TABLE `erabiltzailea` (
  `username` varchar(15) NOT NULL,
  `pasahitza` varchar(100) DEFAULT NULL,
  `rola` varchar(2) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitzordua`
--

CREATE TABLE `hitzordua` (
  `id` int(11) NOT NULL,
  `eserlekua` int(11) NOT NULL,
  `data` date NOT NULL,
  `hasiera_ordua` time NOT NULL,
  `amaiera_ordua` time NOT NULL,
  `hasiera_ordua_erreala` time DEFAULT NULL,
  `amaiera_ordua_erreala` time DEFAULT NULL,
  `izena` varchar(100) NOT NULL,
  `telefonoa` varchar(9) DEFAULT NULL,
  `deskribapena` varchar(250) DEFAULT NULL,
  `etxekoa` char(1) NOT NULL,
  `prezio_totala` decimal(10,2) DEFAULT NULL,
  `id_langilea` int(11) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `hitzordua`
--

INSERT INTO `hitzordua` (`id`, `eserlekua`, `data`, `hasiera_ordua`, `amaiera_ordua`, `hasiera_ordua_erreala`, `amaiera_ordua_erreala`, `izena`, `telefonoa`, `deskribapena`, `etxekoa`, `prezio_totala`, `id_langilea`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(23, 1, '2024-02-08', '10:00:00', '12:30:00', NULL, NULL, 'Pablo', '692087563', 'Corte de pelo corto', 'E', NULL, NULL, '2024-02-08 09:31:42', '2024-02-08 09:31:42', NULL),
(24, 2, '2024-02-08', '11:00:00', '14:00:00', NULL, NULL, 'Eneko', '692087563', 'Se va a teñir el pelo', 'K', NULL, NULL, '2024-02-08 09:32:32', '2024-02-08 09:32:32', NULL),
(25, 4, '2024-02-08', '14:00:00', '16:00:00', NULL, NULL, 'Julian', '692087563', 'Se va a cortar el pelo  y peinarse', 'E', NULL, NULL, '2024-02-08 09:34:04', '2024-02-08 09:34:04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `kategoria`
--

INSERT INTO `kategoria` (`id`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(3, 'Estilo Total', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(4, 'Cabello Chic\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(5, 'Belleza Capilar\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(6, 'Salón Supplies\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kategoria_tratamendu`
--

CREATE TABLE `kategoria_tratamendu` (
  `id` int(11) NOT NULL,
  `izena` varchar(50) NOT NULL,
  `kolorea` char(1) NOT NULL,
  `extra` char(1) NOT NULL,
  `sortze_data` datetime NOT NULL DEFAULT current_timestamp(),
  `eguneratze_data` datetime NOT NULL DEFAULT current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `kategoria_tratamendu`
--

INSERT INTO `kategoria_tratamendu` (`id`, `izena`, `kolorea`, `extra`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(8, 'Cortes', 'n', 'n', '2024-02-08 09:22:25', '2024-02-08 09:22:25', NULL),
(9, 'Tintes', 's', 'n', '2024-02-08 09:22:57', '2024-02-08 09:22:57', NULL),
(10, 'Extras', 'n', 's', '2024-02-08 09:23:10', '2024-02-08 09:23:10', NULL),
(11, 'Manicura', 'n', 'n', '2024-02-08 09:23:29', '2024-02-08 09:23:29', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kolore_historiala`
--

CREATE TABLE `kolore_historiala` (
  `id` int(11) NOT NULL,
  `id_bezeroa` int(11) NOT NULL,
  `id_produktua` int(11) NOT NULL,
  `data` date NOT NULL,
  `kantitatea` int(11) DEFAULT NULL,
  `bolumena` varchar(100) DEFAULT NULL,
  `oharrak` varchar(250) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `langilea`
--

CREATE TABLE `langilea` (
  `id` int(11) NOT NULL,
  `izena` varchar(30) NOT NULL,
  `kodea` varchar(5) NOT NULL,
  `abizenak` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `langilea`
--

INSERT INTO `langilea` (`id`, `izena`, `kodea`, `abizenak`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(10, 'Julio', '2PCC2', 'Julio', '2024-02-08 09:03:04', '2024-02-08 09:03:04', NULL),
(11, 'Jesus', '2PCC2', 'de Nazaret', '2024-02-08 09:03:26', '2024-02-08 09:03:26', NULL),
(12, 'Lola', '2PCC1', 'Lolita', '2024-02-08 09:03:44', '2024-02-08 09:03:44', NULL),
(13, 'Samuel', '2PCC1', 'de Luca', '2024-02-08 09:04:15', '2024-02-08 09:04:15', NULL),
(14, 'David', '2PCC1', 'Canovas', '2024-02-08 09:04:25', '2024-02-08 09:04:25', NULL),
(15, 'Guillermo', '2PCC1', 'Diaz', '2024-02-08 09:04:35', '2024-02-08 09:04:35', NULL),
(16, 'Pedro', '2PCC2', 'Pascal', '2024-02-08 09:04:58', '2024-02-08 09:04:58', NULL),
(17, 'Ronald', '2PCC1', 'McDonald', '2024-02-08 09:06:19', '2024-02-08 09:06:19', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiala`
--

CREATE TABLE `materiala` (
  `id` int(11) NOT NULL,
  `etiketa` varchar(10) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiala`
--

INSERT INTO `materiala` (`id`, `etiketa`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'TIJ001', 'Tijeras', '2024-02-08 09:20:14', '2024-02-08 09:20:14', NULL),
(2, 'TIJ002', 'Tijeras', '2024-02-08 09:20:24', '2024-02-08 09:20:24', NULL),
(3, 'TIJ003', 'Tijeras', '2024-02-08 09:20:39', '2024-02-08 09:20:39', NULL),
(4, 'PLA001', 'Plancha', '2024-02-08 09:20:50', '2024-02-08 09:20:50', NULL),
(5, 'PLA002', 'Plancha', '2024-02-08 09:21:07', '2024-02-08 09:21:07', NULL),
(6, 'SEC001', 'Secador', '2024-02-08 09:21:23', '2024-02-08 09:21:23', NULL),
(7, 'SEC002', 'Secador', '2024-02-08 09:21:35', '2024-02-08 09:21:35', NULL),
(8, 'SEC003', 'Secador', '2024-02-08 09:21:44', '2024-02-08 09:21:44', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiala_erabili`
--

CREATE TABLE `materiala_erabili` (
  `id` int(11) NOT NULL,
  `id_materiala` int(11) NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `hasiera_data` datetime NOT NULL,
  `amaiera_data` datetime DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordutegia`
--

CREATE TABLE `ordutegia` (
  `id` int(11) NOT NULL,
  `kodea` varchar(5) NOT NULL,
  `eguna` int(1) NOT NULL,
  `hasiera_data` date NOT NULL,
  `amaiera_data` date NOT NULL,
  `hasiera_ordua` time NOT NULL,
  `amaiera_ordua` time NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `ordutegia`
--

INSERT INTO `ordutegia` (`id`, `kodea`, `eguna`, `hasiera_data`, `amaiera_data`, `hasiera_ordua`, `amaiera_ordua`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, '2PCC1', 4, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(2, '2PCC1', 5, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(3, '2PCC1', 1, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(4, '2PCC2', 3, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:45', '2024-02-08 09:29:45', NULL),
(5, '2PCC2', 2, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:45', '2024-02-08 09:29:45', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produktua`
--

CREATE TABLE `produktua` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `deskribapena` varchar(250) DEFAULT NULL,
  `id_kategoria` int(11) NOT NULL,
  `marka` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_alerta` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produktua`
--

INSERT INTO `produktua` (`id`, `izena`, `deskribapena`, `id_kategoria`, `marka`, `stock`, `stock_alerta`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(5, 'Champú Hidratante', 'Hidrata', 5, 'L\'Oréal Professionnel', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(6, 'Champú Voluminizador\r\n', 'Da volumen', 5, 'Redken', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(7, 'Acondicionador Reparador\r\n', 'Repara', 4, 'BaByliss Pro', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(8, 'Mascarilla Nutritiva\r\n', 'Nutre', 4, 'Remington', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(9, 'Planchas para el Cabello\r\n', 'Plancha', 3, 'Wella Professionals', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(10, 'Rizadores y Tenacillas\r\n', 'Riza', 3, 'Schwarzkopf Professional', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(11, 'Tintes para el Cabello\r\n', 'Pinta', 6, 'Olaplex', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(12, 'Decolorantes', 'Decolora', 6, 'Matrix Biolage', 0, 0, '2024-02-08 09:17:48', '2024-02-08 09:17:48', NULL),
(13, 'Champú Hidratante', 'Hidrata', 5, 'L\'Oréal Professionnel', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(14, 'Champú Voluminizador\r\n', 'Da volumen', 5, 'Redken', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(15, 'Acondicionador Reparador\r\n', 'Repara', 4, 'BaByliss Pro', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(16, 'Mascarilla Nutritiva\r\n', 'Nutre', 4, 'Remington', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(17, 'Planchas para el Cabello\r\n', 'Plancha', 3, 'Wella Professionals', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(18, 'Rizadores y Tenacillas\r\n', 'Riza', 3, 'Schwarzkopf Professional', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(19, 'Tintes para el Cabello\r\n', 'Pinta', 6, 'Olaplex', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL),
(20, 'Decolorantes', 'Decolora', 6, 'Matrix Biolage', 10, 5, '2024-02-08 09:18:50', '2024-02-08 09:18:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produktu_mugimendua`
--

CREATE TABLE `produktu_mugimendua` (
  `id` int(11) NOT NULL,
  `id_produktua` int(11) NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `kopurua` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taldea`
--

CREATE TABLE `taldea` (
  `kodea` varchar(5) NOT NULL,
  `izena` varchar(100) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `taldea`
--

INSERT INTO `taldea` (`kodea`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
('2PCC1', 'Peluqueria de primero', '2024-02-08 09:01:58', '2024-02-08 09:01:58', NULL),
('2PCC2', 'Peluqueros de segundo', '2024-02-08 09:02:23', '2024-02-08 09:02:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_lerroa`
--

CREATE TABLE `ticket_lerroa` (
  `id` int(11) NOT NULL,
  `id_hitzordua` int(11) NOT NULL,
  `id_tratamendua` int(11) NOT NULL,
  `prezioa` decimal(10,2) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamendua`
--

CREATE TABLE `tratamendua` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `etxeko_prezioa` decimal(10,2) NOT NULL,
  `kanpoko_prezioa` decimal(10,2) NOT NULL,
  `id_katTratamendu` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tratamendua`
--

INSERT INTO `tratamendua` (`id`, `izena`, `etxeko_prezioa`, `kanpoko_prezioa`, `id_katTratamendu`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(8, 'prueba', 20.00, 25.00, 8, '2024-02-08 09:25:50', '2024-02-08 09:26:00', '2024-02-08 09:26:00'),
(9, 'Corte', 5.00, 10.00, 8, '2024-02-08 09:26:17', '2024-02-08 09:26:17', NULL),
(10, 'Color Corto', 5.00, 10.00, 8, '2024-02-08 09:26:48', '2024-02-08 09:26:48', NULL),
(11, 'Color Medio', 10.00, 15.00, 8, '2024-02-08 09:27:01', '2024-02-08 09:27:01', NULL),
(12, 'Color Largo', 15.00, 20.00, 8, '2024-02-08 09:27:12', '2024-02-08 09:27:12', NULL),
(13, 'Extra', 0.00, 0.00, 8, '2024-02-08 09:27:40', '2024-02-08 09:27:40', NULL),
(14, 'Manicura', 10.00, 15.00, 8, '2024-02-08 09:27:56', '2024-02-08 09:27:56', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `txanda`
--

CREATE TABLE `txanda` (
  `id` int(11) NOT NULL,
  `mota` varchar(1) NOT NULL,
  `data` datetime NOT NULL,
  `amaiera_data` datetime NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bezero_fitxa`
--
ALTER TABLE `bezero_fitxa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `erabiltzailea`
--
ALTER TABLE `erabiltzailea`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_hitzordua_langilea` (`id_langilea`);

--
-- Indices de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kategoria_tratamendu`
--
ALTER TABLE `kategoria_tratamendu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_kolore_historiala_produktua` (`id_produktua`),
  ADD KEY `FK_kolore_historiala_bezeroa` (`id_bezeroa`);

--
-- Indices de la tabla `langilea`
--
ALTER TABLE `langilea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_langilea_taldea` (`kodea`);

--
-- Indices de la tabla `materiala`
--
ALTER TABLE `materiala`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_materiala_erabili_langilea` (`id_langilea`),
  ADD KEY `FK_materiala_erabili_materiala` (`id_materiala`);

--
-- Indices de la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ordutegia_taldea` (`kodea`);

--
-- Indices de la tabla `produktua`
--
ALTER TABLE `produktua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_produktua_kategoria` (`id_kategoria`);

--
-- Indices de la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_produktu_mugimendua_produktua` (`id_produktua`),
  ADD KEY `FK_produktu_mugimendua_langilea` (`id_langilea`);

--
-- Indices de la tabla `taldea`
--
ALTER TABLE `taldea`
  ADD PRIMARY KEY (`kodea`);

--
-- Indices de la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ticket_lerroa_hitzordua` (`id_hitzordua`),
  ADD KEY `FK_ticket_lerroa_tratamendua` (`id_tratamendua`);

--
-- Indices de la tabla `tratamendua`
--
ALTER TABLE `tratamendua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kategoria_tratamendu` (`id_katTratamendu`);

--
-- Indices de la tabla `txanda`
--
ALTER TABLE `txanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_txanda_langilea` (`id_langilea`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bezero_fitxa`
--
ALTER TABLE `bezero_fitxa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `kategoria_tratamendu`
--
ALTER TABLE `kategoria_tratamendu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `langilea`
--
ALTER TABLE `langilea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `materiala`
--
ALTER TABLE `materiala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produktua`
--
ALTER TABLE `produktua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tratamendua`
--
ALTER TABLE `tratamendua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `txanda`
--
ALTER TABLE `txanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  ADD CONSTRAINT `FK_hitzordua_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`);

--
-- Filtros para la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  ADD CONSTRAINT `FK_kolore_historiala_bezeroa` FOREIGN KEY (`id_bezeroa`) REFERENCES `bezero_fitxa` (`id`),
  ADD CONSTRAINT `FK_kolore_historiala_produktua` FOREIGN KEY (`id_produktua`) REFERENCES `produktua` (`id`);

--
-- Filtros para la tabla `langilea`
--
ALTER TABLE `langilea`
  ADD CONSTRAINT `FK_langilea_taldea` FOREIGN KEY (`kodea`) REFERENCES `taldea` (`kodea`);

--
-- Filtros para la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  ADD CONSTRAINT `FK_materiala_erabili_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`),
  ADD CONSTRAINT `FK_materiala_erabili_materiala` FOREIGN KEY (`id_materiala`) REFERENCES `materiala` (`id`);

--
-- Filtros para la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  ADD CONSTRAINT `FK_ordutegia_taldea` FOREIGN KEY (`kodea`) REFERENCES `taldea` (`kodea`);

--
-- Filtros para la tabla `produktua`
--
ALTER TABLE `produktua`
  ADD CONSTRAINT `FK_produktua_kategoria` FOREIGN KEY (`id_kategoria`) REFERENCES `kategoria` (`id`);

--
-- Filtros para la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  ADD CONSTRAINT `FK_produktu_mugimendua_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`),
  ADD CONSTRAINT `FK_produktu_mugimendua_produktua` FOREIGN KEY (`id_produktua`) REFERENCES `produktua` (`id`);

--
-- Filtros para la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  ADD CONSTRAINT `FK_ticket_lerroa_hitzordua` FOREIGN KEY (`id_hitzordua`) REFERENCES `hitzordua` (`id`),
  ADD CONSTRAINT `FK_ticket_lerroa_tratamendua` FOREIGN KEY (`id_tratamendua`) REFERENCES `tratamendua` (`id`);

--
-- Filtros para la tabla `tratamendua`
--
ALTER TABLE `tratamendua`
  ADD CONSTRAINT `fk_kategoria_tratamendu` FOREIGN KEY (`id_katTratamendu`) REFERENCES `kategoria_tratamendu` (`id`);

--
-- Filtros para la tabla `txanda`
--
ALTER TABLE `txanda`
  ADD CONSTRAINT `FK_txanda_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
