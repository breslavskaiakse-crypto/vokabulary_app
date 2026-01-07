<?php
session_start();
header('Content-Type: application/json');
$pdo = require 'db.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['error' => 'Please log in to access sets']);
    exit;
}

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    echo json_encode(['error' => 'Set ID is required']);
    exit;
}

// Get the word entry and verify it belongs to the current user
$sstmt = $pdo->prepare("SELECT * FROM Sets WHERE id = :id AND user_id = :user_id");
$sstmt->execute(['id' => $id, 'user_id' => $userId]);
$rows = $sstmt->fetch(PDO::FETCH_ASSOC);

if (!$rows) {
    echo json_encode(['error' => 'Set not found or you do not have access to this set']);
    exit;
}

echo json_encode($rows);