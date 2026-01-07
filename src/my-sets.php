<?php
session_start();
$pdo = require 'db.php';

// Get user ID from session
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: signin.php?error=Please log in to view your sets');
    exit;
}

try {
    // Get sets grouped by set_id for the current user only
    $stmt = $pdo->prepare("SELECT DISTINCT set_id, name FROM `Sets` WHERE user_id = ? ORDER BY set_id DESC");
    $stmt->execute([$userId]);
    $sets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $data = [];
    foreach ($sets as $setRow) {
        $setId = $setRow['set_id'];
        $name = $setRow['name'];
        
        // Get all words for this set by set_id and user_id (not by name, so same names are different sets)
        $wordsStmt = $pdo->prepare("SELECT word, translation FROM `Sets` WHERE set_id = ? AND user_id = ?");
        $wordsStmt->execute([$setId, $userId]);
        $words = $wordsStmt->fetchAll(PDO::FETCH_ASSOC);
        
        $data[] = [
            'id' => $setId,
            'name' => $name,
            'words' => $words,
            'word_count' => count($words)
        ];
    }

    if (count($data) === 0) {
        $data = [];
    }
} catch (PDOException $e) {
    echo "❌ Connection failed : " . $e->getMessage();
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sets - Vocabluary app:)</title>
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

        .button-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .set-button {
            padding: 15px 30px;
            font-size: 1.3em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex: 1;
            min-width: 150px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .set-button:hover {
            background-color: #8a6fa5;
        }

        .set-button:active {
            transform: scale(0.98);
        }

        .no-sets {
            text-align: center;
            color: #6b4c93;
            font-size: 1.5em;
            padding: 40px;
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

    </style>
</head>
<body>
<button class="home-button" onclick="window.location.href='index.php'" title="Home">🏠</button>
<h1>My Sets</h1>
<div class="container" id="setsContainer">
    <?php if (count($data) === 0): ?>
        <div class="no-sets">No sets saved yet. Create your first set!</div>
    <?php else: ?>
        <?php foreach ($data as $set): ?>
            <div class="set-card">
                <div class="set-name"><?php echo htmlspecialchars($set['name']) ?></div>
                <div class="set-info"><?php echo $set['word_count'] ?> word<?php echo $set['word_count'] !== 1 ? 's' : '' ?></div>
                <div class="button-group">
                    <button class="set-button" onclick="keepLearning(<?php echo $set['id'] ?>)">Keep Learning</button>
                    <button class="set-button" onclick="makeTest(<?php echo $set['id'] ?>)">Make a Test</button>
                </div>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <form method="POST" action="crudsForSets.php" style="margin: 0;">
                        <input type="hidden" name="setId" value="<?php echo $set['id'] ?>">
                        <button style="background:rgb(45, 15, 77); padding: 10px 20px; color: white; border: none; border-radius: 5px; cursor: pointer;" value="delete" name="deleteSet" type="submit">Delete</button>
                    </form>
                    <button style="background: rgb(74, 49, 100); padding: 10px 20px; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="window.location.href='edit-set.php?set_id=<?php echo $set['id'] ?>'">Edit</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Sets will be loaded here -->
</div>

<script>
    function keepLearning(setId) {
        // Store the selected set ID for use in learning page
        localStorage.setItem('currentLearningSetId', setId);
        window.location.href = 'learning.php';
    }
    
    function makeTest(setId) {
        // Store the selected set ID for use in test page
        localStorage.setItem('currentLearningSetId', setId);
        window.location.href = 'test.php';
    }
</script>
</body>
</html>

