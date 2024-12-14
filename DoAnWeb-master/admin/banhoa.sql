-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2024 at 08:58 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banhoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `bosuutap`
--

DROP TABLE IF EXISTS `bosuutap`;
CREATE TABLE IF NOT EXISTS `bosuutap` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_bo_suu_tap` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bosuutap`
--

INSERT INTO `bosuutap` (`id`, `ten_bo_suu_tap`) VALUES
(1, 'Hoa mùa hè'),
(2, 'Hoa đặc biệt'),
(3, 'Bộ Sưu Tập Mùa Đông'),
(4, 'Bộ Sưu Tập Cổ Điển'),
(5, 'Bộ Sưu Tập Đặc Biệt'),
(6, 'Bộ Sưu Tập Cảm Hứng'),
(7, 'Bộ Sưu Tập Tình Bạn'),
(8, 'Bộ Sưu Tập Hoa Tết');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

DROP TABLE IF EXISTS `cart_details`;
CREATE TABLE IF NOT EXISTS `cart_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chude`
--

DROP TABLE IF EXISTS `chude`;
CREATE TABLE IF NOT EXISTS `chude` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_chu_de` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chude`
--

INSERT INTO `chude` (`id`, `ten_chu_de`) VALUES
(1, 'Sinh nhật'),
(2, 'Khai trương'),
(3, 'Tình yêu'),
(4, 'Chúc Mừng'),
(5, 'Kỷ Niệm'),
(6, 'Tiệc Cưới'),
(7, 'Tết Nguyên Đán'),
(8, 'Lễ Phục Sinh'),
(9, 'Đặc Biệt');

-- --------------------------------------------------------

--
-- Table structure for table `doituong`
--

DROP TABLE IF EXISTS `doituong`;
CREATE TABLE IF NOT EXISTS `doituong` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_doi_tuong` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doituong`
--

INSERT INTO `doituong` (`id`, `ten_doi_tuong`) VALUES
(1, 'Học sinh'),
(2, 'Người yêu'),
(3, 'Bạn bè'),
(4, 'Bạn Cũ'),
(5, 'Cha Mẹ'),
(6, 'Anh Chị Em'),
(7, 'Thầy Cô'),
(8, 'Sếp'),
(9, 'Đối Tác');

-- --------------------------------------------------------

--
-- Table structure for table `kieudang`
--

DROP TABLE IF EXISTS `kieudang`;
CREATE TABLE IF NOT EXISTS `kieudang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_kieu_dang` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kieudang`
--

INSERT INTO `kieudang` (`id`, `ten_kieu_dang`) VALUES
(1, 'Tròn'),
(2, 'Thẳng'),
(3, 'Lộng lẫy'),
(4, 'Hoa Xếp Lớn'),
(5, 'Hoa Trang Trí'),
(6, 'Hoa Chậu Nhỏ'),
(7, 'Hoa Nổi'),
(8, 'Hoa Nổi Mọi Phía'),
(9, 'Hoa Kiểu Cổ Điển');

-- --------------------------------------------------------

--
-- Table structure for table `mausac`
--

DROP TABLE IF EXISTS `mausac`;
CREATE TABLE IF NOT EXISTS `mausac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_mau_sac` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mausac`
--

INSERT INTO `mausac` (`id`, `ten_mau_sac`) VALUES
(1, 'Đỏ'),
(2, 'Vàng'),
(3, 'Trắng'),
(4, 'Tím'),
(5, 'Hồng Phấn'),
(6, 'Xanh Dương'),
(7, 'Xanh Lá'),
(8, 'Vàng Nhạt'),
(9, 'Đen');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten_san_pham` varchar(255) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `mo_ta` text,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `danh_gia` decimal(3,2) DEFAULT NULL,
  `chu_de_id` int DEFAULT NULL,
  `doi_tuong_id` int DEFAULT NULL,
  `kieu_dang_id` int DEFAULT NULL,
  `mau_sac_id` int DEFAULT NULL,
  `bo_suu_tap_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chu_de_id` (`chu_de_id`),
  KEY `doi_tuong_id` (`doi_tuong_id`),
  KEY `kieu_dang_id` (`kieu_dang_id`),
  KEY `mau_sac_id` (`mau_sac_id`),
  KEY `bo_suu_tap_id` (`bo_suu_tap_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `ten_san_pham`, `gia`, `mo_ta`, `hinh_anh`, `danh_gia`, `chu_de_id`, `doi_tuong_id`, `kieu_dang_id`, `mau_sac_id`, `bo_suu_tap_id`) VALUES
(1, 'Hoa Sinh Nhật Đỏ', 250000.00, 'Bó hoa sinh nhật tươi đẹp với hoa hồng đỏ.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.50, 1, 1, 1, 1, 1),
(2, 'Hoa Khai Trương Vàng', 300000.00, 'Bó hoa khai trương với hoa hướng dương vàng rực rỡ.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.70, 2, 2, 2, 2, 1),
(3, 'Hoa Tình Yêu Hồng', 350000.00, 'Bó hoa tình yêu với những bông hoa hồng hồng lãng mạn.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.80, 3, 3, 3, 3, 2),
(4, 'Hoa Cảm Ơn Trắng', 200000.00, 'Hoa cảm ơn với hoa cúc trắng thanh khiết.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.60, 1, 3, 1, 4, 1),
(5, 'Hoa Sinh Nhật Màu Hồng', 270000.00, 'Bó hoa sinh nhật tươi mới với hoa hồng hồng và cẩm chướng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.30, 1, 1, 2, 1, 2),
(6, 'Hoa Mừng Tốt Nghiệp Đỏ', 400000.00, 'Bó hoa mừng tốt nghiệp với hoa hồng đỏ và lan.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.90, 2, 2, 3, 2, 3),
(7, 'Hoa Chúc Mừng Tươi', 320000.00, 'Bó hoa chúc mừng với các loài hoa tươi sáng và vui tươi.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.40, 2, 1, 1, 3, 1),
(8, 'Hoa Đám Cưới Trắng', 500000.00, 'Bó hoa đám cưới sang trọng với hoa lily trắng và lan.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 5.00, 3, 3, 4, 4, 3),
(9, 'Hoa Tặng Bạn Bè Màu Cam', 280000.00, 'Hoa tặng bạn bè với hoa hồng cam và hoa lan.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.20, 1, 4, 1, 2, 2),
(10, 'Hoa Lễ Tết Màu Đỏ', 450000.00, 'Hoa tết với hoa mai đỏ tươi, mang lại không khí xuân vui tươi.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.50, 3, 1, 2, 1, 1),
(11, 'Hoa Bất Ngờ Vàng', 330000.00, 'Bó hoa bất ngờ với hoa lily vàng, tạo cảm giác bất ngờ và vui mừng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.60, 1, 2, 3, 3, 4),
(12, 'Hoa Chúc Mừng Vàng', 300000.00, 'Bó hoa chúc mừng tuyệt đẹp với hoa hồng vàng và cúc vàng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.80, 1, 1, 1, 3, 2),
(13, 'Hoa Cảm Ơn Hồng', 200000.00, 'Bó hoa cảm ơn tươi đẹp với hoa hồng và hoa lan.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.60, 2, 2, 3, 2, 3),
(14, 'Hoa Tết Đỏ', 350000.00, 'Bó hoa Tết với hoa hồng đỏ và cúc đỏ, tượng trưng cho may mắn và phú quý.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.90, 4, 3, 4, 1, 6),
(15, 'Hoa Sinh Nhật Màu Tím', 270000.00, 'Hoa sinh nhật tươi đẹp với hoa hồng tím và hoa lan tím.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.70, 1, 1, 2, 4, 2),
(16, 'Hoa Cưới Trắng', 500000.00, 'Bó hoa cưới với hoa hồng trắng tinh khôi, sang trọng và thanh lịch.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 5.00, 3, 2, 5, 2, 5),
(17, 'Hoa Lễ Phục Sinh Màu Hồng', 450000.00, 'Hoa phục sinh với hoa hồng hồng, mẫu đơn và hoa cúc.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.70, 4, 4, 3, 1, 4),
(18, 'Hoa Đặc Biệt Đỏ', 300000.00, 'Bó hoa đặc biệt với hoa lan đỏ và hoa hồng đỏ tươi sáng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.80, 6, 5, 1, 5, 6),
(19, 'Hoa Tình Yêu Đỏ', 220000.00, 'Bó hoa tình yêu tuyệt đẹp với hoa hồng đỏ và hoa cẩm chướng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.60, 2, 1, 1, 2, 3),
(20, 'Hoa Tiệc Cưới Trắng', 550000.00, 'Bó hoa tiệc cưới với hoa hồng trắng và hoa lily trắng.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.90, 3, 2, 5, 3, 5),
(21, 'Hoa Ngày Sinh Nhật Hồng Phấn', 290000.00, 'Hoa sinh nhật với hoa hồng phấn và hoa cúc, tạo cảm giác nhẹ nhàng và dễ chịu.', 'https://hoayeuthuong.com/hinh-hoa-tuoi/hoa-khuyen-mai/14339_say-you-do.jpg', 4.70, 1, 3, 2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, '123', '123', NULL, '2024-12-12 06:44:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
