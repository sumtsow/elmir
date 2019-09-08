-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 08 2019 г., 22:38
-- Версия сервера: 5.7.27-0ubuntu0.18.04.1
-- Версия PHP: 5.6.40-12+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `elmir`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `ip` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `text`, `ip`, `created_at`) VALUES
(1, 1, 'user 1', 'comment #1', '127.0.0.1', '2019-09-07 20:00:00'),
(2, 1, 'user 2', 'comment #2', '127.0.0.1', '2019-09-07 20:00:01'),
(3, 2, 'user 3', 'comment #3', '127.0.0.1', '2019-09-07 20:00:02'),
(4, 2, 'user 4', 'comment #4', '127.0.0.1', '2019-09-07 20:00:03'),
(5, 2, 'user 5', 'comment #5', '127.0.0.1', '2019-09-07 22:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `created_at`) VALUES
(1, 'xml_parser_create', '(PHP 4, PHP 5, PHP 7)\r\n\r\nxml_parser_create — Создание XML-анализатора\r\nОписание\r\nxml_parser_create ([ string $encoding ] ) : resource\r\n\r\nxml_parser_create() создает новый XML-анализатор и возвращает ссылающийся на него ресурс, который можно использовать в других XML-функциях.\r\n', '2019-09-07 14:00:00'),
(2, 'Исключения', '\r\n\r\nМодель исключений (exceptions) в PHP похожа с используемыми в других языках программирования. Исключение можно сгенерировать (выбросить) при помощи оператора throw, и можно перехватить (поймать) оператором catch. Код генерирующий исключение, должен быть окружен блоком try, для того, чтобы можно было перехватить исключение. Каждый блок try должен иметь как минимум один соответствующий ему блок catch или finally.\r\n\r\nГенерируемый объект должен принадлежать классу Exception или наследоваться от Exception. Попытка сгенерировать исключение другого класса приведет к фатальной ошибке PHP.\r\n', '2019-09-07 14:00:01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
