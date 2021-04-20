-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Ápr 20. 12:00
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `forum_szb13a`
--
CREATE DATABASE IF NOT EXISTS `forum_szb13a` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `forum_szb13a`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `datum` date DEFAULT current_timestamp(),
  `comment_text` varchar(280) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `thread_id`, `datum`, `comment_text`) VALUES
(1, 2, 1, '2021-04-01', 'OMG, you absolute madlad'),
(2, 3, 1, '2021-04-01', 'it\'s been an honour fighting hedies with you'),
(3, 4, 2, '2021-04-12', 'that\'s a cute cat'),
(4, 2, 2, '2021-04-13', 'i also hope we will see the end soon'),
(5, 3, 4, '2021-04-14', 'a beautiful story bro, but fake af'),
(6, 1, 5, '2021-04-13', 'I also think we should sanction these people'),
(7, 1, 1, '2021-04-20', 'teszt szöveg'),
(8, 2, 1, '2021-04-20', 'alma'),
(9, 3, 1, '2021-04-20', 'this is epic'),
(10, 2, 6, '2021-04-20', 'pics or didn\\\'t happen');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `threads`
--

CREATE TABLE `threads` (
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thread_date` date DEFAULT current_timestamp(),
  `thread_title` varchar(140) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `thread_text` varchar(280) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `threads`
--

INSERT INTO `threads` (`thread_id`, `user_id`, `thread_date`, `thread_title`, `thread_text`) VALUES
(1, 4, '2021-04-01', 'My final GME Update', 'It\'s been a pleasure gambling with you fellow apes'),
(2, 1, '2021-04-11', 'Getting really upset over here', 'Is Covid ever going to end?'),
(3, 1, '2021-04-09', 'I am bad with titles', 'Here is a picture of my cat'),
(4, 2, '2021-04-14', 'The story of a bench', 'I met my girlfriend here'),
(5, 3, '2021-04-13', 'I will get a lot of hate for this', 'I think covidiots should be prosecuted'),
(6, 1, '2021-04-20', 'I found a new stick', 'Hello everyone, I recently found a stick lying around');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`user_id`, `user_name`) VALUES
(1, 'greenApple133'),
(2, 'vicious_cat'),
(3, 'throwaway123'),
(4, 'DeepF_nValue');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `FK_comments_user_id` (`user_id`),
  ADD KEY `FK_comments_thread_id` (`thread_id`);

--
-- A tábla indexei `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `FK_threads_user_id` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comments_thread_id` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION;

--
-- Megkötések a táblához `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `FK_threads_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
