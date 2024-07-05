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


-- Create the matchtype table
CREATE TABLE matchtype (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) UNIQUE
);

-- Create the matches table
CREATE TABLE matches (
    match_id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50),
    team_1 VARCHAR(50),
    team_2 VARCHAR(50),
    team_1_odds DECIMAL(5, 2),
    team_2_odds DECIMAL(5, 2),
    winteam VARCHAR(50),
    match_date DATE,
    FOREIGN KEY (type) REFERENCES matchtype(type)
);

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
-- articles table
CREATE TABLE articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100),
    published_date DATE,
    category VARCHAR(200),
    image_url VARCHAR(255)
);

INSERT INTO jackpottypes (type) VALUES ('Sportpesa');
INSERT INTO jackpottypes (type) VALUES ('Betpower');
INSERT INTO jackpottypes (type) VALUES ('Mozzartbet');
INSERT INTO jackpottypes (type) VALUES ('Odibet');

-- Insert match types into the matchtype table
INSERT INTO matchtype (type) VALUES ('Premier League');
INSERT INTO matchtype (type) VALUES ('La Liga');
INSERT INTO matchtype (type) VALUES ('Serie A');
INSERT INTO matchtype (type) VALUES ('Bundesliga');
INSERT INTO matchtype (type) VALUES ('Ligue 1');
INSERT INTO matchtype (type) VALUES ('Eredivisie');
INSERT INTO matchtype (type) VALUES ('Primeira Liga');
INSERT INTO matchtype (type) VALUES ('MLS');
INSERT INTO matchtype (type) VALUES ('Brasileirão');
INSERT INTO matchtype (type) VALUES ('J1 League');
