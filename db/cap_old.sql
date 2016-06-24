-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-04-2016 a las 16:23:53
-- Versión del servidor: 5.5.47
-- Versión de PHP: 5.4.45-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `cap`
--
drop database cap;
create database cap;
USE cap;




--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` varchar(255)NOT NULL,
  `nombre` varchar(255)NOT NULL DEFAULT ' ',
  `ent` int(4)NOT NULL,
  `suc` int(4)NOT NULL,
  `centro` int(4)NOT NULL,
  `email` varchar(255)NOT NULL DEFAULT ' ',
  `estado` enum('ACTIVO','BLOQUEADO') NOT NULL DEFAULT 'ACTIVO',
  `permisos` varchar(255)NOT NULL DEFAULT ' ',

  PRIMARY KEY (`id`),
  KEY `ent` (`ent`),
  KEY `suc` (`suc`),
  KEY `centro` (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `entidad` (
  `ent` int(4)NOT NULL,
  `nombre` varchar(255)NOT NULL DEFAULT ' ',
  `logo` varchar(255)NOT NULL DEFAULT ' ',

  PRIMARY KEY (`ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `sucursal` (
  `ent` int(4)NOT NULL,
  `suc` int(4)NOT NULL,
  `centro` int(4)NOT NULL,
  `nombre` varchar(255)NOT NULL DEFAULT ' ',

  PRIMARY KEY (ent, suc),
  KEY `centro` (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `centro` (
  `centro` int(4)NOT NULL,
  `nombre` varchar(255)NOT NULL DEFAULT ' ',

  PRIMARY KEY (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `log` (
  `fechahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usuario` varchar(255)NOT NULL DEFAULT ' ',
  `transaccion` varchar(255)NOT NULL DEFAULT ' ',
  `clave` varchar(1023) NOT NULL DEFAULT ' ',
  `datos` varchar(20000) NOT NULL DEFAULT ' ',

  PRIMARY KEY (`fechahora`,`usuario`),
  KEY `transaccion` (`transaccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `cheque` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `proceso` tinyint(2) NOT NULL DEFAULT '0',
  `archivo` char(20)NOT NULL DEFAULT ' ',
  `secuencia` int(10) NOT NULL DEFAULT '0',
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `seccab` int(10) NOT NULL DEFAULT '0',
  `seclote` int(10) NOT NULL DEFAULT '0',
  `secind` int(10) NOT NULL DEFAULT '0',
  `registro` char(94)NOT NULL DEFAULT ' ',
  `depent` int(4) NOT NULL DEFAULT '0',
  `depsuc` int(4) NOT NULL DEFAULT '0',
  `ent` int(4) NOT NULL DEFAULT '0',
  `suc` int(4) NOT NULL DEFAULT '0',
  `cp`  int(4) NOT NULL DEFAULT '0',
  `cta`  int(11) NOT NULL DEFAULT '0',
  `nro`  int(8) NOT NULL DEFAULT '0',
  `importe`  decimal(15) NOT NULL DEFAULT '0',
  `estado`  tinyint(2) NOT NULL DEFAULT '0',
  `revisores` char(255)NOT NULL DEFAULT '',

  PRIMARY KEY (`fecha`,`proceso`,`archivo`,`secuencia`),
  KEY `cmc7` (`ent`,`suc`,`cp`,`cta`,`nro`),
  KEY `imp` (`importe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cheque_rechazo` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `proceso` tinyint(2) NOT NULL DEFAULT '0',
  `cmc7` char(29) NOT NULL DEFAULT '',
  `rechazo` tinyint(2)NOT NULL DEFAULT '0',

  PRIMARY KEY (`fecha`,`proceso`,`cmc7`,`rechazo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `param` (
  `id` varchar(255)NOT NULL DEFAULT ' ',
  `valor` varchar(20000)NOT NULL DEFAULT ' ',

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- Volcado de datos para la tabla `persona`
--

INSERT INTO `param` (`id`, `valor` ) VALUES
('fecha01', '2016-05-05');

INSERT INTO `param` (`id`, `valor` ) VALUES
('Nivel', 'a:4:{i:0;O:5:"Nivel":2:{s:13:" * properties";a:2:{s:8:"cantidad";i:1;s:5:"hasta";i:10000;}s:5:" * dt";a:0:{}}i:1;O:5:"Nivel":2:{s:13:" * properties";a:2:{s:8:"cantidad";i:2;s:5:"hasta";i:20000;}s:5:" * dt";a:0:{}}i:2;O:5:"Nivel":2:{s:13:" * properties";a:2:{s:8:"cantidad";i:3;s:5:"hasta";i:30000;}s:5:" * dt";a:0:{}}i:3;O:5:"Nivel":2:{s:13:" * properties";a:2:{s:8:"cantidad";i:4;s:5:"hasta";d:99999999999999.984;}s:5:" * dt";a:0:{}}}');


INSERT INTO `persona` (`id`, `nombre`, `ent`, `suc`, `centro`, `estado`, `permisos`  ) VALUES
('admE1', 'Administrador 1', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),
('admE2', 'Administrador 2', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),
('admE3', 'Administrador 3', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),
('admE4', 'Administrador 4', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),
('admE5', 'Administrador 5', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),
('admE6', 'Administrador 6', 1, 100, 88,  'ACTIVO', 'ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au');

INSERT INTO `entidad` (`ent`, `nombre`, `logo` ) VALUES
(1, 'Entidad 1', 'logoent1.png');

INSERT INTO `sucursal` (`ent`, `suc`, `centro`, `nombre`  ) VALUES
(1, 100, 88, 'Sucursal 100');

INSERT INTO `centro` (`centro`, `nombre`  ) VALUES
(88, 'Centro 88');

INSERT INTO `cheque` (`fecha`, `proceso`, `archivo`, `secuencia`, `tipo`, `seccab`, `seclote`, `secind`, `registro`, `depent`, `depsuc`,
                      `ent`, `suc`, `cp`, `cta`, `nro`, `importe`, `estado`) VALUES
('2016-05-05', 1, 'CXXX', 10, 6, 1, 2, 10, 
'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234',
1, 100, 7, 129, 8300, 71567, 22369934, 1234567, 0);  

INSERT INTO `cheque` (`fecha`, `proceso`, `archivo`, `secuencia`, `tipo`, `seccab`, `seclote`, `secind`, `registro`, `depent`, `depsuc`,
                      `ent`, `suc`, `cp`, `cta`, `nro`, `importe`, `estado`) VALUES
('2016-05-05', 1, 'CXXX', 11, 6, 1, 2, 11, 
'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234',
1, 100, 7, 335, 1642, 13703, 9793366, 12345678, 0);  

INSERT INTO `param` (`id`, `valor` ) VALUES
('Rechazo', 'a:10:{i:0;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:11;s:11:"descripcion";s:28:"Excede el límite de endosos";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:1;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:16;s:11:"descripcion";s:25:"El documento no es cheque";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:2;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:33;s:11:"descripcion";s:67:"Cheque librado en fórmulas de cuadernos no entregadas por el Banco";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:3;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:36;s:11:"descripcion";s:23:"Adulteración de cheque";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:4;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:37;s:11:"descripcion";s:30:"Plazo de validez legal vencido";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:5;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:38;s:11:"descripcion";s:45:"No coincide firma librador y salvado al dorso";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:6;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:46;s:11:"descripcion";s:42:"Diseño no compensable / pagadero por caja";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:7;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:47;s:11:"descripcion";s:36:"No corresponde segunda presentación";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:8;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:83;s:11:"descripcion";s:37:"Irregularidad en la cadena de endosos";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}i:9;O:7:"Rechazo":2:{s:13:" * properties";a:4:{s:6:"numero";i:96;s:11:"descripcion";s:27:"Errores Entidad depositaria";s:11:"depositaria";i:1;s:6:"girada";i:0;}s:5:" * dt";a:0:{}}}');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;