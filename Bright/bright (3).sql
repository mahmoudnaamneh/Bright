-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 06:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bright`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `idcart` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idcourse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `idcontact` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `contactdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `idcourse` int(11) NOT NULL,
  `language` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `places` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `imageurl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`idcourse`, `language`, `price`, `places`, `description`, `url`, `imageurl`) VALUES
(1, 'c', 70, 10, 'This tutorial covers introduction in C.', 'https://www.udemy.com/course/the-complete-c-programming-bootcamp/', 'https://th.bing.com/th/id/R.939baaf1925687f7a5a6c92b4bacf924?rik=uTIRy6SlLqqAow&riu=http%3a%2f%2fsnti.in%2fimages%2fc-card.png&ehk=FmDEuY0d2ErWBT7nhpV%2bKNNuxTH5m9NwOsSuSPw%2f0vA%3d&risl=&pid=ImgRaw&r=0'),
(2, 'python', 120, 17, 'This tutorial covers introduction in Python', 'https://www.udemy.com/course/python-for-absolute-beginners-u/', 'https://tektutes.com/userfiles/product_images/400/python.png'),
(3, 'java', 100, 3, 'This tutorial covers introduction in java', 'https://www.udemy.com/course/java-programming-tutorial-for-beginners/', 'https://wallpapercave.com/wp/wp7250087.jpg'),
(4, 'C++', 70, 0, 'This tutorial covers introduction in C++.', 'https://www.udemy.com/course/cpp-fundamentals/', 'https://th.bing.com/th/id/OIP.ivxjiUfGdsOinQtSSFw47QAAAA?w=454&h=339&rs=1&pid=ImgDetMain'),
(5, 'C#', 60, 17, 'This tutorial covers introduction in C#', 'https://www.udemy.com/course/learn-c-sharp-programming/', 'https://th.bing.com/th/id/OIP.YOfJJtnHTHk1mL5NE_HRmQHaHa?w=512&h=512&rs=1&pid=ImgDetMain'),
(6, 'javascript', 100, 17, 'This tutorial covers introduction in javascript', 'https://www.udemy.com/course/javascript-basics-for-beginners/', 'https://www.global-itech.com/wp-content/uploads/2020/04/javaScriptIcon-768x870.jpeg'),
(7, 'Ruby', 370, 4, 'This tutorial covers introduction in Ruby.', 'https://www.udemy.com/course/the-complete-ruby-on-rails-developer-course/', 'https://th.bing.com/th/id/R.0291b3c75b38f7e321ec410a0056015f?rik=52prMH774RTV0w&pid=ImgRaw&r=0'),
(8, 'php', 270, 11, 'This tutorial covers introduction in php', 'https://www.udemy.com/course/php-from-scratch-course/', 'https://th.bing.com/th/id/R.adbac78231c9a2ff5c21aaa32dd4e1e4?rik=jWTUkOKwKIk7jg&riu=http%3a%2f%2flofrev.net%2fwp-content%2fphotos%2f2017%2f05%2fphp_emblem.png&ehk=gbX0plW%2fbqAeSR4cWmkL44R%2bUWxCpG3CL%2b2V4KHQlpQ%3d&risl=&pid=ImgRaw&r=0'),
(9, 'MySQL', 120, 19, 'This tutorial covers introduction in SQL', 'https://www.udemy.com/course/the-ultimate-mysql-bootcamp-go-from-sql-beginner-to-expert/', 'https://1000logos.net/wp-content/uploads/2020/08/MySQL-Logo.jpg'),
(10, 'MongoDB', 90, 18, 'This tutorial covers introduction in MongoDB.', 'https://www.udemy.com/course/mongodb-the-complete-developers-guide/', 'https://th.bing.com/th/id/R.8368570cfba7bd7a4523fb60ecb1b902?rik=gvsdFp7QyFPdqQ&pid=ImgRaw&r=0'),
(11, 'Go', 399, 6, 'learn Go from the zero to hero', 'https://www.udemy.com/course/go-the-complete-guide/?couponCode=LETSLEARNNOWPP', 'https://th.bing.com/th/id/OIP.YtlWWciX0sLY9eb4CIvTxQHaEK?rs=1&pid=ImgDetMain'),
(12, '', 0, 0, '', '', ''),
(13, '', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `purchased` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `role` varchar(20) NOT NULL,
  `attemptdate` datetime(6) DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `login_attempts` int(11) NOT NULL,
  `forget` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `phone`, `fname`, `lname`, `birthdate`, `role`, `attemptdate`, `locked`, `login_attempts`, `forget`) VALUES
(11111111, 'odegard123', 'odegar123456789', 'odegard@gmail.com', '0583245667', 'odegard', 'odegard', '2024-03-18', 'normal', '2024-04-05 13:25:45.000000', 0, 0, 0),
(22222222, 'marten12', 'marten12345', 'marten@gmail.com', '0506543329', 'marten', 'marten', '2024-03-02', 'normal', '2024-04-05 11:56:42.000000', 0, 0, 0),
(33333333, 'mike112', 'mike123456', 'mike@gmail.com', '527307121', 'mike', 'mike', '2024-03-06', 'normal', '2024-04-05 17:53:02.000000', 0, 1, 0),
(44444444, 'goldenburg13', 'goldenburg12345', 'goldenburg@gmail.com', '0546789321', 'goldenburg', 'goldenburg', '2024-03-01', 'normal', NULL, 0, 0, 0),
(55555555, 'jakel123', 'jake12345', 'jake@gmail.com', '528617513', 'jake', 'jake', '1970-10-07', 'admin', '2024-04-05 17:34:03.000000', 0, 0, 0),
(66666666, 'baron123', 'barona015', 'baron@example.com', '33233232', 'baron', 'baron', '2003-03-14', 'normal', '2024-03-30 13:09:17.000000', 0, 0, 0),
(77777777, 'sweet123', 'sweet288', 'sweet@gmail.com', '548705667', 'sweet', 'sweet', '2002-04-11', 'normal', '2024-03-17 16:16:46.000000', 1, 2, 0),
(88888888, 'bin123', 'binl644', 'bin@example.com', '3254345', 'bin', 'bin', '2016-05-23', 'normal', NULL, 0, 0, 0),
(99999999, 'meron1', 'meron123456', 'meron@gmail.com', '667769432', 'meron', 'meron', '2001-01-15', 'admin', '2024-04-04 17:09:04.000000', 0, 1, 0),
(10101010, 'sharon123', 'sharon191919', 'sharon@gmail.com', '2434223', 'sharon', 'sharon', '2014-03-19', 'normal', '2024-03-31 14:29:05.000000', 0, 0, 0),
(12121212, 'yakuz123', 'yakuz455', 'yakuz@example.com', '44644', 'yakuz', 'yakuz', '2024-03-01', 'normal', '2024-03-17 16:14:51.000000', 0, 0, 0),
(13131313, 'oden123', 'oden111111', 'oden@gmail.com', '04333222', 'oden', 'oden', '2002-10-15', 'normal', '2024-04-05 10:56:36.000000', 0, 0, 0),
(14141414, 'helmut12', 'helmut123456', 'helmut@gmail.com', '548700000', 'helmut', 'helmut', '2000-06-16', 'normal', '2024-04-05 13:19:36.000000', 0, 0, 0),
(15151515, 'haron123', 'haron654321', 'haron@gmail.com', '0528338310', 'haron', 'haron', '1995-02-09', 'normal', NULL, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idcart`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idcourse` (`idcourse`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`idcontact`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`idcourse`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `idcontact` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `idcourse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`idcourse`) REFERENCES `course` (`idcourse`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`idcourse`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
