-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: cap
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `centro`
--

DROP TABLE IF EXISTS `centro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centro` (
  `centro` int(4) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro`
--

LOCK TABLES `centro` WRITE;
/*!40000 ALTER TABLE `centro` DISABLE KEYS */;
INSERT INTO `centro` VALUES (0,'Centralizadora'),(88,'Centro 88'),(90,'Centro 90');
/*!40000 ALTER TABLE `centro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cheque`
--

DROP TABLE IF EXISTS `cheque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheque` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `proceso` tinyint(2) NOT NULL DEFAULT '0',
  `archivo` char(20) NOT NULL DEFAULT '',
  `secuencia` int(10) NOT NULL DEFAULT '0',
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `seccab` int(10) NOT NULL DEFAULT '0',
  `seclote` int(10) NOT NULL DEFAULT '0',
  `secind` int(10) NOT NULL DEFAULT '0',
  `registro` char(94) NOT NULL DEFAULT '',
  `depent` int(4) NOT NULL DEFAULT '0',
  `depsuc` int(4) NOT NULL DEFAULT '0',
  `depcentro` int(4) NOT NULL DEFAULT '0',
  `reccentro` int(4) NOT NULL DEFAULT '0',
  `ent` int(4) NOT NULL DEFAULT '0',
  `suc` int(4) NOT NULL DEFAULT '0',
  `cp` int(4) NOT NULL DEFAULT '0',
  `cta` int(11) NOT NULL DEFAULT '0',
  `nro` int(8) NOT NULL DEFAULT '0',
  `importe` decimal(15,0) NOT NULL DEFAULT '0',
  `estado` tinyint(2) NOT NULL DEFAULT '0',
  `revisores` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fecha`,`proceso`,`archivo`,`secuencia`),
  KEY `cmc7` (`ent`,`suc`,`cp`,`cta`,`nro`),
  KEY `imp` (`importe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cheque`
--

LOCK TABLES `cheque` WRITE;
/*!40000 ALTER TABLE `cheque` DISABLE KEYS */;
INSERT INTO `cheque` VALUES ('2016-05-05',1,'CXXX',10,6,1,2,10,'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234',1,100,88,0,7,129,8300,71567,22369934,1234567,5,'admE1'),('2016-05-05',1,'CXXX',11,6,1,2,11,'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234',1,100,88,0,7,335,1642,13703,9793366,12345678,5,'admE1');
/*!40000 ALTER TABLE `cheque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cheque_rechazo`
--

DROP TABLE IF EXISTS `cheque_rechazo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheque_rechazo` (
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `proceso` tinyint(2) NOT NULL DEFAULT '0',
  `cmc7` char(29) NOT NULL DEFAULT '',
  `rechazo` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fecha`,`proceso`,`cmc7`,`rechazo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cheque_rechazo`
--

LOCK TABLES `cheque_rechazo` WRITE;
/*!40000 ALTER TABLE `cheque_rechazo` DISABLE KEYS */;
/*!40000 ALTER TABLE `cheque_rechazo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entidad`
--

DROP TABLE IF EXISTS `entidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entidad` (
  `ent` int(4) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT ' ',
  `logo` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entidad`
--

LOCK TABLES `entidad` WRITE;
/*!40000 ALTER TABLE `entidad` DISABLE KEYS */;
INSERT INTO `entidad` VALUES (1,'Entidad 1','logoent1.png');
/*!40000 ALTER TABLE `entidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `usuario` varchar(255) NOT NULL DEFAULT ' ',
  `ip` varchar(255) NOT NULL DEFAULT ' ',
  `evento` varchar(255) NOT NULL DEFAULT ' ',
  `clave` varchar(255) NOT NULL DEFAULT ' ',
  `datos` varchar(20000) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`),
  KEY `fechahora` (`fechahora`),
  KEY `clave` (`clave`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param`
--

DROP TABLE IF EXISTS `param`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `param` (
  `id` varchar(255) NOT NULL DEFAULT ' ',
  `valor` varchar(20000) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `param`
--

LOCK TABLES `param` WRITE;
/*!40000 ALTER TABLE `param` DISABLE KEYS */;
INSERT INTO `param` VALUES ('fecha01','2016-05-05'),('fecha_enviada','2016-05-05'),('Nivel','a:4:{i:0;O:5:\"Nivel\":2:{s:13:\"\0*\0properties\";a:2:{s:8:\"cantidad\";i:1;s:5:\"hasta\";i:10000;}s:5:\"\0*\0dt\";a:0:{}}i:1;O:5:\"Nivel\":2:{s:13:\"\0*\0properties\";a:2:{s:8:\"cantidad\";i:2;s:5:\"hasta\";i:20000;}s:5:\"\0*\0dt\";a:0:{}}i:2;O:5:\"Nivel\":2:{s:13:\"\0*\0properties\";a:2:{s:8:\"cantidad\";i:3;s:5:\"hasta\";i:30000;}s:5:\"\0*\0dt\";a:0:{}}i:3;O:5:\"Nivel\":2:{s:13:\"\0*\0properties\";a:2:{s:8:\"cantidad\";i:4;s:5:\"hasta\";d:99999999999999.984;}s:5:\"\0*\0dt\";a:0:{}}}'),('Rechazo','a:33:{i:0;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"1\";s:11:\"descripcion\";s:16:\"Cuenta Embargada\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:1;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"02\";s:11:\"descripcion\";s:33:\"Cuenta cerrada por orden judicial\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:2;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"3\";s:11:\"descripcion\";s:18:\"Cuenta inexistente\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:3;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"4\";s:11:\"descripcion\";s:27:\"Número de cuenta inválido\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:4;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"6\";s:11:\"descripcion\";s:17:\"Defectos formales\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:5;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"8\";s:11:\"descripcion\";s:81:\"Denuncia de extravío, sustracción o adulteración de cheque (orden de no pagar)\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:6;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:1:\"9\";s:11:\"descripcion\";s:34:\"Feriado local aplicado por las CEC\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:7;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"10\";s:11:\"descripcion\";s:23:\"Insuficiencia de fondos\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:8;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"11\";s:11:\"descripcion\";s:28:\"Excede el límite de endosos\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:9;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"13\";s:11:\"descripcion\";s:36:\"Sucursal/Entidad Destino inexistente\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:10;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:16;s:11:\"descripcion\";s:25:\"El documento no es cheque\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:11;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"17\";s:11:\"descripcion\";s:16:\"Error de formato\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:12;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"18\";s:11:\"descripcion\";s:31:\"Fecha de compensación errónea\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:13;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"21\";s:11:\"descripcion\";s:29:\"Cuenta en concurso preventivo\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:14;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"24\";s:11:\"descripcion\";s:22:\"Transacción duplicada\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:15;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:33;s:11:\"descripcion\";s:67:\"Cheque librado en fórmulas de cuadernos no entregadas por el Banco\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:16;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"34\";s:11:\"descripcion\";s:24:\"Situación de emergencia\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:17;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"35\";s:11:\"descripcion\";s:29:\"Falta conformidad de chequera\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:18;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:36;s:11:\"descripcion\";s:23:\"Adulteración de cheque\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:19;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:37;s:11:\"descripcion\";s:30:\"Plazo de validez legal vencido\";s:11:\"depositaria\";i:1;s:6:\"girada\";i:0;}s:5:\"\0*\0dt\";a:0:{}}i:20;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:38;s:11:\"descripcion\";s:45:\"No coincide firma librador y salvado al dorso\";s:11:\"depositaria\";i:1;s:6:\"girada\";i:0;}s:5:\"\0*\0dt\";a:0:{}}i:21;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"39\";s:11:\"descripcion\";s:46:\"Importe distinto con reg. Por banco Girado CPD\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:22;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"44\";s:11:\"descripcion\";s:48:\"Valores Sust. o extr. de chequeras no entregadas\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:23;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:46;s:11:\"descripcion\";s:42:\"Diseño no compensable / pagadero por caja\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:24;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:47;s:11:\"descripcion\";s:36:\"No corresponde segunda presentación\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:25;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"79\";s:11:\"descripcion\";s:75:\"Error en campo 7 Registro Individual (Tipo de documento/ número de Cheque)\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:26;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"81\";s:11:\"descripcion\";s:12:\"Fuerza Mayor\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:27;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"82\";s:11:\"descripcion\";s:15:\"Imagen faltante\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:28;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"83\";s:11:\"descripcion\";s:37:\"Irregularidad en la cadena de endosos\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:29;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"93\";s:11:\"descripcion\";s:17:\"Día no laborable\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:30;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"94\";s:11:\"descripcion\";s:23:\"Código postal erróneo\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:31;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";i:96;s:11:\"descripcion\";s:27:\"Errores Entidad depositaria\";s:11:\"depositaria\";s:1:\"1\";s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}i:32;O:7:\"Rechazo\":2:{s:13:\"\0*\0properties\";a:4:{s:6:\"numero\";s:2:\"97\";s:11:\"descripcion\";s:24:\"Presentación adelantada\";s:11:\"depositaria\";N;s:6:\"girada\";s:1:\"1\";}s:5:\"\0*\0dt\";a:0:{}}}');
/*!40000 ALTER TABLE `param` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `id` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT ' ',
  `ent` int(4) NOT NULL,
  `suc` int(4) NOT NULL,
  `centro` int(4) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT ' ',
  `estado` enum('ACTIVO','BLOQUEADO') NOT NULL DEFAULT 'ACTIVO',
  `permisos` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id`),
  KEY `ent` (`ent`),
  KEY `suc` (`suc`),
  KEY `centro` (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES ('admE1','Administrador 1',1,0,88,'info@gestion-e.com.ar','ACTIVO','ew,rw,cw,es,rs,cs,eq,rq,cq,sw,ap,ai,au'),('admE2','Administrador 2',1,100,88,'info@gestion-e.com.ar','ACTIVO','ew,cw,rs,eq,cq,ap,au'),('admE3','Administrador 3',1,100,88,'info@gestion-e.com.ar','ACTIVO','ew,rw,cw,es,rs,cs,eq,rq,cq,ap,ai,au'),('admE4','Administrador 4',1,100,88,'info@gestion-e.com.ar','ACTIVO','ew,rw,cw,es,rs,cs,eq,rq,cq,ap,ai,au'),('admE5','Administrador 5',1,100,88,'info@gestion-e.com.ar','ACTIVO','ew,rw,cw,es,rs,cs,eq,rq,cq,ap,ai,au'),('admE6','Administrador 6',1,100,88,'info@gestion-e.com.ar','ACTIVO','ew,rw,cw,es,rs,cs,eq,rq,cq,ap,ai,au'),('admE9','Administrador 9',1,0,88,'info@gestion-e.com.ar','ACTIVO','ew,es,eq'),('ew1','Revisor de Enviada',1,100,0,'info@gestion-e.com.ar','ACTIVO','ew');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursal` (
  `ent` int(4) NOT NULL,
  `suc` int(4) NOT NULL,
  `centro` int(4) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT ' ',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ent`,`suc`),
  KEY `centro` (`centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal`
--

LOCK TABLES `sucursal` WRITE;
/*!40000 ALTER TABLE `sucursal` DISABLE KEYS */;
INSERT INTO `sucursal` VALUES (1,0,0,'Centralizadora','daniel.donantueno@gestion-e.com.ar'),(1,100,88,'Sucursal 100','daniel.donantueno@gestion-e.com.ar'),(1,101,90,'Sucursal 102','daniel.donantueno@gestion-e.com.ar'),(1,102,88,'Sucursal 102','daniel.donantueno@gestion-e.com.ar');
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-21  3:04:15
