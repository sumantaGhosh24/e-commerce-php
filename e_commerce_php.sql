-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 04:29 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `mobile`, `password`, `status`) VALUES
(1, 'test@admin', 'test@admin.com', '9999999999', '$2y$10$3kPUiSRM/ZlG/AEYFlpLaeYWrL8weldj7gSevO7xRLuPrTpVXisci', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `heading1` varchar(255) NOT NULL,
  `heading2` varchar(255) NOT NULL,
  `btn_txt` varchar(255) DEFAULT NULL,
  `btn_link` varchar(55) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `order_no` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `heading1`, `heading2`, `btn_txt`, `btn_link`, `image`, `order_no`, `status`, `createdAt`, `updatedAt`) VALUES
(2, 'test product 1 heading 1', 'test product 1 heading 2', 'view', 'http://localhost:3000', '66fea77761687.jpg', 1, 1, '2024-10-03 14:17:27', '2024-10-03 14:17:27'),
(3, 'test product 2 heading 1', 'test product 2 heading 2', 'view', 'http://localhost:3000', '66fea78fe4470.jpg', 2, 1, '2024-10-03 14:17:51', '2024-10-03 14:17:51'),
(4, 'test product 3 heading 1', 'test product 3 heading 2', 'view', 'http://localhost:3000', '66fea7a44a4d5.jpg', 3, 1, '2024-10-03 14:18:12', '2024-10-03 14:18:12'),
(5, 'test product 4 heading 1', 'test product 4 heading 2', 'view', 'http://localhost:3000', '66fea7c62043f.jpg', 4, 0, '2024-10-03 14:18:46', '2024-10-03 14:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `createdAt`, `updatedAt`) VALUES
(2, 'men', 1, '2024-10-03 15:21:18', '2024-10-03 15:21:18'),
(3, 'electronics', 1, '2024-10-03 15:21:24', '2024-10-03 15:21:24'),
(4, 'home', 0, '2024-10-03 15:21:28', '2024-10-03 15:21:51'),
(5, 'kitchen', 1, '2024-10-03 15:21:40', '2024-10-03 15:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color`, `status`, `createdAt`, `updatedAt`) VALUES
(2, 'red', 1, '2024-10-03 14:27:17', '2024-10-03 14:27:17'),
(3, 'green', 1, '2024-10-03 14:27:20', '2024-10-03 14:27:20'),
(4, 'blue', 1, '2024-10-03 14:27:23', '2024-10-03 14:27:23'),
(5, 'yellow', 1, '2024-10-03 14:27:26', '2024-10-03 14:27:26'),
(6, 'orange', 1, '2024-10-03 14:27:30', '2024-10-03 14:27:30'),
(7, 'black', 0, '2024-10-03 14:27:32', '2024-10-03 14:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(75) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile`, `message`, `createdAt`, `updatedAt`) VALUES
(1, 'test user', 'test@user.com', '7777777777', 'this is a test message with some dummy content is going here', '2024-10-03 14:51:32', '2024-10-03 14:51:32'),
(3, 'test user', 'test@user.com', '4444444444', 'this is a test message, with some dummy content is going here', '2024-10-08 13:58:37', '2024-10-08 13:58:37');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_value` int(11) NOT NULL,
  `coupon_type` varchar(10) NOT NULL,
  `cart_min_value` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `coupon_value`, `coupon_type`, `cart_min_value`, `status`, `createdAt`, `updatedAt`) VALUES
(2, 'welcome500', 500, 'Rupee', 5000, 1, '2024-10-03 15:12:18', '2024-10-03 15:12:18'),
(3, 'year24', 24, 'Percentage', 10000, 1, '2024-10-03 15:12:42', '2024-10-03 15:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `order_status` int(11) NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_value` varchar(50) DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `total_price` float NOT NULL,
  `net_price` int(11) NOT NULL,
  `paymentResultId` varchar(255) DEFAULT NULL,
  `paymentResultStatus` varchar(255) DEFAULT NULL,
  `paymentResultOrderId` varchar(255) DEFAULT NULL,
  `paymentResultPaymentId` varchar(255) DEFAULT NULL,
  `paymentResultRazorpaySignature` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `city`, `pincode`, `order_status`, `coupon_id`, `coupon_value`, `coupon_code`, `total_price`, `net_price`, `paymentResultId`, `paymentResultStatus`, `paymentResultOrderId`, `paymentResultPaymentId`, `paymentResultRazorpaySignature`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'abc road kolkata', 'kolkata', 222222, 3, NULL, NULL, NULL, 5500, 5500, 'order_P9CPKpWStYJSwJ', 'success', 'order_P9CPKpWStYJSwJ', 'pay_P9CPTA3gQLlwM6', 'a57d352253342a7e25c60a6c5e5b240d6525ce844f21d37771bc472fa502917d', '2024-10-15 05:31:38', '2024-10-15 14:18:59'),
(2, 1, 'abc road kolkata', 'kolkata', 222222, 5, 2, '500', 'welcome500', 5500, 5000, 'order_P9CSb6DKxqtUfL', 'success', 'order_P9CSb6DKxqtUfL', 'pay_P9CSj7roZiVLju', '6d3c9a69e67f7c23d99072cefb7efc2a3717326bf5d6e095d4567586173e7dcf', '2024-10-15 05:34:43', '2024-10-15 05:46:27'),
(3, 1, 'abc road kolkata', 'kolkata', 222222, 1, 3, '24', 'year24', 27000, 20520, 'order_P9D3dZIxQwUr8T', 'success', 'order_P9D3dZIxQwUr8T', 'pay_P9D3qBO3IjQjBe', 'a84ab89dcfdc4d818aecc471e72ebb177658d60efdeb69c3c5923ef39a11a563', '2024-10-15 06:09:51', '2024-10-15 06:09:51'),
(4, 1, 'abc road kolkata', 'kolkata', 222222, 1, NULL, NULL, NULL, 2000, 2000, 'order_P9LXJjNlazYayA', 'success', 'order_P9LXJjNlazYayA', 'pay_P9LXi4aFIu6oTN', '213eea170dc11debf5b0437351accac9c0cd516de4fb24e7c5ef5b9858adeb7e', '2024-10-15 14:27:41', '2024-10-15 14:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_attr_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `product_attr_id`, `qty`, `price`) VALUES
(1, 1, 4, 5, 1, 750),
(2, 1, 4, 6, 3, 2250),
(3, 1, 3, 3, 3, 1500),
(4, 1, 3, 4, 2, 1000),
(5, 2, 4, 5, 1, 750),
(6, 2, 4, 6, 3, 2250),
(7, 2, 3, 3, 3, 1500),
(8, 2, 3, 4, 2, 1000),
(9, 3, 3, 3, 2, 1000),
(10, 3, 8, 11, 1, 1000),
(11, 3, 6, 9, 1, 25000),
(12, 4, 4, 5, 1, 750),
(13, 4, 4, 6, 1, 750),
(14, 4, 3, 3, 1, 500);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(4, 'Canceled'),
(5, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mrp` float NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `short_desc` varchar(2000) NOT NULL,
  `description` text NOT NULL,
  `best_seller` int(11) NOT NULL,
  `meta_title` varchar(2000) NOT NULL,
  `meta_desc` varchar(2000) NOT NULL,
  `meta_keyword` varchar(2000) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `categories_id`, `sub_categories_id`, `title`, `mrp`, `price`, `qty`, `short_desc`, `description`, `best_seller`, `meta_title`, `meta_desc`, `meta_keyword`, `status`, `createdAt`, `updatedAt`) VALUES
(3, 2, 2, 'men shirt title', 750, 500, 25, 'men shirt short description', 'men shirt description', 0, 'men shirt meta title', 'men shirt meta description', 'men, shirt', 1, '2024-10-05 06:05:27', '2024-10-13 13:47:37'),
(4, 2, 3, 'men hat title', 1000, 750, 50, 'men hat short description', 'men hat description', 0, 'men hat meta title', 'men hat meta description', 'men, hat', 1, '2024-10-05 06:06:23', '2024-10-13 13:47:50'),
(5, 3, 4, 'electronics mobile title', 12000, 10000, 10, 'electronics mobile short description', 'electronics mobile description', 1, 'electronics mobile meta title', 'electronics mobile meta description', 'electronics, mobile', 1, '2024-10-05 06:07:57', '2024-10-13 13:48:05'),
(6, 3, 5, 'electronics laptop title', 30000, 25000, 5, 'electronics laptop short description', 'electronics laptop description', 1, 'electronics laptop meta title', 'electronics laptop meta description', 'electronics, laptop', 1, '2024-10-05 06:08:58', '2024-10-13 13:48:16'),
(7, 5, 6, 'kitchen induction title', 6000, 5000, 20, 'kitchen induction short description', 'kitchen induction description', 0, 'kitchen induction meta title', 'kitchen induction meta description', 'kitchen, induction', 1, '2024-10-05 06:10:04', '2024-10-13 13:48:27'),
(8, 5, 7, 'kitchen oven title', 1200, 1000, 25, 'kitchen oven short description', 'kitchen oven description', 1, 'kitchen oven meta title', 'kitchen oven meta description', 'kitchen oven meta keyword', 1, '2024-10-05 06:10:54', '2024-10-13 13:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `mrp` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `size_id`, `color_id`, `mrp`, `price`, `qty`) VALUES
(3, 3, 1, 3, 750, 500, 5),
(4, 3, 2, 4, 750, 500, 20),
(5, 4, 3, 2, 1000, 750, 25),
(6, 4, 1, 6, 1000, 750, 25),
(7, 5, 1, 3, 12000, 10000, 5),
(8, 5, 1, 2, 12000, 10000, 5),
(9, 6, 1, 4, 30000, 25000, 5),
(10, 7, 2, 4, 6000, 5000, 20),
(11, 8, 3, 4, 1200, 1000, 25);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`) VALUES
(4, 3, '6700d727bdb8a.jpg'),
(5, 4, '6700d75fe9e6d.png'),
(6, 5, '6700d7bdca6c7.jpg'),
(7, 6, '6700d7fad4450.jpg'),
(8, 7, '6700d83ceed1c.jpg'),
(9, 8, '6700d86df3caf.jpg'),
(10, 3, '6701435ec84f5.jpg'),
(11, 3, '6701436dcd6c2.png'),
(12, 4, '67014414a78fd.jpg'),
(13, 4, '67014417940e4.jpg'),
(14, 5, '6701443aac9b1.jpg'),
(15, 6, '67014469c55c8.jpg'),
(16, 6, '6701446db3b3f.jpg'),
(17, 7, '670144967b254.jpg'),
(18, 7, '670144997ed36.png'),
(19, 8, '670144c567c3a.png'),
(20, 8, '670144c9da549.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` varchar(20) NOT NULL,
  `review` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `review`, `createdAt`, `updatedAt`) VALUES
(2, 4, 1, '4', 'this is a nice product', '2024-10-05 13:55:18', '2024-10-05 13:55:18'),
(3, 5, 1, '3', 'test', '2024-10-10 06:15:11', '2024-10-10 06:15:11'),
(4, 5, 1, '5', 'test updated', '2024-10-10 06:15:47', '2024-10-10 06:15:47'),
(5, 5, 1, '4', 'final test', '2024-10-10 06:18:42', '2024-10-10 06:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `order_by` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `status`, `order_by`, `createdAt`, `updatedAt`) VALUES
(1, 'X', 1, 3, '2024-10-03 14:31:39', '2024-10-03 14:31:39'),
(2, 'XL', 1, 4, '2024-10-03 14:31:39', '2024-10-03 14:31:39'),
(3, 'M', 1, 2, '2024-10-03 14:31:39', '2024-10-03 14:31:39'),
(4, 'S', 1, 1, '2024-10-03 14:31:39', '2024-10-03 14:31:39'),
(5, 'XXL', 1, 5, '2024-10-03 14:31:39', '2024-10-03 14:31:39'),
(7, 'XXXL', 0, 6, '2024-10-03 14:40:52', '2024-10-03 14:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `categories_id`, `sub_categories`, `status`, `createdAt`, `updatedAt`) VALUES
(2, 2, 'shirt', 1, '2024-10-04 13:57:08', '2024-10-04 13:57:08'),
(3, 2, 'hat', 1, '2024-10-04 13:57:20', '2024-10-04 13:57:20'),
(4, 3, 'mobile', 1, '2024-10-04 13:57:25', '2024-10-04 13:57:25'),
(5, 3, 'laptop', 1, '2024-10-04 13:57:32', '2024-10-04 13:57:32'),
(6, 5, 'induction', 1, '2024-10-04 13:57:48', '2024-10-04 13:57:48'),
(7, 5, 'oven', 1, '2024-10-04 13:58:02', '2024-10-04 13:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `mobile`, `createdAt`, `updatedAt`) VALUES
(1, 'test user', '$2y$10$ZTdKdqAIpdS0/ngLDRZZOupjgGeJu9wkZ4PPNtAo0pC4CODmJWQam', 'test@user.com', '4444444444', '2024-10-07 14:51:00', '2024-10-08 13:39:59'),
(2, 'sumanta ghosh', '$2y$10$AzQn9XBb/0/7KnwznDA7seK4g.S5ZAGLZ5wtUlVcOsXGjjjrUoCAq', 'sumanta@ghosh.com', '5555555555', '2024-10-07 14:51:21', '2024-10-07 14:51:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
