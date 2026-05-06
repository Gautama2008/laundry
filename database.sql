CREATE DATABASE IF NOT EXISTS laundry_tama;
USE laundry_tama;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `tb_detail_transaksi`;
DROP TABLE IF EXISTS `tb_transaksi`;
DROP TABLE IF EXISTS `tb_paket`;
DROP TABLE IF EXISTS `tb_member`;
DROP TABLE IF EXISTS `tb_user`;
DROP TABLE IF EXISTS `tb_outlet`;

-- Table structure for tb_outlet
CREATE TABLE `tb_outlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for tb_outlet
INSERT INTO `tb_outlet` (`id`, `nama`, `alamat`, `tlp`) VALUES
(1, 'Laundry Tama Pusat', 'Jl. Merdeka No. 1, Jakarta', '081234567890');

-- Table structure for tb_user
CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_user` (`id`, `nama`, `username`, `password`, `id_outlet`, `role`) VALUES
(1, 'Admintama', 'admin', '0192023a7bbd73250516f069df18b500', 1, 'admin'),
(2, 'Kasirku', 'kasir', 'de28f8f7998f23ab4194b51a6029416f', 1, 'kasir'),
(3, 'Boss', 'owner', '5be057accb25758101fa5eadbbd79503', 1, 'owner');

-- Table structure for tb_member
CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tlp` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for tb_member
INSERT INTO `tb_member` (`id`, `nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
(1, 'Budi Santoso', 'Jl. Sudirman No 4', 'L', '08987654321');

-- Table structure for tb_paket
CREATE TABLE `tb_paket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  CONSTRAINT `tb_paket_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for tb_paket
INSERT INTO `tb_paket` (`id`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(1, 1, 'kiloan', 'Cuci Komplit Reguler', 6000),
(2, 1, 'bed_cover', 'Cuci Bed Cover Besar', 25000);

-- Table structure for tb_transaksi
CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_outlet` int(11) NOT NULL,
  `kode_invoice` varchar(100) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `biaya_tambahan` int(11) NOT NULL DEFAULT 0,
  `diskon` double NOT NULL DEFAULT 0,
  `pajak` int(11) NOT NULL DEFAULT 0,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum_dibayar') NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  KEY `id_member` (`id_member`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_transaksi_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `tb_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_transaksi_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for tb_detail_transaksi
CREATE TABLE `tb_detail_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` double NOT NULL,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_paket` (`id_paket`),
  CONSTRAINT `tb_detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_detail_transaksi_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
