-- Create the rtc_provinces table
CREATE TABLE IF NOT EXISTS rtc_provinces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    province_name VARCHAR(20) NOT NULL
);

-- Insert data into rtc_provinces table
INSERT INTO rtc_provinces (province_name) VALUES
('DAVAO DEL NORTE'),
('DAVAO DE ORO'),
('DAVAO ORIENTAL'),
('DAVAO DEL SUR'),
('DAVAO OCCIDENTAL'),
('DAVAO CITY');
