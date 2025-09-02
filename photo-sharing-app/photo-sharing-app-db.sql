-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 17, 2025 lúc 09:26 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `photo-sharing-app-db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `albums`
--

CREATE TABLE `albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `albums`
--

INSERT INTO `albums` (`id`, `user_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Phong canh', 'hinh anh phong  canh', '2025-08-11 09:03:20', '2025-08-11 09:03:20'),
(2, 1, 'Bản thân', 'Hình ảnh bản thân', '2025-08-11 09:03:39', '2025-08-11 09:03:39'),
(3, 1, 'Gia Đình', 'Hình ảnh gia đình', '2025-08-11 09:03:50', '2025-08-11 09:03:50'),
(4, 2, 'Album 1', 'Album 1', '2025-08-11 09:11:40', '2025-08-11 09:11:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album_user`
--

CREATE TABLE `album_user` (
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album_user`
--

INSERT INTO `album_user` (`album_id`, `user_id`) VALUES
(3, 2),
(3, 3),
(4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photo_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `photo_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'comment 1', '2025-08-11 09:06:52', '2025-08-11 09:06:52'),
(3, 1, 1, 'comment 234', '2025-08-11 09:07:21', '2025-08-11 09:07:21'),
(4, 1, 9, '222', '2025-08-11 09:14:38', '2025-08-11 09:14:38'),
(5, 2, 9, 'sss', '2025-08-11 09:16:06', '2025-08-11 09:16:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_11_102745_add_role_to_users_table', 2),
(6, '2025_08_11_102753_create_albums_table', 2),
(7, '2025_08_11_102801_create_photos_table', 2),
(8, '2025_08_11_102809_create_comments_table', 2),
(9, '2025_08_11_102830_create_album_user_pivot_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `photos`
--

INSERT INTO `photos` (`id`, `album_id`, `user_id`, `path`, `title`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'photos/LvUMfYX1bGd9dDQqESwXgaOTEXiDHA0I6ar9zYnW.png', 'Gia đình 1', '2025-08-11 09:04:31', '2025-08-11 09:04:31'),
(2, 3, 1, 'photos/mAWktkWGOOODD4iLRkqc3PVumG2rNAjvkthikTMy.png', 'Gia đình 2', '2025-08-11 09:04:43', '2025-08-11 09:04:43'),
(3, 3, 1, 'photos/4SeGNhhAT83SeMIO5rPhrDKzFsycBPVo96ycuVtN.png', 'Gia đình 3', '2025-08-11 09:04:58', '2025-08-11 09:04:58'),
(4, 2, 1, 'photos/TXpFetAlKufcfC9rmyMPplX89s256TTQY3zgOjZW.png', 'Tôi 1', '2025-08-11 09:05:19', '2025-08-11 09:05:19'),
(5, 2, 1, 'photos/x5rE1Y1lVbzpkH5sR9NqkCMYHSXcTHuB522RbNsV.png', 'Tôi 2', '2025-08-11 09:05:24', '2025-08-11 09:05:24'),
(6, 2, 1, 'photos/O7MJoi2HDwHyeHM4JlpZL80nodORB1klC2ghYGiw.png', 'Tôi 3', '2025-08-11 09:05:31', '2025-08-11 09:05:31'),
(7, 1, 1, 'photos/qce4F5cb4iV94a7XZ3un9ObMOVQ1NabmKatkPsNV.png', 'phong cảnh 1', '2025-08-11 09:05:58', '2025-08-11 09:05:58'),
(8, 1, 1, 'photos/rgsdOcHL4mzMX4l2wDxJo7bL9C5jg0Wp0mfHtd0l.png', 'phong cảnh 2', '2025-08-11 09:06:06', '2025-08-11 09:06:06'),
(9, 4, 2, 'photos/2wp6JxJSGFG6e75Fco6vHqerQhADHHR53D8heO0E.png', '111', '2025-08-11 09:11:49', '2025-08-11 09:11:49'),
(10, 4, 2, 'photos/GjsN1RIsfGWD2j8qiGUrHZIsGAWPh9cqW9M7r5Uk.png', '2', '2025-08-11 09:12:06', '2025-08-11 09:12:06'),
(11, 3, 1, 'photos/crhLRtxWDLhri3Mb1IZUCHoF1ZRzHZOTKBkLRWTi.png', '11', '2025-08-14 09:02:42', '2025-08-14 09:02:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Thai Tran', 'tranvietdanhthai@gmail.com', NULL, '$2y$10$zIHigpurjBktkBlcD/VMYOfYdpomfbKn6g8FBLKmVv3BHYVzfd0M2', NULL, '2025-08-11 08:52:33', '2025-08-11 08:52:33', 'user'),
(2, 'VIP', 'tranvietdanhthaiht@gamil.com', NULL, '$2y$10$Y4oijrN4hYYGo/JviydIJuXMwonxOoXSMHsRBm4/FDb0zYBkU1OIi', NULL, '2025-08-11 09:11:19', '2025-08-11 09:11:19', 'user'),
(3, 'aaaa', 'bin_boy_2001@yahoo.com.vn', NULL, '$2y$10$rJCtTkY42VI660vu5U6NEef4rE3.yb0X2OsPvbkI7./aCVQ9COoUm', NULL, '2025-08-16 23:40:16', '2025-08-16 23:40:16', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `album_user`
--
ALTER TABLE `album_user`
  ADD PRIMARY KEY (`album_id`,`user_id`),
  ADD KEY `album_user_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_photo_id_foreign` (`photo_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_album_id_foreign` (`album_id`),
  ADD KEY `photos_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `album_user`
--
ALTER TABLE `album_user`
  ADD CONSTRAINT `album_user_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_photo_id_foreign` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
