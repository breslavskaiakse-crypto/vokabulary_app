<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabulary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #e6d9f2;
        }
        h1 {
            color: #6b4c93;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        button {
            padding: 25px 50px;
            font-size: 1.8em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        button:hover {
            background-color: #8a6fa5;
        }
        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
<h1>Vocabulary app:)</h1>
<div class="button-container">
    <button onclick="window.location.href='my-sets.php'">My Sets</button>
    <button onclick="window.location.href='create-set.php'">Create a New Set</button>
    <button onclick="window.location.href='profile.php'">My Profile</button>
</div>
</body>
</html>