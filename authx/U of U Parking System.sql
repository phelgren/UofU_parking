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
INSERT INTO users (driver_id, firstname, lastname, username, password, email, driver_type, address) VALUES
(1, 'John', 'Doe', 'jdoe', 'password123', 'jdoe@example.com', 'Driver', '123 Main St'),
(2, 'Jane', 'Smith', 'jsmith', 'password456', 'jsmith@example.com', 'Driver', '456 Elm St'),
(3, 'Bob', 'Brown', 'bbrown', 'password789', 'bbrown@example.com', 'Driver', '789 Pine St'),
(4, 'Alice', 'Johnson', 'ajohnson', 'password321', 'ajohnson@example.com', 'Driver', '321 Oak St'),
(5, 'Mike', 'Williams', 'mwilliams', 'password654', 'mwilliams@example.com', 'Driver', '654 Cedar St');

-- Create Roles Table
CREATE TABLE IF NOT EXISTS roles (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Insert sample data into Roles Table
INSERT INTO roles (id, username, role) VALUES
(1, 'bsmith', 'admin'),
(2, 'pjones', 'driver'),
(3, 'jdoe', 'admin'),
(4, 'asmith', 'driver'),
(5, 'mjohnson', 'driver');

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
INSERT INTO Payment (PAYMENT_ID, Amount, Credit_card_No, Check_no, Cash, Date) VALUES
(1, 200.00, '1234567890123456', NULL, FALSE, '2023-01-15'),
(2, 150.00, NULL, 'CHK001', FALSE, '2023-08-16'),
(3, 50.00, '6543210987654321', NULL, FALSE, '2023-09-02'),
(4, 150.00, NULL, NULL, TRUE, '2023-03-16'),
(5, 100.00, '1111222233334444', NULL, FALSE, '2022-11-20');

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
INSERT INTO Violation (VIOLATION_ID, Violation_type, Datetime, VIOLATION_TYPE_ID, PAYMENT_ID) VALUES
(1, 'Speeding', '2023-05-01 08:30:00', 101, 1),
(2, 'Parking', '2023-05-02 09:15:00', 102, 2);

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
    FOREIGN KEY (VIOLATION_ID) REFERENCES Violation(VIOLATION_ID) on delete cascade
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Vehicle Table
INSERT INTO Vehicle (VEHICLE_ID, DRIVER_ID, License_Plate, Make, Model, Color, Year, VIOLATION_ID) VALUES
(1, 1, 'ZL1234', 'Toyota', 'Corolla', 'Red', 2015, NULL),
(2, 2, 'HY5678', 'Honda', 'Civic', 'Blue', 2018, 1),
(3, 3, 'BR9101', 'Ford', 'Focus', 'Black', 2019, NULL),
(4, 4, 'KT1123', 'Chevy', 'Malibu', 'White', 2020, 2),
(5, 5, 'UE1415', 'Nissan', 'Altima', 'Grey', 2017, NULL);

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
    FOREIGN KEY (PAYMENT_ID) REFERENCES Payment(PAYMENT_ID) on delete cascade
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data into Permit Table
INSERT INTO Permit (PERMIT_ID, Permit_Type, VEHICLE_ID, Purchase_date, Expiry_date, Cost, DRIVER_ID, PAYMENT_ID) VALUES
(1, 'Annual', 1, '2023-01-01', '2024-01-01', 200.00, 1, 5),
(2, 'Semester', 2, '2023-08-15', '2024-01-15', 150.00, 2, 1),
(3, 'Monthly', 3, '2023-09-01', '2023-10-01', 50.00, 3, 2),
(4, 'Annual', 4, '2022-05-10', '2023-05-10', 200.00, 4, 4),
(5, 'Semester', 5, '2023-03-15', '2023-09-15', 150.00, 5, 3);

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
