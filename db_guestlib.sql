-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13 Mar 2019 pada 14.47
-- Versi Server: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_guestlib`
--
CREATE DATABASE IF NOT EXISTS `db_guestlib` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_guestlib`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `encrypted_password` varchar(100) NOT NULL,
  `salt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `encrypted_password`, `salt`) VALUES
(1, 'admin', '/0OFQXNEwlSNT5wMBMwt88AxIc5iYmZkMzQyY2Qw', 'bbfd342cd0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guestbook`
--

CREATE TABLE `guestbook` (
  `guestbook_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guestbook`
--

INSERT INTO `guestbook` (`guestbook_id`, `member_id`, `date`, `time`) VALUES
(1, 1, '0000-00-00', ''),
(2, 1, '2019-03-13', '03:48'),
(3, 1, '2019-03-13', '03:49'),
(4, 1, '2019-03-13', '09.55'),
(5, 1, '2019-03-13', '11.11'),
(6, 1, '2019-03-13', '14.55'),
(7, 1, '2019-03-13', '14.56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
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
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`member_id`, `id_number`, `name`, `sex`, `occupation`, `instance`, `address`) VALUES
(1, '1555301022', 'Elok Anugrah Alkhaliq', 'Laki-laki', 'Pelajar/Mahasiswa', 'Politeknik Caltex Riau', 'Jl. Buntu'),
(2, '1555301078', 'Selvia Firdaus', 'Perempuan', 'Pelajar/Mahasiswa', 'Politeknik Caltex Riau', 'Jl. Lurus'),
(3, '1455301082', 'Wahyu Adhi', 'Laki-laki', 'Pelajar/Mahasiswa', 'Politeknik Caltex Riau', 'Jl. Lobang'),
(4, '145590', 'Bayu Setiawan', 'Laki-laki', 'Karyawan', 'Aselole', 'XYZ'),
(5, '132290', 'Dara', 'Perempuan', 'Karyawan', 'xyz', 'xyz'),
(6, '445531', 'ZZZZZ', 'Laki-laki', 'xyz', 'xyz', 'xyz');

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
  ADD PRIMARY KEY (`guestbook_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

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
  MODIFY `guestbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
