CREATE DATABASE IF NOT EXISTS onepiece_db;
USE onepiece_db;

-- Tabel Autentikasi
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Utama Karakter
CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    epithet VARCHAR(100), 
    bounty BIGINT,
    devil_fruit VARCHAR(100) DEFAULT 'None',
    photo_url VARCHAR(255),
    general_information TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Relasi 1: Versi Arc
CREATE TABLE IF NOT EXISTS character_arcs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    character_id INT NOT NULL,
    arc_name VARCHAR(100) NOT NULL,
    status TEXT,
    arc_photo_url VARCHAR(255),
    FOREIGN KEY (character_id) REFERENCES characters(id) ON DELETE CASCADE
);

-- Tabel Relasi 2: Kemampuan (Abilities)
CREATE TABLE IF NOT EXISTS character_abilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    character_id INT NOT NULL,
    ability_name VARCHAR(100) NOT NULL,
    ability_type ENUM('Devil Fruit', 'Haki', 'Weapon', 'Physical', 'Other') NOT NULL,
    description TEXT,
    ability_photo_url VARCHAR(255),
    FOREIGN KEY (character_id) REFERENCES characters(id) ON DELETE CASCADE
);

-- Insert dummy admin
INSERT INTO users (username, email, password) VALUES 
('admin', 'admin@onepiece.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password
