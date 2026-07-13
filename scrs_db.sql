CREATE DATABASE IF NOT EXISTS smart_complaint_resolution_system;

USE smart_complaint_resolution_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,

    ticket_no VARCHAR(20) UNIQUE NOT NULL,

    title VARCHAR(150) NOT NULL,

    category ENUM(
        'Billing',
        'Technical',
        'Customer Service',
        'Delivery',
        'Product',
        'Other'
    ) NOT NULL,

    description TEXT NOT NULL,

    priority ENUM(
        'Low',
        'Medium',
        'High',
        'Critical'
    ) DEFAULT 'Medium',

    status ENUM(
        'Pending',
        'In Progress',
        'Resolved',
        'Closed'
    ) DEFAULT 'Pending',

    assigned_to INT DEFAULT NULL,

    resolution_notes TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (assigned_to) REFERENCES users(id)
        ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,

    complaint_id INT NOT NULL,

    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),

    comment TEXT,

    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (complaint_id)
        REFERENCES complaints(id)
        ON DELETE CASCADE
);

INSERT INTO users (
    full_name,
    username,
    email,
    password,
    role
)
VALUES (
    'System Administrator',
    'admin',
    'admin@scrs.com',
    '$2y$10$KpFlULjeGg4Gu/oWo1CMt.UTagg0Chb50Kxz8RnMv9QHGxITJ7UuO',
    'admin'
);