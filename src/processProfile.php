<?php
session_start();
header('Content-Type: application/json');
$pdo = require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $field = $_POST['field'] ?? '';
    
    // Verify user is logged in and matches the user_id
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $userId) {
        echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
        exit;
    }
    
    try {
        if ($field === 'name') {
            $name = trim($_POST['name'] ?? '');
            if (empty($name)) {
                echo json_encode(['success' => false, 'error' => 'Name cannot be empty']);
                exit;
            }
            
            $stmt = $pdo->prepare("UPDATE Users SET Name = ? WHERE id = ?");
            $stmt->execute([$name, $userId]);
            echo json_encode(['success' => true, 'message' => 'Name updated successfully']);
            
        } elseif ($field === 'email') {
            $email = trim($_POST['email'] ?? '');
            if (empty($email)) {
                echo json_encode(['success' => false, 'error' => 'Email cannot be empty']);
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'error' => 'Invalid email format']);
                exit;
            }
            
            // Check if email is already taken by another user
            $checkStmt = $pdo->prepare("SELECT id FROM Users WHERE Email = ? AND id != ?");
            $checkStmt->execute([$email, $userId]);
            if ($checkStmt->fetch()) {
                echo json_encode(['success' => false, 'error' => 'This email is already taken']);
                exit;
            }
            
            $stmt = $pdo->prepare("UPDATE Users SET Email = ? WHERE id = ?");
            $stmt->execute([$email, $userId]);
            echo json_encode(['success' => true, 'message' => 'Email updated successfully']);
            
        } elseif ($field === 'password') {
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            
            if (empty($oldPassword) || empty($newPassword)) {
                echo json_encode(['success' => false, 'error' => 'Both old and new passwords are required']);
                exit;
            }
            
            // Get current password hash
            $stmt = $pdo->prepare("SELECT Password FROM Users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if (!$user) {
                echo json_encode(['success' => false, 'error' => 'User not found']);
                exit;
            }
            
            // Verify old password
            if (!password_verify($oldPassword, $user['Password'])) {
                echo json_encode(['success' => false, 'error' => 'Old password is incorrect']);
                exit;
            }
            
            // Hash and update new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE Users SET Password = ? WHERE id = ?");
            $updateStmt->execute([$hashedPassword, $userId]);
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid field']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>

