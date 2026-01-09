<?php
header('Content-Type: application/json');
$pdo = require 'db/db.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Set ID is required']);
    exit;
}

$setId = $_GET['id'];
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['error' => 'Please log in to access sets']);
    exit;
}

try {
    // Get set by set_id and verify it belongs to the current user
    $stmt = $pdo->prepare("SELECT DISTINCT name, set_id, user_id FROM `Sets` WHERE set_id = ? AND user_id = ? LIMIT 1");
    $stmt->execute([$setId, $userId]);
    $setData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$setData) {
        echo json_encode(['error' => 'Set not found or you do not have access to this set']);
        exit;
    }
    
    $setName = $setData['name'];
    $actualSetId = $setData['set_id'];
    
    // Get all words for this set by set_id and user_id
    $wordsStmt = $pdo->prepare("SELECT word, translation FROM `Sets` WHERE set_id = ? AND user_id = ?");
    $wordsStmt->execute([$actualSetId, $userId]);
    
    $words = $wordsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format words array
    $formattedWords = [];
    foreach ($words as $row) {
        if (!empty($row['word']) && !empty($row['translation'])) {
            $formattedWords[] = [
                'word' => $row['word'],
                'translation' => $row['translation']
            ];
        }
    }
    
    if (empty($formattedWords)) {
        echo json_encode(['error' => 'Set has no words']);
        exit;
    }
    
    echo json_encode([
        'id' => (int)$setId,
        'name' => $setName,
        'words' => $formattedWords
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

