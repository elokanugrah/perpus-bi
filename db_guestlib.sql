-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2019 at 03:20 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_guestlib`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `encrypted_password` varchar(100) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `name` varchar(75) NOT NULL,
  `email` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `encrypted_password`, `salt`, `name`, `email`) VALUES
(1, 'admin', 'uANbWIF3iE/pyO1F2cdh9aYXZ2xjNWFhOGM1ZjIx', 'c5aa8c5f21', 'Elok Anugrah', 'elok15ti@mahasiswa.pcr.ac.id');

-- --------------------------------------------------------

--
-- Table structure for table `bookrecomendation`
--

CREATE TABLE `bookrecomendation` (
  `bookrecomendation_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `type` varchar(70) NOT NULL,
  `title` varchar(145) NOT NULL,
  `author` varchar(70) NOT NULL,
  `version` varchar(50) NOT NULL,
  `publisher` varchar(70) NOT NULL,
  `publication_year` int(4) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookrecomendation`
--

INSERT INTO `bookrecomendation` (`bookrecomendation_id`, `member_id`, `type`, `title`, `author`, `version`, `publisher`, `publication_year`, `date`) VALUES
(1, 1, 'Ekonomi', 'Das Kapital', 'Karl Marx', '', '', 1867, '2019-03-20'),
(2, 1, 'Ekonomi', 'ggg', 'ggg', '', '', 2012, '2019-03-26'),
(3, 15, 'Hukum', 'Test', 'test jjj', '', '', 1997, '2019-03-27'),
(4, 1, 'Ekonomi', 'ggg', 'ggg', '', 'r', 1905, '2019-04-26'),
(5, 1, 'Ekonomi', 'ggg', 'ggg', '', 'r', 1905, '2019-04-26'),
(6, 1, 'Ekonomi', 'Das Kapital', 'Karl Marx', '', 'r', 0, '2019-04-20'),
(7, 1, 'Ekonomi', 'ggg', 'ggg', '2', 'r', 1905, '2019-04-26');

-- --------------------------------------------------------

--
-- Table structure for table `booktype`
--

CREATE TABLE `booktype` (
  `booktype_id` int(11) NOT NULL,
  `booktype_name` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booktype`
--

INSERT INTO `booktype` (`booktype_id`, `booktype_name`) VALUES
(1, 'Ekonomi'),
(2, 'Hukum'),
(5, 'Matematika');

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

CREATE TABLE `guestbook` (
  `guestbook_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`guestbook_id`, `member_id`, `date`, `time`) VALUES
(108, 1, '2019-04-17', '03:01'),
(109, 2, '2019-04-16', '03:01'),
(110, 3, '2019-04-15', '03:01'),
(111, 4, '2019-04-14', '03:01'),
(112, 5, '2019-04-13', '03:01'),
(113, 6, '2019-04-11', '03:01'),
(114, 6, '2019-04-11', '12:13'),
(115, 18, '2019-04-15', '16:12'),
(117, 20, '2019-04-13', '14:12'),
(120, 18, '2019-04-15', '16:12'),
(121, 1, '2019-04-15', '16:12'),
(122, 1, '2019-04-12', '12:12'),
(123, 1, '2019-04-11', '12:12'),
(124, 1, '2019-04-15', '16:12'),
(125, 1, '2019-04-14', '15:12'),
(126, 1, '2019-04-13', '14:12'),
(127, 1, '2019-04-12', '13:12'),
(128, 1, '2019-04-11', '12:12'),
(129, 1, '2019-11-11', '12:12'),
(132, 15, '2019-03-27', '08:01'),
(133, 2, '2019-03-26', '11:01'),
(134, 1, '2019-03-26', '10:01'),
(135, 8, '2019-03-25', '02:01'),
(136, 8, '2019-03-25', '01:01'),
(137, 8, '2019-03-25', '00:01'),
(138, 8, '2019-03-25', '00:01'),
(139, 8, '2019-03-25', '00:01'),
(140, 8, '2019-03-25', '00:01'),
(141, 8, '2019-03-24', '14:01'),
(142, 8, '2019-03-24', '14:01'),
(143, 8, '2019-03-24', '13:01'),
(144, 8, '2019-03-24', '12:01'),
(145, 8, '2019-03-24', '12:01'),
(146, 1, '2019-03-24', '12:01'),
(147, 1, '2019-03-24', '11:01'),
(148, 1, '2019-03-24', '11:01'),
(149, 1, '2019-03-20', '04:01'),
(150, 13, '2019-03-19', '09:01'),
(151, 1, '2019-03-19', '06:01'),
(152, 13, '2019-03-19', '05:01'),
(153, 13, '2019-03-19', '05:01'),
(154, 13, '2019-03-19', '05:01'),
(155, 13, '2019-03-19', '05:01'),
(156, 8, '2019-03-19', '05:01'),
(157, 8, '2019-03-19', '04:01'),
(158, 8, '2019-03-19', '04:01'),
(159, 8, '2019-03-19', '04:01'),
(160, 8, '2019-03-19', '04:01'),
(161, 8, '2019-03-19', '10:01'),
(162, 1, '2019-03-19', '10:01'),
(163, 8, '2019-03-19', '11:01'),
(164, 8, '2019-03-19', '11:01'),
(165, 8, '2019-03-19', '11:01'),
(166, 8, '2019-03-19', '11:01'),
(167, 8, '2019-03-19', '10:01'),
(168, 9, '2019-03-19', '01:01'),
(169, 1, '2019-03-18', '00:01'),
(170, 2, '2019-03-18', '00:01'),
(171, 1, '2019-03-18', '13:01'),
(172, 1, '2019-03-17', '12:01'),
(173, 8, '2019-03-17', '12:01'),
(174, 2, '2019-03-01', '03:01'),
(175, 1, '2019-01-24', '02:01'),
(176, 4, '2019-01-01', '02:01'),
(177, 4, '2018-11-22', '02:01'),
(178, 2, '2018-11-20', '02:01'),
(179, 3, '2018-11-20', '02:01'),
(180, 1, '2018-11-30', '02:01'),
(181, 3, '2018-10-30', '04:01'),
(182, 6, '2018-10-30', '07:01'),
(183, 6, '2018-10-03', '04:01'),
(184, 4, '2018-09-03', '00:01'),
(185, 5, '2018-08-03', '07:01'),
(186, 3, '2018-07-03', '04:01'),
(187, 4, '2018-07-03', '03:01'),
(188, 5, '2018-07-03', '02:01'),
(189, 2, '2018-06-03', '03:01'),
(190, 6, '2018-05-03', '03:01'),
(191, 4, '2018-04-03', '03:01'),
(192, 5, '2018-04-03', '02:01'),
(193, 5, '2018-03-05', '02:01'),
(194, 4, '2018-03-03', '02:01'),
(195, 5, '2018-02-03', '02:01'),
(196, 6, '2018-02-03', '00:01'),
(197, 1, '2018-01-03', '01:01'),
(198, 3, '2018-01-03', '01:01'),
(199, 1, '2018-01-02', '07:01'),
(200, 3, '2018-01-01', '02:01'),
(201, 5, '2018-01-01', '02:01'),
(202, 1, '2019-04-08', '11:01'),
(203, 16, '2019-04-08', '04:01'),
(204, 1, '2019-04-11', '12:12'),
(205, 1, '2019-04-12', '13:12'),
(206, 1, '2019-04-13', '14:12'),
(207, 1, '2019-04-14', '15:12'),
(208, 1, '2019-04-15', '16:12'),
(209, 1, '2019-04-11', '12:12'),
(210, 1, '2019-04-12', '12:12'),
(211, 1, '2019-04-15', '16:12'),
(212, 1, '2019-04-08', '11:01'),
(213, 16, '2019-04-08', '04:01'),
(214, 1, '2019-04-11', '12:12'),
(215, 1, '2019-04-12', '13:12'),
(216, 1, '2019-04-13', '14:12'),
(217, 1, '2019-04-14', '15:12'),
(218, 1, '2019-04-15', '16:12'),
(219, 1, '2019-04-11', '12:12'),
(220, 1, '2019-04-12', '12:12'),
(221, 1, '2019-04-15', '16:12'),
(222, 1, '2019-05-03', '11:17');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `id_number` varchar(30) NOT NULL,
  `name` varchar(70) NOT NULL,
  `sex` varchar(15) NOT NULL,
  `occupation` varchar(35) NOT NULL,
  `instance` varchar(50) NOT NULL,
  `address` varchar(145) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `id_number`, `name`, `sex`, `occupation`, `instance`, `address`) VALUES
(1, '1555301022', 'Elok Anugrah Alkhaliq', 'Laki-laki', 'Pelajar / Mahasiswa', 'Politeknik Caltex Riau', 'Jl. Buntu'),
(2, '1555301078', 'Selvia Firdaus', 'Perempuan', 'Pelajar / Mahasiswa', 'Institut Teknologi Bandung', 'Jl. Lurus'),
(3, '1455301082', 'Wahyu Adhi', 'Laki-laki', 'Pelajar / Mahasiswa', 'politeknik caltex riau', 'Jl. Lobang'),
(4, '145590', 'Bayu Setiawan', 'Laki-laki', 'Pegawai / Karyawan', 'Bank Indoensia', 'XYZ'),
(5, '132290', 'Dara Ayu', 'Perempuan', 'Pelajar / Mahasiswa', 'Bank Riau', 'xyz'),
(6, '445531228854', 'Delvian Zunaidi', 'Laki-laki', 'Umum', 'Lainnya', 'xyz'),
(8, 's', 's', 'Tidak diketahui', 'Umum', 'Lainnya', 's'),
(9, '8888', 'xyz', 'Perempuan', 'Wiraswasta', 'XYZ', 'XYZ'),
(11, 'i', 'i', 'Laki-laki', 'Karyawan Swasta', 'i', 'i'),
(12, 'p', 'p', 'Perempuan', 'Wiraswasta', 'p', 'p'),
(13, 'g', 'g', 'Perempuan', 'Pegawai Negeri Sipil', 'g', 'g'),
(14, 'e', 'e', 'Laki-laki', 'Pelajar / Mahasiswa', 'e', 'e'),
(15, '4555', 'test', 'Laki-laki', 'Pelajar / Mahasiswa', 'Universitas Riau', 'Jl. Buntu No. 2'),
(16, '777', 'test', 'Laki-laki', 'Karyawan Swasta', 'XYZ', 'xyz'),
(17, '6666', 'asdfasdf', 'asdfas', 'asdfasd', 'asdf', 'sdfasdfas dfadsfasd'),
(18, '777', 'asdfasdf', 'sdsds', 'sdfas', 'q3weqw', 'zxfzxcadsfadf xczdx'),
(20, 'df7345634', 'asdfasdf', 'sdsds', 'sdfas', 'sdsds', 'zxfzxcadsfadf xczdx'),
(21, '1555301022', 's', 'gg', 'gg', 'g', 'g');

-- --------------------------------------------------------

--
-- Table structure for table `occupation`
--

CREATE TABLE `occupation` (
  `occupation_id` int(11) NOT NULL,
  `occupation_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `occupation`
--

INSERT INTO `occupation` (`occupation_id`, `occupation_name`) VALUES
(1, 'Pelajar / Mahasiswa'),
(2, 'Pegawai Negeri Sipil'),
(3, 'Tentara Nasional Indonesia'),
(4, 'Kepolisian RI'),
(5, 'Karyawan Swasta'),
(6, 'Wiraswasta'),
(7, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL,
  `token` varchar(90) NOT NULL,
  `salt` varchar(30) NOT NULL,
  `email` varchar(75) NOT NULL,
  `time` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`token_id`, `token`, `salt`, `email`, `time`) VALUES
(2, 'abWWZMz3Fdyw7HcQFmnlxGbhJqozMzZmZDE1NzY0NTE4NGJlZDYyZmRmNWUzM2ZiZTQ=', '336fd157645184bed62fdf5e33fbe4', 'elok15ti@mahasiswa.pcr.ac.id', '09.18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bookrecomendation`
--
ALTER TABLE `bookrecomendation`
  ADD PRIMARY KEY (`bookrecomendation_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `booktype`
--
ALTER TABLE `booktype`
  ADD PRIMARY KEY (`booktype_id`);

--
-- Indexes for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`guestbook_id`),
  ADD KEY `fk_member` (`member_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `occupation`
--
ALTER TABLE `occupation`
  ADD PRIMARY KEY (`occupation_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookrecomendation`
--
ALTER TABLE `bookrecomendation`
  MODIFY `bookrecomendation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booktype`
--
ALTER TABLE `booktype`
  MODIFY `booktype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `guestbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `occupation`
--
ALTER TABLE `occupation`
  MODIFY `occupation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookrecomendation`
--
ALTER TABLE `bookrecomendation`
  ADD CONSTRAINT `fk_member_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;

--
-- Constraints for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
