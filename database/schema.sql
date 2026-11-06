-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2026 at 07:28 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gereja_hky`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `id_kategori`, `id_lokasi`, `nama_barang`, `jumlah`, `kondisi`) VALUES
(1, 'BRG001', 1, 1, 'Piala Misa', 5, 'Baik'),
(2, 'BRG002', 1, 1, 'Sibori', 3, 'Baik'),
(3, 'BRG003', 2, 3, 'Speaker Aktif', 4, 'Baik'),
(4, 'BRG004', 2, 2, 'Laptop', 2, 'Baik'),
(5, 'BRG005', 3, 4, 'Sapu Lantai', 10, 'Baik'),
(6, 'BRG006', 4, 3, 'Kursi Plastik', 100, 'Baik'),
(7, 'BRG007', 5, 6, 'Kursi Altar', 4, 'Kurang Baik'),
(8, 'BRG008', 1, 1, 'Mikrofon Gereja', 5, 'Baik');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `kode_kategori` varchar(20) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `tanggal_dibuat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`, `kode_kategori`, `deskripsi`, `tanggal_dibuat`) VALUES
(1, 'Peralatan Elektronik Update', 'KAT001', 'Kategori elektronik yang telah diperbarui', '2026-11-02'),
(2, 'Elektronik', 'KAT002', 'Peralatan elektronik gereja', '2026-11-01'),
(3, 'Peralatan Kebersihan', 'KAT003', 'Peralatan kebersihan gereja', '2026-11-01'),
(4, 'Perabot Gereja', 'KAT004', 'Perabot dan perlengkapan gereja', '2026-11-01'),
(5, 'Tata laksana', 'KAT005', 'Jangan lupa datang hari minggu', '2026-11-01'),
(6, 'Peralatan Kebersihan Gereja', 'KAT006', 'Peralatan untuk menjaga kebersihan gereja', '2026-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `nama_lokasi` varchar(100) NOT NULL,
  `kode_lokasi` varchar(20) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `kapasitas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`, `kode_lokasi`, `penanggung_jawab`, `kapasitas`) VALUES
(1, 'Sakristi', 'LOK001', 'Petugas Sakristi', 50),
(2, 'Ruang Sekretariat', 'LOK002', 'Sekretaris Gereja', 30),
(3, 'Aula Gereja', 'LOK003', 'Petugas Aula', 150),
(4, 'Gudang Gereja', 'LOK004', 'Petugas Gudang', 200),
(5, 'Gudang Gereja 2', 'LOK005', 'Petugas Gudang Baru', 2000),
(6, 'Gudang Serbaguna', 'LOK006', 'Petugas Gudang Baru', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jenis_transaksi` enum('Masuk','Keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_barang`
--

INSERT INTO `transaksi_barang` (`id_transaksi`, `id_barang`, `jenis_transaksi`, `jumlah`, `tanggal`, `keterangan`) VALUES
(1, 1, 'Masuk', 2, '2026-10-01', 'Penambahan piala misa'),
(2, 3, 'Masuk', 2, '2026-10-02', 'Penambahan speaker'),
(3, 4, 'Keluar', 1, '2026-10-05', 'Peminjaman laptop'),
(4, 5, 'Masuk', 5, '2026-10-06', 'Penambahan sapu'),
(5, 6, 'Keluar', 10, '2026-10-07', 'Pemindahan kursi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_lokasi` (`id_lokasi`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`),
  ADD UNIQUE KEY `kode_lokasi` (`kode_lokasi`);

--
-- Indexes for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_barang` (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`),
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`);

--
-- Constraints for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD CONSTRAINT `transaksi_barang_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
