### FS1030Project
Clone repo 
git clone https://github.com/ZixiZhang-000/FS1030Project.git
### Create DB and Table for patient's profile
'''
CREATE DATABASE patients;
CREATE TABLE IF NOT EXISTS `patient_details`(
  `patient_id` int(5) NOT NULL AUTO_INCREMENT,
  `card_number` int(10) NOT NULL, 
  `first_name` varchar(255) NOT NULL, 
  `last_name` varchar(255) NOT NULL,
  `phone` int(15) NOT NULL, 
  `address` varchar(255) NOT NULL, 
  `medical_history` varchar(255) NOT NULL, 
  `test_result` varchar(255) NOT NULL, 
  `billing_info` varchar(255) NOT NULL, 
  `updeted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  PRIMARY KEY(`patient_id`)
)ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;
'''

### Create DB and Table for users
'''
CREATE DATABASE users;
use users;
CREATE TABLE IF NOT EXISTS `providers`(
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `login` int(10) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL, 
  PRIMARY KEY(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;
'''

### Register and login account
Open http://localhost/FS1030Project/login/login.php
### Execute Code
Open http://localhost/FS1030Project/
