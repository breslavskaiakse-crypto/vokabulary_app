<?php
$pdo = require 'db.php';


$statement = $pdo->prepare("select * from Users");
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$data = $users;
?>

<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<div>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Buttons actions</th>
        </tr>

        <?php foreach ($data as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['Name'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($user['Email'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($user['Password'] ?? '') ?></td>
                <td>
                    <form method="post" action="deleteUser.php">
                        <button value="<?php echo $user['id'] ?>" name="deleteUserid">delete</button>
                    </form>

                </td>
            </tr>

        <?php } ?>
    </table>


</div>
</body>
</html>
