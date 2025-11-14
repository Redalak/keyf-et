-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 14, 2025 at 02:20 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keyf-et`
--

-- --------------------------------------------------------

--
-- Table structure for table `capacity_overrides`
--

CREATE TABLE `capacity_overrides` (
  `id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `max_guests` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capacity_settings`
--

CREATE TABLE `capacity_settings` (
  `id` tinyint UNSIGNED NOT NULL,
  `max_guests_per_slot` int UNSIGNED NOT NULL DEFAULT '20',
  `slot_minutes` smallint UNSIGNED NOT NULL DEFAULT '30',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capacity_settings`
--

INSERT INTO `capacity_settings` (`id`, `max_guests_per_slot`, `slot_minutes`, `updated_at`) VALUES
(1, 20, 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `position` smallint UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `description`, `position`, `active`) VALUES
(1, 'Entrées', 'Pour commencer', 1, 1),
(2, 'Plats', 'Les incontournables', 2, 1),
(3, 'Desserts', 'Douceurs', 3, 1),
(4, 'Boissons', 'Pour se désaltérer', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `position` smallint UNSIGNED NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `category_id`, `name`, `description`, `image_url`, `price`, `position`, `active`) VALUES
(1, 2, 'Assiette de Mezze', NULL, 'assets/img/carte/assiette-de-mezze.webp', 0.00, 1, 1),
(2, 2, 'Beyti', NULL, 'assets/img/carte/beyti.webp', 0.00, 2, 1),
(3, 2, 'Kebab adana', NULL, 'assets/img/carte/kebab-adana.webp', 0.00, 3, 1),
(4, 2, 'Grillades Mixte 3 personnes', NULL, 'assets/img/carte/grillades-mixte-3p.webp', 0.00, 4, 1),
(5, 2, 'Assiettes grillades 4 personnes', NULL, 'assets/img/carte/assiettes-grillades-4p.webp', 0.00, 5, 1),
(6, 2, 'Planche familial', NULL, 'assets/img/carte/planche-familial.webp', 0.00, 6, 1),
(7, 2, 'Brochette d’agneau', NULL, 'assets/img/carte/brochette-agneau-2.webp', 0.00, 7, 1),
(8, 2, 'Pizza turc', NULL, 'assets/img/carte/pizza-turc.webp', 0.00, 8, 1),
(9, 2, 'Soupes aux tripes', NULL, 'assets/img/carte/soupes-tripes.webp', 0.00, 9, 1),
(10, 2, 'Soupe de lentille au corail', NULL, 'assets/img/carte/soupe-lentille-corail.webp', 0.00, 10, 1),
(11, 2, 'Plat du jour', NULL, 'assets/img/carte/plat-du-jour.webp', 0.00, 11, 1),
(12, 2, 'Kefta', NULL, 'assets/img/carte/kefta.webp', 0.00, 12, 1),
(13, 2, 'Grillade Mixte', NULL, 'assets/img/carte/grillade-mixte.webp', 0.00, 13, 1),
(14, 2, 'Ali Nazik', NULL, 'assets/img/carte/ali-nazik.webp', 0.00, 14, 1),
(15, 2, 'Kebab d’aubergine', NULL, 'assets/img/carte/kebab-aubergine.webp', 0.00, 15, 1),
(16, 4, 'Café turc', NULL, 'assets/img/carte/cafe-turc.webp', 0.00, 1, 1),
(17, 4, 'Expresso', NULL, 'assets/img/carte/expresso.webp', 0.00, 2, 1),
(18, 4, 'Thé noir', NULL, 'assets/img/carte/the-noir.webp', 0.00, 3, 1),
(19, 3, 'Kunefe', NULL, 'assets/img/carte/kunefe.webp', 0.00, 1, 1),
(20, 3, 'Riz au lait', NULL, 'assets/img/carte/riz-au-lait.webp', 0.00, 2, 1),
(21, 3, 'Baklava pistache', NULL, 'assets/img/carte/baklava-pistache.webp', 0.00, 3, 1),
(22, 1, 'Assiette Mezze', NULL, 'assets/img/carte/assiette-mezze.webp', 0.00, 1, 1),
(23, 1, 'Salade Coban', NULL, 'assets/img/carte/salade-coban.webp', 0.00, 2, 1),
(24, 1, 'Pidet Aux Fromages', NULL, 'assets/img/carte/pidet-aux-fromages.webp', 0.00, 3, 1),
(25, 1, 'Pidet Agneaux', NULL, 'assets/img/carte/pidet-agneaux.webp', 0.00, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` tinyint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('customer','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capacity_overrides`
--
ALTER TABLE `capacity_overrides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_dt_time` (`date`,`time`);

--
-- Indexes for table `capacity_settings`
--
ALTER TABLE `capacity_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_active_position` (`active`,`position`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_position` (`category_id`,`position`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date_time` (`date`,`time`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capacity_overrides`
--
ALTER TABLE `capacity_overrides`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu_items_category` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
