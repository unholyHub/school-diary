-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql204.infinityfree.com
-- Generation Time: Sep 09, 2023 at 03:47 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_34620676_school_diary`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `div_char` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `number`, `div_char`) VALUES
(1, 10, 'а'),
(2, 5, 'б'),
(4, 8, 'а'),
(6, 10, 'б'),
(8, 1, 'а'),
(9, 4, 'а'),
(10, 12, 'а'),
(11, 5, 'а'),
(12, 9, 'а'),
(13, 9, 'б'),
(14, 2, 'а'),
(15, 2, 'б'),
(16, 1, 'б'),
(17, 3, 'а'),
(18, 3, 'б'),
(19, 4, 'б'),
(20, 6, 'а'),
(21, 6, 'б'),
(22, 7, 'а'),
(23, 7, 'б'),
(24, 8, 'б'),
(25, 11, 'а'),
(26, 11, 'б'),
(27, 12, 'б'),
(42, 12, 'в');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `sent_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from_user_id`, `to_user_id`, `message`, `sent_on`) VALUES
(1, 2, 30, 'Написано съобщение №1', '2023-07-20 18:27:13'),
(2, 2, 30, 'Не ми купи кафе', '2023-07-21 12:25:00'),
(3, 2, 30, 'Подготвя преврат', '2023-07-21 12:27:00'),
(4, 2, 30, 'Не слуша в час', '2023-07-21 12:31:00'),
(5, 2, 37, 'Кой е Супермен всъщност?', '2023-07-21 12:33:00'),
(6, 2, 36, 'Кога ще е готов сценарият, Драго?', '2023-07-21 13:24:00'),
(7, 2, 33, 'Не може да е ученик', '2023-07-21 14:34:00'),
(8, 2, 30, 'Какво стана с преврата??', '2023-07-23 17:22:00'),
(9, 2, 37, 'Най-добрият супер герой който света е видял или ще види да 2012 година', '2023-07-23 19:19:00'),
(13, 44, 28, 'Кой е първият демократично избран президент на България?', '2023-07-25 07:38:00'),
(14, 44, 43, 'Не си предала бележка за отсъствията.', '2023-07-25 14:32:00'),
(16, 44, 32, 'Възраждане на една нация', '2023-07-26 08:20:00'),
(17, 2, 47, 'Зззз1', '2023-07-27 10:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'teacher'),
(3, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `min_starting_grade` int(2) NOT NULL DEFAULT 1,
  `max_ending_grade` int(2) NOT NULL DEFAULT 0,
  `is_main` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `min_starting_grade`, `max_ending_grade`, `is_main`) VALUES
(1, 'Математика', 1, 1, 1),
(2, 'Музика', 1, 11, 1),
(3, 'Български език и литература', 1, 12, 1),
(4, 'Родинознание', 1, 1, 1),
(5, 'Изобразително изкуство', 1, 5, 1),
(6, 'Технологии и предприемачество', 1, 7, 1),
(7, 'Физическо възпитание и спорт', 1, 12, 1),
(9, 'Английски език', 2, 12, 1),
(10, 'Околен свят', 2, 2, 1),
(11, 'Компютърно моделиране', 3, 4, 1),
(12, 'Човекът и общество', 3, 4, 1),
(13, 'Човекът и природата', 5, 6, 1),
(14, 'История и цивилизация', 5, 8, 1),
(15, 'География и икономика', 5, 11, 1),
(16, 'Биология и здравно образование', 7, 10, 1),
(17, 'Физика и астрономия', 7, 10, 1),
(33, 'Компютърно моделиране и информационни технологии', 5, 6, 1),
(34, 'Предмета на истината', 1, 1, 2),
(36, 'Информационни технологии', 7, 10, 1),
(37, 'Химия и опазване на околната среда', 7, 10, 1),
(38, 'Философия', 8, 12, 1),
(39, 'Испански език', 9, 12, 1),
(40, 'Свят и личност', 12, 12, 1),
(41, 'Екологично законодателство', 12, 12, 1),
(42, 'Екологичен мониторинг', 12, 12, 1),
(43, 'Агроекология', 11, 11, 1),
(44, 'Аналитична химия и инструментални методи за анализ', 12, 12, 1),
(51, 'Френски', 11, 12, 1),
(52, 'История и цивилизация', 9, 11, 1),
(54, 'Математика', 12, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_schedules`
--

CREATE TABLE `subject_schedules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `program_slot` int(11) DEFAULT NULL,
  `program_time_start` time DEFAULT NULL,
  `program_time_end` time DEFAULT NULL,
  `day` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_schedules`
--

INSERT INTO `subject_schedules` (`id`, `user_id`, `subject_id`, `class_id`, `program_slot`, `program_time_start`, `program_time_end`, `day`) VALUES
(29, 2, 6, 2, 5, '11:55:00', '12:35:00', 3),
(30, 2, 6, 8, 2, '11:00:00', '11:40:00', 2),
(32, 2, 1, 6, 2, '10:30:00', '11:10:00', 1),
(33, 2, 1, 6, 5, '11:10:00', '11:50:00', 1),
(36, 2, 1, 9, 4, '13:00:00', '13:40:00', 5),
(37, 2, 6, 6, 3, '12:00:00', '12:40:00', 1),
(44, 2, 2, 8, 1, '08:00:00', '08:40:00', 1),
(45, 2, 2, 8, 1, '08:00:00', '08:40:00', 2),
(46, 2, 3, 8, 4, '10:30:00', '11:10:00', 1),
(49, 14, 1, 11, 4, '09:00:00', '09:40:00', 2),
(50, 2, 34, 8, 3, '09:40:00', '10:20:00', 2),
(52, 44, 11, 17, 1, '08:00:00', '08:40:00', 1),
(53, 44, 33, 11, 2, '08:50:00', '09:30:00', 1),
(58, 44, 33, 11, 3, '09:40:00', '10:20:00', 2),
(59, 44, 11, 17, 4, '10:30:00', '11:10:00', 2),
(60, 44, 11, 17, 4, '10:30:00', '11:10:00', 3),
(63, 62, 17, 1, 1, '08:00:00', '08:40:00', 2),
(65, 62, 14, 25, 3, '09:40:00', '10:20:00', 5),
(66, 2, 16, 22, 3, '09:40:00', '10:20:00', 2),
(67, 2, 1, 8, 3, '09:40:00', '10:20:00', 3),
(68, 2, 3, 8, 3, '09:40:00', '10:20:00', 5),
(69, 62, 14, 20, 3, '09:40:00', '10:20:00', 5),
(70, 44, 11, 17, 7, '13:00:00', '13:40:00', 5),
(71, 62, 44, 10, 4, '10:30:00', '11:10:00', 4),
(72, 62, 17, 1, 1, '08:00:00', '08:40:00', 1),
(73, 62, 17, 1, 2, '09:00:00', '09:40:00', 1),
(74, 62, 17, 1, 2, '09:00:00', '09:40:00', 1),
(75, 62, 17, 22, 2, '09:00:00', '09:40:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_topics`
--

CREATE TABLE `subject_topics` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `week` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_topics`
--

INSERT INTO `subject_topics` (`id`, `subject_id`, `name`, `week`) VALUES
(1, 9, 'Въведение в английският език', 3),
(26, 4, 'Области в България', 1),
(27, 6, 'Увод в технологиите и предприемачеството', 1),
(29, 9, 'Азбука', 1),
(36, 33, 'Увод', 1),
(42, 17, 'Нещо', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `phone_number` varchar(100) NOT NULL,
  `parent_email` varchar(200) DEFAULT NULL,
  `profile_picture` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `class_id`, `phone_number`, `parent_email`, `profile_picture`) VALUES
(1, 'admin', 'admin', 'Иван', 'Кирков', NULL, '0923123', NULL, '64b66cf0b4637_student2.jpg'),
(2, 'mod', 'mod', 'Никола', 'Бабунски', NULL, '0888625433', NULL, '64bc2a1cd71b3_64b669e22cbb2_admin.jpg'),
(3, 'teacher1', 'teacher1', 'Вълко', 'Червенков', NULL, '123456789', NULL, '64b6ad04b1473_teacher.jpg'),
(5, 'student23', 'student23', 'Петър', 'Младенов', NULL, '+359 999 999 199', 'john@example.com', '64bc2a6a4b046_64b6bfb8707d7_student4.jpg'),
(14, 'Erikauser1', 'Erikauser1', 'Ботьо', 'Петков', NULL, '3131', NULL, '64b8345bd80d6_Untitled.jpg'),
(27, 'student1', 'student1', 'Йордан', 'Карагегов', NULL, '+359 999 223 147', '', '64be8e957a41d_student3.jpg'),
(28, 'student4', 'student4', 'Георги', 'Първанов', NULL, '+359 999 103 199', 'email@example.com', '64c096feeeea5_student_4.jpg'),
(29, 'student2', 'student2', 'Мате', 'Булев', NULL, '+359 999 103 941', 'email@example.com', '64c09731398f6_student2.jpg'),
(30, 'student3', 'student3', 'Ивайло', 'Андонов', NULL, '+359 999 103 432', 'email@example.com', '64b6ad34da231_student6.jpg'),
(31, 'student69', 'fsdsfdfdas', 'Костадин', 'Торков', NULL, '+359 999 103 199', 'email@example.com', '64b864a9c0b0d_Untitled.jpg'),
(32, 'student512', 'student512', 'Костадин', 'Костадинов', NULL, '+359 999 103 199', 'email@example.com', '64b6aa8e11c21_student4.jpg'),
(33, 'student87', 'student99', 'Георги ', 'Урдов', NULL, '+359 999 103 432', 'email@example.com', '64b6bfb8707d7_student4.jpg'),
(36, 'student36', 'student36', 'Драгомир', 'Петров', NULL, '+3561581652', NULL, '64b910ea7a9f1_student4.jpg'),
(37, 'hen1', '1234', 'Хенри', 'Кавил', NULL, '0888424756', 'mama@abv.bg', '64b9190e3f343_t.jpg'),
(38, 'kvot_mi_doide', 'kvot_mi_doide', 'kvot_mi_doide', 'kvot_mi_doide', NULL, 'kvot_mi_doide', NULL, '64be8cb3b9117_student4.jpg'),
(39, 'kvot_mi_doide', '111', 'име', 'фамилия', NULL, '0823123', 'email@example.com', '64be8d876e4f0_student6.jpg'),
(40, 'kvot_mi_doide12', 'kvot_mi_doide12', 'Кирил', 'Джоджев', NULL, '02154685', 'greta@gmail.com', NULL),
(42, 'defo', '3256', 'Данаил', 'Венчов', NULL, '0888884777', NULL, '64bea43aa8c27_08de774c11d89cb3f4ecf600a33e9c8283-24-keanu-reeves.rsquare.w700.webp'),
(43, 'rum', '1111', 'Милена', 'Руменова', NULL, '0878325789', 'pufi@abv.bg', '64bfe092cf862_milena.jpg'),
(44, 'ros', 'ros', 'Росиян', 'Радослав', NULL, '0878500400', NULL, '64bf5b9bf2aa9_teacher.jpg'),
(45, 'stef', 'stef', 'Стефан', 'Първанов', NULL, '0879794512', 'mimi@abv.bg', NULL),
(46, 'dori', 'dori', 'Теодора', 'Александрова', NULL, '0888555111', 'sfd@abv.bg', '64bfe07513a35_teodora.jpg'),
(47, 'hell_student', 'hell_student', 'Хан', 'Хел', NULL, '256489547', 'min@gmail.com', '64bf97f8af2c7_student6.jpg'),
(48, 'nani', '1111', 'Найден', 'Емилов', NULL, '0889787572', 'ma@abv.bg', '64bfb572a1fe6_9c6edc88909dd71c8f1303a8d84a8532.jpg'),
(49, 'stan', '8512', 'Станислав', 'Стоев', NULL, '0889531249', 'eli@abv.bg', NULL),
(50, 'shani', '5621', 'Шарлот', 'Илиева', NULL, '2356485975', 'mira@abv.bg', NULL),
(51, 'sani', '56321', 'Санела', 'Димитрова', NULL, '5624892145', NULL, NULL),
(52, 'deni', '3355', 'Деан', 'Георгиев', NULL, '0985664220', NULL, NULL),
(53, 'pepi', '88664', 'Петър', 'Драганов', NULL, '3254789642', NULL, NULL),
(54, 'dani', '62222', 'Дамян', 'Дамянов', NULL, '6532', 'rr@gmail.com', NULL),
(55, 'ira', 'ira', 'Ирина', 'Димитрашкова', NULL, '2358', NULL, NULL),
(56, 'dari', 'dari', 'Дарина', 'Томова', NULL, '63258741', NULL, NULL),
(57, 'lubi', '22222', 'Любомир', 'Груев', NULL, '46521', NULL, NULL),
(58, 'kal', 'kal', 'Калоян', 'Страхилов', NULL, '652148', NULL, NULL),
(59, 'ani', 'ani', 'Анна', 'Борисова', NULL, '56214789', NULL, NULL),
(60, 'sisi', 'sisi', 'Симона', 'Симеонова', NULL, '56214789', NULL, NULL),
(61, 'didi', 'didi', 'Даниела', 'Калинова', NULL, '256489', NULL, NULL),
(62, 'andi', 'andi', 'Андреа', 'Костова', NULL, '0897563214', NULL, '64bfcef6f009b_.jpg'),
(63, 'tina', '0000', 'Валентина', 'Киркова', NULL, '0899630000', NULL, NULL),
(64, 'kremi', 'kr', 'Кремена', 'Ангелова', NULL, '65121651312', NULL, NULL),
(65, 'evi', 'evi', 'Евгени', 'Естатиев', NULL, '35463435', NULL, NULL),
(66, 'simo', 'simo', 'Симеон', 'Първолецов', NULL, '3546374', NULL, NULL),
(68, 'dima', 'dima', 'Димитрина', 'Тодорова', NULL, '3756890', NULL, NULL),
(69, 'iivan', 'iivan', 'iivan', 'iivan', NULL, 'iivan', NULL, NULL),
(70, 'dan', '@A34?', 'Дани', 'Даниелов', NULL, '256489654', NULL, NULL),
(71, 'sergo', 'sergo', 'Серго', 'Серго', NULL, '345', NULL, NULL),
(72, 'ina', 'ina', 'Ина', 'Ина', NULL, '657', NULL, NULL),
(73, 'rrr', 'rrr', 'Румен', 'Руменов', NULL, '0899001002', NULL, '64fb4d2d87b4c_defo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_absences`
--

CREATE TABLE `users_absences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `is_full` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_absences`
--

INSERT INTO `users_absences` (`id`, `user_id`, `subject_id`, `is_full`, `created_on`) VALUES
(4, 37, 4, 0, '2023-07-23 17:08:00'),
(5, 37, 6, 1, '2023-07-23 17:44:00'),
(6, 37, 2, 0, '2023-07-23 19:23:00'),
(8, 32, 17, 0, '2023-07-25 23:59:00'),
(10, 50, 1, 1, '2023-07-26 08:36:00'),
(11, 60, 14, 1, '2023-07-27 20:03:00'),
(12, 54, 14, 1, '2023-07-27 20:41:00'),
(13, 28, 1, 1, '2023-08-01 09:00:00'),
(17, 73, 1, 1, '2023-09-01 09:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_grades`
--

CREATE TABLE `users_grades` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `final_grade` int(11) DEFAULT NULL,
  `term` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_grades`
--

INSERT INTO `users_grades` (`id`, `user_id`, `subject_id`, `grade`, `final_grade`, `term`) VALUES
(35, 37, 1, 2, NULL, 1),
(36, 37, 1, 6, NULL, 1),
(37, 37, 6, 5, NULL, 1),
(38, 37, 1, 5, NULL, 1),
(39, 37, 1, 4, NULL, 1),
(40, 37, 1, 3, NULL, 1),
(41, 37, 1, NULL, 4, 3),
(42, 37, 1, NULL, 4, 1),
(43, 37, 1, 6, NULL, 2),
(44, 37, 1, 3, NULL, 2),
(45, 37, 6, 4, NULL, 2),
(46, 37, 1, NULL, 4, 2),
(47, 37, 6, 3, NULL, 1),
(48, 37, 6, 5, NULL, 2),
(49, 37, 6, 3, NULL, 1),
(50, 37, 2, 5, NULL, 1),
(51, 37, 2, NULL, 5, 1),
(52, 37, 2, 6, NULL, 2),
(53, 37, 2, NULL, 5, 3),
(54, 37, 2, NULL, 5, 2),
(57, 37, 3, 4, NULL, 1),
(58, 37, 3, 6, NULL, 1),
(59, 37, 3, NULL, 5, 1),
(60, 37, 3, 3, NULL, 2),
(61, 37, 3, 3, NULL, 2),
(62, 37, 3, 4, NULL, 2),
(63, 37, 3, NULL, 4, 3),
(64, 37, 6, 6, NULL, 2),
(65, 37, 3, 4, NULL, 2),
(66, 37, 6, 4, NULL, 2),
(67, 37, 6, 6, NULL, 2),
(68, 37, 6, 4, NULL, 2),
(69, 37, 6, 6, NULL, 2),
(70, 37, 6, NULL, 5, 3),
(71, 29, 1, 4, NULL, 1),
(72, 29, 1, NULL, 4, 1),
(73, 29, 1, 5, NULL, 2),
(74, 29, 1, 4, NULL, 2),
(75, 29, 1, NULL, 5, 3),
(76, 29, 1, NULL, 5, 2),
(77, 37, 6, 4, NULL, 1),
(78, 37, 6, 3, NULL, 2),
(81, 36, 16, 6, NULL, 1),
(82, 36, 16, NULL, 6, 1),
(83, 36, 16, 6, NULL, 2),
(84, 36, 16, 4, NULL, 2),
(85, 36, 16, NULL, 5, 3),
(86, 36, 16, NULL, 5, 2),
(88, 43, 44, 5, NULL, 1),
(89, 43, 44, 5, NULL, 1),
(90, 43, 44, NULL, 5, 1),
(91, 43, 44, 5, NULL, 2),
(92, 43, 44, NULL, 5, 2),
(93, 43, 44, NULL, 5, 3),
(94, 60, 14, 4, NULL, 1),
(95, 37, 6, NULL, 5, 2),
(96, 37, 6, NULL, 5, 1),
(97, 37, 34, 6, NULL, 1),
(98, 37, 34, NULL, 5, 1),
(99, 50, 11, 5, NULL, 1),
(100, 50, 11, NULL, 4, 1),
(101, 50, 11, 5, NULL, 2),
(102, 50, 11, 4, NULL, 2),
(103, 50, 11, NULL, 5, 2),
(104, 50, 11, NULL, 5, 3),
(105, 54, 1, 6, NULL, 1),
(106, 54, 1, NULL, 6, 1),
(107, 54, 1, 6, NULL, 2),
(108, 54, 1, NULL, 6, 2),
(109, 54, 1, NULL, 6, 3),
(110, 57, 2, 6, NULL, 1),
(111, 57, 2, NULL, 6, 1),
(112, 57, 2, 5, NULL, 2),
(113, 57, 2, NULL, 5, 2),
(114, 57, 2, NULL, 6, 3),
(116, 54, 33, 5, NULL, 1),
(117, 54, 33, NULL, 5, 1),
(118, 54, 33, 6, NULL, 2),
(119, 54, 33, NULL, 6, 2),
(120, 54, 33, NULL, 6, 3),
(121, 30, 17, 6, NULL, 1),
(123, 32, 17, 5, NULL, 1),
(125, 37, 4, 2, NULL, 1),
(126, 37, 4, 3, NULL, 1),
(128, 30, 14, 3, NULL, 1),
(129, 30, 14, 3, NULL, 2),
(130, 28, 1, 4, NULL, 1),
(131, 28, 1, 4, NULL, 1),
(132, 28, 1, 4, NULL, 1),
(133, 73, 1, 5, NULL, 1),
(134, 73, 1, 5, NULL, 1),
(135, 73, 1, NULL, 5, 1),
(136, 73, 1, 5, NULL, 2),
(137, 73, 1, 6, NULL, 2),
(138, 73, 1, NULL, 5, 2),
(139, 73, 1, NULL, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_classes`
--

CREATE TABLE `user_classes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_classes`
--

INSERT INTO `user_classes` (`id`, `user_id`, `class_id`) VALUES
(13, 30, 4),
(15, 31, 1),
(16, 28, 4),
(17, 33, 1),
(18, 37, 8),
(20, 36, 22),
(21, 32, 22),
(22, 27, 6),
(24, 39, 8),
(25, 5, 22),
(28, 42, 1),
(29, 43, 10),
(30, 45, 10),
(31, 46, 10),
(35, 47, 23),
(38, 48, 14),
(39, 49, 14),
(40, 50, 17),
(41, 51, 17),
(42, 52, 9),
(43, 53, 9),
(44, 54, 11),
(45, 55, 11),
(46, 56, 20),
(47, 57, 20),
(49, 59, 12),
(50, 60, 25),
(51, 61, 25),
(52, 40, 20),
(54, 73, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(5, 5, 3),
(6, 27, 3),
(7, 28, 3),
(8, 29, 3),
(9, 30, 3),
(10, 31, 3),
(11, 32, 3),
(12, 33, 3),
(14, 14, 2),
(15, 36, 3),
(16, 37, 3),
(18, 39, 3),
(19, 40, 3),
(21, 42, 3),
(22, 43, 3),
(23, 44, 2),
(24, 45, 3),
(25, 46, 3),
(26, 47, 3),
(27, 48, 3),
(28, 49, 3),
(29, 50, 3),
(30, 51, 3),
(31, 52, 3),
(32, 53, 3),
(33, 54, 3),
(34, 55, 3),
(35, 56, 3),
(36, 57, 3),
(37, 58, 3),
(38, 59, 3),
(39, 60, 3),
(40, 61, 3),
(41, 62, 2),
(42, 63, 1),
(43, 64, 2),
(44, 65, 3),
(45, 66, 3),
(47, 68, 2),
(48, 69, 3),
(49, 70, 3),
(50, 71, 3),
(51, 72, 2),
(52, 73, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_subjects`
--

CREATE TABLE `user_subjects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_subjects`
--

INSERT INTO `user_subjects` (`id`, `user_id`, `subject_id`) VALUES
(7, 3, 13),
(8, 3, 15),
(9, 3, 16),
(12, 3, 14),
(35, 44, 33),
(36, 44, 11),
(44, 62, 17),
(45, 62, 14),
(47, 62, 44),
(48, 64, 17),
(49, 62, 51),
(51, 68, 14),
(82, 2, 16),
(86, 2, 1),
(88, 72, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`from_user_id`),
  ADD KEY `messages_ibfk_2` (`to_user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_schedules`
--
ALTER TABLE `subject_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_schedules_ibfk_1` (`user_id`),
  ADD KEY `subject_schedules_ibfk_2` (`subject_id`),
  ADD KEY `subject_schedules_ibfk_3` (`class_id`);

--
-- Indexes for table `subject_topics`
--
ALTER TABLE `subject_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_absences`
--
ALTER TABLE `users_absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_absences_ibfk_1` (`user_id`),
  ADD KEY `users_absences_ibfk_2` (`subject_id`);

--
-- Indexes for table `users_grades`
--
ALTER TABLE `users_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_grades_current_ibfk_1` (`user_id`),
  ADD KEY `users_grades_current_ibfk_2` (`subject_id`);

--
-- Indexes for table `user_classes`
--
ALTER TABLE `user_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_subjects`
--
ALTER TABLE `user_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `subject_schedules`
--
ALTER TABLE `subject_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `subject_topics`
--
ALTER TABLE `subject_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users_absences`
--
ALTER TABLE `users_absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users_grades`
--
ALTER TABLE `users_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `user_classes`
--
ALTER TABLE `user_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_subjects`
--
ALTER TABLE `user_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_schedules`
--
ALTER TABLE `subject_schedules`
  ADD CONSTRAINT `subject_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_schedules_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_schedules_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_topics`
--
ALTER TABLE `subject_topics`
  ADD CONSTRAINT `subject_topics_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_absences`
--
ALTER TABLE `users_absences`
  ADD CONSTRAINT `users_absences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_absences_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_grades`
--
ALTER TABLE `users_grades`
  ADD CONSTRAINT `users_grades_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_classes`
--
ALTER TABLE `user_classes`
  ADD CONSTRAINT `user_classes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_classes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_subjects`
--
ALTER TABLE `user_subjects`
  ADD CONSTRAINT `user_subjects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
