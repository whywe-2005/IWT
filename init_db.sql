-- Select the database defined in docker-compose.yml
USE event_db;

-- 1. Table for RSVP entries (used by index.php, view.php)
CREATE TABLE IF NOT EXISTS rsvp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    message TEXT,
    rsvp_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table for feedback entries (used by index.php)
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table for invitations (used by submit.php, in case you use it later)
-- Note: This structure is inferred from submit.php, assuming a 'guests' field
CREATE TABLE IF NOT EXISTS invitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    guests INT,
    message TEXT
);