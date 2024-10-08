-- Create the crime_categories table
CREATE TABLE crime_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

-- Insert data into crime_categories table
INSERT INTO crime_categories (category_name) VALUES
('Crime Against Person'),
('Crime Against Property'),
('Violation Against Special Laws');