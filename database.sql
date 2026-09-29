CREATE DATABASE IF NOT EXISTS php_crud
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE php_crud;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, phone, course) VALUES
('Rahul Patil', 'rahul@example.com', '9876543210', 'BCA'),
('Sneha Sharma', 'sneha@example.com', '9123456780', 'BSc Computer Science');
