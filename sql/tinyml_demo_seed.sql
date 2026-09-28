-- Optional demo data for TinyML ranking.
-- Run after tinyml_migration.sql.
-- These are fictional demo donors created only for the course prototype.

INSERT INTO donor_details
(donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address,
 total_donations, last_donation_date, first_donation_date)
VALUES
('Demo A Plus 1','0500001001','demo1@fidak.local',28,'Female','A+','Jeddah',8,'2026-08-20','2023-01-15'),
('Demo A Plus 2','0500001002','demo2@fidak.local',34,'Male','A+','Jeddah',3,'2026-03-12','2024-06-02'),
('Demo A Plus 3','0500001003','demo3@fidak.local',25,'Female','A+','Jeddah',12,'2026-07-05','2022-05-18'),
('Demo A Plus 4','0500001004','demo4@fidak.local',39,'Male','A+','Jeddah',2,'2025-10-11','2025-02-01'),
('Demo O Plus 1','0500002001','demo5@fidak.local',31,'Female','O+','Jeddah',10,'2026-08-01','2022-04-20'),
('Demo O Plus 2','0500002002','demo6@fidak.local',45,'Male','O+','Jeddah',4,'2026-01-09','2024-01-09'),
('Demo O Plus 3','0500002003','demo7@fidak.local',29,'Female','O+','Jeddah',6,'2026-06-18','2023-08-10');
