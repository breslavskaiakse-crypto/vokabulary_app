<?php
$pdo = require 'db.php';
$id = $_POST['deleteUserid'];

$statement = $pdo->prepare('delete from Users where id = :id');
$statement->execute(['id' => $id]);

echo "✅ Data Deleted successfully!";