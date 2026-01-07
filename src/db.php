<?php
return new PDO(
    "mysql:host=mysql;dbname=mydatabase;charset=utf8mb4",
    "myuser",
    "mypassword",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);