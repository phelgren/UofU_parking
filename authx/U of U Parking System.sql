-- Drop existing tables in the correct order
DROP TABLE IF EXISTS Parking_Space;
DROP TABLE IF EXISTS Parking_Lot;
DROP TABLE IF EXISTS Permit;
DROP TABLE IF EXISTS Vehicle;
DROP TABLE IF EXISTS Violation;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS users;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    driver_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    username VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    driver_type VARCHAR(16) NOT NULL,
    address VARCHAR(128)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Insert sample data into Users Table
INSERT INTO users (firstname, lastname, username, password, email, driver_type, address) VALUES
('Pauline', 'Jones', 'pjones', '$2y$10$eUPykGAZJkNSlDn6ajlwBOcOd3ORMu/suADQ0QmBKQrWLEeh1riSi', 'pjones@example.com', 'admin', '123 Main St'),
('Bill', 'Smith', 'bsmith', '$2y$10$Xkf5yhNmft37WLx0rUH87uDDPFmU1fKsePpnC6qhfUDaeaJfWWAKa', 'bsmith@example.com', 'faculty', '456 Elm St'),
('John', 'Doe', 'jdoe', '$2y$10$W4Sa0rY6uQuxL1n/TgoqPujxxJmfT68zMsGZ9C9ZFQvQu8ZVZVgBK', 'jdoe@example.com', 'student', '123 Main St'),
('Jane', 'Smith', 'jsmith', '$2y$10$HoTL2XhTpc986zr0XywPxevW.lA8ZtVxBGlGLYf4OokD9sjibdpi6', 'jsmith@example.com', 'faculty', '456 Oak St'),
('Alice', 'Johnson', 'ajohnson', '$2y$10$FIMjv/VMHgdsMS6KlsBTvuk4bzG7ytiwdVbWYNpAIgONywGBkZnfC', 'alice.johnson@example.com', 'student', '789 Pine St'),
('Bob', 'Williams', 'bwilliams', '$2y$10$msOyMKaoNt3v8kKfJA2iI.zaTRHAGKur0M7xrvJGT2.HRFU6CLegO', 'bob.williams@example.com', 'student', '101 Elm St'),
('Charlie', 'Brown', 'cbrown', '$2y$10$snd/H0P02XyghxvbdAUY/OSzPczCpsE6rIOwfFFuyE.eVRfcRAmSm', 'charlie.brown@example.com', 'faculty', '202 Maple St'),
('Diana', 'Miller', 'dmiller', '$2y$10$Tl.n9SrqhZUb49R1V9EHVuyZBy4Ot2hkShy4JuHn5F.9EKjulsRmS', 'diana.miller@example.com', 'faculty', '303 Birch St'),
('Evan', 'Davis', 'edavis', '$2y$10$2F0AMI8muY1wneS6fFtdCeZiylxefAsz4wfiUl.OgjDYx53DGWslO', 'evan.davis@example.com', 'student', '404 Cedar St'),
('Fiona', 'Garcia', 'fgarcia', '$2y$10$R8eJc/J/sLJ81X500LNumuxDaRm6bIWGgAxM07QPRiqQW/m0lqq8S', 'fiona.garcia@example.com', 'student', '505 Ash St'),
('George', 'Martinez', 'gmartinez', '$2y$10$84qecHcHTjQmakTOfumgSOaXAb4Y82r2pa21kS4Q0WkvWsCOgAwQ6', 'george.martinez@example.com', 'guest', '606 Spruce St'),
('Hannah', 'Lopez', 'hlopez', '$2y$10$Dx04vspTOmPMqFEQGRmeCOEwwouNhHCct3./IqIr4m5fthWoXcup2', 'hannah.lopez@example.com', 'student', '707 Cherry St'),
('Ian', 'Clark', 'iclark', '$2y$10$3zZZ4J7fnUBSUnQuEr9PmuVKKIBRjnloiOxwXAropcd2ovys8WTXG', 'ian.clark@example.com', 'faculty', '808 Walnut St'),
('Jenna', 'Harris', 'jharris', '$2y$10$ZzNCN9owfcLxX5udB/TvN.Wk75qYSo79f4IZsv6rzp4RKAdqTrc5K', 'jenna.harris@example.com', 'student', '909 Poplar St'),
('Kyle', 'Lewis', 'klewis', '$2y$10$Gcvw6oHjJZL.Lmbdky3qGuQOFGxnymis41IZJuK1x5duXEIXFS2VS', 'kyle.lewis@example.com', 'faculty', '1001 Fir St'),
('Laura', 'Walker', 'lwalker', '$2y$10$mKkfxYU/lk9ZfczrXjqcyeiPDTACoBT/X7E41JCun8Sx/hLA.kyoK', 'laura.walker@example.com', 'student', '1102 Magnolia St'),
('Michael', 'Robinson', 'mrobinson', '$2y$10$mKkfxYU/lk9ZfczrXjqcyeiPDTACoBT/X7E41JCun8Sx/hLA.kyoK', 'michael.robinson@example.com', 'student', '1203 Cypress St');


-- Create Roles Table
CREATE TABLE IF NOT EXISTS roles (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Insert sample data into Roles Table -- needed for the few folks who have multiple roles
INSERT INTO roles (id, username, role) VALUES
(1, 'pjones', 'admin'),
(2, 'jsmith', 'admin');


-- Create Payment Table
CREATE TABLE Payment (
    PAYMENT_ID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(10, 2),
    Credit_card_No VARCHAR(20),
    Check_no VARCHAR(20),
    Cash BOOLEAN,
    Date DATE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Payment Table
INSERT INTO Payment (Amount, Credit_card_No, Check_no, Cash, Date) VALUES
(200.00, '1234567890123456', NULL, FALSE, '2023-01-15'),
(150.00, NULL, 'CHK001', FALSE, '2023-08-16'),
(50.00, '6543210987654321', NULL, FALSE, '2023-09-02'),
(150.00, NULL, NULL, TRUE, '2023-03-16'),
(100.00, '1111222233334444', NULL, FALSE, '2022-11-20'),
(120.50, '4111111111111111', NULL, FALSE, '2024-11-01'),
(85.75, NULL, 'CHK202311', FALSE, '2024-11-02'),
(50.00, NULL, NULL, TRUE, '2024-11-03'),
(200.00, '4222222222222222', NULL, FALSE, '2024-11-04'),
(95.25, NULL, 'CHK202312', FALSE, '2024-11-05'),
(30.00, NULL, NULL, TRUE, '2024-11-06'),
(150.00, '4333333333333333', NULL, FALSE, '2024-11-07'),
(60.75, NULL, 'CHK202313', FALSE, '2024-11-08'),
(45.00, NULL, NULL, TRUE, '2024-11-09'),
(300.00, '4444444444444444', NULL, FALSE, '2024-11-10'),
(75.50, NULL, 'CHK202314', FALSE, '2024-11-11'),
(25.00, NULL, NULL, TRUE, '2024-11-12'),
(180.00, '4555555555555555', NULL, FALSE, '2024-11-13'),
(90.75, NULL, 'CHK202315', FALSE, '2024-11-14'),
(40.00, NULL, NULL, TRUE, '2024-11-15'),
(828.00, '4111111111111111', NULL, FALSE, '2024-11-16'),
(883.00, '4222222222222222', NULL, FALSE, '2024-11-17'),
(828.00, '4333333333333333', NULL, FALSE, '2024-11-18'),
(345.00, NULL, 'CHK202316', FALSE, '2024-11-19'),
(172.50, NULL, NULL, TRUE, '2024-11-20'),
(1331.70, '4444444444444444', NULL, FALSE, '2024-11-21'),
(2815.20, '4555555555555555', NULL, FALSE, '2024-11-22'),
(2346.00, NULL, 'CHK202317', FALSE, '2024-11-23'),
(1393.80, NULL, NULL, TRUE, '2024-11-24'),
(115.20, NULL, 'CHK202318', FALSE, '2024-11-25');

-- Create Violation Table
CREATE TABLE Violation (
    VIOLATION_ID INT AUTO_INCREMENT PRIMARY KEY,
    Violation_type VARCHAR(50),
    Datetime DATETIME,
    VIOLATION_TYPE_ID INT,
    PAYMENT_ID INT,
    FOREIGN KEY (PAYMENT_ID) REFERENCES Payment(PAYMENT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Violation Table
INSERT INTO Violation ( Violation_type, Datetime, VIOLATION_TYPE_ID, PAYMENT_ID) VALUES
('Speeding', '2023-05-01 08:30:00', 101, 1),
('Parking', '2023-05-02 09:15:00', 102, 2),
('No Permit', '2024-11-01 08:30:00', 1, 1),
('Time Expired', '2024-11-02 09:00:00', 2, 2),
('Invalid Permit', '2024-11-03 10:15:00', 3, 3),
('No Permit', '2024-11-04 11:45:00', 1, 4),
('Time Expired', '2024-11-05 12:30:00', 2, 5),
('Invalid Permit', '2024-11-06 13:00:00', 3, 6),
('No Permit', '2024-11-07 14:20:00', 1, 7),
('Time Expired', '2024-11-08 15:00:00', 2, 8),
('Invalid Permit', '2024-11-09 16:10:00', 3, 9),
('No Permit', '2024-11-10 17:30:00', 1, 10),
('Time Expired', '2024-11-11 18:00:00', 2, 11),
('Invalid Permit', '2024-11-12 19:15:00', 3, 12),
('No Permit', '2024-11-13 20:45:00', 1, 13),
('Time Expired', '2024-11-14 21:30:00', 2, 14),
('Invalid Permit', '2024-11-15 22:00:00', 3, 15);


-- Create Vehicle Table
CREATE TABLE Vehicle (
    VEHICLE_ID INT AUTO_INCREMENT PRIMARY KEY,
    DRIVER_ID INT,
    License_Plate VARCHAR(20) UNIQUE,
    Make VARCHAR(50),
    Model VARCHAR(50),
    Color VARCHAR(20),
    Year YEAR,
    VIOLATION_ID INT,
    FOREIGN KEY (DRIVER_ID) REFERENCES users(driver_id),
    FOREIGN KEY (VIOLATION_ID) REFERENCES Violation(VIOLATION_ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Vehicle Table
INSERT INTO Vehicle (DRIVER_ID, License_Plate, Make, Model, Color, Year, VIOLATION_ID) VALUES
(1, 'ZL1234', 'Toyota', 'Corolla', 'Red', 2015, NULL),
(2, 'HY5678', 'Honda', 'Civic', 'Blue', 2018, 1),
(1, 'ABC1234', 'Toyota', 'Camry', 'Blue', 2018, 1), -- Associated with Violation_ID 1
(2, 'XYZ5678', 'Honda', 'Civic', 'Red', 2020, 2), -- Associated with Violation_ID 2
(3, 'LMN8901', 'Ford', 'F-150', 'Black', 2017, NULL),
(4, 'DEF2345', 'Chevrolet', 'Malibu', 'White', 2019, 3), -- Associated with Violation_ID 3
(5, 'UVW6789', 'Tesla', 'Model 3', 'Gray', 2022, NULL),
(6, 'GHI3456', 'Nissan', 'Altima', 'Silver', 2016, NULL),
(7, 'RST9101', 'BMW', 'X5', 'Blue', 2021, 4), -- Associated with Violation_ID 4
(8, 'JKL4567', 'Hyundai', 'Elantra', 'Green', 2015, NULL),
(9, 'NOP5678', 'Kia', 'Sportage', 'Yellow', 2019, NULL),
(10, 'QRS6789', 'Subaru', 'Outback', 'Brown', 2020, 5), -- Associated with Violation_ID 5
(11, 'TUV7890', 'Mazda', 'CX-5', 'Orange', 2018, NULL),
(12, 'WXY8901', 'Volkswagen', 'Golf', 'Black', 2016, NULL),
(13, 'ZAB9012', 'Jeep', 'Wrangler', 'Red', 2023, NULL),
(14, 'BCD1234', 'Audi', 'A4', 'Silver', 2017, NULL),
(15, 'EFG3456', 'Mercedes', 'C-Class', 'White', 2021, NULL);


-- Create Permit Table
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
    FOREIGN KEY (DRIVER_ID) REFERENCES users(driver_id),
    FOREIGN KEY (PAYMENT_ID) REFERENCES Payment(PAYMENT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Permit Table
INSERT INTO Permit (Permit_Type, VEHICLE_ID, Purchase_date, Expiry_date, Cost, DRIVER_ID, PAYMENT_ID) VALUES
('Permit A', 1, '2024-11-16', '2025-11-16', 828.00, 1, 16),
('Permit CA', 2, '2024-11-17', '2025-11-17', 883.00, 2, 17),
('Permit CU', 3, '2024-11-18', '2025-11-18', 828.00, 3, 18),
('Permit U', 4, '2024-11-19', '2025-11-19', 345.00, 4, 19),
('Semester U', 5, '2024-11-20', '2024-12-20', 172.50, 5, 20),
('Vendor', 6, '2024-11-21', '2025-11-21', 1331.70, 6, 21),
('Permit MR', 7, '2024-11-22', '2025-11-22', 2815.20, 7, 22),
('Permit R', 8, '2024-11-23', '2025-11-23', 2346.00, 8, 23),
('Permit T', 9, '2024-11-24', '2025-11-24', 1393.80, 9, 24),
('Motorcycle', 10, '2024-11-25', '2025-11-25', 115.20, 10, 25),
('Permit A', 11, '2024-11-16', '2025-11-16', 828.00, 11, 16),
('Permit CA', 12, '2024-11-17', '2025-11-17', 883.00, 12, 17),
('Permit CU', 13, '2024-11-18', '2025-11-18', 828.00, 13, 18),
('Permit U', 14, '2024-11-19', '2025-11-19', 345.00, 14, 19),
('Semester U', 15, '2024-11-20', '2024-12-20', 172.50, 15, 20);


-- Create Parking_Lot Table
CREATE TABLE Parking_Lot (
    LOT_ID INT AUTO_INCREMENT PRIMARY KEY,
    Permit_type VARCHAR(50),
    Address VARCHAR(255),
    Capacity INT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create Parking_Space Table
CREATE TABLE Parking_Space (
    SPACE_ID INT AUTO_INCREMENT PRIMARY KEY,
    Field VARCHAR(50),
    LOT_ID INT,
    FOREIGN KEY (LOT_ID) REFERENCES Parking_Lot(LOT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
