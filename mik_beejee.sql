-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.173:3308
-- Время создания: Май 01 2020 г., 17:12
-- Версия сервера: 5.5.62-38.14-log
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mik_beejee`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `task_id` varchar(13) NOT NULL DEFAULT '' COMMENT 'Unique task ID',
  `task_name` varchar(50) DEFAULT NULL COMMENT 'User name',
  `task_email` varchar(50) DEFAULT NULL COMMENT 'User email',
  `task_text` text COMMENT 'Task description',
  `task_status` tinyint(1) DEFAULT '0' COMMENT 'Task status',
  `task_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Current unixtime'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `task_email`, `task_text`, `task_status`, `task_timestamp`) VALUES
('5eac572862192', 'Mik', 'miksoft.tm@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales, mauris ut sagittis congue, libero mauris pellentesque sapien, feugiat elementum elit augue vel dui. Aenean.', 0, '2020-05-01 17:06:48'),
('5eac57493fe71', 'Mike', 'miksoft.tm@gmail.com', 'Praesent commodo, ex condimentum ornare ornare, ligula velit consequat dolor, nec porta turpis erat eu dolor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Suspendisse ultricies nisl non urna sollicitudin, sed sodales augue fermentum. Vivamus scelerisque condimentum mi, quis sodales nisi dapibus ut. Quisque viverra.', 0, '2020-05-01 17:07:21');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` varchar(13) NOT NULL DEFAULT '' COMMENT 'Unique user ID',
  `user_name` varchar(50) DEFAULT NULL COMMENT 'User name',
  `user_password` varchar(50) DEFAULT NULL COMMENT 'User password',
  `user_session` varchar(50) DEFAULT NULL COMMENT 'User session hash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_session`) VALUES
('5eac33809db80', 'admin', '202cb962ac59075b964b07152d234b70', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_id` (`task_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
