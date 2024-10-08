-- Create the rtc_branches table
CREATE TABLE rtc_branches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(100) NOT NULL,
    province_id INT,
    FOREIGN KEY (province_id) REFERENCES rtc_provinces(id) ON DELETE CASCADE
);

-- Insert data into rtc_branches table
-- RTC branches in DAVAO DEL NORTE
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 2, Tagum City', 1),
('RTC-Br, 2-FC, Tagum City', 1),
('RTC-Br, 1, Tagum City', 1),
('RTC-Br, 3-FC, Panabo City', 1),
('RTC-Br, 34, Panabo City', 1),
('RTC-Br, 4, Panabo City', 1),
('RTC-Br, 4-FC, Samal', 1);

-- RTC branches in DAVAO DE ORO
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 3, Nabunturan', 2),
('RTC-Br, 56, Compostela', 2);

-- RTC branches in DAVAO ORIENTAL
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 7, Baganga', 3),
('RTC-Br, 9, Lupon', 3);

-- RTC branches in DAVAO DEL SUR
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 7, Sta. Cruz', 4),
('RTC-Br, 5, Digos City', 4),
('RTC-Br, 61, Digos City', 4),
('RTC-Br, 21, Bansalan', 4);

-- RTC branches in DAVAO OCCIDENTAL
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 20, Digos City', 5);

-- RTC branches in DAVAO CITY
INSERT INTO rtc_branches (branch_name, province_id) VALUES
('RTC-Br, 33, Davao City', 6),
('RTC-Br, 6-FC, Davao City', 6),
('RTC-Br, 12, Davao City', 6),
('RTC-Br, 8, Davao City', 6);
