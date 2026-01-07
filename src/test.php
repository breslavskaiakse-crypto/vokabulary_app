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
    
    <div id="content">
        <div class="no-set-message">Loading...</div>
    </div>

<script>
    let currentSet = null;
    let currentIndex = 0;
    let words = [];
    let userAnswers = [];

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
                userAnswers = [];
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
        if (currentIndex >= words.length) {
            showResults();
            return;
        }

        const word = words[currentIndex];
        const cardNumber = currentIndex + 1;
        const totalWords = words.length;
        const isLast = currentIndex === words.length - 1;

        const content = document.getElementById('content');
        content.innerHTML = `
            <h1>Test</h1>
            <div class="card-counter">Question ${cardNumber} of ${totalWords}</div>
            <div class="card-container">
                <div class="test-card">
                    <div class="translation-text">${escapeHtml(word.translation)}</div>
                    <div class="input-section">
                        <label for="userAnswer">Write the word:</label>
                        <input type="text" id="userAnswer" placeholder="Enter the word" onkeypress="handleKeyPress(event)">
                    </div>
                </div>
            </div>
            <button class="next-button" onclick="nextWord()">${isLast ? 'See My Result' : 'Next Word'}</button>
        `;
        
        // Focus on input
        setTimeout(() => {
            const input = document.getElementById('userAnswer');
            if (input) {
                input.focus();
            }
        }, 100);
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            nextWord();
        }
    }

    function nextWord() {
        const input = document.getElementById('userAnswer');
        const userAnswer = input ? input.value.trim() : '';
        
        // Store the answer
        userAnswers.push({
            word: words[currentIndex].word,
            translation: words[currentIndex].translation,
            userAnswer: userAnswer
        });
        
        currentIndex++;
        displayCard();
    }

    function showResults() {
        let correctCount = 0;
        const results = [];

        userAnswers.forEach(answer => {
            const isCorrect = answer.userAnswer.toLowerCase().trim() === answer.word.toLowerCase().trim();
            if (isCorrect) {
                correctCount++;
            }
            results.push({
                ...answer,
                isCorrect: isCorrect
            });
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
                        ${results.map(result => `
                            <div class="result-item ${result.isCorrect ? 'correct' : 'incorrect'}">
                                <div class="result-word"><strong>${escapeHtml(result.word)}</strong></div>
                                <div class="result-translation">Translation: ${escapeHtml(result.translation)}</div>
                                ${!result.isCorrect ? `<div class="result-user-answer">Your answer: "${escapeHtml(result.userAnswer)}"</div>` : ''}
                            </div>
                        `).join('')}
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

    // Load set when page loads
    loadSet();
</script>
</body>
</html>
