-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ashraya
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `accountants`
--

DROP TABLE IF EXISTS `accountants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accountants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accountants_school_id_foreign` (`school_id`),
  KEY `accountants_user_id_foreign` (`user_id`),
  CONSTRAINT `accountants_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `accountants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountants`
--

LOCK TABLES `accountants` WRITE;
/*!40000 ALTER TABLE `accountants` DISABLE KEYS */;
/*!40000 ALTER TABLE `accountants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `class_routine_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_school_id_foreign` (`school_id`),
  KEY `attendances_class_id_foreign` (`class_id`),
  KEY `attendances_section_id_foreign` (`section_id`),
  KEY `attendances_class_routine_id_foreign` (`class_routine_id`),
  KEY `attendances_student_id_foreign` (`student_id`),
  CONSTRAINT `attendances_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_class_routine_id_foreign` FOREIGN KEY (`class_routine_id`) REFERENCES `class_routines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_routines`
--

DROP TABLE IF EXISTS `class_routines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_routines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `time_start_min` int(11) NOT NULL,
  `time_end_min` int(11) NOT NULL,
  `start_am_pm` enum('am','pm') COLLATE utf8_unicode_ci NOT NULL,
  `end_am_pm` enum('am','pm') COLLATE utf8_unicode_ci NOT NULL,
  `day` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_routines_class_id_foreign` (`class_id`),
  KEY `class_routines_section_id_foreign` (`section_id`),
  KEY `class_routines_subject_id_foreign` (`subject_id`),
  CONSTRAINT `class_routines_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_routines_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_routines`
--

LOCK TABLES `class_routines` WRITE;
/*!40000 ALTER TABLE `class_routines` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_routines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_sections`
--

DROP TABLE IF EXISTS `class_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `teacher_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_sections_school_id_foreign` (`school_id`),
  KEY `class_sections_class_id_foreign` (`class_id`),
  KEY `class_sections_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `class_sections_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_sections`
--

LOCK TABLES `class_sections` WRITE;
/*!40000 ALTER TABLE `class_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `numeric_name` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_school_id_foreign` (`school_id`),
  CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,2,'Nursey',1,1,'2019-06-23 01:07:48','2019-06-23 01:07:48'),(2,2,'LKG',2,1,'2019-06-23 01:08:13','2019-06-23 01:08:13'),(3,2,'UKG',3,1,'2019-06-23 01:08:19','2019-06-23 01:08:19'),(4,2,'One',4,1,'2019-06-23 01:08:26','2019-06-23 01:08:26'),(5,2,'Two',5,1,'2019-06-23 01:08:33','2019-06-23 01:08:33'),(6,2,'Three',6,1,'2019-06-23 01:08:41','2019-06-23 01:08:41'),(7,2,'Four',7,1,'2019-06-23 01:08:49','2019-06-23 01:08:49'),(8,2,'Five',8,1,'2019-06-23 01:09:00','2019-06-23 01:09:00'),(9,2,'Six',9,1,'2019-06-23 01:09:08','2019-06-23 01:09:08'),(10,2,'Seven',10,1,'2019-06-23 01:09:17','2019-06-23 01:09:17'),(11,2,'Eight',11,1,'2019-06-23 01:09:24','2019-06-23 01:09:24'),(12,2,'Nine',12,1,'2019-06-23 01:09:32','2019-06-23 01:09:32'),(13,2,'Ten',13,1,'2019-06-23 01:09:45','2019-06-23 01:09:45');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrolls`
--

DROP TABLE IF EXISTS `enrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrolls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `enroll_code` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `roll_number` int(11) NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enrolls_school_id_foreign` (`school_id`),
  KEY `enrolls_class_id_foreign` (`class_id`),
  KEY `enrolls_section_id_foreign` (`section_id`),
  CONSTRAINT `enrolls_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrolls_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrolls_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrolls`
--

LOCK TABLES `enrolls` WRITE;
/*!40000 ALTER TABLE `enrolls` DISABLE KEYS */;
/*!40000 ALTER TABLE `enrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_grades`
--

DROP TABLE IF EXISTS `exam_grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `grade_point` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mark_form` int(11) NOT NULL,
  `mark_upto` int(11) NOT NULL,
  `comment` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_grades_school_id_foreign` (`school_id`),
  CONSTRAINT `exam_grades_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_grades`
--

LOCK TABLES `exam_grades` WRITE;
/*!40000 ALTER TABLE `exam_grades` DISABLE KEYS */;
INSERT INTO `exam_grades` VALUES (1,2,'A+','4',90,100,'Outstanding',1,'2019-06-23 01:22:39','2019-06-23 01:22:39'),(2,2,'A','3.6',80,90,'Excellent',1,'2019-06-23 01:22:56','2019-06-23 01:22:56'),(3,2,'B+','3.2',70,80,'Very Good',1,'2019-06-23 01:23:18','2019-06-23 01:23:18'),(4,2,'B','2.8',60,70,'Good',1,'2019-06-23 01:23:43','2019-06-23 01:23:43'),(5,2,'C+','2.4',50,60,'Satisfactory',1,'2019-06-23 01:24:14','2019-06-23 01:24:14'),(6,2,'C','2.0',40,50,'Acceptable',1,'2019-06-23 01:24:38','2019-06-23 01:24:38'),(7,2,'D+','1.6',30,40,'Partially Acceptable',1,'2019-06-23 01:23:57','2019-06-23 01:23:57'),(8,2,'D','1.2',20,30,'Insufficient',1,'2019-06-23 01:24:55','2019-06-23 01:24:55'),(9,2,'E','0.8',0,20,'Very Insufficient',1,'2019-06-23 01:25:11','2019-06-23 01:25:11');
/*!40000 ALTER TABLE `exam_grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_marks`
--

DROP TABLE IF EXISTS `exam_marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_marks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `exam_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `marks_obtained` int(11) NOT NULL DEFAULT '0',
  `marks_obtained_theory` int(11) NOT NULL DEFAULT '0',
  `marks_obtained_practical` int(11) NOT NULL DEFAULT '0',
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_marks_school_id_foreign` (`school_id`),
  KEY `exam_marks_class_id_foreign` (`class_id`),
  KEY `exam_marks_section_id_foreign` (`section_id`),
  KEY `exam_marks_subject_id_foreign` (`subject_id`),
  KEY `exam_marks_exam_id_foreign` (`exam_id`),
  KEY `exam_marks_student_id_foreign` (`student_id`),
  CONSTRAINT `exam_marks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_marks_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_marks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_marks`
--

LOCK TABLES `exam_marks` WRITE;
/*!40000 ALTER TABLE `exam_marks` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `result_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exams_school_id_foreign` (`school_id`),
  CONSTRAINT `exams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,2,'First Terminal','2076-03-15','2070-2071',1,'2019-06-23 01:57:48','2019-06-23 01:57:48','2076-03-25');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_categories`
--

DROP TABLE IF EXISTS `expense_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expense_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_categories_school_id_foreign` (`school_id`),
  CONSTRAINT `expense_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_categories`
--

LOCK TABLES `expense_categories` WRITE;
/*!40000 ALTER TABLE `expense_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_invoices`
--

DROP TABLE IF EXISTS `expense_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expense_invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `expense_category_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_invoices_school_id_foreign` (`school_id`),
  KEY `expense_invoices_expense_category_id_foreign` (`expense_category_id`),
  CONSTRAINT `expense_invoices_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expense_invoices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_invoices`
--

LOCK TABLES `expense_invoices` WRITE;
/*!40000 ALTER TABLE `expense_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fees_school_id_foreign` (`school_id`),
  KEY `fees_class_id_foreign` (`class_id`),
  CONSTRAINT `fees_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `fee_category_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `discounted_or_not` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  KEY `invoice_items_fee_category_id_foreign` (`fee_category_id`),
  CONSTRAINT `invoice_items_fee_category_id_foreign` FOREIGN KEY (`fee_category_id`) REFERENCES `fees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_transport_items`
--

DROP TABLE IF EXISTS `invoice_transport_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_transport_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_transport_items_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_transport_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_transport_items`
--

LOCK TABLES `invoice_transport_items` WRITE;
/*!40000 ALTER TABLE `invoice_transport_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_transport_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `previous_invoice_id` int(11) DEFAULT '0',
  `amount` double(8,2) NOT NULL,
  `amount_paid` double(8,2) NOT NULL,
  `amount_in_words` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `due` double(8,2) NOT NULL,
  `remarks` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_date_nepali` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `year` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `previous_or_not` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_date_nepali` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `previous_year_amount` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_school_id_foreign` (`school_id`),
  KEY `invoices_class_id_foreign` (`class_id`),
  KEY `invoices_student_id_foreign` (`student_id`),
  CONSTRAINT `invoices_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_user` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `licenses_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'Baisc',',q{7Ln-%oP8GG?8',600,1,'2019-04-13 02:43:21','2019-06-11 12:30:42');
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_03_25_083801_add_column_is_active_and_user_type_to_users',1),(4,'2019_03_25_092216_create_licenses_table',1),(5,'2019_03_25_095125_drop_column_valid_till_to_licenses',1),(6,'2019_03_25_102707_create_schools_table',1),(7,'2019_03_25_105301_add_column_user_id_to_schools',1),(8,'2019_03_25_110318_create_school_licenses_table',1),(9,'2019_03_27_143037_create_school_details_table',1),(10,'2019_03_27_145131_create_teachers_table',1),(11,'2019_03_27_163142_create_classes_table',1),(12,'2019_03_28_102917_create_class_sections_table',1),(13,'2019_03_28_134331_create_subjects_table',1),(14,'2019_03_28_152350_create_parents_table',1),(15,'2019_03_28_154904_create_transports_table',1),(16,'2019_03_28_165415_create_enrolls_table',1),(17,'2019_03_28_165846_create_students_table',1),(18,'2019_03_30_062437_create_fees_table',1),(19,'2019_03_30_072129_create_scholarships_table',1),(20,'2019_03_30_073745_add_column_scholarship_id_to_students',1),(21,'2019_03_30_075924_create_exams_table',1),(22,'2019_03_30_081826_add_column_enroll_to_enrolls',1),(23,'2019_03_30_082136_create_exam_grades_table',1),(24,'2019_03_31_065915_create_accountants_table',1),(25,'2019_03_31_072606_create_expense_categories_table',1),(26,'2019_03_31_075533_create_invoices_table',1),(27,'2019_03_31_080444_create_invoice_items_table',1),(28,'2019_03_31_080710_create_invoice_transport_items_table',1),(29,'2019_03_31_160600_add_column_payment_date_to_invoices',1),(30,'2019_03_31_173239_add_column_is_active_to_invoices',1),(31,'2019_04_03_092645_create_expense_invoices_table',1),(32,'2019_04_05_150040_create_class_routines_table',1),(33,'2019_04_05_171413_create_attendances_table',1),(34,'2019_04_07_051336_create_exam_marks_table',1),(35,'2019_04_16_133905_add_column_address_to_parents',2),(36,'2019_04_16_142211_add_column_result_date_to_exams',2),(37,'2019_04_26_051119_add_column_payment_date_nepali_to_invoices',3),(38,'2019_05_02_145713_add_column_status_to_enrolls',4),(39,'2019_05_26_152957_add_column_nepali_date_to_students',5),(40,'2019_06_07_021726_add_column_previous_year_amount_to_invoices',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `profession` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parents_school_id_foreign` (`school_id`),
  KEY `parents_user_id_foreign` (`user_id`),
  CONSTRAINT `parents_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parents`
--

LOCK TABLES `parents` WRITE;
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scholarships`
--

DROP TABLE IF EXISTS `scholarships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scholarships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scholarships_school_id_foreign` (`school_id`),
  CONSTRAINT `scholarships_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scholarships`
--

LOCK TABLES `scholarships` WRITE;
/*!40000 ALTER TABLE `scholarships` DISABLE KEYS */;
/*!40000 ALTER TABLE `scholarships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_details`
--

DROP TABLE IF EXISTS `school_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `currency` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `running_session` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_details_school_id_foreign` (`school_id`),
  CONSTRAINT `school_details_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_details`
--

LOCK TABLES `school_details` WRITE;
/*!40000 ALTER TABLE `school_details` DISABLE KEYS */;
INSERT INTO `school_details` VALUES (1,1,'nrs','2076-2077','2019-04-13 02:44:12','2019-05-05 02:00:05'),(2,2,'nrs','2076-2077','2019-06-11 12:29:51','2019-06-24 08:54:06');
/*!40000 ALTER TABLE `school_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_licenses`
--

DROP TABLE IF EXISTS `school_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_licenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `valid_till` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_licenses_school_id_foreign` (`school_id`),
  CONSTRAINT `school_licenses_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_licenses`
--

LOCK TABLES `school_licenses` WRITE;
/*!40000 ALTER TABLE `school_licenses` DISABLE KEYS */;
INSERT INTO `school_licenses` VALUES (1,1,1,NULL,'2019-04-13 02:44:12','2019-04-13 02:44:12'),(2,2,1,'2020-06-11 18:15:55','2019-06-11 12:29:51','2019-06-11 12:30:55');
/*!40000 ALTER TABLE `school_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schools_email_unique` (`email`),
  KEY `schools_user_id_foreign` (`user_id`),
  CONSTRAINT `schools_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,2,'Samaya Pathshala','samayapathshala@gmail.com','Kamalamai Municipality-6,Dhura Bazar, Sindhuli','+977-047-520431','Shyam Ghalan','assets/uploads/school/logo/logo (1)1555144152.png',1,'2019-04-13 02:44:12','2019-04-13 02:44:12'),(2,1161,'Ashraya School','aashrayschool@gmail.com','Chwas Pakha Marg, Kathmandu 44600','01-4262991','Ashraya School','assets/uploads/school/logo/avs_logo1561272510.jpg',1,'2019-06-11 12:29:51','2019-06-23 01:03:30');
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `enroll_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL,
  `transport_id` int(11) DEFAULT NULL,
  `scholarship_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dob_nepali` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_enroll_id_foreign` (`enroll_id`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_parent_id_foreign` (`parent_id`),
  CONSTRAINT `students_enroll_id_foreign` FOREIGN KEY (`enroll_id`) REFERENCES `enrolls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `teacher_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('is_oral_written','is_none') COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_marks` int(11) NOT NULL,
  `full_marks_theory` int(11) DEFAULT NULL,
  `full_marks_practical` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_school_id_foreign` (`school_id`),
  KEY `subjects_class_id_foreign` (`class_id`),
  KEY `subjects_teacher_id_foreign` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,2,1,1,'English','is_none',100,NULL,NULL,1,'2019-06-23 01:19:01','2019-06-23 01:19:01'),(2,2,1,1,'Nepali','is_none',100,NULL,NULL,1,'2019-06-23 01:19:34','2019-06-23 01:19:34'),(3,2,1,1,'Math','is_none',100,NULL,NULL,1,'2019-06-23 01:20:15','2019-06-23 01:20:15');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `designation` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `hired_date` date DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `addresss` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teachers_school_id_foreign` (`school_id`),
  KEY `teachers_user_id_foreign` (`user_id`),
  CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transports`
--

DROP TABLE IF EXISTS `transports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `number_of_vehicle` int(11) NOT NULL,
  `fare` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transports_school_id_foreign` (`school_id`),
  CONSTRAINT `transports_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transports`
--

LOCK TABLES `transports` WRITE;
/*!40000 ALTER TABLE `transports` DISABLE KEYS */;
/*!40000 ALTER TABLE `transports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1167 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Codemandu','info@cmbs.com.np',NULL,'$2y$10$D8kzFTWe0yjXjhVhCb1eROfkKCUWRH9Dzheb63.1KUIZ2cOQpy8Qi','WhpOLA8BMmIwqaTbz5QedRSdGO0DqPc3st38ENNEM30HKnEPZE9PD6KCC4Qb',NULL,NULL,1,1),(2,'Shayam Ghalan','samayapathshala@gmail.com',NULL,'$2y$10$WJku3vMN3mkf993mrkw.j.z05e2/UTMrqJ9HbgL2gCn2IgSGLV6n6','gmusHUyVY5tUhBrhPvEpjEADzQpia7UNtskWR3mrh0O4ap7cWiZOJOm3D6xC','2019-04-15 18:26:11','2019-04-15 18:26:11',2,1),(1161,'Ashraya School','aashrayschool@gmail.com',NULL,'$2y$10$L6R06LNjJcskRWbSU4SRN.dql1hg..JPP6LnmoDUqGO02BFXDQ0Fe','BjEtxm3ZcLadRyEDcrZoG4DGqYKNzjWI0PCHU4RhZV5IRHx9C2cIvPapHJqc','2019-06-11 12:29:51','2019-06-11 12:29:51',2,1);
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

-- Dump completed on 2019-06-24 20:28:54
