-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2026 at 10:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oolasystems_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `employment_type` varchar(255) NOT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `responsibilities` text DEFAULT NULL,
  `status` enum('Open','Closed','Draft','On Hold') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `response` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `email`, `company`, `subject`, `message`, `response`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tayyeba', 'Ahmed', 'tayyeba.ahmed@gmail.com', 'Cybex', 'Mobile App Development', 'Our Company want to develop Mobile App for its sales and marketing.', NULL, 'new', '2026-08-07 08:00:13', '2026-08-07 08:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `project_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `response` text DEFAULT NULL,
  `lead_score` tinyint(3) UNSIGNED DEFAULT NULL,
  `lead_temperature` varchar(20) DEFAULT NULL,
  `service_interest` varchar(255) DEFAULT NULL,
  `timeline` varchar(255) DEFAULT NULL,
  `budget_range` varchar(255) DEFAULT NULL,
  `ai_summary` text DEFAULT NULL,
  `ai_recommendation` text DEFAULT NULL,
  `ai_processed_at` timestamp NULL DEFAULT NULL,
  `ai_status` varchar(255) DEFAULT NULL,
  `lead_status` varchar(255) NOT NULL DEFAULT 'New',
  `follow_up_date` date DEFAULT NULL,
  `last_contacted_at` timestamp NULL DEFAULT NULL,
  `follow_up_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `project_type`, `message`, `status`, `response`, `lead_score`, `lead_temperature`, `service_interest`, `timeline`, `budget_range`, `ai_summary`, `ai_recommendation`, `ai_processed_at`, `ai_status`, `lead_status`, `follow_up_date`, `last_contacted_at`, `follow_up_notes`, `created_at`, `updated_at`) VALUES
(1, 'Tinker AI Test Company', 'tinker-ai@example.com', 'Artificial Intelligence', 'We need an AI-powered customer support solution for our enterprise. We want to start within the next three months and need help with architecture and implementation.', 'New', NULL, 75, 'WARM', 'AI-powered customer support solution', 'Next three months', 'Not specified', 'Customer needs an AI-powered customer support solution with architecture and implementation within the next three months.', 'Contact Tinker AI Test Company to discuss budget and proceed with proposal.', '2026-08-09 08:34:09', NULL, 'New', NULL, NULL, NULL, '2026-08-09 08:21:33', '2026-08-10 09:13:18'),
(2, 'UI AI Test Company', 'ui-ai-test@example.com', 'Artificial Intelligence', 'We need an AI-powered customer support platform for our enterprise. We want to start within three months and need architecture, implementation and deployment support.', 'New', NULL, 70, 'WARM', 'AI-powered customer support platform', '3 months', 'Not specified', 'Strong interest in AI solutions for customer support. Clear timeline but no budget details.', 'Request a detailed proposal with cost estimates.', '2026-08-09 13:01:18', NULL, 'New', NULL, NULL, NULL, '2026-08-09 13:00:38', '2026-08-09 13:01:18'),
(3, 'UI AI Test Company', 'ui-ai-test@example.com', 'Artificial Intelligence', 'We need an AI-powered customer support platform for our enterprise. We want to start within three months and need architecture, implementation and deployment support.', 'New', NULL, 50, 'WARM', 'AI-powered customer support platform', 'Within three months', 'Not specified', 'The company requires an AI-powered customer support solution with architecture, implementation, and deployment support within a short timeline.', 'Follow up to gather budget details and proceed with a proposal.', '2026-08-09 13:01:41', NULL, 'New', NULL, NULL, NULL, '2026-08-09 13:01:29', '2026-08-09 13:01:41'),
(4, 'Samtech AI', 'samtech.ai@gmail.com', 'Artificial Intelligence', 'We need an AI-powered customer support platform for our enterprise. We expect to start within three months and need architecture, development, testing and deployment support', 'New', NULL, 60, 'WARM', 'AI-powered customer support platform', '3 months', 'Not specified', 'Samtech AI is looking for an AI-powered customer support solution. They need architecture, development, testing, and deployment within 3 months.', 'Respond to express interest and request a budget discussion.', '2026-08-09 13:10:03', NULL, 'New', NULL, NULL, NULL, '2026-08-09 13:09:21', '2026-08-09 13:10:03'),
(5, 'Ginytech AI', 'ginytech.ai@gmail.com', 'Artificial Intelligence', 'We need an AI-powered customer support platform for our enterprise. We expect to start within three months and need architecture, development, testing and deployment support', 'New', NULL, 75, 'WARM', 'AI-powered customer support platform', '3 months', 'Not specified', 'Ginytech AI requires an AI-powered customer support solution with architecture, development, testing, and deployment support within 3 months.', 'Follow up with Ginytech AI to discuss budget details and scheduling.', '2026-08-09 19:22:20', 'Completed', 'New', NULL, NULL, NULL, '2026-08-09 18:49:31', '2026-08-09 19:22:20'),
(6, 'Queue AI Test', 'queue-test@example.com', 'Artificial Intelligence', 'We need an AI-powered customer support solution for our enterprise.\r\nWe would like to start implementation within the next three months.', 'New', NULL, 50, 'WARM', 'AI-powered customer support solution', 'Next three months', 'Not specified', 'Customer needs an AI-powered customer support solution and is eager to implement it within the next three months.', 'Send a proposal with implementation plan and pricing.', '2026-08-09 19:22:44', 'Completed', 'New', NULL, NULL, NULL, '2026-08-09 19:11:38', '2026-08-09 19:22:44'),
(7, 'Tentech AI', 'tentech.ai@gmail.com', 'Artificial Intelligence', 'We need an AI-powered customer support platform for our enterprise. We expect to start within three months and need architecture, development, testing and deployment support', 'New', NULL, 70, 'WARM', 'AI-powered customer support platform', '3 months', 'Not specified', 'Tentech AI requires an AI-powered customer support solution with architecture, development, testing, and deployment support within 3 months.', 'Respond to the inquiry to discuss further details and propose a tailored solution.', '2026-08-09 19:30:08', 'Completed', 'New', NULL, NULL, NULL, '2026-08-09 19:29:27', '2026-08-09 19:30:08'),
(8, 'Samsons AI', 'samsons.ai@gmail.com', 'Mobile App Development', 'Business Need:\r\nEnterprise AI-powered mobile app\r\n\r\nRequirements:\r\n- Architecture\r\n- Development\r\n- Testing\r\n- Deployment support\r\n\r\nExpected Timeline: Within three months', 'New', NULL, 45, 'LOW', 'Mobile App Development', 'Within three months', 'Not specified', 'Inquiry for an enterprise AI-powered mobile app within 3 months, but submitted via a generic Gmail address without budget details.', 'Send an automated reply requesting corporate email credentials, budget range, and project scope details before scheduling a discovery call.', '2026-08-11 06:34:52', 'Completed', 'New', NULL, NULL, NULL, '2026-08-11 04:55:04', '2026-08-11 06:34:52'),
(9, 'SamsoTech AI', 'samsotech.ai@gmail.com', 'Mobile App Development', 'Business Need:\r\nEnterprise AI-powered mobile app\r\n\r\nRequirements:\r\n- architecture\r\n- development\r\n- testing\r\n- deployment support\r\n\r\nExpected Timeline: Within three months', 'New', NULL, 60, 'WARM', 'Mobile App Development', 'Within three months', 'Not specified', 'Inquiry for an end-to-end enterprise AI mobile app with a 3-month timeline, submitted via a Gmail address without budget details.', 'Schedule an initial discovery call to verify business credentials, establish budget expectations, and assess timeline feasibility.', '2026-08-11 06:34:58', 'Completed', 'New', NULL, NULL, NULL, '2026-08-11 06:13:07', '2026-08-11 06:34:58'),
(10, 'TanTech AI', 'tantech.ai@gmail.com', 'Mobile App Development', 'Business Need:\r\nEnterprise AI-powered mobile app and e-commerce web application\r\n\r\nRequirements:\r\n- architecture\r\n- development\r\n- testing\r\n- deployment support\r\n\r\nExpected Timeline: Within three months', 'New', NULL, 65, 'WARM', 'Mobile App Development & E-commerce Web Application', 'Within three months', 'Not specified', 'TanTech AI requires full-lifecycle development (architecture to deployment) for an enterprise AI mobile app and web platform on a 3-month timeline, but provided a generic Gmail address and no budget details.', 'Send a discovery questionnaire to confirm business legitimacy, gather budget details, and scope requirements before scheduling an initial sales call.', '2026-08-11 07:44:03', 'Completed', 'New', NULL, NULL, NULL, '2026-08-11 06:37:44', '2026-08-11 07:44:03'),
(11, 'Lovetech AI', 'lovetech.ai@gmail.com', 'Mobile App Development', 'Business Need:\r\nAI-powered mobile app for enterprise\r\n\r\nRequirements:\r\n- Mobile app development\r\n- Architecture\r\n- Development\r\n- Testing\r\n- Deployment support\r\n\r\nExpected Timeline: Within three months', 'New', NULL, 65, 'WARM', 'AI-powered Mobile App Development', 'Within three months', 'Not specified', 'Inquiry from Lovetech AI for full-lifecycle enterprise AI mobile app development within 3 months. Contact provided a Gmail address and left budget unspecified.', 'Reach out to verify business credentials, confirm scope feasibility for the 3-month timeline, and discover budget expectations.', '2026-08-11 07:43:28', 'Completed', 'New', NULL, NULL, NULL, '2026-08-11 07:19:51', '2026-08-11 07:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_19_065245_create_contacts_table', 1),
(6, '2026_04_20_032707_create_visitors_table', 1),
(7, '2026_08_08_103219_create_careers_table', 2),
(10, '2026_04_19_074154_create_inquiries_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$4Umw.tQ4RR/gxO7v9N5aruto9Q0iJk/MFGiCD58F8VZ3IpAuHU3h.', 'vClnHPRuB5nTPnjZ2ITHnZtD9KwgrtuljDnnJrm1Hr4VE6HHqouqK1LfVfIW', '2026-04-20 09:19:23', '2026-04-20 09:19:23'),
(2, 'Umair Ahmed', 'umair.ahmed@gmail.com', NULL, '$2y$12$vP0EjvczZPVX9VUMpYdETOEGNLAmIUZhM4aGFRX1x4FkGYBoMGtIK', NULL, '2026-08-07 04:30:09', '2026-08-07 04:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip`, `user_agent`, `page`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '/', '2026-04-20 09:09:41', '2026-04-20 09:09:41'),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '/', '2026-04-27 12:42:28', '2026-04-27 12:42:28'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'tutorial', '2026-04-27 13:15:32', '2026-04-27 13:15:32'),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 04:56:51', '2026-04-28 04:56:51'),
(5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 05:02:32', '2026-04-28 05:02:32'),
(6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'tutorials/Chapter00', '2026-04-28 05:32:46', '2026-04-28 05:32:46'),
(7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'tutorials/Chapter00', '2026-04-28 06:03:27', '2026-04-28 06:03:27'),
(8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 06:06:47', '2026-04-28 06:06:47'),
(9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 06:13:08', '2026-04-28 06:13:08'),
(10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 11:30:04', '2026-04-28 11:30:04'),
(11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 11:52:26', '2026-04-28 11:52:26'),
(12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-28 23:59:37', '2026-04-28 23:59:37'),
(13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'tutorials/dotnet/fundamental/Chapter02', '2026-04-29 00:32:45', '2026-04-29 00:32:45'),
(14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-04-29 00:36:24', '2026-04-29 00:36:24'),
(15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'tutorials/dotnet/fundamental/Chapter02', '2026-04-29 01:17:07', '2026-04-29 01:17:07'),
(16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'portfolio', '2026-04-29 01:48:14', '2026-04-29 01:48:14'),
(17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-05-02 07:21:18', '2026-05-02 07:21:18'),
(18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '/', '2026-05-02 07:22:22', '2026-05-02 07:22:22'),
(19, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'login', '2026-08-06 15:03:01', '2026-08-06 15:03:01'),
(20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-07 00:44:09', '2026-08-07 00:44:09'),
(21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-07 01:35:51', '2026-08-07 01:35:51'),
(22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-07 02:25:27', '2026-08-07 02:25:27'),
(23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-07 02:59:24', '2026-08-07 02:59:24'),
(24, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-07 04:28:16', '2026-08-07 04:28:16'),
(25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/users/2', '2026-08-07 05:54:41', '2026-08-07 05:54:41'),
(26, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/users', '2026-08-07 07:02:19', '2026-08-07 07:02:19'),
(27, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '.well-known/appspecific/com.chrome.devtools.json', '2026-08-07 07:32:44', '2026-08-07 07:32:44'),
(28, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-07 08:03:30', '2026-08-07 08:03:30'),
(29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-07 11:00:37', '2026-08-07 11:00:37'),
(30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries', '2026-08-07 12:16:15', '2026-08-07 12:16:15'),
(31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/contacts/1', '2026-08-07 12:48:22', '2026-08-07 12:48:22'),
(32, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-07 13:32:12', '2026-08-07 13:32:12'),
(33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-08 03:10:09', '2026-08-08 03:10:09'),
(34, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'terms', '2026-08-08 03:48:19', '2026-08-08 03:48:19'),
(35, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'sitemap', '2026-08-08 05:21:22', '2026-08-08 05:21:22'),
(36, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-08 05:58:42', '2026-08-08 05:58:42'),
(37, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-08 06:29:15', '2026-08-08 06:29:15'),
(38, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-08 09:08:12', '2026-08-08 09:08:12'),
(39, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-08 15:52:27', '2026-08-08 15:52:27'),
(40, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-08 16:48:42', '2026-08-08 16:48:42'),
(41, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin', '2026-08-09 03:24:39', '2026-08-09 03:24:39'),
(42, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries', '2026-08-09 03:54:53', '2026-08-09 03:54:53'),
(43, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/4', '2026-08-09 04:34:13', '2026-08-09 04:34:13'),
(44, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/4', '2026-08-09 04:47:18', '2026-08-09 04:47:18'),
(45, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-09 06:47:57', '2026-08-09 06:47:57'),
(46, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-09 08:35:28', '2026-08-09 08:35:28'),
(47, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/1', '2026-08-09 12:41:32', '2026-08-09 12:41:32'),
(48, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-09 12:59:12', '2026-08-09 12:59:12'),
(49, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-09 18:48:00', '2026-08-09 18:48:00'),
(50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'inquiry', '2026-08-09 19:29:27', '2026-08-09 19:29:27'),
(51, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/7', '2026-08-09 20:01:27', '2026-08-09 20:01:27'),
(52, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 02:26:59', '2026-08-10 02:26:59'),
(53, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 03:10:47', '2026-08-10 03:10:47'),
(54, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 03:23:25', '2026-08-10 03:23:25'),
(55, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 08:30:48', '2026-08-10 08:30:48'),
(56, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 09:08:40', '2026-08-10 09:08:40'),
(57, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'chatbot/message', '2026-08-10 10:07:34', '2026-08-10 10:07:34'),
(58, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 13:04:35', '2026-08-10 13:04:35'),
(59, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-10 13:48:46', '2026-08-10 13:48:46'),
(60, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 03:33:59', '2026-08-11 03:33:59'),
(61, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 03:46:52', '2026-08-11 03:46:52'),
(62, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 03:53:30', '2026-08-11 03:53:30'),
(63, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 04:48:42', '2026-08-11 04:48:42'),
(64, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 05:28:33', '2026-08-11 05:28:33'),
(65, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 06:05:32', '2026-08-11 06:05:32'),
(66, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/9', '2026-08-11 06:35:24', '2026-08-11 06:35:24'),
(67, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 06:42:08', '2026-08-11 06:42:08'),
(68, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '/', '2026-08-11 07:17:44', '2026-08-11 07:17:44'),
(69, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/11', '2026-08-11 07:32:37', '2026-08-11 07:32:37'),
(70, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'admin/inquiries/11', '2026-08-11 07:47:39', '2026-08-11 07:47:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
