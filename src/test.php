<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Vocabluary app:)</title>
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
        .setting-option input[type="radio"],
        .setting-option input[type="checkbox"] {
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
        .multiple-choice-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        .choice-button {
            padding: 15px 20px;
            font-size: 1.2em;
            background-color: #f5f5f5;
            color: #333;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: left;
        }
        .choice-button:hover {
            background-color: #e6d9f2;
            border-color: #6b4c93;
        }
        .true-false-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .true-false-button {
            padding: 20px 50px;
            font-size: 1.5em;
            background-color: #f5f5f5;
            color: #333;
            border: 3px solid #9b7fb8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 150px;
        }
        .true-false-button:hover {
            background-color: #e6d9f2;
            border-color: #6b4c93;
            transform: scale(1.05);
        }
        .word-text {
            font-size: 2.5em;
            color: #6b4c93;
            text-align: center;
            margin-bottom: 20px;
            word-wrap: break-word;
        }
        .translation-pair {
            text-align: center;
            margin-bottom: 30px;
        }
        .next-button {
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
            display: block;
            margin: 0 auto;
        }
        .next-button:hover {
            background-color: #8a6fa5;
        }
        .next-button:active {
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
        .result-item {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .result-item.correct {
            border-left: 5px solid #4CAF50;
        }
        .result-item.incorrect {
            border-left: 5px solid #f44336;
        }
        .result-word {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 10px;
        }
        .result-translation {
            font-size: 1.1em;
            color: #666;
        }
        .result-user-answer {
            font-size: 1.1em;
            color: #f44336;
            margin-top: 5px;
            font-style: italic;
        }
        .result-stats {
            text-align: center;
            color: #6b4c93;
            font-size: 2em;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .result-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            margin-top: 30px;
        }
        .result-button {
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
        }
        .result-button:hover {
            background-color: #8a6fa5;
        }
        .result-button:active {
            transform: scale(0.98);
        }
        .result-page {
            position: relative;
            width: 100%;
        }
        .result-emoji {
            position: fixed;
            font-size: 3em;
            animation: float 3s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }
        .result-emoji:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .result-emoji:nth-child(2) { top: 20%; right: 15%; animation-delay: 0.5s; }
        .result-emoji:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 1s; }
        .result-emoji:nth-child(4) { bottom: 15%; right: 10%; animation-delay: 1.5s; }
        .result-emoji:nth-child(5) { top: 50%; left: 5%; animation-delay: 2s; }
        .result-emoji:nth-child(6) { top: 60%; right: 5%; animation-delay: 2.5s; }
        .result-emoji:nth-child(7) { bottom: 50%; left: 50%; animation-delay: 0.3s; }
        .result-emoji:nth-child(8) { top: 30%; left: 50%; animation-delay: 1.2s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        
        .support-message {
            text-align: center;
            color: #6b4c93;
            font-size: 2em;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }
        .result-content {
            position: relative;
            z-index: 2;
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
                <label class="setting-label">Question Types:</label>
                <div class="setting-option">
                    <label>
                        <input type="checkbox" name="questionTypes" value="multiple" checked>
                        Multiple Choice
                    </label>
                </div>
                <div class="setting-option">
                    <label>
                        <input type="checkbox" name="questionTypes" value="writing" checked>
                        Writing
                    </label>
                </div>
                <div class="setting-option">
                    <label>
                        <input type="checkbox" name="questionTypes" value="truefalse" checked>
                        True/False
                    </label>
                </div>
            </div>
            <button class="modal-save-button" onclick="saveSettings()">Save Settings</button>
        </div>
    </div>

<script>
    let currentSet = null;
    let currentIndex = 0;
    let words = [];
    let userAnswers = [];
    let questionTypes = []; // Array to store question type for each word: 'multiple', 'writing', 'truefalse'
    let trueFalseData = []; // Store true/false question data (isCorrect, shownTranslation)
    let settings = {
        firstSide: 'word', // 'word' or 'translation'
        cardOrder: 'set', // 'set' or 'random'
        questionTypes: ['multiple', 'writing', 'truefalse'] // Array of enabled question types
    };
    let originalWords = []; // Store original word order for random mode

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

                words = currentSet.words;
                originalWords = [...words];
                userAnswers = [];
                trueFalseData = [];
                
                // Randomly assign question type for each word (only from enabled types)
                questionTypes = words.map(() => {
                    const enabledTypes = settings.questionTypes;
                    if (enabledTypes.length === 0) {
                        // Fallback if no types selected
                        return 'multiple';
                    }
                    const rand = Math.random();
                    const index = Math.floor(rand * enabledTypes.length);
                    return enabledTypes[index];
                });
                
                // Prepare true/false questions first (before shuffling)
                prepareTrueFalseQuestions().then(() => {
                    // Apply card order setting after preparing true/false data
                    if (settings.cardOrder === 'random') {
                        // Create array of indices to shuffle
                        const indices = words.map((_, i) => i);
                        shuffleArray(indices);
                        
                        // Reorder words, questionTypes, and trueFalseData together
                        words = indices.map(i => words[i]);
                        questionTypes = indices.map(i => questionTypes[i]);
                        // Reorder trueFalseData - need to map old indices to new positions
                        const newTrueFalseData = [];
                        indices.forEach((oldIndex, newIndex) => {
                            newTrueFalseData[newIndex] = trueFalseData[oldIndex];
                        });
                        trueFalseData = newTrueFalseData;
                    }
                    
                    currentIndex = 0;
                    displayCard();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('content').innerHTML = 
                    '<div class="no-set-message">Error loading set. Please try again.</div>';
            });
    }
    
    async function prepareTrueFalseQuestions() {
        const promises = [];
        
        for (let i = 0; i < words.length; i++) {
            if (questionTypes[i] === 'truefalse') {
                const word = words[i];
                const isCorrect = Math.random() < 0.5; // 50% chance
                
                if (isCorrect) {
                    // Use correct translation
                    trueFalseData[i] = {
                        isCorrect: true,
                        shownTranslation: word.translation
                    };
                } else {
                    // Need wrong translation
                    if (words.length > 1) {
                        // Use translation from another word
                        const otherWords = words.filter((w, idx) => idx !== i);
                        const randomOther = otherWords[Math.floor(Math.random() * otherWords.length)];
                        trueFalseData[i] = {
                            isCorrect: false,
                            shownTranslation: randomOther.translation
                        };
                    } else {
                        // Only 1 word in set, generate wrong translation with AI
                        promises.push(
                            fetch(`getWrongAnswers.php?word=${encodeURIComponent(word.word)}&correctTranslation=${encodeURIComponent(word.translation)}&language=English&count=1`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.wrongAnswers && data.wrongAnswers.length > 0) {
                                        trueFalseData[i] = {
                                            isCorrect: false,
                                            shownTranslation: data.wrongAnswers[0]
                                        };
                                    } else {
                                        // Fallback: use a dummy wrong translation
                                        trueFalseData[i] = {
                                            isCorrect: false,
                                            shownTranslation: 'Incorrect translation'
                                        };
                                    }
                                })
                                .catch(error => {
                                    console.error('Error generating wrong translation:', error);
                                    trueFalseData[i] = {
                                        isCorrect: false,
                                        shownTranslation: 'Incorrect translation'
                                    };
                                })
                        );
                    }
                }
            }
        }
        
        // Wait for all AI requests to complete
        await Promise.all(promises);
    }

    async function displayCard() {
        if (currentIndex >= words.length) {
            showResults();
            return;
        }

        const word = words[currentIndex];
        const questionType = questionTypes[currentIndex];
        const cardNumber = currentIndex + 1;
        const totalWords = words.length;
        const isLast = currentIndex === words.length - 1;

        const content = document.getElementById('content');
        let questionHTML = '';

        if (questionType === 'multiple') {
            questionHTML = await displayMultipleChoiceQuestion(word, cardNumber, totalWords);
        } else if (questionType === 'writing') {
            questionHTML = displayWritingQuestion(word, cardNumber, totalWords);
        } else if (questionType === 'truefalse') {
            questionHTML = displayTrueFalseQuestion(word, cardNumber, totalWords);
        }

        content.innerHTML = `
            <h1>Test</h1>
            <div class="card-counter">Question ${cardNumber} of ${totalWords} ${getQuestionTypeLabel(questionType)}</div>
            <div class="card-container">
                ${questionHTML}
            </div>
            ${questionType !== 'multiple' && questionType !== 'truefalse' ? `<button class="next-button" onclick="nextWord()">${isLast ? 'See My Result' : 'Next Word'}</button>` : ''}
        `;
        
        // Focus on input for writing questions
        if (questionType === 'writing') {
            setTimeout(() => {
                const input = document.getElementById('userAnswer');
                if (input) {
                    input.focus();
                }
            }, 100);
        }
    }
    
    function getQuestionTypeLabel(type) {
        if (type === 'multiple') return '(Multiple Choice)';
        if (type === 'writing') return '(Writing)';
        if (type === 'truefalse') return '(True/False)';
        return '';
    }
    
    async function displayMultipleChoiceQuestion(word, cardNumber, totalWords) {
        // Determine which side to show based on settings
        const showWord = settings.firstSide === 'word';
        const frontText = showWord ? word.word : word.translation;
        const correctAnswer = showWord ? word.translation : word.word;
        
        // Generate multiple choice options
        const wrongAnswers = [];
        const otherWords = words.filter(w => w.word !== word.word);
        
        // Get wrong answers from other words (up to 3)
        for (let i = 0; i < Math.min(3, otherWords.length); i++) {
            wrongAnswers.push(showWord ? otherWords[i].translation : otherWords[i].word);
        }
        
        // If we need more wrong answers, generate them with AI
        const needed = 4 - wrongAnswers.length - 1;
        if (needed > 0) {
            try {
                const wordForAI = showWord ? word.word : word.translation;
                const correctForAI = showWord ? word.translation : word.word;
                const response = await fetch(`getWrongAnswers.php?word=${encodeURIComponent(wordForAI)}&correctTranslation=${encodeURIComponent(correctForAI)}&language=English&count=${needed}`);
                const data = await response.json();
                if (data.wrongAnswers && Array.isArray(data.wrongAnswers)) {
                    wrongAnswers.push(...data.wrongAnswers.slice(0, needed));
                }
            } catch (error) {
                console.error('Error generating wrong answers:', error);
            }
        }
        
        // Combine correct answer with wrong answers and shuffle
        const options = [correctAnswer, ...wrongAnswers];
        shuffleArray(options);
        
        // Store options for checking answer
        window.currentMultipleChoiceOptions = options;
        window.currentCorrectAnswer = correctAnswer;
        
        const buttons = options.map((option, index) => `
            <button class="choice-button" onclick="selectMultipleChoiceAnswer(${index})">
                ${escapeHtml(option)}
            </button>
        `).join('');
        
        return `
            <div class="test-card">
                <div class="word-text">${escapeHtml(frontText)}</div>
                <div class="multiple-choice-container">
                    ${buttons}
                </div>
            </div>
        `;
    }
    
    function displayWritingQuestion(word, cardNumber, totalWords) {
        // Determine which side to show based on settings
        const showWord = settings.firstSide === 'word';
        const frontText = showWord ? word.translation : word.word;
        const expectedAnswer = showWord ? word.word : word.translation;
        const answerLabel = showWord ? 'Write the word:' : 'Write the translation:';
        
        return `
            <div class="test-card">
                <div class="translation-text">${escapeHtml(frontText)}</div>
                <div class="input-section">
                    <label for="userAnswer">${answerLabel}</label>
                    <input type="text" id="userAnswer" placeholder="Enter your answer" onkeypress="handleKeyPress(event)">
                </div>
            </div>
        `;
    }
    
    function displayTrueFalseQuestion(word, cardNumber, totalWords) {
        const trueFalseInfo = trueFalseData[currentIndex];
        const shownTranslation = trueFalseInfo ? trueFalseInfo.shownTranslation : word.translation;
        
        // Determine which side to show first based on settings
        const firstText = settings.firstSide === 'word' ? word.word : shownTranslation;
        const secondText = settings.firstSide === 'word' ? shownTranslation : word.word;
        
        return `
            <div class="test-card">
                <div class="translation-pair">
                    <div class="word-text">${escapeHtml(firstText)}</div>
                    <div class="translation-text">${escapeHtml(secondText)}</div>
                </div>
                <div class="true-false-container">
                    <button class="true-false-button" onclick="selectTrueFalseAnswer(true)">True</button>
                    <button class="true-false-button" onclick="selectTrueFalseAnswer(false)">False</button>
                </div>
            </div>
        `;
    }
    
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
    
    function selectMultipleChoiceAnswer(selectedIndex) {
        const selectedOption = window.currentMultipleChoiceOptions[selectedIndex];
        const isCorrect = selectedOption === window.currentCorrectAnswer || 
                         selectedOption.toLowerCase() === window.currentCorrectAnswer.toLowerCase();
        
        // Store the answer
        userAnswers.push({
            word: words[currentIndex].word,
            translation: words[currentIndex].translation,
            userAnswer: selectedOption,
            questionType: 'multiple',
            isCorrect: isCorrect
        });
        
        currentIndex++;
        displayCard();
    }
    
    function selectTrueFalseAnswer(userAnswer) {
        const trueFalseInfo = trueFalseData[currentIndex];
        const isCorrect = userAnswer === trueFalseInfo.isCorrect;
        
        // Store the answer
        userAnswers.push({
            word: words[currentIndex].word,
            translation: words[currentIndex].translation,
            userAnswer: userAnswer ? 'True' : 'False',
            questionType: 'truefalse',
            isCorrect: isCorrect,
            shownTranslation: trueFalseInfo.shownTranslation
        });
        
        currentIndex++;
        displayCard();
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            nextWord();
        }
    }

    function nextWord() {
        const input = document.getElementById('userAnswer');
        const userAnswer = input ? input.value.trim() : '';
        const word = words[currentIndex];
        const showWord = settings.firstSide === 'word';
        const expectedAnswer = showWord ? word.word : word.translation;
        const isCorrect = userAnswer.toLowerCase().trim() === expectedAnswer.toLowerCase().trim();
        
        // Store the answer
        userAnswers.push({
            word: word.word,
            translation: word.translation,
            userAnswer: userAnswer,
            questionType: 'writing',
            isCorrect: isCorrect
        });
        
        currentIndex++;
        displayCard();
    }

    function showResults() {
        let correctCount = 0;
        const results = [];

        userAnswers.forEach(answer => {
            if (answer.isCorrect) {
                correctCount++;
            }
            results.push(answer);
        });

        const percentage = (correctCount / words.length) * 100;
        let supportMessage = '';
        let emojis = [];

        if (percentage === 100) {
            supportMessage = 'Perfect! Outstanding work!';
            emojis = ['🎉', '🌟', '🏆', '✨', '💯', '🎊', '👏', '🥇'];
        } else if (percentage > 60) {
            supportMessage = 'Great job! You\'re doing well!';
            emojis = ['👍', '😊', '⭐', '💪', '🎯', '🙌', '👌', '💯'];
        } else if (percentage > 20) {
            supportMessage = 'Keep practicing! You\'re making progress!';
            emojis = ['📚', '💪', '🌱', '📖', '🎓', '✏️', '📝', '💡'];
        } else {
            supportMessage = 'Don\'t give up! Keep learning and you\'ll improve!';
            emojis = ['🌱', '💪', '📚', '🎯', '📖', '✏️', '💡', '🌟'];
        }

        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="result-page">
                ${emojis.map((emoji, index) => `<div class="result-emoji" style="animation-delay: ${index * 0.3}s">${emoji}</div>`).join('')}
                <div class="result-content">
                    <h1>Your Result</h1>
                    <div class="support-message">${supportMessage}</div>
                    <div class="result-stats">You got ${correctCount} out of ${words.length} words correct!</div>
                    <div class="card-container">
                        ${results.map((result, index) => {
                            const questionTypeLabel = result.questionType === 'multiple' ? 'Multiple Choice' : 
                                                      result.questionType === 'writing' ? 'Writing' : 'True/False';
                            let answerDisplay = '';
                            
                            if (result.questionType === 'multiple') {
                                answerDisplay = `Your answer: "${escapeHtml(result.userAnswer)}"`;
                            } else if (result.questionType === 'writing') {
                                answerDisplay = `Your answer: "${escapeHtml(result.userAnswer)}"`;
                            } else if (result.questionType === 'truefalse') {
                                answerDisplay = `Shown translation: "${escapeHtml(result.shownTranslation)}"<br>Your answer: ${result.userAnswer}`;
                            }
                            
                            return `
                                <div class="result-item ${result.isCorrect ? 'correct' : 'incorrect'}">
                                    <div class="result-word"><strong>${escapeHtml(result.word)}</strong> <span style="font-size: 0.8em; color: #999;">(${questionTypeLabel})</span></div>
                                    <div class="result-translation">Correct translation: ${escapeHtml(result.translation)}</div>
                                    ${!result.isCorrect ? `<div class="result-user-answer">${answerDisplay}</div>` : ''}
                                </div>
                            `;
                        }).join('')}
                    </div>
                    <div class="result-buttons">
                        <button class="result-button" onclick="window.location.href='my-sets.php'">My Sets</button>
                    </div>
                </div>
            </div>
        `;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Load settings from localStorage
    function loadSettings() {
        const savedSettings = localStorage.getItem('testSettings');
        if (savedSettings) {
            settings = JSON.parse(savedSettings);
        }
        updateSettingsModal();
    }
    
    // Save settings to localStorage
    function saveSettingsToStorage() {
        localStorage.setItem('testSettings', JSON.stringify(settings));
    }
    
    // Update modal to show current settings
    function updateSettingsModal() {
        const firstSideRadio = document.querySelector(`input[name="firstSide"][value="${settings.firstSide}"]`);
        const cardOrderRadio = document.querySelector(`input[name="cardOrder"][value="${settings.cardOrder}"]`);
        if (firstSideRadio) firstSideRadio.checked = true;
        if (cardOrderRadio) cardOrderRadio.checked = true;
        
        // Update checkboxes for question types
        document.querySelectorAll('input[name="questionTypes"]').forEach(checkbox => {
            checkbox.checked = settings.questionTypes.includes(checkbox.value);
        });
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
        const selectedTypes = Array.from(document.querySelectorAll('input[name="questionTypes"]:checked')).map(cb => cb.value);
        
        // Ensure at least one question type is selected
        if (selectedTypes.length === 0) {
            alert('Please select at least one question type.');
            return;
        }
        
        const settingsChanged = settings.firstSide !== firstSide || 
                               settings.cardOrder !== cardOrder || 
                               JSON.stringify(settings.questionTypes.sort()) !== JSON.stringify(selectedTypes.sort());
        
        settings.firstSide = firstSide;
        settings.cardOrder = cardOrder;
        settings.questionTypes = selectedTypes;
        saveSettingsToStorage();
        
        closeSettings();
        
        // If settings changed and test hasn't started, reload
        if (settingsChanged && currentIndex === 0 && userAnswers.length === 0) {
            // Reload the set with new settings
            loadSet();
        }
    }
    
    // Shuffle array (Fisher-Yates algorithm)
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    // Load settings and set when page loads
    loadSettings();
    loadSet();
</script>
</body>
</html>
