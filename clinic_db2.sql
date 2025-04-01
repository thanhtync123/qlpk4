-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 11:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic_db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `name`) VALUES
(1, 'Chẩn đoán 1'),
(2, 'Chẩn đoán 2'),
(3, 'Chẩn đoán 3'),
(4, 'Chẩn đoán 4'),
(5, 'Chẩn đoán 5');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notes`
--

CREATE TABLE `doctor_notes` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_notes`
--

INSERT INTO `doctor_notes` (`id`, `content`) VALUES
(1, 'Lời dặn 1'),
(2, 'Lời dặn 2'),
(3, 'Lời dặn 3'),
(4, 'Lời dặn 4'),
(5, 'Lời dặn 5');

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `symptoms` varchar(100) NOT NULL,
  `diagnosis_id` int(11) NOT NULL,
  `doctor_note_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinations`
--

INSERT INTO `examinations` (`id`, `patient_id`, `reason`, `symptoms`, `diagnosis_id`, `doctor_note_id`, `created_at`, `updated_at`) VALUES
(78, 3, 'Lý do nè', 'Triệu chứng nè', 1, 1, '2025-03-26 03:03:48', '2025-03-26 03:03:48'),
(81, 1, 'Lý do nè', 'Triệu chứng nè', 1, 1, '2025-03-26 03:11:08', '2025-03-26 03:11:08'),
(83, 2, 'ld1', 'tc1', 2, 4, '2025-03-26 03:12:52', '2025-03-26 03:12:52'),
(84, 2, '213123', '123123123123231', 1, 1, '2025-03-26 03:16:37', '2025-03-26 03:16:37'),
(85, 2, '213123', '123123123123231', 1, 1, '2025-03-26 03:16:49', '2025-03-26 03:16:49'),
(86, 4, '123', '213', 1, 1, '2025-03-26 03:20:54', '2025-03-26 03:20:54'),
(88, 2, 'ldo nè', 'tc nè', 1, 1, '2025-03-26 03:27:29', '2025-03-26 03:27:29'),
(89, 2, 'Chào', 'Triệu chứng', 1, 1, '2025-03-26 03:30:35', '2025-03-26 03:30:35'),
(91, 1, 'web nhà', 'làm', 4, 5, '2025-03-26 03:34:09', '2025-03-26 03:34:09'),
(92, 2, 'web nhà làm', 'tới chơi bro', 1, 1, '2025-03-26 03:35:29', '2025-03-26 03:35:29'),
(93, 1, 'long mộng gà', 'tới chơi', 1, 1, '2025-03-26 03:36:19', '2025-03-26 03:36:19'),
(94, 4, '123123', '123213', 1, 1, '2025-03-26 03:37:13', '2025-03-26 03:37:13'),
(95, 4, 'Long mộng gà', 'tới chơi bro', 5, 5, '2025-03-26 03:40:58', '2025-03-26 03:40:58'),
(96, 1, 'đc', 'đc', 1, 1, '2025-03-26 03:44:07', '2025-03-26 03:44:07'),
(97, 1, 'đc', 'đc', 1, 1, '2025-03-26 03:44:55', '2025-03-26 03:44:55'),
(98, 1, 'đc', 'đc', 1, 1, '2025-03-26 03:46:29', '2025-03-26 03:46:29'),
(99, 1, '123123', '123123123', 1, 1, '2025-03-26 03:46:55', '2025-03-26 03:46:55'),
(102, 3, 'Test lưu thuốc', 'Test lưu thuốc', 1, 1, '2025-03-26 04:33:56', '2025-03-26 04:33:56'),
(103, 1, 'test tới chơi', 'test tới chơi', 1, 1, '2025-03-26 04:35:09', '2025-03-26 04:35:09'),
(104, 2, '123123123123', '123123123123123123', 1, 1, '2025-03-26 04:35:59', '2025-03-26 04:35:59'),
(105, 2, 'Test', 'Test', 1, 1, '2025-03-26 04:53:18', '2025-03-26 04:53:18'),
(106, 2, 'Lưu thông tin', 'tới chơi bro', 1, 1, '2025-03-26 04:55:48', '2025-03-26 04:55:48'),
(110, 2, 'sdj', 'JSSDGK', 4, 3, '2025-03-28 05:11:23', '2025-03-28 05:11:23'),
(114, 2, 'lý do khám nè', 'sdgojio', 1, 1, '2025-03-28 05:20:42', '2025-03-28 05:20:42'),
(115, 1, 'Rapital tới chơi bro', 'Rapital tới chơi bro', 3, 3, '2025-03-28 05:24:50', '2025-03-28 05:24:50'),
(116, 1, '21312', '3123', 1, 1, '2025-03-28 06:25:48', '2025-03-28 06:25:48'),
(117, 4, '123123', '123123', 1, 1, '2025-03-28 06:26:53', '2025-03-28 06:26:53'),
(118, 2, '123', '123123', 1, 1, '2025-03-30 02:05:02', '2025-03-30 02:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `examination_medications`
--

CREATE TABLE `examination_medications` (
  `id` bigint(20) NOT NULL,
  `examination_id` bigint(20) NOT NULL,
  `medication_id` bigint(20) DEFAULT NULL,
  `unit` varchar(10) NOT NULL,
  `dosage` varchar(10) NOT NULL,
  `route` varchar(10) NOT NULL,
  `times` varchar(10) NOT NULL,
  `note` varchar(10) DEFAULT NULL,
  `price` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination_medications`
--

INSERT INTO `examination_medications` (`id`, `examination_id`, `medication_id`, `unit`, `dosage`, `route`, `times`, `note`, `price`, `created_at`, `updated_at`) VALUES
(48, 105, 1, 'Viên', '1', 'Uống', '1', NULL, '10000', '2025-03-26 04:53:18', '2025-03-26 04:53:18'),
(49, 105, 2, 'Viên', '1', 'Uống', '1', NULL, '20000', '2025-03-26 04:53:18', '2025-03-26 04:53:18'),
(50, 105, 3, 'Gói', '1', 'Uống', '1', NULL, '40000', '2025-03-26 04:53:18', '2025-03-26 04:53:18'),
(51, 114, 2, 'Viên', '1', 'Uống', '1', NULL, '20000', '2025-03-28 05:20:42', '2025-03-28 05:20:42'),
(52, 115, 1, 'Viên', '1', 'Uống', '1', 'sau ăn', '10000', '2025-03-28 05:24:50', '2025-03-28 05:24:50'),
(53, 115, 2, 'Viên', '1', 'Uống', '1', 'trước ăn', '20000', '2025-03-28 05:24:50', '2025-03-28 05:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `examination_results`
--

CREATE TABLE `examination_results` (
  `id` bigint(20) NOT NULL,
  `examination_service_id` bigint(20) NOT NULL,
  `template_id` bigint(20) DEFAULT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`result`)),
  `final_result` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination_results`
--

INSERT INTO `examination_results` (`id`, `examination_service_id`, `template_id`, `result`, `final_result`, `file_path`, `created_at`, `updated_at`) VALUES
(20, 177, NULL, '{\"glucose\": \"5.4 mmol/L\", \"hemoglobin\": \"13.5 g/dL\", \"bilan_mo\": \"Bình thường\"}', '123123234', 'CFdFBM2Pie.png,nvSAyATN2Z.png', '2025-03-29 21:09:45', '2025-03-29 21:09:45'),
(21, 177, 10, '{\"ef\": \"60%\", \"van_tim\": \"Bình thường\", \"ket_luan\": \"Không có dấu hiệu bất thường\"}', '2344643', 'iNapzfZILp.png,SyjxmFnJf9.png,m3ZOnOUVog.png,xIUKkNPmq2.png', '2025-03-29 21:11:01', '2025-03-29 21:11:01'),
(22, 174, 10, '{\"ef\": \"60%\", \"van_tim\": \"Bình thường\", \"ket_luan\": \"Không có dấu hiệu bất thường\"}', '12312312', '', '2025-03-29 21:13:28', '2025-03-30 04:48:26'),
(23, 177, 10, '{\"ef\": \"60%\", \"van_tim\": \"Bình thường\", \"ket_luan\": \"Không có dấu hiệu bất thường\"}', '123123', '', '2025-03-29 21:49:52', '2025-03-29 21:49:52'),
(24, 174, NULL, '{\"glucose\": \"5.4 mmol/L\", \"hemoglobin\": \"13.5 g/dL\", \"bilan_mo\": \"Bình thường\"}', NULL, NULL, '2025-03-29 23:39:36', '2025-03-29 23:39:36'),
(25, 176, 15, '{\r\n  \"category\": [\r\n    \"Bạch cầu\",\r\n    \"Tiểu cầu\",\r\n    \"Hồng cầu\",\r\n    \"Hemoglobin\"\r\n  ],\r\n  \"tests\": [\r\n    {\r\n      \"name\": \"Xét nghiệm máu\",\r\n      \"results\": [\r\n        {\r\n          \"name\": \"Glucose\",\r\n          \"value\": \"5.2123\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"3.9 - 6.1\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Cholesterol\",\r\n          \"value\": \"4.8123\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"3.0 - 5.2\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Triglyceride\",\r\n          \"value\": \"1.5123\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"0.5 - 1.7\",\r\n          \"note\": \"Bình thường\"\r\n        }\r\n      ]\r\n    },\r\n    {\r\n      \"name\": \"Xét nghiệm tế bào\",\r\n      \"results\": [\r\n        {\r\n          \"name\": \"Bạch cầu\",\r\n          \"value\": \"7.5123\",\r\n          \"unit\": \"G/L\",\r\n          \"range\": \"4.0 - 10.0\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Tiểu cầu\",\r\n          \"value\": \"250123\",\r\n          \"unit\": \"G/L\",\r\n          \"range\": \"150 - 400\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Hồng cầu\",\r\n          \"value\": \"4.7123123\",\r\n          \"unit\": \"T/L\",\r\n          \"range\": \"4.2 - 5.9\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Hemoglobin\",\r\n          \"value\": \"140\",\r\n          \"unit\": \"g/L\",\r\n          \"range\": \"120 - 160\",\r\n          \"note\": \"Bình thường\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}', NULL, NULL, '2025-03-30 02:03:21', '2025-03-30 02:03:21'),
(26, 176, 15, '{\r\n  \"category\": [\r\n    \"Bạch cầu\",\r\n    \"Tiểu cầu\",\r\n    \"Hồng cầu\",\r\n    \"Hemoglobin\"\r\n  ],\r\n  \"tests\": [\r\n    {\r\n      \"name\": \"Xét nghiệm máu\",\r\n      \"results\": [\r\n        {\r\n          \"name\": \"Glucose\",\r\n          \"value\": \"5.2213\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"3.9 - 6.1\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Cholesterol\",\r\n          \"value\": \"4.8\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"3.0 - 5.2\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Triglyceride\",\r\n          \"value\": \"1.5\",\r\n          \"unit\": \"mmol/L\",\r\n          \"range\": \"0.5 - 1.7\",\r\n          \"note\": \"Bình thường\"\r\n        }\r\n      ]\r\n    },\r\n    {\r\n      \"name\": \"Xét nghiệm tế bào\",\r\n      \"results\": [\r\n        {\r\n          \"name\": \"Bạch cầu\",\r\n          \"value\": \"7.5\",\r\n          \"unit\": \"G/L\",\r\n          \"range\": \"4.0 - 10.0\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Tiểu cầu\",\r\n          \"value\": \"250\",\r\n          \"unit\": \"G/L\",\r\n          \"range\": \"150 - 400\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Hồng cầu\",\r\n          \"value\": \"4.7\",\r\n          \"unit\": \"T/L\",\r\n          \"range\": \"4.2 - 5.9\",\r\n          \"note\": \"Bình thường\"\r\n        },\r\n        {\r\n          \"name\": \"Hemoglobin\",\r\n          \"value\": \"140\",\r\n          \"unit\": \"g/L\",\r\n          \"range\": \"120 - 160\",\r\n          \"note\": \"Bình thường\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}', NULL, NULL, '2025-04-01 08:45:57', '2025-04-01 08:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `examination_services`
--

CREATE TABLE `examination_services` (
  `id` bigint(20) NOT NULL,
  `examination_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination_services`
--

INSERT INTO `examination_services` (`id`, `examination_id`, `service_id`, `price`, `created_at`, `updated_at`) VALUES
(173, 106, 2, 300000, '2025-03-26 04:55:48', '2025-03-26 04:55:48'),
(174, 110, 1, 500000, '2025-03-28 05:11:23', '2025-03-28 05:11:23'),
(175, 110, 23, 150000, '2025-03-28 05:11:23', '2025-03-28 05:11:23'),
(176, 116, 1, 500000, '2025-03-28 06:25:48', '2025-03-28 06:25:48'),
(177, 117, 5, 2000000, '2025-03-28 06:26:53', '2025-03-28 06:26:53'),
(178, 118, 1, 500000, '2025-03-30 02:05:02', '2025-03-30 02:05:02');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `times_per_day` int(11) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `price` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`id`, `name`, `unit`, `dosage`, `route`, `times_per_day`, `note`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol', 'Viên', '1', 'Uống', 1, '', 10000, '2025-03-18 13:36:53', '2025-03-26 09:35:18'),
(2, 'Amoxicillin', 'Viên', '1', 'Uống', 1, NULL, 20000, '2025-03-18 13:36:53', '2025-03-26 09:35:24'),
(3, 'Vitamin C', 'Gói', '1', 'Uống', 1, NULL, 40000, '2025-03-18 13:36:53', '2025-03-26 09:35:36'),
(4, 'Ibuprofen', 'Viên', '1', 'Uống', 1, NULL, 50000, '2025-03-18 13:36:53', '2025-03-26 09:35:45'),
(5, 'Daki', 'Gói', '2', 'uống', 1, NULL, 14000, '2025-03-19 20:08:16', '2025-03-30 02:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `date_of_birth`, `gender`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', '1990-05-12', 'Nam', '0987654321', 'Hà Nội', '2025-03-18 13:36:44', '2025-03-18 13:36:44'),
(2, 'Trần Thị B', '1985-08-20', 'Nữ', '0912345678', 'TP. Hồ Chí Minh', '2025-03-18 13:36:44', '2025-03-18 13:36:44'),
(3, 'Lê Văn C', '2000-01-15', 'Nam', '0978123456', 'Đà Nẵng', '2025-03-18 13:36:44', '2025-03-18 13:36:44'),
(4, 'Lương Ngọc Hân', '2025-03-19', 'Nữ', '0912111222', 'TP. Hồ Chí Minh', '2025-03-19 08:52:48', '2025-03-19 08:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('X-quang','Điện tim','Xét nghiệm','Siêu âm') NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `price` int(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `type`, `content`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Chụp X-quang phổi', 'X-quang', 'Kiểm tra hình ảnh phổi', 500000, '2025-03-18 13:36:49', '2025-03-18 13:36:49'),
(2, 'Điện tim ECG', 'Điện tim', 'Kiểm tra hoạt động tim', 300000, '2025-03-18 13:36:49', '2025-03-18 13:36:49'),
(3, 'Xét nghiệm máu', 'Xét nghiệm', 'Kiểm tra công thức máu', 200000, '2025-03-18 13:36:49', '2025-03-18 13:36:49'),
(4, 'Siêu âm ổ bụng', 'Siêu âm', 'Siêu âm kiểm tra nội tạng', 400000, '2025-03-18 13:36:49', '2025-03-18 13:36:49'),
(5, 'Chụp X-quang xương sườn', 'X-quang', NULL, 2000000, '2025-03-18 07:11:16', '2025-03-19 03:20:52'),
(6, 'Chụp X-quang tay', 'X-quang', NULL, 2000000, '2025-03-18 07:11:31', '2025-03-19 03:21:00'),
(17, 'X-quang', 'X-quang', 'Mô tả dịch vụ X-quang', 100000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(18, 'Điện tim', 'Điện tim', 'Mô tả dịch vụ điện tim', 150000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(19, 'Siêu âm bụng', 'Siêu âm', 'Siêu âm kiểm tra bụng', 120000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(20, 'Xét nghiệm máu tổng quát', 'Xét nghiệm', 'Xét nghiệm máu để kiểm tra sức khỏe', 70000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(21, 'X-quang phổi', 'X-quang', 'X-quang kiểm tra phổi', 110000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(22, 'Điện tim 24h', 'Điện tim', 'Theo dõi điện tim trong 24 giờ', 180000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(23, 'Siêu âm tim', 'Siêu âm', 'Siêu âm tim để kiểm tra chức năng tim', 150000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(24, 'Xét nghiệm nước tiểu', 'Xét nghiệm', 'Xét nghiệm nước tiểu để kiểm tra sức khỏe', 60000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(25, 'X-quang cột sống', 'X-quang', 'X-quang kiểm tra cột sống', 130000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(26, 'Điện tim stress', 'Điện tim', 'Điện tim kiểm tra khi gắng sức', 200000, '2025-03-19 10:41:26', '2025-03-19 10:41:26'),
(28, '1231', 'Điện tim', '123', 23123, '2025-03-30 02:11:31', '2025-03-30 02:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `template_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `template_content`, `created_at`, `updated_at`) VALUES
(8, 'Biểu mẫu X-quang', '{\"chuan_doan\": \"Viêm phổi\", \"mo_ta_hinh_anh\": \"Hình ảnh mờ vùng phổi\", \"de_xuat\": \"Tái khám sau 1 tuần\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(10, 'Biểu mẫu Siêu âm tim', '{\"ef\": \"60%\", \"van_tim\": \"Bình thường\", \"ket_luan\": \"Không có dấu hiệu bất thường\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(11, 'Biểu mẫu MRI não', '{\"mo_ta\": \"Không có tổn thương đáng kể\", \"ket_luan\": \"Bình thường\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(12, 'Biểu mẫu Xét nghiệm nước tiểu', '{\"protein\": \"Âm tính\", \"glucose\": \"Âm tính\", \"bạch_cầu\": \"Dương tính nhẹ\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(13, 'Biểu mẫu Nội soi dạ dày', '{\"ket_qua\": \"Viêm dạ dày nhẹ\", \"hp_test\": \"Âm tính\", \"de_xuat\": \"Sử dụng thuốc giảm acid\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(14, 'Biểu mẫu Siêu âm gan', '{\"mo_ta\": \"Gan có kích thước bình thường\", \"ket_luan\": \"Không có dấu hiệu xơ gan\"}', '2025-03-28 13:58:34', '2025-03-28 13:58:34'),
(15, 'Biểu mẫu Xét nghiệm máu', '{\n  \"category\": [\"Bạch cầu\", \"Tiểu cầu\", \"Hồng cầu\", \"Hemoglobin\"],\n  \"tests\": [\n    {\n      \"name\": \"Xét nghiệm máu\",\n      \"results\": [\n        {\"name\": \"Glucose\", \"value\": \"5.2\", \"unit\": \"mmol/L\", \"range\": \"3.9 - 6.1\", \"note\": \"Bình thường\"},\n        {\"name\": \"Cholesterol\", \"value\": \"4.8\", \"unit\": \"mmol/L\", \"range\": \"3.0 - 5.2\", \"note\": \"Bình thường\"},\n        {\"name\": \"Triglyceride\", \"value\": \"1.5\", \"unit\": \"mmol/L\", \"range\": \"0.5 - 1.7\", \"note\": \"Bình thường\"}\n      ]\n    },\n    {\n      \"name\": \"Xét nghiệm tế bào\",\n      \"results\": [\n        {\"name\": \"Bạch cầu\", \"value\": \"7.5\", \"unit\": \"G/L\", \"range\": \"4.0 - 10.0\", \"note\": \"Bình thường\"},\n        {\"name\": \"Tiểu cầu\", \"value\": \"250\", \"unit\": \"G/L\", \"range\": \"150 - 400\", \"note\": \"Bình thường\"},\n        {\"name\": \"Hồng cầu\", \"value\": \"4.7\", \"unit\": \"T/L\", \"range\": \"4.2 - 5.9\", \"note\": \"Bình thường\"},\n        {\"name\": \"Hemoglobin\", \"value\": \"140\", \"unit\": \"g/L\", \"range\": \"120 - 160\", \"note\": \"Bình thường\"}\n      ]\n    }\n  ]\n}\n', '2025-03-30 07:00:14', '2025-03-30 08:26:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `examinations_ibfk_2` (`diagnosis_id`),
  ADD KEY `examinations_ibfk_3` (`doctor_note_id`);

--
-- Indexes for table `examination_medications`
--
ALTER TABLE `examination_medications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examination_id` (`examination_id`),
  ADD KEY `medication_id` (`medication_id`);

--
-- Indexes for table `examination_results`
--
ALTER TABLE `examination_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examination_service_id` (`examination_service_id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `examination_services`
--
ALTER TABLE `examination_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examination_id` (`examination_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_service_name` (`name`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `examination_medications`
--
ALTER TABLE `examination_medications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `examination_results`
--
ALTER TABLE `examination_results`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `examination_services`
--
ALTER TABLE `examination_services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `examinations`
--
ALTER TABLE `examinations`
  ADD CONSTRAINT `examinations_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examinations_ibfk_2` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examinations_ibfk_3` FOREIGN KEY (`doctor_note_id`) REFERENCES `doctor_notes` (`id`);

--
-- Constraints for table `examination_medications`
--
ALTER TABLE `examination_medications`
  ADD CONSTRAINT `examination_medications_ibfk_1` FOREIGN KEY (`examination_id`) REFERENCES `examinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examination_medications_ibfk_2` FOREIGN KEY (`medication_id`) REFERENCES `medications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `examination_results`
--
ALTER TABLE `examination_results`
  ADD CONSTRAINT `examination_results_ibfk_1` FOREIGN KEY (`examination_service_id`) REFERENCES `examination_services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examination_results_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `examination_services`
--
ALTER TABLE `examination_services`
  ADD CONSTRAINT `examination_services_ibfk_1` FOREIGN KEY (`examination_id`) REFERENCES `examinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `examination_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
