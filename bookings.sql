-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS book;

-- Switch to the newly created database
USE book;

-- Create the table if it doesn't exist
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    timeslot VARCHAR(50) NOT NULL,
    CONSTRAINT unique_booking UNIQUE (name, date, timeslot) -- Define a unique constraint
);

