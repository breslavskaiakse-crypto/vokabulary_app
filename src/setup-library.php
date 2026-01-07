<?php
// setup-library.php - One-time setup script to initialize the vocabulary library
// Run this script once to add the is_library column and import sample data

$pdo = require 'db.php';

echo "Setting up vocabulary library...\n\n";

try {
    // Add is_library column if it doesn't exist
    echo "1. Adding is_library column...\n";
    try {
        $pdo->exec("ALTER TABLE `Sets` ADD COLUMN `is_library` TINYINT(1) DEFAULT 0");
        echo "   ✓ Column added successfully\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "   ✓ Column already exists\n";
        } else {
            throw $e;
        }
    }
    
    // Add index if it doesn't exist
    echo "2. Adding index...\n";
    try {
        $pdo->exec("CREATE INDEX idx_is_library ON `Sets`(is_library)");
        echo "   ✓ Index created successfully\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key') !== false) {
            echo "   ✓ Index already exists\n";
        } else {
            throw $e;
        }
    }
    
    // Import sample vocabulary data
    echo "3. Importing sample vocabulary data...\n";
    $jsonFile = __DIR__ . '/library-vocabulary.json';
    
    if (!file_exists($jsonFile)) {
        echo "   ⚠ Sample data file not found: $jsonFile\n";
        echo "   You can import sets later using import-library-sets.php\n";
    } else {
        $json = file_get_contents($jsonFile);
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['sets'])) {
            echo "   ⚠ Invalid JSON format in sample data file\n";
        } else {
            $imported = 0;
            $skipped = 0;
            
            foreach ($data['sets'] as $set) {
                $setName = trim($set['name'] ?? '');
                $level = trim($set['level'] ?? '');
                $words = $set['words'] ?? [];
                
                if (empty($setName) || empty($words)) {
                    $skipped++;
                    continue;
                }
                
                $fullName = $setName . ($level ? " - " . $level : "");
                
                // Check if set already exists
                $checkStmt = $pdo->prepare("SELECT set_id FROM `Sets` WHERE name = ? AND is_library = 1 LIMIT 1");
                $checkStmt->execute([$fullName]);
                if ($checkStmt->fetch()) {
                    $skipped++;
                    continue;
                }
                
                try {
                    $stmt = $pdo->prepare(
                        "INSERT INTO Sets (set_id, user_id, name, word, translation, is_library) 
                         VALUES (:set_id, :user_id, :name, :word, :translation, 1)"
                    );
                    
                    $firstWordInserted = false;
                    $setId = null;
                    $firstWordId = null;
                    
                    foreach ($words as $wordData) {
                        $word = trim($wordData['word'] ?? '');
                        $translation = trim($wordData['translation'] ?? '');
                        
                        if ($word !== '' && $translation !== '') {
                            if (!$firstWordInserted) {
                                $stmt->execute([
                                    'set_id' => 0,
                                    'user_id' => 0,
                                    'name' => $fullName,
                                    'word' => $word,
                                    'translation' => $translation,
                                ]);
                                $firstWordId = $pdo->lastInsertId();
                                $setId = $firstWordId;
                                $firstWordInserted = true;
                            } else {
                                $stmt->execute([
                                    'set_id' => $setId,
                                    'user_id' => 0,
                                    'name' => $fullName,
                                    'word' => $word,
                                    'translation' => $translation,
                                ]);
                            }
                        }
                    }
                    
                    if ($setId && $firstWordId) {
                        $updateStmt = $pdo->prepare("UPDATE Sets SET set_id = ? WHERE id = ?");
                        $updateStmt->execute([$setId, $firstWordId]);
                        $imported++;
                    }
                } catch (PDOException $e) {
                    echo "   ⚠ Error importing '$setName': " . $e->getMessage() . "\n";
                }
            }
            
            echo "   ✓ Imported $imported set(s)\n";
            if ($skipped > 0) {
                echo "   ⚠ Skipped $skipped set(s) (already exist)\n";
            }
        }
    }
    
    echo "\n✓ Library setup complete!\n";
    echo "\nNext steps:\n";
    echo "1. Visit library.php to see available sets\n";
    echo "2. Users can click 'Add to My Sets' to copy sets to their collection\n";
    echo "3. Import more sets using import-library-sets.php\n";
    
} catch (PDOException $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>

