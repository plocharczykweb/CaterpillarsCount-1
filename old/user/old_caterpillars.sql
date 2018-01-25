-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2015 at 06:39 PM
-- Server version: 5.6.21-log
-- PHP Version: 5.4.23



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


USE caterpillars;

--
-- Database: `pocket14_catepillarTest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE IF NOT EXISTS `tbl_orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `surveyID` int(11) NOT NULL,
  `orderArthropod` varchar(100) NOT NULL DEFAULT '',
  `orderLength` int(5) NOT NULL DEFAULT '0',
  `orderNotes` varchar(1000) NOT NULL DEFAULT '',
  `orderCount` int(5) NOT NULL DEFAULT '0',
  `insectPhoto` varchar(2083) DEFAULT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`orderID`),
  KEY `surveyID_fk_in_orders` (`surveyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=206 ;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`orderID`, `surveyID`, `orderArthropod`, `orderLength`, `orderNotes`, `orderCount`, `insectPhoto`, `timeStamp`, `isValid`) VALUES
(19, 59, 'orArth', 6, 'nooote', 7, 'domain/order59-19.jpg', '2014-10-24 05:24:54', 0),
(20, 59, 'orArth', 6, 'nooote', 7, 'domain/order59-20.jpg', '2014-10-24 05:25:29', 1),
(21, 59, 'orArth', 6, 'nooote', 7, 'domain/order59-21.jpg', '2014-10-24 05:25:50', 1),
(22, 64, '', 0, '', 0, 'domain/order64-22.jpg', '2014-10-24 15:09:11', 1),
(23, 65, 'orArth', 6, 'nooote', 7, 'domain/order65-23.jpg', '2014-10-24 15:10:37', 1),
(24, 59, 'orArth', 6, 'nooote', 7, 'domain/order59-24.jpg', '2014-10-24 15:27:04', 1),
(25, 59, 'orArth', 6, 'nooote', 7, 'domain/order59-25.jpg', '2014-10-24 15:27:05', 1),
(33, 121, 'orderName test', 0, ' ', 0, 'domain/order121-33.jpg', '2014-11-03 14:45:01', 0),
(34, 121, 'orderName test', 0, ' ', 0, 'domain/order121-34.jpg', '2014-11-03 14:45:01', 1),
(35, 122, 'orderName test', 0, ' ', 0, 'domain/order122-35.jpg', '2014-11-03 14:50:12', 1),
(36, 122, 'orderName test', 0, ' ', 4, 'domain/order122-36.jpg', '2014-11-03 14:50:12', 1),
(37, 123, 'orderName test', 58566, 'hhhghgvccxfhmsksjxjxjxjdjsnwodockdnahsjskdjd', 88666, 'domain/order123-37.jpg', '2014-11-03 19:35:26', 1),
(38, 124, 'Beetles (Coleoptera)', 0, ' ', 0, 'domain/order124-38.jpg', '2014-11-04 05:21:54', 1),
(39, 125, 'Click to choose a order', 0, ' ', 0, 'domain/order125-39.jpg', '2014-11-05 01:07:50', 1),
(40, 126, 'Click to choose a order', 0, ' ', 1, 'domain/order126-40.jpg', '2014-11-05 01:23:14', 1),
(43, 131, 'Ants (Formicidae)', 0, ' ', 0, 'domain/order131-43.jpg', '2014-11-05 13:22:39', 1),
(44, 131, 'Click to choose a order', 0, ' ', 0, 'domain/order131-44.jpg', '2014-11-05 13:22:39', 1),
(45, 131, 'Aphids and Psyllids', 2147483647, 'Kakajshh ', 94848, 'domain/order131-45.jpg', '2014-11-05 13:22:39', 1),
(78, 160, 'Click to choose a order', 0, ' ', 0, 'domain/order160-78.jpg', '2014-11-10 15:34:30', 1),
(106, 265, '1', 2, '4', 3, 'domain/order265-106.jpg', '2014-11-12 01:14:50', 1),
(107, 265, '2', 3, '5', 4, 'domain/order265-107.jpg', '2014-11-12 01:14:50', 1),
(108, 266, '2', 3, '5', 4, 'domain/order266-108.jpg', '2014-11-12 01:19:52', 1),
(109, 266, '1', 2, '4', 3, 'domain/order266-109.jpg', '2014-11-12 01:19:52', 1),
(110, 266, '3', 4, '6', 5, 'domain/order266-110.jpg', '2014-11-12 01:19:52', 1),
(111, 267, 'Bees and Wasps (Hymenoptera, excluding ants)', 11, 'This ', 21, 'domain/order267-111.jpg', '2014-11-12 04:02:38', 1),
(112, 267, 'Bees and Wasps (Hymenoptera, excluding ants)', 22, 'The ', 35, 'domain/order267-112.jpg', '2014-11-12 04:02:39', 1),
(113, 273, 'Click to choose a order', 0, ' ', 0, 'domain/order273-113.jpg', '2014-11-12 04:50:28', 1),
(114, 274, 'Click to choose a order', 0, ' ', 0, 'domain/order274-114.jpg', '2014-11-12 04:54:42', 1),
(115, 275, 'Click to choose a order', 0, ' ', 0, 'domain/order275-115.jpg', '2014-11-12 05:03:32', 1),
(116, 275, 'Click to choose a order', 0, ' ', 0, 'domain/order275-116.jpg', '2014-11-12 05:03:32', 1),
(117, 276, 'Click to choose a order', 0, ' ', 0, 'domain/order276-117.jpg', '2014-11-12 05:08:13', 1),
(118, 277, 'Click to choose a order', 0, ' ', 0, 'domain/order277-118.jpg', '2014-11-12 05:10:01', 1),
(119, 277, 'Click to choose a order', 0, ' ', 0, 'domain/order277-119.jpg', '2014-11-12 05:10:01', 1),
(120, 279, '1', 2, '4', 3, 'domain/order279-120.jpg', '2014-11-12 05:25:48', 1),
(121, 280, '1', 2, '4', 3, 'domain/order280-121.jpg', '2014-11-12 05:25:49', 1),
(122, 281, '1', 2, '4', 3, 'domain/order281-122.jpg', '2014-11-12 05:25:50', 1),
(123, 282, '1', 2, '4', 3, 'domain/order282-123.jpg', '2014-11-12 05:25:51', 1),
(124, 283, '1', 2, '4', 3, 'domain/order283-124.jpg', '2014-11-12 05:25:51', 1),
(125, 288, 'Bees and Wasps (Hymenoptera, excluding ants)', 5, 'g', 6, 'domain/order288-125.jpg', '2014-11-12 07:14:49', 1),
(126, 289, 'Caterpillars (Lepidoptera larvae)', 200, 'cute bugs', 5, 'domain/order289-126.jpg', '2014-11-12 13:19:42', 1),
(127, 290, '1', 2, '4', 3, 'domain/order290-127.jpg', '2014-11-12 13:22:49', 1),
(128, 291, '1', 2, '4', 3, 'domain/order291-128.jpg', '2014-11-12 13:22:56', 1),
(129, 292, '1', 2, '4', 3, 'domain/order292-129.jpg', '2014-11-12 13:23:09', 1),
(130, 294, '1', 21, '4', 3, 'domain/order294-130.jpg', '2014-11-12 13:25:59', 1),
(131, 295, '1', 21, '4', 3, 'domain/order295-131.jpg', '2014-11-12 13:26:12', 1),
(132, 296, 'Bees and Wasps (Hymenoptera, excluding ants)', 5, 'Violent', 8, 'domain/order296-132.jpg', '2014-11-12 14:36:31', 1),
(133, 296, 'Caterpillars (Lepidoptera larvae)', 6, 'notes', 5, 'domain/order296-133.jpg', '2014-11-12 14:36:32', 1),
(134, 307, '1', 2, '4', 3, 'domain/order307-134.jpg', '2014-12-02 12:57:03', 1),
(135, 307, '2', 3, '5', 4, 'domain/order307-135.jpg', '2014-12-02 12:57:03', 1),
(136, 308, '1', 2, '4', 3, 'domain/order308-136.jpg', '2014-12-02 12:57:18', 1),
(137, 308, '5', 6, '8', 7, 'domain/order308-137.jpg', '2014-12-02 12:57:22', 1),
(138, 309, '5', 6, '8', 7, 'domain/order309-138.jpg', '2014-12-02 12:57:38', 1),
(139, 310, '5', 6, '8', 7, 'domain/order310-139.jpg', '2014-12-02 12:58:25', 1),
(140, 310, 't', 1, '2', 1, 'domain/order310-140.jpg', '2014-12-02 12:58:25', 1),
(142, 337, '', 0, '', 0, 'uploads/order337-142.jpg', '2014-12-02 20:45:52', 1),
(143, 59, 'orArth', 6, 'nooote', 7, 'uploads/order59-143.jpg', '2014-12-02 21:40:31', 1),
(144, 59, 'orArth', 6, 'nooote', 7, 'uploads/order59-144.jpg', '2014-12-02 21:40:43', 1),
(145, 369, 'Beetles (Coleoptera)', 11, '', 2, 'uploads/order369-145.jpg', '2014-12-03 10:08:11', 1),
(146, 369, 'Beetles (Coleoptera)', 12, 's', 3, 'uploads/order369-146.jpg', '2014-12-03 10:08:14', 1),
(147, 370, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'g', 5, 'uploads/order370-147.jpg', '2014-12-03 13:20:29', 1),
(148, 371, 'Aphids and Psyllids', 2, 'M', 6, 'uploads/order371-148.jpg', '2014-12-03 13:20:37', 1),
(149, 372, 'Aphids and Psyllids', 99, 'Mm', 96, 'uploads/order372-149.jpg', '2014-12-03 13:21:38', 1),
(150, 373, 'Aphids and Psyllids', 99, 'Mm', 96, 'uploads/order373-150.jpg', '2014-12-03 13:21:54', 1),
(151, 374, 'Aphids and Psyllids', 6, 'M', 6, 'uploads/order374-151.jpg', '2014-12-03 13:32:21', 1),
(152, 375, 'Caterpillars (Lepidoptera larvae)', 2, 'K', 6, 'uploads/order375-152.jpg', '2014-12-03 13:36:14', 1),
(153, 378, 'Ants (Formicidae)', 33, '', 2, 'uploads/order378-153.jpg', '2014-12-03 17:53:33', 1),
(154, 378, 'Aphids and Psyllids (Sternorrhyncha)', 3, '', 50, 'uploads/order378-154.jpg', '2014-12-03 17:53:35', 1),
(155, 379, 'Ants (Formicidae)', 3, '', 5, 'uploads/order379-155.jpg', '2014-12-05 18:27:27', 1),
(156, 379, 'Daddy longlegs (Opiliones)', 34, '', 1, 'uploads/order379-156.jpg', '2014-12-05 18:27:28', 1),
(157, 380, 'Aphids and Psyllids', 99, 'N', 99, 'uploads/order380-157.jpg', '2014-12-05 18:31:56', 1),
(158, 380, 'Aphids and Psyllids', 99, 'Nn', 68, 'uploads/order380-158.jpg', '2014-12-05 18:31:56', 1),
(159, 381, 'Aphids and Psyllids (Sternorrhyncha)', 5, '', 55, 'uploads/order381-159.jpg', '2014-12-05 19:47:23', 1),
(160, 382, 'Bees and Wasps (Hymenoptera, excluding ants)', 23, '', 4, 'uploads/order382-160.jpg', '2014-12-05 19:59:18', 1),
(161, 384, 'Bees and Wasps (Hymenoptera, excluding ants)', 5, 'fhg', 5, 'uploads/order384-161.jpg', '2014-12-06 01:21:37', 1),
(162, 386, 'Beetles (Coleoptera)', 2, '1', 3, 'uploads/order386-162.jpg', '2014-12-06 03:49:28', 1),
(163, 386, 'Beetles (Coleoptera)', 1, '', 2, 'uploads/order386-163.jpg', '2014-12-06 03:49:28', 1),
(164, 387, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'hgh', 5, 'uploads/order387-164.jpg', '2014-12-06 05:53:40', 1),
(165, 387, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order387-165.jpg', '2014-12-06 05:53:40', 1),
(166, 388, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'hgh', 5, 'uploads/order388-166.jpg', '2014-12-06 05:54:53', 1),
(167, 388, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order388-167.jpg', '2014-12-06 05:54:53', 1),
(168, 389, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'hgh', 5, 'uploads/order389-168.jpg', '2014-12-06 05:56:59', 1),
(169, 389, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order389-169.jpg', '2014-12-06 05:56:59', 1),
(170, 390, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'hgh', 5, 'uploads/order390-170.jpg', '2014-12-06 06:00:41', 1),
(171, 390, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order390-171.jpg', '2014-12-06 06:00:42', 1),
(172, 393, 'Daddy longlegs (Opiliones)', 3, '', 4, 'uploads/order393-172.jpg', '2014-12-06 07:05:34', 1),
(173, 394, 'Bees and Wasps (Hymenoptera, excluding ants)', 68, 'Jjpt', 58, 'uploads/order394-173.jpg', '2014-12-06 12:34:55', 1),
(174, 397, 'Bees and Wasps (Hymenoptera, excluding ants)', 55, 'FB', 25, 'uploads/order397-174.jpg', '2014-12-06 12:38:44', 1),
(175, 398, 'Bees and Wasps (Hymenoptera, excluding ants)', 55, 'FB', 25, 'uploads/order398-175.jpg', '2014-12-06 12:38:47', 1),
(176, 400, 'Bees and Wasps (Hymenoptera, excluding ants)', 68, 'b', 55, 'uploads/order400-176.jpg', '2014-12-06 12:41:14', 1),
(177, 405, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'tggg', 5, 'uploads/order405-177.jpg', '2014-12-06 13:17:55', 1),
(178, 406, 'Leaf hoppers and Cicadas (Auchenorrhyncha)', 40, 'big cicada!', 2, 'uploads/order406-178.jpg', '2014-12-06 14:13:24', 1),
(179, 407, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'tggg', 5, 'uploads/order407-179.jpg', '2014-12-06 14:16:08', 1),
(180, 409, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order409-180.jpg', '2014-12-06 14:30:17', 1),
(181, 410, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order410-181.jpg', '2014-12-06 14:30:19', 1),
(182, 411, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order411-182.jpg', '2014-12-06 14:30:19', 1),
(183, 412, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order412-183.jpg', '2014-12-06 14:30:19', 1),
(184, 414, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order414-184.jpg', '2014-12-06 14:30:19', 1),
(185, 413, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order413-185.jpg', '2014-12-06 14:30:19', 1),
(186, 415, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order415-186.jpg', '2014-12-06 14:30:19', 1),
(187, 416, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order416-187.jpg', '2014-12-06 14:30:19', 1),
(188, 417, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order417-188.jpg', '2014-12-06 14:30:19', 1),
(189, 418, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order418-189.jpg', '2014-12-06 14:30:19', 1),
(190, 408, 'Aphids and Psyllids', 9, 'k', 8, 'uploads/order408-190.jpg', '2014-12-06 14:30:19', 1),
(191, 419, 'Aphids and Psyllids', 6, 'bp', 5, 'uploads/order419-191.jpg', '2014-12-06 14:31:05', 1),
(192, 420, 'Ants (Formicidae)', 4, 'lots of ants!', 40, 'uploads/order420-192.jpg', '2014-12-06 14:34:45', 1),
(193, 421, 'Flies (Diptera)', 54, 'too many', 6, 'uploads/order421-193.jpg', '2014-12-06 14:42:16', 1),
(194, 422, 'Bees and Wasps (Hymenoptera, excluding ants)', 22, 'Test', 22, 'uploads/order422-194.jpg', '2014-12-06 14:42:16', 1),
(195, 421, 'Daddy longlegs (Opiliones)', 5, '', 8, 'uploads/order421-195.jpg', '2014-12-06 14:42:16', 1),
(196, 422, 'Bees and Wasps (Hymenoptera, excluding ants)', 33, 'Hug', 33, 'uploads/order422-196.jpg', '2014-12-06 14:42:17', 1),
(197, 423, 'Daddy longlegs (Opiliones)', 2, '', 3, 'uploads/order423-197.jpg', '2014-12-06 14:45:28', 1),
(198, 423, 'Beetles (Coleoptera)', 4, '', 5, 'uploads/order423-198.jpg', '2014-12-06 14:45:28', 1),
(199, 425, 'Caterpillars (Lepidoptera larvae)', 35, 'Testing', 2, 'uploads/order425-199.jpg', '2014-12-16 02:04:41', 1),
(200, 426, 'Caterpillars (Lepidoptera larvae)', 35, 'Testing', 2, 'uploads/order426-200.jpg', '2014-12-16 02:04:41', 1),
(201, 427, 'NONE', 0, ' ', 0, 'uploads/order427-201.jpg', '2014-12-17 02:27:50', 1),
(202, 428, 'NONE', 0, ' ', 0, 'uploads/order428-202.jpg', '2014-12-17 02:27:50', 1),
(203, 429, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order429-203.jpg', '2014-12-17 16:00:57', 1),
(204, 430, 'Bees and Wasps (Hymenoptera, excluding ants)', 6, 'gh', 5, 'uploads/order430-204.jpg', '2014-12-17 16:01:23', 1),
(205, 431, 'Bees and Wasps (Hymenoptera, excluding ants)', 5, '', 2, 'uploads/order431-205.jpg', '2014-12-17 16:17:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_privilege`
--

CREATE TABLE IF NOT EXISTS `tbl_privilege` (
  `privilegeLevel` int(2) NOT NULL,
  `privilegeName` varchar(20) NOT NULL,
  `privilegeDescription` varchar(300) NOT NULL,
  PRIMARY KEY (`privilegeLevel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_privilege`
--

INSERT INTO `tbl_privilege` (`privilegeLevel`, `privilegeName`, `privilegeDescription`) VALUES
(0, 'General User', 'Can submit survey/order data'),
(5, 'Site Admin', 'Can make change to site password for the site he/she manages.\r\nCan mark General User (level 0) as invalid.\r\nCan mark other siteAdmin relationship within same site as invalid.\r\nCan mark own site as invalid.'),
(10, 'Master Admin', 'Can make change to all site password for the site he/she manages.\r\nCan mark all General User (level 0) as invalid.\r\nCan mark all Site Admin (level 5) as invalid.\r\nCan mark all siteAdmin relationship as invalid.\r\nCan mark all sites as invalid.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siteAdmin`
--

CREATE TABLE IF NOT EXISTS `tbl_siteAdmin` (
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1',
  `siteID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  KEY `fk_siteID` (`siteID`),
  KEY `fk_userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_siteAdmin`
--

INSERT INTO `tbl_siteAdmin` (`timeStamp`, `isValid`, `siteID`, `userID`) VALUES
('2014-10-19 19:58:27', 1, NULL, NULL),
('2014-10-23 20:29:20', 1, 4, 4),
('2014-10-23 21:31:17', 1, 6, 1),
('2014-10-23 21:32:37', 1, 7, 1),
('2014-10-23 21:38:22', 1, 8, 1),
('2014-10-23 21:38:45', 1, 9, 1),
('2014-10-23 21:39:57', 1, 10, 1),
('2014-10-24 01:53:38', 1, 11, 1),
('2014-10-24 02:21:27', 1, 12, 1),
('2014-10-24 03:54:39', 1, 13, 1),
('2014-10-24 15:11:59', 1, 14, 1),
('2014-10-24 15:26:32', 1, 15, 1),
('2014-10-28 18:45:14', 1, 17, 1),
('2014-10-28 18:45:14', 1, 16, 1),
('2014-10-28 22:24:05', 1, 3, 58),
('2014-11-12 00:17:08', 1, 18, 1),
('2014-11-17 15:21:48', 1, 19, 1),
('2014-11-30 10:49:19', 1, 112, 1),
('2014-11-30 10:53:20', 1, 113, 1),
('2014-12-02 11:07:04', 1, 114, 1),
('2014-12-02 18:44:41', 1, 115, 1),
('2014-12-02 18:45:24', 1, 116, 1),
('2014-12-02 18:46:26', 1, 117, 69),
('2014-12-02 20:48:31', 1, 118, 1),
('2014-12-03 07:44:42', 1, 119, 1),
('2014-12-03 07:46:57', 1, 120, 1),
('2014-12-03 13:31:40', 1, 121, 1),
('2014-12-06 04:09:36', 1, 122, 1),
('2014-12-06 04:50:52', 1, 123, 64),
('2014-12-06 14:47:59', 1, 124, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sites`
--

CREATE TABLE IF NOT EXISTS `tbl_sites` (
  `siteID` int(11) NOT NULL AUTO_INCREMENT,
  `siteName` varchar(100) NOT NULL DEFAULT '',
  `siteState` varchar(15) NOT NULL DEFAULT '',
  `siteLat` float NOT NULL,
  `siteLong` float NOT NULL,
  `siteSaltHash` varchar(77) NOT NULL,
  `siteDescription` text NOT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isValid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`siteID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `tbl_sites`
--

INSERT INTO `tbl_sites` (`siteID`, `siteName`, `siteState`, `siteLat`, `siteLong`, `siteSaltHash`, `siteDescription`, `timeStamp`, `isValid`) VALUES
(3, 'test site', 'NC', 111, 222, 'sha256:1000:7+Udn4ef7zUFCkZh6h3QcXvTcN4yvkVn:M0aNO7lm5Bh4az0oR8VJsbzGvVwHPeue', 'site desc', '2014-10-23 15:52:43', 1),
(4, 'site Name', 'SC', 111, 222, 'hashash', 'desc', '2014-10-23 20:09:41', 1),
(5, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:1pta47mJHrlO41E0H8mbJEoMf/mhgzFX:DXSKfoH/PvPbwLFsQF7nMit8woUZrYC9', 'siteDescriptionContent', '2014-10-23 21:30:39', 1),
(6, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:W5uRSbcdDTJnQiavSFfVTON+PBEvKNe/:tCC0DuVkgTPs4nGttbZY0owW9eBSsnnl', 'siteDescriptionContent', '2014-10-23 21:31:17', 1),
(7, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:BWJIned0LOWbrSIM4dFnV7GUjqqYGpUn:1ivWX/QcgDxzox0ndi9RzJHXcuNTqDPT', 'siteDescriptionContent', '2014-10-23 21:32:37', 1),
(8, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:XFYC7J1XqBdJfHQU7Y1nACHSw9FMfdxB:WwFhdVwhyZDU2gzXDDDCGDCcD8BdIGgw', 'siteDescriptionContent', '2014-10-23 21:38:22', 1),
(9, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:ge9dEyl/DGwJ3OWaKUWCpGY9UE1YbNBl:wYq1sGSjtob4jUWdfsxO/sr8nmPRA5QW', 'siteDescriptionContent', '2014-10-23 21:38:45', 1),
(10, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:auBVHEpOm5PTtFYot/VewxFN7To0tku4:1Vl1I3pfwcsRJ3KN+Q4402vgIG8/35xi', 'siteDescriptionContent', '2014-10-23 21:39:57', 1),
(11, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:012iYNfz3Del36KRV66PoguQaBchLy8E:qaJEc+s89Ck4AYNd9/lm9BBSBdNpKZuN', 'siteDescriptionContent', '2014-10-24 01:53:38', 1),
(12, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:90cNBo0djtEB2ZFgVRFKOUc9qcLNu6oU:nPcIpoKYjKWoBVTWs1ez+fVcnxPQ7pqC', 'siteDescriptionContent', '2014-10-24 02:21:27', 1),
(13, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:2W7h3T9elTBs2r/vntrBwXycgCNkCY18:L2PTLJiIgHdcs58GPYFRRMNw3kZpYAmj', 'siteDescriptionContent', '2014-10-24 03:54:39', 1),
(14, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:uWdG3uSS0iglw8qk6KVl61ovKq6iAQge:KGNM31oUjTLlrCTPQtDLDWABgNtJ/TjI', 'siteDescriptionContent', '2014-10-24 15:11:59', 1),
(15, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:HV+RddnXfTQLs98lhNzi5V6JOUboGiDb:abZ6VDaZH28iAZV8hczbB9QM3sLg72fc', 'siteDescriptionContent', '2014-10-24 15:26:32', 1),
(16, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:ngQ9UK+QD91TrnQ1ISVRgPG1aydrnoq+:MjwJ31gKlbu4lVJIkI4ZcLqdR+NFrJjc', 'siteDescriptionContent', '2014-10-28 18:45:14', 1),
(17, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:39bLQfn1WWDg/N8uRPV2ePdatOpiM3xi:sWWkqvx3KwD2NfRYfraL5mJXVPLoGZXv', 'siteDescriptionContent', '2014-10-28 18:45:14', 1),
(18, 'Demo Site', 'NC', 35.9333, -79.0333, 'sha256:1000:HS4ezzxaVZ1+JHBgJFfBQX5Sw8MR3OAN:e0XnZ3geMuOZfHSAwQXP1QPlkraMb7cQ', 'For CC! Beta Users', '2014-11-12 00:17:08', 1),
(19, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:fsKTSVxHe0EHMmqtoYAoB4jkBYmdC1zd:88SHwXpVS8jdsQP9zIE/YPPgXP5jN6/E', 'siteDescriptionContent', '2014-11-17 15:21:48', 1),
(22, '', '', 123, 123, 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '', '2014-11-24 04:51:09', 1),
(111, '', '', 0, 0, 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '', '2014-11-24 04:50:19', 1),
(112, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:AH7Tt8azbYisOoGOkn2vW182/AdJfLzf:4KwVO9PHczwNS8CzhC2PZ8TjLLqDo7Od', 'siteDescriptionContent', '2014-11-30 10:49:19', 1),
(113, 'Durham', 'NC', 1, 2, 'sha256:1000:e88WNbMfe+7molm2rN/a7DoD7qIgWysR:+NojsWVAQehCCXoiCXUeNTibdeR1KyoF', '', '2014-11-30 10:53:20', 1),
(114, 'New Site', 'NC', 111, 222, 'sha256:1000:5PsLxE6JNUAwfM4lzEvCdEeEy/J7guxm:nc4PjWYgqx+pCcOJKgSPgKxn/cbb1f+A', '1123', '2014-12-02 11:07:04', 1),
(115, 'Durhamd', 'NC', 11, 22, 'sha256:1000:EbRYjbLGpT1XfA4MZQhakAphBTfyL69F:cYM9JCxfabpaCjsWwCf6qFMQWMjnJp2b', '', '2014-12-02 18:44:41', 1),
(116, 'Durhamd', 'NC', 11, 22, 'sha256:1000:zuxVaHJQMGf+OlixfJR70mNY+4IXGybU:Axtw/NGMNDjRnREuQvpuufYa0JygAMXF', '1', '2014-12-02 18:45:24', 1),
(117, 'Prairie Ridge', 'NC', 38, -80, 'sha256:1000:yicNxQLyXny6GyezhLcFUNPXftXn+MuG:l4BcH9Yc+HoWgqMQMv7YRT5twdjbjA8y', 'Prairie Ridge Ecostation, Raleigh, NC', '2014-12-02 18:46:26', 1),
(118, 'siteNameContent', 'CA', 567, 765, 'sha256:1000:GSXbz5AH7PYi0pFS9uVPbhImDHe+Yrqd:3U0jUsM1OfuvuFlWd5whBWsA/re3a8KN', 'siteDescriptionContent', '2014-12-02 20:48:31', 1),
(119, 'New York', 'NY', 11, 2, 'sha256:1000:m9SUxdgLjjHrCbTh+rVu1AJota6U41kf:tYM3DIaaq7KTHnWoc+wwpNwUh6QmnE4e', '', '2014-12-03 07:44:42', 1),
(120, 'Boston', 'MA', 11, 22, 'sha256:1000:DnsKfxB+7Uo15d5/DksVEOSr63i0tyYR:0aHC3+G8jHgX/QJpfiMqL3FqIdcFsthZ', '', '2014-12-03 07:46:57', 1),
(121, 'Chapel Hill', 'NC', 123, -80, 'sha256:1000:prLnIrfdsiu7DNb6BbpzBjhAzUAs7SF5:dyr6GhPTYBfmCnAbzgunmNj18WNOfEFm', '', '2014-12-03 13:31:40', 1),
(122, 'Yahoo', 'AZ', 112, -80, 'sha256:1000:khs4X0ZxvAXgsKh2N4xjmuqZMDHSEibQ:zYxSPgB0t1p+rznG2p9F4BT3oQhchxJB', '', '2014-12-06 04:09:36', 1),
(123, 'Demo Site 2', 'LA', 35.9333, -79.0333, 'sha256:1000:KksGzVC8k+1O2Ggxij55vqi5y+5TAkC2:oetMjMkPQbHVghe0TVL0T5/HIqbHmfVF', 'For CC! Beta Users', '2014-12-06 04:50:52', 1),
(124, '12', 'CA', 1, 2, 'sha256:1000:8AZu11IquiYySwgFIxKdUnkddJLOLi2+:N6nG8fICSTrKyJms2jsl85fLW3+fg6ou', '', '2014-12-06 14:47:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surveys`
--

CREATE TABLE IF NOT EXISTS `tbl_surveys` (
  `surveyID` int(11) NOT NULL AUTO_INCREMENT,
  `siteID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `circle` int(5) NOT NULL DEFAULT '0',
  `survey` varchar(5) NOT NULL DEFAULT '',
  `timeStart` datetime NOT NULL DEFAULT '1900-01-01 12:00:00',
  `timeSubmit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temperatureMin` int(5) DEFAULT '0',
  `temperatureMax` int(5) DEFAULT '0',
  `siteNotes` varchar(1000) DEFAULT NULL,
  `plantSpecies` varchar(100) DEFAULT '',
  `herbivory` int(1) DEFAULT '0',
  `leavePhoto` varchar(2083) DEFAULT '',
  `isValid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`surveyID`),
  KEY `siteID_fk_in_surveys` (`siteID`),
  KEY `userID_fk_in_surveys` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=432 ;

--
-- Dumping data for table `tbl_surveys`
--

INSERT INTO `tbl_surveys` (`surveyID`, `siteID`, `userID`, `circle`, `survey`, `timeStart`, `timeSubmit`, `temperatureMin`, `temperatureMax`, `siteNotes`, `plantSpecies`, `herbivory`, `leavePhoto`, `isValid`) VALUES
(45, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:46:42', 72, 73, 'siteNote', 'plantSpecies', 1, '', 0),
(46, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:46:58', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-46.jpg', 1),
(47, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:47:59', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-47.jpg', 0),
(48, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:49:56', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-48.jpg', 0),
(49, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:52:55', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-49.jpg', 0),
(50, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:53:28', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-50.jpg', 0),
(51, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:54:40', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-51.jpg', 0),
(52, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:58:38', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-52.jpg', 0),
(53, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 04:59:11', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-53.jpg', 1),
(54, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:01:25', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-54.jpg', 1),
(55, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:02:43', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-55.jpg', 1),
(56, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:03:07', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-56.jpg', 1),
(57, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:03:20', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-57.jpg', 0),
(58, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:21:27', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-58.jpg', 0),
(59, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 05:22:15', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-59.jpg', 1),
(64, 5, 1, 0, '', '1900-01-01 12:00:00', '2014-10-24 15:08:24', 0, 0, NULL, '', 0, 'domain/survey1-64.jpg', 1),
(65, 5, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 15:10:09', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-65.jpg', 1),
(66, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-24 15:27:18', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-66.jpg', 1),
(71, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-27 06:17:21', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-71.jpg', 1),
(72, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-27 06:18:06', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-72.jpg', 1),
(74, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-10-27 06:28:12', 72, 73, 'siteNote', 'plantSpecies', 0, 'domain/survey1-74.jpg', 1),
(84, 3, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:27', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-84.jpg', 1),
(86, 3, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:39', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-86.jpg', 1),
(88, 4, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:46', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-88.jpg', 1),
(89, 5, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:50', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-89.jpg', 1),
(90, 6, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:54', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-90.jpg', 0),
(91, 7, 1, 1, 'a', '2014-10-26 02:33:16', '2014-10-27 06:38:58', 30, 40, 'siteNotes', 'plantSpecies', 0, 'domain/survey1-91.jpg', 1),
(102, 5, 51, 0, '', '1900-01-01 12:00:00', '2014-11-02 16:59:34', 0, 0, NULL, '', 0, 'domain/survey51-102.jpg', 1),
(103, 5, 51, 0, '', '1900-01-01 12:00:00', '2014-11-02 16:59:42', 0, 0, NULL, '', 0, 'domain/survey51-103.jpg', 1),
(104, 5, 51, 0, '', '1900-01-01 12:00:00', '2014-11-02 17:08:05', 0, 0, NULL, '', 0, 'domain/survey51-104.jpg', 1),
(105, 5, 51, 0, '', '1900-01-01 12:00:00', '2014-11-02 17:08:19', 0, 0, NULL, '', 0, 'domain/survey51-105.jpg', 1),
(106, 5, 51, 0, '', '1900-01-01 12:00:00', '2014-11-02 17:15:30', 0, 0, NULL, '', 0, 'domain/survey51-106.jpg', 1),
(107, 5, 51, 1, 'a', '2014-10-13 12:06:02', '2014-11-02 17:19:25', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey51-107.jpg', 1),
(108, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-11-02 17:20:49', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-108.jpg', 1),
(109, 5, 51, 1, 'a', '2014-10-13 12:06:02', '2014-11-03 13:57:24', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey51-109.jpg', 1),
(110, 5, 51, 1, 'a', '2014-10-13 12:06:02', '2014-11-03 14:00:18', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey51-110.jpg', 1),
(111, 5, 51, 1, 'a', '2014-10-13 12:06:02', '2014-11-03 14:00:53', 72, 73, 'note', '', 4, 'domain/survey51-111.jpg', 1),
(112, 5, 51, 1, 'a', '2014-10-13 12:06:02', '2014-11-03 14:04:38', 72, 73, 'note', '', 4, 'domain/survey51-112.jpg', 1),
(113, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:05:08', 72, 73, 'note', '', 4, 'domain/survey51-113.jpg', 1),
(114, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:08:31', 72, 73, 'note', '', 1, 'domain/survey51-114.jpg', 1),
(115, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:14:41', 72, 73, 'note', '', 1, 'domain/survey51-115.jpg', 1),
(116, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:19:27', 72, 73, 'note', '', 1, 'domain/survey51-116.jpg', 1),
(117, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:21:33', 72, 73, 'note', '', 1, 'domain/survey51-117.jpg', 1),
(118, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:28:39', 72, 73, 'note', '', 1, 'domain/survey51-118.jpg', 1),
(119, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:35:23', 72, 73, 'note', '', 1, 'domain/survey51-119.jpg', 1),
(120, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:44:31', 72, 73, 'note', '', 1, 'domain/survey51-120.jpg', 1),
(121, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:45:00', 72, 73, 'note', '', 1, 'domain/survey51-121.jpg', 1),
(122, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-03 14:50:11', 72, 73, 'note', '', 1, 'domain/survey51-122.jpg', 1),
(123, 5, 51, 3, '1E', '2014-10-13 12:06:02', '2014-11-03 19:35:26', 72, 73, 'note', '', 1, 'domain/survey51-123.jpg', 1),
(124, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-04 05:21:54', 72, 73, 'note', '', 1, 'domain/survey51-124.jpg', 1),
(125, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-05 01:07:50', 72, 73, 'note', '', 1, 'domain/survey51-125.jpg', 1),
(126, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-05 01:23:13', 72, 73, 'sjsbbs', 'Habsburg', 4, 'domain/survey51-126.jpg', 1),
(127, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-05 01:57:16', 72, 73, '', '', 1, 'domain/survey51-127.jpg', 1),
(128, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-05 03:33:35', 72, 73, '', '', 1, 'domain/survey51-128.jpg', 1),
(129, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-05 03:33:38', 72, 73, '', '', 1, 'domain/survey51-129.jpg', 1),
(131, 5, 51, 3, 'D', '2014-10-13 12:06:02', '2014-11-05 13:22:39', 72, 73, 'Test notes', '', 1, 'domain/survey51-131.jpg', 1),
(132, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:49:43', 72, 73, '', '', 1, 'domain/survey51-132.jpg', 1),
(133, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:49:45', 72, 73, '', '', 1, 'domain/survey51-133.jpg', 1),
(134, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:49:55', 72, 73, '', '', 1, 'domain/survey51-134.jpg', 1),
(135, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:51:19', 72, 73, '', '', 1, 'domain/survey51-135.jpg', 1),
(136, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:51:21', 72, 73, '', '', 1, 'domain/survey51-136.jpg', 1),
(137, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-09 22:52:09', 72, 73, '', '', 1, 'domain/survey51-137.jpg', 1),
(160, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 15:34:29', 72, 73, '', '', 1, 'domain/survey51-160.jpg', 1),
(179, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:40:28', 72, 73, '', '', 1, 'domain/survey51-179.jpg', 1),
(180, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:45:36', 72, 73, '', '', 1, 'domain/survey51-180.jpg', 1),
(181, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:46:23', 72, 73, '', '', 1, 'domain/survey51-181.jpg', 1),
(182, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:47:18', 72, 73, '', '', 1, 'domain/survey51-182.jpg', 1),
(183, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:47:40', 72, 73, '', '', 1, 'domain/survey51-183.jpg', 1),
(184, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:50:39', 72, 73, '', '', 1, 'domain/survey51-184.jpg', 1),
(185, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:53:38', 72, 73, '', '', 1, 'domain/survey51-185.jpg', 1),
(186, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:55:06', 72, 73, '', '', 1, 'domain/survey51-186.jpg', 1),
(187, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:55:06', 72, 73, '', '', 1, 'domain/survey51-187.jpg', 1),
(188, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:55:24', 72, 73, '', '', 1, 'domain/survey51-188.jpg', 1),
(189, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:57:24', 72, 73, '', '', 1, 'domain/survey51-189.jpg', 1),
(190, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:57:55', 72, 73, '', '', 1, 'domain/survey51-190.jpg', 1),
(191, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:58:36', 72, 73, '', '', 1, 'domain/survey51-191.jpg', 1),
(192, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:58:42', 72, 73, '', '', 1, 'domain/survey51-192.jpg', 1),
(193, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 19:59:06', 72, 73, '', '', 1, 'domain/survey51-193.jpg', 1),
(194, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:00:57', 72, 73, '', '', 1, 'domain/survey51-194.jpg', 1),
(195, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:11:32', 72, 73, '', '', 1, 'domain/survey51-195.jpg', 1),
(196, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:11:33', 72, 73, '', '', 1, 'domain/survey51-196.jpg', 1),
(197, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:11:39', 72, 73, '', '', 1, 'domain/survey51-197.jpg', 1),
(198, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:30:31', 72, 73, '', '', 1, 'domain/survey51-198.jpg', 1),
(199, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:31:01', 72, 73, '', '', 1, 'domain/survey51-199.jpg', 1),
(200, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:33:29', 72, 73, '', '', 1, 'domain/survey51-200.jpg', 1),
(201, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:34:37', 72, 73, '', '', 1, 'domain/survey51-201.jpg', 1),
(202, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:45:10', 72, 73, '', '', 1, 'domain/survey51-202.jpg', 1),
(203, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:47:15', 72, 73, '', '', 1, 'domain/survey51-203.jpg', 1),
(204, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:47:21', 72, 73, '', '', 1, 'domain/survey51-204.jpg', 1),
(205, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:47:36', 72, 73, '', '', 1, 'domain/survey51-205.jpg', 1),
(206, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:57:29', 72, 73, '', '', 1, 'domain/survey51-206.jpg', 1),
(207, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:57:49', 72, 73, '', '', 1, 'domain/survey51-207.jpg', 1),
(208, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 20:58:12', 72, 73, '', '', 1, 'domain/survey51-208.jpg', 1),
(209, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-10 21:01:53', 72, 73, '', '', 1, 'domain/survey51-209.jpg', 1),
(213, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-11 01:06:35', 72, 73, '', '', 1, 'domain/survey51-213.jpg', 1),
(214, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-11 01:12:20', 72, 73, '', '', 1, 'domain/survey51-214.jpg', 1),
(215, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-11 01:46:21', 72, 73, '', '', 1, 'domain/survey51-215.jpg', 1),
(216, 5, 51, 1, 'Click', '2014-10-13 12:06:02', '2014-11-11 01:46:27', 72, 73, '', '', 1, 'domain/survey51-216.jpg', 1),
(218, 5, 51, 1, 'Click', '2014-11-10 21:02:11', '2014-11-11 02:02:10', 72, 73, '', '', 1, 'domain/survey51-218.jpg', 1),
(219, 5, 51, 1, 'Click', '2014-11-10 21:34:33', '2014-11-11 02:34:32', 72, 73, '', '', 1, 'domain/survey51-219.jpg', 1),
(221, 5, 51, 1, 'Click', '2014-11-10 21:49:48', '2014-11-11 02:49:46', 72, 73, '', '', 1, 'domain/survey51-221.jpg', 1),
(224, 5, 51, 1, 'Click', '2014-11-11 00:01:51', '2014-11-11 05:01:50', 72, 73, '', '', 1, 'domain/survey51-224.jpg', 1),
(225, 5, 51, 1, 'Click', '2014-11-11 00:04:55', '2014-11-11 05:04:54', 72, 73, '', '', 1, 'domain/survey51-225.jpg', 1),
(226, 5, 51, 1, 'Click', '2014-11-11 00:10:01', '2014-11-11 05:10:03', 72, 73, '', '', 1, 'domain/survey51-226.jpg', 1),
(227, 5, 51, 1, 'Click', '2014-11-11 00:11:02', '2014-11-11 05:11:03', 72, 73, '', '', 1, 'domain/survey51-227.jpg', 1),
(228, 5, 51, 1, 'Click', '2014-11-11 00:12:59', '2014-11-11 05:12:57', 72, 73, '', '', 1, 'domain/survey51-228.jpg', 1),
(229, 5, 51, 1, 'Click', '2014-11-11 00:15:06', '2014-11-11 05:15:10', 72, 73, '', '', 1, 'domain/survey51-229.jpg', 1),
(230, 5, 51, 1, 'Click', '2014-11-11 00:16:45', '2014-11-11 05:16:44', 72, 73, '', '', 1, 'domain/survey51-230.jpg', 1),
(231, 5, 51, 1, 'Click', '2014-11-11 00:21:44', '2014-11-11 05:21:42', 72, 73, '', '', 1, 'domain/survey51-231.jpg', 1),
(232, 5, 51, 1, 'Click', '2014-11-11 00:22:18', '2014-11-11 05:22:16', 72, 73, '', '', 1, 'domain/survey51-232.jpg', 1),
(233, 5, 51, 1, 'Click', '2014-11-11 00:22:49', '2014-11-11 05:22:47', 72, 73, '', '', 1, 'domain/survey51-233.jpg', 1),
(234, 5, 51, 1, 'Click', '2014-11-11 00:23:18', '2014-11-11 05:23:38', 72, 73, '', '', 1, 'domain/survey51-234.jpg', 1),
(235, 5, 51, 1, 'Click', '2014-11-11 00:26:25', '2014-11-11 05:26:24', 72, 73, '', '', 1, 'domain/survey51-235.jpg', 1),
(236, 5, 51, 1, 'Click', '2014-11-11 00:30:01', '2014-11-11 05:30:00', 72, 73, '', '', 1, 'domain/survey51-236.jpg', 1),
(237, 5, 51, 1, 'Click', '2014-11-11 00:30:54', '2014-11-11 05:30:53', 72, 73, '', '', 1, 'domain/survey51-237.jpg', 1),
(238, 5, 51, 1, 'Click', '2014-11-11 00:35:47', '2014-11-11 05:35:46', 72, 73, '', '', 1, 'domain/survey51-238.jpg', 1),
(239, 5, 51, 1, 'Click', '2014-11-11 00:37:50', '2014-11-11 05:37:49', 72, 73, '', '', 1, 'domain/survey51-239.jpg', 1),
(240, 5, 51, 1, 'Click', '2014-11-11 00:38:39', '2014-11-11 05:38:37', 72, 73, '', '', 1, 'domain/survey51-240.jpg', 1),
(241, 5, 51, 1, 'Click', '2014-11-11 00:42:17', '2014-11-11 05:42:16', 72, 73, '', '', 1, 'domain/survey51-241.jpg', 1),
(242, 5, 51, 1, 'Click', '2014-11-11 00:47:51', '2014-11-11 05:47:49', 72, 73, '', '', 1, 'domain/survey51-242.jpg', 1),
(243, 5, 51, 1, 'Click', '2014-11-11 00:51:28', '2014-11-11 05:51:27', 72, 73, '', '', 1, 'domain/survey51-243.jpg', 1),
(244, 5, 51, 1, 'Click', '2014-11-11 00:52:06', '2014-11-11 05:52:06', 72, 73, '', '', 1, 'domain/survey51-244.jpg', 1),
(245, 5, 51, 1, 'Click', '2014-11-11 00:57:37', '2014-11-11 05:57:35', 72, 73, '', '', 1, 'domain/survey51-245.jpg', 1),
(246, 5, 51, 1, 'Click', '2014-11-11 00:58:59', '2014-11-11 05:58:57', 72, 73, '', '', 1, 'domain/survey51-246.jpg', 1),
(247, 5, 51, 1, 'Click', '2014-11-11 00:59:30', '2014-11-11 05:59:28', 72, 73, '', '', 1, 'domain/survey51-247.jpg', 1),
(248, 5, 51, 1, 'Click', '2014-11-11 01:00:57', '2014-11-11 06:00:55', 72, 73, '', '', 1, 'domain/survey51-248.jpg', 1),
(249, 5, 51, 1, 'Click', '2014-11-11 01:03:29', '2014-11-11 06:03:28', 72, 73, '', '', 1, 'domain/survey51-249.jpg', 1),
(250, 5, 51, 1, 'Click', '2014-11-11 01:05:13', '2014-11-11 06:05:12', 72, 73, '', '', 1, 'domain/survey51-250.jpg', 1),
(256, 8, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 00:56:40', 30, 3010, '', '', 1, 'domain/survey58-256.jpg', 1),
(258, 4, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 00:59:12', 30, 40, '', '', 1, 'domain/survey58-258.jpg', 1),
(259, 7, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 00:59:48', 30, 40, '', '', 1, 'domain/survey58-259.jpg', 1),
(260, 7, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 00:59:52', 30, 40, '', '', 1, 'domain/survey58-260.jpg', 1),
(261, 7, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 00:59:55', 30, 40, '', '', 1, 'domain/survey58-261.jpg', 1),
(262, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 01:12:06', 30, 40, '', '', 1, 'domain/survey58-262.jpg', 1),
(263, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 01:12:08', 30, 40, '', '', 1, 'domain/survey58-263.jpg', 1),
(264, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 01:13:50', 30, 40, '', '', 1, 'domain/survey58-264.jpg', 1),
(265, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 01:14:48', 30, 40, '', '', 1, 'domain/survey58-265.jpg', 1),
(266, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 01:19:50', 30, 40, '', '', 1, 'domain/survey58-266.jpg', 1),
(267, 5, 51, 4, 'Click', '2014-10-13 12:06:02', '2014-11-12 04:02:38', 72, 73, '', '', 1, 'domain/survey51-267.jpg', 1),
(270, 5, 51, 1, 'Click', '2014-11-11 23:44:32', '2014-11-12 04:44:31', 72, 73, '', '', 1, 'domain/survey51-270.jpg', 1),
(271, 5, 51, 1, 'Click', '2014-11-11 23:45:08', '2014-11-12 04:45:14', 72, 73, '', '', 1, 'domain/survey51-271.jpg', 1),
(272, 5, 51, 1, 'Click', '2014-11-11 23:45:10', '2014-11-12 04:45:14', 72, 73, '', '', 1, 'domain/survey51-272.jpg', 1),
(273, 5, 51, 1, 'Click', '2014-11-11 23:50:29', '2014-11-12 04:50:27', 72, 73, '', '', 1, 'domain/survey51-273.jpg', 1),
(274, 5, 51, 1, 'Click', '2014-11-11 23:54:43', '2014-11-12 04:54:42', 72, 73, '', '', 1, 'domain/survey51-274.jpg', 1),
(275, 5, 51, 1, 'Click', '2014-11-12 00:03:33', '2014-11-12 05:03:31', 72, 73, '', '', 1, 'domain/survey51-275.jpg', 1),
(276, 5, 51, 1, 'Click', '2014-11-12 00:08:15', '2014-11-12 05:08:13', 72, 73, '', '', 1, 'domain/survey51-276.jpg', 1),
(277, 5, 51, 1, 'Click', '2014-11-12 00:10:02', '2014-11-12 05:10:00', 72, 73, '', '', 1, 'domain/survey51-277.jpg', 1),
(278, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:37', 30, 40, '', '', 1, 'domain/survey58-278.jpg', 1),
(279, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:48', 30, 40, '', '', 1, 'domain/survey58-279.jpg', 1),
(280, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:49', 30, 40, '', '', 1, 'domain/survey58-280.jpg', 1),
(281, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:50', 30, 40, '', '', 1, 'domain/survey58-281.jpg', 1),
(282, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:50', 30, 40, '', '', 1, 'domain/survey58-282.jpg', 1),
(283, 5, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 05:25:51', 30, 40, '', '', 1, 'domain/survey58-283.jpg', 1),
(287, 18, 64, 1, 'A', '2014-11-12 01:45:42', '2014-11-12 06:46:00', 60, 70, '', 'Acer rubrum (red maple)', 0, 'domain/survey64-287.jpg', 1),
(288, 18, 64, 1, 'A', '2014-11-12 02:14:05', '2014-11-12 07:14:49', 60, 70, 'i', 'Acer rubrum (red maple)', 4, 'domain/survey64-288.jpg', 1),
(289, 18, 65, 4, 'D', '2014-11-12 08:16:13', '2014-11-12 13:19:42', 60, 70, 'rainy day ', 'Carya alba (mockernut hickory)', 2, 'domain/survey65-289.jpg', 1),
(290, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:22:49', 30, 40, '', '', 1, 'domain/survey58-290.jpg', 1),
(291, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:22:56', 30, 40, '', '', 1, 'domain/survey58-291.jpg', 1),
(292, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:23:07', 30, 40, '', '1', 1, 'domain/survey58-292.jpg', 1),
(293, 6, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:24:55', 30, 40, '', '', 1, 'domain/survey58-293.jpg', 1),
(294, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:25:52', 30, 40, '', '', 1, 'domain/survey58-294.jpg', 1),
(295, 9, 58, 1, 'A', '0000-00-00 00:00:00', '2014-11-12 13:26:10', 30, 40, '', '', 1, 'domain/survey58-295.jpg', 1),
(296, 18, 64, 7, 'C', '2014-11-12 08:32:13', '2014-11-12 14:36:31', 60, 70, 'notes', 'UNC Students', 3, 'domain/survey64-296.jpg', 1),
(297, 5, 68, 1, 'Click', '2014-11-17 23:42:45', '2014-11-18 04:42:43', 72, 73, '', '', 1, 'domain/survey68-297.jpg', 1),
(298, 5, 67, 1, 'Click', '2014-11-18 21:55:40', '2014-11-19 02:55:39', 72, 73, '', '', 1, 'domain/survey67-298.jpg', 1),
(299, 18, 64, 1, 'A', '2014-11-23 08:51:57', '2014-11-23 13:52:11', 60, 70, 'h', 'Acer rubrum (red maple)', 0, 'domain/survey64-299.jpg', 1),
(300, 5, 51, 6, 'E', '2014-11-24 10:03:58', '2014-11-24 15:03:58', 72, 73, '', 'Jan', 1, 'domain/survey51-300.jpg', 1),
(301, 18, 64, 1, 'A', '2014-12-01 15:45:25', '2014-12-01 20:51:32', 60, 70, '', 'picea rubens', 2, 'domain/survey64-301.jpg', 1),
(302, 18, 64, 1, 'A', '2014-12-01 15:45:25', '2014-12-01 20:53:12', 60, 70, '', 'picea rubens', 2, 'domain/survey64-302.jpg', 1),
(303, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:51:17', 30, 40, '', '', 1, 'domain/survey58-303.jpg', 1),
(304, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:51:23', 30, 40, '', '', 1, 'domain/survey58-304.jpg', 1),
(305, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:53:37', 30, 40, '', '', 1, 'domain/survey58-305.jpg', 1),
(306, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:54:35', 30, 40, '', '', 1, 'domain/survey58-306.jpg', 1),
(307, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:56:45', 30, 40, '', '', 1, 'domain/survey58-307.jpg', 1),
(308, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:57:15', 30, 40, '', '', 1, 'domain/survey58-308.jpg', 1),
(309, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:57:36', 30, 40, '', '', 1, 'domain/survey58-309.jpg', 1),
(310, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 12:58:24', 30, 40, '', '', 1, 'domain/survey58-310.jpg', 1),
(311, 7, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 18:24:09', 30, 40, '', '', 1, 'domain/survey58-311.jpg', 1),
(312, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-02 18:24:23', 30, 40, '', '', 1, 'domain/survey58-312.jpg', 1),
(313, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 19:55:58', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-313.jpg', 1),
(314, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:01:14', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/--survey1-314.jpg', 1),
(315, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:01:40', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain--survey1-315.jpg', 1),
(316, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:03:53', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain//survey1-316.jpg', 1),
(317, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:04:06', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-317.jpg', 1),
(318, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:04:16', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-318.jpg', 1),
(319, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:09:13', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-319.jpg', 1),
(320, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:10:46', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-320.jpg', 1),
(321, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:11:02', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploadss/survey1-321.jpg', 1),
(322, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:11:30', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-322.jpg', 1),
(323, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:22:59', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-323.jpg', 1),
(324, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:24:12', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-324.jpg', 1),
(325, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:24:45', 72, 73, 'siteNote', 'plantSpecies', 4, 'domain/survey1-325.jpg', 1),
(326, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:27:41', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-326.jpg', 1),
(327, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:27:44', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-327.jpg', 1),
(328, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:33:19', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-328.jpg', 1),
(329, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:36:27', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-329.jpg', 1),
(330, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:41:03', 72, 73, 'siteNote', 'plantSpecies', 4, '', 1),
(331, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:41:37', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-331.jpg', 1),
(332, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:42:04', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-332.jpg', 1),
(333, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:44:17', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(334, 5, 1, 0, '', '1900-01-01 12:00:00', '2014-12-02 20:45:15', 0, 0, NULL, '', 0, 'uploads/survey1-334.jpg', 1),
(335, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:45:19', 72, 73, 'siteNote', 'plantSpecies', 4, '', 1),
(336, 5, 1, 0, '', '1900-01-01 12:00:00', '2014-12-02 20:45:26', 0, 0, NULL, '', 0, 'uploads/survey1-336.jpg', 1),
(337, 5, 1, 0, '', '1900-01-01 12:00:00', '2014-12-02 20:45:28', 0, 0, NULL, '', 0, 'uploads/survey1-337.jpg', 1),
(338, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:45:58', 72, 73, 'siteNote', 'plantSpecies', 4, '', 1),
(339, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:46:50', 72, 73, 'siteNote', 'plantSpecies', 4, '', 1),
(340, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:48:15', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(341, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:49:55', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(342, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:50:12', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(343, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:56:35', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(344, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:56:49', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(345, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:57:00', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads//', 1),
(346, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:57:14', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads//', 1),
(347, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 20:59:23', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(348, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:00:00', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(349, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:00:36', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(350, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:00:50', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(351, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:01:42', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/', 1),
(352, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:02:24', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-352.jpg', 1),
(353, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:02:48', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-353.jpg', 1),
(354, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:04:55', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-354.jpg', 1),
(355, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:10:12', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-355.jpg', 1),
(356, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:14:09', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-356.jpg', 1),
(357, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:16:40', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-357.jpg', 1),
(358, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:18:58', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-358.jpg', 1),
(359, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:19:10', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-359.jpg', 1),
(360, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:20:37', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-360.jpg', 1),
(361, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:21:15', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-361.jpg', 1),
(362, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:23:40', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-362.jpg', 1),
(363, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:34:19', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-363.jpg', 1),
(364, 4, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:35:07', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-364.jpg', 1),
(365, 4, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-02 21:36:11', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-365.jpg', 1),
(366, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-03 09:30:02', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-366.jpg', 1),
(367, 3, 58, 1, 'A', '0000-00-00 00:00:00', '2014-12-03 09:30:36', 20, 30, '', '', 0, 'uploads/survey58-367.jpg', 1),
(368, 3, 1, 1, 'a', '2014-10-13 12:06:02', '2014-12-03 09:48:32', 72, 73, 'siteNote', 'plantSpecies', 4, 'uploads/survey1-368.jpg', 0),
(369, 3, 58, 5, 'C', '2014-12-03 05:00:00', '2014-12-03 10:08:01', 60, 70, '', '', 0, 'uploads/survey58-369.jpg', 1),
(370, 18, 64, 1, 'A', '2014-12-03 08:01:20', '2014-12-03 13:20:29', 60, 70, 'g', 'Acer rubrum (red maple)', 0, 'uploads/survey64-370.jpg', 1),
(371, 5, 67, 3, 'D', '2014-12-03 08:20:36', '2014-12-03 13:20:37', 72, 73, '', 'Gg', 1, 'uploads/survey67-371.jpg', 1),
(372, 5, 67, 2, 'C', '2014-12-03 08:21:38', '2014-12-03 13:21:38', 72, 73, 'Mm', 'Mm', 1, 'uploads/survey67-372.jpg', 1),
(373, 5, 67, 2, 'C', '2014-12-03 08:21:54', '2014-12-03 13:21:53', 72, 73, 'Mm', 'Mm', 1, 'uploads/survey67-373.jpg', 1),
(374, 5, 67, 2, 'C', '2014-12-03 08:32:21', '2014-12-03 13:32:21', 72, 73, '', 'R', 1, 'uploads/survey67-374.jpg', 1),
(375, 5, 67, 1, 'B', '2014-12-03 08:36:13', '2014-12-03 13:36:13', 72, 73, '', 'N', 1, 'uploads/survey67-375.jpg', 1),
(376, 5, 67, 2, 'E', '2014-12-03 08:37:18', '2014-12-03 13:37:18', 72, 73, 'N', 'K', 1, 'uploads/survey67-376.jpg', 1),
(377, 5, 67, 2, 'C', '2014-12-03 08:48:48', '2014-12-03 13:48:47', 72, 73, '', 'Mm', 1, 'uploads/survey67-377.jpg', 1),
(378, 117, 69, 2, 'B', '0000-00-00 00:00:00', '2014-12-03 17:53:28', 50, 60, '', '', 3, 'uploads/survey69-378.jpg', 1),
(379, 117, 69, 4, 'A', '2014-12-03 10:00:00', '2014-12-05 18:27:17', 60, 70, '', 'White Oak', 1, 'uploads/survey69-379.jpg', 1),
(380, 10, 76, 2, 'C', '2014-12-05 13:31:56', '2014-12-05 18:31:56', 72, 73, 'Sjh', 'Nj', 1, 'uploads/survey76-380.jpg', 1),
(381, 117, 69, 3, 'D', '2014-12-03 14:00:00', '2014-12-05 19:47:21', 60, 70, '', 'Ironwood', 0, 'uploads/survey69-381.jpg', 1),
(382, 117, 69, 1, 'A', '2014-12-03 14:30:00', '2014-12-05 19:59:14', 70, 80, '', 'American Holly', 0, 'uploads/survey69-382.jpg', 1),
(383, 3, 58, 1, 'A', '2014-12-10 13:00:00', '2014-12-05 22:37:31', 50, 60, '', '', 1, 'uploads/survey58-383.jpg', 1),
(384, 18, 64, 1, 'A', '2014-12-05 20:20:42', '2014-12-06 01:21:37', 60, 70, 'hd', 'Acer rubrum (red maple)', 2, 'uploads/survey64-384.jpg', 1),
(385, 3, 79, 3, 'D', '2014-12-09 03:01:00', '2014-12-06 03:30:38', 30, 40, '', '', 1, 'uploads/survey79-385.jpg', 1),
(386, 3, 79, 2, 'E', '2014-12-05 22:45:00', '2014-12-06 03:49:28', 50, 60, '', '', 0, 'uploads/survey79-386.jpg', 0),
(387, 123, 64, 1, 'A', '0000-00-00 00:00:00', '2014-12-06 05:53:40', 60, 70, '', 'Diospyros virginiana (common persimmon)', 3, 'uploads/survey64-387.jpg', 1),
(388, 123, 64, 1, 'A', '0000-00-00 00:00:00', '2014-12-06 05:54:53', 60, 70, '', 'Diospyros virginiana (common persimmon)', 3, 'uploads/survey64-388.jpg', 1),
(389, 123, 64, 1, 'A', '0000-00-00 00:00:00', '2014-12-06 05:56:58', 60, 70, '', 'Diospyros virginiana (common persimmon)', 3, 'uploads/survey64-389.jpg', 1),
(390, 123, 64, 1, 'A', '2014-10-24 08:00:36', '2014-12-06 06:00:41', 40, 50, '', 'Diospyros virginiana (common persimmon)', 3, 'uploads/survey64-390.jpg', 1),
(391, 18, 64, 1, 'A', '2014-12-06 01:10:50', '2014-12-06 06:11:37', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-391.jpg', 1),
(392, 3, 79, 2, 'E', '2014-12-09 01:53:00', '2014-12-06 06:54:00', 40, 50, '', '', 4, 'uploads/survey79-392.jpg', 1),
(393, 3, 79, 3, 'B', '2014-12-06 02:04:00', '2014-12-06 07:05:33', 40, 50, '', '', 0, 'uploads/survey79-393.jpg', 1),
(394, 10, 80, 2, 'C', '2014-12-06 07:34:54', '2014-12-06 12:34:54', 72, 73, '', 'Bb', 1, 'uploads/survey80-394.jpg', 1),
(395, 18, 64, 1, 'A', '2014-12-06 07:35:07', '2014-12-06 12:36:28', 60, 70, 'g', 'Acer rubrum (red maple)', 0, 'uploads/survey64-395.jpg', 1),
(396, 18, 64, 1, 'A', '2014-12-06 07:35:07', '2014-12-06 12:38:16', 60, 70, 'g', 'Acer rubrum (red maple)', 0, 'uploads/survey64-396.jpg', 1),
(397, 10, 80, 3, 'D', '2014-12-06 07:38:43', '2014-12-06 12:38:44', 72, 73, '', 'B', 1, 'uploads/survey80-397.jpg', 1),
(398, 10, 80, 3, 'D', '2014-12-06 07:38:44', '2014-12-06 12:38:45', 72, 73, '', 'B', 1, 'uploads/survey80-398.jpg', 1),
(399, 18, 64, 1, 'A', '2014-12-06 07:40:25', '2014-12-06 12:40:43', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-399.jpg', 1),
(400, 5, 67, 2, 'C', '2014-12-06 07:41:13', '2014-12-06 12:41:14', 72, 73, '', 'Mm', 1, 'uploads/survey67-400.jpg', 1),
(401, 18, 64, 1, 'A', '2014-12-06 07:40:25', '2014-12-06 12:42:11', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-401.jpg', 1),
(402, 18, 64, 1, 'A', '2014-12-06 07:42:29', '2014-12-06 12:43:15', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-402.jpg', 1),
(403, 18, 64, 1, 'A', '2014-12-06 07:45:48', '2014-12-06 12:46:43', 50, 60, 'tdgf', 'Acer rubrum (red maple)', 0, 'uploads/survey64-403.jpg', 1),
(404, 18, 64, 1, 'A', '2014-12-06 08:16:56', '2014-12-06 13:17:25', 60, 70, 'j', 'Acer rubrum (red maple)', 0, 'uploads/survey64-404.jpg', 1),
(405, 18, 64, 1, 'A', '2014-12-06 08:16:56', '2014-12-06 13:17:55', 60, 70, 'j', 'Acer rubrum (red maple)', 0, 'uploads/survey64-405.jpg', 1),
(406, 117, 75, 6, 'E', '2014-12-05 09:15:00', '2014-12-06 14:13:24', 40, 50, '', 'Acer rubrum (red maple)', 1, 'uploads/survey75-406.jpg', 1),
(407, 18, 64, 1, 'A', '2014-12-06 08:20:15', '2014-12-06 14:16:07', 80, 90, 'j', 'Quercus nigra (water oak)', 0, 'uploads/survey64-407.jpg', 1),
(408, 18, 80, 3, 'D', '2014-12-06 09:30:07', '2014-12-06 14:30:09', 72, 73, '', 'n', 1, 'uploads/survey80-408.jpg', 1),
(409, 18, 80, 3, 'D', '2014-12-06 09:30:09', '2014-12-06 14:30:11', 72, 73, '', 'n', 1, 'uploads/survey80-409.jpg', 1),
(410, 18, 80, 3, 'D', '2014-12-06 09:30:05', '2014-12-06 14:30:11', 72, 73, '', 'n', 1, 'uploads/survey80-410.jpg', 1),
(411, 18, 80, 3, 'D', '2014-12-06 09:30:09', '2014-12-06 14:30:13', 72, 73, '', 'n', 1, 'uploads/survey80-411.jpg', 1),
(412, 18, 80, 3, 'D', '2014-12-06 09:30:10', '2014-12-06 14:30:15', 72, 73, '', 'n', 1, 'uploads/survey80-412.jpg', 1),
(413, 18, 80, 3, 'D', '2014-12-06 09:30:10', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-413.jpg', 1),
(414, 18, 80, 3, 'D', '2014-12-06 09:30:10', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-414.jpg', 1),
(415, 18, 80, 3, 'D', '2014-12-06 09:30:12', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-415.jpg', 1),
(416, 18, 80, 3, 'D', '2014-12-06 09:30:12', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-416.jpg', 1),
(417, 18, 80, 3, 'D', '2014-12-06 09:30:13', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-417.jpg', 1),
(418, 18, 80, 3, 'D', '2014-12-06 09:30:12', '2014-12-06 14:30:16', 72, 73, '', 'n', 1, 'uploads/survey80-418.jpg', 1),
(419, 10, 80, 3, 'D', '2014-12-06 09:31:05', '2014-12-06 14:31:05', 72, 73, '', 'b', 1, 'uploads/survey80-419.jpg', 1),
(420, 117, 69, 1, 'A', '2014-12-06 09:31:00', '2014-12-06 14:34:45', 40, 50, '', 'Nice presentation so far...', 4, 'uploads/survey69-420.jpg', 1),
(421, 18, 64, 1, 'A', '2014-12-06 09:38:30', '2014-12-06 14:42:16', 60, 70, 'gdhv', 'Gordonia lasianthus (loblolly bay)', 4, 'uploads/survey64-421.jpg', 1),
(422, 18, 67, 2, 'B', '2014-12-06 09:42:17', '2014-12-06 14:42:16', 72, 73, 'Nah', 'Test', 1, 'uploads/survey67-422.jpg', 1),
(423, 3, 58, 6, 'C', '2014-12-03 09:44:00', '2014-12-06 14:45:27', 40, 50, '', '', 0, 'uploads/survey58-423.jpg', 1),
(424, 117, 69, 2, 'C', '2014-12-10 16:37:00', '2014-12-11 22:06:55', 40, 50, '', 'Carya tomentosa', 2, 'uploads/survey69-424.jpg', 1),
(425, 5, 69, 5, 'A', '2014-12-15 21:04:39', '2014-12-16 02:04:40', 72, 73, '', 'Acer rubrum', 1, 'uploads/survey69-425.jpg', 1),
(426, 5, 69, 5, 'A', '2014-12-15 21:04:43', '2014-12-16 02:04:40', 72, 73, '', 'Acer rubrum', 1, 'uploads/survey69-426.jpg', 1),
(427, 5, 69, 2, 'B', '2014-12-16 21:27:48', '2014-12-17 02:27:50', 72, 73, '', 'From site 117', 1, 'uploads/survey69-427.jpg', 1),
(428, 5, 69, 2, 'B', '2014-12-16 21:27:51', '2014-12-17 02:27:50', 72, 73, '', 'From site 117', 1, 'uploads/survey69-428.jpg', 1),
(429, 18, 64, 1, 'A', '2014-12-17 10:59:54', '2014-12-17 16:00:57', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-429.jpg', 1),
(430, 18, 64, 1, 'A', '2014-12-17 10:59:54', '2014-12-17 16:01:23', 60, 70, '', 'Acer rubrum (red maple)', 0, 'uploads/survey64-430.jpg', 1),
(431, 117, 64, 1, 'A', '2014-12-17 11:16:05', '2014-12-17 16:17:46', 60, 70, '', 'Carpinus caroliniana (American hornbeam)', 1, 'uploads/survey64-431.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `saltHash` varchar(77) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` smallint(1) NOT NULL DEFAULT '0',
  `validUser` smallint(1) NOT NULL DEFAULT '1',
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilegeLevel` int(2) DEFAULT '0',
  `recoveryToken` varchar(5) DEFAULT 'xxxxx',
  `recoveryDate` date DEFAULT '1000-01-01',
  PRIMARY KEY (`userID`),
  KEY `privilegeLevel` (`privilegeLevel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `email`, `saltHash`, `name`, `active`, `validUser`, `timeStamp`, `privilegeLevel`, `recoveryToken`, `recoveryDate`) VALUES
(1, 'pintianz@yahoo.com', 'sha256:1000:uBQreSp/k4jzABrcvZs11mMd/byASstj:cEz7svbrKLncMrt5bSIiHrmkb3HMe+dN', 'test name', 1, 1, '2014-10-06 23:13:31', 10, 'xxxxx', '1000-01-01'),
(4, 'yinan_fang@hotmail.com', 'sha256:1000:cz2hgNLmPyr+fbJghqrsp6EdbbA1cvIv:m4KE8E4TfZerAfVwREjaX2UXgDkLgbWi', 'Yinan Fang', 0, 0, '2014-10-08 13:16:58', 0, 'xxxxx', '1000-01-01'),
(5, '', 'sha256:1000:7OIUh0/C/umOOiT055pbxrgtALto9tvm:St53+5qgaVmsOLWy9cnub1f1x160/fkj', ' ', 0, 1, '2014-10-08 13:29:53', 0, 'xxxxx', '1000-01-01'),
(6, 'Sksbsb', 'sha256:1000:M82+7K7FooaKZNOpvD+p9P//cEyMtAFs:FhF1vidECKBKmbDVuMYByWGPKo7Munri', 'Akabks Ksnsn', 0, 1, '2014-10-08 13:31:08', 0, 'xxxxx', '1000-01-01'),
(7, 'yinan_fang@hotmail.com11', 'sha256:1000:wJdaI0w3C9ZPz0JuStLmJU+0T5/Gw8RQ:MiWRSq0EaMobGzfaXgtrwnGHTKSX/uFr', 'Yinan Fang', 0, 1, '2014-10-08 13:45:41', 0, 'xxxxx', '1000-01-01'),
(8, 'yinan_fang@hotmail.com13', 'sha256:1000:lE/s1B+a8/1cO/aCene222xgZd3VwqsW:/OUph4HvHAOmFLb6GpznMBzxEVUIaFbV', 'Yinan Fang', 0, 1, '2014-10-09 03:05:12', 0, 'xxxxx', '1000-01-01'),
(9, 'yinan_fang@hotmail.com14', 'sha256:1000:1jXKOYPJUB+NiyQvlrzyMKg/4HD2XmR5:Hz1m/meZMSl//dimhibnA7YxLo4n4jrV', 'Yinan Fang', 0, 1, '2014-10-09 03:35:09', 0, 'xxxxx', '1000-01-01'),
(10, 'yinan_fang@hotmail.com15', 'sha256:1000:0pfYlHxX9PpSVwE46rmUKADclCLd9vrC:0TaIcHi44I1hX3cu5upKMO95otAr5//o', 'Yinan Fang', 0, 1, '2014-10-09 03:38:29', 0, 'xxxxx', '1000-01-01'),
(11, 'yinan_fang@hotmail.com16', 'sha256:1000:mAVA276BlhQFigGvmWJsE/P/xZmEm3MJ:wiuiPw8Z21iuyvxkDbeaJV+MKQQoPKaM', 'Yinan Fang', 0, 1, '2014-10-09 03:43:50', 0, 'xxxxx', '1000-01-01'),
(12, 'yinan_fang@hotmail.com17', 'sha256:1000:YMTfFVBBR/ZLvbbcZZ/9ZdlF8WeA7tfN:FIIJzMVY9TvL2ELUmm/Yp2OY+2UlY7pa', 'Yinan Fang', 0, 1, '2014-10-09 23:16:47', 0, 'xxxxx', '1000-01-01'),
(13, 'yinan_fang@hotmail.com18', 'sha256:1000:17WGd1E7xzzSS5rvRJ5uAzKPk64kZc9M:EEKG/OdNJOQfRliOlllbrFKu3aqDFNxM', 'Yinan Fang', 0, 1, '2014-10-09 23:18:00', 0, 'xxxxx', '1000-01-01'),
(14, 'yinan_fang@hotmail.com19', 'sha256:1000:uId4PAp29pEw+hEplk5Mrf4C5QOO34C3:UQT+YQRPidpIt22yFyaPGq/2fb0gAIjK', 'Yinan Fang', 0, 1, '2014-10-09 23:19:07', 0, 'xxxxx', '1000-01-01'),
(15, 'yinan_fang@hotmail.com20', 'sha256:1000:9ZTqWHDtpAfnNKT/FXAUSoZZjVY6NLyF:Gm0R5fQIEqhg8+ky0MFkJ3733bmHKxGB', 'Yinan Fang', 0, 1, '2014-10-10 00:02:09', 0, 'xxxxx', '1000-01-01'),
(16, 'yinan_fang@hotmail.com21', 'sha256:1000:ca+VmxJTsds0KvQnQBTm6uT0zs0V4k2v:sRbub6vwGmZzfgqvWAG0UNtf+5lIidSM', 'Yinan Fang', 0, 1, '2014-10-10 00:04:38', 0, 'xxxxx', '1000-01-01'),
(17, 'yinan_fang@hotmail.com22', 'sha256:1000:8on0xEJ56G49ZZx044YC2Ooa+lTIQw53:Qm3GE/g7kYury4yO/ScDoL637S6+kmGq', 'Yinan Fang', 0, 1, '2014-10-10 00:22:09', 0, 'xxxxx', '1000-01-01'),
(18, 'yinan_fang@hotmail.com23', 'sha256:1000:jRVezCXhkaNW5a93uT6AqINduDMmG3ij:th9geXyyt5Nvg+q5vuIQ6O/gR/FtlIBk', 'Yinan Fang', 0, 1, '2014-10-10 00:22:37', 0, 'xxxxx', '1000-01-01'),
(19, 'yinan_fang@hotmail.com24', 'sha256:1000:79Um/mhozDSDoq0uoQLlWEh/XDquQAZQ:L3cdL4e1TPe4fcPLJrzmOZYkwqxrjNuW', 'Yinan Fang', 0, 1, '2014-10-10 00:25:11', 0, 'xxxxx', '1000-01-01'),
(20, 'yinan_fang@hotmail.com25', 'sha256:1000:Uu8L6n2s9syWG2iyM5bIqf5mQgPgO60T:ivNyrxEp+jTYJnMxn7poqwk8X6Sqg4Aa', 'Yinan Fang', 0, 1, '2014-10-10 00:29:17', 0, 'xxxxx', '1000-01-01'),
(21, 'yinan_fang@hotmail.com26', 'sha256:1000:4JI5Z8hZWPtd2akmHhwjICw1U0vgjXMX:XK/6AFr+efrTBDqDd50r+Mmn+HhmGAwh', 'Yinan Fang', 0, 1, '2014-10-10 00:34:26', 0, 'xxxxx', '1000-01-01'),
(22, 'yinan_fang@hotmail.com27', 'sha256:1000:FLEbTgQqfSi+giMHVpLMCtKp+jNPbWQ1:6DEuddpWx+PnpvWcHmTQPP8AP7VkWfG6', 'Yinan Fang', 0, 1, '2014-10-10 00:38:27', 0, 'xxxxx', '1000-01-01'),
(23, 'yinan_fang@hotmail.com28', 'sha256:1000:vqiJOtCJk+dznosBjG/BMPvSi3jz7S4q:zXKGzy47KVh1e6O616wMEEZcOHcsikNP', 'Yinan Fang', 0, 1, '2014-10-10 13:45:59', 0, 'xxxxx', '1000-01-01'),
(24, 'yinan_fang@hotmail.com29', 'sha256:1000:Tb+4VUwhSdkZP9X44/CFVIxgiaKrFMmO:IeKEGwV9dLBZN1FwMXthZno464lni1dn', 'Yinan Fang', 0, 1, '2014-10-12 01:15:58', 0, 'xxxxx', '1000-01-01'),
(25, 'yinan_fang@hotmail.com30', 'sha256:1000:PignTjEbzcOa+IPGVVRP7bqf4elq+5BQ:8uTym96zdPl1/XxBI0/JOx8e8+6NZ/aW', 'Yinan Fang', 0, 1, '2014-10-12 01:27:21', 0, 'xxxxx', '1000-01-01'),
(26, 'yinan_fang@hotmail.com31', 'sha256:1000:pQnmUGenNVl23SehCyMXwf9mGzBttW5r:XjTkr9mbezzey2YUWTlQYiWWHGuNBjVp', 'Yinan Fang', 0, 1, '2014-10-12 14:37:02', 0, 'xxxxx', '1000-01-01'),
(27, 'yinan_fang@hotmail.com32', 'sha256:1000:xoAbWRYpq2DNVdpqjBJ4YhZ6Zmdz+ae8:MGf4MFPefXuRoWF+p8kauXpClzqw1A1T', 'Yinan Fang', 0, 1, '2014-10-12 14:42:26', 0, 'xxxxx', '1000-01-01'),
(28, 'yinan_fang@hotmail.com111', 'sha256:1000:/pxxxYHiu3eDOzAZUd+i6tNIpS0xSUPd:ZM1JmBmlAM5jdZ1uoATeAqdQdVu/+wI9', 'Yinan Fang', 0, 1, '2014-10-14 18:06:09', 0, 'xxxxx', '1000-01-01'),
(29, 'yinan_fang@hotmail.com112', 'sha256:1000:HlToqvUhETGFoOk/JTELZJXkGoDzyGYh:RjgXKOiqt/bZJpizP70RxZKBr3ipuJk1', 'Yinan Fang', 0, 1, '2014-10-14 18:11:36', 0, 'xxxxx', '1000-01-01'),
(30, 'yinan_fang@hotmail.com113', 'sha256:1000:deNrzPAV+oURHN3JzGQr8EwxLrUGye24:FXAfPljo+MMoTJJFonSvlOhXagGZ81ut', 'Yinan Fang', 0, 1, '2014-10-14 18:13:21', 0, 'xxxxx', '1000-01-01'),
(31, 'yinan_fang@hotmail.com114', 'sha256:1000:IOd5kj/ilpoJEudzQaRY6Or8jIEcVWZP:gGGdo2J7XP+2f02ja5nhBOORlArc3ta9', 'Yinan Fang', 0, 1, '2014-10-14 18:14:39', 0, 'xxxxx', '1000-01-01'),
(32, 'yinan_fang@hotmail.com115', 'sha256:1000:LKT23pimYAxeEkt6Hiy/f6vbpGknh6Gz:p+FwLDGicfyYYPIDgILo9WP9hbeW0qUk', 'Yinan Fang', 0, 1, '2014-10-14 18:20:15', 0, 'xxxxx', '1000-01-01'),
(33, 'yinan_fang@hotmail.com116', 'sha256:1000:LTSohsxIZGbtPd5Y8pk7iLw/Yx3WIcB8:dVH47DvAc+f+BQcTaHNg8q1oqBiFBRJi', 'Yinan Fang', 0, 1, '2014-10-14 18:21:53', 0, 'xxxxx', '1000-01-01'),
(34, 'yinan_fang@hotmail.com118', 'sha256:1000:VG1u2Km/CjdI+/jhMAsfuTBei8MuTFh+:J3wcMEYzkovkMrXNOIO7qKUJeTJxk/U+', 'Yinan Fang', 0, 1, '2014-10-14 18:27:56', 0, 'xxxxx', '1000-01-01'),
(35, 'yinan_fang@hotmail.com119', 'sha256:1000:518r3a3acyhnuXvyrpjghYUTDHeJBKJk:UZzxmV7LD2Y0loT8GsGjBy5mm256xphd', 'Yinan Fang', 0, 1, '2014-10-14 20:24:39', 0, 'xxxxx', '1000-01-01'),
(36, 'yinan_fang@hotmail.com120', 'sha256:1000:GFjO8Fzc57yod5IPLxAx98DWoC9yhmDw:bnbmb2JoaKMlB2DWyaJwqrzTlF/G6uu9', 'Yinan Fang', 0, 1, '2014-10-14 20:37:31', 0, 'xxxxx', '1000-01-01'),
(37, 'yinan_fang@hotmail.com122', 'sha256:1000:xaXzums/sOBZBF7ZVZSaN81hQ4ybuZx3:skzTwChwsqv9hiNbnTQNBRh1MZjAy906', 'Yinan Fang', 0, 1, '2014-10-14 23:16:37', 0, 'xxxxx', '1000-01-01'),
(38, 'yinan_fang@hotmail.com123', 'sha256:1000:TucZ3pDqZ4Cig1wQUdNVYKd3LTtg5hOA:iSnIQp6WclSgdL79WXZz+19vAFNyua1D', 'Yinan Fang', 0, 1, '2014-10-15 03:09:10', 0, 'xxxxx', '1000-01-01'),
(39, 'yinan_fang@hotmail.com124', 'sha256:1000:rdxXhu0e96iTrkD0cclN46wLLtpTSYfo:KGEpKVN+OFShHrgYlYCi/JQpEcnDxDZ8', 'Yinan Fang', 0, 1, '2014-10-15 03:28:01', 0, 'xxxxx', '1000-01-01'),
(40, 'yinan_fang@hotmail.com126', 'sha256:1000:J63JxqeFAZS0cel8wm6LxFx8ZA3B4Mb9:PETceA5ASY5xKEKUWxQcIh956H4NOKVe', 'Yinan Fang', 0, 1, '2014-10-15 03:44:16', 0, 'xxxxx', '1000-01-01'),
(41, 'yinan_fang@hotmail.com127', 'sha256:1000:smFGoSVburKLTJr7HF1qpn4d7XBwMcJL:3vWpM43h2COegdf9pPDI5NyvL7Aq19yC', 'Yinan Fang', 0, 1, '2014-10-15 05:32:55', 0, 'xxxxx', '1000-01-01'),
(42, 'yinan_fang@hotmail.com128', 'sha256:1000:0E1i5nLOr0kHN6Cdn9zqFvO5kBRgWZbK:+Skq/fMGzp8MijRHA4z/okNJ21ChdXnE', 'Yinan Fang', 0, 1, '2014-10-15 06:16:26', 0, 'xxxxx', '1000-01-01'),
(43, 'yinan_fang@hotmail.com129', 'sha256:1000:w8Nz4nTJWKmhsqPiFa8wuKPp26/VmUqo:51IX2OOeL5HoXIa5zOd+Vpti+SaXfia8', 'Yinan Fang', 0, 1, '2014-10-15 07:17:59', 0, 'xxxxx', '1000-01-01'),
(44, 'yinan_fang@hotmail.com131', 'sha256:1000:prHsq2SghyMvcISkHXbrmIAmnxe4F5WQ:K8h0c3HStCQXM6D8m41JkO1mmFA4+zOg', 'Yinan Fang', 0, 1, '2014-10-15 07:38:55', 0, 'xxxxx', '1000-01-01'),
(45, 'yinan_fang@hotmail.com132', 'sha256:1000:LYVQ37quON56fPHsHkFr/ykQsVOBCQqs:KT5GTlk8tSSvPctaVKzJJUD+oXKLbgmL', 'Yinan Fang', 0, 1, '2014-10-15 07:41:06', 0, 'xxxxx', '1000-01-01'),
(46, 'yinan_fang@hotmail.com133', 'sha256:1000:zcoUpnzNa+rq95JfG2Aiv2pGmcoKPabB:K2i+uMcgaWZOvD5LQ/efosldAD3IdrCR', 'Yinan Fang', 0, 1, '2014-10-15 07:42:44', 0, 'xxxxx', '1000-01-01'),
(47, 'yinan_fang@hotmail.com134', 'sha256:1000:QidT7uRfFBO5Pdq02c8CsRpQxepwpTxX:Y6/sIAq5SkJ86Z4d9NURMOoh1z+qb1Zu', 'Yinan Fang', 0, 1, '2014-10-15 07:46:14', 0, 'xxxxx', '1000-01-01'),
(48, 'yinan_fang@hotmail.com135', 'sha256:1000:4t4cXS2z9qx+QNB6glptAatvN4MEHTvh:VIMw9BJteOQ81/TkzBSPro/0TPhLwsc3', 'Yinan Fang', 0, 1, '2014-10-15 07:49:54', 0, 'xxxxx', '1000-01-01'),
(49, 'jforcedev@gmail.com', 'sha256:1000:axTemU5OEMaB/m1AG0zKDyHWzQ9Ao+5H:afPg7IMhiMXcKSnw6u5soOiE/SFKyym0', 'Justin Forsyth', 1, 1, '2014-10-15 10:22:39', 0, 'xxxxx', '1000-01-01'),
(50, 'yinan_fang@hotmail.com137', 'sha256:1000:i6VA5HwBw9a1uzO8Lac+pvWj/oHJ0fh+:GpTn22X9apESPmSa2tOfnIt6FSe1e0ZC', 'Yinan Fang', 0, 1, '2014-10-15 11:59:06', 0, 'xxxxx', '1000-01-01'),
(51, 'yinan_fang@hotmail.com138', 'sha256:1000:slrSKn/hCagwD5OwgcmfXH6lbc01MOz4:fvL3NOvAZ8dAA+//o/oir5REkBvyov+o', 'Yinan Fang', 0, 1, '2014-10-15 12:31:33', 0, 'xxxxx', '1000-01-01'),
(52, 'yinan_fang@hotmail.com139', 'sha256:1000:NbInN5HVD++P6KbabMILBl+BpoLdckXo:Xq/2Q2bF4cqxPanH3RRsPejRWpotDZ3z', 'Yinan Fang', 0, 1, '2014-10-15 15:33:22', 0, 'xxxxx', '1000-01-01'),
(53, 'yinan_fang@hotmail.com140', 'sha256:1000:pv8g7ePUlm54DUc9+OUDZAYLsZ+gdHOm:wxxHm5qmd5TCesUfTGoCYRLM9Ug4S5Su', 'Yinan Fang', 0, 1, '2014-10-15 16:14:05', 0, 'xxxxx', '1000-01-01'),
(54, 'yinan_fang@hotmail.com141', 'sha256:1000:YaD/5JIhYOZKSwnwFP6thGWVKSD1N75a:72Jwv8GbaeXMvY8luKDYvFMnPYuv3GKN', 'Yinan Fang', 0, 1, '2014-10-15 16:15:01', 0, 'xxxxx', '1000-01-01'),
(55, 'yinan_fang@hotmail.com142', 'sha256:1000:yi7RJkHCPYf+Rd72+CIoqVmYDXhSRAeo:yu9SD0JO7SHXedvRemN920XfIaAVe7nu', 'Yinan Fang', 0, 1, '2014-10-15 16:16:23', 0, 'xxxxx', '1000-01-01'),
(56, 'yinan_fang@hotmail.com143', 'sha256:1000:4r3tdIEvuwbCAL3Sl5cExSL0P0W89tTP:7/erx8cEPLUn6T81TjPyxsB98SD9ZYXm', 'Yinan Fang', 0, 1, '2014-10-15 16:17:54', 0, 'xxxxx', '1000-01-01'),
(57, 'yinan_fang@hotmail.com144', 'sha256:1000:kP0zrR7gKUmwLv9/pGxq+BE+BR/b7eZ7:78Y8ivTTAUXnQK3WIQiTi9OYhQn2OwkJ', 'Yinan Fang', 0, 1, '2014-10-15 16:20:52', 0, 'xxxxx', '1000-01-01'),
(58, 'twgu11@gmail.com', 'sha256:1000:VaKLxY1ZoCSjxALMvXcBVBgFkBgmP3D+:SXBqhpZZMjRda5KK6V0AcwjCnC2e4v7c', 'Derek Gu', 1, 1, '2014-10-19 19:53:10', 5, 'xxxxx', '1000-01-01'),
(60, 'yinan_fang@hotmail.com145', 'sha256:1000:hfE+nzJ3xcVWnE8aNbX0R3EPm2qm96sM:hAOruTvuGJnBdv1qxcZj613c3X7BOVQX', 'Yinan Fang', 0, 1, '2014-10-20 18:49:36', 0, 'xxxxx', '1000-01-01'),
(61, 'pintianz55@yahoo.com', 'sha256:1000:qycbAJrbNzV0SmRZXt+ZJQJTI2FLxY1q:79afRZCVKyfLZmoL35uWTYTvQeZK+HZc', 'new name', 0, 1, '2014-10-23 20:58:59', 0, 'xxxxx', '1000-01-01'),
(63, 'pintianz2@yahoo.com', 'sha256:1000:lHm+Gz5lQ2kjVJET0BEBeuIAQXme7kOU:9Rb499cO+/WZ7AczEyfBuGaxcB5+qUHU', 'new name', 0, 1, '2014-10-24 15:27:56', 0, 'xxxxx', '1000-01-01'),
(64, 'jforsyth@unc.edu', 'sha256:1000:08SIH75sNS29XDwgDjxOlYuJRJEk9EYe:2nrO39mveCDNnFy+yz1B8QMAQV8Ta3qM', 'Justin Forsyth', 1, 1, '2014-11-12 06:44:51', 10, 'xxxxx', '1000-01-01'),
(65, 'pozefsky@cs.unc.edu', 'sha256:1000:BtTgFP/5ZnvIyGZGJ8scxnNcnlUSbRxC:+yJlahgDagSqW31xST8gMJXo/iYqkAzr', 'Diane Pozefsky', 1, 1, '2014-11-12 13:13:45', 0, 'xxxxx', '1000-01-01'),
(66, 'pintianz5@yahoo.com', 'sha256:1000:iKOItWQ5hDEZtG1sHU4ifi27dy7gHlKZ:h5PqfESNYbPcAG1BHtzFX+pq6o+OWf1P', 'new name', 0, 1, '2014-11-17 15:10:07', 5, 'xxxxx', '1000-01-01'),
(67, 'test@gmail.com', 'sha256:1000:ogIGNjwsG5G2nEQca9aWCb0jZF1TOLOR:yMthWN8VNWInk0UbZEk9Pv3DynUDAiow', 'Yinan Fang', 1, 1, '2014-11-18 04:12:38', 0, 'xxxxx', '1000-01-01'),
(68, 'Jsh@hsh.ei', 'sha256:1000:VPbGDDt3HX4/4Xz6SD/sXa27hHcLmwTQ:UHqk2/xSoO2Eoq/UBZEnCAd8u07f2VOt', 'G H', 0, 1, '2014-11-18 04:40:11', 0, 'xxxxx', '1000-01-01'),
(69, 'hurlbert@bio.unc.edu', 'sha256:1000:iatWBRnwN4e/mgjNnDSie1T3XG6yuYS7:9/KoRu03+RDgt7UqBX+rXC2/ZbGVpXTI', 'Allen Hurlbert', 1, 1, '2014-12-02 18:32:12', 10, 'xxxxx', '1000-01-01'),
(70, 'pintianz555@yahoo.com', 'sha256:1000:JEkkg4qKLmfjuDKqXO+G2vh0EnjlumMU:m1Ezu0VFCtEz587aFhAPURUN0FLmi1yd', 'new name', 0, 1, '2014-12-02 19:40:52', 0, 'xxxxx', '1000-01-01'),
(71, 'pintianz3@unc.edu', 'sha256:1000:jltFntMUUb6i2sduQfogLRpSplcT/EPB:Rw+Bh2Pp6vzs7aLNDnmCVnzGonUAu+yK', 'new name', 1, 0, '2014-12-02 19:41:09', 0, 'xxxxx', '1000-01-01'),
(72, '1', 'sha256:1000:BnLZq40VINaDhCF1P7n6ctGo3OXBAeYY:quOl0OFLE9l/Y8fM7AT+AIzXIpNVnU6Y', '3 4', 0, 1, '2014-12-03 11:06:47', 0, 'xxxxx', '1000-01-01'),
(73, 'gud@unc.edu', 'sha256:1000:iNtNvwL0pKh1tp6tawCjkqXir40k/4eg:pQiK9KHvY/x7a5vmb8wVxDb5UqtY1Bbb', 'Derek Gu2', 1, 1, '2014-12-03 11:11:15', 0, 'xxxxx', '1000-01-01'),
(74, 'ky19on@gmail.com', 'sha256:1000:EN7G43D9HeJxUSvmcQvbrqfBqPdSDPTv:xKonyT8HWHkbgZoFBbmavLgRVitqTho5', 'Derek Gu', 1, 1, '2014-12-03 11:13:37', 0, 'xxxxx', '1000-01-01'),
(75, 'father_of_hope@yahoo.com', 'sha256:1000:Is2qW/AUpcNPK2W1eMk+Hj7QNDVneUli:7DWpsYEXehuYi9OP4TJtomTAqz05/CyC', 'Test User', 1, 1, '2014-12-04 15:59:53', 0, 'WM1Qx', '2015-01-25'),
(76, 'Test2@gmail.com', 'sha256:1000:46RWmXnxFZUzLk8x5yQYTrryoumj9hqD:IkphNJIEVKllHw0YvJbjBVkM/wFeEX5M', 'hj Jn', 0, 1, '2014-12-05 18:29:59', 0, 'xxxxx', '1000-01-01'),
(78, 'pintianz@live.unc.edu', 'sha256:1000:udQyYUE3r18E4gidXFD3bzAHdrl9ktfb:W3ubAxn/EhbtEZQx3JEE+KEuWSSNo4Yi', 'new name', 0, 1, '2014-12-05 21:45:36', 0, 'xxxxx', '1000-01-01'),
(79, 'baizijiao@gmail.com', 'sha256:1000:5kuUI6juFUIjnxp5/oxwBQao++/Xgiq2:hf99xlbs5/YQHBNl50JSxAruaTjXyCNS', 'Zijiao Bai', 1, 1, '2014-12-06 03:20:46', 0, 'xxxxx', '1000-01-01'),
(80, 'Yinani@howb.dj', 'sha256:1000:C5QRinuyy/JmhMhWdhet/48rRQvCy5Rs:4/VxfCvUV/gSZhFd9m8LXsWKNGZWcjll', 'Test Sih', 0, 1, '2014-12-06 12:33:47', 0, 'xxxxx', '1000-01-01'),
(81, 'ahhurlbert@hotmail.com', 'sha256:1000:4dDXy0CPqQlK+F9HywyOHkicz7fR/gnc:BtqQAEl+gOs/GgaZkuS5glHkakI6M27i', 'Test User2', 1, 1, '2014-12-10 16:08:52', 0, 'xxxxx', '1000-01-01'),
(82, 'liza72836@gmail.com', 'sha256:1000:3sFUD4O/CsxlHjN1UmqJka08CWbZ6yvk:mhYvECcWoz4jDqIs3MFJPgO81R/wsZEk', 'Liza Liza', 1, 1, '2014-12-13 13:50:24', 0, 'xxxxx', '1000-01-01'),
(83, 'xpwhq@sina.com', 'sha256:1000:XjR/LtcFVU/vdgglOKSebMVpEDgB9QK4:2dmqbttAmzp3WUjAoD9c9R9nsCE0bvMI', 'Haiqin Wang', 1, 1, '2014-12-14 08:07:35', 0, 'xxxxx', '1000-01-01'),
(84, 'zhangyuanshan@126.com', 'sha256:1000:GXUfbubfL5wsUH81eFiaIsZn3ZyiUdpp:bHfL25eyFXcuAeWK4wrJsWzKYwEIYtGj', 'Z ya', 0, 1, '2014-12-22 01:58:21', 0, 'xxxxx', '1000-01-01'),
(85, '150200447@qq.com', 'sha256:1000:S7JMwjicxgiRaI9OJ7RGXSHp25DNeIG4:LldH9GIQOMOLTBc5yDAewG6F89MImWAK', 'Zhang Yuanshan', 0, 1, '2014-12-22 02:15:05', 0, 'xxxxx', '1000-01-01'),
(86, 'justin@forsyth.im', 'sha256:1000:FtWAVApm8rHpikmuJWu0wCSVWbrue1QM:UasT4zLdU52lYAvNYKQBLb1fT+LnRpXS', 'Justin Forsyth', 1, 1, '2015-01-02 14:45:47', 0, 'OYf4r', '2015-01-18'),
(87, 'hurlbert@email.unc.edu', 'sha256:1000:o9z6UJr6nOqVsXHubCI6I/OXw1yyM3UZ:CDd3bQR0S2CqRjKcQFmGsffsWA9AHauo', 'Test User3', 1, 1, '2015-01-02 20:55:11', 0, 'xxxxx', '1000-01-01'),
(88, 'EholZwarrh@gmail.com', 'sha256:1000:RsAJsDM4hVYDAmYgBblEaQsIWG6kfkSU:YTfNcDX6ZLTsNUiC/n4Ok9xOiiIuLv08', 'E H', 0, 1, '2015-01-05 21:59:14', 0, 'xxxxx', '1000-01-01'),
(89, 'brunomafini@hotmail.com', 'sha256:1000:fPzIRby9bsYjyvFtLM/HKo28q0yx/GSZ:OadV5h9o+ZMOIIAC7Q2s+K8oKQThp+V5', 'Bruno Mafini', 0, 1, '2015-01-07 18:29:35', 0, 'xxxxx', '1000-01-01'),
(90, 'hbhujb@mlklk.jnhj', 'sha256:1000:ptHsBuRYWtqvYYnEGruoxRJzN1FuxyiF:upc7N80GaSvmYRoaNVK02cJNexAjWAk5', 'knnbjknkj nkjkjn', 0, 1, '2015-01-09 01:22:27', 0, 'xxxxx', '1000-01-01'),
(91, 'rbrown@touchcare.com', 'sha256:1000:zGqjAiB5Ayu2p536eJb6E0Krrlu+t3dq:mgLlpWP7C+hbU991GxYA+wCWAQ94jivh', 'Robert Brown', 1, 1, '2015-01-16 15:02:08', 0, 'xxxxx', '1000-01-01'),
(92, 'touchcare1@gmail.com', 'sha256:1000:mIH56rj4/pHZaNbFTG5ZvfuSnOR8gbsc:fxm4fRK7muPHGgv0WNqUvkAJlkrzygNg', 'Tom Martin', 1, 1, '2015-01-16 15:04:26', 0, 'xxxxx', '1000-01-01'),
(93, 'lgstestx@gmail.com', 'sha256:1000:KkxWN3sYh5MELTv3ZaXqMc/KqbP1dE/0:rd6ONcpOfD3uHqrY2KDVceu8G7Jg/yLJ', 'S K', 0, 1, '2015-01-19 16:23:32', 0, 'xxxxx', '1000-01-01'),
(94, 'fake@fake.co', 'sha256:1000:evAXdh7Gy2IbLgKSZHGEcsAM4o3pQtOr:Wy8+VsO5xKps/vV+cMvxAzUTWa7y/DVc', 'mike tyson', 0, 1, '2015-01-19 20:40:12', 0, 'xxxxx', '1000-01-01'),
(95, 'justinhforsyth@gmail.com', 'sha256:1000:Obs//dQU86LhdJagi76+VsSV51H6CiQU:q4+eTrsk33o8snwQWKPusmABH1FYx3MZ', 'justin forsyth', 0, 1, '2015-01-20 21:32:41', 0, 'xxxxx', '1000-01-01'),
(96, 'baprice@live.unc.edu', 'sha256:1000:iWJEfvW9RUa4iZJczXVdBZua8eQuC8HF:cpRNp3kto36DCdWT8UBYJ+6IeMByLhVi', 'Brandon Price', 1, 1, '2015-01-23 16:28:40', 0, 'pdsE5', '2015-02-04'),
(97, 'hayeste@live.unc.edu', 'sha256:1000:3lZo3HpFkKOgYXCHRc6gM5J0yWl9QiS6:OLYWQtAs3fdS+k6rcdLE5DxAdkAzGig6', 'Tracie Hayes', 0, 1, '2015-01-28 15:06:12', 0, 'xxxxx', '1000-01-01'),
(98, 'nam@gmail.com', 'sha256:1000:zL81ULoZjW+PFt+0nNLtzcjjyw8Rpf2n:vyTG3qdVTd4yN7fhJtNMED5IrJVCxi4W', 'Nam 01', 0, 1, '2015-02-08 09:17:32', 0, 'xxxxx', '1000-01-01');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `surveyID_fk_in_orders` FOREIGN KEY (`surveyID`) REFERENCES `tbl_surveys` (`surveyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_siteAdmin`
--
ALTER TABLE `tbl_siteAdmin`
  ADD CONSTRAINT `fk_siteID` FOREIGN KEY (`siteID`) REFERENCES `tbl_sites` (`siteID`),
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `tbl_users` (`userID`);

--
-- Constraints for table `tbl_surveys`
--
ALTER TABLE `tbl_surveys`
  ADD CONSTRAINT `siteID_fk_in_surveys` FOREIGN KEY (`siteID`) REFERENCES `tbl_sites` (`siteID`),
  ADD CONSTRAINT `userID_fk_in_surveys` FOREIGN KEY (`userID`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`privilegeLevel`) REFERENCES `tbl_privilege` (`privilegeLevel`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
