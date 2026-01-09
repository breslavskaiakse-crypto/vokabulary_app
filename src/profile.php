<?php
$pdo = require 'db/db.php';

// Get user ID from session (we'll need to set this during login)
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    // If no user is logged in, redirect to login
    header('Location: login?error=Please log in to view your profile');
    exit;
}

// Fetch user data
$stmt = $pdo->prepare("SELECT id, Name, Email, Password FROM Users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: login?error=User not found');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Vocabulary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background-color: #e6d9f2;
        }
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #9b7fb8;
            color: white;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #8a6fa5;
        }
        h1 {
            color: #6b4c93;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .profile-container {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            min-width: 500px;
            max-width: 600px;
        }
        .profile-item {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e6d9f2;
        }
        .profile-item:last-child {
            border-bottom: none;
        }
        .profile-label {
            color: #6b4c93;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
        .profile-value {
            color: #333;
            font-size: 1.1em;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .profile-value input {
            flex: 1;
            padding: 10px;
            font-size: 1em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            margin-right: 10px;
        }
        .edit-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button:hover {
            background-color: #8a6fa5;
        }
        .save-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 10px;
        }
        .cancel-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 10px;
        }
        .old-password-section {
            margin-top: 10px;
            padding: 15px;
            background-color: #fff3cd;
            border-radius: 8px;
            border: 2px solid #ffc107;
            width: 100%;
            box-sizing: border-box;
        }
        .old-password-section label {
            display: block;
            color: #856404;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .old-password-section input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 2px solid #ffc107;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .error-message {
            color: #f44336;
            background-color: #ffebee;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success-message {
            color: #4CAF50;
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class="home-button" onclick="window.location.href='/'" title="Home">🏠</button>
    
    <h1>My Profile</h1>
    
    <div class="profile-container">
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
        
        <form method="POST" action="processProfile" id="profileForm">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            
            <!-- Name Field -->
            <div class="profile-item">
                <label class="profile-label">Name</label>
                <div class="profile-value" id="nameDisplay">
                    <span id="nameValue"><?php echo htmlspecialchars($user['Name']); ?></span>
                    <button type="button" class="edit-button" onclick="editField('name')">Edit</button>
                </div>
                <div class="profile-value" id="nameEdit" style="display: none; flex-direction: column; align-items: stretch;">
                    <input type="text" name="name" id="nameInput" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
                    <div style="display: flex; margin-top: 10px;">
                        <button type="button" class="save-button" onclick="saveField('name')">Save</button>
                        <button type="button" class="cancel-button" onclick="cancelEdit('name')">Cancel</button>
                    </div>
                </div>
            </div>
            
            <!-- Email Field -->
            <div class="profile-item">
                <label class="profile-label">Email</label>
                <div class="profile-value" id="emailDisplay">
                    <span id="emailValue"><?php echo htmlspecialchars($user['Email']); ?></span>
                    <button type="button" class="edit-button" onclick="editField('email')">Edit</button>
                </div>
                <div class="profile-value" id="emailEdit" style="display: none; flex-direction: column; align-items: stretch;">
                    <input type="email" name="email" id="emailInput" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                    <div style="display: flex; margin-top: 10px;">
                        <button type="button" class="save-button" onclick="saveField('email')">Save</button>
                        <button type="button" class="cancel-button" onclick="cancelEdit('email')">Cancel</button>
                    </div>
                </div>
            </div>
            
            <!-- Password Field -->
            <div class="profile-item">
                <label class="profile-label">Password</label>
                <div class="profile-value" id="passwordDisplay">
                    <span id="passwordValue">••••••••</span>
                    <button type="button" class="edit-button" onclick="editField('password')">Edit</button>
                </div>
                <div class="profile-value" id="passwordEdit" style="display: none; flex-direction: column; align-items: stretch;">
                    <div class="old-password-section">
                        <label for="oldPassword">Old Password</label>
                        <input type="password" name="old_password" id="oldPasswordInput" placeholder="Enter your old password" required>
                    </div>
                    <input type="password" name="password" id="passwordInput" placeholder="Enter new password" style="margin-top: 10px;" required>
                    <div style="display: flex; margin-top: 10px;">
                        <button type="button" class="save-button" onclick="saveField('password')">Save</button>
                        <button type="button" class="cancel-button" onclick="cancelEdit('password')">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        let originalValues = {
            name: '<?php echo htmlspecialchars($user['Name'], ENT_QUOTES); ?>',
            email: '<?php echo htmlspecialchars($user['Email'], ENT_QUOTES); ?>',
            password: ''
        };
        
        function editField(field) {
            document.getElementById(field + 'Display').style.display = 'none';
            document.getElementById(field + 'Edit').style.display = 'flex';
            
            if (field === 'password') {
                document.getElementById('oldPasswordInput').focus();
            } else {
                document.getElementById(field + 'Input').focus();
            }
        }
        
        function cancelEdit(field) {
            document.getElementById(field + 'Display').style.display = 'flex';
            document.getElementById(field + 'Edit').style.display = 'none';
            
            // Reset values
            if (field === 'password') {
                document.getElementById('oldPasswordInput').value = '';
                document.getElementById('passwordInput').value = '';
            } else {
                document.getElementById(field + 'Input').value = originalValues[field];
            }
        }
        
        function saveField(field) {
            const form = document.getElementById('profileForm');
            const formData = new FormData(form);
            
            // Add field type
            formData.append('field', field);
            
            // For password, we need old password
            if (field === 'password') {
                const oldPassword = document.getElementById('oldPasswordInput').value;
                const newPassword = document.getElementById('passwordInput').value;
                
                if (!oldPassword || !newPassword) {
                    alert('Please enter both old and new password');
                    return;
                }
            }
            
            // Submit form
            fetch('processProfile', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show updated data
                    window.location.href = 'profile?success=' + encodeURIComponent(data.message);
                } else {
                    // Show error message
                    window.location.href = 'profile?error=' + encodeURIComponent(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating profile. Please try again.');
            });
        }
    </script>
</body>
</html>

