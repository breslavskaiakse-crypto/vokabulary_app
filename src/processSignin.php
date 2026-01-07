<?php
session_start();
$pdo = require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        header('Location: signin.php?error=Email and password are required');
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: signin.php?error=Please enter a valid email address');
        exit;
    }
    
    try {
        // Check if email exists in database
        $stmt = $pdo->prepare("SELECT id, Password FROM Users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // Email not found in database
            header('Location: signin.php?error=Email not found. Please create an account first.');
            exit;
        }
        
        // Verify password
        if (!password_verify($password, $user['Password'])) {
            // Password is incorrect
            header('Location: signin.php?error=Incorrect password');
            exit;
        }
        
        // Email exists and password is correct - log user in
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php?success=Welcome back!');
        exit;
        
    } catch (PDOException $e) {
        header('Location: signin.php?error=An error occurred. Please try again.');
        exit;
    }
} else {
    header('Location: signin.php');
    exit;
}
?>

