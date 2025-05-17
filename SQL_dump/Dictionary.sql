-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Час створення: Трв 14 2025 р., 19:26
-- Версія сервера: 5.7.39
-- Версія PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `Dictionary`
--

-- --------------------------------------------------------

--
-- Структура таблиці `dictionaries`
--

CREATE TABLE `dictionaries` (
  `id` int(11) NOT NULL,
  `source_language_id` int(11) NOT NULL,
  `target_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `dictionaries`
--

INSERT INTO `dictionaries` (`id`, `source_language_id`, `target_language_id`) VALUES
(1, 1, 2),
(2, 5, 2),
(3, 6, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`) VALUES
(1, 'English', 'en'),
(2, 'Ukraine', 'ua'),
(3, 'Russia', 'ru'),
(4, 'Romania', 'ro'),
(5, 'Czech', 'cz'),
(6, 'Poland', 'pl'),
(8, 'Slovakia', 'sl');

-- --------------------------------------------------------

--
-- Структура таблиці `translations`
--

CREATE TABLE `translations` (
  `id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `translated_text` varchar(255) NOT NULL,
  `target_language_id` int(11) NOT NULL,
  `dictionary_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `translations`
--

INSERT INTO `translations` (`id`, `word_id`, `translated_text`, `target_language_id`, `dictionary_id`) VALUES
(1, 10, 'Дивовижний ', 2, 1),
(2, 12, 'Кошеня', 2, 1),
(3, 13, 'Привітик', 2, 2),
(4, 14, 'До побачення', 2, 2),
(6, 11, 'Стривожений', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Роман', '$2y$10$4ELDQnJ6dG32f79OWMe7Lem8wVL1ECtnNAlE2/Z3CLm2zqrO1YI6W', 'admin'),
(5, 'Олександра', '$2y$10$hDWj.fZTDFWoFmW6GSEZIO54iLu8EpCpQQ2kGjB1kpbJx8fj2jw3G', 'admin'),
(9, 'Василь', '$2y$10$iQa7m.P2XSvqJErhsyJE9uzTteUlwHK5gKQiLX5Zm96VJTW8K2L5e', 'user'),
(10, 'Андрій', '$2y$10$aIOYevE3dyt.ni.b.iiGIeIb6WalBAgo4UX3AdPnUzQMkywGiezTC', 'user');

-- --------------------------------------------------------

--
-- Структура таблиці `user_saved_words`
--

CREATE TABLE `user_saved_words` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user_saved_words`
--

INSERT INTO `user_saved_words` (`id`, `user_id`, `word_id`) VALUES
(14, 10, 12),
(15, 1, 10),
(19, 1, 11),
(20, 1, 12),
(24, 1, 14);

-- --------------------------------------------------------

--
-- Структура таблиці `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `dictionary_id` int(11) NOT NULL,
  `word_text` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `words`
--

INSERT INTO `words` (`id`, `dictionary_id`, `word_text`, `language_id`) VALUES
(10, 1, 'Amazing', 1),
(11, 1, 'Anxious ', 1),
(12, 1, 'Kitten', 1),
(13, 2, 'Ahoi', 5),
(14, 2, 'Nashledanou', 5);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `dictionaries`
--
ALTER TABLE `dictionaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_language_id` (`source_language_id`),
  ADD KEY `target_language_id` (`target_language_id`);

--
-- Індекси таблиці `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Індекси таблиці `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `word_id` (`word_id`),
  ADD KEY `target_language_id` (`target_language_id`),
  ADD KEY `translations_ibfk_3` (`dictionary_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Індекси таблиці `user_saved_words`
--
ALTER TABLE `user_saved_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `word_id` (`word_id`);

--
-- Індекси таблиці `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dictionary_id` (`dictionary_id`),
  ADD KEY `language_id` (`language_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `dictionaries`
--
ALTER TABLE `dictionaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблиці `user_saved_words`
--
ALTER TABLE `user_saved_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблиці `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `dictionaries`
--
ALTER TABLE `dictionaries`
  ADD CONSTRAINT `dictionaries_ibfk_1` FOREIGN KEY (`source_language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dictionaries_ibfk_2` FOREIGN KEY (`target_language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_ibfk_1` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `translations_ibfk_2` FOREIGN KEY (`target_language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `translations_ibfk_3` FOREIGN KEY (`dictionary_id`) REFERENCES `dictionaries` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `user_saved_words`
--
ALTER TABLE `user_saved_words`
  ADD CONSTRAINT `user_saved_words_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_saved_words_ibfk_2` FOREIGN KEY (`word_id`) REFERENCES `words` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`dictionary_id`) REFERENCES `dictionaries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `words_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
