-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2025 at 06:50 PM
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
-- Database: `fidak_bbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `admin_name`, `admin_username`, `admin_password`) VALUES
(1, 'Salman Aldosari', 'admin', '123456'),
(2, 'Layla Al-Ghamdi', 'layla_admin', 'securepass123'),
(3, 'Mohammed Al-Shehri', 'moh_admin', 'admin@789'),
(4, 'Sarah Al-Qahtani', 'sarah_admin', 'sarahBBMS2025');

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `blood_id` int(11) NOT NULL,
  `blood_group` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`blood_id`, `blood_group`) VALUES
(1, 'B+'),
(2, 'B-'),
(3, 'A+'),
(4, 'O+'),
(5, 'O-'),
(6, 'A-'),
(7, 'AB+'),
(8, 'AB-');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `contact_id` int(11) NOT NULL,
  `contact_address` varchar(100) NOT NULL,
  `contact_mail` varchar(50) NOT NULL,
  `contact_phone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`contact_id`, `contact_address`, `contact_mail`, `contact_phone`) VALUES
(1, 'Riyadh, Al Narjis District', 'fidak@bbms.sa', '0555123456');

-- --------------------------------------------------------

--
-- Table structure for table `contact_query`
--

CREATE TABLE `contact_query` (
  `query_id` int(11) NOT NULL,
  `query_name` varchar(100) NOT NULL,
  `query_mail` varchar(120) NOT NULL,
  `query_number` char(11) NOT NULL,
  `query_message` longtext NOT NULL,
  `query_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `query_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_query`
--

INSERT INTO `contact_query` (`query_id`, `query_name`, `query_mail`, `query_number`, `query_message`, `query_date`, `query_status`) VALUES
(1, 'Nawaf Al-Otaibi', 'nawaf@fidak.sa', '0556347890', 'Urgent need for O+ blood at King Faisal Hospital.', '2025-04-20 22:30:15', 1),
(2, 'Ahmed Al-Mansour', 'ahmed.m@hospital.sa', '0558234567', 'Need AB- blood for thalassemia patient at Central Hospital', '2025-04-20 12:22:10', 2),
(4, 'Khalid Al-Otaibi', 'k.otaibi@company.sa', '0547456789', 'Question about eligibility for blood donation after travel', '2025-04-18 08:30:45', 1),
(5, 'Reem Al-Sharif', 'reem.sharif@email.com', '0539567890', 'Request for blood donation information session at our community center', '2025-04-17 06:15:22', 2);

-- --------------------------------------------------------

--
-- Table structure for table `donor_details`
--

CREATE TABLE `donor_details` (
  `donor_id` int(11) NOT NULL,
  `donor_name` varchar(50) NOT NULL,
  `donor_number` varchar(10) NOT NULL,
  `donor_mail` varchar(50) DEFAULT NULL,
  `donor_age` int(11) NOT NULL,
  `donor_gender` varchar(10) NOT NULL,
  `donor_blood` varchar(10) NOT NULL,
  `donor_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor_details`
--

INSERT INTO `donor_details` (`donor_id`, `donor_name`, `donor_number`, `donor_mail`, `donor_age`, `donor_gender`, `donor_blood`, `donor_address`) VALUES
(1, 'Abdullah Al-Harbi', '0551122334', 'a.harbi@email.com', 28, 'Male', 'O+', 'Riyadh, Al Malaz District'),
(2, 'Maha Al-Sulaiman', '0552233445', 'm.sulaiman@email.com', 35, 'Female', 'A-', 'Jeddah, Al Rawdah District'),
(3, 'Faisal Al-Ghamdi', '0553344556', 'f.ghamdi@email.com', 42, 'Male', 'B+', 'Dammam, Al Aziziyah District'),
(4, 'Noura Al-Shammari', '0554455667', 'n.shammari@email.com', 31, 'Female', 'AB+', 'Riyadh, Al Olaya District'),
(5, 'Khalid Al-Zahrani', '0555566778', 'k.zahrani@email.com', 25, 'Male', 'O-', 'Jeddah, Al Safa District'),
(6, 'Aisha Al-Qurashi', '0556677889', 'a.qurashi@email.com', 29, 'Female', 'A+', 'Khobar, Al Dhahran District'),
(7, 'Yousef Al-Mutairi', '0557788990', 'y.mutairi@email.com', 37, 'Male', 'B-', 'Riyadh, Al Narjis District'),
(8, 'Huda Al-Amri', '0558899001', 'h.amri@email.com', 33, 'Female', 'AB-', 'Jeddah, Al Khalidiya District');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_type` varchar(50) NOT NULL,
  `page_data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_name`, `page_type`, `page_data`) VALUES
(1, 'Why Donate Blood?', 'donor', 'Your blood donation can save lives. Blood is used for pregnant women, patients, and accident victims.'),
(2, 'About Us', 'aboutus', 'Fidak BBMS is an electronic system for managing blood donation operations in Saudi Arabia.'),
(3, 'The Need for Blood', 'needforblood', 'Patients need blood constantly, especially cancer and anemia patients.'),
(4, 'Tips Before Donating', 'bloodtips', 'Have a light meal, stay hydrated, and get enough rest before donating.'),
(5, 'Who You Help', 'whoyouhelp', 'Pregnant women, accident victims, and chronically ill children benefit from your donation.'),
(6, 'Blood Types', 'bloodgroups', 'A+, A-, B+, B-, O+, O-, AB+, AB-'),
(7, 'Universal Donors', 'universal', 'O- is the universal donor, while AB+ is the universal recipient.');

-- --------------------------------------------------------

--
-- Table structure for table `query_stat`
--

CREATE TABLE `query_stat` (
  `id` int(11) NOT NULL,
  `query_type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `query_stat`
--

INSERT INTO `query_stat` (`id`, `query_type`) VALUES
(1, 'Read'),
(2, 'In Progress'),
(3, 'Resolved'),
(4, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `admin_username` (`admin_username`);

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`blood_id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `contact_query`
--
ALTER TABLE `contact_query`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `donor_details`
--
ALTER TABLE `donor_details`
  ADD PRIMARY KEY (`donor_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page_id` (`page_id`),
  ADD UNIQUE KEY `page_type` (`page_type`);

--
-- Indexes for table `query_stat`
--
ALTER TABLE `query_stat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `blood_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_query`
--
ALTER TABLE `contact_query`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donor_details`
--
ALTER TABLE `donor_details`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
