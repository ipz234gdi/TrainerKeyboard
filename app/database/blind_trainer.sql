-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 10 2025 г., 17:31
-- Версия сервера: 9.1.0
-- Версия PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blind_trainer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'Home Row'),
(1, 'Базові символи'),
(4, 'Пунктуація'),
(2, 'Розширені символи'),
(6, 'Спецсимволи'),
(3, 'Числа');

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `category_id` int DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `lang` enum('ua','en','','') NOT NULL,
  `rating` decimal(3,2) DEFAULT '0.00',
  `difficulty` enum('easy','medium','hard') DEFAULT 'medium',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `content`, `category_id`, `tags`, `lang`, `rating`, `difficulty`) VALUES
(2, 'Урок 2: Розширені символи', ';lkj fdsa ;lkj fdsa', 4, '', 'ua', 9.42, 'easy'),
(3, 'Урок 2: Розширені символи 2', 'qwerpoiu qwer poiu', NULL, '', 'ua', 9.29, 'easy'),
(4, 'Укр урок 1', 'Це провірка тексту', 1, '', 'ua', 9.03, 'medium'),
(5, '123', '1234567 123 234', 3, '', 'en', 8.93, 'medium'),
(7, 'Урок 1', 'gh gh gh hg hg hg', 1, '', 'en', 7.69, 'hard');

-- --------------------------------------------------------

--
-- Структура таблицы `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `wpm` int NOT NULL,
  `accuracy` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `stats`
--

INSERT INTO `stats` (`id`, `user_id`, `lesson_id`, `wpm`, `accuracy`, `created_at`) VALUES
(11, 1, 2, 21, 90.00, '2025-05-06 17:12:30'),
(12, 1, 2, 11, 86.00, '2025-05-06 17:12:40'),
(13, 1, 2, 11, 83.00, '2025-05-06 17:12:40'),
(14, 1, 2, 11, 79.00, '2025-05-06 17:12:40'),
(15, 1, 2, 11, 76.00, '2025-05-06 17:12:40'),
(16, 1, 3, 21, 90.00, '2025-05-06 18:08:38'),
(17, 1, 3, 11, 90.00, '2025-05-06 18:10:40'),
(30, 1, 4, 19, 86.00, '2025-05-07 06:46:24'),
(31, 1, 4, 38, 100.00, '2025-05-07 06:46:45'),
(32, 1, 5, 20, 100.00, '2025-05-07 07:06:14'),
(33, 1, 4, 25, 100.00, '2025-05-07 07:22:41'),
(34, 1, 4, 5, 18.00, '2025-05-07 07:23:28'),
(37, 1, 5, 26, 88.00, '2025-05-07 07:27:40'),
(41, 1, 5, 26, 94.00, '2025-05-07 13:38:54'),
(43, 1, 7, 49, 100.00, '2025-05-07 19:40:15'),
(44, 1, 7, 55, 81.00, '2025-05-07 19:43:59');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('student','teacher','administrator') NOT NULL DEFAULT 'student',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`, `blocked`) VALUES
(1, 'Reiclid', '$2y$10$NvkYMQE9dNV2ovgCSmKVme0.LreHhldC4g8MDQWGgUgNi1.B0KLKW', '2025-05-04 16:31:06', 'administrator', 0),
(2, 'Reiclid2', '$2y$10$ZFUDL.Z59BIAc3MFQEoLlufZ3kL9hbDe.HjgUvUjk6tAdcTxXVaBC', '2025-05-06 18:20:24', 'student', 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stats_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
