-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Nov 2024 pada 02.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `albums`
--

CREATE TABLE `albums` (
  `AlbumID` int(11) NOT NULL,
  `album_name` varchar(100) NOT NULL,
  `album_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `albums`
--

INSERT INTO `albums` (`AlbumID`, `album_name`, `album_description`, `created_at`) VALUES
(1, 'tatas', '', '2024-10-28 04:00:10'),
(2, 'kenangan', '', '2024-10-28 04:12:11'),
(3, 'kombet kenangan', '', '2024-10-28 04:25:37'),
(4, 'seribu kenangan', '', '2024-10-29 01:39:20'),
(5, 'ngawi 9', 'a', '2024-10-29 01:55:21'),
(6, 'kombet day', 'kaosdkwoakosdaindfjnret', '2024-10-29 01:59:36'),
(7, 'tatata', 'tatatata', '2024-10-29 02:01:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `FotoID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`CommentID`, `FotoID`, `UserID`, `comment`, `created_at`) VALUES
(0, 2, 6, 'AS', '2024-10-29 01:10:36'),
(0, 2, 6, 'waw\r\n', '2024-10-29 01:10:40'),
(0, 2, 21, 'keren', '2024-10-29 01:11:24'),
(0, 3, 21, 'gacor\r\n', '2024-10-29 01:12:26'),
(0, 1, 21, 'thats anjing man', '2024-10-29 01:19:05'),
(0, 5, 22, 'raja crypto', '2024-10-29 01:27:54'),
(0, 5, 22, 'asdwa', '2024-10-29 01:28:05'),
(0, 5, 23, 'kombet kerbo', '2024-10-29 01:28:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_foto`
--

CREATE TABLE `gallery_foto` (
  `FotoID` int(11) NOT NULL,
  `JudulFoto` varchar(100) NOT NULL,
  `DeskripsiFoto` text DEFAULT NULL,
  `LokasiFile` varchar(255) NOT NULL,
  `AlbumID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TanggalUnggah` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gallery_foto`
--

INSERT INTO `gallery_foto` (`FotoID`, `JudulFoto`, `DeskripsiFoto`, `LokasiFile`, `AlbumID`, `UserID`, `TanggalUnggah`) VALUES
(1, 'a', 'a', '671f11bc05c8e_gambar12.JPEG', 1, 6, '2024-10-28'),
(2, 'SEBUAH PELIHARAAN YANG LUCU', 'kombet namanya', '671f11e7772be_d37acc35053ff4939aa8855b19896bf4.jpg', 2, 6, '2024-10-28'),
(3, 'NIKAHAN', 'NIKAHAN\\r\\n', '671f144f6c6ca_gambar10.JPEG', 1, 6, '2024-10-28'),
(4, 'TA', 'TA', '671f146ccbde2_gambar12.JPEG', 3, 6, '2024-10-28'),
(5, 'kombet adm dunia maya', 'wkpaoksdoawkodw', '672039dabc978_ronald.jpg', 3, 22, '2024-10-29'),
(6, 'tim sial', 'asdwasdw', '672039f0c5433_Manchester-United-logo.png', 2, 22, '2024-10-29'),
(7, 'kombet nyesel', 'adwasd', '672041b215c01_nyesel.jpg', 6, 23, '2024-10-29'),
(8, 'sultans', 'sultans', '67204202804e7_nyesel.jpg', 2, 6, '2024-10-29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `likes`
--

CREATE TABLE `likes` (
  `LikeID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FotoID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `likes`
--

INSERT INTO `likes` (`LikeID`, `UserID`, `FotoID`) VALUES
(2, 6, 1),
(1, 6, 2),
(8, 6, 8),
(3, 21, 1),
(4, 21, 2),
(5, 21, 3),
(6, 22, 5),
(7, 23, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'riyan', 'muhammadrian1523@gmail.com', '$2y$10$KSg1CdnBVuu8.nT74VMFW.GtVM/K.73zfyyBnbU/u.OfXRn9lf9TK'),
(2, 'mapratama', 'odoi1523@gmail.com', '$2y$10$yoAxQCqaKu/YnOmIcWBt.uG768d4CnN/ZvdPWls62IzhKbSIZKQdW'),
(3, 'kurnia', 'kurnia@gmail.com', '$2y$10$VjVB2.eYKOLf0ygxxeZX5ebwnvEUr1DYiAmR9Opue4Cv9MGcRdgRy'),
(4, 'raka', 'raka@gmail.comn', '$2y$10$7um1WKR55ElXSIw3qdk7Suvv00ka943FrgjOH9ceipu4igrsfJHCm'),
(5, 'ryantujuh', 'ryan@gmail.com', '$2y$10$eLItrZ.svOfrG.b317KMV.wNN.uomJ6RrDhnOAKO37Mb9PFlA4dEC'),
(6, 'kombet', 'kombet@gmail.com', '$2y$10$urRX6/eXYpLR6JoFeR2y3uh08pSIkGwGCGWYUP03imVFD7cVxw9eG'),
(8, 'tatas', 'muhammad1523@gmail.com', '$2y$10$IywLao.0Xj2alrsinYt2YeOB6D/sF8RQ6RuShzNHcjU18JOtDygdK'),
(9, 'sultan', 'sultan@gmail.com', '$2y$10$lH7Sa/1hHmm23owIpJqHueJ6QHed3tmSoVn8eIkF2sz8TVeyDD.SW'),
(15, 'matias', 'matias@gmail.com', '$2y$10$2Ov5/ewyW4tzJmW9h2eL4.tIdSqA0Mk8OZuZkORC.cJUEckTb3IlG'),
(18, 'parpet', 'parpet@gmail.com', '$2y$10$oZkYz6dYHkcVQN5u3kfXpOkzmSgNWEUk7yQgwTdZLPKBOqgRDzvOa'),
(19, 'kombeetAdminDuniaMaya', 'tuku@gmail.com', '$2y$10$TsR/sQ1cwzEJwnZv1iylzOFLqahRjK.9UmkkrSlcTHGd4DxkNVZGK'),
(20, 'kombetAdminDuniaMaya', 'kurkur@gmail.com', '$2y$10$rUsRh5urt2KD8rBpGflJfOk5TLeOLfYZ6L3esb0.Ft/aJbmTvk6nm'),
(21, 'MATT', 'matt@gmail.com', '$2y$10$Ea9G.Kaa7MOKnFDDGSMTMeGI3GzRF7D.x44P6lmKg9798ABEAXNvK'),
(22, 'kombetking', 'kombets@gmail.com', '$2y$10$VLPHMfx87MD18DDonSLXJeU7/KJTs8N9jdHRo0TD95a7CAnir1rOS'),
(23, 'riyanntujuh', 'riyan@gmail.com', '$2y$10$OSspN3cLNUptGRcFw0V0N.U.bhNzEymVrGx58GBws.Nxc4P3XVdlG'),
(24, 'user4', 'user@ff', '$2y$10$A3y0GVNJP87I/M7im0M1WOTN8pJXbT19g/1CPTH03QjH2MQKeNFd2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`AlbumID`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD KEY `fk_user_id` (`UserID`);

--
-- Indeks untuk tabel `gallery_foto`
--
ALTER TABLE `gallery_foto`
  ADD PRIMARY KEY (`FotoID`);

--
-- Indeks untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`LikeID`),
  ADD UNIQUE KEY `UserID` (`UserID`,`FotoID`),
  ADD KEY `FotoID` (`FotoID`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `albums`
--
ALTER TABLE `albums`
  MODIFY `AlbumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `gallery_foto`
--
ALTER TABLE `gallery_foto`
  MODIFY `FotoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `LikeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`FotoID`) REFERENCES `gallery_foto` (`FotoID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
