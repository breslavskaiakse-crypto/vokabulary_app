<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Set with AI - Vocabluary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background-color: #e6d9f2;
        }
        h1 {
            color: #6b4c93;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .container {
            width: 100%;
            max-width: 600px;
        }
        .input-section {
            margin-bottom: 30px;
        }
        .input-section label {
            display: block;
            color: #6b4c93;
            font-size: 1.3em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .input-section input,
        .input-section select {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            background-color: white;
            color: #333;
            box-sizing: border-box;
        }
        .input-section input:focus,
        .input-section select:focus {
            outline: none;
            border-color: #6b4c93;
        }
        .input-section input[type="number"] {
            -moz-appearance: textfield;
        }
        .input-section input[type="number"]::-webkit-outer-spin-button,
        .input-section input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .create-button {
            padding: 20px 50px;
            font-size: 1.5em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .create-button:hover:not(:disabled) {
            background-color: #8a6fa5;
        }
        .create-button:active:not(:disabled) {
            transform: scale(0.98);
        }
        .create-button:disabled {
            background-color: #c4b5d4;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
            z-index: 1000;
        }
        .home-button:hover {
            background-color: #8a6fa5;
        }
        .home-button:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <button class="home-button" onclick="window.location.href='index.php'" title="Home">🏠</button>
<h1>New Set with AI</h1>
<div class="container">
    <div class="input-section">
        <label for="topic">My Topic</label>
        <input type="text" id="topic" placeholder="Enter your topic" oninput="checkForm()">
    </div>
    
    <div class="input-section">
        <label for="wordCount">How Many Words</label>
        <input type="number" id="wordCount" placeholder="Enter number of words" min="1" oninput="checkForm()">
    </div>
    
    <div class="input-section">
        <label for="level">My Level</label>
        <select id="level" onchange="checkForm()">
            <option value="">Select your level</option>
            <option value="beginner">Beginner (A1) - I'm just starting</option>
            <option value="elementary">Elementary (A2) - I know basic words</option>
            <option value="pre-intermediate">Pre-Intermediate (B1) - I can have simple conversations</option>
            <option value="intermediate">Intermediate (B2) - I can discuss various topics</option>
            <option value="advanced">Advanced (C1) - I'm fluent but want to improve</option>
            <option value="proficient">Proficient (C2) - Near-native level</option>
        </select>
    </div>
    
    <div class="input-section">
        <label for="termsLanguage">Terms Language</label>
        <select id="termsLanguage" onchange="checkForm()">
            <option value="">Select terms language</option>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Italian">Italian</option>
            <option value="Portuguese">Portuguese</option>
            <option value="Russian">Russian</option>
            <option value="Chinese">Chinese</option>
            <option value="Japanese">Japanese</option>
            <option value="Korean">Korean</option>
            <option value="Arabic">Arabic</option>
            <option value="Dutch">Dutch</option>
            <option value="Polish">Polish</option>
            <option value="Turkish">Turkish</option>
            <option value="Swedish">Swedish</option>
            <option value="Norwegian">Norwegian</option>
            <option value="Danish">Danish</option>
            <option value="Finnish">Finnish</option>
            <option value="Greek">Greek</option>
            <option value="Hebrew">Hebrew</option>
        </select>
    </div>
    
    <div class="input-section">
        <label for="translationLanguage">Translation Language</label>
        <select id="translationLanguage" onchange="checkForm()">
            <option value="">Select translation language</option>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Italian">Italian</option>
            <option value="Portuguese">Portuguese</option>
            <option value="Russian">Russian</option>
            <option value="Chinese">Chinese</option>
            <option value="Japanese">Japanese</option>
            <option value="Korean">Korean</option>
            <option value="Arabic">Arabic</option>
            <option value="Dutch">Dutch</option>
            <option value="Polish">Polish</option>
            <option value="Turkish">Turkish</option>
            <option value="Swedish">Swedish</option>
            <option value="Norwegian">Norwegian</option>
            <option value="Danish">Danish</option>
            <option value="Finnish">Finnish</option>
            <option value="Greek">Greek</option>
            <option value="Hebrew">Hebrew</option>
        </select>
    </div>
    
    <div style="margin-top: 10px; margin-bottom: 20px; padding: 10px; background-color: #f5f5f5; border-radius: 6px; color: #6b4c93; font-size: 0.9em;">
        <strong>💡 Tip:</strong> If you choose the same language for words and translations, AI will suggest explanations of the word in the same language instead of translations.
    </div>
    
    <button class="create-button" id="createButton" onclick="createSet()" disabled>Create</button>
</div>

<script>
    function checkForm() {
        const topic = document.getElementById('topic').value.trim();
        const wordCount = document.getElementById('wordCount').value.trim();
        const level = document.getElementById('level').value;
        const termsLanguage = document.getElementById('termsLanguage').value;
        const translationLanguage = document.getElementById('translationLanguage').value;
        const createButton = document.getElementById('createButton');
        
        // Enable button only if all fields are filled
        if (topic.length > 0 && wordCount.length > 0 && parseInt(wordCount) > 0 && level.length > 0 && termsLanguage.length > 0 && translationLanguage.length > 0) {
            createButton.disabled = false;
        } else {
            createButton.disabled = true;
        }
    }
    
    function createSet() {
        const topic = document.getElementById('topic').value.trim();
        const wordCount = document.getElementById('wordCount').value.trim();
        const level = document.getElementById('level').value;
        const termsLanguage = document.getElementById('termsLanguage').value;
        const translationLanguage = document.getElementById('translationLanguage').value;
        
        // Disable button and show loading
        const createButton = document.getElementById('createButton');
        createButton.disabled = true;
        const originalText = createButton.textContent;
        createButton.textContent = 'Creating...';
        
        // Send request to PHP backend
        const formData = new FormData();
        formData.append('topic', topic);
        formData.append('wordCount', wordCount);
        formData.append('level', level);
        formData.append('termsLanguage', termsLanguage);
        formData.append('translationLanguage', translationLanguage);
        
        fetch('generateAISet.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to edit-set page to review and save the generated set
                window.location.href = 'edit-set.php?new=1';
            } else {
                alert('Error: ' + (data.error || 'Failed to create set. Please try again.'));
                createButton.disabled = false;
                createButton.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please check your connection and try again.');
            createButton.disabled = false;
            createButton.textContent = originalText;
        });
    }
</script>
</body>
</html>

