CREATE TABLE usertypes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usertype VARCHAR(50) NOT NULL UNIQUE
);

-- Insert predefined user types
INSERT INTO usertypes (usertype) VALUES 
('Admin'),
('SU'),
('User');

-- Create the users table with a foreign key reference to usertypes
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usertype_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    unique_code VARCHAR(100) UNIQUE NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usertype_id) REFERENCES usertypes(id)
);

-- Create the function to generate random strings
DELIMITER $$

CREATE FUNCTION generate_random_string(length INT) RETURNS VARCHAR(100)
BEGIN
    DECLARE chars_str VARCHAR(100) DEFAULT 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    DECLARE str VARCHAR(100) DEFAULT '';
    DECLARE i INT DEFAULT 0;

    WHILE i < length DO
        SET str = CONCAT(str, SUBSTRING(chars_str, FLOOR(1 + RAND() * 62), 1));
        SET i = i + 1;
    END WHILE;

    RETURN str;
END $$

DELIMITER ;

-- Create the trigger to set unique_code before insertion
DELIMITER $$

CREATE TRIGGER before_insert_users
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    DECLARE usertype_name VARCHAR(50);
    SELECT usertype INTO usertype_name FROM usertypes WHERE id = NEW.usertype_id;
    SET NEW.unique_code = CONCAT(usertype_name, '_', generate_random_string(10));
END $$

DELIMITER ;
DROP TABLE IF EXISTS `matches`;
DROP TABLE IF EXISTS `plans`;

-- Table structure for table `matches`
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_id` int NOT NULL,
  `team1` varchar(100) NOT NULL,
  `team2` varchar(100) NOT NULL,
  `odds_team1` decimal(10,2) NOT NULL,
  `odds_team2` decimal(10,2) NOT NULL,
  `win_team` varchar(100) NOT NULL,
  `date_played` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `plan_id` (`plan_id`)
);



-- Table structure for table `plans`
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);


-- Inserting data for table `plans`
INSERT INTO `plans` (`name`, `created_at`) VALUES
('PLAN1', '2024-06-16 00:00:00'),
('PLAN2', '2024-06-16 00:00:00'),
('PLAN', '2024-06-16 00:00:00');

-- Create table for jackpot types
CREATE TABLE jackpottypes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL
);

-- Create table for jackpots
CREATE TABLE jackpots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jackpottype_id INT NOT NULL,
    team1 VARCHAR(100) NOT NULL,
    team2 VARCHAR(100) NOT NULL,
    win VARCHAR(100) NOT NULL,
    date_played DATE,
    FOREIGN KEY (jackpottype_id) REFERENCES jackpottypes(id)
);

INSERT INTO jackpottypes (type) VALUES ('Sportpesa');
INSERT INTO jackpottypes (type) VALUES ('Betpower');
INSERT INTO jackpottypes (type) VALUES ('Mozzartbet');
INSERT INTO jackpottypes (type) VALUES ('Odibet');

