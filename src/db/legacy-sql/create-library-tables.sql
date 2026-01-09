-- Create LibrarySets table for ready-made vocabulary sets
CREATE TABLE IF NOT EXISTS `LibrarySets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `topic` VARCHAR(100) NOT NULL,
    `source_language` VARCHAR(50) NOT NULL,
    `target_language` VARCHAR(50) NOT NULL,
    `level` VARCHAR(50) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `word_count` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_topic (`topic`),
    INDEX idx_source_language (`source_language`),
    INDEX idx_target_language (`target_language`),
    INDEX idx_level (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create LibrarySetWords table to store words for each library set
CREATE TABLE IF NOT EXISTS `LibrarySetWords` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `library_set_id` INT NOT NULL,
    `word` VARCHAR(255) NOT NULL,
    `translation` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`library_set_id`) REFERENCES `LibrarySets`(`id`) ON DELETE CASCADE,
    INDEX idx_library_set_id (`library_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


