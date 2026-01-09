-- SQL script to add set_id column to Sets table
-- Run this once to update your database structure

ALTER TABLE `Sets` ADD COLUMN `set_id` INT NULL AFTER `id`;

-- Update existing rows: use the id of the first word in each set as the set_id
UPDATE `Sets` s1
INNER JOIN (
    SELECT name, MIN(id) as first_id
    FROM `Sets`
    GROUP BY name
) s2 ON s1.name = s2.name
SET s1.set_id = s2.first_id;

-- Make set_id NOT NULL after updating existing data
ALTER TABLE `Sets` MODIFY COLUMN `set_id` INT NOT NULL;

-- Add index for better performance
CREATE INDEX idx_set_id ON `Sets`(set_id);


