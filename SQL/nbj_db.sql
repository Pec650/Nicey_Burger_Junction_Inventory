-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 03:33 PM
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
-- Database: `nbj_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `map_html` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_name`, `barangay`, `city`, `phone_num`, `map_html`, `updated_at`, `created_at`) VALUES
(1, 'Mactan Newtown Branch', 'Lapu Lapu City', 'Cebu', '09225864821', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d412.60687855449055!2d124.0105853115941!3d10.3098150102535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9979b9b4848cf%3A0x914d2eebdd07a45c!2sNicey%20Burger%20Junction%20Mactan%20Newtown%20Branch!5e0!3m2!1sen!2sph!4v1760790858920!5m2!1sen!2sph\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '2025-10-15 13:03:52', '2025-10-15 13:03:52'),
(2, 'Apas Branch', 'San Miguel Rd', 'Cebu', '09959944866', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d825.152108231691!2d123.90630900732855!3d10.33331895186003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9998d0fd28a1f%3A0x4b583d7c8b5497f8!2sNicey%20Burger%20Junction%20-%20Apas%20Branch!5e0!3m2!1sen!2sph!4v1760790100482!5m2!1sen!2sph\" width=\"100%\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '2025-10-18 12:10:56', '2025-10-18 12:10:56');

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
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `user_type` enum('Cashier','Manager','Admin') NOT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `user_type`, `branch_id`) VALUES
(1, 'Admin', 'admin1234@gmail.com', NULL, '$2y$12$eY1oEQvMteweU7Y/I5zJt.nX/Kferqr1SuIqkgZm1q1mfDEGF2R/6', NULL, '2025-10-23 12:09:28', '2025-10-23 12:09:28', 'Admin', NULL);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` double NOT NULL,
  `request` text DEFAULT NULL,
  `status` enum('Pending','Ongoing','Complete') NOT NULL DEFAULT 'Pending',
  `payment_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `total_price`, `request`, `status`, `payment_id`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 40, NULL, 'Complete', 3, '2025-10-19 21:53:24', '2025-10-19 21:37:26'),
(2, 1, 3, 1, 66, 'Cookies', 'Complete', 3, '2025-10-19 21:53:24', '2025-10-19 21:37:31'),
(3, 1, 1, 1, 40, NULL, 'Complete', 4, '2025-10-19 21:54:35', '2025-10-19 21:54:23'),
(4, 1, 21, 1, 20, NULL, 'Complete', 4, '2025-10-19 21:54:35', '2025-10-19 21:54:28'),
(5, 1, 2, 1, 58, NULL, 'Complete', 5, '2025-10-19 22:11:13', '2025-10-19 22:05:06');

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `total_payment` double NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `remarks` enum('Ongoing','Completed','Cancelled') NOT NULL DEFAULT 'Ongoing',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `user_id`, `branch_id`, `total_payment`, `total_quantity`, `remarks`, `updated_at`, `created_at`) VALUES
(1, 1, 2, 106, 2, 'Cancelled', '2025-10-19 21:42:13', '2025-10-19 21:37:35'),
(2, 1, 2, 106, 2, 'Cancelled', '2025-10-19 21:42:23', '2025-10-19 21:42:21'),
(3, 1, 2, 106, 2, 'Completed', '2025-10-19 21:53:24', '2025-10-19 21:42:26'),
(4, 1, 2, 60, 2, 'Completed', '2025-10-19 21:54:35', '2025-10-19 21:54:32'),
(5, 1, 2, 58, 1, 'Completed', '2025-10-19 22:11:13', '2025-10-19 22:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `type` enum('Buy 1 Take 1','Regular','Drinks','Others') NOT NULL DEFAULT 'Regular',
  `img_dir` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `type`, `img_dir`) VALUES
(1, 'Nice Hamburger', 40, 'Buy 1 Take 1', 'NiceHamburgerx2.png'),
(2, 'Nice Cheeseburger', 58, 'Buy 1 Take 1', 'NiceCheeseBurgerx2.png'),
(3, 'Nice Hamburger with Egg', 66, 'Buy 1 Take 1', 'Hamburger_with_Eggx2.png'),
(4, 'Nice Hotdog Sandwich', 46, 'Buy 1 Take 1', 'Hotdog_Sandwichx2.png'),
(5, 'Nice Cheesedog', 64, 'Buy 1 Take 1', 'Cheesedog.png'),
(6, 'Nice Footlong', 85, 'Buy 1 Take 1', 'Footlongx2.png'),
(7, 'Nice Cheeseburger with Egg', 84, 'Buy 1 Take 1', 'Cheeseburger_with_Eggx2.png'),
(8, 'Ham and Cheese', 37, 'Regular', 'NiceCheeseBurger.png'),
(9, 'Ham and Egg with Cheese', 50, 'Regular', 'Ham and Egg with Cheese.png'),
(10, 'Ham and Egg', 41, 'Regular', 'Hamburger with Egg.png'),
(11, 'Bacon and Cheese', 37, 'Regular', 'Bacon_and_Cheese.png'),
(12, 'Bacon and Egg with Cheese', 50, 'Regular', 'Bacon and Egg with Cheese.png'),
(13, 'Bacon and Egg', 41, 'Regular', 'Bacon_and_Egg.png'),
(14, 'Egg Sandwich', 22, 'Regular', 'Egg_Sandwich.png'),
(16, 'Nice Siopao', 40, 'Regular', 'Siopao.png'),
(17, 'Nice Pizza Solo', 55, 'Regular', 'Pizza_Solo.png'),
(19, 'C2 Solo', 20, 'Drinks', 'C2_Solo.png'),
(20, 'C2 500', 33, 'Drinks', 'C2_500.png'),
(21, 'Nature Spring 500ml', 20, 'Drinks', 'Nature_Spring_500ml.png'),
(22, 'Chuckie', 35, 'Drinks', 'Chuckie.png'),
(23, 'Plus', 15, 'Drinks', 'Plus.png'),
(24, 'Kopiko 78', 22, 'Drinks', 'Kopiko_78.png'),
(25, 'Company J', 15, 'Drinks', 'Company_J.png'),
(26, 'Softdrinks 8oz', 18, 'Drinks', 'Pepsi_8oz.png'),
(27, 'Softdrinks 12oz', 25, 'Drinks', 'Pepsi_12oz.png'),
(28, 'Softdrinks 300ml', 26, 'Drinks', 'Pepsi_300ml.png'),
(29, 'JUICE IN CAN-PHIL BRAND', 25, 'Drinks', 'JUICE_IN_CAN-PHIL_BRAND.png'),
(30, '3 in 1 Coffee', 7, 'Drinks', '3_n_1_Coffee.png'),
(31, 'Noodles', 20, 'Others', 'Noodles.png'),
(32, 'Pancit Cantoon', 25, 'Others', 'Pancit_Canton.png'),
(33, 'Cup Noodles', 30, 'Others', 'Cup_Noodles.png');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('nuq9uf62jCRFSO4Uv3Nrpn96QyV8NovzSt7vPp2M', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibEVsMmNvbXoyTzFqYlhFa2t5OVE2azJDRFR2c2tBVWc5S0diaVBkSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761225876);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `user_type` enum('Member','Guest') NOT NULL DEFAULT 'Guest',
  `branch_id` int(11) DEFAULT NULL,
  `pass_code` varchar(255) DEFAULT NULL,
  `pass_code_exp_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `user_type`, `branch_id`, `pass_code`, `pass_code_exp_date`) VALUES
(1, 'Customer1234', 'customer1234@gmail.com', NULL, '$2y$12$eY1oEQvMteweU7Y/I5zJt.nX/Kferqr1SuIqkgZm1q1mfDEGF2R/6', NULL, '2025-10-11 05:27:32', '2025-10-20 02:20:23', 'Member', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
