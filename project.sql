-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 
-- 伺服器版本： 8.0.17
-- PHP 版本： 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `creditcard_payment_store_cooperate`
--

CREATE TABLE `creditcard_payment_store_cooperate` (
  `PID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `feedback` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `creditcard_payment_store_cooperate`
--

INSERT INTO `creditcard_payment_store_cooperate` (`PID`, `CID`, `SID`, `discount`, `feedback`) VALUES
(1, 1, 2, 10, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `credit_card`
--

CREATE TABLE `credit_card` (
  `creditcard_CID` int(11) NOT NULL,
  `creditcard_bank` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creditcard_category` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `credit_card`
--

INSERT INTO `credit_card` (`creditcard_CID`, `creditcard_bank`, `creditcard_category`) VALUES
(1, 'UBS Group AG', 'infinite card'),
(2, 'Fubon', 'LinePay Card'),
(3, 'UBS Group AG', 'classA'),
(4, 'UBS Group AG', 'classB'),
(5, 'test1', 'test1');

-- --------------------------------------------------------

--
-- 資料表結構 `payment`
--

CREATE TABLE `payment` (
  `payment_PID` int(11) NOT NULL,
  `payment_template` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `payment`
--

INSERT INTO `payment` (`payment_PID`, `payment_template`) VALUES
(1, 'LinePay'),
(2, 'PXPay');

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `store_SID` int(11) NOT NULL,
  `store_category` int(11) NOT NULL,
  `store_name` varchar(45) NOT NULL,
  `store_location` varchar(60) NOT NULL,
  `store_phone_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `store`
--

INSERT INTO `store` (`store_SID`, `store_category`, `store_name`, `store_location`, `store_phone_number`) VALUES
(1, 2, 'Starbucks', 'Seatle', '123'),
(2, 1, 'In&Out', 'L.A.', '696');

-- --------------------------------------------------------

--
-- 資料表結構 `store_category`
--

CREATE TABLE `store_category` (
  `storecategory_SCID` int(11) NOT NULL,
  `storecategory_category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `store_category`
--

INSERT INTO `store_category` (`storecategory_SCID`, `storecategory_category`) VALUES
(1, 'fast food restaurant'),
(2, 'coffee shop');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_UID` int(11) NOT NULL,
  `user_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_UID`, `user_name`, `user_password`, `user_email`) VALUES
(1, 'bryuan', '0000', 'qq'),
(2, 'test', 'test', 'a1073329@mail.nuk.edu.tw'),
(8, 'test', 'password2', '370brian@gmail.com'),
(20, 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- 資料表結構 `user_creditcard_relation`
--

CREATE TABLE `user_creditcard_relation` (
  `PK` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `CID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `user_creditcard_relation`
--

INSERT INTO `user_creditcard_relation` (`PK`, `UID`, `CID`) VALUES
(4, 8, 2),
(8, 8, 5),
(9, 2, 5),
(11, 8, 3);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `creditcard_payment_store_cooperate`
--
ALTER TABLE `creditcard_payment_store_cooperate`
  ADD KEY `CPSC_CID` (`CID`),
  ADD KEY `CPSC_PID` (`PID`),
  ADD KEY `CPSC_SID` (`SID`);

--
-- 資料表索引 `credit_card`
--
ALTER TABLE `credit_card`
  ADD PRIMARY KEY (`creditcard_CID`);

--
-- 資料表索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_PID`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_SID`),
  ADD KEY `S_category` (`store_category`);

--
-- 資料表索引 `store_category`
--
ALTER TABLE `store_category`
  ADD PRIMARY KEY (`storecategory_SCID`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_UID`);

--
-- 資料表索引 `user_creditcard_relation`
--
ALTER TABLE `user_creditcard_relation`
  ADD PRIMARY KEY (`PK`),
  ADD KEY `UID_idx` (`UID`),
  ADD KEY `CID_idx` (`CID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `credit_card`
--
ALTER TABLE `credit_card`
  MODIFY `creditcard_CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `store`
--
ALTER TABLE `store`
  MODIFY `store_SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `store_category`
--
ALTER TABLE `store_category`
  MODIFY `storecategory_SCID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `user_UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_creditcard_relation`
--
ALTER TABLE `user_creditcard_relation`
  MODIFY `PK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `creditcard_payment_store_cooperate`
--
ALTER TABLE `creditcard_payment_store_cooperate`
  ADD CONSTRAINT `CPSC_CID` FOREIGN KEY (`CID`) REFERENCES `credit_card` (`creditcard_CID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `CPSC_PID` FOREIGN KEY (`PID`) REFERENCES `payment` (`payment_PID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `CPSC_SID` FOREIGN KEY (`SID`) REFERENCES `store` (`store_SID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `S_category` FOREIGN KEY (`store_category`) REFERENCES `store_category` (`storecategory_SCID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `user_creditcard_relation`
--
ALTER TABLE `user_creditcard_relation`
  ADD CONSTRAINT `UCR_CID` FOREIGN KEY (`CID`) REFERENCES `credit_card` (`creditcard_CID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `UCR_UID` FOREIGN KEY (`UID`) REFERENCES `user` (`user_UID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
