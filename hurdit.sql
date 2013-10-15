-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2011 at 04:18 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gwu`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `storyID` int(10) NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `timeWritten` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upVotes` int(10) NOT NULL,
  `downVotes` int(10) NOT NULL,
  `edited` int(1) NOT NULL DEFAULT '0',
  `lastEdited` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`timeWritten`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userID`, `storyID`, `comment`, `timeWritten`, `upVotes`, `downVotes`, `edited`, `lastEdited`) VALUES
(2, 1, 11, '2', '2011-06-08 00:41:03', 2, 3, 0, '2011-06-08 00:41:03'),
(3, 1, 11, '3', '2011-06-08 00:41:05', 3, 2, 0, '2011-06-08 00:41:05'),
(4, 4, 11, '1', '2011-06-08 00:41:22', 3, 1, 0, '2011-06-08 00:41:22'),
(5, 4, 11, '2', '2011-06-08 00:41:24', 1, 3, 0, '2011-06-08 00:41:24'),
(6, 4, 11, '3', '2011-06-08 00:41:26', 0, 4, 0, '2011-06-08 00:41:26'),
(7, 4, 11, '2', '2011-06-08 21:49:40', 2, 2, 0, '2011-06-08 21:49:40'),
(8, 1, 11, 'hurdit hurdit hurdithurdit', '2011-06-08 23:31:44', 0, 1, 0, '2011-06-08 23:31:44'),
(1, 1, 10, '1', '2011-06-09 12:59:18', 2, 0, 0, '2011-06-09 12:59:18'),
(2, 1, 10, '2', '2011-06-09 12:59:21', 0, 0, 0, '2011-06-09 12:59:21'),
(3, 1, 10, '3', '2011-06-09 12:59:24', 0, 0, 0, '2011-06-09 12:59:24'),
(4, 1, 10, '4', '2011-06-09 12:59:26', 0, 1, 0, '2011-06-09 12:59:26'),
(5, 1, 10, 'hurdit hurditfa;dsklf\r\n', '2011-06-09 13:00:08', 0, 0, 0, '2011-06-09 13:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `commentvotes`
--

CREATE TABLE IF NOT EXISTS `commentvotes` (
  `userID` int(10) NOT NULL,
  `commentID` int(10) NOT NULL,
  `storyID` int(11) NOT NULL,
  `direction` int(2) NOT NULL DEFAULT '0',
  `timeVoted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commentvotes`
--

INSERT INTO `commentvotes` (`userID`, `commentID`, `storyID`, `direction`, `timeVoted`) VALUES
(4, 2, 11, 1, '2011-06-08 22:09:26'),
(4, 3, 11, 1, '2011-06-08 22:09:26'),
(4, 4, 11, 1, '2011-06-08 22:09:27'),
(4, 5, 11, -1, '2011-06-08 22:09:28'),
(4, 6, 11, -1, '2011-06-08 22:09:28'),
(4, 7, 11, -1, '2011-06-08 22:09:29'),
(1, 2, 11, 1, '2011-06-09 12:51:27'),
(1, 6, 11, -1, '2011-06-09 12:51:29'),
(1, 7, 11, -1, '2011-06-09 12:51:31'),
(1, 8, 11, -1, '2011-06-09 12:51:32'),
(1, 5, 11, -1, '2011-06-09 12:52:09'),
(1, 3, 11, -1, '2011-06-09 12:52:21'),
(1, 4, 11, 1, '2011-06-09 12:53:43'),
(1, 1, 10, 1, '2011-06-09 12:59:29'),
(1, 4, 10, -1, '2011-06-09 12:59:30'),
(1, 1, 11, 1, '2011-06-09 13:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `userID` int(10) NOT NULL,
  `friendID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`userID`, `friendID`) VALUES
(1, 4),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE IF NOT EXISTS `story` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `upVotes` int(10) NOT NULL DEFAULT '0',
  `downVotes` int(10) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  `timeSubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `storyLink` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`id`, `name`, `description`, `upVotes`, `downVotes`, `username`, `views`, `timeSubmitted`, `storyLink`) VALUES
(1, 'Industrial robots do Star Wars better than Lucas -- Engadget', '	\r\nAt the International Conference on Robotics and Automation in Shanghai, industrial robot company Yasakawa equipped a couple of its manufacturing ma', 1, 1, 'guorui', 0, '2011-05-11 20:33:35', 'http://www.engadget.com/2011/05/11/industrial-robots-do-star-wars-better-than-lucas/'),
(2, 'Nokia N9 hits the FCC, packs more bands than a rubber tree -- Engadget', '	\r\nLast we heard, the Nokia N9 rode Stephen Elop''s burning platform into the sunset, never to be seen again. Today, there''s a FCC filing that ', 4, 1, 'guorui', 0, '2011-05-11 20:34:06', 'http://www.engadget.com/2011/05/11/nokia-n9-hits-the-fcc-packs-more-bands-than-a-rubber-tree/'),
(3, 'Panasonic Lumix DMC-G3 leaked, expected to launch tomorrow -- Engadget', '	\r\nPanasonic is rumored to be launching the Lumix DMC-G3 tomorrow, the update to its Micro Four Thirds G2. According to 43 Rumors, the new cam ', 3, 2, 'guorui', 0, '2011-05-11 20:34:14', 'http://www.engadget.com/2011/05/11/panasonic-lumix-dmc-g3-leaked-expected-to-launch-tomorrow/'),
(4, 'Google announces new ways to discover apps on Android Market, more tools for developers -- Engadget', '	\r\nAndroid Market may have a lot going for it, but most would surely agree that it could use some improvement when it comes to discovering ', 4, 1, 'guorui', 12, '2011-05-11 20:34:20', 'http://www.engadget.com/2011/05/11/google-announces-five-new-ways-to-discover-apps-on-android-marke/'),
(5, 'Pioneer', '	\r\nMicrosoft hasn''t exactly set the market ablaze with Surface, but Pioneer still wants its share of the extremely limited action. The company''s Surfa', 3, 1, 'guorui', 0, '2011-05-11 20:34:29', 'http://www.engadget.com/2011/05/11/pioneers-discussion-table-takes-on-surface-in-japan-this-july/'),
(6, 'Editorial: Google clarifies Chromebook subscriptions, might have just changed the industry -- Engadg', '	\r\nFollowing Google''s second I/O keynote, we were ushered into a room where a number of the company''s executives were on hand to field questions from ', 2, 2, 'guorui', 2, '2011-05-11 20:34:35', 'http://www.engadget.com/2011/05/11/editorial-google-clarifies-chromebook-subscriptions-might-have/'),
(7, 'Third Rail iPhone case has detachable battery, probably won', '	\r\nFor humans, coming into contact with the third rail will likely void your personal lifetime warranty, but one accessory manufacturer hopes to apply', 1, 4, 'guorui', 0, '2011-05-11 20:34:41', 'http://www.engadget.com/2011/05/11/third-rail-iphone-case-has-detachable-battery-probably-wont-el/'),
(8, 'Cornell', '	\r\n\r\n	\r\n	A few years ago, engineers at Cornell were rejoicing when their Ranger robot set an unofficial world record by walking for 5.6 miles without st', 2, 3, 'guorui', 1, '2011-05-11 20:34:47', 'http://www.engadget.com/2011/05/11/cornells-ranger-robot-walks-40-5-miles-on-a-single-charge-does/'),
(9, 'NEC', '	\r\n\r\n	If you''ve been looking in vain for the right Windows tablet, you might want to have a gander at NEC''s VersaPro VK15V/TM-C, a pad that ', 1, 4, 'guorui', 3, '2011-05-11 20:34:54', 'http://www.engadget.com/2011/05/11/necs-versapro-vk15v-tm-c-looks-like-a-tablet-runs-like-a-netbo/'),
(10, 'Google TV shows off new Honeycomb UI, plans for Market, SDK; opens up remote app source code -- Enga', '	\r\n\r\n	Google I/O is still ongoing and at the session for teaching developers how to build Android apps for Google TV the team has just shown ', 0, 5, 'guorui', 46, '2011-05-11 20:35:00', 'http://www.engadget.com/2011/05/11/google-tv-shows-off-new-honeycomb-ui/'),
(11, 'No Title', '	\r\nGoogle''s second (and final) day of I/O 2011 was all about Chrome, and unfortunately for those yearning for a Chrome OS tablet, it looks as ', 101, 4, 'guorui', 464, '2011-05-11 20:35:06', 'http://www.engadget.com/2011/05/11/google-no-plans-for-chrome-os-on-tablets-any-other-form-fact/');

-- --------------------------------------------------------

--
-- Table structure for table `storyvotes`
--

CREATE TABLE IF NOT EXISTS `storyvotes` (
  `userID` int(10) NOT NULL,
  `storyID` int(10) NOT NULL,
  `direction` int(2) NOT NULL DEFAULT '0',
  `timeVoted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `storyvotes`
--

INSERT INTO `storyvotes` (`userID`, `storyID`, `direction`, `timeVoted`) VALUES
(4, 11, -1, '2011-06-08 22:04:59'),
(4, 10, -1, '2011-06-08 22:05:05'),
(4, 3, -1, '2011-06-08 22:05:16'),
(4, 4, -1, '2011-06-08 22:19:01'),
(4, 2, 1, '2011-06-08 22:19:03'),
(4, 7, -1, '2011-06-08 22:19:04'),
(4, 8, 1, '2011-06-08 22:19:06'),
(4, 9, -1, '2011-06-08 22:19:07'),
(4, 1, 1, '2011-06-08 22:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `timeJoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` int(1) NOT NULL DEFAULT '0',
  `banUntil` date DEFAULT NULL,
  `userLevel` int(1) NOT NULL DEFAULT '1',
  `gender` varchar(1) NOT NULL,
  `displayPicture` varchar(500) NOT NULL DEFAULT 'images/profile_pic_small.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `timeJoined`, `banned`, `banUntil`, `userLevel`, `gender`, `displayPicture`) VALUES
(1, 'guorui', '81dc9bdb52d04dc20036dbd8313ed055', '2011-05-11 20:26:56', 0, NULL, 4, 'm', 'images/profile_pic_small.png'),
(2, 'test', '202cb962ac59075b964b07152d234b70', '2011-05-14 11:29:34', 0, NULL, 1, 'm', 'images/profile_pic_small.png'),
(3, 'account', '202cb962ac59075b964b07152d234b70', '2011-05-14 12:09:18', 0, NULL, 1, 'm', 'images/profile_pic_small.png'),
(4, 'siva', '202cb962ac59075b964b07152d234b70', '2011-06-07 23:35:52', 0, NULL, 3, 'm', 'images/profile_pic_small.png');
