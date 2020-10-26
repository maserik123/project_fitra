-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2019 at 05:40 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentoring_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `b_ikhwan`
--

CREATE TABLE `b_ikhwan` (
  `i_id` int(11) NOT NULL,
  `i_nama_pementor` varchar(45) NOT NULL,
  `i_no_ikhwan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `b_ikhwan`
--

INSERT INTO `b_ikhwan` (`i_id`, `i_nama_pementor`, `i_no_ikhwan`) VALUES
(2, 'Fitra', 27);

-- --------------------------------------------------------

--
-- Table structure for table `b_kegiatan`
--

CREATE TABLE `b_kegiatan` (
  `kg_id` int(11) NOT NULL,
  `kg_nama_kegiatan` varchar(110) NOT NULL,
  `kg_batasan_tilawah` int(11) NOT NULL,
  `kg_kultum` varchar(45) NOT NULL,
  `kg_tanggal` date NOT NULL,
  `i_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `b_kegiatan`
--

INSERT INTO `b_kegiatan` (`kg_id`, `kg_nama_kegiatan`, `kg_batasan_tilawah`, `kg_kultum`, `kg_tanggal`, `i_id`) VALUES
(19, 'Pertemuan 2', 55, 'Futsal barengan ', '2019-11-21', 2);

-- --------------------------------------------------------

--
-- Table structure for table `b_kehadiran`
--

CREATE TABLE `b_kehadiran` (
  `h_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `kg_id` int(11) NOT NULL,
  `i_id` int(11) NOT NULL,
  `h_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `b_kehadiran`
--

INSERT INTO `b_kehadiran` (`h_id`, `mhs_id`, `kg_id`, `i_id`, `h_status`) VALUES
(6, 30, 19, 2, 'hadir'),
(7, 30, 21, 2, 'tidak'),
(8, 30, 21, 2, 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `b_mhs_ikhwan`
--

CREATE TABLE `b_mhs_ikhwan` (
  `mhs_id` int(11) NOT NULL,
  `mhs_username` varchar(45) NOT NULL,
  `mhs_password` varchar(45) NOT NULL,
  `mhs_nama` varchar(45) NOT NULL,
  `mhs_angkatan` year(4) NOT NULL,
  `i_id` int(15) NOT NULL,
  `prodi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `b_mhs_ikhwan`
--

INSERT INTO `b_mhs_ikhwan` (`mhs_id`, `mhs_username`, `mhs_password`, `mhs_nama`, `mhs_angkatan`, `i_id`, `prodi_id`) VALUES
(29, 'herry123', '2ece84f1e0aa7d8819eb776405e364c6', 'Herry Abastia Sembiring', 2019, 2, 9),
(30, 'dimas123', '51947e3cf64ee746b6f2c73d174d525a', 'Dimas Kusuma Pranjaya', 2019, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `b_prodi`
--

CREATE TABLE `b_prodi` (
  `prodi_id` int(4) NOT NULL,
  `prodi_nama` varchar(200) NOT NULL,
  `prodi_abbr` varchar(6) NOT NULL,
  `prodi_jenjang` enum('D3','D4','S2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `b_prodi`
--

INSERT INTO `b_prodi` (`prodi_id`, `prodi_nama`, `prodi_abbr`, `prodi_jenjang`) VALUES
(1, 'Teknik Komputer', 'TK', 'D3'),
(2, 'Teknik Elektronika', 'TE', 'D3'),
(3, 'Teknik Telekomunikasi', 'TT', 'D3'),
(4, 'Teknik Mekatronika', 'TM', 'D3'),
(5, 'Akuntansi', 'AKT', 'D3'),
(6, 'Teknik Informatika', 'TI', 'D4'),
(7, 'Sistem Informasi', 'SI', 'D4'),
(8, 'Teknik Elektronika', 'TET', 'D4'),
(9, 'Teknik Mesin', 'MS', 'D4'),
(10, 'Teknik Listrik', 'TL', 'D4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b_ikhwan`
--
ALTER TABLE `b_ikhwan`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `b_kegiatan`
--
ALTER TABLE `b_kegiatan`
  ADD PRIMARY KEY (`kg_id`);

--
-- Indexes for table `b_kehadiran`
--
ALTER TABLE `b_kehadiran`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `b_mhs_ikhwan`
--
ALTER TABLE `b_mhs_ikhwan`
  ADD PRIMARY KEY (`mhs_id`);

--
-- Indexes for table `b_prodi`
--
ALTER TABLE `b_prodi`
  ADD PRIMARY KEY (`prodi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b_ikhwan`
--
ALTER TABLE `b_ikhwan`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `b_kegiatan`
--
ALTER TABLE `b_kegiatan`
  MODIFY `kg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `b_kehadiran`
--
ALTER TABLE `b_kehadiran`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `b_mhs_ikhwan`
--
ALTER TABLE `b_mhs_ikhwan`
  MODIFY `mhs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `b_prodi`
--
ALTER TABLE `b_prodi`
  MODIFY `prodi_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
