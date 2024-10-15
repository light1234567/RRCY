-- Create the crimes table
CREATE TABLE IF NOT EXISTS crimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crime_name VARCHAR(100) NOT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES crime_categories(id) ON DELETE CASCADE
);

-- Insert data into crimes table
-- Crime Against Person
INSERT INTO crimes (crime_name, category_id) VALUES
('Rape (RA 8353)', 1),
('Homicide', 1),
('Statutory Rape', 1),
('Attempted Homicide', 1),
('Sexual Assault', 1),
('Frustrated Homicide', 1),
('Acts of Lasciviousness', 1),
('Frustrated Murder', 1),
('Murder', 1),
('Robbery Against Person', 1),
('Attempted Murder', 1),
('Slight Physical Injury', 1),
('Qualified Statutory Rape through Carnal Knowledge', 1),
('Special Complex Crime of Rape with Homicide', 1),
('Qualified Trafficking in Person', 1),
('Grave Threat', 1);

-- Crime Against Property
INSERT INTO crimes (crime_name, category_id) VALUES
('Robbery', 2),
('Theft', 2),
('Robbery with force upon things', 2),
('Qualified Theft', 2),
('Robbery in an inhabited place', 2),
('Trespass to dwelling', 2),
('Robbery in uninhabited place', 2),
('Malicious Mischief', 2),
('Car napping (RA 10883 of 2016)', 2),
('Robbery with violence against persons', 2),
('Destructive Arson and Simple Theft', 2),
('PD 1612', 2),
('Robbery with intimidation against person and RA10883', 2);

-- Violation Against Special Laws
INSERT INTO crimes (crime_name, category_id) VALUES
('RA 9165 - Comprehensive Dangerous Drug Act of 2002', 3),
('RA 10591 - Comprehensive Firearms and Ammunition Regulation Act', 3),
('RA 8485 - Animal Welfare Act of 1998', 3),
('PD 1612 - Anti-Fencing Law of 1979', 3),
('RA 9208 - Anti-Trafficking in Persons Act of 2003', 3),
('Illegal possession of explosives', 3);
