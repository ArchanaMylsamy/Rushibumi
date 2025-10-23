-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 11:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update_visertube`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admins', 'admin@site.com', 'admin', NULL, '6624ee96387ea1713696406.png', '$2y$12$vc.c.pNxefhOjFzLFNMEW.16i/h1vQCigtZeTLDY12QlIlS0KTWbm', NULL, NULL, '2024-04-21 04:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `storage_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `button_label` varchar(252) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1="impression", 2="click", 3="both"',
  `impression` int NOT NULL DEFAULT '0',
  `click` int NOT NULL DEFAULT '0',
  `per_impression` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `per_click` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `available_impression` int NOT NULL DEFAULT '0',
  `available_click` int NOT NULL DEFAULT '0',
  `ad_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_status` tinyint(1) NOT NULL DEFAULT '0',
  `step` tinyint(1) NOT NULL DEFAULT '0',
  `used_ftp` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_analytics`
--

CREATE TABLE `advertisement_analytics` (
  `id` bigint UNSIGNED NOT NULL,
  `advertisement_id` int NOT NULL,
  `video_id` int NOT NULL,
  `click` tinyint(1) NOT NULL DEFAULT '0',
  `impression` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_category`
--

CREATE TABLE `advertisement_category` (
  `id` bigint UNSIGNED NOT NULL,
  `advertisement_id` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ad_play_durations`
--

CREATE TABLE `ad_play_durations` (
  `id` bigint UNSIGNED NOT NULL,
  `video_id` int NOT NULL DEFAULT '0',
  `play_duration` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `replier_user_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cron_schedule_id` int NOT NULL DEFAULT '0',
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(5, 'Withdraw Money', 'withdraw_money', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"withdrawMoney\"]', '', 1, '2025-04-29 11:08:10', '2025-04-29 11:07:10', 1, 1, '2024-05-06 04:46:06', '2025-04-29 05:07:10');

-- --------------------------------------------------------

--
-- Table structure for table `cron_job_logs`
--

CREATE TABLE `cron_job_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `cron_job_id` int UNSIGNED NOT NULL DEFAULT '0',
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `error` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interval` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Minute', 60, 1, '2024-03-13 23:34:09', '2024-09-03 03:16:05'),
(3, 'Daily', 86400, 1, '2024-05-06 04:46:39', '2024-05-06 04:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `advertisement_id` int NOT NULL DEFAULT '0',
  `playlist_id` int NOT NULL DEFAULT '0',
  `plan_id` int NOT NULL DEFAULT '0',
  `is_monetization` tinyint(1) NOT NULL DEFAULT '0',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 11:16:05', '2024-05-16 06:23:02'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2024-10-02 06:14:33'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2024-11-10 00:16:32'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2024-09-15 03:11:09'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.png', 0, NULL, '2024-09-15 03:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"visertube\",\"video\",\"advertisement\",\"subscribe\",\"reels\",\"ffmpeg\"],\"description\":\"ViserTube is the leading online video-sharing platform designed for seamless uploading, high-quality streaming, and global community engagement. Whether you\\u2019re a creator or viewer, enjoy fast video uploads, customizable channels, powerful search tools, and monetization options. Join ViserTube today to share and discover videos across diverse categories like vlogs, music, tech, and live events\",\"social_title\":\"ViserTube - Online Video Sharing Platform\",\"social_description\":\"ViserTube is the leading online video-sharing platform designed for seamless uploading, high-quality streaming, and global community engagement. Whether you\\u2019re a creator or viewer, enjoy fast video uploads, customizable channels, powerful search tools, and monetization options. Join ViserTube today to share and discover videos across diverse categories like vlogs, music, tech, and live events\",\"image\":\"67304ee6e44f71731219174.png\"}', NULL, NULL, '', '2020-07-04 23:42:52', '2024-11-10 00:12:56'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"Latest News\",\"sub_heading\":\"Register New Account\",\"description\":\"fdg sdfgsdf g ggg\",\"about_icon\":\"<i class=\\\"las la-address-card\\\"><\\/i>\",\"background_image\":\"60951a84abd141620384388.png\",\"about_image\":\"5f9914e907ace1603867881.jpg\"}', NULL, 'basic', NULL, '2020-10-28 00:51:20', '2021-05-07 10:16:28'),
(25, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"------\"}', NULL, 'basic', '', '2020-10-28 00:51:34', '2024-05-01 01:36:53'),
(27, 'contact_us.content', '{\"title\":\"Auctor gravida vestibulu\",\"short_details\":\"55f55\",\"email_address\":\"5555f\",\"contact_details\":\"5555h\",\"contact_number\":\"5555a\",\"latitude\":\"5555h\",\"longitude\":\"5555s\",\"website_footer\":\"5555qqq\"}', NULL, 'basic', NULL, '2020-10-28 00:59:19', '2020-11-01 04:51:54'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', NULL, '2020-10-28 01:04:02', '2024-03-13 23:54:07'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"las la-expand\\\"><\\/i>\",\"url\":\"https:\\/\\/www.google.com\\/\"}', NULL, 'basic', NULL, '2020-11-12 04:07:30', '2021-05-12 05:56:59'),
(33, 'feature.content', '{\"heading\":\"asdf\",\"sub_heading\":\"asdf\"}', NULL, 'basic', NULL, '2021-01-03 23:40:54', '2021-01-03 23:40:55'),
(34, 'feature.element', '{\"title\":\"asdf\",\"description\":\"asdf\",\"feature_icon\":\"asdf\"}', NULL, 'basic', NULL, '2021-01-03 23:41:02', '2021-01-03 23:41:02'),
(35, 'service.element', '{\"trx_type\":\"withdraw\",\"service_icon\":\"<i class=\\\"las la-highlighter\\\"><\\/i>\",\"title\":\"asdfasdf\",\"description\":\"asdfasdfasdfasdf\"}', NULL, 'basic', NULL, '2021-03-06 01:12:10', '2021-03-06 01:12:10'),
(36, 'service.content', '{\"trx_type\":\"deposit\",\"heading\":\"asdf fffff\",\"subheading\":\"555\"}', NULL, 'basic', NULL, '2021-03-06 01:27:34', '2022-03-30 08:07:06'),
(41, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<h4>Cookie Policy<\\/h4>\\r\\n\\r\\n<p>This Cookie Policy explains how to use cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.<\\/p>\\r\\n<br>\\r\\n<h4>What are cookies?<\\/h4>\\r\\n\\r\\n<p>Cookies are small pieces of data stored on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.<\\/p>\\r\\n<br>\\r\\n<h4>Why do we use cookies?<\\/h4>\\r\\n\\r\\n<p>We use cookies for several reasons. Some cookies are required for technical reasons for our Website to operate, and we refer to these as \\\"essential\\\" or \\\"strictly necessary\\\" cookies. Other cookies enable us to track and target the interests of our users to enhance the experience on our Website. Third parties serve cookies through our Website for advertising, analytics, and other purposes.<\\/p>\\r\\n<br>\\r\\n<h4>What types of cookies do we use?<\\/h4>\\r\\n\\r\\n<div>\\r\\n    <ul style=\\\"list-style: unset;\\\">\\r\\n        <li>\\r\\n            <strong>Essential Website Cookies:<\\/strong> \\r\\n            These cookies are strictly necessary to provide you with services available through our Website and to use some of its features.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Analytics and Performance Cookies:<\\/strong> \\r\\n            These cookies allow us to count visits and traffic sources to measure and improve our Website\'s performance.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Advertising Cookies:<\\/strong> \\r\\n            These cookies make advertising messages more relevant to you and your interests. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed, and in some cases selecting advertisements that are based on your interests.\\r\\n        <\\/li>\\r\\n    <\\/ul>\\r\\n<\\/div>\\r\\n<br>\\r\\n<h4>Data Collected by Cookies<\\/h4>\\r\\n<p>Cookies may collect various types of data, including but not limited to:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>IP addresses<\\/li>\\r\\n    <li>Browser and device information<\\/li>\\r\\n    <li>Referring website addresses<\\/li>\\r\\n    <li>Pages visited on our website<\\/li>\\r\\n    <li>Interactions with our website, such as clicks and mouse movements<\\/li>\\r\\n    <li>Time spent on our website<\\/li>\\r\\n<\\/ul>\\r\\n<br>\\r\\n<h4>How We Use Collected Data<\\/h4>\\r\\n\\r\\n<p>We may use data collected by cookies for the following purposes:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>To personalize your experience on our website<\\/li>\\r\\n    <li>To improve our website\'s functionality and performance<\\/li>\\r\\n    <li>To analyze trends and gather demographic information about our user base<\\/li>\\r\\n    <li>To deliver targeted advertising based on your interests<\\/li>\\r\\n    <li>To prevent fraudulent activity and enhance website security<\\/li>\\r\\n<\\/ul>\\r\\n<br>\\r\\n<h4>Third-party cookies<\\/h4>\\r\\n\\r\\n<p>In addition to our cookies, we may also use various third-party cookies to report usage statistics of our Website, deliver advertisements on and through our Website, and so on.<\\/p>\\r\\n<br>\\r\\n<h4>How can we control cookies?<\\/h4>\\r\\n\\r\\n<p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by clicking on the \\\"Cookie Settings\\\" link in the footer of our website. You can also set or amend your web browser controls to accept or refuse cookies. If you choose to reject cookies, you may still use our Website though your access to some functionality and areas of our Website may be restricted.<\\/p>\\r\\n<br>\\r\\n<h4>Changes to our Cookie Policy<\\/h4>\\r\\n\\r\\n<p>We may update our Cookie Policy from time to time. We will notify you of any changes by posting the new Cookie Policy on this page.<\\/p>\",\"status\":1}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-04-25 06:26:36'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<h4>Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <br \\/>\\r\\n        <h4>How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n        <br \\/>\\r\\n        <h4>Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Changes to this Privacy Policy<\\/h4>\\r\\n        <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n        <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\"}', NULL, 'basic', 'privacy-policy', '2021-06-09 08:50:42', '2024-04-24 05:43:19'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<h4>Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <br \\/>\\r\\n        <h4>How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n        <br \\/>\\r\\n        <h4>Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n        <br \\/>\\r\\n        <h4>Changes to this Privacy Policy<\\/h4>\\r\\n        <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n        <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\"}', NULL, 'basic', 'terms-of-service', '2021-06-09 08:51:18', '2024-05-12 05:47:29'),
(44, 'maintenance.data', '{\"description\":\"<h3 class=\\\"text--danger\\\" style=\\\"text-align: center; \\\">THE SITE IS UNDER MAINTENANCE<\\/h3><p style=\\\"text-align: center; \\\">We\'re just tuning up a few things.We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience.<\\/p>\",\"image\":\"6603c203472ad1711522307.png\"}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-11-10 00:21:23'),
(52, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Exploring the Cryptocurrency Landscape: A Comprehensive Guide for Beginners.\",\"description\":\"Retirement planning is essential for ensuring financial security and peace of mind in your golden years. In this blog post, we discuss key retirement planning strategies, including setting retirement goals, estimating retirement expenses, maximizing retirement savings accounts, and creating a sustainable withdrawal plan. Whether you\'re decades away from retirement or nearing your retirement age, this guide will help you take proactive steps towards a financially secure future.<br \\/><br \\/>\\r\\n<h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5>\\r\\n<div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances. Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#d5d5d5;font-weight:500;font-size:18px;border-left:4px solid #687687;\\\">Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n\\r\\n\\r\\n<h5>Planning for retirement doesn\'t end with accumulating savings<\\/h5>\\r\\n<div>It also involves developing a sustainable withdrawal strategy to ensure your funds last throughout your retirement years. We\'ll discuss key factors to consider when creating a withdrawal plan, such as your expected lifespan, inflation, and investment returns, to help you strike the right balance between enjoying your retirement lifestyle and preserving your financial security.<br \\/><\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h5>Planning before starting<\\/h5>\\r\\n<div>Whether you\'re just starting your career, mid-career, or approaching retirement age, it\'s never too early or too late to begin planning for your future. Join us as we empower you with the knowledge and tools you need to take control of your retirement destiny and embark on the path towards a financially secure and fulfilling retirement.<br \\/><br \\/><h5>From setting clear retirement goals to estimating your future expenses and income needs<\\/h5><div>we\'ll guide you through the process of creating a solid retirement plan tailored to your unique circumstances. Whether you\'re decades away from retirement or nearing your retirement age, this guide offers valuable insights to help you make informed decisions and take proactive steps towards achieving your retirement objectives.<\\/div><\\/div>\",\"image\":\"662a19077e0ad1714034951.jpg\"}', NULL, 'basic', 'exploring-the-cryptocurrency-landscape-a-comprehensive-guide-for-beginners', '2024-03-24 06:52:04', '2024-05-01 03:55:15'),
(55, 'counter.content', '{\"heading\":\"Latest Newsss\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-21 01:13:50', '2024-04-21 01:13:50'),
(56, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-21 01:13:52', '2024-04-21 01:13:52'),
(60, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\"}', NULL, 'basic', '', '2024-04-25 06:35:35', '2024-04-25 06:35:35'),
(61, 'kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', '', '2024-04-25 06:40:29', '2024-04-25 06:40:29'),
(62, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"------\"}', NULL, 'basic', '', '2024-04-30 07:31:30', '2024-04-30 07:31:30'),
(64, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\",\"image\":\"6631dbf594eca1714543605.png\"}', NULL, 'basic', '', '2024-05-01 00:06:45', '2024-05-01 00:06:46'),
(65, 'faq.element', '{\"question\":\"Commodo cupiditate i\",\"answer\":\"Aut vel quo unde est\",\"icon\":\"<i class=\\\"fab fa-accusoft\\\"><\\/i>\"}', NULL, 'basic', '', '2024-05-04 00:21:20', '2024-05-04 00:21:20'),
(66, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Page you are looking for doesn\'t exit or an other error occurred or temporarily unavailable.\",\"button_name\":\"Go to Home\",\"button_url\":\"\\/\",\"image\":\"663a0f20ecd0b1715080992.png\"}', NULL, 'basic', '', '2024-05-07 05:23:12', '2024-10-02 04:44:42'),
(67, 'ban_page.content', '{\"has_image\":\"1\",\"heading\":\"You are banned !\",\"image\":\"6730516c889bd1731219820.png\"}', NULL, 'basic', '', '2024-10-02 04:53:49', '2024-11-10 00:23:40'),
(68, 'auth_page.content', '{\"login_page_title\":\"Please enter your details to sign in\",\"register_page_title\":\"Register Now\",\"register_page_subtitle\":\"Please enter your details to sign in.\",\"verification_page_title\":\"Builds credibility and trust by confirming authenticity, enhances account security, unlocks exclusive features, and attracts brand collaborations, increasing visibility and engagement.\",\"security_page_alert_message\":\"You don\'t have 2-Step Verification, this exposes your account at higher risk of attack\",\"security_page_link_text\":\"Turn it on to increase security\"}', NULL, 'basic', '', '2024-10-14 02:45:39', '2024-11-02 00:09:30'),
(69, 'withdraw_method_page.content', '{\"title\":\"Please Read Carefully\",\"subtitle\":\"Take control of your withdrawals with our comprehensive withdraw method page, allowing you to customize and select your preferred method based on limits, charges, and conversion rates. Optimize your earnings and choose the best withdrawal method for you.\"}', NULL, 'basic', '', '2024-10-28 23:45:15', '2024-10-28 23:45:15'),
(70, 'monetization_page.content', NULL, NULL, NULL, NULL, '2024-10-28 23:58:01', '2024-10-28 23:58:01'),
(71, 'monetization_page.content', NULL, NULL, NULL, NULL, '2024-10-28 23:58:20', '2024-10-28 23:58:20'),
(72, 'monetization_page.content', '{\"has_image\":\"1\",\"title\":\"Become a partner\",\"subtitle\":\"To make money, join the ViserTube Partner Program\",\"card_title\":\"Earn for each advertisement click from your video\",\"card_tagline\":\"Join partnership program\",\"congratulation_message\":\"Congratulations! You are now eligible for monetization.\",\"review_message\":\"Your monetization request is under processing. Please wait.\",\"active_message\":\"Your monetization is now active.\",\"reject_message\":\"Your monetization request has been canceled\",\"first_image\":\"6729bdc47485d1730788804.png\",\"second_image\":\"6729bdc47f2601730788804.png\"}', NULL, 'basic', '', '2024-10-29 00:01:15', '2024-11-05 00:40:04'),
(73, 'advertiser_dashboard.content', NULL, NULL, NULL, NULL, '2024-10-29 00:19:35', '2024-10-29 00:19:35'),
(74, 'advertiser_dashboard.content', NULL, NULL, NULL, NULL, '2024-10-29 00:21:18', '2024-10-29 00:21:18'),
(75, 'advertiser_dashboard.content', '{\"has_image\":\"1\",\"initiate_message\":\"You are currently not listed as an advertiser. To register as advertiser, please submit the required information.\",\"review_message\":\"Your request has been successfully submitted. Please wait for our team to review and approve your request.\",\"image\":\"6729be3da1e771730788925.png\"}', NULL, 'basic', '', '2024-10-29 00:21:53', '2024-11-05 00:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', '663a38d7b455d1715091671.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:11'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', '663a3920e30a31715091744.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:24'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', '663a39861cb9d1715091846.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:06'),
(4, 0, 104, 'Skrill', 'Skrill', '663a39494c4a91715091785.png', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:23:05'),
(5, 0, 105, 'PayTM', 'Paytm', '663a390f601191715091727.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:07'),
(6, 0, 106, 'Payeer', 'Payeer', '663a38c9e2e931715091657.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:20:57'),
(7, 0, 107, 'PayStack', 'Paystack', '663a38fc814e91715091708.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:48'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', '663a36c2c34d61715091138.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:18'),
(10, 0, 110, 'RazorPay', 'Razorpay', '663a393a527831715091770.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:50'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', '663a3995417171715091861.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:21'),
(12, 0, 112, 'Instamojo', 'Instamojo', '663a384d54a111715091533.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:18:53'),
(13, 0, 501, 'Blockchain', 'Blockchain', '663a35efd0c311715090927.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:08:47'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', '663a36a8d8e1d1715091112.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"---------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"---------------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:52'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '663a36b7b841a1715091127.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:07'),
(17, 0, 505, 'Coingate', 'Coingate', '663a368e753381715091086.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:26'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '663a367e46ae51715091070.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:10'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', '663a38ed101a61715091693.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:33'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', '663a39afb519f1715091887.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:47'),
(27, 0, 115, 'Mollie', 'Mollie', '663a387ec69371715091582.png', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:19:42'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', '663a361b16bd11715090971.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2024-05-07 08:09:31'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', '663a386c714a91715091564.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:19:24'),
(37, 0, 120, 'Authorize.net', 'Authorize', '663a35b9ca5991715090873.png', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:07:53'),
(46, 0, 121, 'NMI', 'NMI', '663a3897754cf1715091607.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:20:07'),
(50, 0, 507, 'BTCPay', 'BTCPay', '663a35cd25a8d1715090893.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"HsqFVTXSeUFJu7caoYZc3CTnP8g5LErVdHhEXPVTheHf\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"4436bd706f99efae69305e7c4eff4780de1335ce\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-05-07 08:08:13'),
(51, 0, 508, 'Now payments hosted', 'NowPaymentsHosted', '663a38b8d57a81715091640.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2024-05-07 08:20:40'),
(52, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', '663a38a59d2541715091621.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 1, '', NULL, NULL, '2024-05-07 08:20:21'),
(53, 0, 122, '2Checkout', 'TwoCheckout', '663a39b8e64b91715091896.png', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"253248016872\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"eQM)ID@&vG84u!O*g[p+\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 0, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-05-07 08:24:56'),
(54, 0, 123, 'Checkout', 'Checkout', '663a3628733351715090984.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:09:44'),
(56, 0, 510, 'Binance', 'Binance', '663a35db4fd621715090907.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2024-05-07 08:08:27'),
(57, 0, 124, 'SslCommerz', 'SslCommerz', '663a397a70c571715091834.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:23:54'),
(58, 0, 125, 'Aamarpay', 'Aamarpay', '663a34d5d1dfc1715090645.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"aamarpaytest\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"dbb74894e82415a2f7ff0ec3a97e4183\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2024-08-15 00:28:55'),
(60, 0, 126, 'bKash', 'BKash', '6810b256cb0bb1745924694.png', 1, '{\"username\":{\"title\":\"Username\",\"global\":true,\"value\":\"----------------------\"},\"password\":{\"title\":\"Password\",\"global\":true,\"value\":\"---------\"},\"app_key\":{\"title\":\"App Key\",\"global\":true,\"value\":\"------------\"},\"app_secret\":{\"title\":\"App Secret\",\"global\":true,\"value\":\"---------------------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2025-04-29 05:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `firebase_config` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socialite_credentials` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `config_progress` text COLLATE utf8mb4_unicode_ci,
  `google_api_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_subscribe` bigint NOT NULL DEFAULT '0',
  `minimum_views` bigint NOT NULL DEFAULT '0',
  `vc_warning` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ad_config` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ffmpeg_status` tinyint(1) NOT NULL DEFAULT '0',
  `per_impression_spent` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `per_click_spent` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `per_click_earn` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `per_impression_earn` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `off_days` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `monetization_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `monetization_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_playlist_sell` tinyint(1) NOT NULL DEFAULT '1',
  `is_monthly_subscription` tinyint(1) NOT NULL DEFAULT '1',
  `is_storage` tinyint(1) NOT NULL DEFAULT '0',
  `storage_used_id` int NOT NULL DEFAULT '0',
  `video_sell_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `playlist_sell_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `plan_sell_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `secondary_color`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `socialite_credentials`, `last_cron`, `available_version`, `system_customized`, `paginate_number`, `currency_format`, `config_progress`, `google_api_key`, `minimum_subscribe`, `minimum_views`, `vc_warning`, `ad_config`, `ffmpeg_status`, `per_impression_spent`, `per_click_spent`, `per_click_earn`, `per_impression_earn`, `off_days`, `monetization_amount`, `monetization_status`, `is_playlist_sell`, `is_monthly_subscription`, `is_storage`, `storage_used_id`, `video_sell_charge`, `playlist_sell_charge`, `plan_sell_charge`, `created_at`, `updated_at`) VALUES
(1, 'ViserTube', 'USD', '$', 'info@viserlab.com', '{{site_name}}', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/Z1qtvtV.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2021 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', '{{site_name}}', '{{site_name}}', 'hi {{fullname}} ({{username}}), {{message}}', 'EF233C', '063862', '{\"name\":\"php\"}', '{\"name\":\"clickatell\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"------------------\",\"authDomain\":\"----------------------\",\"projectId\":\"-------------------------\",\"storageBucket\":\"------------------\",\"messagingSenderId\":\"-----------------------\",\"appId\":\"-------------------\",\"measurementId\":\"-----------------------\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 'basic', '{\"google\":{\"client_id\":\"---------------------\",\"client_secret\":\"---------------------\",\"status\":0},\"facebook\":{\"client_id\":\"------------------\",\"client_secret\":\"------------------\",\"status\":0},\"linkedin\":{\"client_id\":\"----------------------\",\"client_secret\":\"-----------------------\",\"status\":0}}', '2025-04-29 11:07:10', '1.5', 0, 20, 1, '[]', '------------------------', 50, 200, '{\"title\":\"Warning\",\"description\":\"Description of the warning or violation goes here. Please review the content carefully\"}', '{\"per_minute\":\"3\",\"ad_views\":\"3\"}', 0, 1.00000000, 1.00000000, 1.00000000, 1.00000000, '{\"Sunday\":\"on\",\"Friday\":\"on\"}', 100.00000000, 1, 0, 0, 0, 0, 0.00, 0.00, 0.00, NULL, '2025-04-29 05:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day_off` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impressions`
--

CREATE TABLE `impressions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `views` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '6810b2cc244a71745924812.png', '2020-07-06 03:47:55', '2025-04-29 05:06:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '{{site_name}} - Balance Added', '<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>', 'We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.', '{{amount}} {{site_currency}} has been successfully added to your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 0, NULL, 1, '2021-11-03 12:00:00', '2024-05-25 00:49:44'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '{{site_name}} - Balance Subtracted', '<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>', 'We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.', '{{amount}} {{site_currency}} debited from your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:17:48'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '{{site_name}} - Deposit successful', '<div>We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.</div><div><br></div><div>Below, you\'ll find the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>If you have any questions or need further assistance, feel free to reach out to our support team. We\'re here to assist you in any way we can.</div>', 'We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.', 'Deposit Completed Successfully', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-05-08 07:20:34'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Deposit Request Approved', '{{site_name}} - Deposit Request Approved', '<div>We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.</div><div><br></div><div>Here are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div><div>Your current balance now stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.', 'Deposit of {{amount}} {{site_currency}} via {{method_name}} has been approved.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:19:49'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Deposit Request Rejected', '{{site_name}} - Deposit Request Rejected', '<div>We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of the rejected deposit:</div><div><br></div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Charge:</b> {{charge}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>If you have any questions or need further clarification, please don\'t hesitate to contact us. We\'re here to assist you.</div><div><br></div><div>Rejection Reason:</div><div>{{rejection_message}}</div><div><br></div><div>Thank you for your understanding.</div>', 'We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:20:13'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Below are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Payable:</b> {{method_amount}} {{method_currency}}</div><div><b>Pay via: </b>{{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to reach out to our support team. We\'re here to assist you.</div>', 'We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} submitted successfully.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:42'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '{{site_name}} Password Reset Code', '<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>', 'To proceed with the password reset, please use the following account recovery code: {{code}}', 'To proceed with the password reset, please use the following account recovery code: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:24:57'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Password Reset Successful', NULL, '<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>', 'We are writing to inform you that the password reset for your account was successful.', 'We are writing to inform you that the password reset for your account was successful.', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:24'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{{site_name}} - Support Ticket Replied', '<div>\r\n    <div><span>Thank you for reaching out to us regarding your support ticket with the subject</span>:\r\n        <span>\"{{ticket_subject}}\"&nbsp;</span><span>and ticket ID</span>: {{ticket_id}}.</div><br>\r\n    <div><span>We have carefully reviewed your inquiry, and we are pleased to provide you with the following\r\n            response</span><span>:</span></div><br>\r\n    <div>{{reply}}</div><br>\r\n    <div><span>If you have any further questions or need additional assistance, please feel free to reply by clicking on\r\n            the following link</span>: <a href=\"{{link}}\" title=\"\" target=\"_blank\">{{link}}</a><span>. This link will take you to\r\n            the ticket thread where you can provide further information or ask for clarification.</span></div><br>\r\n    <div><span>Thank you for your patience and cooperation as we worked to address your concerns.</span></div>\r\n</div>', 'Thank you for reaching out to us regarding your support ticket with the subject: \"{{ticket_subject}}\" and ticket ID: {{ticket_id}}. We have carefully reviewed your inquiry. To check the response, please go to the following link: {{link}}', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, '{{site_name}} Support Team', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:06'),
(10, 'EVER_CODE', 'Verification - Email', 'Email Verification Code', NULL, '<div>\r\n    <div><span>Thank you for taking the time to verify your email address with us. Your email verification code\r\n            is</span>: <b><font size=\"6\">{{code}}</font></b></div><br>\r\n    <div><span>Please enter this code in the designated field on our platform to complete the verification\r\n            process.</span></div><br>\r\n    <div><span>If you did not request this verification code, please disregard this email. Your account security is our\r\n            top priority, and we advise you to take appropriate measures if you suspect any unauthorized access.</span>\r\n    </div><br>\r\n    <div><span>If you have any questions or encounter any issues during the verification process, please don\'t hesitate\r\n            to contact our support team for assistance.</span></div><br>\r\n    <div><span>Thank you for choosing us.</span></div>\r\n</div>', '---', '---', '{\"code\":\"Email verification code\"}', 1, '{{site_name}} Verification Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:12'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', NULL, '---', 'Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.', '---', '{\"code\":\"SMS Verification Code\"}', 0, '{{site_name}} Verification Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:03'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdrawal Confirmation: Your Request Processed Successfully', '{{site_name}} - Withdrawal Request Approved', '<div>We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.</div><div><br></div><div>Below are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>You will receive:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Details of Processed Payment:</b></div><div>{{admin_details}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.', 'Withdrawal Confirmation: Your Request Processed Successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:37'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdrawal Request Rejected', '{{site_name}} - Withdrawal Request Rejected', '<div>We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Refund Details:</b></div><div>{{amount}} {{site_currency}} has been refunded to your account, and your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><hr><div><br></div><div><b>Reason for Rejection:</b></div><div>{{admin_details}}</div><div><br></div><div>If you have any questions or concerns regarding this rejection or need further assistance, please do not hesitate to contact our support team. We apologize for any inconvenience this may have caused.</div>', 'We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Withdrawal Request Rejected', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:55'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdrawal Request Confirmation', '{{site_name}} - Requested for withdrawal', '<div>We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Withdrawal request submitted successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:27:20'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-05-16 01:32:53'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC Details has been approved', '{{site_name}} - KYC Approved', '<div><div><span>We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.</span></div><br><div><span>Your commitment to completing the KYC process promptly is greatly appreciated, as it helps us ensure the security and integrity of our platform for all users.</span></div><br><div><span>With your KYC verification now complete, you can proceed with confidence to carry out any payout transactions you require. Should you encounter any issues or have any questions along the way, please don\'t hesitate to reach out to our support team. We\'re here to assist you every step of the way.</span></div><br><div><span>Thank you once again for choosing {{site_name}} and for your cooperation in this matter.</span></div></div>', 'We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.', 'Your  Know Your Customer (KYC) information has been approved successfully', '[]', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-05-08 07:23:57'),
(17, 'KYC_REJECT', 'KYC Rejected', 'KYC has been rejected', '{{site_name}} - KYC Rejected', '<div><div><span>We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time.</span></div><br><div><span>We understand that this news may be disappointing, and we want to assure you that we take these matters seriously to maintain the security and integrity of our platform.</span></div><br><div><span>Reasons for rejection may include discrepancies or incomplete information in the documentation provided. If you believe there has been a misunderstanding or if you would like further clarification on why your KYC was rejected, please don\'t hesitate to contact our support team.</span></div><br><div><span>We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.</span></div><br><div><span>We apologize for any inconvenience this may cause and appreciate your understanding and cooperation in this matter.</span></div><br><div>Rejection Reason:</div><div>{{reason}}</div><div><br></div><div><span>Thank you for your continued support and patience.</span></div></div>', 'We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time. We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.', 'Your  Know Your Customer (KYC) information has been rejected', '{\"reason\":\"Rejection Reason\"}', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-05-08 07:24:13'),
(18, 'PURCHASED_VIDEO', 'Purchased Video', 'Video purchased successfully', '{{site_name}} - Deposit Request Approved', '<div>You have successfully purchased&nbsp; {{title}}&nbsp; video.<br></div><div><br></div><div>Here are the details of your purchased details:</div><div><b>Title:</b> {{title}}<br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}<br><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'You have successfully purchased  {{title}}  video.', 'You have successfully purchased  {{title}}  video.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\",\"title\":\"Video title\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-08-14 04:27:13'),
(22, 'ADVERTISER_APPROVE', 'Advertiser Approved', 'Advertiser request has been approved', '{{site_name}} - Advertiser Approved', '<p style=\"text-align: left;\"><font size=\"4\">We are pleased to inform you that your advertiser account has been successfully reviewed and approved. You are now eligible to run campaigns and manage your advertising activities within our system.</font></p><p style=\"text-align: left;\"><font size=\"4\">We greatly appreciate your promptness in completing the advertiser verification process, as it helps us maintain a secure and trustworthy platform for all our users.</font></p><p style=\"text-align: left;\"><font size=\"4\">With your advertiser status now active, you can confidently proceed with creating and managing your ad campaigns. If you encounter any issues or have any questions, please don\'t hesitate to reach out to our support team. We\'re here to assist you every step of the way.</font></p><p style=\"text-align: left;\"><font size=\"4\"><br></font></p><p style=\"text-align: left;\"><font size=\"4\">Thank you once again for choosing {{site_name}} and for partnering with us as an advertiser.</font></p>', 'We are pleased to inform you that your advertiser account has been successfully reviewed and approved. This means that you are now eligible to conduct any campaign or advertisement.', 'Your  Know Your advertiser information has been approved successfully', '[]', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-08-27 06:17:52'),
(23, 'ADVERTISER_REJECT', 'Advertiser Rejected', 'Advertiser request has been rejected', '{{site_name}} - Advertiser Rejected', '<p>We regret to inform you that the information provided for your advertiser account has been reviewed and, unfortunately, it has not met our verification standards. As a result, we are unable to approve your advertiser submission at this time.</p><p>We understand that this news may be disappointing, and we want to assure you that we take these matters seriously to maintain the security and integrity of our platform.</p><p>Reasons for rejection may include discrepancies or incomplete information in the documentation provided. If you believe there has been a misunderstanding or if you would like further clarification on why your advertiser account was rejected, please don\'t hesitate to contact our support team.</p><p>We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your advertiser information for review.</p><p>We apologize for any inconvenience this may cause and appreciate your understanding and cooperation in this matter.</p><p>Rejection Reason:<br>{{reason}}</p><p>Thank you for your continued support and patience.</p>', 'We regret to inform you that the information provided for your advertiser account has been reviewed and, unfortunately, it has not met our verification standards. As a result, we are unable to approve your advertiser submission at this time.\r\n\r\nWe encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your advertiser information for review.', 'Your  Know Your advertiser information has been rejected', '{\"reason\":\"Rejection Reason\"}', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-08-27 06:19:34'),
(24, 'PUBLISHED_ADVERTISEMENT', 'Purchased Advertisement', 'Advertisement published succesffully', '{{site_name}}', '<div>You have successfully purchased&nbsp; {{title}}&nbsp; video.<br></div><div><br></div><div>Here are the details of your purchased details:</div><div><b>Title:</b> {{title}}<br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}<br><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'You have successfully purchased  {{title}}  video.', 'You have successfully purchased  {{title}}  video.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\",\"title\":\"Video title\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-08-14 04:27:13'),
(25, 'PUBLISHED_ADVERTISEMENT', 'Purchased Advertisement', 'Advertisement published succesffully', '{{site_name}}', '<div>You have successfully purchased&nbsp; {{title}}&nbsp; video.<br></div><div><br></div><div>Here are the details of your purchased details:</div><div><b>Title:</b> {{title}}<br></div><div><span style=\"font-weight: bolder; color: rgb(33, 37, 41);\">Earn Click:</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{click}}</font></span><br></div><div><span style=\"color: rgb(33, 37, 41); font-weight: bolder;\">Earn impressiom:</span><span style=\"background-color: var(--bs-card-bg); text-align: var(--bs-body-text-align);\"><font color=\"#212529\">{{impression}}</font></span><span style=\"color: rgb(33, 37, 41);\"><br></span></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}<br><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'You have successfully purchased  {{title}}  video.', 'You have successfully purchased  {{title}}  video.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\",\"title\":\"Advertisement title\",\r\n\"click\":\"Advertisement click\",\r\n\"impression\":\"Advertisement impression\"\r\n\r\n}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-08-28 03:40:15'),
(26, 'INSUFFICIENT_WITHDRAW_BALANCE', 'Insufficient Withdraw Balance', 'Insufficient Withdraw Balance', '{{site_name}}', '<span style=\"color: rgb(33, 37, 41);\">Currenct balance :&nbsp;</span>{{current_balance}}<br><span style=\"color: rgb(33, 37, 41);\">Withdraw amount :&nbsp;{{withdraw_amount}}</span><div>Withdraw method :&nbsp;{{withdraw_method}}</div><div>Withdraw schedule :&nbsp;{{withdraw_schedule}}</div>', 'Currenct balance : {{currenct_balance}}\r\nWithdraw amount : {{withdraw_amount}}\r\nWithdraw method : {{withdraw_method}}\r\nWithdraw schedule : {{withdraw_schedule}}', 'Currenct balance : {{currenct_balance}}\r\nWithdraw amount : {{withdraw_amount}}\r\nWithdraw method : {{withdraw_method}}\r\nWithdraw schedule : {{withdraw_schedule}}', '{\"current_balance\":\"Current balance of user\",\"withdraw_amount\":\"Withdraw amount\",\"withdraw_method\":\"Withdraw method name\",\"withdraw_schedule\":\"Withdraw schedule\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-09-03 03:10:59'),
(27, 'PURCHASED_MONETIZATION', 'Purchased Monetization', 'Purchased monetization', '{{site_name}} - Monetizarion Request', '<div>We are pleased to inform you that your monetization request submit.</div><div><br></div><div>Here are the details:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div>', 'We are pleased to inform you that your monetiation request are submit.', 'We are pleased to inform you that your monetiation request are submit.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-09-16 05:24:12'),
(28, 'PURCHASED_PLAYLIST', 'Purchased Playlist', 'Playlist purchased successfully', '{{site_name}} - Playlist Purchase Successful', '<div>You have successfully purchased the playlist titled {{title}}.<br></div><div><br></div><div>Here are the details of your purchase:</div><div><b>Title:</b> {{title}}<br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}<br><br></div><div>If you have any questions or need further assistance, please contact our support team. We\'re here to help.</div>', 'You have successfully purchased the playlist titled {{title}}.', 'You have successfully purchased the playlist titled {{title}}.', '{\"trx\":\"Transaction number for the purchase\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the purchase method\",\"method_currency\":\"Currency of the purchase method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\",\"title\":\"Playlist title\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2024-04-07 18:00:00', '2024-04-07 18:00:00'),
(29, 'PURCHASED_PLAN', 'Purchased Plan', 'Plan purchased successfully', '{{site_name}} - Plan Purchase Successful', '<div>You have successfully purchased the plan named {{plan_name}}.<br></div><div><br></div><div>Here are the details of your purchase:</div><div><b>Plan:</b> {{plan_name}}<br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}<br><br></div><div>If you have any questions or need further assistance, please contact our support team. We\'re here to help.</div>', 'You have successfully purchased the plan named {{plan_name}}.', 'You have successfully purchased the plan named {{plan_name}}.', '{\"trx\":\"Transaction number for the purchase\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the purchase method\",\"method_currency\":\"Currency of the purchase method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\",\"plan_name\":\"Plan name\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2024-04-07 18:00:00', '2024-04-07 18:00:00'),
(30, 'NEW_PLAN_SELL', 'New Plan Sale', 'Your plan {{plan_name}} has a new sale!', '{{site_name}} - New Plan Sold', '<div>Congratulations! Your plan <strong>{{plan_name}}</strong> has just been sold.</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Your New Balance:</b> {{post_balance}} {{site_currency}}</div><div><br></div><div>Keep up the great work!</div>', 'Your plan \"{{plan_name}}\" has been sold. Amount: {{amount}} {{site_currency}}. Balance: {{post_balance}} {{site_currency}}.', 'Your plan \"{{plan_name}}\" has been sold. Amount: {{amount}}.', '{\"plan_name\":\"Name of the sold plan\",\"amount\":\"Amount received\",\"rate\":\"Conversion rate\",\"trx\":\"Transaction number\",\"post_balance\":\"User\'s balance after the sale\"}', 1, '{{site_name}} Notifications', NULL, 1, NULL, 0, '2024-04-07 18:00:00', '2024-04-07 18:00:00'),
(31, 'NEW_PLAYLIST_SELL', 'New Playlist Sale', 'Your playlist {{title}} has a new sale!', '{{site_name}} - New Playlist Sold', '<div>Great news! Your playlist <strong>{{title}}</strong> has just been purchased.</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Your New Balance:</b> {{post_balance}} {{site_currency}}</div><div><br></div><div>Keep creating awesome content!</div>', 'Your playlist \"{{title}}\" has been sold. Amount: {{amount}} {{site_currency}}. Balance: {{post_balance}} {{site_currency}}.', 'Your playlist \"{{title}}\" has been sold. Amount: {{amount}}.', '{\"title\":\"Title of the sold playlist\",\"amount\":\"Amount received\",\"rate\":\"Conversion rate\",\"trx\":\"Transaction number\",\"post_balance\":\"User\'s balance after the sale\"}', 1, '{{site_name}} Notifications', NULL, 1, NULL, 0, '2024-04-07 18:00:00', '2024-04-07 18:00:00'),
(32, 'NEW_VIDEO_SELL', 'New Video Sale', 'Your video {{title}} has a new sale!', '{{site_name}} - New Video Sold', '<div>Awesome! Your video <strong>{{title}}</strong> has just been purchased.</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Your New Balance:</b> {{post_balance}} {{site_currency}}</div><div><br></div><div>Keep producing amazing content!</div>', 'Your video \"{{title}}\" has been sold. Amount: {{amount}} {{site_currency}}. Balance: {{post_balance}} {{site_currency}}.', 'Your video \"{{title}}\" has been sold. Amount: {{amount}}.', '{\"title\":\"Title of the sold video\",\"amount\":\"Amount received\",\"rate\":\"Conversion rate\",\"trx\":\"Transaction number\",\"post_balance\":\"User\'s balance after the sale\"}', 1, '{{site_name}} Notifications', NULL, 1, NULL, 0, '2024-04-07 18:00:00', '2024-04-07 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', NULL, NULL, 1, '2020-07-11 06:23:58', '2024-11-05 23:33:09'),
(5, 'Contact', 'contact', 'templates.basic.', NULL, NULL, 1, '2020-10-22 01:14:53', '2020-10-22 01:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_playlists`
--

CREATE TABLE `plan_playlists` (
  `id` int NOT NULL,
  `plan_id` int NOT NULL DEFAULT '0',
  `playlist_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_videos`
--

CREATE TABLE `plan_videos` (
  `id` int NOT NULL,
  `plan_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `visibility` tinyint(1) NOT NULL DEFAULT '0',
  `playlist_subscription` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist_videos`
--

CREATE TABLE `playlist_videos` (
  `id` bigint UNSIGNED NOT NULL,
  `playlist_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_plans`
--

CREATE TABLE `purchased_plans` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `owner_id` int NOT NULL DEFAULT '0',
  `plan_id` int NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_playlists`
--

CREATE TABLE `purchased_playlists` (
  `id` bigint NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `owner_id` int NOT NULL DEFAULT '0',
  `playlist_id` int NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchased_videos`
--

CREATE TABLE `purchased_videos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `owner_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storages`
--

CREATE TABLE `storages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1="local server", 2="FTP" , 3="Wasabi", 4="Digital Ocean"',
  `available_space` bigint DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `following_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

CREATE TABLE `subtitles` (
  `id` bigint UNSIGNED NOT NULL,
  `video_id` int NOT NULL DEFAULT '0',
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `playlist_id` int NOT NULL DEFAULT '0',
  `plan_id` int NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `social_links` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `monetization_status` tinyint NOT NULL DEFAULT '0',
  `advertiser_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `advertiser_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1="Approve", 2="Pending", 3="Reject"',
  `advertiser_rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_reactions`
--

CREATE TABLE `user_reactions` (
  `id` bigint UNSIGNED NOT NULL,
  `comment_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `video_owner_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `is_like` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0="dislike", 1="like"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL DEFAULT '0',
  `storage_id` int NOT NULL DEFAULT '0',
  `video` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumb_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audience` tinyint(1) NOT NULL DEFAULT '0',
  `stock_video` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `visibility` tinyint(1) NOT NULL DEFAULT '0',
  `tagssss` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `step` tinyint(1) NOT NULL DEFAULT '0',
  `is_shorts_video` int NOT NULL DEFAULT '0',
  `is_only_playlist` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `views` bigint NOT NULL DEFAULT '0',
  `is_trending` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_files`
--

CREATE TABLE `video_files` (
  `id` bigint UNSIGNED NOT NULL,
  `video_id` int NOT NULL DEFAULT '0',
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quality` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_resolutions`
--

CREATE TABLE `video_resolutions` (
  `id` bigint UNSIGNED NOT NULL,
  `resolution_label` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` int NOT NULL DEFAULT '0',
  `height` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_tags`
--

CREATE TABLE `video_tags` (
  `id` bigint UNSIGNED NOT NULL,
  `video_id` int NOT NULL DEFAULT '0',
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_histories`
--

CREATE TABLE `watch_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `last_view` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_laters`
--

CREATE TABLE `watch_laters` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `video_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `after_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `withdraw_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT '0.00000000',
  `max_limit` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `fixed_charge` decimal(28,8) DEFAULT '0.00000000',
  `rate` decimal(28,8) DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_settings`
--

CREATE TABLE `withdraw_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `withdraw_method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `user_data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `next_withdraw_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisement_analytics`
--
ALTER TABLE `advertisement_analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisement_category`
--
ALTER TABLE `advertisement_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_play_durations`
--
ALTER TABLE `ad_play_durations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impressions`
--
ALTER TABLE `impressions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_playlists`
--
ALTER TABLE `plan_playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_videos`
--
ALTER TABLE `plan_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist_videos`
--
ALTER TABLE `playlist_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_plans`
--
ALTER TABLE `purchased_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_playlists`
--
ALTER TABLE `purchased_playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_videos`
--
ALTER TABLE `purchased_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storages`
--
ALTER TABLE `storages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reactions`
--
ALTER TABLE `user_reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_files`
--
ALTER TABLE `video_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_resolutions`
--
ALTER TABLE `video_resolutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_tags`
--
ALTER TABLE `video_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watch_laters`
--
ALTER TABLE `watch_laters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_settings`
--
ALTER TABLE `withdraw_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisement_analytics`
--
ALTER TABLE `advertisement_analytics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisement_category`
--
ALTER TABLE `advertisement_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ad_play_durations`
--
ALTER TABLE `ad_play_durations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `impressions`
--
ALTER TABLE `impressions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_playlists`
--
ALTER TABLE `plan_playlists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_videos`
--
ALTER TABLE `plan_videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlist_videos`
--
ALTER TABLE `playlist_videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchased_plans`
--
ALTER TABLE `purchased_plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchased_playlists`
--
ALTER TABLE `purchased_playlists`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchased_videos`
--
ALTER TABLE `purchased_videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `storages`
--
ALTER TABLE `storages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtitles`
--
ALTER TABLE `subtitles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_reactions`
--
ALTER TABLE `user_reactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_files`
--
ALTER TABLE `video_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_resolutions`
--
ALTER TABLE `video_resolutions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_tags`
--
ALTER TABLE `video_tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_histories`
--
ALTER TABLE `watch_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_laters`
--
ALTER TABLE `watch_laters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_settings`
--
ALTER TABLE `withdraw_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
