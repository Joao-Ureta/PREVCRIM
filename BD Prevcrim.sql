CREATE DATABASE  IF NOT EXISTS `prevcrim` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `prevcrim`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: prevcrim
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `bitacora_accesos`
--

DROP TABLE IF EXISTS `bitacora_accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bitacora_accesos` (
  `id_acceso` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `fecha_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `actividad` text,
  PRIMARY KEY (`id_acceso`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `bitacora_accesos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora_accesos`
--

LOCK TABLES `bitacora_accesos` WRITE;
/*!40000 ALTER TABLE `bitacora_accesos` DISABLE KEYS */;
/*!40000 ALTER TABLE `bitacora_accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciudad` (
  `id_ciudad` int NOT NULL AUTO_INCREMENT,
  `nombre_ciudad` varchar(100) NOT NULL,
  `id_region` int NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  KEY `id_region` (`id_region`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudad`
--

LOCK TABLES `ciudad` WRITE;
/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
INSERT INTO `ciudad` VALUES (1,'Chacabuco',7),(2,'Cordillera',7),(3,'Maipo',7),(4,'Melipilla',7),(5,'Santiago',7),(6,'Talagante',7);
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comuna`
--

DROP TABLE IF EXISTS `comuna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comuna` (
  `id_comuna` int NOT NULL AUTO_INCREMENT,
  `nombre_comuna` varchar(100) NOT NULL,
  `id_ciudad` int NOT NULL,
  PRIMARY KEY (`id_comuna`),
  KEY `id_ciudad` (`id_ciudad`),
  CONSTRAINT `comuna_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comuna`
--

LOCK TABLES `comuna` WRITE;
/*!40000 ALTER TABLE `comuna` DISABLE KEYS */;
INSERT INTO `comuna` VALUES (1,'Colina',1),(2,'Lampa',1),(3,'TilTil',1),(4,'Pirque',2),(5,'Puente Alto',2),(6,'San Jose de Maipo',2),(7,'Buin',3),(8,'Calera de Tango',3),(9,'Paine',3),(10,'San Bernardo',3),(11,'Alhué',4),(12,'Curacaví',4),(13,'Maria Pinto',4),(14,'Melipilla',4),(15,'San Pedro',4),(16,'Cerrillos',5),(17,'Cerro Navia',5),(18,'Conchalí',5),(19,'El Bosque',5),(20,'Estacion Central',5),(21,'Huechuraba',5),(22,'Independencia',5),(23,'La Cisterna',5),(24,'La Florida',5),(25,'La Granja',5),(26,'La Pintana',5),(27,'La Reina',5),(28,'Las Condes',5),(29,'Lo Barnechea',5),(30,'Lo Espejo',5),(31,'Lo Prado',5),(32,'Macul',5),(33,'Maipú',5),(34,'Ñuñoa',5),(35,'Pedro Aguirre Cerda',5),(36,'Peñalolen',5),(37,'Providencia',5),(38,'Pudahuel',5),(39,'Quilicura',5),(40,'Quinta Normal',5),(41,'Recoleta',5),(42,'Renca',5),(43,'San Joaquin',5),(44,'San Miguel',5),(45,'San Ramón',5),(46,'Santiago',5),(47,'Vitacura',5),(48,'El Monte',6),(49,'Isla de Maipo',6),(50,'Padre Hurtado',6),(51,'Peñaflor',6),(52,'Talagante',6);
/*!40000 ALTER TABLE `comuna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delincuente`
--

DROP TABLE IF EXISTS `delincuente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delincuente` (
  `id_delincuente` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `rut` varchar(12) DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `genero` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `apodo` varchar(100) DEFAULT NULL,
  `antecedentes` text,
  `foto` varchar(255) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `id_sector` int DEFAULT NULL,
  `estado_judicial` enum('Preso','Libre','Orden de arresto') NOT NULL DEFAULT 'Libre',
  `id_comuna` int DEFAULT NULL,
  `direccion_particular` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_delincuente`),
  UNIQUE KEY `rut` (`rut`),
  KEY `id_sector` (`id_sector`),
  KEY `id_comuna` (`id_comuna`),
  CONSTRAINT `delincuente_ibfk_1` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id_sector`) ON DELETE CASCADE,
  CONSTRAINT `delincuente_ibfk_2` FOREIGN KEY (`id_comuna`) REFERENCES `comuna` (`id_comuna`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delincuente`
--

LOCK TABLES `delincuente` WRITE;
/*!40000 ALTER TABLE `delincuente` DISABLE KEYS */;
INSERT INTO `delincuente` VALUES (1,'Axel leopoldo Soto revira','17.838.923-5',34,'Masculino','El Ragnar','Trafico ilícito de drogas','estaticos/img/delincuente4.jpg\r\n','Chileno',1,'Libre',35,'Los porros 2727'),(2,'Nikens Nikens Pierre du Perfum','19.356.487-6',25,'Masculino','El Maluco','Robo con violencia','estaticos/img/delincuente5.jpg\r\n','Chileno',5,'Preso',20,'Toro Mazote 5687'),(3,'Joao Edson Ureta Mardones','17.424.065-5',35,'Masculino','El Joaito','Tráfico ilícito de drogas','estaticos/img/delincuente6.jpeg\r\n','Chileno',1,'Orden de arresto',38,'Rio Baker 5569'),(4,'Carlos Andrés Soto Muñoz','19.456.789-2',32,'Masculino','El Flaco Soto','Condenado por robo con intimidación (2017), porte ilegal de arma (2019), reincidencia en hurto (2022).','estaticos/img/delincuente1.jpg','Chileno',1,'Preso',20,'Avenida Ecuador 4495'),(5,'Luis Eduardo Rivas Contreras','17.234.567-8',41,'Masculino','El Gato','Antecedentes por tráfico de drogas (2016), amenazas a carabineros (2020), receptación (2023).','estaticos/img/delincuente2.jpg','Chileno',2,'Preso',26,'Ya no se me ocurre 2223'),(6,'José Manuel Paredes González','18.987.654-3',28,'Masculino','El Chispa','Registro por robo de vehículo (2019), homicidio frustrado (2021), fuga de recinto penitenciario (2022).','estaticos/img/delincuente3.jpg','Chileno',3,'Preso',17,'Alpatacal 9294'),(8,'Camila Andrea Bormann Carrero','19.695.452-9',25,'Femenino','La Chihuahua','Violencia domestica (2025)','estaticos/img/delincuente7.jpeg','Chileno',5,'Libre',31,'Los tamarindos 2287');
/*!40000 ALTER TABLE `delincuente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delito`
--

DROP TABLE IF EXISTS `delito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delito` (
  `id_delito` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `descripcion` text,
  `id_tipo_delito` int DEFAULT NULL,
  `id_sector` int DEFAULT NULL,
  `id_institucion` int DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_delito`),
  KEY `id_tipo_delito` (`id_tipo_delito`),
  KEY `id_sector` (`id_sector`),
  KEY `id_institucion` (`id_institucion`),
  CONSTRAINT `delito_ibfk_1` FOREIGN KEY (`id_tipo_delito`) REFERENCES `tipo_delito` (`id_tipo_delito`) ON DELETE CASCADE,
  CONSTRAINT `delito_ibfk_2` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id_sector`) ON DELETE CASCADE,
  CONSTRAINT `delito_ibfk_3` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delito`
--

LOCK TABLES `delito` WRITE;
/*!40000 ALTER TABLE `delito` DISABLE KEYS */;
INSERT INTO `delito` VALUES (1,'2025-01-01 02:08:42','Un individuo armado intimidó a una pareja para robarles sus pertenencias mientras caminaban por la vía pública. El delincuente huyó hacia una población cercana. Carabineros llegó minutos después tras el llamado de testigos.',1,1,1,33.46594357,-70.70394318),(2,'2025-04-05 08:30:00','Un individuo fue detenido tras ser sorprendido intentando robar una tienda en el centro comercial. Fue capturado por Carabineros después de que la alarma de seguridad se activara.',1,1,1,-33.46506000,-70.64840000),(3,'2025-04-06 20:45:00','Una persona fue arrestada por posesión de drogas al ser interceptada por Carabineros en un sector de la comuna de La Florida. La sustancia incautada dio positivo a cocaína.',3,3,1,-33.56007000,-70.62165000),(4,'2025-04-07 18:00:00','Un hombre fue detenido por robo en un supermercado tras sustraer productos sin pagarlos. Fue capturado por seguridad y entregado a la PDI.',5,2,2,-33.43282000,-70.64440000),(5,'2025-04-07 22:30:00','Un automóvil fue robado durante la noche mientras estaba estacionado en una calle de la comuna de Maipú. El robo fue reportado por el propietario y la PDI está realizando las investigaciones.',1,5,2,-33.50036000,-70.80150000),(7,'2025-04-05 08:30:00','Un individuo fue detenido tras ser sorprendido intentando robar una tienda en el centro comercial. Fue capturado por Carabineros después de que la alarma de seguridad se activara.',1,1,1,-33.46506000,-70.64840000),(8,'2025-04-06 20:45:00','Una persona fue arrestada por posesión de drogas al ser interceptada por Carabineros en un sector de la comuna de La Florida. La sustancia incautada dio positivo a cocaína.',3,3,1,-33.56007000,-70.62165000),(9,'2025-04-07 18:00:00','Un hombre fue detenido por robo en un supermercado tras sustraer productos sin pagarlos. Fue capturado por seguridad y entregado a la PDI.',5,2,2,-33.43282000,-70.64440000),(10,'2025-04-07 22:30:00','Un automóvil fue robado durante la noche mientras estaba estacionado en una calle de la comuna de Maipú. El robo fue reportado por el propietario y la PDI está realizando las investigaciones.',1,5,2,-33.50036000,-70.80150000),(12,'2025-04-09 01:00:41','Mujer agrede a su pareja por infidelidad',6,5,1,-33.43902030,-70.70650240);
/*!40000 ALTER TABLE `delito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delito_delincuente`
--

DROP TABLE IF EXISTS `delito_delincuente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delito_delincuente` (
  `id_delito` int NOT NULL,
  `id_delincuente` int NOT NULL,
  `rol_en_el_delito` varchar(50) DEFAULT NULL,
  `id_tipo_delito` int DEFAULT NULL,
  PRIMARY KEY (`id_delito`,`id_delincuente`),
  KEY `id_delincuente` (`id_delincuente`),
  KEY `id_tipo_delito` (`id_tipo_delito`),
  CONSTRAINT `delito_delincuente_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  CONSTRAINT `delito_delincuente_ibfk_2` FOREIGN KEY (`id_delincuente`) REFERENCES `delincuente` (`id_delincuente`) ON DELETE CASCADE,
  CONSTRAINT `delito_delincuente_ibfk_3` FOREIGN KEY (`id_tipo_delito`) REFERENCES `tipo_delito` (`id_tipo_delito`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delito_delincuente`
--

LOCK TABLES `delito_delincuente` WRITE;
/*!40000 ALTER TABLE `delito_delincuente` DISABLE KEYS */;
INSERT INTO `delito_delincuente` VALUES (2,2,'Autor',1),(3,1,'Autor',3),(3,5,'Cómplice',3),(5,6,'Cómplice',5),(9,3,'Autor',1),(10,4,'Autor',1),(12,8,'Autor',6);
/*!40000 ALTER TABLE `delito_delincuente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delito_victima`
--

DROP TABLE IF EXISTS `delito_victima`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delito_victima` (
  `id_delito` int NOT NULL,
  `id_victima` int NOT NULL,
  PRIMARY KEY (`id_delito`,`id_victima`),
  KEY `id_victima` (`id_victima`),
  CONSTRAINT `delito_victima_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  CONSTRAINT `delito_victima_ibfk_2` FOREIGN KEY (`id_victima`) REFERENCES `victima` (`id_victima`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delito_victima`
--

LOCK TABLES `delito_victima` WRITE;
/*!40000 ALTER TABLE `delito_victima` DISABLE KEYS */;
/*!40000 ALTER TABLE `delito_victima` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denuncia`
--

DROP TABLE IF EXISTS `denuncia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `denuncia` (
  `id_denuncia` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `descripcion` text,
  `medio` varchar(100) DEFAULT NULL,
  `lugar_delito` varchar(255) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_delito` int DEFAULT NULL,
  PRIMARY KEY (`id_denuncia`),
  KEY `id_delito` (`id_delito`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `denuncia_ibfk_1` FOREIGN KEY (`id_delito`) REFERENCES `delito` (`id_delito`) ON DELETE CASCADE,
  CONSTRAINT `denuncia_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denuncia`
--

LOCK TABLES `denuncia` WRITE;
/*!40000 ALTER TABLE `denuncia` DISABLE KEYS */;
/*!40000 ALTER TABLE `denuncia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institucion`
--

DROP TABLE IF EXISTS `institucion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institucion` (
  `id_institucion` int NOT NULL AUTO_INCREMENT,
  `nombre_institucion` varchar(100) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `id_comuna` int DEFAULT NULL,
  PRIMARY KEY (`id_institucion`),
  KEY `id_comuna` (`id_comuna`),
  CONSTRAINT `institucion_ibfk_1` FOREIGN KEY (`id_comuna`) REFERENCES `comuna` (`id_comuna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institucion`
--

LOCK TABLES `institucion` WRITE;
/*!40000 ALTER TABLE `institucion` DISABLE KEYS */;
INSERT INTO `institucion` VALUES (1,'Carabineros de Chile','Avenida Bernardo O\'Higgins 1196','(2) 2922 0000',NULL,-33.50245786,-70.77273080,33),(2,'Seguridad OS-10','Huérfanos 540','(2) 9220760',NULL,-33.43896791,-70.64460537,46),(3,'Paz Ciudadana','Valenzuela Castillo 1881','(2) 2 2 363 38 00',NULL,-33.43370080,-70.61127105,37);
/*!40000 ALTER TABLE `institucion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `region` (
  `id_region` int NOT NULL AUTO_INCREMENT,
  `nombre_region` varchar(100) NOT NULL,
  PRIMARY KEY (`id_region`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Región de Arica y Parinacota'),(2,'Región de Tarapacá'),(3,'Región de Antofagasta'),(4,'Región de Atacama'),(5,'Región de Coquimbo'),(6,'Región de Valparaíso'),(7,'Región Metropolitana de Santiago'),(8,'Región del Libertador General Bernardo O\'Higgins'),(9,'Región del Maule'),(10,'Región de Ñuble'),(11,'Región del Biobío'),(12,'Región de La Araucanía'),(13,'Región de Los Ríos'),(14,'Región de Los Lagos'),(15,'Región de Aysén del General Carlos Ibáñez del Campo'),(16,'Región de Magallanes y de la Antártica Chilena');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sector`
--

DROP TABLE IF EXISTS `sector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sector` (
  `id_sector` int NOT NULL AUTO_INCREMENT,
  `nombre_sector` varchar(100) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_sector`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sector`
--

LOCK TABLES `sector` WRITE;
/*!40000 ALTER TABLE `sector` DISABLE KEYS */;
INSERT INTO `sector` VALUES (1,'Centro',-33.44890000,-70.66930000),(2,'Norte',-33.36000000,-70.73300000),(3,'Nororiente',-33.39720000,-70.59860000),(4,'Suroriente',-33.55000000,-70.58000000),(5,'Sur',-33.58500000,-70.68000000);
/*!40000 ALTER TABLE `sector` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sentencia`
--

DROP TABLE IF EXISTS `sentencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sentencia` (
  `id_sentencia` int NOT NULL AUTO_INCREMENT,
  `id_delincuente` int DEFAULT NULL,
  `tribunal` varchar(100) DEFAULT NULL,
  `fecha_sentencia` date DEFAULT NULL,
  `condena` text,
  PRIMARY KEY (`id_sentencia`),
  KEY `id_delincuente` (`id_delincuente`),
  CONSTRAINT `sentencia_ibfk_1` FOREIGN KEY (`id_delincuente`) REFERENCES `delincuente` (`id_delincuente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sentencia`
--

LOCK TABLES `sentencia` WRITE;
/*!40000 ALTER TABLE `sentencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `sentencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_delito`
--

DROP TABLE IF EXISTS `tipo_delito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_delito` (
  `id_tipo_delito` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(100) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id_tipo_delito`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_delito`
--

LOCK TABLES `tipo_delito` WRITE;
/*!40000 ALTER TABLE `tipo_delito` DISABLE KEYS */;
INSERT INTO `tipo_delito` VALUES (1,'Robo con violencia o intimidación','Delito que consiste en apoderarse de una cosa mueble ajena con ánimo de lucro, empleando violencia física o amenazas sobre las personas para conseguir el propósito. Regulado en el Art. 436 del Código Penal.'),(2,'Homicidio','Delito que consiste en causar la muerte a otra persona. Puede ser simple, calificado, frustrado o tentado. Artículos 391 y siguientes del Código Penal.'),(3,'Tráfico ilícito de drogas','Conducta que implica producir, transportar, distribuir o vender sustancias estupefacientes o psicotrópicas prohibidas. Regulado por la Ley 20.000.'),(4,'Porte ilegal de arma de fuego','Delito que consiste en portar armas de fuego sin la autorización correspondiente. Regulado por la Ley 17.798 sobre control de armas.'),(5,'Receptación','Delito que consiste en adquirir, vender, guardar o esconder bienes robados o hurtados, sabiendo su procedencia ilícita. Art. 456 bis A del Código Penal.'),(6,'Violencia intrafamiliar','Ejercicio de violencia física o psicológica en contra de un miembro del grupo familiar. Regulado por la Ley 20.066.'),(7,'Abuso sexual','Delito que consiste en realizar actos de significación sexual sobre otra persona sin su consentimiento, sin llegar a la violación. Art. 366 y siguientes del Código Penal.'),(8,'Estafa y otras defraudaciones','Acción de engañar a otra persona con el fin de obtener un beneficio económico indebido. Art. 468 y siguientes del Código Penal.'),(9,'Amenazas','Consiste en intimidar a otra persona con causarle un mal que pueda afectarla a ella o a sus bienes. Tipificado en el Art. 296 del Código Penal.'),(10,'Conducción en estado de ebriedad','Delito que consiste en conducir un vehículo motorizado con una concentración de alcohol superior a la permitida. Sancionado por la Ley de Tránsito 18.290.');
/*!40000 ALTER TABLE `tipo_delito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('Administrador','JefeZona','Operador','Visitante','AdministradorGeneral') DEFAULT 'Visitante',
  `id_institucion` int DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `rut` (`rut`),
  UNIQUE KEY `correo` (`correo`),
  KEY `id_institucion` (`id_institucion`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `institucion` (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Joao Edson Ureta Mardones','17.424.065-5','admin@gmail.com','$2y$10$a88Zv/rSS2D6Cwir.FszjOVMOO.9CWv9EGmPLml4akSKdezorZnwi','AdministradorGeneral',1),(4,'JefeZona Carabineros','18.848.729-7','carabinero_Jzona@gmail.com','$2y$10$vnw14NJBO7qcLxAEjsCuyeZcHwx1WLoYqLyllftUzyCfbqHny8H9W','JefeZona',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `victima`
--

DROP TABLE IF EXISTS `victima`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `victima` (
  `id_victima` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `sexo` enum('Masculino','Femenino','Otro') DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_victima`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `victima`
--

LOCK TABLES `victima` WRITE;
/*!40000 ALTER TABLE `victima` DISABLE KEYS */;
/*!40000 ALTER TABLE `victima` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'prevcrim'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-08 22:36:47
