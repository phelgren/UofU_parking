--Table Creations
-- Start with Users (the same as drivers)
create table if not exists users(
    driver_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstname varchar(128) not null,
	lastname varchar(128) not null,
	username varchar(128) not null unique,
	password varchar(128) not null,
	email varchar(128) not null,
	driver_type varchar(16) not null,
	address varchar(128)
)ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `username`, `role`) VALUES
(1, 'bsmith', 'student'),
(2, 'pjones', 'faculty'),
(3, 'pjones', 'admin');


--vehicle 
DROP TABLE IF EXISTS Vehicle;
CREATE TABLE Vehicle (
    VEHICLE_ID INT AUTO_INCREMENT PRIMARY KEY,
    DRIVER_ID INT,
    License_Plate VARCHAR(20) UNIQUE,
    Make VARCHAR(50),
    Model VARCHAR(50),
    Color VARCHAR(20),
    Year YEAR,
    VIOLATION_ID INT,
    FOREIGN KEY (DRIVER_ID) REFERENCES Users(DRIVER_ID),
    FOREIGN KEY (VIOLATION_ID) REFERENCES Violation(VIOLATION_ID)
);

INSERT INTO VEHICLE (VEHICLE_ID, DRIVER_ID, License_Plate, Make, Model, Color, Year, VIOLATION_ID)
VALUES
(1, 1, 'ZL1234', 'Toyota', 'Corolla', 'Red', 2015, NULL),
(2, 2, 'HY5678', 'Honda', 'Civic', 'Blue', 2018, 1),
(3, 2, 'BR9101', 'Ford', 'Focus', 'Black', 2019, NULL),
(4, 4, 'KT1123', 'Chevy', 'Malibu', 'White', 2020, 2),
(5, 4, 'UE1415', 'Nissan', 'Altima', 'Grey', 2017, NULL);

--Permit
DROP TABLE IF EXISTS Permit;
CREATE TABLE Permit (
    PERMIT_ID INT AUTO_INCREMENT PRIMARY KEY,
    Permit_Type VARCHAR(50),
    VEHICLE_ID INT,
    Purchase_date DATE,
    Expiry_date DATE,
    Cost DECIMAL(10, 2),
    DRIVER_ID INT,
    PAYMENT_ID INT,
    FOREIGN KEY (VEHICLE_ID) REFERENCES Vehicle(VEHICLE_ID),
    FOREIGN KEY (DRIVER_ID) REFERENCES Driver(DRIVER_ID),
    FOREIGN KEY (PAYMENT_ID) REFERENCES Payment(PAYMENT_ID)
);

INSERT INTO PERMIT (PERMIT_ID, Permit_Type, VEHICLE_ID, Purchase_date, Expiry_date, Cost, DRIVER_ID, PAYMENT_ID) VALUES
(1, 'Annual', 1, '2023-01-01', '2024-01-01', 200.00, 1, 5),
(2, 'Semester', 2, '2023-08-15', '2024-01-15', 150.00, 2, 1),
(3, 'Monthly', 3, '2023-09-01', '2023-10-01', 50.00, 2, 2),
(4, 'Annual', 4, '2022-05-10', '2023-05-10', 200.00, 4, 4),
(5, 'Semester', 5, '2023-03-15', '2023-09-15', 150.00, 4, 3);

--Payment
DROP TABLE IF EXISTS Payment;
CREATE TABLE Payment (
    PAYMENT_ID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(10, 2),
    Credit_card_No VARCHAR(20),
    Check_no VARCHAR(20),
    Cash BOOLEAN,
    Date DATE
);

INSERT INTO PAYMENT (PAYMENT_ID, Amount, Credit_card_No, Check_no, Cash, Date) VALUES
(1, 200.00, '1234567890123456', NULL, FALSE, '2023-01-15'),
(2, 150.00, NULL, 'CHK001', FALSE, '2023-08-16'),
(3, 50.00, '6543210987654321', NULL, FALSE, '2023-09-02'),
(4, 150.00, NULL, NULL, TRUE, '2023-03-16'),
(5, 100.00, '1111222233334444', NULL, FALSE, '2022-11-20');


--Violation	
DROP TABLE IF EXISTS Violation;
CREATE TABLE Violation (
    VIOLATION_ID INT AUTO_INCREMENT PRIMARY KEY,
    Violation_type VARCHAR(50),
    Datetime DATETIME,
    VIOLATION_TYPE_ID INT,
    PAYMENT_ID INT,
    FOREIGN KEY (PAYMENT_ID) REFERENCES Payment(PAYMENT_ID)
);

INSERT INTO violation (VIOLATION_ID,violation_type,Datetime,VIOLATION_TYPE_ID,PAYMENT_ID) VALUES
(1, 'Meter Violation','2023-01-15',1,1),
(2, 'No Permit','2024-01-15',2,2),
(3, 'No Permit','2023-01-15',2,3),
(4, 'Lot Violation','2024-11-15',3,4),
(5, 'Meter Violation','2023-01-15',1,5);

--Parking Lot
DROP TABLE IF EXISTS Parking_Lot;
CREATE TABLE Parking_Lot (
    LOT_ID INT AUTO_INCREMENT PRIMARY KEY,
    Permit_type VARCHAR(50),
    Address VARCHAR(255),
    Capacity INT
);
--Parking SPACE
 DROP TABLE IF EXISTS Parking_Space;
CREATE TABLE Parking_Space (
    SPACE_ID INT AUTO_INCREMENT PRIMARY KEY,
    Field VARCHAR(50),
    LOT_ID INT,
    FOREIGN KEY (LOT_ID) REFERENCES Parking_Lot(LOT_ID)
);
--Users	
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    driver_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstname varchar(128) not null,
	lastname varchar(128) not null,
	username varchar(128) not null unique,
	password varchar(128) not null,
	email varchar(128) not null,
	driver_type varchar(16) not null,
	address varchar(128)
    );
  


DROP TABLE IF EXISTS `roles`;

-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `role` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
;

-- Inserting sample data into roles table with roles 'driver' and 'admin'
INSERT INTO `roles` (`id`, `username`, `role`) VALUES
(1, 'bsmith', 'admin'),
(2, 'pjones', 'driver'),
(3, 'jdoe', 'admin'),
(4, 'asmith', 'driver'),
(5, 'mjohnson', 'driver');

  