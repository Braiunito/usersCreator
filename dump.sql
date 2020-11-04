-- MySQL dump 10.16  Distrib 10.1.47-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: database    Database: lamp
-- ------------------------------------------------------
-- Server version	5.7.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Señor','Maciel','$2y$10$tR1ns0.5xV9k7AELV4jl9.H0ETnQevLounH8H2E3Y39etzgXjdhZS','braiantablet@gmail.com','2020-11-03 21:41:10'),(13,'Bad','Boy','$2y$10$QcFlOegSEqvWFk4IuzNEgORXmKdOecb4DaZDaNmzUXstz9Z4QjsG6','badboy@gmail.com','2020-11-04 02:02:14'),(14,'Other','User','$2y$10$i9e7yMlDQIv1acmKKQlOvuIqSwDAWm.RuUrNGa.8fXG3xi/wecWnS','other@user.com','2020-11-03 22:53:25'),(15,'Anto','Maciel','$2y$10$FZY7XsucnPEbuC/obyKxT.S/4m0qYub1Tx1A6XA2qAJQr5a0cN0HC','antonelavanesamaciel@gmail.com','2020-11-04 00:42:55'),(16,'Braian','Maciel','$2y$10$TEm9Q9tUi8xDAQ53qoKmF.ESvXaGIdvBdtONmLFh2uFf1NWx7jkFe','gaga@gmail.com','2020-11-04 00:44:32'),(17,'Braian','Maciel','$2y$10$9e8lzajqKqdDr5szLGlRse3EgdU3D0xcq8knQPTsA9jwNqEhuVQwe','braiantablet1@gmail.com','2020-11-04 01:36:39'),(18,'Braian','Maciel','$2y$10$OMO9jTymyKngUEKHtPb24OJQ4V2313V5rzX9FCSt6LG3azoRsFYp6','braiantablet2@gmail.com','2020-11-04 01:39:45'),(19,'Braian','Maciel','$2y$10$O9IDGdm2.qX.KkoTCEmBw.o2GgBBkJfusCN7n9ws0DxdIBM7oKs7C','braiantablet4@gmail.com','2020-11-04 01:40:39'),(20,'Braian','Maciel','$2y$10$gyeYmRyaAcu4iptDUA3wH.v.yKzi7/1f9cgedYk0BJcG4FasE.9le','braian+rifthu3020@42mate.com','2020-11-04 01:42:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-04  2:30:56
