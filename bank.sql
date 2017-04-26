--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` smallint(6) NOT NULL,
  `client_id` smallint(6) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `balance` varchar(40) NOT NULL,
  `routing_number` varchar(40) NOT NULL,
  `account_type` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `client_id`, `account_number`, `balance`, `routing_number`, `account_type`) VALUES
(1, 1, '22', '22000', '0', 'checkings'),
(2, 2, '24', '24000', '0', 'savings'),
(3, 3, '26', '26000', '111111', 'savings'),
(4, 7, '128509521', '0', '0', 'checkings');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `client_id` smallint(6) NOT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `birth_date` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `SSN` varchar(20) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`client_id`, `last_name`, `first_name`, `birth_date`, `email`, `SSN`, `role`, `username`, `password`) VALUES
(1, 'Penelton', 'Ryan', '1992/03/12', 'rpenelton@example.com', '123456789', '1', 'ryan', '12345'),
(2, 'Kozakli', 'Hazal', '1992/05/15', 'hkozakli@example.com', '987654321', '2', 'hazal', '1345'),
(3, 'Solo', 'Jaina', '4059/07/13', 'jsolo@example.com', '563491278', '2', 'jaina', '15654'),
(7, 'Grounds', 'Adam', '02/13/1997', 'agrounds@umail.iu.edu', '1234567', '2', 'adamdude00', 'HelloWorld!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `client_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
