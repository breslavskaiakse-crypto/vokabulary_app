<?php
// library.php - Display ready-made vocabulary sets from the library
$pdo = require 'db.php';

// Check if is_library column exists, if not, create it
try {
    $pdo->exec("ALTER TABLE `Sets` ADD COLUMN `is_library` TINYINT(1) DEFAULT 0");
    $pdo->exec("CREATE INDEX idx_is_library ON `Sets`(is_library)");
} catch (PDOException $e) {
    // Column might already exist, that's okay
}

try {
    // Get all library sets (is_library = 1)
    $stmt = $pdo->prepare("SELECT DISTINCT set_id, name FROM `Sets` WHERE is_library = 1 ORDER BY name");
    $stmt->execute();
    $sets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $data = [];
    foreach ($sets as $setRow) {
        $setId = $setRow['set_id'];
        $name = $setRow['name'];
        
        // Get word count
        $wordsStmt = $pdo->prepare("SELECT COUNT(*) as count FROM `Sets` WHERE set_id = ? AND is_library = 1");
        $wordsStmt->execute([$setId]);
        $wordCount = $wordsStmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        $data[] = [
            'id' => $setId,
            'name' => $name,
            'word_count' => $wordCount
        ];
    }
} catch (PDOException $e) {
    $data = [];
    $error = "Error loading library: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabulary Library - Vocabluary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background-color: #e6d9f2;
        }
        h1 {
            color: #6b4c93;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .container {
            width: 100%;
            max-width: 800px;
        }
        .set-card {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .set-name {
            color: #6b4c93;
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .set-info {
            color: #666;
            font-size: 1em;
            margin-bottom: 20px;
        }
        .add-button {
            padding: 15px 30px;
            font-size: 1.3em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .add-button:hover {
            background-color: #8a6fa5;
        }
        .add-button:active {
            transform: scale(0.98);
        }
        .add-button:disabled {
            background-color: #c4b5d4;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
            z-index: 1000;
        }
        .home-button:hover {
            background-color: #8a6fa5;
        }
        .home-button:active {
            transform: scale(0.95);
        }
        .no-sets {
            text-align: center;
            color: #6b4c93;
            font-size: 1.5em;
            padding: 40px;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
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
    <button class="home-button" onclick="window.location.href='/'" title="Home">🏠</button>
    <h1>Vocabulary Library</h1>
    <div class="container">
        <?php if (isset($_GET['success'])): ?>
            <div class="message success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="message error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if (empty($data)): ?>
            <div class="no-sets">
                No library sets available yet.<br>
                <small style="font-size: 0.8em; color: #999;">
                    Import sets using import-library-sets.php
                </small>
            </div>
        <?php else: ?>
            <?php foreach ($data as $set): ?>
                <div class="set-card">
                    <div class="set-name"><?php echo htmlspecialchars($set['name']); ?></div>
                    <div class="set-info"><?php echo $set['word_count']; ?> word<?php echo $set['word_count'] !== 1 ? 's' : ''; ?></div>
                    <button class="add-button" onclick="addToMySets(<?php echo $set['id']; ?>)">
                        Add to My Sets
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script>
        function addToMySets(setId) {
            const button = event.target;
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Adding...';
            
            fetch('copy-library-set?set_id=' + setId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'my-sets?success=' + encodeURIComponent('Set added to your collection!');
                } else {
                    alert('Error: ' + (data.error || 'Failed to add set'));
                    button.disabled = false;
                    button.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                button.disabled = false;
                button.textContent = originalText;
            });
        }
    </script>
</body>
</html>
