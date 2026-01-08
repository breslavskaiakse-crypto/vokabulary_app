<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn with Cards - Vocabluary app:)</title>
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
        .settings-button {
            position: fixed;
            top: 20px;
            right: 20px;
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
        .settings-button:hover {
            background-color: #8a6fa5;
        }
        .settings-button:active {
            transform: scale(0.95);
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-content {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            position: relative;
        }
        .modal-header {
            color: #6b4c93;
            font-size: 2em;
            margin-bottom: 25px;
            text-align: center;
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 2em;
            cursor: pointer;
            color: #999;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.3s;
        }
        .modal-close:hover {
            background-color: #f0f0f0;
            color: #6b4c93;
        }
        .setting-group {
            margin-bottom: 25px;
        }
        .setting-label {
            display: block;
            color: #6b4c93;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .setting-option {
            margin-bottom: 15px;
        }
        .setting-option label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 1.1em;
            color: #333;
        }
        .setting-option input[type="radio"] {
            margin-right: 10px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .modal-save-button {
            width: 100%;
            padding: 15px;
            font-size: 1.3em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .modal-save-button:hover {
            background-color: #8a6fa5;
        }
        .card-container {
            perspective: 1000px;
            width: 100%;
            max-width: 500px;
            height: 400px;
            margin-bottom: 40px;
        }

        .card {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            cursor: pointer;
        }

        .card.flipped {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 40px;
            box-sizing: border-box;
        }

        .card-back {
            transform: rotateY(180deg);
        }

        .card-text {
            font-size: 2.5em;
            color:rgb(94, 66, 146);
            text-align: center;
            word-wrap: break-word;
        }

        .button-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            width: 100%;
            max-width: 500px;
        }

        .action-button {
            padding: 20px 40px;
            font-size: 1.3em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            flex: 1;
            min-width: 150px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-button:hover {
            background-color: #8a6fa5;
        }

        .action-button:active {
            transform: scale(0.98);
        }

        .card-counter {
            color: #6b4c93;
            font-size: 1.2em;
            margin-bottom: 20px;
            text-align: center;
        }

        .no-set-message {
            text-align: center;
            color: #6b4c93;
            font-size: 1.5em;
            padding: 40px;
        }

        .congratulations-page {
            text-align: center;
            z-index: 1;
            position: relative;
            width: 100%;
        }

        .congratulations-emoji {
            position: fixed;
            font-size: 3em;
            animation: float 3s ease-in-out infinite;
            pointer-events: none;
        }

        .congratulations-emoji:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .congratulations-emoji:nth-child(2) {
            top: 20%;
            right: 15%;
            animation-delay: 0.5s;
        }

        .congratulations-emoji:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 1s;
        }

        .congratulations-emoji:nth-child(4) {
            bottom: 15%;
            right: 10%;
            animation-delay: 1.5s;
        }

        .congratulations-emoji:nth-child(5) {
            top: 50%;
            left: 5%;
            animation-delay: 2s;
        }

        .congratulations-emoji:nth-child(6) {
            top: 60%;
            right: 5%;
            animation-delay: 2.5s;
        }

        .congratulations-emoji:nth-child(7) {
            bottom: 50%;
            left: 50%;
            animation-delay: 0.3s;
        }

        .congratulations-emoji:nth-child(8) {
            top: 30%;
            left: 50%;
            animation-delay: 1.2s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        .congratulations-title {
            color: #6b4c93;
            font-size: 2.5em;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        .congratulations-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .congratulations-button {
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

        .congratulations-button:hover {
            background-color: #8a6fa5;
        }

        .congratulations-button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
<button class="home-button" onclick="window.location.href='index.php'" title="Home">🏠</button>
<button class="settings-button" onclick="openSettings()" title="Settings">⚙️</button>

<div id="content">
    <div class="no-set-message">Loading...</div>
</div>

<!-- Settings Modal -->
<div class="modal-overlay" id="settingsModal" onclick="closeSettingsOnOverlay(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeSettings()">×</button>
        <h2 class="modal-header">Settings</h2>
        <div class="setting-group">
            <label class="setting-label">First Side of Card:</label>
            <div class="setting-option">
                <label>
                    <input type="radio" name="firstSide" value="word" checked>
                    Word (Original Language)
                </label>
            </div>
            <div class="setting-option">
                <label>
                    <input type="radio" name="firstSide" value="translation">
                    Translation
                </label>
            </div>
        </div>
        <div class="setting-group">
            <label class="setting-label">Card Order:</label>
            <div class="setting-option">
                <label>
                    <input type="radio" name="cardOrder" value="set" checked>
                    Like in Set
                </label>
            </div>
            <div class="setting-option">
                <label>
                    <input type="radio" name="cardOrder" value="random">
                    Random
                </label>
            </div>
        </div>
        <button class="modal-save-button" onclick="saveSettings()">Save Settings</button>
    </div>
</div>

<script>
    let currentSet = null;
    let currentIndex = 0;
    let allWords = [];
    let unknownWords = [];
    let settings = {
        firstSide: 'word', // 'word' or 'translation'
        cardOrder: 'set' // 'set' or 'random'
    };

    // Load settings from localStorage
    function loadSettings() {
        const savedSettings = localStorage.getItem('learnWithCardsSettings');
        if (savedSettings) {
            settings = JSON.parse(savedSettings);
        }
        // Update modal to reflect saved settings
        updateSettingsModal();
    }

    // Save settings to localStorage
    function saveSettingsToStorage() {
        localStorage.setItem('learnWithCardsSettings', JSON.stringify(settings));
    }

    // Update modal to show current settings
    function updateSettingsModal() {
        const firstSideRadio = document.querySelector(`input[name="firstSide"][value="${settings.firstSide}"]`);
        const cardOrderRadio = document.querySelector(`input[name="cardOrder"][value="${settings.cardOrder}"]`);
        if (firstSideRadio) firstSideRadio.checked = true;
        if (cardOrderRadio) cardOrderRadio.checked = true;
    }

    // Open settings modal
    function openSettings() {
        updateSettingsModal();
        document.getElementById('settingsModal').classList.add('show');
    }

    // Close settings modal
    function closeSettings() {
        document.getElementById('settingsModal').classList.remove('show');
    }

    // Close settings when clicking overlay
    function closeSettingsOnOverlay(event) {
        if (event.target.id === 'settingsModal') {
            closeSettings();
        }
    }

    // Save settings from modal
    function saveSettings() {
        const firstSide = document.querySelector('input[name="firstSide"]:checked').value;
        const cardOrder = document.querySelector('input[name="cardOrder"]:checked').value;
        
        const settingsChanged = settings.firstSide !== firstSide || settings.cardOrder !== cardOrder;
        
        settings.firstSide = firstSide;
        settings.cardOrder = cardOrder;
        saveSettingsToStorage();
        
        closeSettings();
        
        // If order changed, reshuffle words
        if (settingsChanged && settings.cardOrder === 'random' && unknownWords.length > 0) {
            shuffleArray(unknownWords);
            currentIndex = 0;
        }
        
        // Redisplay current card with new settings
        if (unknownWords.length > 0) {
            displayCard();
        }
    }

    // Shuffle array (Fisher-Yates algorithm)
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    function loadSet() {
        const setId = localStorage.getItem('currentLearningSetId');
        if (!setId) {
            document.getElementById('content').innerHTML =
                '<div class="no-set-message">No set selected. Please go back and select a set.</div>';
            return;
        }

        // Fetch set from database
        fetch(`getSetById.php?id=${setId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('content').innerHTML =
                        '<div class="no-set-message">' + data.error + '</div>';
                    return;
                }

                currentSet = data;

                if (!currentSet || !currentSet.words || currentSet.words.length === 0) {
                    document.getElementById('content').innerHTML =
                        '<div class="no-set-message">Set not found or has no words.</div>';
                    return;
                }

                allWords = currentSet.words;
                unknownWords = [...allWords]; // Start with all words
                
                // Apply card order setting
                if (settings.cardOrder === 'random') {
                    shuffleArray(unknownWords);
                }
                
                currentIndex = 0;
                displayCard();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('content').innerHTML =
                    '<div class="no-set-message">Error loading set. Please try again.</div>';
            });
    }

    function displayCard() {
        // Check if all words are known
        if (unknownWords.length === 0) {
            showCongratulations();
            return;
        }

        const word = unknownWords[currentIndex];
        const cardNumber = currentIndex + 1;
        const totalWords = unknownWords.length;

        // Determine which side should be front based on settings
        const frontText = settings.firstSide === 'word' ? word.word : word.translation;
        const backText = settings.firstSide === 'word' ? word.translation : word.word;

        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="card-counter">Card ${cardNumber} of ${totalWords}</div>
            <div class="card-container">
                <div class="card" id="flipCard" onclick="flipCard()">
                    <div class="card-front">
                        <div class="card-text">${escapeHtml(frontText)}</div>
                    </div>
                    <div class="card-back">
                        <div class="card-text">${escapeHtml(backText)}</div>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <button class="action-button" onclick="nextCard(false)">I Don't Know This Word</button>
                <button class="action-button" onclick="nextCard(true)">I Know This Word</button>
            </div>
        `;

        // Ensure card starts unflipped
        setTimeout(() => {
            const card = document.getElementById('flipCard');
            if (card) {
                card.classList.remove('flipped');
            }
        }, 10);
    }

    function flipCard() {
        const card = document.getElementById('flipCard');
        if (card) {
            card.classList.toggle('flipped');
        }
    }

    function nextCard(knowWord) {
        const currentWord = unknownWords[currentIndex];

        if (knowWord) {
            // Remove the word from unknown words
            unknownWords = unknownWords.filter((w, index) => index !== currentIndex);

            // Adjust index if needed
            if (currentIndex >= unknownWords.length && unknownWords.length > 0) {
                currentIndex = 0;
            }
        } else {
            // Move to next card
            currentIndex++;

            // If it was the last card, loop back to the first
            if (currentIndex >= unknownWords.length) {
                currentIndex = 0;
            }
        }
        
        // If random order and we're looping, reshuffle
        if (settings.cardOrder === 'random' && unknownWords.length > 1 && currentIndex === 0) {
            shuffleArray(unknownWords);
        }
 
        displayCard();
    }

    function showCongratulations() {
        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="congratulations-page">
                <div class="congratulations-emoji">🎉</div>
                <div class="congratulations-emoji">🎊</div>
                <div class="congratulations-emoji">✨</div>
                <div class="congratulations-emoji">🌟</div>
                <div class="congratulations-emoji">🎈</div>
                <div class="congratulations-emoji">🎁</div>
                <div class="congratulations-emoji">💫</div>
                <div class="congratulations-emoji">🥳</div>
                <h1 class="congratulations-title">You've studied the set "${escapeHtml(currentSet.name)}"!</h1>
                <div class="congratulations-buttons">
                    <button class="congratulations-button" onclick="learnAgain()">Learn It with Cards Again</button>
                    <button class="congratulations-button" onclick="makeTest()">Make a Test</button>
                    <button class="congratulations-button" onclick="goToMySets()">My Sets</button>
                </div>
            </div>
        `;
    }

    function learnAgain() {
        // Reset unknown words to all words
        unknownWords = [...allWords];
        
        // Apply card order setting
        if (settings.cardOrder === 'random') {
            shuffleArray(unknownWords);
        }
        
        currentIndex = 0;
        displayCard();
    }

    function makeTest() {
        // Navigate to test page (set ID is already stored)
        window.location.href = 'test.php';
    }

    function goToMySets() {
        window.location.href = 'my-sets.php';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Load settings and set when page loads
    loadSettings();
    loadSet();
</script>
</body>
</html>

