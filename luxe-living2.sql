-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 08:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxe-living2`
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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 41399.10, '2025-10-02 23:07:41', '2025-10-02 23:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Living room', '2025-10-02 22:57:28', '2025-10-02 22:57:28'),
(2, 'Outdoor', '2025-10-02 22:57:48', '2025-10-02 22:57:48'),
(3, 'Bedroom', '2025-10-02 22:57:56', '2025-10-02 22:57:56'),
(4, 'Hallway', '2025-10-02 22:58:04', '2025-10-02 22:58:04'),
(5, 'Dining room', '2025-10-02 22:58:17', '2025-10-02 22:58:17'),
(6, 'Office room', '2025-10-02 22:58:33', '2025-10-02 22:58:33');

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
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2025_09_19_062124_create_categories_table', 2),
(11, '2025_09_19_100023_create_products_table', 3),
(12, '2025_09_21_163234_create_carts_table', 4),
(13, '2025_09_22_061544_create_orders_table', 5),
(14, '2025_09_22_061707_create_payments_table', 6),
(15, '2025_09_18_050952_add_two_factor_columns_to_users_table', 7),
(16, '2025_09_18_051117_create_personal_access_tokens_table', 7),
(17, '2025_09_21_062641_add_is_active_and_discount_to_products_table', 7),
(18, '2025_10_02_083852_add_google_fields_to_users_table', 7),
(19, '2025_10_02_090252_set_default_role_in_users_table', 7),
(20, '2025_10_02_104820_change_role_column_to_tiny_integer_in_users_table', 7),
(21, '2025_10_03_042152_add_avatar_to_users_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `products` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_address` text NOT NULL,
  `delivery_phone` varchar(255) NOT NULL,
  `delivery_name` varchar(255) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `order_status` enum('order pending','confirmed') NOT NULL DEFAULT 'order pending',
  `payment_status` enum('pending','payment confirmed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('bank_transfer','online_transfer') NOT NULL,
  `receipt_pdf` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `exp_date` varchar(255) DEFAULT NULL,
  `cvv` varchar(255) DEFAULT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'mobile_app', '2284636f83395bebb5288b2a12cc80447679ffec8a39bdd0abc7de14bb4c6a3d', '[\"*\"]', '2025-10-03 00:23:55', NULL, '2025-10-03 00:23:53', '2025-10-03 00:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `image`, `price`, `discount`, `description`, `material`, `colour`, `stock`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '3-Seater Fabric Sofa', '1759466130.jpg', 45999.00, 10.00, 'Comfortable 3-seater sofa with plush cushioning and durable fabric upholstery. Features solid wooden frame and removable cushion covers for easy cleaning. Perfect for contemporary living spaces.', 'Fabric, Hardwood Frame', 'Charcoal Grey', 15, 1, '2025-10-02 23:05:30', '2025-10-02 23:05:30'),
(2, 1, 'Coffee Table', '1759466448.jpg', 12500.00, 0.00, 'Elegant coffee table with natural wood grain finish and sturdy construction. Features lower shelf for storage and magazine display. Adds warmth and character to any living room.', 'Solid Oak Wood', 'Natural Oak Brown', 25, 1, '2025-10-02 23:10:48', '2025-10-02 23:10:48'),
(3, 1, 'Velvet Accent Armchair', '1759466537.jpg', 20999.00, 0.00, 'Luxurious velvet accent chair with high back support and padded armrests. Gold-finished metal legs add a touch of elegance. Ideal for reading corners or as statement seating.', 'Velvet, Foam Padding, Metal', 'Emerald Green', 8, 1, '2025-10-02 23:12:17', '2025-10-02 23:12:17'),
(4, 1, 'Contemporary TV Entertainment Unit', '1759466676.jpg', 28999.00, 10.00, 'Sleek TV console with ample storage space including open shelves and closed cabinets. Cable management system keeps wires organized. Suitable for TVs up to 65 inches.', 'Engineered Wood', 'Walnut Brown', 16, 1, '2025-10-02 23:14:36', '2025-10-02 23:14:36'),
(5, 2, 'Rattan Patio Dining Set', '1759466964.jpg', 47500.00, 15.00, 'Weather-resistant rattan dining set includes table and 4 chairs with comfortable cushions. Perfect for outdoor dining and entertaining. UV-protected and water-resistant for durability in all seasons.', 'PE Rattan, Aluminum Frame, Water-resistant Cushions', 'Natural Brown with Beige Cushions', 10, 1, '2025-10-02 23:19:24', '2025-10-02 23:19:24'),
(6, 2, 'Wooden Garden Bench', '1759467049.jpg', 15800.00, 0.00, 'Traditional garden bench crafted from treated hardwood. Features ergonomic curved backrest for comfort. Weather-treated finish protects against rain and sun damage. Seats 2-3 people comfortably.', 'Treated Teak Wood', 'Natural Teak', 20, 1, '2025-10-02 23:20:49', '2025-10-02 23:20:49'),
(7, 3, 'Queen Platform Bed Frame', '1759467165.jpg', 62000.00, 0.00, 'Elegant queen-size bed frame with button-tufted headboard and sturdy slat support system. No box spring required. Features padded headboard for comfortable reading in bed. Easy assembly with all hardware included.', 'Linen Fabric, Solid Wood Frame, Foam Padding', 'Light Grey', 3, 1, '2025-10-02 23:22:45', '2025-10-02 23:45:57'),
(8, 3, '3-Door Sliding Wardrobe', '1759467344.jpg', 268999.00, 10.00, 'Spacious wardrobe with three sliding doors featuring full-length mirror. Multiple compartments with hanging rails, shelves, and drawers for organized storage. Smooth sliding mechanism with soft-close feature.', 'Engineered Wood, Laminate Finish', 'White and Grey', 9, 1, '2025-10-02 23:25:44', '2025-10-02 23:25:44'),
(9, 4, 'Slim Entryway Console Table', '1759467496.jpg', 16500.00, 23.00, 'Space-saving console table perfect for narrow hallways. Features lower shelf for decorative storage and slim profile design. Ideal for displaying photos, keys, and mail. Sturdy construction with modern aesthetic.', 'Solid Wood, Metal Legs', 'White with Gold Legs', 33, 1, '2025-10-02 23:28:16', '2025-10-02 23:28:16'),
(10, 5, 'Extendable 6-Seater Dining Table', '1759467651.jpg', 345999.00, 13.00, 'Elegant rectangular dining table with extension leaf that seats 6-8 people. Features smooth tabletop surface and sturdy pedestal base. Easy-pull mechanism extends table for hosting guests. Perfect for family dinners and gatherings.', 'Wooden, Cushion', 'Capri Black', 7, 1, '2025-10-02 23:30:51', '2025-10-02 23:30:51'),
(11, 6, 'L-Shaped Executive Computer Desk', '1759467768.jpg', 38600.00, 0.00, 'Spacious L-shaped desk with ample workspace for computer, documents, and office supplies. Features built-in cable management system and scratch-resistant surface. Ideal for home offices and corporate workspaces. Sturdy construction supports multiple monitors.', 'Engineered Wood', 'White', 19, 1, '2025-10-02 23:32:48', '2025-10-02 23:32:48'),
(12, 6, 'Office Chair', '1759467981.jpg', 22400.00, 0.00, 'High-back ergonomic office chair with breathable mesh backrest and adjustable lumbar support. Features adjustable armrests, seat height, and tilt mechanism. 360-degree swivel with smooth-rolling casters. Designed for all-day comfort and productivity.', 'Mesh Fabric, Foam Cushion, Metal Base', 'Brown', 23, 1, '2025-10-02 23:36:21', '2025-10-02 23:36:21'),
(13, 1, 'Orian Classic Sofa Set', '1759468268.jpg', 236999.00, 12.00, 'Premium Orian collection featuring 3-seater, 2-seater, and single armchair with elegant curved armrests. High-resilience foam cushioning provides exceptional comfort. Detailed stitching and tufted backrest add sophistication. Built with reinforced hardwood frame for lasting durability.', 'Premium Linen Fabric, High-density Foam, Solid Hardwood Frame', 'Charcoal Grey', 10, 1, '2025-10-02 23:41:08', '2025-10-02 23:41:08');

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
  `avatar` varchar(255) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google2fa_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `google_refresh_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `google2fa_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `google_id`, `google_token`, `google_refresh_token`) VALUES
(1, 'admin1', 'admin@gmail.com', NULL, 0, NULL, '$2y$12$WjyyU7ueCLE3pnPNWSBXEOAFXmg7LoGkDfCLRG7RohCpNSqJEH.I2', NULL, NULL, NULL, NULL, '2025-10-02 22:40:53', '2025-10-02 22:40:53', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Shalindri Sathiyanathan', 'shalindriapiit@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKyaQW4qbuQFa3ST3c96i6ikbUbifOgaX5yQAeCMT8NEoW_Dvk=s96-c', 1, '2025-10-02 23:46:44', NULL, NULL, 'LbHKtCRgXSeh99ai3SRkbXMYdXGOt57Shnh4dhsBlWewCLEKrgoWvArRdntq', NULL, NULL, '2025-10-02 22:55:49', '2025-10-02 23:46:44', NULL, NULL, NULL, '101790893108637750317', NULL, NULL),
(3, 'Grace William', 'grace@gmail.com', NULL, 1, NULL, '$2y$12$ZXwKtE7dUWpOIr9HnOHdOuB1rw0FuWGWCwsI7sirSEUe1FZcbXJKK', NULL, NULL, NULL, NULL, '2025-10-03 00:23:22', '2025-10-03 00:23:22', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
