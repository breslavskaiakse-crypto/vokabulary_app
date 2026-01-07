-- SQL script to add user_id column to Sets table
-- Run this once to update your database structure

-- Add user_id column to Sets table
ALTER TABLE `Sets` ADD COLUMN `user_id` INT NULL AFTER `set_id`;

-- Note: For existing data, you may want to set a default user_id or delete old data
-- For now, we'll leave existing rows with NULL user_id (they'll be orphaned)
-- You can update them manually if needed:
-- UPDATE Sets SET user_id = 1 WHERE user_id IS NULL;  -- Replace 1 with actual user ID

-- Make it NOT NULL after handling existing data
-- ALTER TABLE `Sets` MODIFY COLUMN `user_id` INT NOT NULL;

-- Add foreign key constraint (optional but recommended)
-- ALTER TABLE `Sets` ADD CONSTRAINT fk_user_id 
--     FOREIGN KEY (user_id) REFERENCES Users(id) 
--     ON DELETE CASCADE;

-- Add index for better query performance
CREATE INDEX idx_user_id ON `Sets`(user_id);

