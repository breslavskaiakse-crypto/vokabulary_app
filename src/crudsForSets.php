<?php
session_start();
$pdo = require 'db.php';

// Get user ID from session
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: signin.php?error=Please log in to manage your sets');
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['deleteSet']) && !isset($_POST['updateSet'])) {

    $name = trim($_POST['setName'] ?? '');
    
    // Get all words from the form
    $words = [];
    if (isset($_POST['words']) && is_array($_POST['words'])) {
        foreach ($_POST['words'] as $wordData) {
            if (isset($wordData['word']) && isset($wordData['translation'])) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                if ($word !== '' && $translation !== '') {
                    $words[] = [
                        'word' => $word,
                        'translation' => $translation
                    ];
                }
            }
        }
    }

    if ($name === '') {
        header('Location: create-myself.php?error=Set name is required');
        exit;
    }
    
    if (empty($words)) {
        header('Location: create-myself.php?error=At least one word is required');
        exit;
    }

    try {
        // Insert first word with temporary set_id (0), then get its auto-increment ID
        // Use that ID as the set_id for all words in the set
        // This ensures each set gets a unique ID that fits within INT limits
        $stmt = $pdo->prepare(
            "INSERT INTO Sets (set_id, user_id, name, word, translation) VALUES (:set_id, :user_id, :name, :word, :translation)"
        );
        
        $firstWordInserted = false;
        $setId = null;
        $firstWordId = null;
        
        foreach ($words as $wordData) {
            if (isset($wordData['word']) && isset($wordData['translation'])) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                
                if ($word !== '' && $translation !== '') {
                    if (!$firstWordInserted) {
                        // Insert first word with temporary set_id = 0, then get its ID
                        $stmt->execute([
                            'set_id' => 0, // Temporary value
                            'user_id' => $userId,
                            'name' => $name,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                        $firstWordId = $pdo->lastInsertId();
                        $setId = $firstWordId; // Use the auto-increment ID as set_id
                        $firstWordInserted = true;
                    } else {
                        // Insert remaining words with the set_id from first word
                        $stmt->execute([
                            'set_id' => $setId,
                            'user_id' => $userId,
                            'name' => $name,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                    }
                }
            }
        }
        
        // Update the first word's set_id to match its own ID
        if ($setId !== null && $firstWordId !== null) {
            $updateStmt = $pdo->prepare("UPDATE Sets SET set_id = ? WHERE id = ?");
            $updateStmt->execute([$setId, $firstWordId]);
        }
        
        if ($firstWordInserted) {
            header('Location: my-sets.php?success=' . urlencode('Set saved successfully!'));
        } else {
            header('Location: my-sets.php?error=' . urlencode('No valid words to save'));
        }
        exit;
    } catch (PDOException $e) {
        die("Error saving set: " . $e->getMessage());
    }


}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteSet'])) {
    $setId = $_POST['setId'] ?? '';

    if ($setId) {
        // Verify that the set belongs to the current user before deleting
        $checkStmt = $pdo->prepare("SELECT user_id FROM Sets WHERE set_id = ? LIMIT 1");
        $checkStmt->execute([$setId]);
        $setOwner = $checkStmt->fetch();
        
        if (!$setOwner || $setOwner['user_id'] != $userId) {
            header('Location: my-sets.php?error=' . urlencode('You do not have permission to delete this set'));
            exit;
        }
        
        // Delete all words for this set by set_id and user_id (security: only delete user's own sets)
        $sstmt = $pdo->prepare("DELETE FROM Sets WHERE set_id = :set_id AND user_id = :user_id");
        $sstmt->execute(['set_id' => $setId, 'user_id' => $userId]);
        
        header('Location: my-sets.php?success=' . urlencode('Set deleted successfully!'));
        exit;
    } else {
        header('Location: my-sets.php?error=' . urlencode('Set ID is required'));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateSet'])) {
    $setId = isset($_POST['setId']) ? intval($_POST['setId']) : 0;
    $isNewSet = isset($_POST['isNewSet']) && $_POST['isNewSet'] == '1';
    $name = trim($_POST['setName'] ?? '');
    
    // Get all words from the form
    $words = [];
    if (isset($_POST['words']) && is_array($_POST['words'])) {
        foreach ($_POST['words'] as $wordData) {
            if (isset($wordData['word']) && isset($wordData['translation'])) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                if ($word !== '' && $translation !== '') {
                    $words[] = [
                        'word' => $word,
                        'translation' => $translation
                    ];
                }
            }
        }
    }
    
    if ($name === '') {
        $redirectUrl = $isNewSet ? 'edit-set.php?new=1' : 'edit-set.php?set_id=' . $setId;
        header('Location: ' . $redirectUrl . '&error=' . urlencode('Set name is required'));
        exit;
    }
    
    if (empty($words)) {
        $redirectUrl = $isNewSet ? 'edit-set.php?new=1' : 'edit-set.php?set_id=' . $setId;
        header('Location: ' . $redirectUrl . '&error=' . urlencode('At least one word is required'));
        exit;
    }
    
    try {
        if ($isNewSet || $setId === 0) {
            // Creating a new set (from AI or manually)
            // Clear session data
            unset($_SESSION['ai_generated_set']);
            
            // Insert first word with temporary set_id (0), then get its auto-increment ID
            $stmt = $pdo->prepare(
                "INSERT INTO Sets (set_id, user_id, name, word, translation) VALUES (:set_id, :user_id, :name, :word, :translation)"
            );
            
            $firstWordInserted = false;
            $newSetId = null;
            $firstWordId = null;
            
            foreach ($words as $wordData) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                
                if ($word !== '' && $translation !== '') {
                    if (!$firstWordInserted) {
                        $stmt->execute([
                            'set_id' => 0,
                            'user_id' => $userId,
                            'name' => $name,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                        $firstWordId = $pdo->lastInsertId();
                        $newSetId = $firstWordId;
                        $firstWordInserted = true;
                    } else {
                        $stmt->execute([
                            'set_id' => $newSetId,
                            'user_id' => $userId,
                            'name' => $name,
                            'word' => $word,
                            'translation' => $translation,
                        ]);
                    }
                }
            }
            
            // Update first word's set_id
            if ($newSetId !== null && $firstWordId !== null) {
                $updateStmt = $pdo->prepare("UPDATE Sets SET set_id = ? WHERE id = ?");
                $updateStmt->execute([$newSetId, $firstWordId]);
            }
            
            if ($firstWordInserted) {
                header('Location: my-sets.php?success=' . urlencode('Set saved successfully!'));
            } else {
                header('Location: edit-set.php?new=1&error=' . urlencode('Failed to save words to database'));
            }
            exit;
        } else {
            // Updating existing set
            // Verify that the set belongs to the current user
            $checkStmt = $pdo->prepare("SELECT user_id FROM Sets WHERE set_id = ? LIMIT 1");
            $checkStmt->execute([$setId]);
            $setOwner = $checkStmt->fetch();
            
            if (!$setOwner || $setOwner['user_id'] != $userId) {
                header('Location: my-sets.php?error=' . urlencode('You do not have permission to edit this set'));
                exit;
            }
            
            // Delete all existing words for this set
            $deleteStmt = $pdo->prepare("DELETE FROM Sets WHERE set_id = ? AND user_id = ?");
            $deleteStmt->execute([$setId, $userId]);
            
            // Insert new words with the same set_id
            $stmt = $pdo->prepare(
                "INSERT INTO Sets (set_id, user_id, name, word, translation) VALUES (:set_id, :user_id, :name, :word, :translation)"
            );
            
            foreach ($words as $wordData) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                
                if ($word !== '' && $translation !== '') {
                    $stmt->execute([
                        'set_id' => $setId,
                        'user_id' => $userId,
                        'name' => $name,
                        'word' => $word,
                        'translation' => $translation,
                    ]);
                }
            }
            
            header('Location: my-sets.php?success=' . urlencode('Set updated successfully!'));
            exit;
        }
    } catch (PDOException $e) {
        $redirectUrl = $isNewSet ? 'edit-set.php?new=1' : 'edit-set.php?set_id=' . $setId;
        header('Location: ' . $redirectUrl . '&error=' . urlencode('Error saving set: ' . $e->getMessage()));
        exit;
    }
}