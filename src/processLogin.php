<?php
$pdo = require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        header('Location: login?error=All fields are required');
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: login?error=Please enter a valid email address');
        exit;
    }

    try {
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT id, Password FROM Users WHERE Email = ?");
        $checkStmt->execute([$email]);
        $existingUser = $checkStmt->fetch();

        if ($existingUser) {
            // User exists, verify password
            if (password_verify($password, $existingUser['Password'])) {
                // Password correct, log in
                $_SESSION['user_id'] = $existingUser['id'];
                header('Location: index?success=Welcome back!');
                exit;
            } else {
                // Password incorrect
                header('Location: login?error=Incorrect password');
                exit;
            }
        } else {
            // New user, register them
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO Users (Name, Email, Password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);

            // Log in the new user
            $_SESSION['user_id'] = $pdo->lastInsertId();

            header('Location: index?success=Welcome! You have been registered successfully.');
            exit;
        }

    } catch (PDOException $e) {
        print_r($e);
        die();
        header('Location: login?error=An error occurred. Please try again.');
        exit;
    }
} else {
    header('Location: login');
    exit;
}
?>

