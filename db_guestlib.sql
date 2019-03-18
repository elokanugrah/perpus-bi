-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2019 at 04:04 PM
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
  `salt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `encrypted_password`, `salt`) VALUES
(1, 'admin', '/0OFQXNEwlSNT5wMBMwt88AxIc5iYmZkMzQyY2Qw', 'bbfd342cd0');

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
(10, 5, '2018-01-01', '12.11'),
(11, 3, '2018-01-01', '12.12'),
(12, 1, '2018-01-02', '12.30'),
(13, 3, '2018-01-03', '12.05'),
(14, 1, '2018-01-03', '12.07'),
(15, 6, '2018-02-03', '10.00'),
(16, 5, '2018-02-03', '11.12'),
(17, 4, '2018-03-03', '12.12'),
(18, 5, '2018-03-05', '12.12'),
(19, 5, '2018-04-03', '12.12'),
(20, 4, '2018-04-03', '12.15'),
(21, 6, '2018-05-03', '12.15'),
(22, 2, '2018-06-03', '12.15'),
(23, 5, '2018-07-03', '12.12'),
(24, 4, '2018-07-03', '12.15'),
(25, 3, '2018-07-03', '12.20'),
(26, 5, '2018-08-03', '12.30'),
(27, 4, '2018-09-03', '13.00'),
(28, 6, '2018-10-03', '14.20'),
(29, 6, '2018-10-30', '15.30'),
(30, 3, '2018-11-30', '11.20'),
(31, 1, '2018-12-03', '12.12'),
(32, 3, '2018-12-20', '12.12'),
(33, 2, '2018-12-20', '12.12'),
(34, 4, '2018-12-22', '11.12'),
(35, 4, '2019-01-01', '12.12'),
(36, 1, '2019-01-24', '12.12'),
(37, 2, '2019-11-01', '14.14'),
(38, 7, '2019-03-17', '17.27'),
(39, 8, '2019-03-17', '21.51'),
(40, 1, '2019-03-17', '21.52');

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
(1, '1555301022', 'Elok Anugrah Alkhaliq', 'Laki-laki', 'Pelajar/Mahasiswa', 'Politeknik Caltex Riau', 'Jl. Buntu'),
(2, '1555301078', 'Selvia Firdaus', 'Perempuan', 'Pelajar/Mahasiswa', 'Institut Teknologi Bandung', 'Jl. Lurus'),
(3, '1455301082', 'Wahyu Adhi', 'Laki-laki', 'Pelajar/Mahasiswa', 'politeknik caltex riau', 'Jl. Lobang'),
(4, '145590', 'Bayu Setiawan', 'Laki-laki', 'Pegawai/Karyawan', 'Bank Indoensia', 'XYZ'),
(5, '132290', 'Dara Ayu', 'Perempuan', 'Pegawai/Karyawan', 'Bank Riau', 'xyz'),
(6, '445531228854', 'Delvian Zunaidi', 'Laki-laki', 'Umum', 'Lainnya', 'xyz'),
(7, 'a', 'a', 'Tidak diketahui', 'Lainnya', 'a', 'a'),
(8, 's', 's', 'Tidak diketahui', 'Lainnya', 's', 's');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `guestbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `occupation`
--
ALTER TABLE `occupation`
  MODIFY `occupation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
