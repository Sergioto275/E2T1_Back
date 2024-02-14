SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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

CREATE TABLE tratamendua (
	id INT AUTO_INCREMENT,
	izena VARCHAR(100) NOT NULL,
	etxeko_prezioa DECIMAL(10,2) NOT NULL,
	kanpoko_prezioa DECIMAL(10,2) NOT NULL,		
	sortze_data DATETIME DEFAULT CURRENT_TIMESTAMP,
    eguneratze_data DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ezabatze_data DATETIME,
	CONSTRAINT PK_tratamendua PRIMARY KEY(id)
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

COMMIT;