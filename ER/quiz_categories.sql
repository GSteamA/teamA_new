-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2024 年 12 月 24 日 08:56
-- サーバのバージョン： 8.0.32
-- PHP のバージョン: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `laravel`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `quiz_categories`
--

CREATE TABLE `quiz_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `quiz_categories`
--

INSERT INTO `quiz_categories` (`id`, `name`, `display_name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'culture', '文化', 'culture-quiz', '2024-12-23 16:38:10', '2024-12-23 16:38:10'),
(2, 'history', '歴史', 'history-quiz', '2024-12-23 16:38:10', '2024-12-23 16:38:10'),
(3, 'language', 'ことば', 'language-quiz', '2024-12-23 16:38:10', '2024-12-23 16:38:10'),
(4, 'people', '人物', 'people-quiz', '2024-12-23 16:38:10', '2024-12-23 16:38:10'),
(5, 'economy', '経済', 'economy-quiz', '2024-12-23 16:38:10', '2024-12-23 16:38:10');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `quiz_categories`
--
ALTER TABLE `quiz_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quiz_categories_code_unique` (`code`),
  ADD KEY `quiz_categories_code_index` (`code`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `quiz_categories`
--
ALTER TABLE `quiz_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
