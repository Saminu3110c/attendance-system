-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 02:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL DEFAULT curdate(),
  `attendance_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `course_id`, `attendance_date`, `attendance_time`) VALUES
(1, 2, 3, '2025-05-29', '2025-05-29 12:05:39'),
(2, 3, 3, '2025-05-29', '2025-05-29 12:38:52'),
(3, 4, 3, '2025-06-02', '2025-06-02 13:29:10'),
(4, 2, 1, '2025-06-02', '2025-06-02 14:18:03'),
(5, 4, 1, '2025-06-02', '2025-06-02 14:22:41'),
(6, 2, 3, '2025-06-02', '2025-06-02 14:29:38'),
(7, 3, 4, '2025-06-02', '2025-06-02 14:53:53'),
(8, 2, 4, '2025-06-02', '2025-06-02 14:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `title`, `teacher_id`) VALUES
(1, 'Math101', 'General Mathematics', 1),
(3, 'Math103', 'Basic Calculus', 4),
(4, 'GENS101', 'Genaral Studies I', 6);

-- --------------------------------------------------------

--
-- Table structure for table `course_activations`
--

CREATE TABLE `course_activations` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_activations`
--

INSERT INTO `course_activations` (`id`, `course_id`, `teacher_id`, `start_time`, `end_time`) VALUES
(1, 1, 1, '2025-05-29 02:40:00', '2025-05-29 03:00:00'),
(2, 3, 4, '2025-05-29 10:50:00', '2025-05-29 11:50:00'),
(3, 3, 4, '2025-05-29 12:00:00', '2025-05-29 14:00:00'),
(4, 1, 1, '2025-05-29 12:30:00', '2025-05-29 13:00:00'),
(5, 1, 1, '2025-05-29 12:30:00', '2025-05-29 13:30:00'),
(6, 1, 1, '2025-05-29 14:10:00', '2025-05-29 14:20:00'),
(7, 3, 4, '2025-06-02 12:52:00', '2025-06-02 13:00:00'),
(8, 3, 4, '2025-06-02 13:06:00', '2025-06-02 13:30:00'),
(9, 1, 1, '2025-06-02 14:17:00', '2025-06-02 14:30:00'),
(10, 3, 4, '2025-06-02 14:26:00', '2025-06-02 14:30:00'),
(11, 4, 6, '2025-06-02 14:52:00', '2025-06-02 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `course_assignments`
--

CREATE TABLE `course_assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `department`, `level`, `email`, `password`) VALUES
(2, 'SCI22BTC001', 'Saminu Isah', 'Computer Engineering', '100L', 'saminu3110c@gmail.com', '$2y$10$dS8Qe.K/.FxCULGa.wsCpeqBrPVFEz9PS9..GxLaVRrqWSPSl2rda'),
(3, 'SCI22BTC002', 'Fatima Usman', 'Electrical Engineering', '200l', 'fatimausman@gmail.com', '$2y$10$SlIREEp3oT9LVcz1m9mrluXuSdMUw71DXDfpz4.Q2Ad7vkX7gYMni'),
(4, 'SCI22BTC003', 'Adamu Yahaya', 'Mechanical Engineering', '100L', 'adamuyahaya@gmail.com', '$2y$10$UagtgGbcewTbyFo29PHoGuB7cZPadsrRZcKMvlrMgwta80efM4PHK'),
(5, 'SCI22BTC004', 'Hauwa Sani', 'Computer Engineering', '100L', 'hauwasani@gmail.com', '$2y$10$uJePZNJqR2ihzCeCMd1XgO8jgTClALFbNvKXGm22qKFYeQG9w4Rxu'),
(6, 'SCI21BCT005', 'Aliyu Musa', 'Computer Science', '100', 'aliyumusa@gmail.com', '$2y$10$MSQKH7wdP6aRxfN4iSrMden6lmL34GEdIyf4hfjRAoCflYrybjXpi'),
(7, 'SCI21BCT006', 'Hauwa Bello', 'Information Tech', '200', 'hauwabello@gmail.com', '$2y$10$VNgSK3I8rDpek/ezbFZkWup3bgYiIZqYWoFlnwrSV.XqAunFPMgku'),
(8, 'SCI21BCT007', 'Garba Musa', 'Computer Science', '100', 'garbamusa@gmail.com', NULL),
(9, 'SCI21BCT008', 'Yakubu Bello', 'Information Tech', '200', 'Yakububello@gmail.com', NULL),
(10, 'SCI21BCT009', 'Halima Umar', 'Computer Science', '100', 'halimaumar@gmail.com', NULL),
(11, 'SCI21BCT010', 'Hajara Adamu', 'Information Tech', '200', 'hajaraadamu@gmail.com', NULL),
(13, 'SCI21BCT012', 'Haruna Garba', 'Computer Engineering', '200', 'harunagarba@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_id`, `name`, `email`, `password`) VALUES
(1, 'P.1001', 'Adamu Abubakar', 'adamuabubakar@gmail.com', '$2y$10$6TGXyQeCqKWHbnNhbDKdlOJHxZZgcWN0jb8L.ChXPE/Yo2vULqcTu'),
(4, 'P.1000', 'Jamila Adamu', 'jamila@gmail.com', '$2y$10$Ulwx5FXGUi/HevCKmMDTNe1uXX5lBTwDYJU08Pr8DTxS3AeJ96d96'),
(6, 'P.1003', 'Musa Isah', 'musaisah@gmail.com', '$2y$10$dwIiZYKjfxbtGc9c7.gUoOjCxe075Oak2tBy7.QKtAT9LPLrXes2W'),
(7, 'P.1004', 'Jamilu Ali', 'jamalauali@gmail.com', '$2y$10$3LB5Gqd/eVAniOF1z7mEy.1u9x5zdnbx.yRLLj4Z/2/C8hlH7m0Ua');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'admin@ful.com', '$2y$10$g5Q3er8BjK/8GTGLfTB4AeKSeKwa/kk3BeDN5FOaB.J9cP6HkKcCO', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`,`attendance_date`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `fk_teacher_course` (`teacher_id`);

--
-- Indexes for table `course_activations`
--
ALTER TABLE `course_activations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_activations`
--
ALTER TABLE `course_activations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_assignments`
--
ALTER TABLE `course_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_teacher_course` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_activations`
--
ALTER TABLE `course_activations`
  ADD CONSTRAINT `course_activations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_activations_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD CONSTRAINT `course_assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_assignments_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
