-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 06:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worknest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `user_name`, `action`, `details`, `created_at`) VALUES
(1, NULL, 'Guest', 'CART_ADD', 'Added to cart: Open Shelf Bookcase', '2026-07-07 05:34:17'),
(2, NULL, 'Guest', 'CART_ADD', 'Added to cart: OakLine Office Desk 120cm', '2026-07-07 05:53:01'),
(3, NULL, 'Guest', 'CART_REMOVE', 'Removed product #9 from cart', '2026-07-07 06:06:37'),
(4, NULL, 'Guest', 'CART_REMOVE', 'Removed product #4 from cart', '2026-07-07 06:06:38'),
(5, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:24:57'),
(6, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:24:58'),
(7, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:24:59'),
(8, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:25:00'),
(9, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:25:00'),
(10, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:25:01'),
(11, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:25:01'),
(12, NULL, 'Guest', 'CART_REMOVE', 'Removed product #3 from cart', '2026-07-07 06:25:05'),
(13, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-07 06:35:21'),
(14, NULL, 'Guest', 'CART_REMOVE', 'Removed product #3 from cart', '2026-07-07 06:35:41'),
(15, NULL, 'Guest', 'REGISTER', 'New account registered: yrresuguitan00@gmail.com', '2026-07-07 08:22:42'),
(16, NULL, 'Guest', 'VERIFY_EMAIL', 'Email verified: yrresuguitan00@gmail.com', '2026-07-07 08:34:56'),
(17, 1, 'Yrre Suguitan', 'LOGIN', 'yrresuguitan00@gmail.com logged in', '2026-07-07 08:35:12'),
(18, 1, 'Yrre Suguitan', 'LOGOUT', 'Yrre Suguitan logged out', '2026-07-07 08:35:22'),
(19, NULL, 'Guest', 'CART_ADD', 'Added to cart: ErgoFlex Task Chair', '2026-07-07 08:39:45'),
(20, NULL, 'Guest', 'CART_ADD', 'Added to cart: ErgoFlex Task Chair', '2026-07-07 08:39:46'),
(21, NULL, 'Guest', 'CART_UPDATE', 'Cart quantities updated', '2026-07-07 08:39:54'),
(22, NULL, 'Guest', 'CART_UPDATE', 'Cart quantities updated', '2026-07-07 08:39:56'),
(23, 1, 'Yrre Suguitan', 'LOGIN', 'yrresuguitan00@gmail.com logged in', '2026-07-07 08:40:01'),
(24, 1, 'Yrre Suguitan', 'CHECKOUT', 'Placed order #1 (total 10,998.00)', '2026-07-07 08:40:09'),
(25, 1, 'Yrre Suguitan', 'PAYMENT', 'Order #1 paid via Cash on Delivery', '2026-07-07 08:40:19'),
(26, 1, 'Yrre Suguitan', 'LOGOUT', 'Yrre Suguitan logged out', '2026-07-11 11:05:54'),
(27, 1, 'Yrre Suguitan', 'LOGIN', 'yrresuguitan00@gmail.com logged in', '2026-07-11 11:05:57'),
(28, 1, 'Yrre Suguitan', 'LOGOUT', 'Yrre Suguitan logged out', '2026-07-11 11:05:59'),
(29, NULL, 'Guest', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-11 11:08:00'),
(30, NULL, 'Guest', 'CART_ADD', 'Added to cart: ErgoFlex Task Chair', '2026-07-11 11:08:02'),
(31, 1, 'Yrre Suguitan', 'LOGIN', 'yrresuguitan00@gmail.com logged in', '2026-07-11 11:13:06'),
(32, 1, 'Yrre Suguitan', 'CART_UPDATE', 'Cart quantities updated', '2026-07-11 11:15:56'),
(33, 1, 'Yrre Suguitan', 'CART_UPDATE', 'Cart quantities updated', '2026-07-11 11:15:57'),
(34, 1, 'Yrre Suguitan', 'CHECKOUT', 'Placed order #2 (total 8,749.00)', '2026-07-11 11:16:03'),
(35, 1, 'Yrre Suguitan', 'PAYMENT', 'Order #2 paid via Cash on Delivery', '2026-07-11 11:16:10'),
(36, 1, 'Yrre Suguitan', 'LOGOUT', 'Yrre Suguitan logged out', '2026-07-11 11:32:05'),
(37, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 11:32:19'),
(38, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 12:10:49'),
(39, 3, 'Test Buyer', 'LOGIN', 'buyer@worknest.local logged in', '2026-07-11 12:11:18'),
(40, 3, 'Test Buyer', 'LOGOUT', 'Test Buyer logged out', '2026-07-11 12:16:58'),
(41, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 12:17:02'),
(42, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 14:45:54'),
(43, 3, 'Test Buyer', 'LOGIN', 'buyer@worknest.local logged in', '2026-07-11 14:46:03'),
(44, 3, 'Test Buyer', 'LOGOUT', 'Test Buyer logged out', '2026-07-11 14:46:27'),
(45, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 14:46:33'),
(46, 2, 'WorkNest Administrator', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-11 14:46:51'),
(47, 2, 'WorkNest Administrator', 'CART_ADD', 'Added to cart: OakLine Office Desk 120cm', '2026-07-11 14:46:52'),
(48, 2, 'WorkNest Administrator', 'CART_ADD', 'Added to cart: Anti-Fatigue Floor Mat', '2026-07-11 14:46:55'),
(49, 2, 'WorkNest Administrator', 'CHECKOUT', 'Placed order #3 (total 12,048.00)', '2026-07-11 14:47:02'),
(50, 2, 'WorkNest Administrator', 'PAYMENT', 'Order #3 paid via Cash on Delivery', '2026-07-11 14:47:06'),
(51, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:08:47'),
(52, 1, 'Yrre Suguitan', 'LOGIN', 'yrresuguitan00@gmail.com logged in', '2026-07-11 15:08:55'),
(53, 1, 'Yrre Suguitan', 'LOGOUT', 'Yrre Suguitan logged out', '2026-07-11 15:09:36'),
(54, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:09:43'),
(55, 2, 'WorkNest Administrator', 'USER_EDIT', 'Admin edited user #1', '2026-07-11 15:09:51'),
(56, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:09:56'),
(57, NULL, 'Guest', 'REGISTER', 'New account registered: janedoe@gmail.com', '2026-07-11 15:11:07'),
(58, NULL, 'Guest', 'REGISTER', 'New account registered: janedoe1@gmail.com', '2026-07-11 15:11:55'),
(59, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:12:14'),
(60, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:12:30'),
(61, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:14:30'),
(62, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:14:57'),
(63, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:21:44'),
(64, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:23:33'),
(65, 3, 'Test Buyer', 'LOGIN', 'buyer@worknest.local logged in', '2026-07-11 15:25:39'),
(66, 3, 'Test Buyer', 'CART_ADD', 'Added to cart: Executive Leather Chair', '2026-07-11 15:25:42'),
(67, 3, 'Test Buyer', 'CART_ADD', 'Added to cart: ErgoFlex Task Chair', '2026-07-11 15:25:42'),
(68, 3, 'Test Buyer', 'CART_ADD', 'Added to cart: Drafting Stool', '2026-07-11 15:25:43'),
(69, 3, 'Test Buyer', 'CART_ADD', 'Added to cart: Desk Organizer Set', '2026-07-11 15:25:45'),
(70, 3, 'Test Buyer', 'CART_ADD', 'Added to cart: Desk Organizer Set', '2026-07-11 15:25:46'),
(71, 3, 'Test Buyer', 'CHECKOUT', 'Placed order #4 (total 19,046.00)', '2026-07-11 15:25:53'),
(72, 3, 'Test Buyer', 'PAYMENT', 'Order #4 paid via Cash on Delivery', '2026-07-11 15:25:58'),
(73, 3, 'Test Buyer', 'LOGOUT', 'Test Buyer logged out', '2026-07-11 15:28:07'),
(74, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:29:06'),
(75, 2, 'WorkNest Administrator', 'LOGOUT', 'WorkNest Administrator logged out', '2026-07-11 15:32:45'),
(76, 2, 'WorkNest Administrator', 'LOGIN', 'admin@worknest.local logged in', '2026-07-11 15:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Chairs'),
(2, 'Tables & Desks'),
(3, 'Storage'),
(4, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ship_name` varchar(100) NOT NULL,
  `ship_address` varchar(255) NOT NULL,
  `ship_contact` varchar(30) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(30) DEFAULT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `ship_name`, `ship_address`, `ship_contact`, `total`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 'Yrre Suguitan', 'Sampaloc', '09497763572', 10998.00, 'Cash on Delivery', 'paid', '2026-07-07 08:40:09'),
(2, 1, 'Yrre Suguitan', 'Sampaloc', '09497763572', 8749.00, 'Cash on Delivery', 'paid', '2026-07-11 11:16:03'),
(3, 2, 'WorkNest Administrator', 'WorkNest HQ, Quezon City', '09170000001', 12048.00, 'Cash on Delivery', 'paid', '2026-07-11 14:47:02'),
(4, 3, 'Test Buyer', '123 Sample St., Quezon City', '09170000002', 19046.00, 'Cash on Delivery', 'paid', '2026-07-11 15:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 1, 'ErgoFlex Task Chair', 5499.00, 2),
(2, 2, 3, 'Drafting Stool', 3250.00, 1),
(3, 2, 1, 'ErgoFlex Task Chair', 5499.00, 1),
(4, 3, 3, 'Drafting Stool', 3250.00, 1),
(5, 3, 4, 'OakLine Office Desk 120cm', 7499.00, 1),
(6, 3, 12, 'Anti-Fatigue Floor Mat', 1299.00, 1),
(7, 4, 2, 'Executive Leather Chair', 8999.00, 1),
(8, 4, 1, 'ErgoFlex Task Chair', 5499.00, 1),
(9, 4, 3, 'Drafting Stool', 3250.00, 1),
(10, 4, 11, 'Desk Organizer Set', 649.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `created_at`) VALUES
(1, 1, 'ErgoFlex Task Chair', 'Adjustable mesh-back office chair with lumbar support and tilt lock.', 5499.00, 21, '2026-07-07 05:28:34'),
(2, 1, 'Executive Leather Chair', 'High-back bonded leather chair with padded armrests.', 8999.00, 11, '2026-07-07 05:28:34'),
(3, 1, 'Drafting Stool', 'Height-adjustable stool with foot ring, good for standing desks.', 3250.00, 15, '2026-07-07 05:28:34'),
(4, 2, 'OakLine Office Desk 120cm', 'Laminated oak-finish desk with cable grommet and side drawer.', 7499.00, 14, '2026-07-07 05:28:34'),
(5, 2, 'Conference Table 8-Seater', 'Rectangular meeting table with sturdy steel legs.', 15999.00, 5, '2026-07-07 05:28:34'),
(6, 2, 'Adjustable Standing Desk', 'Manual crank sit-stand desk, 70-115cm height range.', 11999.00, 8, '2026-07-07 05:28:34'),
(7, 3, 'Steel Filing Cabinet 4-Drawer', 'Lockable vertical filing cabinet, powder-coated steel.', 6799.00, 10, '2026-07-07 05:28:34'),
(8, 3, 'Mobile Pedestal', '3-drawer under-desk pedestal with casters and central lock.', 3999.00, 20, '2026-07-07 05:28:34'),
(9, 3, 'Open Shelf Bookcase', '5-tier laminated bookcase for files and binders.', 4599.00, 14, '2026-07-07 05:28:34'),
(10, 4, 'Monitor Riser Stand', 'Bamboo monitor stand with phone slot and storage space.', 899.00, 40, '2026-07-07 05:28:34'),
(11, 4, 'Desk Organizer Set', 'Mesh organizer set: pen holder, letter tray, and sorter.', 649.00, 48, '2026-07-07 05:28:34'),
(12, 4, 'Anti-Fatigue Floor Mat', 'Cushioned standing mat, 50x80cm, non-slip base.', 1299.00, 29, '2026-07-07 05:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(30) NOT NULL,
  `role` enum('admin','buyer') NOT NULL DEFAULT 'buyer',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verify_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `address`, `contact_no`, `role`, `is_verified`, `verify_token`, `created_at`) VALUES
(1, 'Yrre Suguitan', 'yrresuguitan00@gmail.com', '$2y$10$jS4N3QQki3QQueAXjzlyp.lVXBhvqkcTE2v44N87KiFKtbup1m36u', 'Sampaloc', '09497763572', 'admin', 1, NULL, '2026-07-07 08:22:40'),
(2, 'WorkNest Administrator', 'admin@worknest.local', '$2y$10$yR/C1nHPo2tCzaYrAdLT4usVOC/v5/UAUzgQTX3ubli6D3vJK3dsO', 'WorkNest HQ, Quezon City', '09170000001', 'admin', 1, NULL, '2026-07-11 11:31:38'),
(3, 'Test Buyer', 'buyer@worknest.local', '$2y$10$pmXIjGAiNA8mv8qLpFGj7.I79QX9b9L7BJjjiQQhYox8ZwwwClleG', '123 Sample St., Quezon City', '09170000002', 'buyer', 1, NULL, '2026-07-11 11:31:38'),
(4, 'Jane Doe', 'janedoe@gmail.com', '$2y$10$hYdkLQlP9CNjnzJ34AlDDu1QO9RbevdaNEIAEpu2m6m.gHAwtSerq', 'House', '099999999', 'buyer', 0, 'f9a61216e1a3c44dd601efc54ddb7233', '2026-07-11 15:11:05'),
(5, 'Jane Doe', 'janedoe1@gmail.com', '$2y$10$eVZUYKPrvsDCE64oiEeGhOiFR2a6hBxGZEHFpTIR/eKL7u.TDYIrS', 'House', '09497763572', 'buyer', 0, 'b9c7ae1477f7fba3998d3688b494ac4c', '2026-07-11 15:11:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
