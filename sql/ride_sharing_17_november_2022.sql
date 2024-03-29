-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2022 at 09:23 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ride_sharing`
--

-- --------------------------------------------------------

--
-- Table structure for table `histori_isisaldo`
--

CREATE TABLE `histori_isisaldo` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_uang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `histori_isisaldo`
--

INSERT INTO `histori_isisaldo` (`id`, `tanggal`, `jumlah_uang`, `id_user`) VALUES
(1, '2022-11-03', 321, 12),
(2, '2022-11-04', 60000, 13),
(3, '2022-11-05', 6000, 15),
(4, '2022-11-06', 7000, 14);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `biaya` int(11) NOT NULL,
  `lokasi_berangkat` varchar(50) NOT NULL,
  `lokasi_tujuan` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_live`
--

CREATE TABLE `order_live` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL COMMENT 'kapasitas mobil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_live`
--

INSERT INTO `order_live` (`id`, `id_user`, `id_driver`, `kapasitas`) VALUES
(1, 14, 1, 5),
(2, 0, 14, -1),
(3, 12, 14, -1),
(4, 12, 14, -1),
(5, 12, 14, -1),
(6, 12, 14, 4),
(7, 12, 14, 4),
(8, 12, 14, 4),
(9, 12, 14, 4),
(10, 12, 14, 4),
(11, 12, 14, 4),
(12, 12, 14, 4),
(13, 12, 14, 4),
(14, 12, 14, 4),
(15, 12, 14, 4),
(16, 12, 14, 4),
(17, 12, 14, 4),
(18, 12, 14, 4);

-- --------------------------------------------------------

--
-- Table structure for table `search_live`
--

CREATE TABLE `search_live` (
  `id` int(11) NOT NULL,
  `lokasi_berangkat` varchar(100) NOT NULL,
  `lokasi_tujuan` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = driver, 1 = user',
  `id_driver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `search_live`
--

INSERT INTO `search_live` (`id`, `lokasi_berangkat`, `lokasi_tujuan`, `id_user`, `status`, `id_driver`) VALUES
(445, '1,Jl. Siwalankerto Permai II', 'jombang', 12, 1, 14),
(453, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(454, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0),
(455, '39,Jl. Siwalankerto Permai II', ' gedung p siwalankerto', 14, 0, 0),
(456, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(457, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0),
(458, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(459, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(460, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(461, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(462, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(463, '39,Jl. Siwalankerto Permai II', 'gedung p siwalankerto', 14, 0, 0),
(464, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0),
(465, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0),
(466, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0),
(467, '39,Jl. Siwalankerto Permai II', 'tumapel', 14, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `biaya` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `saldo` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL COMMENT '0-5 kapasitas kendaraan',
  `status` int(11) NOT NULL COMMENT '0 = user 1 = driver'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `umur`, `alamat`, `saldo`, `kapasitas`, `status`) VALUES
(12, 'driver', 'driver', 20, 'Jl. Tumapel No.47', 61362, 4, 1),
(13, 'user', 'user', 21, 'Jl. Tumapel No.45', 110000, 0, 0),
(14, 'user1', 'user1', 27, 'Jl. Siwalankerto VIII', 57000, 5, 0),
(15, 'user2', 'user2', 22, 'Jl. Siwalankerto VIII', 56000, 0, 0),
(16, 'user3', 'user3', 21, 'Jl. Siwalankerto VIII', 50000, 0, 0),
(17, 'user4', 'user4', 34, 'Jl. Siwalankerto VIII', 50000, 0, 0),
(18, 'user5', 'user5', 31, 'Jl. Siwalankerto VIII', 50000, 0, 0),
(19, 'user6', 'user6', 23, 'Jl. Siwalankerto VIII', 50000, 0, 0),
(20, '', '', 0, '', 50000, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `histori_isisaldo`
--
ALTER TABLE `histori_isisaldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_live`
--
ALTER TABLE `order_live`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_live`
--
ALTER TABLE `search_live`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `histori_isisaldo`
--
ALTER TABLE `histori_isisaldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_live`
--
ALTER TABLE `order_live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `search_live`
--
ALTER TABLE `search_live`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=468;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
