-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2023 at 06:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartegories`
--

CREATE TABLE `cartegories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Discription` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cartegories`
--

INSERT INTO `cartegories` (`ID`, `Name`, `Discription`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(704, 'laptop', 'laptop', 1, 0, 0, 0),
(705, 'accessoires', 'accessoires informatique est gaming', 2, 0, 0, 0),
(706, 'smartphone', 'smartphone', 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Comment_Date` date NOT NULL,
  `ItemID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Descreption` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `CatID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Approuve` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Descreption`, `Price`, `Add_Date`, `Image`, `CatID`, `UserID`, `Approuve`) VALUES
(21, 'Asus vivobook 2022 i5 12th blue edition', 'Asus vivobook 2021 un laptop de haute gamme , un pc professionnel avec un processeur rapide et puissant le intel i5 11eme génération avec 8 ram de haut fréquence et 512 go ssd , il est adapté pour les étudiants , la programmation , le graphique design et le travail quotidien .', '125000.00', '2023-07-01', 'data/uploades/21/', 704, 1, 0),
(22, 'Dell XPS Plus 9320 2022 neuf', 'Le Dell XPS 13 Plus 9320 offre des performances haut de gamme à la hauteur de son apparence haut de gamme. Le processeur Intel Core i7-1260P à 2,1 GHz de 12e génération possède 12 cœurs (avec hyper-threading sur quatre cœurs de performance). La prise en charge graphique se fait via Intel Iris Xe intégré.  Le stockage est d’une taille décente à 512 Go et il est très rapide, ce qui rend les tâches quotidiennes super rapides. Les 16 Go de RAM vous offrent de nombreuses capacités multitâches.  Comme vous vous en doutez avec un i7 de 12e génération, nous avons constaté que les performances du processeur étaient excellentes et que le support graphique était bon, il est donc bien équipé pour tout défi en dehors des jeux haut de gamme.', '265000,00', '2023-07-01', 'data/uploades/22/', 704, 1, 0),
(24, 'HP LAPTOP Model 15', 'Le HP Laptop 15-s est un PC portable bureautique doté d’un écran FHD de 15.6 pouces. Il embarque le processeur Intel Athlon silver 3050U , dispose de 4 Go de mémoire vive et de 128 Go de stockage .', '49000,00', '2023-07-01', 'data/uploades/24/', 704, 1, 0),
(28, 'DELL XPS 15″ i9 Double GPU', 'Le Dell XPS 15 i9 avec processeur i9 8950HK est un ordinateur portable haut de gamme double carte graphique  de 15 pouces. Il dispose, d’un processeur Intel Core i9 de 8e génération HK , de 32 Go de RAM et d’un SSD de 1 tera (1000 Go ). Il possède également une carte graphique dédiée Nvidia gtx 1050 ti , un clavier rétroéclairé confortable et une autonomie de batterie allant jusqu’à 7 heures. Le design est élégant , ce qui en fait un excellent choix pour les professionnels .', '145000,00', '2023-07-08', 'data/uploades/28/', 704, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `OrderPrice` varchar(255) DEFAULT NULL,
  `OrderAddress` varchar(255) DEFAULT NULL,
  `OrderWilaya` varchar(255) DEFAULT NULL,
  `OrderCommune` varchar(255) DEFAULT NULL,
  `OrderTel` varchar(255) DEFAULT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `OrderPrice`, `OrderAddress`, `OrderWilaya`, `OrderCommune`, `OrderTel`, `UserID`) VALUES
(30, '2023-07-04', '265000', 'Group Scolarie Mouhamed chrif Zouabi', 'alger', 'BacheDjerrah', '0555952167', 23),
(32, '2023-07-06', '410000,00', 'maghniya', 'alger', 'msirda', '023629652', 23),
(33, '2023-07-06', '314000', 'errahmaniya', 'alger', 'douira', '0556784634', 27),
(36, '2023-07-08', '194000', 'ibno rochd', 'alger', 'hydra', '0123214321', 29),
(37, '2023-07-08', '314000,00', 'Group Scolarie Mouhamed chrif Zouabi', 'alger', 'douira', '0546798349', 23);

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `OrderID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`OrderID`, `ItemID`) VALUES
(30, 22),
(32, 22),
(33, 22),
(33, 24),
(36, 24),
(36, 28),
(37, 22),
(37, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'user identyfier',
  `Username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'user name to login',
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'password to login',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'user Privilage',
  `Truststatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `Regstatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approuvel',
  `Date` date NOT NULL DEFAULT '2023-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `email`, `Fullname`, `GroupID`, `Truststatus`, `Regstatus`, `Date`) VALUES
(1, 'amine', '23bc6df7647b818d79ce7fc43fa0f460c188205a', 'amine@admin.info', 'OURAGHI  Ahmed EL Amine', 1, 0, 1, '2023-01-01'),
(22, 'chbira', 'df8d241c2b289c5a6794fa48ddac85a427be2c61', 'chbira@riadh.dzRO', 'chbira Riadh', 0, 0, 1, '2023-06-19'),
(23, 'kaka', '513d74946327c04cb6f0b0190b460dd9821db726', 'kaka@kaka.dz', 'kaka', 0, 0, 1, '2023-06-19'),
(26, 'kamal', '5cc5d8d4c7115f1c96c2983ec0d0f8a0f9dab596', 'kamal@habouhci.dz', 'kamal habouhci', 0, 0, 1, '2023-07-04'),
(27, 'hamza ', 'cc2078c49601d1d3b0905156ce70ce0875c69e77', 'hamza@chbira.dz', 'hamza chbira', 0, 0, 1, '2023-07-06'),
(28, 'baghin ', '0b5a026426cacb535c56888d5153a665d8f642ee', 'baghin@ztili.dz', 'baghin ztili', 0, 0, 1, '2023-07-07'),
(29, 'ouraghi ', 'bd2e786e50d32cf6920b33935a14f9f925d9b854', 'ouraghi@ahmed.dz', 'ouraghi ahmed amine', 0, 0, 1, '2023-07-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartegories`
--
ALTER TABLE `cartegories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `comm_item` (`ItemID`),
  ADD KEY `comm_user` (`UserID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `users_items_1` (`UserID`),
  ADD KEY `cats_items_1` (`CatID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `users_orders_1` (`UserID`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`OrderID`,`ItemID`),
  ADD KEY `orders_details_items_1` (`ItemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartegories`
--
ALTER TABLE `cartegories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user identyfier', AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comm_item` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comm_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cats_items_1` FOREIGN KEY (`CatID`) REFERENCES `cartegories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_items_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `users_orders_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `orders_details_items_1` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_order_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
