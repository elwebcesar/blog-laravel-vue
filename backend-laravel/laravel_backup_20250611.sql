-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_b7ad7f2b04bd98f199a2b8c016e37e66c831b866','i:1;',1749663757),('laravel_cache_b7ad7f2b04bd98f199a2b8c016e37e66c831b866:timer','i:1749663757;',1749663757);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_table` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_id` int DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_05_08_221941_create_modules_table',1),(5,'2024_05_08_221956_create_permits_table',1),(6,'2025_03_08_172816_create_personal_access_tokens_table',1),(7,'2025_03_08_173630_create_posts_table',1),(8,'2025_03_11_025517_create_images_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 delete, 1 active, 2 inactive',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'module' COMMENT 'type module',
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_module` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'url main uses for dashboard',
  `active` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'section_toactive',
  `color` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `system` tinyint NOT NULL DEFAULT '0' COMMENT '1 is the system, 0 not',
  `show_on` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'where show module',
  `query` longtext COLLATE utf8mb4_unicode_ci COMMENT 'sql for total rows or content php',
  `back_module_id` bigint unsigned DEFAULT NULL COMMENT 'id module back',
  `module_id` bigint unsigned DEFAULT NULL COMMENT 'id parent module depend',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permits`
--

DROP TABLE IF EXISTS `permits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 inactive, 1 active',
  `level` tinyint NOT NULL DEFAULT '0' COMMENT 'Level permits (1-3)',
  `url_module` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Url sub module',
  `module_id` bigint unsigned DEFAULT NULL COMMENT 'id module parent sub module',
  `sub_module_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permits_module_id_foreign` (`module_id`),
  KEY `permits_sub_module_id_foreign` (`sub_module_id`),
  KEY `permits_user_id_foreign` (`user_id`),
  CONSTRAINT `permits_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `permits_sub_module_id_foreign` FOREIGN KEY (`sub_module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `permits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permits`
--

LOCK TABLES `permits` WRITE;
/*!40000 ALTER TABLE `permits` DISABLE KEYS */;
/*!40000 ALTER TABLE `permits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'user-token','6da95b2c5cd380c52f828715d4f375bc47fb7b65ecb7fbf4d5c31ffbbc2619ca','[\"*\"]',NULL,NULL,'2025-06-09 16:05:30','2025-06-09 16:05:30'),(2,'App\\Models\\User',1,'ApiDash','a942f91d1e632140cb74284019105446f3efcf0d130ead2e7be06544a49efd62','[\"*\"]',NULL,'2025-06-10 14:55:41','2025-06-10 13:55:41','2025-06-10 13:55:41'),(3,'App\\Models\\User',1,'ApiDash','c043c783cc1369d593e01603e7fb1cb12b280fb37e9dfa328d1ee60b30c38e7f','[\"*\"]',NULL,'2025-06-10 14:56:48','2025-06-10 13:56:48','2025-06-10 13:56:48'),(4,'App\\Models\\User',1,'ApiDash','f345bb79ff61574a0725757881c0eb9e975f8a13335d59af4df4e986fb4217f4','[\"*\"]',NULL,'2025-06-10 15:14:02','2025-06-10 14:14:02','2025-06-10 14:14:02'),(5,'App\\Models\\User',1,'ApiDash','4c3fc282c729cd1edd00d0219df72308ce4d1c9890cd04b8b734121eb1b27872','[\"*\"]',NULL,'2025-06-10 15:14:06','2025-06-10 14:14:06','2025-06-10 14:14:06'),(6,'App\\Models\\User',1,'ApiDash','ad6a50e791d9ec0a691c2505c5c369d4d55558107a10e3dcfed129fef34ae28b','[\"*\"]',NULL,'2025-06-10 15:14:07','2025-06-10 14:14:07','2025-06-10 14:14:07'),(7,'App\\Models\\User',1,'ApiDash','952c3084f11e42d59ee7c2aa2d1e11b81cf78cd3e8c4e58a317f31d3826b0377','[\"*\"]',NULL,'2025-06-10 15:14:08','2025-06-10 14:14:08','2025-06-10 14:14:08'),(8,'App\\Models\\User',1,'ApiDash','0acea4930c5709d3a7a203b0a1d837de96525833c12b3771f94c56a7e607dcb9','[\"*\"]',NULL,'2025-06-10 15:14:09','2025-06-10 14:14:09','2025-06-10 14:14:09'),(9,'App\\Models\\User',1,'ApiDash','170d89e6c85ca0507cae198fbba72ff30c587133a0aee13f2b47a123dedbe280','[\"*\"]',NULL,'2025-06-10 15:14:55','2025-06-10 14:14:55','2025-06-10 14:14:55'),(10,'App\\Models\\User',1,'ApiDash','0abbe80061b9863159bb7fbab243152c72594dfff5385a8712e96d27c05ac653','[\"*\"]',NULL,'2025-06-10 15:19:07','2025-06-10 14:19:07','2025-06-10 14:19:07'),(11,'App\\Models\\User',1,'ApiDash','cbe473b991db65cd8cbd46e05555bfc98abfba362358430383a13a46e5a63953','[\"*\"]',NULL,'2025-06-10 15:22:08','2025-06-10 14:22:08','2025-06-10 14:22:08'),(12,'App\\Models\\User',1,'ApiDash','de7dc175b52b9364665c35ee74cc49b0644865b1b4e1490ba3284441f3e89117','[\"*\"]',NULL,'2025-06-10 15:23:51','2025-06-10 14:23:51','2025-06-10 14:23:51'),(13,'App\\Models\\User',1,'ApiDash','1f178bb7181672b53ba666391ca07201865176acffc51dbfac2d9cb74b6c5dac','[\"*\"]',NULL,'2025-06-10 15:49:48','2025-06-10 14:49:48','2025-06-10 14:49:48'),(14,'App\\Models\\User',1,'ApiDash','82d0351e8eea6f23366a9826841846e69171156418e1fcfca136f022db9d3560','[\"*\"]',NULL,'2025-06-10 16:00:38','2025-06-10 15:00:38','2025-06-10 15:00:38'),(15,'App\\Models\\User',1,'ApiDash','82f4fbf5b25904d38ee5bd0800c142ebdabbcadd61a476a73f0c313682153e30','[\"*\"]',NULL,'2025-06-10 16:38:40','2025-06-10 15:38:40','2025-06-10 15:38:40'),(16,'App\\Models\\User',1,'ApiDash','5b018623ffc404827e6843abf03a8709c46d0cf8048e3e320b977029f07a7dce','[\"*\"]',NULL,'2025-06-10 16:46:47','2025-06-10 15:46:47','2025-06-10 15:46:47'),(17,'App\\Models\\User',1,'ApiDash','4408c0cbe27c58780d1ca3e0ab0bb3cf4e0534b4156e32acc9e4835aa355a2f7','[\"*\"]',NULL,'2025-06-10 16:48:17','2025-06-10 15:48:17','2025-06-10 15:48:17'),(18,'App\\Models\\User',1,'ApiDash','cf5a0fa1139a3d59be6e91b4af2e2fea0bc26d6fb202b00c60e1993476e65733','[\"*\"]',NULL,'2025-06-10 16:49:58','2025-06-10 15:49:58','2025-06-10 15:49:58'),(19,'App\\Models\\User',1,'ApiDash','7500b7bd9bf48bc018ad293cb9a6a90d0f3dbdf16ac4bcb159daf3f685afd544','[\"*\"]',NULL,'2025-06-10 16:51:28','2025-06-10 15:51:28','2025-06-10 15:51:28'),(20,'App\\Models\\User',1,'ApiDash','0403159eac14bc88eb43a7a6151336b3846e0e8b38ba07eba70ef31852b86840','[\"*\"]',NULL,'2025-06-10 16:55:18','2025-06-10 15:55:18','2025-06-10 15:55:18'),(21,'App\\Models\\User',1,'ApiDash','3212c1a5041d564c5c2d13fc59c2d5b9e1aa60ed48965ee01cc897cead6d9784','[\"*\"]',NULL,'2025-06-10 18:03:02','2025-06-10 17:03:02','2025-06-10 17:03:02'),(22,'App\\Models\\User',1,'ApiDash','0ebc81d5c0a8915b79a5fc63a9e5a7dea9c61e55dbe903df6f4b565b945b011d','[\"*\"]','2025-06-10 17:06:48','2025-06-10 18:04:10','2025-06-10 17:04:10','2025-06-10 17:06:48'),(23,'App\\Models\\User',1,'ApiDash','919c10be7eecfeb4aef1a163d458933d912d3a15fb7d202c6ab95d3b57f0c6da','[\"*\"]',NULL,'2025-06-10 18:15:28','2025-06-10 17:15:28','2025-06-10 17:15:28'),(24,'App\\Models\\User',1,'ApiDash','3102cee212510d6f4db53b58180985eb0cbd7c14270796f28f66daca9175e011','[\"*\"]',NULL,'2025-06-10 18:17:06','2025-06-10 17:17:06','2025-06-10 17:17:06'),(25,'App\\Models\\User',1,'ApiDash','7e8c3fa614591ba12581d036c16c47a8629738af1d135800aa68bb9709302d1c','[\"*\"]',NULL,'2025-06-10 18:24:23','2025-06-10 17:24:23','2025-06-10 17:24:23'),(26,'App\\Models\\User',1,'ApiDash','284f6ee474d66cd763a8ec4836d7f0b25e6bf7741f87a5ae719811f9a1939056','[\"*\"]',NULL,'2025-06-10 19:11:54','2025-06-10 18:11:54','2025-06-10 18:11:54'),(27,'App\\Models\\User',1,'ApiDash','ec0816c44b6ba759de5983f7b0f584e3efb6a0dadd38c413414f7be1540a1d17','[\"*\"]',NULL,'2025-06-10 19:13:41','2025-06-10 18:13:41','2025-06-10 18:13:41'),(28,'App\\Models\\User',1,'ApiDash','3242f0e76bd8ca6c54ae9634cd0e5bf3146f3cbd1b27d0df9efc5302cce357b6','[\"*\"]','2025-06-10 18:31:13','2025-06-10 19:20:55','2025-06-10 18:20:55','2025-06-10 18:31:13'),(29,'App\\Models\\User',1,'ApiDash','2f8bf67be2400dc2a741581c7a4ad6657915c791a6545e4afe45bb1b59125a6f','[\"*\"]',NULL,'2025-06-10 19:52:18','2025-06-10 18:52:18','2025-06-10 18:52:18'),(30,'App\\Models\\User',1,'ApiDash','135838bd736d946731c4ab4717943e18f615a2451af4242a389409911824db5f','[\"*\"]',NULL,'2025-06-10 19:53:20','2025-06-10 18:53:20','2025-06-10 18:53:20'),(31,'App\\Models\\User',1,'ApiDash','9c21f1310a5b2567992fef898a50584442aba2c6a50422c9f6fbf0ad8639a324','[\"*\"]',NULL,'2025-06-10 20:04:18','2025-06-10 19:04:18','2025-06-10 19:04:18'),(32,'App\\Models\\User',1,'ApiDash','6ebe86dc741b468129c35c228f093362ac753768e69945a81252ad54753063a3','[\"*\"]',NULL,'2025-06-10 20:08:46','2025-06-10 19:08:46','2025-06-10 19:08:46'),(33,'App\\Models\\User',1,'ApiDash','dc26966b57f98d95bef96dccfff0608aeca46d0343eed16909ee694fe7206c2d','[\"*\"]',NULL,'2025-06-10 20:10:38','2025-06-10 19:10:38','2025-06-10 19:10:38'),(34,'App\\Models\\User',1,'ApiDash','f190a9502fb2cbd5eacbbaeadace29e2fb5e48274b5bb7df53816c7df46796be','[\"*\"]',NULL,'2025-06-10 20:11:50','2025-06-10 19:11:49','2025-06-10 19:11:50'),(35,'App\\Models\\User',1,'ApiDash','1c90c19ca2dc0ece9bae83baed7e3a785f5938d6ad46bfbbffff0507ab72e86c','[\"*\"]',NULL,'2025-06-10 20:39:24','2025-06-10 19:39:24','2025-06-10 19:39:24'),(36,'App\\Models\\User',1,'ApiDash','4cd5990e7555193de4fc1235fe203d251235eb587c177083c1e4825f74e88085','[\"*\"]',NULL,'2025-06-10 21:56:28','2025-06-10 20:56:28','2025-06-10 20:56:28'),(37,'App\\Models\\User',1,'ApiDash','8cd1cfd37fe1fddcae2ad31b8ef98fc3deefc31a32369a1e0d7ff3e3d7b0678e','[\"*\"]',NULL,'2025-06-10 22:09:47','2025-06-10 21:09:47','2025-06-10 21:09:47'),(38,'App\\Models\\User',1,'ApiDash','0b7541aa9186332b89b714f1b923241081787984a3dc3c9343470538e50a55c1','[\"*\"]',NULL,'2025-06-10 22:10:13','2025-06-10 21:10:13','2025-06-10 21:10:13'),(39,'App\\Models\\User',1,'ApiDash','4580d7905b1b4f6b0d7df4d7dfe8b134f53020a76b10aee45feb23953566bd83','[\"*\"]','2025-06-10 21:22:28','2025-06-10 22:17:00','2025-06-10 21:17:00','2025-06-10 21:22:28'),(40,'App\\Models\\User',1,'ApiDash','9bb0eb3fdc0187f3292f839c2484f31e20b09a40da9db3366b10d494bfc1f945','[\"*\"]',NULL,'2025-06-10 22:23:59','2025-06-10 21:23:59','2025-06-10 21:23:59'),(41,'App\\Models\\User',1,'ApiDash','291da8be1b18c028cb608c188da47b9ab4f4e3768fdbc122ff2e7a68f04d1cff','[\"*\"]','2025-06-10 21:33:30','2025-06-10 22:33:06','2025-06-10 21:33:05','2025-06-10 21:33:30'),(42,'App\\Models\\User',1,'ApiDash','01cee7f2f02cb4dc947ff85125cb18f4abb8a665ffa56a29a31d3c1095eee01a','[\"*\"]',NULL,'2025-06-10 22:58:15','2025-06-10 21:58:15','2025-06-10 21:58:15'),(43,'App\\Models\\User',1,'ApiDash','ba62f304c2212d33766049862a3dec5a76d3c2920e73d4714559f2f139681c3a','[\"*\"]',NULL,'2025-06-10 22:59:58','2025-06-10 21:59:58','2025-06-10 21:59:58'),(44,'App\\Models\\User',1,'ApiDash','001541acc3b4e5cf67a9ff73df9661bdf2600db9bcb4a96e1f0b4583ab38cbe3','[\"*\"]',NULL,'2025-06-10 23:03:12','2025-06-10 22:03:12','2025-06-10 22:03:12'),(45,'App\\Models\\User',1,'ApiDash','aec4cec42ca112135ca1f3d6963a73b9f6ddb63ab8429416a949ee63957bb0c6','[\"*\"]',NULL,'2025-06-10 23:06:27','2025-06-10 22:06:27','2025-06-10 22:06:27'),(46,'App\\Models\\User',1,'ApiDash','e115cecda92cd13e8aff66c3e062af4d716cbf0e42f6e0570f673dafa587ca71','[\"*\"]',NULL,'2025-06-10 23:07:32','2025-06-10 22:07:32','2025-06-10 22:07:32'),(47,'App\\Models\\User',1,'ApiDash','272c162a2f927e321ee00482ee37f03a5f34904e15d2f236d6106167ecac5192','[\"*\"]',NULL,'2025-06-10 23:09:38','2025-06-10 22:09:38','2025-06-10 22:09:38'),(48,'App\\Models\\User',1,'ApiDash','a96400b83094e48da1b092caf84e18d584c1719379de71c1c1c0b0708a3947a7','[\"*\"]',NULL,'2025-06-10 23:09:59','2025-06-10 22:09:59','2025-06-10 22:09:59'),(49,'App\\Models\\User',1,'ApiDash','d330ffdf9b0f330e169a8075ae8b5eda1c9477dc01f8c0cfe5adcbfcd3e76360','[\"*\"]',NULL,'2025-06-10 23:10:30','2025-06-10 22:10:30','2025-06-10 22:10:30'),(50,'App\\Models\\User',1,'ApiDash','c56a0e5b556a3b677a7ac8b29f09bf44f3390f757bca3343dbb0c4554b829931','[\"*\"]',NULL,'2025-06-10 23:12:14','2025-06-10 22:12:14','2025-06-10 22:12:14'),(51,'App\\Models\\User',1,'ApiDash','ba035543cfef0d20ac4be21b0c6377a16b50ba54390972e31e1c56bcf9b28f05','[\"*\"]',NULL,'2025-06-10 23:17:05','2025-06-10 22:17:05','2025-06-10 22:17:05'),(52,'App\\Models\\User',1,'ApiDash','d94ad74f6e9bfccc8a9e0d4e8c5c115f0a53e2d5d63e8754b6c088950b1d5684','[\"*\"]',NULL,'2025-06-10 23:18:34','2025-06-10 22:18:34','2025-06-10 22:18:34'),(53,'App\\Models\\User',1,'ApiDash','01e197b43a9b072ccd0edbc362cc76b759a7cba98826a5a28c2f0f796289711c','[\"*\"]',NULL,'2025-06-10 23:20:56','2025-06-10 22:20:56','2025-06-10 22:20:56'),(54,'App\\Models\\User',1,'ApiDash','32d0a7f66052688b53112429989d43a056df58c67748a8dd8d620f54e54c97d4','[\"*\"]',NULL,'2025-06-10 23:25:47','2025-06-10 22:25:47','2025-06-10 22:25:47'),(55,'App\\Models\\User',1,'ApiDash','4f28c7336c9818b230ba0a2a098a76d66bb632eb1a168356777bd2058bae571b','[\"*\"]',NULL,'2025-06-10 23:41:25','2025-06-10 22:41:25','2025-06-10 22:41:25'),(56,'App\\Models\\User',1,'ApiDash','1e92030c26aaad0f5ebee3db9c3f5dbcdd8deeb7772eb85bade6a3614032bbb4','[\"*\"]',NULL,'2025-06-10 23:42:11','2025-06-10 22:42:11','2025-06-10 22:42:11'),(57,'App\\Models\\User',1,'ApiDash','7304720e291491dde759c3d8924de9da0d1016093ca1f4da225cbdc52b748df3','[\"*\"]',NULL,'2025-06-10 23:48:18','2025-06-10 22:48:18','2025-06-10 22:48:18'),(58,'App\\Models\\User',1,'ApiDash','8b0d178f3169c6858e7e654460f0afb73b9056c34e31aec49528224ce060919e','[\"*\"]',NULL,'2025-06-10 23:53:50','2025-06-10 22:53:50','2025-06-10 22:53:50'),(59,'App\\Models\\User',1,'ApiDash','91a49cbf225d212da7313659220b624d68ab39f2202ca77e43d966e52ce941ac','[\"*\"]',NULL,'2025-06-10 23:57:40','2025-06-10 22:57:40','2025-06-10 22:57:40'),(60,'App\\Models\\User',1,'ApiDash','2d2faa8b9070d82a197eefbed3dab27afd5dfe4e7822bf7edefdf13c41465499','[\"*\"]',NULL,'2025-06-11 00:18:42','2025-06-10 23:18:42','2025-06-10 23:18:42'),(61,'App\\Models\\User',1,'ApiDash','22519f2c58572bdb5898131a02eb1247a27eb2f50c736b191789c2021dfa93c4','[\"*\"]',NULL,'2025-06-11 03:53:23','2025-06-11 02:53:23','2025-06-11 02:53:23'),(62,'App\\Models\\User',1,'ApiDash','9a9da368a1e1d8bfe397f97746875d48ad68f2082aa75ca461e56deb341d1be0','[\"*\"]',NULL,'2025-06-11 03:57:10','2025-06-11 02:57:10','2025-06-11 02:57:10'),(63,'App\\Models\\User',1,'ApiDash','8eddb6b100073f649f63fe4df9416b479e99cf1767b134daccb8c668530dd638','[\"*\"]',NULL,'2025-06-11 15:29:04','2025-06-11 14:29:04','2025-06-11 14:29:04'),(64,'App\\Models\\User',1,'ApiDash','02afb3766b70cc3e3d7ee3390a9a8c12d47370f92bd001d91526772faba51d01','[\"*\"]',NULL,'2025-06-11 15:29:40','2025-06-11 14:29:40','2025-06-11 14:29:40'),(65,'App\\Models\\User',1,'ApiDash','2014ea59f1c06af4b8cfe3c07a70235a26ce02ca3cc248b9c4e5e2eb3b459808','[\"*\"]',NULL,'2025-06-11 15:35:27','2025-06-11 14:35:27','2025-06-11 14:35:27'),(66,'App\\Models\\User',1,'ApiDash','59caec422977587455bb15421c1ccd8de1ebe50386189d815eef3a51bbb5d9e0','[\"*\"]',NULL,'2025-06-11 15:52:34','2025-06-11 14:52:34','2025-06-11 14:52:34'),(67,'App\\Models\\User',1,'ApiDash','f3981ca28623bcb678db292e46f5491f1736bca1dffbe3dd6013c7a9c6a1cd88','[\"*\"]','2025-06-11 15:54:06','2025-06-11 16:41:54','2025-06-11 15:41:54','2025-06-11 15:54:06'),(68,'App\\Models\\User',1,'ApiDash','cbf07469899410ce9c4d182f19b2d8d4390c1555c70659631f200b242897f87c','[\"*\"]',NULL,'2025-06-11 16:56:07','2025-06-11 15:56:07','2025-06-11 15:56:07'),(69,'App\\Models\\User',1,'ApiDash','8aee39976dd9479b57deade7b5bb5e63eec5f2b65a13611c7f32cec01fb24f21','[\"*\"]',NULL,'2025-06-11 17:30:12','2025-06-11 16:30:12','2025-06-11 16:30:12'),(70,'App\\Models\\User',1,'ApiDash','bd30e675e3c66966dd0d6a0fc496bc39ae131d1f2807c5084d643e9dc6f245fc','[\"*\"]','2025-06-11 17:24:11','2025-06-11 17:36:39','2025-06-11 16:36:39','2025-06-11 17:24:11'),(71,'App\\Models\\User',1,'ApiDash','4cda1ac89e7a0020a43fe8c5857ad2d62e60d65cf6865f1ee9f1e6f7f01cb325','[\"*\"]',NULL,'2025-06-11 18:41:37','2025-06-11 17:41:37','2025-06-11 17:41:37');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 delete, 1 private, 2 public',
  `title` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (4,1,'Mi primer post','Este es el contenido del post.','mi-primer-post-D0vW9W','/blog/mi-primer-post','2025-06-09 19:27:22',1),(5,2,'Segundo post','Este es el contenido del post.','segundo-post-xz2tGy','/blog/mi-primer-post','2025-06-09 19:29:19',1),(6,3,'Tercer post','Este es el contenido del post.','tercer-post','/blog/mi-primer-post','2025-06-09 19:33:50',1),(8,1,'Hola!','Contenido del POST hola','hola',NULL,'2025-06-10 18:31:13',1),(10,1,'nuevo post','probando!','nuevo-post',NULL,'2025-06-10 21:33:30',1),(11,1,'Uno mas','De nuevo otro post.','uno-mas',NULL,'2025-06-11 15:54:06',1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('2kUPugtNfqgUwY8L6qQVoKZi2pJFitqYH7o27Eae',NULL,'172.18.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 YaBrowser/25.4.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiekJkNEl4MWJscnBzVW01bWdDUkkwa3pua0dHMzJWOURRcG5UaWFGVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749665276),('Ije9XLhftxpoj841RE3xnzStRw8csA8fuyjvGKZv',NULL,'172.18.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXFGMUFmNXFEOFBhS28zQk00bFpSdkc5eHFGTGNobHZzcVMyT2FmeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xOTIuMTY4LjEuNTk6ODA4MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749505727),('PulmAVBRTpzPfq9YZsj9e0M3xM0E0r2R9hffrE3y',NULL,'172.18.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHpmT0RtZzRTMDY1bWdPamxsVlhGNmJmdVE4ZEJPbGJJWklDaWNsdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749484333);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` int NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'cesar','elwebcesar@gmail.com','$2y$12$v9WbR0x5DmuwSHtWMNtyteC41P3eVs/93cFvFemavPtVbzvbPNcAW',NULL,NULL,NULL,'2025-06-09 16:05:30','2025-06-09 16:05:30');
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

-- Dump completed on 2025-06-11 20:30:28
