<?php
$pdo = require 'db.php';

try {
    // Use backticks around table name and query() method like my-sets.php
    $stmt = $pdo->query("SELECT * FROM `Sets`");
    $rows = $stmt->fetchAll();
    
    if (count($rows) === 0) {
        $data = [];
        $message = "No sets found in the database.";
    } else {
        $data = $rows;
        $message = "";
    }
} catch (PDOException $e) {
    echo "❌ Connection failed : " . $e->getMessage();
    $data = [];
    $message = "Error loading sets: " . $e->getMessage();
}
?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #e6d9f2;
        }
        h1 {
            color: #6b4c93;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 12px;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        th {
            background-color: #9b7fb8;
            color: white;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            color: #856404;
        }
    </style>
</head>
<body>
    <h1>All Sets</h1>
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Set ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Word</th>
                <th>Translation</th>
            </tr>
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $set): ?>
                    <tr>
                        <td><?php echo $set['id'] ?? 'N/A' ?></td>
                        <td><?php echo isset($set['set_id']) ? $set['set_id'] : 'N/A (column not added yet)' ?></td>
                        <td><?php echo isset($set['user_id']) ? $set['user_id'] : 'N/A (column not added yet)' ?></td>
                        <td><?php echo htmlspecialchars($set['name'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($set['word'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($set['translation'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        No sets found in the database.
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>