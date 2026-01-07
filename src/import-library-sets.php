<?php
// import-library-sets.php - Import vocabulary sets from public datasets into the library
// This script can import from JSON or CSV files

session_start();
$pdo = require 'db.php';

// Check if is_library column exists, if not, create it
try {
    $pdo->exec("ALTER TABLE `Sets` ADD COLUMN `is_library` TINYINT(1) DEFAULT 0");
    $pdo->exec("CREATE INDEX idx_is_library ON `Sets`(is_library)");
} catch (PDOException $e) {
    // Column might already exist, that's okay
}

function importFromJSON($jsonFile) {
    global $pdo;
    
    if (!file_exists($jsonFile)) {
        return ['error' => 'File not found: ' . $jsonFile];
    }
    
    $json = file_get_contents($jsonFile);
    $data = json_decode($json, true);
    
    if (!$data || !isset($data['sets'])) {
        return ['error' => 'Invalid JSON format. Expected {"sets": [...]}'];
    }
    
    $imported = 0;
    $errors = [];
    
    foreach ($data['sets'] as $index => $set) {
        $setName = trim($set['name'] ?? '');
        $level = trim($set['level'] ?? '');
        $topic = trim($set['topic'] ?? '');
        $words = $set['words'] ?? [];
        
        if (empty($setName) || empty($words) || !is_array($words)) {
            $errors[] = "Set #" . ($index + 1) . ": Missing name or words";
            continue;
        }
        
        // Create full set name
        $fullName = $setName;
        if ($level) {
            $fullName .= " - " . $level;
        }
        
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO Sets (set_id, user_id, name, word, translation, is_library) 
                 VALUES (:set_id, :user_id, :name, :word, :translation, 1)"
            );
            
            $firstWordInserted = false;
            $setId = null;
            $firstWordId = null;
            $validWords = 0;
            
            foreach ($words as $wordData) {
                $word = trim($wordData['word'] ?? '');
                $translation = trim($wordData['translation'] ?? '');
                
                if ($word !== '' && $translation !== '') {
                    if (!$firstWordInserted) {
                        $stmt->execute([
                            'set_id' => 0,
                            'user_id' => 0, // Library sets have user_id = 0
                            'name' => $fullName,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                        $firstWordId = $pdo->lastInsertId();
                        $setId = $firstWordId;
                        $firstWordInserted = true;
                        $validWords++;
                    } else {
                        $stmt->execute([
                            'set_id' => $setId,
                            'user_id' => 0,
                            'name' => $fullName,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                        $validWords++;
                    }
                }
            }
            
            if ($setId && $firstWordId && $validWords > 0) {
                $updateStmt = $pdo->prepare("UPDATE Sets SET set_id = ? WHERE id = ?");
                $updateStmt->execute([$setId, $firstWordId]);
                $imported++;
            } else {
                $errors[] = "Set '$setName': No valid words to import";
            }
        } catch (PDOException $e) {
            $errors[] = "Set '$setName': " . $e->getMessage();
        }
    }
    
    return [
        'success' => true, 
        'imported' => $imported,
        'errors' => $errors
    ];
}

function importFromCSV($csvFile) {
    global $pdo;
    
    if (!file_exists($csvFile)) {
        return ['error' => 'File not found: ' . $csvFile];
    }
    
    $handle = fopen($csvFile, 'r');
    if (!$handle) {
        return ['error' => 'Could not open file: ' . $csvFile];
    }
    
    // Expected CSV format: Set Name, Level, Word, Translation
    // First line is header
    $header = fgetcsv($handle);
    
    $sets = [];
    $currentSet = null;
    
    while (($row = fgetcsv($handle)) !== false) {
        if (count($row) < 4) continue;
        
        $setName = trim($row[0]);
        $level = trim($row[1]);
        $word = trim($row[2]);
        $translation = trim($row[3]);
        
        if (empty($setName) || empty($word) || empty($translation)) continue;
        
        $fullName = $setName . ($level ? " - " . $level : "");
        
        if (!isset($sets[$fullName])) {
            $sets[$fullName] = [];
        }
        
        $sets[$fullName][] = [
            'word' => $word,
            'translation' => $translation
        ];
    }
    
    fclose($handle);
    
    // Convert to JSON format and import
    $jsonData = ['sets' => []];
    foreach ($sets as $name => $words) {
        $parts = explode(' - ', $name);
        $jsonData['sets'][] = [
            'name' => $parts[0],
            'level' => isset($parts[1]) ? $parts[1] : '',
            'words' => $words
        ];
    }
    
    // Save to temp JSON and import
    $tempFile = sys_get_temp_dir() . '/temp_import_' . time() . '.json';
    file_put_contents($tempFile, json_encode($jsonData));
    $result = importFromJSON($tempFile);
    unlink($tempFile);
    
    return $result;
}

// Handle file upload or file path
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileType = $_POST['file_type'] ?? 'json';
    $filePath = $_POST['file_path'] ?? '';
    
    if (isset($_FILES['vocab_file']) && $_FILES['vocab_file']['error'] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['vocab_file']['tmp_name'];
        $fileType = strtolower(pathinfo($_FILES['vocab_file']['name'], PATHINFO_EXTENSION));
        
        if ($fileType === 'json') {
            $result = importFromJSON($uploadedFile);
        } elseif ($fileType === 'csv') {
            $result = importFromCSV($uploadedFile);
        } else {
            $result = ['error' => 'Unsupported file type. Use JSON or CSV.'];
        }
    } elseif ($filePath && file_exists($filePath)) {
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($fileType === 'json') {
            $result = importFromJSON($filePath);
        } elseif ($fileType === 'csv') {
            $result = importFromCSV($filePath);
        } else {
            $result = ['error' => 'Unsupported file type. Use JSON or CSV.'];
        }
    } else {
        $result = ['error' => 'No file provided'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

// Display import form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Library Sets - Vocabluary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #e6d9f2;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #6b4c93;
            font-weight: bold;
        }
        input[type="file"], input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #9b7fb8;
            border-radius: 5px;
        }
        button {
            padding: 15px 30px;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
        }
        button:hover {
            background-color: #8a6fa5;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Import Vocabulary Library Sets</h1>
    <form method="POST" enctype="multipart/form-data" id="importForm">
        <div class="form-group">
            <label>Upload JSON or CSV file:</label>
            <input type="file" name="vocab_file" accept=".json,.csv" required>
        </div>
        <button type="submit">Import Sets</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        document.getElementById('importForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = 'Importing...';
            
            try {
                const response = await fetch('import-library-sets.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                if (result.error) {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = 'Error: ' + result.error;
                } else {
                    resultDiv.className = 'result success';
                    let html = `Successfully imported ${result.imported} set(s)!`;
                    if (result.errors && result.errors.length > 0) {
                        html += '<br><br>Errors:<br>' + result.errors.join('<br>');
                    }
                    resultDiv.innerHTML = html;
                }
            } catch (error) {
                resultDiv.className = 'result error';
                resultDiv.innerHTML = 'Error: ' + error.message;
            }
        });
    </script>
</body>
</html>

