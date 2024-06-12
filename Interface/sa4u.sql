-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 04, 2024 at 03:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sa4u`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(50) NOT NULL,
  `AdminName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(50) NOT NULL,
  `FeedbackText` varchar(255) NOT NULL,
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productreview`
--

CREATE TABLE `productreview` (
  `ReviewID` int(50) NOT NULL,
  `review` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productreview`
--

INSERT INTO `productreview` (`ReviewID`, `review`, `rating`, `UserID`) VALUES
(1, 'this product was very bad !! they could have done better!!', '1', 6),
(2, 'amazing work. best I have ever seen.', '5', 7),
(3, 'the product was very good but not original!!!', '3', 8),
(4, 'the product is very good ! excellent!!', '5', 2),
(5, 'the product was horrible! would not recommend ', '1', 10),
(6, 'the eye cream was fantastic ! ', '5', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(50) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Telephone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `UserName`, `Email`, `Password`, `Gender`, `Telephone`) VALUES
(1, 'John', 'john36@gmail.com', '$2y$10$zUnT0R.gyJt7GPF2qu3VTOk1Gx25IkQKk8qM7EXPO.s6wsEtQA0bK', 'male', '07123345687'),
(2, 'Jane', 'janead@sa4u.com', '$2y$10$54uO8fi.9L.ErStWCbusHexA2rMzKfAach3GzYUyjxOAA1GEcwf.y', 'prefer_not_to_say', '07398232326'),
(3, 'Rachel', 'rachel36@gmail.com', '$2y$10$pKr/kFhzz7yStJZth/srauUYre6Bfbav9abf12SEKSJI87QUZK4Hu', 'female', '07239348348'),
(4, 'Ross', 'ross36@gmail.com', '$2y$10$Nq/regoNQHJ6Xg66bzc39e7.Pij2lBPPixVImkUM3z.SYXIQ4Ly/u', 'male', '074532473484'),
(5, 'Joey', 'joey36@gmail.com', '$2y$10$4GL14FGVkIMy2dlDTvTAfeIKBL3IuwXNVgbi.cwHC21izMCAzXGSy', 'male', '07322284943'),
(6, 'Phoebe', 'pheebs36@gmail.com', '$2y$10$3C2Rs.4PW7s7q3HHSeQZvevVNgzVzSe4kZRlZP4zTn..aCY.r24nC', 'female', '0732473494'),
(7, 'Maimuna', 'maimush@gmail.com', '$2y$10$LukBb5j8Fl/RM7qNBsAyu.WEslERkQ9zgShciDlFQbJNGRJdYBW4a', 'female', '0743652325'),
(8, 'Ahmed', 'ahmed@gmail.com', '$2y$10$gGx9gSXvpTFH8yDi0mkuiuNwXTGDq6G1v/v2ZC92iJVerOg9JCcK6', 'male', '0717870777'),
(9, 'Rahima', 'rahima@gmail.com', '$2y$10$MtZ808a.aRkaX73Yz6AdnOuGG8EVMWEejkd6Cu4Me1TJ/ZC3Qo4TO', 'female', '072352247'),
(10, 'Amina', 'amina36@gmail.com', '$2y$10$loQQ.4OKQ8RmjXP2kxFqY.YoIYk6D4JtM/10OXfpfemnneGmKsoDe', 'female', '0726323247');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `ReviewID` (`ReviewID`);

--
-- Indexes for table `productreview`
--
ALTER TABLE `productreview`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productreview`
--
ALTER TABLE `productreview`
  MODIFY `ReviewID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`AdminID`),
  ADD CONSTRAINT `feedback_ibfk_3` FOREIGN KEY (`ReviewID`) REFERENCES `productreview` (`ReviewID`);

--
-- Constraints for table `productreview`
--
ALTER TABLE `productreview`
  ADD CONSTRAINT `productreview_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
