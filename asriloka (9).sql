-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 06:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asriloka`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `checkIn` datetime(3) NOT NULL,
  `checkOut` datetime(3) NOT NULL,
  `roomId` int(11) DEFAULT NULL,
  `status` enum('BOOKED','PAYED','CHECKEDIN','CHECKEDOUT','CANCELLED') DEFAULT 'BOOKED',
  `totalPrice` int(50) NOT NULL,
  `bundlingId` int(11) DEFAULT NULL,
  `paymentMethod` enum('DP','FULL') DEFAULT NULL,
  `userPayed` int(50) DEFAULT NULL,
  `pictureId` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `userId`, `checkIn`, `checkOut`, `roomId`, `status`, `totalPrice`, `bundlingId`, `paymentMethod`, `userPayed`, `pictureId`, `capacity`) VALUES
(82, 15, '2023-10-25 00:00:00.000', '2023-10-26 00:00:00.000', 67, 'BOOKED', 1515000, NULL, 'DP', 123000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bundling`
--

CREATE TABLE `bundling` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `price` double NOT NULL,
  `type` enum('LDK','PERUSAHAAN','KELUARGA','CAMP') NOT NULL,
  `picture` varchar(191) DEFAULT NULL,
  `isReady` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bundling`
--

INSERT INTO `bundling` (`id`, `name`, `description`, `price`, `type`, `picture`, `isReady`) VALUES
(24, 'Paket A - Gathering (No Trainer)', '', 75000, 'PERUSAHAAN', NULL, 0),
(25, 'Paket A - Tanpa Menginap (No Trainer)', '', 65000, 'LDK', NULL, 1),
(27, 'Paket B - Tanpa Menginap (With Trainer)', '', 95000, 'LDK', NULL, 1),
(28, 'Paket B - Gathering (With Trainer)', '', 130000, 'PERUSAHAAN', NULL, 1),
(29, 'Paket C - Menginap 2 Hari 1 Malam (No Trainer)', '', 175000, 'LDK', NULL, 1),
(30, 'Paket D - Menginap 2 Hari 1 Malam (With Trainer)', '', 275000, 'LDK', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `capacity`
--

CREATE TABLE `capacity` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capacity`
--

INSERT INTO `capacity` (`id`, `name`, `description`) VALUES
(1, 'Standard', '2'),
(2, 'Standard', '3'),
(3, 'standar', '4'),
(4, 'standar', '15'),
(5, 'standar', '29'),
(6, 'standar', '35');

-- --------------------------------------------------------

--
-- Table structure for table `capacityonroom`
--

CREATE TABLE `capacityonroom` (
  `roomId` int(11) NOT NULL,
  `capacityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capacityonroom`
--

INSERT INTO `capacityonroom` (`roomId`, `capacityId`) VALUES
(67, 4),
(73, 3),
(74, 3),
(75, 5),
(76, 6);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `id` int(11) NOT NULL,
  `picture` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `isGeneral` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`id`, `picture`, `name`, `description`, `isGeneral`) VALUES
(6, 'internet.png', 'Wifi', 'Tanya di loket', 1),
(18, 'toilet.png', 'Kamar Mandi Dalam', 'Berada di dalam kamar', 0),
(19, 'waterheater.jpg', 'Water Heater', 'Memanaskan air untuk kopi dan teh', 1),
(20, 'kipas angin.jpg', 'Kipas Angin', 'Berada di dalam kamar', 0),
(21, 'hotel-sign.png', 'Penginapan', 'Paket LDKS/Perusahaan 2 hari 1 malam', 0),
(22, 'kolam.png', 'Kolam Renang', 'Bersih dan luas', 1),
(23, 'parking.png', 'Area Parkir', 'Aman dan nyaman', 1),
(24, 'taman.png', 'Taman', 'Luas dengan pemandangan indah', 1),
(25, 'toilet.png', 'Kamar Mandi', 'Umum', 1);

-- --------------------------------------------------------

--
-- Table structure for table `facilityonbundling`
--

CREATE TABLE `facilityonbundling` (
  `bundlingId` int(11) NOT NULL,
  `facilityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilityonbundling`
--

INSERT INTO `facilityonbundling` (`bundlingId`, `facilityId`) VALUES
(24, 6),
(25, 6),
(29, 18),
(29, 19),
(29, 20),
(29, 21),
(30, 18),
(30, 19),
(30, 20),
(30, 21);

-- --------------------------------------------------------

--
-- Table structure for table `facilityonroom`
--

CREATE TABLE `facilityonroom` (
  `roomId` int(11) NOT NULL,
  `facilityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilityonroom`
--

INSERT INTO `facilityonroom` (`roomId`, `facilityId`) VALUES
(67, 18),
(67, 20),
(73, 18),
(73, 20),
(74, 18),
(74, 20),
(75, 18),
(75, 20),
(76, 18),
(76, 20);

-- --------------------------------------------------------

--
-- Table structure for table `generalinformation`
--

CREATE TABLE `generalinformation` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `picture` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `name` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `name`) VALUES
(29, 'Malaka-Hotel-Bandung-2.webp'),
(30, '60961de48b31a.jpg'),
(31, '1bb30149-c9a8-4240-947c-530f6e9863f9.jpg'),
(32, 'image (1).png'),
(33, 'success-icon-23201.png'),
(34, 'penginapan1.jpg'),
(35, 'slide2.jpg'),
(36, 'slide3.jpg'),
(37, 'slide4.jpg'),
(38, 'slide2.jpg'),
(39, 'slide3.jpg'),
(40, 'slide4.jpg'),
(41, 'slide2.jpg'),
(42, 'slide3.jpg'),
(43, 'slide4.jpg'),
(44, 'slide2.jpg'),
(45, 'slide3.jpg'),
(46, 'slide4.jpg'),
(47, 'slide2.jpg'),
(48, 'slide3.jpg'),
(49, 'slide4.jpg'),
(50, 'slide2.jpg'),
(51, 'slide3.jpg'),
(52, 'slide4.jpg'),
(53, 'denahKuntilt1.PNG'),
(54, 'slide3.jpg'),
(55, 'denahKuntilt2.PNG'),
(56, 'slide4.jpg'),
(57, 'denahKuntilt2.PNG'),
(58, 'denahKuntilt3.PNG'),
(59, 'denahKuntilt2.PNG'),
(60, 'denahKuntilt3.PNG'),
(61, 'slide3.jpg'),
(62, 'slide4.jpg'),
(63, 'slide3.jpg'),
(64, 'slide4.jpg'),
(65, 'denahKuntilt2.PNG'),
(66, 'denahKuntilt3.PNG'),
(67, 'denahKuntilt3.PNG'),
(68, 'denahKuntilt1.PNG'),
(69, 'denahKuntilt2.PNG'),
(70, 'denahKuntilt3.PNG'),
(71, 'denahKuntilt3.PNG'),
(72, 'slide2.jpg'),
(73, 'slide3.jpg'),
(74, 'slide4.jpg'),
(75, 'denahKuntilt3.PNG'),
(76, 'denahKuntilt1.PNG'),
(77, 'slide4.jpg'),
(78, 'logo.png'),
(79, 'denahKuntilt3.PNG'),
(80, 'denahKuntilt3.PNG'),
(81, 'slide2.jpg'),
(82, 'denahKuntilt3.PNG'),
(83, 'slide4.jpg'),
(84, 'success.png'),
(85, 'slide3.jpg'),
(86, 'denahKuntilt3.PNG'),
(87, 'slide2.jpg'),
(88, 'slide3.jpg'),
(89, 'slide4.jpg'),
(90, 'denahKuntilt3.PNG'),
(91, 'slide2.jpg'),
(92, 'slide3.jpg'),
(93, 'slide4.jpg'),
(94, 'slide3.jpg'),
(95, 'penginapan1.jpg'),
(96, 'slide2.jpg'),
(97, 'slide3.jpg'),
(98, 'slide4.jpg'),
(99, 'denahKuntilt3.PNG'),
(100, 'penginapan1.jpg'),
(101, 'slide2.jpg'),
(102, 'slide3.jpg'),
(103, 'slide4.jpg'),
(104, 'penginapan1.jpg'),
(105, 'slide2.jpg'),
(106, 'denahKuntilt1.PNG'),
(107, 'slide3.jpg'),
(108, 'slide2.jpg'),
(109, 'slide3.jpg'),
(110, 'slide4.jpg'),
(111, 'slide3.jpg'),
(112, 'slide4.jpg'),
(113, 'penginapan1.jpg'),
(114, 'slide2.jpg'),
(115, 'slide3.jpg'),
(116, 'slide4.jpg'),
(117, 'penginapan1.jpg'),
(118, 'penginapan1.jpg'),
(119, 'WhatsApp Image 2023-10-01 at 23.16.27.jpeg'),
(120, 'WhatsApp Image 2023-10-01 at 23.17.42.jpeg'),
(121, 'perusahaan.jpeg'),
(122, 'perusahaan.jpeg'),
(123, 'WhatsApp Image 2023-10-01 at 23.16.27.jpeg'),
(124, 'slide2.jpg'),
(125, 'camp.jpg'),
(126, 'camp.jpg'),
(127, 'kompor.jpg'),
(128, 'musholla.png'),
(129, 'slide2.jpg'),
(130, 'kompor.jpg'),
(131, 'kompor.jpg'),
(132, 'kompor.jpg'),
(133, 'kompor.jpg'),
(134, 'kompor.jpg'),
(135, 'perusahaan.jpeg'),
(136, 'slide3.jpg'),
(137, 'slide4.jpg'),
(138, 'penginapan1.jpg'),
(139, 'slide2.jpg'),
(140, 'perusahaan.jpeg'),
(141, 'perusahaan.jpeg'),
(142, 'perusahaan.jpeg'),
(143, 'Frame 2063.png'),
(144, NULL),
(145, 'Frame 1.png'),
(146, 'image.jpg'),
(147, 'Frame 2063.png'),
(148, 'Group 31.png'),
(149, 'Frame 1.png'),
(150, 'Group 31.png'),
(151, 'Frame 2063.png'),
(152, 'Frame 1.png'),
(153, 'Group 31.png'),
(154, '787da2457723b52053320b1d6de0a63c.png'),
(155, 'c8631ebf27fc8f3ac662c7f36549c073.png'),
(156, '3bee5e719af4dbce2abc8e678ab740c1.png'),
(157, 'a8277012b2ac5d893e631d8eb3b9c821.png'),
(158, '18d3a494f2e728b05d92584a60f801e2.png'),
(159, 'denahJanaka.PNG'),
(160, 'IMG_8045.JPG'),
(161, 'penginapan1.jpg'),
(162, 'denahKuntilt1.PNG'),
(163, 'denahKuntilt2.PNG'),
(164, 'denahKuntilt3.PNG'),
(165, 'dewi kunti.jpg'),
(166, 'slide3.jpg'),
(167, 'denahArimbi2.PNG'),
(168, 'IMG_8063.JPG'),
(169, 'denahArimbi2.PNG'),
(170, 'IMG_8062.JPG'),
(171, 'denahArimbi2.PNG'),
(172, 'IMG_8062.JPG'),
(173, 'IMG_8062.JPG'),
(174, 'IMG_8062.JPG'),
(175, 'IMG_8063.JPG'),
(176, 'IMG_6775.JPG'),
(177, 'IMG_6774.JPG'),
(178, 'Gambar PNG 7 (1).png'),
(179, 'Gambar PNG 8.png'),
(180, 'Gambar PNG 43.png'),
(181, 'Gambar PNG 8.png'),
(182, 'IMG_7988.JPG'),
(183, 'IMG_8004.JPG'),
(184, 'Gambar PNG 29.png'),
(185, 'Gambar PNG 43.png'),
(186, 'IMG_8044.JPG'),
(187, 'janaka.jpg'),
(188, 'denahArimbi2.PNG'),
(189, 'IMG_8062.JPG'),
(190, 'denahKuntilt1.PNG'),
(191, 'dewi kunti.jpg'),
(192, 'denahKuntilt1.PNG'),
(193, 'IMG_8046.JPG'),
(194, 'denahKuntilt1.PNG'),
(195, 'IMG_8046.JPG'),
(196, 'slide3.jpg'),
(197, 'denahKuntilt2.PNG'),
(198, 'IMG_8051.JPG'),
(199, 'slide3.jpg'),
(200, 'denahKuntilt3.PNG'),
(201, 'slide3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pictureonbundling`
--

CREATE TABLE `pictureonbundling` (
  `bundlingId` int(11) NOT NULL,
  `pictureId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pictureonbundling`
--

INSERT INTO `pictureonbundling` (`bundlingId`, `pictureId`) VALUES
(24, 121),
(25, 121),
(27, 179),
(28, 176),
(28, 177),
(29, 182),
(29, 183),
(30, 180),
(30, 184);

-- --------------------------------------------------------

--
-- Table structure for table `pictureonroom`
--

CREATE TABLE `pictureonroom` (
  `roomId` int(11) NOT NULL,
  `pictureId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pictureonroom`
--

INSERT INTO `pictureonroom` (`roomId`, `pictureId`) VALUES
(67, 186),
(67, 187),
(73, 36),
(73, 53),
(73, 193),
(74, 167),
(74, 170),
(75, 36),
(75, 55),
(75, 198),
(76, 36),
(76, 58);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `rating` double NOT NULL,
  `roomId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `price` double NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `isReady` tinyint(1) NOT NULL DEFAULT 0,
  `picture` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `description`, `price`, `rating`, `isReady`, `picture`) VALUES
(67, 'Janaka Besar', NULL, 1500000, 0, 1, NULL),
(73, 'Graha Dewi Kunti lt1', NULL, 700000, 0, 1, NULL),
(74, 'Griya Arimbi 2', NULL, 350000, 0, 1, NULL),
(75, 'Graha Dewi Kunti lt2', NULL, 2500000, 0, 1, NULL),
(76, 'Graha Dewi Kunti lt3', NULL, 3000000, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roomonbundling`
--

CREATE TABLE `roomonbundling` (
  `bundlingId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rule`
--

CREATE TABLE `rule` (
  `id` int(11) NOT NULL,
  `isGeneral` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rule`
--

INSERT INTO `rule` (`id`, `isGeneral`, `description`) VALUES
(3, 1, 'Pembayaran penuh pada saat Check-in'),
(4, 1, 'Pembatalan reservasi maksimal 1x24 jam sebelum tanggal penyewaan dengan melakukan pemberitahuan kepada pihak Asriloka. Jika lebih dari 1x24 jam akan dikenakan biaya 1 malam penyewaan\r\n'),
(6, 1, 'Sebelum menyewa, silahkan melakukan konfirmasi ketersediaan penginapan/paket kepada pihak Asriloka\r\n'),
(7, 1, 'Check-in 14.00 WIB & Check-out 12.00 WIB'),
(8, 1, 'Dilarang merokok di dalam kamar');

-- --------------------------------------------------------

--
-- Table structure for table `ruleonbundling`
--

CREATE TABLE `ruleonbundling` (
  `bundlingId` int(11) NOT NULL,
  `ruleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruleonbundling`
--

INSERT INTO `ruleonbundling` (`bundlingId`, `ruleId`) VALUES
(24, 6),
(25, 3),
(27, 3),
(27, 4),
(27, 6),
(28, 3),
(28, 4),
(28, 6),
(29, 3),
(29, 4),
(29, 6),
(29, 7),
(29, 8),
(30, 3),
(30, 4),
(30, 6),
(30, 7),
(30, 8);

-- --------------------------------------------------------

--
-- Table structure for table `ruleonroom`
--

CREATE TABLE `ruleonroom` (
  `roomId` int(11) NOT NULL,
  `ruleId` int(11) NOT NULL,
  `assignedAt` datetime(3) NOT NULL DEFAULT current_timestamp(3),
  `assignedBy` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruleonroom`
--

INSERT INTO `ruleonroom` (`roomId`, `ruleId`, `assignedAt`, `assignedBy`) VALUES
(67, 3, '2023-10-11 12:56:12.427', ''),
(67, 4, '2023-10-11 12:56:12.430', ''),
(67, 6, '2023-10-11 12:56:12.432', ''),
(67, 7, '2023-10-11 12:56:12.434', ''),
(67, 8, '2023-10-11 12:56:12.435', ''),
(73, 3, '2023-10-11 13:09:21.735', ''),
(73, 4, '2023-10-11 13:09:21.737', ''),
(73, 6, '2023-10-11 13:09:21.738', ''),
(73, 7, '2023-10-11 13:09:21.740', ''),
(73, 8, '2023-10-11 13:09:21.742', ''),
(74, 3, '2023-10-11 13:05:15.685', ''),
(74, 4, '2023-10-11 13:05:15.687', ''),
(74, 6, '2023-10-11 13:05:15.689', ''),
(74, 7, '2023-10-11 13:05:15.690', ''),
(74, 8, '2023-10-11 13:05:15.694', ''),
(75, 3, '2023-10-11 13:16:22.957', ''),
(75, 4, '2023-10-11 13:16:22.958', ''),
(75, 6, '2023-10-11 13:16:22.959', ''),
(75, 7, '2023-10-11 13:16:22.960', ''),
(75, 8, '2023-10-11 13:16:22.962', ''),
(76, 3, '2023-10-11 13:19:03.513', ''),
(76, 4, '2023-10-11 13:19:03.516', ''),
(76, 6, '2023-10-11 13:19:03.518', ''),
(76, 7, '2023-10-11 13:19:03.519', ''),
(76, 8, '2023-10-11 13:19:03.522', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `picture` varchar(191) DEFAULT NULL,
  `phone` varchar(191) NOT NULL,
  `dob` datetime(3) DEFAULT current_timestamp(3),
  `address` varchar(191) DEFAULT NULL,
  `role` enum('ADMIN','USER') NOT NULL DEFAULT 'USER',
  `token` varchar(191) DEFAULT 'undefined'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `picture`, `phone`, `dob`, `address`, `role`, `token`) VALUES
(14, 'Admin', '$2y$10$/Vqs2P3iE2MZns0K6zEPD.YaDO2vRWeLt9F7WUvpfGii3Bo91qThG', NULL, '012345678', '2023-10-25 20:47:52.880', NULL, 'ADMIN', 'pgjMOseps6Y/7YBw/w6Gw2YO/XmC4H/u2z14hETv/R4='),
(15, 'User', '$2y$10$PB9C0BprdOhbMIAQN7QZnO6vmT5GPQX8Bmiq/YWTG.kWG.pWT4K2e', NULL, '01234456789', '2000-01-01 00:00:00.000', 'User Address', 'USER', 'IIzI2k9ZYIlEnB1WJP5aLTLPGP2lwTOqieuglyydUBo='),
(16, 'Pelanggan terhormat', '$2y$10$quMkpe8BRwnjvIoHLcRkb.8OL717OCpE1veFLRYKD./lbNUs5hdOW', '1698242176-65391e80d6bb9.png', '085123456789', '2023-10-25 00:00:00.000', 'Dsn.Sidorembug Ds.Balongsari RT.13 RW.04\r\nKec. Gedeg', 'USER', 'yn4WEbcHtwzRFjnbIKcqsknlD85WIrZ4QfJDskhdCBQ=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Booking_userId_fkey` (`userId`),
  ADD KEY `Booking_roomId_fkey` (`roomId`),
  ADD KEY `Booking_bundlingId_fkey` (`bundlingId`) USING BTREE;

--
-- Indexes for table `bundling`
--
ALTER TABLE `bundling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `capacity`
--
ALTER TABLE `capacity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `capacityonroom`
--
ALTER TABLE `capacityonroom`
  ADD PRIMARY KEY (`roomId`,`capacityId`),
  ADD KEY `CapacityOnRoom_capacityId_fkey` (`capacityId`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilityonbundling`
--
ALTER TABLE `facilityonbundling`
  ADD PRIMARY KEY (`bundlingId`,`facilityId`),
  ADD KEY `FacilityOnBundling_facilityId_fkey` (`facilityId`);

--
-- Indexes for table `facilityonroom`
--
ALTER TABLE `facilityonroom`
  ADD PRIMARY KEY (`roomId`,`facilityId`),
  ADD KEY `FacilityOnRoom_facilityId_fkey` (`facilityId`);

--
-- Indexes for table `generalinformation`
--
ALTER TABLE `generalinformation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pictureonbundling`
--
ALTER TABLE `pictureonbundling`
  ADD PRIMARY KEY (`bundlingId`,`pictureId`),
  ADD KEY `PictureOnBundling_pictureId_fkey` (`pictureId`);

--
-- Indexes for table `pictureonroom`
--
ALTER TABLE `pictureonroom`
  ADD PRIMARY KEY (`roomId`,`pictureId`),
  ADD KEY `PictureOnRoom_pictureId_fkey` (`pictureId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Review_roomId_fkey` (`roomId`),
  ADD KEY `Review_userId_fkey` (`userId`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roomonbundling`
--
ALTER TABLE `roomonbundling`
  ADD PRIMARY KEY (`bundlingId`,`roomId`),
  ADD KEY `RoomOnBundling_roomId_fkey` (`roomId`);

--
-- Indexes for table `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruleonbundling`
--
ALTER TABLE `ruleonbundling`
  ADD PRIMARY KEY (`bundlingId`,`ruleId`),
  ADD KEY `RuleOnBundling_ruleId_fkey` (`ruleId`);

--
-- Indexes for table `ruleonroom`
--
ALTER TABLE `ruleonroom`
  ADD PRIMARY KEY (`roomId`,`ruleId`),
  ADD KEY `RuleOnRoom_ruleId_fkey` (`ruleId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `bundling`
--
ALTER TABLE `bundling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `capacity`
--
ALTER TABLE `capacity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `generalinformation`
--
ALTER TABLE `generalinformation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `rule`
--
ALTER TABLE `rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `Booking_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Booking_userId_fkey` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `capacityonroom`
--
ALTER TABLE `capacityonroom`
  ADD CONSTRAINT `CapacityOnRoom_capacityId_fkey` FOREIGN KEY (`capacityId`) REFERENCES `capacity` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `CapacityOnRoom_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `facilityonbundling`
--
ALTER TABLE `facilityonbundling`
  ADD CONSTRAINT `FacilityOnBundling_bundlingId_fkey` FOREIGN KEY (`bundlingId`) REFERENCES `bundling` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FacilityOnBundling_facilityId_fkey` FOREIGN KEY (`facilityId`) REFERENCES `facility` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `facilityonroom`
--
ALTER TABLE `facilityonroom`
  ADD CONSTRAINT `FacilityOnRoom_facilityId_fkey` FOREIGN KEY (`facilityId`) REFERENCES `facility` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FacilityOnRoom_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pictureonbundling`
--
ALTER TABLE `pictureonbundling`
  ADD CONSTRAINT `PictureOnBundling_bundlingId_fkey` FOREIGN KEY (`bundlingId`) REFERENCES `bundling` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PictureOnBundling_pictureId_fkey` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pictureonroom`
--
ALTER TABLE `pictureonroom`
  ADD CONSTRAINT `PictureOnRoom_pictureId_fkey` FOREIGN KEY (`pictureId`) REFERENCES `picture` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PictureOnRoom_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `Review_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Review_userId_fkey` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `roomonbundling`
--
ALTER TABLE `roomonbundling`
  ADD CONSTRAINT `RoomOnBundling_bundlingId_fkey` FOREIGN KEY (`bundlingId`) REFERENCES `bundling` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RoomOnBundling_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ruleonbundling`
--
ALTER TABLE `ruleonbundling`
  ADD CONSTRAINT `RuleOnBundling_bundlingId_fkey` FOREIGN KEY (`bundlingId`) REFERENCES `bundling` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RuleOnBundling_ruleId_fkey` FOREIGN KEY (`ruleId`) REFERENCES `rule` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ruleonroom`
--
ALTER TABLE `ruleonroom`
  ADD CONSTRAINT `RuleOnRoom_roomId_fkey` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RuleOnRoom_ruleId_fkey` FOREIGN KEY (`ruleId`) REFERENCES `rule` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
