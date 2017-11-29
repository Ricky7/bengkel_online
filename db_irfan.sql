-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 12, 2017 at 12:01 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_irfan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `peran` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama`, `username`, `password`, `peran`) VALUES
(1, 'Barry', 'admin', '$2y$10$8RIrRt2H314TchR16O2cYO.avCEaUmaOdcP6XjO/IHosmeH.K9HVG', 'admin'),
(2, 'Carlie', 'carlie123', '$2y$10$olHo7F9/8dCSgwPsoGbYv.qkxURgGrSs4OGJ.IRNdvxJQs8uOUQj2', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id_cart` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `harga` int(30) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id_cart`, `id_produk`, `id_user`, `harga`, `jumlah`) VALUES
(3, 2, 0, 50000, 1),
(4, 5, 0, 1500000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL,
  `deskripsi_kat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`, `deskripsi_kat`) VALUES
(1, 'Oli Motor', 'Pelumas mesin motor'),
(2, 'Knalpot', '  Knalpot aftermarket buat segala motor'),
(3, 'Aksesoris', 'Hiasan motor dan lainnya'),
(5, 'Lampu', '  Segala Jenis Lampu yang ada pada bagian motor'),
(6, 'Ban Lingkar', 'Segala Jenis Ban atau Lingkar motor'),
(7, 'Karburator', 'Berbagai Jenis Karburator'),
(8, 'Busi', 'Berbagai Jenis Busi'),
(9, 'Shock Breaker', 'Berbagai Jenis Shock Breaker'),
(10, 'Aksesoris', 'Segala Jenis Aksesoris dan variasi motor'),
(11, 'Stiker', 'Segala Jenis stiker motor'),
(12, 'Rantai', 'Segala Jenis Rantai'),
(13, 'Cairan', 'Segala jenis cariran yang diperlukan pada motor'),
(14, 'Kanvas Rem', 'Segala Jenis Kanvas Rem pada motor'),
(15, 'Body', 'Body ataupun Cover Body pada segala jenis motor'),
(16, 'Lainnya', 'Produk - produk tambahan yang tidak bermerk');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kirim`
--

CREATE TABLE `tbl_kirim` (
  `id_kirim` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tgl_kirim` datetime NOT NULL,
  `jasa_kurir` varchar(25) NOT NULL,
  `paket_antar` varchar(25) NOT NULL,
  `berat_paket` int(10) NOT NULL,
  `no_resi` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kirim`
--

INSERT INTO `tbl_kirim` (`id_kirim`, `id_order`, `alamat`, `tgl_kirim`, `jasa_kurir`, `paket_antar`, `berat_paket`, `no_resi`) VALUES
(4, 1, 'Jl.Pancing No 20 Medan', '2017-08-05 01:18:25', 'PT POS INDONESIA', 'Paketpos Biasa', 12500, '4565767456345654'),
(5, 2, 'Jl.Pancing No 20 Medan', '2017-08-05 15:15:48', 'PT POS INDONESIA', 'Paketpos Biasa', 6500, '3425465467564354'),
(6, 3, 'Jl.Pancing No 20 Medan', '2017-08-05 15:26:11', 'PT POS INDONESIA', 'Paketpos Valuable Go', 6500, '5345345634658'),
(7, 4, 'Jl.Pancing No 20 Medan', '2017-08-12 16:21:51', 'JNE', 'YES', 3000, '234723490723509723');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kabupaten` varchar(30) NOT NULL,
  `kodepos` varchar(10) NOT NULL,
  `provinsi` varchar(25) NOT NULL,
  `tgl_order` datetime NOT NULL,
  `desk_order` varchar(150) DEFAULT NULL,
  `jasa_kurir` varchar(25) NOT NULL,
  `jenis_paket` varchar(20) NOT NULL,
  `ongkir` int(20) NOT NULL,
  `berat_order` int(20) NOT NULL,
  `status_order` varchar(15) NOT NULL,
  `jenis_bank` varchar(12) DEFAULT NULL,
  `nama_rek` varchar(25) DEFAULT NULL,
  `no_rek` varchar(20) DEFAULT NULL,
  `nilai_transfer` int(15) DEFAULT NULL,
  `ket_transfer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id_order`, `id_user`, `id_admin`, `no_hp`, `alamat`, `kabupaten`, `kodepos`, `provinsi`, `tgl_order`, `desk_order`, `jasa_kurir`, `jenis_paket`, `ongkir`, `berat_order`, `status_order`, `jenis_bank`, `nama_rek`, `no_rek`, `nilai_transfer`, `ket_transfer`) VALUES
(1, 2, 1, '084657636745', 'Jl.Pancing No 20 Medan', 'Jakarta Ba', '34564', 'DKI Jakarta', '2017-08-03 21:24:47', 'Nothing', 'PT POS INDONESIA', 'Paketpos Biasa', 114635, 12500, 'Selesai', 'MANDIRI', 'Megan Putri', '7768475863', 4370000, 'Nothing'),
(2, 2, 1, '084657636745', 'Jl.Pancing No 20 Medan', 'Batang Har', '45635', 'Jambi', '2017-08-04 20:33:21', 'Tidak ada', 'PT POS INDONESIA', 'Paketpos Biasa', 72215, 6500, 'Selesai', 'MANDIRI', 'Megan', '575687674676', 2880000, 'gk ada'),
(3, 2, 1, '084657636745', 'Jl.Pancing No 20 Medan', 'Jakarta Pusat', '24235', 'DKI Jakarta', '2017-08-05 15:12:41', 'gk ada', 'PT POS INDONESIA', 'Paketpos Valuable Go', 212100, 6500, 'Selesai', 'BCA', 'Megan', '467564534758734', 3015000, 'gk ada'),
(4, 2, 1, '084657636745', 'Jl.Pancing No 20 Medan', 'Jakarta Pusat', '33435', 'DKI Jakarta', '2017-08-12 16:16:41', 'nothing', 'JNE', 'YES', 75000, 3000, 'Selesai', 'BCA', 'Megan', '074507475749754', 3120000, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `id_detail` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`id_detail`, `id_order`, `id_produk`, `jumlah`, `harga`) VALUES
(1, 1, 4, 2, 2600000),
(2, 1, 2, 3, 150000),
(3, 1, 5, 1, 1500000),
(4, 2, 5, 1, 1500000),
(5, 2, 4, 1, 1300000),
(6, 3, 4, 1, 1300000),
(7, 3, 5, 1, 1500000),
(9, 4, 3, 1, 45000),
(10, 4, 6, 2, 3000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_produk` varchar(30) NOT NULL,
  `nama_produk` varchar(30) NOT NULL,
  `merk` varchar(20) NOT NULL,
  `harga` int(15) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `berat` int(30) NOT NULL,
  `stok` int(20) NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `id_kategori`, `kode_produk`, `nama_produk`, `merk`, `harga`, `deskripsi`, `gambar`, `berat`, `stok`, `tgl_update`) VALUES
(2, 1, '456354', 'Yamalube', 'Yamaha', 50000, 'Pelicin', '607257.png', 1000, 27, '2017-08-01 00:22:51'),
(3, 1, '567657', 'MPX 500', 'Honda', 45000, 'Oli khusus honda', '155910.png', 1000, 41, '2017-08-01 14:49:27'),
(4, 2, '577467', ' Valencia Titanium', 'R9', 1300000, 'Khusus Buat Jupiter MX', '72772.png', 3000, 91, '2017-08-01 14:49:17'),
(5, 2, '685785', 'Valencia Stainless', 'R9', 1500000, 'Khusus Honda Legenda', '793682.png', 3500, 74, '2017-08-01 14:49:08'),
(6, 6, '456756', 'Velg Racing', 'TDR', 1500000, 'Gk ada', '118223.png', 1000, 50, '2017-08-12 16:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kota` varchar(20) DEFAULT NULL,
  `provinsi` varchar(30) DEFAULT NULL,
  `kodepos` varchar(15) DEFAULT NULL,
  `tgl_daftar` datetime NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama`, `kota`, `provinsi`, `kodepos`, `tgl_daftar`, `no_hp`, `alamat`) VALUES
(2, 'megan123', '$2y$10$AL6MvM74HQGDoncTVsDP8.m9wjwExb6/vDYNTPkxWxr0umhlnqzuS', 'Megan', NULL, NULL, NULL, '2017-08-02 17:23:49', '084657636745', 'Jl.Pancing No 20 Medan'),
(3, 'irfan123', '$2y$10$8uOcuKDuMcLRvPFWh7IypeGlzGGUBRtOIgdgAJ3JnQRJhQ1GvtcZ6', 'Irfan', NULL, NULL, NULL, '2017-08-12 16:23:47', '084656465485', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_kirim`
--
ALTER TABLE `tbl_kirim`
  ADD PRIMARY KEY (`id_kirim`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_kirim`
--
ALTER TABLE `tbl_kirim`
  MODIFY `id_kirim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
