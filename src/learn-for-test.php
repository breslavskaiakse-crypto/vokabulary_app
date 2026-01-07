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
    
    <div id="content">
        <div class="no-set-message">Loading...</div>
    </div>

<script>
    let currentSet = null;
    let currentIndex = 0;
    let allWords = [];
    let unknownWords = [];
    let showFeedback = false;
    let isCorrect = false;
    let currentWord = null;
    let lastUserAnswer = '';

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
        // Check if all words are known
        if (unknownWords.length === 0) {
            showCongratulations();
            return;
        }

        currentWord = unknownWords[currentIndex];
        const cardNumber = currentIndex + 1;
        const totalWords = unknownWords.length;

        if (showFeedback) {
            if (isCorrect) {
                // Show "very good!" message and auto-advance after 1.5 seconds
                const content = document.getElementById('content');
                content.innerHTML = `
                    <h1>Learn for a Test</h1>
                    <div class="card-counter">Question ${cardNumber} of ${totalWords}</div>
                    <div class="card-container">
                        <div class="test-card">
                            <div class="translation-text">${escapeHtml(currentWord.translation)}</div>
                            <div class="input-section">
                                <label for="userAnswer">Write the word:</label>
                                <input type="text" id="userAnswer" value="${escapeHtml(lastUserAnswer)}" disabled>
                            </div>
                            <div class="feedback-message">Very good!</div>
                        </div>
                    </div>
                `;
                setTimeout(() => {
                    // Word was already removed in checkAnswer(), just move to next
                    // Adjust index if needed
                    if (currentIndex >= unknownWords.length && unknownWords.length > 0) {
                        currentIndex = 0;
                    } else if (unknownWords.length === 0) {
                        // All words are known, will show congratulations
                        currentIndex = 0;
                    }
                    
                    showFeedback = false;
                    displayCard();
                }, 1500);
            } else {
                // Show correct answer with text instruction and skip button
                const content = document.getElementById('content');
                content.innerHTML = `
                    <h1>Learn for a Test</h1>
                    <div class="card-counter">Question ${cardNumber} of ${totalWords}</div>
                    <div class="card-container">
                        <div class="test-card">
                            <div class="translation-text">${escapeHtml(currentWord.translation)}</div>
                            <div class="input-section">
                                <label for="userAnswer">Write the word:</label>
                                <input type="text" id="userAnswer" value="${escapeHtml(lastUserAnswer)}" oninput="checkCorrectAnswer()" autofocus>
                            </div>
                            <div class="correct-answer">
                                <div class="correct-answer-label">Correct answer:</div>
                                <div class="correct-answer-text" id="correctAnswer">${escapeHtml(currentWord.word)}</div>
                                <div class="copy-text">Copy the correct answer</div>
                                <button class="skip-button" onclick="skipToNext()">Skip</button>
                            </div>
                        </div>
                    </div>
                `;
                // Focus on input after a short delay
                setTimeout(() => {
                    const input = document.getElementById('userAnswer');
                    if (input) {
                        input.focus();
                        input.select();
                    }
                }, 100);
            }
        } else {
            // Show new question
            const content = document.getElementById('content');
            content.innerHTML = `
                <h1>Learn for a Test</h1>
                <div class="card-counter">Question ${cardNumber} of ${totalWords}</div>
                <div class="card-container">
                    <div class="test-card">
                        <div class="translation-text">${escapeHtml(currentWord.translation)}</div>
                        <div class="input-section">
                            <label for="userAnswer">Write the word:</label>
                            <input type="text" id="userAnswer" placeholder="Enter the word" onkeypress="handleKeyPress(event)" autofocus>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter' && !showFeedback) {
            checkAnswer();
        }
    }

    function checkAnswer() {
        const input = document.getElementById('userAnswer');
        lastUserAnswer = input ? input.value.trim() : '';
        const correctAnswer = currentWord.word.trim();
        
        isCorrect = lastUserAnswer.toLowerCase() === correctAnswer.toLowerCase();
        
        // If correct, remove from unknown words (will be handled in displayCard feedback)
        if (isCorrect) {
            // Remove the word from unknown words
            unknownWords = unknownWords.filter((w, index) => index !== currentIndex);
            
            // Adjust index if needed
            if (currentIndex >= unknownWords.length && unknownWords.length > 0) {
                currentIndex = 0;
            } else if (unknownWords.length === 0) {
                // All words are known, will show congratulations
                currentIndex = 0;
            }
        }
        
        showFeedback = true;
        displayCard();
    }

    function checkCorrectAnswer() {
        const input = document.getElementById('userAnswer');
        if (!input) return;
        
        const userAnswer = input.value.trim();
        const correctAnswer = currentWord.word.trim();
        
        // If user typed the correct answer, remove from unknown words and move to next
        if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
            // Remove the word from unknown words since it was answered correctly
            unknownWords = unknownWords.filter((w, index) => index !== currentIndex);
            
            // Adjust index if needed
            if (currentIndex >= unknownWords.length && unknownWords.length > 0) {
                currentIndex = 0;
            } else if (unknownWords.length === 0) {
                // All words are known, will show congratulations
                currentIndex = 0;
            }
            
            showFeedback = false;
            displayCard();
        }
    }

    function skipToNext() {
        // Move to next card (word stays in unknownWords since it wasn't answered correctly)
        currentIndex++;
        
        // If it was the last card, loop back to the first
        if (currentIndex >= unknownWords.length) {
            currentIndex = 0;
        }
        
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
        // Reset unknown words to all words
        unknownWords = [...allWords];
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

    // Load set when page loads
    loadSet();
</script>
</body>
</html>

