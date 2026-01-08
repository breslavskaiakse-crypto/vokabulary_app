<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn for a Test - Vocabluary app:)</title>
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
        h1 {
            color: #6b4c93;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .card-container {
            width: 100%;
            max-width: 600px;
            margin-bottom: 30px;
        }
        .test-card {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        .translation-text {
            font-size: 2.5em;
            color: #6b4c93;
            text-align: center;
            margin-bottom: 30px;
            word-wrap: break-word;
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
        .input-section input {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            background-color: white;
            color: #333;
            box-sizing: border-box;
        }
        .input-section input:focus {
            outline: none;
            border-color: #6b4c93;
        }
        .input-section input:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .feedback-message {
            text-align: center;
            font-size: 1.8em;
            color: #4CAF50;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .correct-answer {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .correct-answer-label {
            color: #6b4c93;
            font-size: 1.2em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .correct-answer-text {
            font-size: 1.5em;
            color: #333;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .copy-text {
            color: #6b4c93;
            font-size: 1.1em;
            margin-bottom: 15px;
            font-style: italic;
        }
        .skip-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .skip-button:hover {
            background-color: #8a6fa5;
        }
        .correct-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 10px;
        }
        .correct-button:hover {
            background-color: #45a049;
        }
        .multiple-choice-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .choice-button {
            padding: 20px;
            font-size: 1.3em;
            background-color: #9b7fb8;
            color: white;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            word-wrap: break-word;
        }
        .choice-button:hover {
            background-color: #8a6fa5;
            transform: scale(1.02);
        }
        .choice-button:active {
            transform: scale(0.98);
        }
        .choice-button.correct {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .choice-button.incorrect {
            background-color: #f44336;
            border-color: #f44336;
        }
        .choice-button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }
        .word-text {
            font-size: 2.5em;
            color: #6b4c93;
            text-align: center;
            margin-bottom: 30px;
            word-wrap: break-word;
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
        .congratulations-emoji:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .congratulations-emoji:nth-child(2) { top: 20%; right: 15%; animation-delay: 0.5s; }
        .congratulations-emoji:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 1s; }
        .congratulations-emoji:nth-child(4) { bottom: 15%; right: 10%; animation-delay: 1.5s; }
        .congratulations-emoji:nth-child(5) { top: 50%; left: 5%; animation-delay: 2s; }
        .congratulations-emoji:nth-child(6) { top: 60%; right: 5%; animation-delay: 2.5s; }
        .congratulations-emoji:nth-child(7) { bottom: 50%; left: 50%; animation-delay: 0.3s; }
        .congratulations-emoji:nth-child(8) { top: 30%; left: 50%; animation-delay: 1.2s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
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
            <div class="setting-group">
                <label class="setting-label">Type of Questions:</label>
                <div class="setting-option">
                    <label>
                        <input type="radio" name="questionType" value="both" checked>
                        Both (Multiple Choice & Writing)
                    </label>
                </div>
                <div class="setting-option">
                    <label>
                        <input type="radio" name="questionType" value="multiple">
                        Multiple Choice Only
                    </label>
                </div>
                <div class="setting-option">
                    <label>
                        <input type="radio" name="questionType" value="writing">
                        Writing Only
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
    let wordStatus = []; // Array tracking status for each word: 'type1', 'type2', or 'learned'
    let showFeedback = false;
    let isCorrect = false;
    let currentWord = null;
    let lastUserAnswer = '';
    let multipleChoiceOptions = [];
    let selectedAnswer = null;
    let settings = {
        firstSide: 'word', // 'word' or 'translation'
        cardOrder: 'set', // 'set' or 'random'
        questionType: 'both' // 'both', 'multiple', or 'writing'
    };
    let originalOrder = []; // Store original order for random mode
    
    // Load settings from localStorage
    function loadSettings() {
        const savedSettings = localStorage.getItem('learnForTestSettings');
        if (savedSettings) {
            settings = JSON.parse(savedSettings);
        }
        updateSettingsModal();
    }
    
    // Save settings to localStorage
    function saveSettingsToStorage() {
        localStorage.setItem('learnForTestSettings', JSON.stringify(settings));
    }
    
    // Update modal to show current settings
    function updateSettingsModal() {
        const firstSideRadio = document.querySelector(`input[name="firstSide"][value="${settings.firstSide}"]`);
        const cardOrderRadio = document.querySelector(`input[name="cardOrder"][value="${settings.cardOrder}"]`);
        const questionTypeRadio = document.querySelector(`input[name="questionType"][value="${settings.questionType}"]`);
        if (firstSideRadio) firstSideRadio.checked = true;
        if (cardOrderRadio) cardOrderRadio.checked = true;
        if (questionTypeRadio) questionTypeRadio.checked = true;
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
        const questionType = document.querySelector('input[name="questionType"]:checked').value;
        
        const settingsChanged = settings.firstSide !== firstSide || 
                               settings.cardOrder !== cardOrder || 
                               settings.questionType !== questionType;
        
        settings.firstSide = firstSide;
        settings.cardOrder = cardOrder;
        settings.questionType = questionType;
        saveSettingsToStorage();
        
        closeSettings();
        
        // Apply settings changes
        if (settingsChanged) {
            // If order changed, reorder words
            if (settings.cardOrder === 'random') {
                applyRandomOrder();
            } else {
                restoreOriginalOrder();
            }
            
            // If question type changed, update word statuses
            updateWordStatusesForQuestionType();
            
            // Redisplay current card
            if (allWords.length > 0) {
                displayCard();
            }
        }
    }
    
    // Apply random order
    function applyRandomOrder() {
        if (originalOrder.length === 0) {
            originalOrder = allWords.map((w, i) => ({ word: w, originalIndex: i, status: wordStatus[i] }));
        }
        
        // Create shuffled indices
        const indices = Array.from({ length: allWords.length }, (_, i) => i);
        shuffleArray(indices);
        
        // Reorder words and statuses
        const shuffledWords = indices.map(i => allWords[i]);
        const shuffledStatuses = indices.map(i => wordStatus[i]);
        
        allWords = shuffledWords;
        wordStatus = shuffledStatuses;
    }
    
    // Restore original order
    function restoreOriginalOrder() {
        if (originalOrder.length > 0) {
            // Sort by original index
            originalOrder.sort((a, b) => a.originalIndex - b.originalIndex);
            allWords = originalOrder.map(item => item.word);
            wordStatus = originalOrder.map(item => item.status);
            originalOrder = [];
        }
    }
    
    // Update word statuses based on question type setting
    function updateWordStatusesForQuestionType() {
        if (settings.questionType === 'multiple') {
            // Only multiple choice - mark all as type1, remove type2
            wordStatus = wordStatus.map(status => status === 'type2' ? 'type1' : status);
        } else if (settings.questionType === 'writing') {
            // Only writing - mark all as type2, remove type1
            wordStatus = wordStatus.map(status => status === 'type1' ? 'type2' : status);
        }
        // 'both' - keep current statuses
    }
    
    // Shuffle array (Fisher-Yates algorithm)
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
    
    // Helper function to get current word status
    function getCurrentWordStatus() {
        if (currentIndex >= allWords.length) {
            currentIndex = 0; // Loop back
        }
        return wordStatus[currentIndex];
    }
    
    // Helper function to get words that need questions
    function getWordsNeedingQuestions() {
        return wordStatus.filter(status => status !== 'learned').length;
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
                // Initialize all words based on question type setting
                if (settings.questionType === 'writing') {
                    wordStatus = allWords.map(() => 'type2');
                } else {
                    wordStatus = allWords.map(() => 'type1');
                }
                originalOrder = [];
                
                // Apply card order setting
                if (settings.cardOrder === 'random') {
                    applyRandomOrder();
                }
                
                currentIndex = 0;
                showFeedback = false;
                displayCard();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('content').innerHTML = 
                    '<div class="no-set-message">Error loading set. Please try again.</div>';
            });
    }

    function displayCard() {
        // Check if all words are fully learned
        if (getWordsNeedingQuestions() === 0) {
            showCongratulations();
            return;
        }

        // Find next word that needs a question
        let attempts = 0;
        while (attempts < allWords.length) {
            if (currentIndex >= allWords.length) {
                currentIndex = 0;
                // If random order, reshuffle when looping
                if (settings.cardOrder === 'random') {
                    applyRandomOrder();
                }
            }
            
            if (wordStatus[currentIndex] !== 'learned') {
                break;
            }
            currentIndex++;
            attempts++;
        }

        currentWord = allWords[currentIndex];
        let status = wordStatus[currentIndex];
        
        // Determine question type based on settings and word status
        if (settings.questionType === 'multiple') {
            // Only multiple choice - convert type2 to type1
            if (status === 'type2') status = 'type1';
        } else if (settings.questionType === 'writing') {
            // Only writing - convert type1 to type2
            if (status === 'type1') status = 'type2';
        }
        // 'both' - use current status
        
        const totalWords = getWordsNeedingQuestions();
        const cardNumber = currentIndex + 1;

        if (showFeedback) {
            if (status === 'type1') {
                displayType1Feedback(cardNumber, totalWords);
            } else if (status === 'type2') {
                displayType2Feedback(cardNumber, totalWords);
            }
        } else {
            if (status === 'type1') {
                displayType1Question(cardNumber, totalWords);
            } else if (status === 'type2') {
                displayType2Question(cardNumber, totalWords);
            }
        }
    }

    async function displayType1Question(cardNumber, totalWords) {
        // Generate multiple choice options based on firstSide setting
        await generateMultipleChoiceOptions();
        
        // Determine which side to show based on settings
        const frontText = settings.firstSide === 'word' ? currentWord.word : currentWord.translation;
        const correctAnswer = settings.firstSide === 'word' ? currentWord.translation : currentWord.word;
        
        const content = document.getElementById('content');
        content.innerHTML = `
            <h1>Learn for a Test</h1>
            <div class="card-counter">Question ${cardNumber} of ${allWords.length} (Multiple Choice)</div>
            <div class="card-container">
                <div class="test-card">
                    <div class="word-text">${escapeHtml(frontText)}</div>
                    <div class="multiple-choice-container" id="choicesContainer">
                        ${multipleChoiceOptions.map((option, index) => `
                            <button class="choice-button" onclick="selectAnswer(${index}, '${escapeHtml(correctAnswer)}')">
                                ${escapeHtml(option)}
                            </button>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
    }

    function displayType1Feedback(cardNumber, totalWords) {
        const frontText = settings.firstSide === 'word' ? currentWord.word : currentWord.translation;
        const correctAnswer = settings.firstSide === 'word' ? currentWord.translation : currentWord.word;
        
        const content = document.getElementById('content');
        const buttons = multipleChoiceOptions.map((option, index) => {
            let buttonClass = 'choice-button';
            if (index === selectedAnswer) {
                buttonClass += isCorrect ? ' correct' : ' incorrect';
            } else if (option === correctAnswer) {
                buttonClass += ' correct';
            }
            
            return `
                <button class="${buttonClass}" disabled>
                    ${escapeHtml(option)}
                </button>
            `;
        }).join('');
        
        content.innerHTML = `
            <h1>Learn for a Test</h1>
            <div class="card-counter">Question ${cardNumber} of ${allWords.length} (Multiple Choice)</div>
            <div class="card-container">
                <div class="test-card">
                    <div class="word-text">${escapeHtml(frontText)}</div>
                    <div class="multiple-choice-container">
                        ${buttons}
                    </div>
                    ${isCorrect ? '<div class="feedback-message">Very good!</div>' : ''}
                </div>
            </div>
        `;
        
        setTimeout(() => {
            if (isCorrect) {
                // Mark word as needing Type 2 (if question type is 'both')
                if (settings.questionType === 'both') {
                    wordStatus[currentIndex] = 'type2';
                } else {
                    // If only multiple choice, mark as learned
                    wordStatus[currentIndex] = 'learned';
                }
            }
            
            // Move to next word
            currentIndex++;
            showFeedback = false;
            displayCard();
        }, isCorrect ? 1500 : 2000);
    }

    function displayType2Question(cardNumber, totalWords) {
        // Determine which side to show based on settings
        const frontText = settings.firstSide === 'word' ? currentWord.word : currentWord.translation;
        const expectedAnswer = settings.firstSide === 'word' ? currentWord.translation : currentWord.word;
        const answerLabel = settings.firstSide === 'word' ? 'Write the translation:' : 'Write the word:';
        
        const content = document.getElementById('content');
        content.innerHTML = `
            <h1>Learn for a Test</h1>
            <div class="card-counter">Question ${cardNumber} of ${allWords.length} (Writing)</div>
            <div class="card-container">
                <div class="test-card">
                    <div class="translation-text">${escapeHtml(frontText)}</div>
                    <div class="input-section">
                        <label for="userAnswer">${answerLabel}</label>
                        <input type="text" id="userAnswer" placeholder="Enter your answer" onkeypress="handleKeyPress(event)" autofocus>
                    </div>
                </div>
            </div>
        `;
    }

    function displayType2Feedback(cardNumber, totalWords) {
        const frontText = settings.firstSide === 'word' ? currentWord.word : currentWord.translation;
        const expectedAnswer = settings.firstSide === 'word' ? currentWord.translation : currentWord.word;
        const answerLabel = settings.firstSide === 'word' ? 'Write the translation:' : 'Write the word:';
        
        if (isCorrect) {
            // Show "very good!" message and auto-advance
            const content = document.getElementById('content');
            content.innerHTML = `
                <h1>Learn for a Test</h1>
                <div class="card-counter">Question ${cardNumber} of ${allWords.length} (Writing)</div>
                <div class="card-container">
                    <div class="test-card">
                        <div class="translation-text">${escapeHtml(frontText)}</div>
                        <div class="input-section">
                            <label for="userAnswer">${answerLabel}</label>
                            <input type="text" id="userAnswer" value="${escapeHtml(lastUserAnswer)}" disabled>
                        </div>
                        <div class="feedback-message">Very good!</div>
                    </div>
                </div>
            `;
            setTimeout(() => {
                // Mark word as fully learned
                wordStatus[currentIndex] = 'learned';
                
                // Move to next word
                currentIndex++;
                showFeedback = false;
                displayCard();
            }, 1500);
        } else {
            // Show correct answer with text instruction, skip button, and "I answered correctly" button
            const content = document.getElementById('content');
            content.innerHTML = `
                <h1>Learn for a Test</h1>
                <div class="card-counter">Question ${cardNumber} of ${allWords.length} (Writing)</div>
                <div class="card-container">
                    <div class="test-card">
                        <div class="translation-text">${escapeHtml(frontText)}</div>
                        <div class="input-section">
                            <label for="userAnswer">${answerLabel}</label>
                            <input type="text" id="userAnswer" value="${escapeHtml(lastUserAnswer)}" oninput="checkCorrectAnswer()" autofocus>
                        </div>
                        <div class="correct-answer">
                            <div class="correct-answer-label">Correct answer:</div>
                            <div class="correct-answer-text" id="correctAnswer">${escapeHtml(expectedAnswer)}</div>
                            <div class="copy-text">Copy the correct answer</div>
                            <div style="display: flex; gap: 10px; justify-content: center;">
                                <button class="skip-button" onclick="skipToNext()">Skip</button>
                                <button class="correct-button" onclick="markAsCorrect()">I answered correctly</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            setTimeout(() => {
                const input = document.getElementById('userAnswer');
                if (input) {
                    input.focus();
                    input.select();
                }
            }, 100);
        }
    }
    
    function markAsCorrect() {
        // Mark word as fully learned (treat as correct answer)
        wordStatus[currentIndex] = 'learned';
        
        // Move to next word in set order
        currentIndex++;
        showFeedback = false;
        displayCard();
    }

    async function generateMultipleChoiceOptions() {
        // Determine which side is shown and which side should be options
        const showWord = settings.firstSide === 'word';
        const correctAnswer = showWord ? currentWord.translation : currentWord.word;
        const wrongAnswers = [];
        const otherWords = allWords.filter(w => w.word !== currentWord.word);
        
        // Get wrong answers from other words (up to 3)
        for (let i = 0; i < Math.min(3, otherWords.length); i++) {
            wrongAnswers.push(showWord ? otherWords[i].translation : otherWords[i].word);
        }
        
        // If we need more wrong answers, generate them with AI
        const needed = 4 - wrongAnswers.length - 1; // -1 for correct answer
        if (needed > 0) {
            try {
                const wordForAI = showWord ? currentWord.word : currentWord.translation;
                const correctForAI = showWord ? currentWord.translation : currentWord.word;
                const response = await fetch(`getWrongAnswers.php?word=${encodeURIComponent(wordForAI)}&correctTranslation=${encodeURIComponent(correctForAI)}&language=English&count=${needed}`);
                const data = await response.json();
                if (data.wrongAnswers && Array.isArray(data.wrongAnswers)) {
                    // Filter out any wrong answers that are already in our list
                    const newAnswers = data.wrongAnswers.filter(ans => 
                        !wrongAnswers.some(existing => existing.toLowerCase() === ans.toLowerCase())
                    );
                    wrongAnswers.push(...newAnswers.slice(0, needed));
                } else if (data.error) {
                    console.error('AI API error:', data.error);
                }
            } catch (error) {
                console.error('Error generating wrong answers:', error);
            }
        }
        
        // Combine correct answer with wrong answers and shuffle
        multipleChoiceOptions = [correctAnswer, ...wrongAnswers];
        shuffleArray(multipleChoiceOptions);
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    function selectAnswer(index, correctAnswer) {
        selectedAnswer = index;
        const selectedOption = multipleChoiceOptions[index];
        // Compare without HTML entities
        isCorrect = selectedOption === correctAnswer || 
                   decodeHtml(selectedOption).trim().toLowerCase() === decodeHtml(correctAnswer).trim().toLowerCase();
        
        showFeedback = true;
        displayCard();
    }
    
    function decodeHtml(html) {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }


    function handleKeyPress(event) {
        if (event.key === 'Enter' && !showFeedback) {
            checkAnswer();
        }
    }

    function checkAnswer() {
        // This is for Type 2 (writing) questions
        const input = document.getElementById('userAnswer');
        lastUserAnswer = input ? input.value.trim() : '';
        const expectedAnswer = settings.firstSide === 'word' ? currentWord.translation.trim() : currentWord.word.trim();
        
        isCorrect = lastUserAnswer.toLowerCase() === expectedAnswer.toLowerCase();
        
        showFeedback = true;
        displayCard();
    }

    function checkCorrectAnswer() {
        // This is for Type 2 (writing) questions when showing correct answer
        const input = document.getElementById('userAnswer');
        if (!input) return;
        
        const userAnswer = input.value.trim();
        const expectedAnswer = settings.firstSide === 'word' ? currentWord.translation.trim() : currentWord.word.trim();
        
        // If user typed the correct answer, mark as fully learned and move to next
        if (userAnswer.toLowerCase() === expectedAnswer.toLowerCase()) {
            // Mark word as fully learned
            wordStatus[currentIndex] = 'learned';
            
            // Move to next word
            currentIndex++;
            showFeedback = false;
            displayCard();
        }
    }

    function skipToNext() {
        // Move to next word in set order (word stays in type2 status since it wasn't answered correctly)
        currentIndex++;
        showFeedback = false;
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
        // Reset to start over based on question type setting
        if (settings.questionType === 'writing') {
            wordStatus = allWords.map(() => 'type2');
        } else {
            wordStatus = allWords.map(() => 'type1');
        }
        originalOrder = [];
        
        // Apply card order setting
        if (settings.cardOrder === 'random') {
            applyRandomOrder();
        }
        
        currentIndex = 0;
        showFeedback = false;
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

