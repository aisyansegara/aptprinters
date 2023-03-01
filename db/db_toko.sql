-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2023 pada 10.42
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembelian`
--

CREATE TABLE `tb_pembelian` (
  `idPembelian` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idPrinter` int(11) NOT NULL,
  `tanggalPembelian` date NOT NULL,
  `jumlahPembelian` varchar(255) NOT NULL,
  `hargaPembelian` varchar(255) NOT NULL,
  `jasaPengiriman` varchar(100) NOT NULL,
  `buktiPembayaran` varchar(255) NOT NULL,
  `kodePembelian` varchar(255) NOT NULL,
  `statusPembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pembelian`
--

INSERT INTO `tb_pembelian` (`idPembelian`, `idUser`, `idPrinter`, `tanggalPembelian`, `jumlahPembelian`, `hargaPembelian`, `jasaPengiriman`, `buktiPembayaran`, `kodePembelian`, `statusPembelian`) VALUES
(1, 2, 4, '2023-02-12', '2', '5000000', 'tiki', '63e8b72429e1d.jpg', 'APTP01', 2),
(2, 2, 3, '2023-02-12', '1', '1500000', 'j&t', '63e8b75e9e0ce.jpg', 'APTP02', 1),
(3, 4, 2, '2023-02-12', '3', '7500000', 'jne', '63e8b7d2dd367.jpg', 'APTP03', 1),
(4, 7, 10, '2023-02-12', '1', '3500000', 'jne', '63e8b8c91097f.jpg', 'APTP04', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_printers`
--

CREATE TABLE `tb_printers` (
  `idPrinter` int(11) NOT NULL,
  `gambarPrinter` varchar(255) NOT NULL,
  `namaPrinter` varchar(100) NOT NULL,
  `deskripsiPrinter` varchar(255) NOT NULL,
  `hargaPrinter` varchar(255) NOT NULL,
  `stokPrinter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_printers`
--

INSERT INTO `tb_printers` (`idPrinter`, `gambarPrinter`, `namaPrinter`, `deskripsiPrinter`, `hargaPrinter`, `stokPrinter`) VALUES
(1, '63e2fded9ad6f.jpg', 'hp a2023', 'Printer HP A2023 terbaru dan termurah.', '3000000', '15'),
(2, '63da96f0dcb65.jpg', 'samsung b2023', 'Printer Samsung B2023 yang fungsional.', '2500000', '12'),
(3, '63da976decb47.jpg', 'brother c2023', 'Printer Brother C2023, printer yang mampu menghadirkan kualitas cetakan foto yang mudah, berkualitas profesional, dan tetap terjangkau di mana saja.', '1500000', '14'),
(4, '63ddb543659d7.png', 'canon d2023', 'Printer Ink Jet yang mampu menghadirkan kualitas cetakan foto yang mudah, berkualitas profesional, dan tetap terjangkau di rumah Anda.', '2500000', '15'),
(9, '63e2ff19e8007.jpg', 'HP E2023', 'Printer HP terbaru, murah, dan berkualitas tinggi.', '4500000', '15'),
(10, '63e5cb5e9a726.jpg', 'epson f2023', 'Printer EPSON F2023 terbaru dan berkualitas.', '3500000', '14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `idUser` int(11) NOT NULL,
  `namaUser` varchar(200) NOT NULL,
  `usernameUser` varchar(50) NOT NULL,
  `passwordUser` varchar(255) NOT NULL,
  `alamatUser` varchar(255) NOT NULL,
  `statusUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`idUser`, `namaUser`, `usernameUser`, `passwordUser`, `alamatUser`, `statusUser`) VALUES
(2, 'Andhika Nugraha', 'andhikanugraha', '$2y$10$OAzeqQVxeE8hCDrl3UteGeLRBxSk0JEZcYHog/IFVdlovm6oTf54m', 'Jakarta Pusat', 'customer'),
(4, 'Raihan Maulana', 'raihanmaulana', '$2y$10$SMLaBDQKrr01WqIQluVq8ujyuoC.dQ6.KxXE5YQZsBbHA0BxdnNmy', 'Jakarta Barat', 'customer'),
(5, 'Aisyan Segara', 'aisyansegara', '$2y$10$Q3Olm4YrxIHIJ6Mxid2s7OZrFnjW06pi/i/hIZaWy435gI9AzVMeG', 'Bogor', 'admin'),
(7, 'Muhammad Rizky', 'mrizky', '$2y$10$qPNtwIV8wywE1pAB120h.uA4lwPY0zRgukIhV1t/IgyEOm6YxpoY.', 'Petamburan V', 'customer'),
(8, 'Agdi Priadi', 'agdi', '$2y$10$hcoOALXqYmg5abz18VhJ0.M4/qc.kcjCdlqFIKwxgoppHhuDEg6Jm', 'Jakarta Pusat', 'customer'),
(9, 'asd', 'asd', '$2y$10$vRGHiX5yDgRm9z9fM5uw0uPlBEY1PzQne/.gBko/D33CXItjAVRoy', 'sadas', 'customer'),
(10, 'budi', 'budiku', '$2y$10$o6I.Z7TjGXw8OB6Eqf218eEbDEE7P92ftpKWBQPApcG8j7vlWH2/m', 'Solo, Jawa Tengah', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  ADD PRIMARY KEY (`idPembelian`);

--
-- Indeks untuk tabel `tb_printers`
--
ALTER TABLE `tb_printers`
  ADD PRIMARY KEY (`idPrinter`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  MODIFY `idPembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_printers`
--
ALTER TABLE `tb_printers`
  MODIFY `idPrinter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
