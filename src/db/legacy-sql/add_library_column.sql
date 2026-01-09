-- SQL script to add is_library column to Sets table
-- Run this once to update your database structure

ALTER TABLE `Sets` ADD COLUMN `is_library` TINYINT(1) DEFAULT 0;

-- Add index for better performance
CREATE INDEX idx_is_library ON `Sets`(is_library);

-- Note: All existing sets will have is_library = 0 (user sets)
-- Library sets will have is_library = 1 and user_id = 0


