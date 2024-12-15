CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;


CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(500),
    lastname VARCHAR(500),
    password VARCHAR(500),
    email VARCHAR(500) UNIQUE,
    role VARCHAR(500),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP 
);


CREATE TABLE IF NOT EXISTS Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    firstname VARCHAR(500),
    lastname VARCHAR(500),
    email VARCHAR(500) UNIQUE,
    telephone VARCHAR(100) UNIQUE,
    company VARCHAR(500),
    type VARCHAR(100),
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES Users(id) ON DELETE CASCADE
);


INSERT INTO Users (firstname, lastname, password, email, role, created_at)
VALUES (
    'Admin', 
    'First_User', 
    '$2y$10$/hxj/.zLNpIuwahEyaHRXOu1dVkfFE1pLGLw1t3A8ko5bG.akhmh.', -- should check
    'admin@project2.com', 
    'admin', 
    NOW()
);