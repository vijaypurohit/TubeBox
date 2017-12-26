-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2017 at 01:58 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctube`
--

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE `channels` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`id`, `user_id`, `name`, `slug`, `description`, `image_filename`, `created_at`, `updated_at`) VALUES
(1, 1, 'CIT', 'CIT', 'Learn to Code and swim in Ocean', 'img1CIT.png', '2017-04-19 17:35:46', '2017-06-14 04:19:48'),
(2, 2, 'vpCit', 'vpCit', 'Whole New Description', 'img2vpCit.png', '2017-06-08 02:10:03', '2017-06-16 04:02:12');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reply_id` int(10) UNSIGNED DEFAULT NULL,
  `commentable_id` int(11) NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `reply_id`, `commentable_id`, `commentable_type`, `body`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 38, 'App\\Models\\Video', 'Test Comment', '2017-06-10 07:36:54', '2017-06-10 07:16:06', '2017-06-10 07:36:54'),
(2, 2, NULL, 38, 'App\\Models\\Video', 'Another user Test Comment', NULL, '2017-06-10 07:16:06', '2017-06-10 08:16:20'),
(3, 1, 2, 38, 'App\\Models\\Video', 'This is reply to sec user', NULL, '2017-06-10 07:16:06', '2017-06-10 08:16:20'),
(4, 1, 2, 38, 'App\\Models\\Video', 'This is another reply to sec user', NULL, '2017-06-10 07:16:06', '2017-06-10 08:16:20'),
(5, 1, NULL, 38, 'App\\Models\\Video', 'i typed', '2017-06-10 07:38:16', '2017-06-10 06:27:20', '2017-06-10 07:38:16'),
(6, 1, 1, 38, 'App\\Models\\Video', 'new reply', '2017-06-10 07:36:50', '2017-06-10 07:25:15', '2017-06-10 07:36:50'),
(7, 2, 5, 38, 'App\\Models\\Video', 'Another user Test Comment', NULL, '2017-06-10 07:16:06', '2017-06-10 08:16:20'),
(8, 1, NULL, 38, 'App\\Models\\Video', 'new', NULL, '2017-06-12 01:47:33', '2017-06-12 01:47:33'),
(9, 1, NULL, 109, 'App\\Models\\Video', 'new', '2017-06-15 08:21:55', '2017-06-15 08:21:42', '2017-06-15 08:21:55'),
(10, 1, 9, 109, 'App\\Models\\Video', 'reply', NULL, '2017-06-15 08:21:50', '2017-06-15 08:21:50'),
(11, 2, NULL, 125, 'App\\Models\\Video', 'Hi', NULL, '2017-06-16 05:41:14', '2017-06-16 05:41:14'),
(12, 2, NULL, 125, 'App\\Models\\Video', 'another hi', '2017-06-16 05:47:21', '2017-06-16 05:44:23', '2017-06-16 05:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_04_19_224435_create_channels_table', 1),
(4, '2017_04_19_230932_create_jobs_table', 2),
(5, '2017_04_19_230949_create_failed_jobs_table', 2),
(6, '2017_04_22_114144_create_videos_table', 3),
(7, '2017_04_24_205327_create_video_views_table', 4),
(8, '2017_04_24_205453_create_votes_table', 4),
(9, '2017_04_24_205528_create_comments_table', 4),
(10, '2017_04_24_205602_create_subscriptions_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `channel_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `channel_id`, `created_at`, `updated_at`) VALUES
(25, 2, 1, '2017-06-15 23:55:39', '2017-06-15 23:55:39'),
(28, 1, 2, '2017-06-17 06:12:02', '2017-06-17 06:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Vijay Purohit', 'vijay.pu9@gmail.com', '$2y$10$mwWN84X9stRFh5bPHH9QRuCWKjIHiWmX6uJgs5X8hosDQekuZFDHe', '0dOH5sHdcz3M5Nfg80L8tssRj6N4nOJlnW9zeAOyhRTct4aTp20sZzDEXcM4', '2017-04-19 17:35:46', '2017-04-19 17:35:46'),
(2, 'vp', 'vp@gmail.com', '$2y$10$n4Q2IJasmPrH/htrxAQltOJoYUOpusvZ5V81f0grb2gTbM4NFpbo6', '03QAIuPs4qVTQ4qJxiSGQEvrkBa1ZA7ESYOJlA8hzyc5ITYjPXcz9l20dhwY', '2017-06-08 02:10:03', '2017-06-08 02:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `channel_id` int(10) UNSIGNED NOT NULL,
  `uid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `video_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` enum('public','unlisted','private') COLLATE utf8mb4_unicode_ci NOT NULL,
  `allow_votes` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comments` tinyint(1) NOT NULL DEFAULT '0',
  `processed_percentage` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `channel_id`, `uid`, `title`, `description`, `processed`, `video_id`, `video_filename`, `visibility`, `allow_votes`, `allow_comments`, `processed_percentage`, `deleted_at`, `created_at`, `updated_at`) VALUES
(36, 1, '1s_158f7ed4a4adbd_v_1592bc3c01c89b', 'Untitled', NULL, 0, NULL, '1s_158f7ed4a4adbd_v_1592bc3c01c89b.MP4', 'public', 1, 0, 86, NULL, '2017-05-29 01:16:24', '2017-05-29 01:16:24'),
(38, 1, '1s_158f7ed4a4adbd_v_159368e116f1db', 'Oceans Test', 'THis is new video created after changing file max post and upload size to 25mb', 1, '1s_158f7ed4a4adbd_v_', '1s_158f7ed4a4adbd_v_159368e116f1db.mp4', 'public', 1, 1, 99, NULL, '2017-06-06 05:42:17', '2017-06-17 04:19:31'),
(109, 1, '1s_CIT_v_1594289711331f', 'Customised', 'The Video Uploaded after Custom Transcoding', 1, '3zizuj71prd785i9tze97xskbonupb', '1s_CIT_v_1594289711331f.mp4', 'public', 1, 1, 99, NULL, '2017-06-15 07:49:45', '2017-06-15 08:08:09'),
(110, 1, '1s_CIT_v_159429240b2f06', 'Second Customised Video', 'It is a second video customised in a row', 1, 'uo4xc3a6gx2pycoeoptn8svgovehc7', '1s_CIT_v_159429240b2f06.MP4', 'public', 0, 0, 99, NULL, '2017-06-15 08:27:20', '2017-06-15 08:27:29'),
(122, 2, '2s_vpCit_v_159438cd60166b', 'Coals Mov', 'This is in mOv Format', 1, 'glgs7ld1yih8cnv6wdlpl83ypiuq4a', '2s_vpCit_v_159438cd60166b.mov', 'public', 1, 1, 100, NULL, '2017-06-16 02:16:30', '2017-06-16 02:17:12'),
(123, 2, '2s_vpCit_v_1594396c1bd6f7', 'morgan avi', 'this is in avi format', 1, '8r6fw36d6whxc5056zckin0qg431mh', '2s_vpCit_v_1594396c1bd6f7.avi', 'public', 1, 1, 99, NULL, '2017-06-16 02:58:49', '2017-06-16 05:28:29'),
(124, 2, '2s_vpCit_v_15943a86f8a767', 'The Flv Video - The Bunny Video', 'this is video in flv format', 1, '6mub4ofe2d10q2c1vrk9sy368ojjmz', '2s_vpCit_v_15943a86f8a767.flv', 'public', 1, 1, 100, NULL, '2017-06-16 04:14:15', '2017-06-16 07:42:56'),
(125, 2, '2s_vpCit_v_15943bacdeb8e9', 'the Video in Mkv - the Bunny Video awesome one', 'This is video in Mkv format', 1, 'gykgln0njr25jd7qg9uyrgkgwwpgks', '2s_vpCit_v_15943bacdeb8e9.mkv', 'public', 1, 1, 100, NULL, '2017-06-16 05:32:37', '2017-06-16 07:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `video_views`
--

CREATE TABLE `video_views` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `video_id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_views`
--

INSERT INTO `video_views` (`id`, `user_id`, `video_id`, `ip`, `created_at`, `updated_at`) VALUES
(3, 1, 38, '127.0.0.1', '2017-06-08 01:03:51', '2017-06-08 01:03:51'),
(4, 1, 38, '127.0.0.1', '2017-06-08 01:04:53', '2017-06-08 01:04:53'),
(6, 1, 38, '127.0.0.1', '2017-06-12 01:29:21', '2017-06-12 01:29:21'),
(7, NULL, 38, '127.0.0.1', '2017-06-12 01:58:44', '2017-06-12 01:58:44'),
(8, 1, 38, '127.0.0.1', '2017-06-12 04:54:31', '2017-06-12 04:54:31'),
(9, 1, 38, '127.0.0.1', '2017-06-14 04:42:17', '2017-06-14 04:42:17'),
(10, 1, 38, '127.0.0.1', '2017-06-14 04:43:48', '2017-06-14 04:43:48'),
(11, 1, 109, '127.0.0.1', '2017-06-15 08:07:23', '2017-06-15 08:07:23'),
(12, 1, 110, '127.0.0.1', '2017-06-15 08:28:33', '2017-06-15 08:28:33'),
(13, 2, 38, '127.0.0.1', '2017-06-15 23:07:49', '2017-06-15 23:07:49'),
(14, 2, 109, '127.0.0.1', '2017-06-15 23:08:44', '2017-06-15 23:08:44'),
(15, 2, 38, '127.0.0.1', '2017-06-15 23:09:00', '2017-06-15 23:09:00'),
(16, 2, 110, '127.0.0.1', '2017-06-15 23:09:28', '2017-06-15 23:09:28'),
(17, 2, 122, '127.0.0.1', '2017-06-16 02:17:01', '2017-06-16 02:17:01'),
(18, 2, 122, '127.0.0.1', '2017-06-16 02:58:16', '2017-06-16 02:58:16'),
(19, 2, 123, '127.0.0.1', '2017-06-16 03:00:01', '2017-06-16 03:00:01'),
(20, 2, 125, '127.0.0.1', '2017-06-16 05:41:28', '2017-06-16 05:41:28'),
(21, 2, 124, '127.0.0.1', '2017-06-16 05:43:02', '2017-06-16 05:43:02'),
(22, 2, 125, '127.0.0.1', '2017-06-16 05:47:06', '2017-06-16 05:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `voteable_id` int(11) NOT NULL,
  `voteable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('up','down') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `voteable_id`, `voteable_type`, `type`, `created_at`, `updated_at`) VALUES
(6, 1, 39, 'App\\Models\\Video', 'up', '2017-06-12 01:29:09', '2017-06-12 01:29:09'),
(13, 1, 109, 'App\\Models\\Video', 'up', '2017-06-15 08:21:35', '2017-06-15 08:21:35'),
(15, 2, 38, 'App\\Models\\Video', 'up', '2017-06-15 23:09:20', '2017-06-15 23:09:20'),
(24, 2, 109, 'App\\Models\\Video', 'up', '2017-06-15 23:55:30', '2017-06-15 23:55:30'),
(25, 2, 125, 'App\\Models\\Video', 'up', '2017-06-16 05:41:21', '2017-06-16 05:41:21'),
(26, 1, 38, 'App\\Models\\Video', 'down', '2017-06-17 04:19:42', '2017-06-17 04:19:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `channels_slug_unique` (`slug`),
  ADD KEY `channels_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_reply_id_foreign` (`reply_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_channel_id_foreign` (`channel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videos_channel_id_foreign` (`channel_id`);

--
-- Indexes for table `video_views`
--
ALTER TABLE `video_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_views_user_id_foreign` (`user_id`),
  ADD KEY `video_views_video_id_foreign` (`video_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channels`
--
ALTER TABLE `channels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT for table `video_views`
--
ALTER TABLE `video_views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `channels`
--
ALTER TABLE `channels`
  ADD CONSTRAINT `channels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_channel_id_foreign` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_views`
--
ALTER TABLE `video_views`
  ADD CONSTRAINT `video_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_views_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
