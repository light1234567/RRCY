-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_employee
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_citymuni`
--

DROP TABLE IF EXISTS `tbl_citymuni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_citymuni` (
  `psgc` varchar(20) NOT NULL,
  `col_citymuni` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`psgc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_citymuni`
--

LOCK TABLES `tbl_citymuni` WRITE;
/*!40000 ALTER TABLE `tbl_citymuni` DISABLE KEYS */;
INSERT INTO `tbl_citymuni` VALUES 
('112301000','ASUNCION (SAUG)'),
('112303000','CARMEN'),
('112305000','KAPALONG'),
('112314000','NEW CORELLA'),
('112315000','CITY OF PANABO'),
('112317000','ISLAND GARDEN CITY OF SAMAL'),
('112318000','SANTO TOMAS'),
('112319000','CITY OF TAGUM (Capital)'),
('112322000','TALAINGOD'),
('112323000','BRAULIO E. DUJALI'),
('112324000','SAN ISIDRO'),
('112401000','BANSALAN'),
('112402000','CITY OF DAVAO'),
('112403000','CITY OF DIGOS (Capital)'),
('112404000','HAGONOY'),
('112406000','KIBLAWAN'),
('112407000','MAGSAYSAY'),
('112408000','MALALAG'),
('112410000','MATANAO'),
('112411000','PADADA'),
('112412000','SANTA CRUZ'),
('112414000','SULOP'),
('112501000','BAGANGA'),
('112502000','BANAYBANAY'),
('112503000','BOSTON'),
('112504000','CARAGA'),
('112505000','CATEEL'),
('112506000','GOVERNOR GENEROSO'),
('112507000','LUPON'),
('112508000','MANAY'),
('112509000','CITY OF MATI (Capital)'),
('112510000','SAN ISIDRO'),
('112511000','TARRAGONA'),
('118201000','COMPOSTELA'),
('118202000','LAAK (SAN VICENTE)'),
('118203000','MABINI (DOÑA ALICIA)'),
('118204000','MACO'),
('118205000','MARAGUSAN (SAN MARIANO)'),
('118206000','MAWAB'),
('118207000','MONKAYO'),
('118208000','MONTEVISTA'),
('118209000','NABUNTURAN (Capital)'),
('118210000','NEW BATAAN'),
('118211000','PANTUKAN'),
('118601000','DON MARCELINO'),
('118602000','JOSE ABAD SANTOS (TRINIDAD)'),
('118603000','MALITA (Capital)'),
('118604000','SANTA MARIA'),
('118605000','SARANGANI');
/*!40000 ALTER TABLE `tbl_citymuni` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-01 14:15:08
