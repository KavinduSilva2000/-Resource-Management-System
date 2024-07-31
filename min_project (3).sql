-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 09:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `min_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Book_Id` varchar(20) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `Book_Name` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Publication` varchar(100) NOT NULL,
  `Year` int(4) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Book_Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Book_Id`, `ISBN`, `Book_Name`, `Author`, `Publication`, `Year`, `Category`, `Status`, `Book_Image`) VALUES
('11', '125456', 'holmes', 'kavindu', 'grer', 2014, '2', 'Borrow', 'binarydust.png'),
('2', '153487', 'spiderman', 'dssfe', 'dhiad', 2015, '3', 'Library Use Only', 'Dune1.png'),
('3', '15454', 'madolduwa', 'vareva', 'bsez', 2014, '1', 'Borrow', 'Dune2.png'),
('4', '1759', 'marapana', 'guv', 'frv', 2018, '1', 'Borrow', 'harryp1.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'novel'),
(2, 'magazine'),
(3, 'cartoon'),
(4, 'game');

-- --------------------------------------------------------

--
-- Table structure for table `deletedfiles`
--

CREATE TABLE `deletedfiles` (
  `File_Id` varchar(200) NOT NULL,
  `File_Name` varchar(200) NOT NULL,
  `Record_RoomNo_Old` varchar(200) NOT NULL,
  `No_Of_MinitSheets` int(11) NOT NULL,
  `Year` year(4) NOT NULL,
  `Cupboard_No` varchar(200) NOT NULL,
  `Rack_No` varchar(200) NOT NULL,
  `Docket_No` varchar(200) NOT NULL,
  `Position_at_Docket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docket`
--

CREATE TABLE `docket` (
  `Docket_No` int(11) NOT NULL,
  `Size` int(11) NOT NULL DEFAULT 100,
  `Cupboard_No` int(11) NOT NULL,
  `Rack_No` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `docket`
--

INSERT INTO `docket` (`Docket_No`, `Size`, `Cupboard_No`, `Rack_No`, `Status`) VALUES
(1, 100, 1, 1, 1),
(2, 100, 1, 1, 1),
(3, 100, 1, 1, 1),
(4, 100, 1, 1, 1),
(5, 100, 1, 1, 1);

--
-- Triggers `docket`
--
DELIMITER $$
CREATE TRIGGER `before_docket_delete` BEFORE DELETE ON `docket` FOR EACH ROW BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Handle the exception
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'An error occurred while deleting the docket';
    END;

    -- Update specific columns to NULL or a default value before deleting the row
    UPDATE docket
    SET Cupboard_No = NULL, Rack_No = NULL, Status = 0
    WHERE Docket_No = OLD.Docket_No;

    -- Move files to deletedFiles
    INSERT INTO deletedFiles
    SELECT *
    FROM file
    WHERE Docket_No = OLD.Docket_No;

    -- Delete files from the original table
    DELETE FROM file
    WHERE Docket_No = OLD.Docket_No;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_docket_delete2` BEFORE DELETE ON `docket` FOR EACH ROW BEGIN
    -- Update specific columns to NULL or a default value before deleting the row
    UPDATE docket
    SET Cupboard_No = NULL, Rack_No = NULL, Status = 0
    WHERE Docket_No = OLD.Docket_No;

    -- Move files to deletedFiles
    INSERT INTO deletedFiles
    SELECT *
    FROM file
    WHERE Docket_No = OLD.Docket_No;

    -- Delete files from the original table
    DELETE FROM file
    WHERE Docket_No = OLD.Docket_No;

    -- If there is no handler, any error will be reported as it is
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `Record_Room_No` char(14) NOT NULL,
  `File_Id` varchar(200) NOT NULL,
  `File_Name` varchar(200) NOT NULL,
  `No_Of_MinitSheets` int(11) NOT NULL,
  `Year` year(4) NOT NULL,
  `Cupboard_No` int(10) NOT NULL,
  `Rack_No` int(11) NOT NULL,
  `Docket_No` int(11) NOT NULL,
  `Position_at_Docket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`Record_Room_No`, `File_Id`, `File_Name`, `No_Of_MinitSheets`, `Year`, `Cupboard_No`, `Rack_No`, `Docket_No`, `Position_at_Docket`) VALUES
('R-01-01-01-001', '1', 'file11111', 1, '1901', 1, 1, 1, 1),
('R-01-01-01-002', '2', 'file2', 2, '1901', 1, 1, 1, 2),
('R-01-01-01-003', '3', 'file3', 3, '1901', 1, 1, 1, 3),
('R-01-01-01-004', '10', 'file2', 100, '1901', 1, 1, 1, 4),
('R-01-01-01-005', '55', 'file1', 100, '1901', 1, 1, 1, 5),
('R-01-01-01-006', '11', 'file11', 1, '2020', 1, 1, 1, 6),
('R-01-01-01-007', '36', 'file1', 1, '2155', 1, 1, 1, 7);

--
-- Triggers `file`
--
DELIMITER $$
CREATE TRIGGER `set_position_and_RecordRoomNo` BEFORE INSERT ON `file` FOR EACH ROW BEGIN

DECLARE position INT;
DECLARE DockNo INT;
DECLARE RRN VARCHAR(15);

SET DockNo = NEW.Docket_No ;

    IF (SELECT COUNT(*) FROM file WHERE Docket_No = DockNo)  = 0 THEN
        SET NEW.Position_at_Docket = 1;
       
    ELSE
    SELECT Position_at_Docket INTO position
        FROM file WHERE Docket_No = DockNo
        ORDER BY Position_at_Docket DESC
        LIMIT 1;
       
        SET NEW.Position_at_Docket = position + 1;   
    END IF;
    
    SET RRN = CONCAT('R-', LPAD(NEW.Cupboard_No, 2, '0'), '-', LPAD(NEW.Rack_No, 2, '0'), '-', LPAD(NEW.Docket_No, 2, '0'), '-', LPAD(NEW.Position_at_Docket,3,'0'));

    
    SET NEW.Record_Room_No = RRN;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fine_amount`
--

CREATE TABLE `fine_amount` (
  `nic` varchar(100) NOT NULL,
  `Fine_Amount` decimal(10,0) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issued_item`
--

CREATE TABLE `issued_item` (
  `Section_Id` char(6) NOT NULL,
  `Item_Id` varchar(20) NOT NULL,
  `Quantity` bigint(20) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_item`
--

INSERT INTO `issued_item` (`Section_Id`, `Item_Id`, `Quantity`, `Date`) VALUES
('0001', '0001', 100, '2024-06-29'),
('0001', '0003', 478, '2024-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE `issue_book` (
  `nic` varchar(100) NOT NULL,
  `Book_Id` varchar(20) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `Book_Name` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Year` int(4) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL,
  `issued_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`nic`, `Book_Id`, `ISBN`, `Book_Name`, `Author`, `Year`, `Category`, `username`, `issued_date`) VALUES
('200035200980', '22222', '5251', 'Aruni', 'Aruni', 2012, '2', '', '2024-06-20'),
('200035200981', '22222', '5251', 'Aruni', 'Aruni', 2012, '2', '', '2024-06-20'),
('123456789123', '123', '32', 'Dishsan', 'Dishsan', 2014, '2', '', '2024-06-20'),
('200035200981', '4', '1759', 'marapana', 'guv', 2018, '1', '', '2024-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `Item_Id` varchar(200) NOT NULL,
  `Item_name` varchar(200) NOT NULL,
  `CurrentBalance` bigint(20) NOT NULL,
  `Open_Balance` bigint(20) NOT NULL DEFAULT 0,
  `Replishment` int(11) NOT NULL,
  `ReorderNeeded` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`Item_Id`, `Item_name`, `CurrentBalance`, `Open_Balance`, `Replishment`, `ReorderNeeded`) VALUES
('0001', 'item1', 403, 0, 100, 1),
('0002', 'item2', 4, 0, 100, 0),
('0003', 'item3', 123, 0, 50, 0),
('0004', 'item4', 234, 0, 25, 0),
('0005', 'item5', 500, 0, 10, 0),
('0006', 'item6', 0, 0, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `nic` varchar(100) NOT NULL,
  `file_tracking` varchar(20) NOT NULL,
  `library_management` varchar(20) NOT NULL,
  `inventory` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`nic`, `file_tracking`, `library_management`, `inventory`) VALUES
('12345', 'not_access', 'user', 'admin'),
('123456789123', 'not_access', 'user', 'not_access'),
('199711111V', 'user', 'user', 'user'),
('200035200980', 'not_access', 'admin', 'not_access'),
('200035200981', 'not_access', 'user', 'not_access'),
('20035200892', 'not_access', 'user', 'not_access'),
('234', 'admin', 'admin', 'admin'),
('956723467V', 'user', 'user', 'not_access'),
('987989699v', 'admin', 'user', 'user'),
('99999999V', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_item`
--

CREATE TABLE `purchased_item` (
  `Item_Id` varchar(20) NOT NULL,
  `Quantity` bigint(20) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchased_item`
--

INSERT INTO `purchased_item` (`Item_Id`, `Quantity`, `Date`) VALUES
('0001', 1, '2024-06-01'),
('0001', 2, '2024-06-01'),
('0001', 100, '2024-06-05'),
('0001', 400, '2024-06-20'),
('0002', 4, '2024-06-02'),
('0003', 1, '2024-06-01'),
('0003', 100, '2024-06-25'),
('0003', 500, '2024-06-13'),
('0004', 234, '2024-06-21'),
('0005', 500, '2024-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `request_book`
--

CREATE TABLE `request_book` (
  `nic` varchar(100) NOT NULL,
  `Book_Id` varchar(20) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `Book_Name` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Year` int(4) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_book`
--

INSERT INTO `request_book` (`nic`, `Book_Id`, `ISBN`, `Book_Name`, `Author`, `Year`, `Category`, `username`) VALUES
('200035200980', '532', '626', 'pathumi', 'efse', 2024, '1', ''),
('200035200981', '11', '125456', 'holmes', 'kavindu', 2014, '2', '');

-- --------------------------------------------------------

--
-- Table structure for table `return_book`
--

CREATE TABLE `return_book` (
  `nic` varchar(100) NOT NULL,
  `Book_Id` int(20) NOT NULL,
  `ISBN` varchar(17) NOT NULL,
  `Book_Name` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Year` int(4) NOT NULL,
  `Category` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_book`
--

INSERT INTO `return_book` (`nic`, `Book_Id`, `ISBN`, `Book_Name`, `Author`, `Year`, `Category`, `username`, `issue_date`, `return_date`) VALUES
('200035200981', 532, '626', 'pathumi', 'efse', 2024, '1', '', '2024-06-18', '2024-06-18'),
('200035200981', 532, '626', 'pathumi', 'efse', 2024, '1', '', '2024-06-18', '2024-06-18'),
('200035200981', 532, '626', 'pathumi', 'efse', 2024, '1', '', '2024-06-18', '2024-06-18'),
('200035200981', 532, '626', 'pathumi', 'efse', 2024, '1', '', '2024-06-18', '2024-06-18'),
('200035200981', 532, '626', 'pathumi', 'efse', 2024, '1', '', '2024-06-18', '2024-06-18'),
('200035200981', 1111, '11112', 'kavindu', 'kavindu', 2222, '1', '', '2024-06-19', '2024-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `Section_Id` char(6) NOT NULL,
  `Section_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`Section_Id`, `Section_Name`) VALUES
('0001', 'section1'),
('0002', 'section2'),
('0003', 'section3'),
('0004', 'section4'),
('0005', 'section5'),
('0006', 'section6');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `nic` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`first_name`, `last_name`, `nic`, `password`, `username`) VALUES
('dhishan', 'dhammearatchi', '123', '$2y$10$b13X7ud3pW0hTJLwMwYPROKExiVk8im3mjtF6k/uNyUyeR5XlUCT6', 'dhishan dhammearatchi'),
('Rukshan', 'kodithuwakku', '12345', '$2y$10$pzIUsz/4fdcztIauLxbtd.zSIyAxFfHcir4ublD/31FSsM.U16waS', 'rukshan gimhana'),
('dulani', 'silva', '123456789123', '$2y$10$XdrZKOxc3rtVyvjGHIgtmOB6gkGZ/wsOL6KXzc68PeLdt0/KWdKcS', 'dulani silva'),
('janani', 'shanmugam', '199711111V', '$2y$10$spoHyodrDqXT6RfNe1rU8.6HVjKGA6.DsdkBA4DrZ16i/DXms40MK', 'janani shanmugam'),
('dushan', 'silva', '200035200980', '$2y$10$KXX1bB970xn.iuMCwj1Q5.sVzInu5slHxP4tWuP7iHSb4SuLzDFKC', 'dushan silva'),
('kavindu', 'silva', '200035200981', '$2y$10$ZBpV5WHzSk0OpjT1vi4CNOE8bP8EsQKSO/Cp9Ob.jWuxizDWp4buy', 'kavindu silva'),
('hiruni', 'silva', '20035200892', '$2y$10$.WXdkzPESI7AmYyvA.ijROfLeTD9QVEgV8kJmyruw8UtyEJabuZc.', 'hiruni silva'),
('dhishan', 'dhammearatchi', '234', '$2y$10$sO4wjirfCvvSnq6FUm7F7uRF7Ar1wt/W4THb/pu3C4aSB00eleby2', 'dhishan dhammearatchi'),
('shama', 'kandewaththa', '597980655v', '$2y$10$jICvc2SGQIMPLwAiqe.Bbes.BdT/1mC04CZvuPjXMsQF.cbyoU5Cy', 'shama kandewaththa'),
('Nima', 'dskd', '956723467V', '$2y$10$Gqu3kigu68IToyrISvo5TeFMeUdzw16U75ROK0sfIE86bghBB.gpe', 'nima dskd'),
('nimesha', 'malindi', '987980699v', '$2y$10$vqVZLKbuVpdhX3NNFa/3/eJWLbxFV3vDokuNhBw3GLGX33tWAV26m', 'nimesha malindi'),
('nimesha', 'kandewaththa', '987989699v', '$2y$10$h/gd4TfeI1eOCHBQHXa5Je3Gncrn.GbrW81Vryv2aEqqviVYPUUCu', 'nimesha kandewaththa'),
('aruni', 'nimesha', '99999999V', '$2y$10$uj8PZAoEQiVQatNfXsw4SeJoqMC5w0kycAfI8LGcZj1R3baNk6K/6', 'aruni nimesha');

-- --------------------------------------------------------

--
-- Table structure for table `user_temp`
--

CREATE TABLE `user_temp` (
  `first_name` varchar(500) NOT NULL,
  `last_name` varchar(500) NOT NULL,
  `nic` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_temp`
--

INSERT INTO `user_temp` (`first_name`, `last_name`, `nic`, `password`, `username`) VALUES
('pathumi', 'malsha', '12345789', '$2y$10$t5r6pc1Ix2VpPSiRi31xTulRPWml3/CEuaxgpEaAVqifkOmG/gFrm', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `deletedfiles`
--
ALTER TABLE `deletedfiles`
  ADD PRIMARY KEY (`File_Id`);

--
-- Indexes for table `docket`
--
ALTER TABLE `docket`
  ADD PRIMARY KEY (`Docket_No`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`Record_Room_No`),
  ADD UNIQUE KEY `File_Id` (`File_Id`);

--
-- Indexes for table `fine_amount`
--
ALTER TABLE `fine_amount`
  ADD PRIMARY KEY (`nic`),
  ADD KEY `fk_fineamount_nic` (`nic`);

--
-- Indexes for table `issued_item`
--
ALTER TABLE `issued_item`
  ADD PRIMARY KEY (`Section_Id`,`Item_Id`,`Quantity`,`Date`),
  ADD KEY `FK_Item_Id` (`Item_Id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`Item_Id`),
  ADD UNIQUE KEY `Item_name` (`Item_name`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`nic`);

--
-- Indexes for table `purchased_item`
--
ALTER TABLE `purchased_item`
  ADD PRIMARY KEY (`Item_Id`,`Quantity`,`Date`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`Section_Id`),
  ADD UNIQUE KEY `Section_Name` (`Section_Name`),
  ADD UNIQUE KEY `Section_Id` (`Section_Id`,`Section_Name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nic`);

--
-- Indexes for table `user_temp`
--
ALTER TABLE `user_temp`
  ADD PRIMARY KEY (`nic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
