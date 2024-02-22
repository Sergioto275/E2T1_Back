SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES 'utf8mb4';

--
-- Base de datos: '3wag2e2'
--
-- DROP TABLE produktu_mugimendua;
-- DROP TABLE kolore_historiala;
-- DROP TABLE bezero_fitxa;
-- DROP TABLE produktua;
-- DROP TABLE kategoria;
-- DROP TABLE ticket_lerroa;
-- DROP TABLE tratamendua;
-- DROP TABLE hitzordua;
-- DROP TABLE materiala_erabili;
-- DROP TABLE materiala;
-- DROP TABLE txanda;
-- DROP TABLE langilea;
-- DROP TABLE ordutegia;
-- DROP TABLE taldea;
-- DROP TABLE erabiltzailea;

CREATE TABLE erabiltzailea (
	username VARCHAR(15),
	pasahitza VARCHAR(100),
	rola VARCHAR(2),
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_erabiltzailea PRIMARY KEY(username),
	CONSTRAINT CK_erabiltzailea_rola CHECK (rola IN ('IK','IR'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE taldea (
	kodea VARCHAR(5),
	izena VARCHAR(100),
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_taldea PRIMARY KEY(kodea)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ordutegia (
	id INT AUTO_INCREMENT,
	kodea VARCHAR(5) NOT NULL,
	eguna INT(1) NOT NULL,
	hasiera_data DATE NOT NULL,
	amaiera_data DATE NOT NULL,
	hasiera_ordua TIME NOT NULL,
	amaiera_ordua TIME NOT NULL,
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_ordutegia PRIMARY KEY(id),
	CONSTRAINT FK_ordutegia_taldea FOREIGN KEY (kodea) REFERENCES taldea(kodea),
	CONSTRAINT CK_ordutegia_eguna CHECK (eguna BETWEEN 1 AND 5)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE langilea (
	id INT AUTO_INCREMENT,
	izena VARCHAR(30) NOT NULL,
	kodea VARCHAR(5) NOT NULL,
	abizenak VARCHAR(100) NOT NULL,	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_langilea PRIMARY KEY(id),
	CONSTRAINT FK_langilea_taldea FOREIGN KEY (kodea) REFERENCES taldea(kodea)	
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE txanda (
	id INT AUTO_INCREMENT,
	mota VARCHAR(1) NOT NULL,
	data DATE NOT NULL,
	id_langilea INT NOT NULL,
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_txanda PRIMARY KEY(id),
	CONSTRAINT FK_txanda_langilea FOREIGN KEY (id_langilea) REFERENCES langilea(id),
	CONSTRAINT CK_txanda_mota CHECK (mota in ('G','M'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE materiala (
	id INT AUTO_INCREMENT,
	etiketa VARCHAR(10) NOT NULL,
	izena VARCHAR(100) NOT NULL,	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_materiala PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE materiala_erabili (
	id INT AUTO_INCREMENT,
	id_materiala INT NOT NULL,
	id_langilea INT NOT NULL,	
	hasiera_data DATETIME NOT NULL,
	amaiera_data DATETIME,	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_materiala_erabili PRIMARY KEY(id),
	CONSTRAINT FK_materiala_erabili_langilea FOREIGN KEY (id_langilea) REFERENCES langilea(id),
	CONSTRAINT FK_materiala_erabili_materiala FOREIGN KEY (id_materiala) REFERENCES materiala(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE hitzordua (
	id INT AUTO_INCREMENT,
	eserlekua INT NOT NULL,
	data DATE NOT NULL,
	hasiera_ordua TIME NOT NULL,
	amaiera_ordua TIME NOT NULL,
	hasiera_ordua_erreala TIME,
	amaiera_ordua_erreala TIME,
	izena VARCHAR(100) NOT NULL,
	telefonoa VARCHAR(9),
	deskribapena VARCHAR(250),
	etxekoa CHAR(1) NOT NULL,
	prezio_totala DECIMAL(10,2),
	id_langilea INT,		
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_hitzordua PRIMARY KEY(id),
	CONSTRAINT FK_hitzordua_langilea FOREIGN KEY (id_langilea) REFERENCES langilea(id),
	CONSTRAINT CK_hitzordua_etxekoa CHECK(etxekoa in ('E','K'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE kategoria_tratamendu (
  id int(11) NOT NULL,
  izena varchar(50) NOT NULL,
  kolorea char(1) NOT NULL,
  extra char(1) NOT NULL,
  sortze_data datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  eguneratze_data datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ezabatze_data datetime DEFAULT NULL,
  CONSTRAINT PK_kategoria_tratamendu PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tratamendua (
	id INT AUTO_INCREMENT,
	izena VARCHAR(100) NOT NULL,
	etxeko_prezioa DECIMAL(10,2) NOT NULL,
	kanpoko_prezioa DECIMAL(10,2) NOT NULL,
	id_katTratamendu int(11) NOT NULL,
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_tratamendua PRIMARY KEY(id),
	CONSTRAINT FK_katTratamendu FOREIGN KEY (id_katTratamendu) REFERENCES kategoria_tratamendu(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ticket_lerroa (
	id INT AUTO_INCREMENT,
	id_hitzordua INT NOT NULL,		
	id_tratamendua INT NOT NULL,
	prezioa DECIMAL(10,2) NOT NULL,
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_ticket_lerroa PRIMARY KEY(id),
	CONSTRAINT FK_ticket_lerroa_hitzordua FOREIGN KEY (id_hitzordua) REFERENCES hitzordua(id),
	CONSTRAINT FK_ticket_lerroa_tratamendua FOREIGN KEY (id_tratamendua) REFERENCES tratamendua(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE kategoria (
	id INT AUTO_INCREMENT,
	izena VARCHAR(100) NOT NULL,
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_kategoria PRIMARY KEY(id)	
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE produktua (
	id INT AUTO_INCREMENT,
	izena VARCHAR(100) NOT NULL,
	deskribapena VARCHAR(250),
	id_kategoria INT NOT NULL,
	marka VARCHAR(50) NOT NULL,
	stock INT NOT NULL,
	stock_alerta INT NOT NULL,	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_produktua PRIMARY KEY(id),
	CONSTRAINT FK_produktua_kategoria FOREIGN KEY (id_kategoria) REFERENCES kategoria(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE bezero_fitxa (
	id INT AUTO_INCREMENT,
	izena VARCHAR(100) NOT NULL,
	abizena VARCHAR(200) NOT NULL,
	telefonoa VARCHAR(9),
	azal_sentikorra CHAR(1) DEFAULT 'E',	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_bezero_fitxa PRIMARY KEY(id),
	CONSTRAINT CK_bezero_fitxa_azala CHECK (azal_sentikorra IN ('B','E'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE kolore_historiala (
	id INT AUTO_INCREMENT,
	id_bezeroa INT not null,
	id_produktua INT not null,
	data DATE not null,
	kantitatea INT,
	bolumena VARCHAR(100),
	oharrak VARCHAR(250),	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_kolore_historiala PRIMARY KEY(id),
	CONSTRAINT FK_kolore_historiala_produktua FOREIGN KEY (id_produktua) REFERENCES produktua(id),
	CONSTRAINT FK_kolore_historiala_bezeroa FOREIGN KEY (id_bezeroa) REFERENCES bezero_fitxa(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE produktu_mugimendua (
	id INT AUTO_INCREMENT,
	id_produktua INT NOT NULL,
	id_langilea INT NOT NULL,	
	data DATETIME NOT NULL,
	kopurua INT NOT NULL,	
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_produktu_mugimendua PRIMARY KEY(id),
	CONSTRAINT FK_produktu_mugimendua_produktua FOREIGN KEY (id_produktua) REFERENCES produktua(id),
	CONSTRAINT FK_produktu_mugimendua_langilea FOREIGN KEY (id_langilea) REFERENCES langilea(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `taldea`
--

INSERT INTO `taldea` (`kodea`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
('2PCC1', 'Peluqueria de primero', '2024-02-08 09:01:58', '2024-02-08 09:01:58', NULL),
('2PCC2', 'Peluqueros de segundo', '2024-02-08 09:02:23', '2024-02-08 09:02:23', NULL);

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

--
-- Volcado de datos para la tabla `hitzordua`
--

INSERT INTO `hitzordua` (`id`, `eserlekua`, `data`, `hasiera_ordua`, `amaiera_ordua`, `hasiera_ordua_erreala`, `amaiera_ordua_erreala`, `izena`, `telefonoa`, `deskribapena`, `etxekoa`, `prezio_totala`, `id_langilea`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(23, 1, '2024-02-08', '10:00:00', '12:30:00', NULL, NULL, 'Pablo', '692087563', 'Corte de pelo corto', 'E', NULL, NULL, '2024-02-08 09:31:42', '2024-02-08 09:31:42', NULL),
(24, 2, '2024-02-08', '11:00:00', '14:00:00', NULL, NULL, 'Eneko', '692087563', 'Se va a teñir el pelo', 'K', NULL, NULL, '2024-02-08 09:32:32', '2024-02-08 09:32:32', NULL),
(25, 4, '2024-02-08', '14:00:00', '16:00:00', NULL, NULL, 'Julian', '692087563', 'Se va a cortar el pelo  y peinarse', 'E', NULL, NULL, '2024-02-08 09:34:04', '2024-02-08 09:34:04', NULL);

--
-- Volcado de datos para la tabla `kategoria`
--

INSERT INTO `kategoria` (`id`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(3, 'Estilo Total', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(4, 'Cabello Chic\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(5, 'Belleza Capilar\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL),
(6, 'Salón Supplies\r\n', '2024-02-08 09:11:09', '2024-02-08 09:11:09', NULL);

--
-- Volcado de datos para la tabla `kategoria_tratamendu`
--

INSERT INTO `kategoria_tratamendu` (`id`, `izena`, `kolorea`, `extra`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(8, 'Cortes', 'n', 'n', '2024-02-08 09:22:25', '2024-02-08 09:22:25', NULL),
(9, 'Tintes', 's', 'n', '2024-02-08 09:22:57', '2024-02-08 09:22:57', NULL),
(10, 'Extras', 'n', 's', '2024-02-08 09:23:10', '2024-02-08 09:23:10', NULL),
(11, 'Manicura', 'n', 'n', '2024-02-08 09:23:29', '2024-02-08 09:23:29', NULL);


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

--
-- Volcado de datos para la tabla `ordutegia`
--

INSERT INTO `ordutegia` (`id`, `kodea`, `eguna`, `hasiera_data`, `amaiera_data`, `hasiera_ordua`, `amaiera_ordua`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, '2PCC1', 4, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(2, '2PCC1', 5, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(3, '2PCC1', 1, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:05', '2024-02-08 09:29:05', NULL),
(4, '2PCC2', 3, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:45', '2024-02-08 09:29:45', NULL),
(5, '2PCC2', 2, '2024-01-01', '2024-02-29', '09:00:00', '17:00:00', '2024-02-08 09:29:45', '2024-02-08 09:29:45', NULL);

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

COMMIT;