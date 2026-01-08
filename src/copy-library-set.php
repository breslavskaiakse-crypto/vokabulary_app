<?php
// copy-library-set.php - Copy a library set to user's collection
$pdo = require 'db.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['error' => 'Please log in']);
    exit;
}

$setId = isset($_GET['set_id']) ? intval($_GET['set_id']) : 0;
if (!$setId) {
    echo json_encode(['error' => 'Set ID is required']);
    exit;
}

try {
    // Get library set
    $stmt = $pdo->prepare("SELECT name, word, translation FROM `Sets` WHERE set_id = ? AND is_library = 1");
    $stmt->execute([$setId]);
    $words = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($words)) {
        echo json_encode(['error' => 'Library set not found']);
        exit;
    }
    
    $setName = $words[0]['name'];
    
    // Check if user already has this set
    $checkStmt = $pdo->prepare("SELECT set_id FROM `Sets` WHERE name = ? AND user_id = ? AND is_library = 0 LIMIT 1");
    $checkStmt->execute([$setName, $userId]);
    $existingSet = $checkStmt->fetch();
    
    if ($existingSet) {
        // User already has this set, append a number
        $counter = 1;
        $newName = $setName . " (" . $counter . ")";
        while (true) {
            $checkStmt->execute([$newName, $userId]);
            if (!$checkStmt->fetch()) {
                break;
            }
            $counter++;
            $newName = $setName . " (" . $counter . ")";
        }
        $setName = $newName;
    }
    
    // Copy to user's sets
    $insertStmt = $pdo->prepare(
        "INSERT INTO Sets (set_id, user_id, name, word, translation, is_library) 
         VALUES (:set_id, :user_id, :name, :word, :translation, 0)"
    );
    
    $firstWordInserted = false;
    $newSetId = null;
    $firstWordId = null;
    
    foreach ($words as $row) {
        if (!$firstWordInserted) {
            $insertStmt->execute([
                'set_id' => 0,
                'user_id' => $userId,
                'name' => $setName,
                'word' => $row['word'],
                'translation' => $row['translation'],
            ]);
            $firstWordId = $pdo->lastInsertId();
            $newSetId = $firstWordId;
            $firstWordInserted = true;
        } else {
            $insertStmt->execute([
                'set_id' => $newSetId,
                'user_id' => $userId,
                'name' => $setName,
                'word' => $row['word'],
                'translation' => $row['translation'],
            ]);
        }
    }
    
    if ($newSetId && $firstWordId) {
        $updateStmt = $pdo->prepare("UPDATE Sets SET set_id = ? WHERE id = ?");
        $updateStmt->execute([$newSetId, $firstWordId]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Set added to your collection']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>

