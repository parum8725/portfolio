-- =====================================================
-- Database : portfolio_db
-- Untuk    : Admin Panel Portfolio Sarah Ika
-- Cara pakai di XAMPP:
--   1. Buka phpMyAdmin (http://localhost/phpmyadmin)
--   2. Klik tab "Import" lalu pilih file ini
--   3. Klik "Go" / "Kirim"
--   4. Setelah itu buka http://localhost/portfolio/php/install.php
--      untuk membuat user admin default
-- =====================================================

CREATE DATABASE IF NOT EXISTS `portfolio_db`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `portfolio_db`;

-- -----------------------------------------------------
-- Tabel users (login admin)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabel profile (data diri / jumbotron)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `brand_name` VARCHAR(100) NOT NULL DEFAULT 'Sarah Ika',
  `name` VARCHAR(150) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `instagram` VARCHAR(255) DEFAULT NULL,
  `linkedin` VARCHAR(255) DEFAULT NULL,
  `footer_text` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `profile` (`brand_name`, `name`, `subtitle`, `photo`, `instagram`, `linkedin`, `footer_text`) VALUES
('Sarah Ika',
 'Sarah Ika Puspita Arum',
 'Informatics Engineering | Student Of Duta Bangsa University',
 'fotoku.jpg',
 'https://www.instagram.com/sarahika.pa/',
 'https://www.linkedin.com/in/sarah-ika-puspita-arum-59ab58208',
 '© 2024 Created by Sarah Ika');

-- -----------------------------------------------------
-- Tabel about (konten About Me)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `content` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about` (`content`) VALUES
('My name is Sarah Ika Puspita Arum, but you can call me Sarah. I am currently a 4 semester student at Universitas Duta Bangsa, studying Informatics Engineering in the Faculty of Computer Science. I have interest in technology, especially in the development of IoT (Internet of Things).

Right now, I am active in the IoT lab team at my university, where I am involved in innovative projects that provide valuable experience. One of my achievements is winning 1st place in the national IoT competition at Politeknik Indonusa''s Innovation Contest for Students in November 2023. Additionally, I am exploring the world of programming, focusing on mobile application development with Flutter and visual programming using Java.

I am also part of two startups: Atamagri and Empower Play. Atamagri focuses on developing technology solutions for agriculture. Here, I am involved in various projects developing weather station tools, commercial drones, and applications for mapping land and identifying pests and plant diseases. Empower Play''s main business is creating and researching technological innovations to help people with disabilities of various kinds.

Moreover, I have experience in computer networks, including MikroTik, Debian, and Cisco. During my studies, I have taken various programming courses such as C++, HTML, CSS, Python, and Laravel, and I have successfully completed final projects that involve creating simple websites or applications.

I have been active in the Informatics Engineering Student Association (HMPTI) since the beginning of my studies until the 4th semester, serving in the research and technology division. In this role, I have participated in various development and research projects in the field of technology.

With all these experiences, I hope to continue growing and making a positive contribution to the world of technology, as well as being part of a community focused on innovation and collaboration.');

-- -----------------------------------------------------
-- Tabel organizations (pengalaman organisasi)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `role` VARCHAR(200) NOT NULL,
  `items` TEXT NOT NULL COMMENT 'Satu baris per item (dipisah newline)',
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `organizations` (`title`, `role`, `items`, `sort_order`) VALUES
('Empower Play', 'Technology Research',
'Research and stay updated on the latest technologies in therapy games and sign language translation.
Analyze academic literature, journals, and case studies relevant to the field.
Design and build prototypes of new technologies that can be integrated into Empower Play''s products.
Test these prototypes in a controlled environment to assess their performance and effectiveness.
Assess the current technologies used in the products to determine their strengths and weaknesses.
Collect and analyze data on how users interact with the products and the impact on their skills and understanding.
Work closely with product developers, designers, and marketers to ensure the technologies meet the company''s vision and mission.
Present research findings and recommendations to stakeholders clearly and comprehensively.
Create detailed reports of the research findings, including analysis and recommendations.
Document technical details necessary for further development.', 1),

('Atamagri', 'CTO',
'Develop and implement a long-term vision for technology at Atamagri.
Create strategies that support the company''s growth and success.
Lead the technical team in developing products like Atama Climate, Atama Vis, and Atama Sense.
Oversee the product development lifecycle from concept to launch.
Manage the integration of IoT and AI technologies to enhance weather monitoring accuracy and pest control predictions.
Develop advanced AI algorithms for analyzing weather data, temperature, and humidity.
Innovate new features that improve the efficiency and effectiveness of Atamagri products.
Identify new opportunities in agricultural technology and implement them in Atamagri''s products.', 2),

('HIMPUNAN MAHASISWA TEKNIK INFORMATIKA (HMPTI)', 'RESEARCH AND TECHNOLOGY',
'Managing the artwork gallery on the HMPTI website.
Conducting research to develop content materials for social media.
Compiling materials to be used in Sibarmati and webinars.
Managing and updating the user interface (UI) on the HMPTI website.
Monitoring and analyzing the performance of social media content.
Coordinating and facilitating the execution of webinars and Sibarmati.', 3);

-- -----------------------------------------------------
-- Tabel projects (projects & certificates)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `projects` (`title`, `description`, `image`, `sort_order`) VALUES
('IOT Project for Physics', 'Designing a gas leakage detector based on IoT using MQ-2 sensor', 'kandang1.jpg', 1),
('IOT Project for Physics', 'Designing a gas leakage detector based on IoT using MQ-2 sensor.', 'gas.jpg', 2),
('IOT Project for Electronics', 'Monitoring electrical power based on Internet of Things using the Blynk application.', 'listrik.jpg', 3),
('Flutter UI/UX Project', 'Designing UI/UX for a mobile to-do list application.', 'list1.jpg', 4),
('IMK UI/UX Project', 'Designing UI/UX for a garment factory website for inputting and outputting clothing.', 'baju.jpg', 5),
('Computer Network Project', 'Cisco network simulation: Case study with 5 switches and 2 routers.', 'cisco.jpg', 6),
('IOT Competition Champion Certificate', 'Monitoring temperature and humidity in duckling pens using ESP8266.', 'komnas.png', 7),
('Earth Competition Participant Certificate', 'Automatic watering and fertilizing device using MAPPI-32.', 'earth.jpg', 8),
('EDUCATION TRAINING CERTIFICATE', 'STP X UNS XNCHU X RAFIXUS Cybersecurity Education Training', 'stp1.jpg', 9),
('LOUCA23 CERTIFICATE', 'LibreOffice Conf. Asia & UbuCon Asia 2023', 'loca.jpg', 10),
('CERTIFICATE OF COMPLETION', 'Basics Of Sustainability', 'ecoyz.jpg', 11),
('TOP 10 TGSC 2023', 'The Gade Sociopreneurship Challenge 2023', 'tgsc.jpg', 12),
('INNOVATION CHALLENGE', 'Indonesia Ai Innovation Challenge Top 9', 'atamagrii.jpg', 13),
('TDC SUMMIT FEST 2023', 'Pitching And Exhabition', 'TDC.jpg', 14);

-- -----------------------------------------------------
-- Tabel messages (pesan dari form kontak)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
