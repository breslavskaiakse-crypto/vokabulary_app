-- SQL script to add Password column to Users table
-- Run this once to update your database structure

ALTER TABLE `Users` ADD COLUMN `Password` VARCHAR(255) NULL AFTER `Email`;

-- Make Password NOT NULL after adding it (optional, but recommended for security)
-- ALTER TABLE `Users` MODIFY COLUMN `Password` VARCHAR(255) NOT NULL;

