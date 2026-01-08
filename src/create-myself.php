<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Set Myself - Vocabluary app:)</title>
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
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .container {
            width: 100%;
            max-width: 600px;
        }
        .set-name-section {
            margin-bottom: 30px;
        }
        .set-name-section label {
            display: block;
            color: #6b4c93;
            font-size: 1.3em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .set-name-section input {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            background-color: white;
            color: #333;
            box-sizing: border-box;
        }
        .set-name-section input:focus {
            outline: none;
            border-color: #6b4c93;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .delete-card-button {
            position: absolute;
            top: 25px;
            right: 15px;
            background-color: #4a2d5c;
            color: white;
            border: 2px solid #6b4c93;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 1.5em;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 101;
        }
        .delete-card-button:hover {
            background-color: #6b4c93;
            transform: scale(1.1);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
        }
        .card-input {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            border: 2px solid #9b7fb8;
            border-radius: 6px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .card-input:focus {
            outline: none;
            border-color: #6b4c93;
        }
        .add-button {
            width: 60px;
            height: 60px;
            font-size: 2em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
        }
        .add-button:hover {
            background-color: #8a6fa5;
        }
        .add-button:active {
            transform: scale(0.95);
        }
        .add-button:disabled {
            background-color: #c4b5d4;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .add-button:disabled:hover {
            background-color: #c4b5d4;
        }
        .save-button {
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
        .save-button:hover {
            background-color: #8a6fa5;
        }
        .save-button:active {
            transform: scale(0.98);
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
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
        .language-selection {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .language-select {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            font-size: 1em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            background-color: white;
            color: #333;
            box-sizing: border-box;
        }
        .language-select:focus {
            outline: none;
            border-color: #6b4c93;
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #9b7fb8;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 100;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .suggestion-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #e0e0e0;
            transition: background-color 0.2s;
        }
        .suggestion-item:hover {
            background-color: #f5f5f5;
        }
        .suggestion-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <button class="home-button" onclick="window.location.href='/'" title="Home">🏠</button>
    <form method="POST" action="crudsForSets" id="setForm" onsubmit="return prepareFormData(event)">
    <h1>New Set</h1>
<div class="container">
    <?php if (isset($_GET['error'])): ?>
        <div style="background-color: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    <div class="set-name-section">
        <label for="setName">Set Name</label>
        <input type="text" id="setName" name="setName" placeholder="Enter set name" required>
    </div>
    
    <div class="language-selection">
        <select class="language-select" id="wordLanguage" onchange="updateLanguageSettings()">
            <option value="English">Word Language: English</option>
            <option value="Spanish">Word Language: Spanish</option>
            <option value="French">Word Language: French</option>
            <option value="German">Word Language: German</option>
            <option value="Italian">Word Language: Italian</option>
            <option value="Portuguese">Word Language: Portuguese</option>
            <option value="Russian">Word Language: Russian</option>
            <option value="Chinese">Word Language: Chinese</option>
            <option value="Japanese">Word Language: Japanese</option>
            <option value="Korean">Word Language: Korean</option>
            <option value="Arabic">Word Language: Arabic</option>
            <option value="Dutch">Word Language: Dutch</option>
            <option value="Polish">Word Language: Polish</option>
            <option value="Turkish">Word Language: Turkish</option>
            <option value="Swedish">Word Language: Swedish</option>
            <option value="Norwegian">Word Language: Norwegian</option>
            <option value="Danish">Word Language: Danish</option>
            <option value="Finnish">Word Language: Finnish</option>
            <option value="Greek">Word Language: Greek</option>
            <option value="Hebrew">Word Language: Hebrew</option>
        </select>
        <select class="language-select" id="translationLanguage" onchange="updateLanguageSettings()">
            <option value="English">Translation Language: English</option>
            <option value="Spanish">Translation Language: Spanish</option>
            <option value="French">Translation Language: French</option>
            <option value="German">Translation Language: German</option>
            <option value="Italian">Translation Language: Italian</option>
            <option value="Portuguese">Translation Language: Portuguese</option>
            <option value="Russian">Translation Language: Russian</option>
            <option value="Chinese">Translation Language: Chinese</option>
            <option value="Japanese">Translation Language: Japanese</option>
            <option value="Korean">Translation Language: Korean</option>
            <option value="Arabic">Translation Language: Arabic</option>
            <option value="Dutch">Translation Language: Dutch</option>
            <option value="Polish">Translation Language: Polish</option>
            <option value="Turkish">Translation Language: Turkish</option>
            <option value="Swedish">Translation Language: Swedish</option>
            <option value="Norwegian">Translation Language: Norwegian</option>
            <option value="Danish">Translation Language: Danish</option>
            <option value="Finnish">Translation Language: Finnish</option>
            <option value="Greek">Translation Language: Greek</option>
            <option value="Hebrew">Translation Language: Hebrew</option>
        </select>
    </div>
    <div style="margin-top: 10px; margin-bottom: 20px; padding: 10px; background-color: #f5f5f5; border-radius: 6px; color: #6b4c93; font-size: 0.9em;">
        <strong>💡 Tip:</strong> If you choose the same language for words and translations, AI will suggest explanations of the word in the same language instead of translations.
    </div>
    
    <div id="cardsContainer">
        <div class="card" data-card-id="1">
            <button type="button" class="delete-card-button" onclick="deleteCard(1)" id="deleteButton1" style="display: none;">×</button>
            <div class="input-wrapper">
                <input type="text" class="card-input" placeholder="New word" id="word1" oninput="handleWordInput(1)" onkeydown="handleKeyDown(event, 1, 'word')" onfocus="handleWordFocus(1)" autocomplete="off">
                <div class="suggestions-dropdown" id="wordSuggestions1"></div>
            </div>
            <div class="input-wrapper">
                <input type="text" class="card-input" placeholder="Translation" id="translation1" oninput="handleTranslationInput(1)" onkeydown="handleKeyDown(event, 1, 'translation')" onfocus="handleTranslationFocus(1)" autocomplete="off">
                <div class="suggestions-dropdown" id="translationSuggestions1"></div>
            </div>
        </div>
    </div>
    
    <div class="button-container">
        <button class="add-button" id="addButton" type="button" onclick="addNewCard()" disabled>+</button>
        <button class="save-button" type="submit">Save</button>
    </div>
</div>
    </form>
<script>
    let cardCounter = 1;
    
    function deleteCard(cardId) {
        const cards = document.querySelectorAll('.card');
        // Don't allow deleting if it's the only card
        if (cards.length <= 1) {
            return;
        }
        
        const card = document.querySelector(`.card[data-card-id="${cardId}"]`);
        if (card) {
            card.remove();
            checkLastCard();
            updateDeleteButtons();
        }
    }
    
    function updateDeleteButtons() {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const cardId = card.getAttribute('data-card-id');
            const deleteButton = document.getElementById(`deleteButton${cardId}`);
            if (deleteButton) {
                // Show delete button only if there's more than one card
                deleteButton.style.display = cards.length > 1 ? 'flex' : 'none';
            }
        });
    }
    
    function checkLastCard() {
        const cards = document.querySelectorAll('.card');
        if (cards.length === 0) return;
        
        const lastCard = cards[cards.length - 1];
        const cardId = lastCard.getAttribute('data-card-id');
        const wordInput = document.getElementById(`word${cardId}`);
        const translationInput = document.getElementById(`translation${cardId}`);
        
        const addButton = document.getElementById('addButton');
        
        if (wordInput && translationInput) {
            const wordValue = wordInput.value.trim();
            const translationValue = translationInput.value.trim();
            
            // Enable button only if both fields have at least one letter
            if (wordValue.length > 0 && translationValue.length > 0) {
                addButton.disabled = false;
            } else {
                addButton.disabled = true;
            }
        }
        
        // Update delete buttons visibility
        updateDeleteButtons();
    }
    
    // Debounce timers for suggestions
    let wordTimers = {};
    let translationTimers = {};
    
    function updateLanguageSettings() {
        // Language settings updated, clear any existing suggestions
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        
        // Re-fetch translations for all cards that have words entered and translation fields focused
        // This will happen automatically when user clicks on translation field
    }
    
    function handleWordInput(cardId) {
        checkLastCard();
        
        const wordInput = document.getElementById(`word${cardId}`);
        const word = wordInput.value.trim();
        const wordLanguage = document.getElementById('wordLanguage').value;
        const wordSuggestionsDiv = document.getElementById(`wordSuggestions${cardId}`);
        
        // Hide all other suggestions first
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            if (dropdown !== wordSuggestionsDiv) {
                dropdown.style.display = 'none';
            }
        });
        
        // Clear previous timer
        if (wordTimers[cardId]) {
            clearTimeout(wordTimers[cardId]);
        }
        
        // Hide suggestions if input is too short
        if (word.length < 2) {
            wordSuggestionsDiv.style.display = 'none';
            return;
        }
        
        // Fetch word suggestions only (not translations)
        wordTimers[cardId] = setTimeout(() => {
            fetch(`getWordSuggestions?word=${encodeURIComponent(word)}&language=${encodeURIComponent(wordLanguage)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.suggestions && data.suggestions.length > 0) {
                        showSuggestions(wordSuggestionsDiv, data.suggestions, wordInput);
                    } else {
                        wordSuggestionsDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching word suggestions:', error);
                    wordSuggestionsDiv.style.display = 'none';
                });
        }, 500);
    }
    
    function handleWordFocus(cardId) {
        // Hide all other suggestions first
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        
        // Fetch word suggestions when focusing on word field
        const wordInput = document.getElementById(`word${cardId}`);
        const word = wordInput.value.trim();
        if (word.length >= 2) {
            handleWordInput(cardId);
        }
    }
    
    function handleTranslationFocus(cardId) {
        // Hide all other suggestions first
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        
        // Always fetch translation suggestions when clicking on translation field
        const wordInput = document.getElementById(`word${cardId}`);
        const word = wordInput.value.trim();
        const wordLanguage = document.getElementById('wordLanguage').value;
        const translationLanguage = document.getElementById('translationLanguage').value;
        const translationSuggestionsDiv = document.getElementById(`translationSuggestions${cardId}`);
        
        // Hide suggestions if word is empty
        if (word.length === 0) {
            translationSuggestionsDiv.style.display = 'none';
            return;
        }
        
        // Clear previous timer
        if (translationTimers[cardId]) {
            clearTimeout(translationTimers[cardId]);
        }
        
        // If languages are the same, fetch word explanations instead of translations
        if (wordLanguage === translationLanguage) {
            // Fetch word explanations using AI
            fetch(`getWordExplanations?word=${encodeURIComponent(word)}&language=${encodeURIComponent(wordLanguage)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.suggestions && data.suggestions.length > 0) {
                        const translationInput = document.getElementById(`translation${cardId}`);
                        showSuggestions(translationSuggestionsDiv, data.suggestions, translationInput);
                    } else {
                        translationSuggestionsDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching word explanations:', error);
                    translationSuggestionsDiv.style.display = 'none';
                });
        } else {
            // Fetch translations when languages are different
            fetch(`getTranslationSuggestions?word=${encodeURIComponent(word)}&source=${encodeURIComponent(wordLanguage)}&target=${encodeURIComponent(translationLanguage)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.suggestions && data.suggestions.length > 0) {
                        const translationInput = document.getElementById(`translation${cardId}`);
                        showSuggestions(translationSuggestionsDiv, data.suggestions, translationInput);
                    } else {
                        translationSuggestionsDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching translation suggestions:', error);
                    translationSuggestionsDiv.style.display = 'none';
                });
        }
    }
    
    function handleTranslationInput(cardId) {
        checkLastCard();
        
        const translationInput = document.getElementById(`translation${cardId}`);
        const wordInput = document.getElementById(`word${cardId}`);
        const word = wordInput.value.trim();
        const wordLanguage = document.getElementById('wordLanguage').value;
        const translationLanguage = document.getElementById('translationLanguage').value;
        const suggestionsDiv = document.getElementById(`translationSuggestions${cardId}`);
        
        // Hide all other suggestions first
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            if (dropdown !== suggestionsDiv) {
                dropdown.style.display = 'none';
            }
        });
        
        // Clear previous timer
        if (translationTimers[cardId]) {
            clearTimeout(translationTimers[cardId]);
        }
        
        // Hide suggestions if word is empty
        if (word.length === 0) {
            suggestionsDiv.style.display = 'none';
            return;
        }
        
        // Debounce: wait 500ms after user stops typing
        translationTimers[cardId] = setTimeout(() => {
            // If languages are the same, fetch word explanations instead of translations
            if (wordLanguage === translationLanguage) {
                fetch(`getWordExplanations?word=${encodeURIComponent(word)}&language=${encodeURIComponent(wordLanguage)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.suggestions && data.suggestions.length > 0) {
                            showSuggestions(suggestionsDiv, data.suggestions, translationInput);
                        } else {
                            suggestionsDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching word explanations:', error);
                        suggestionsDiv.style.display = 'none';
                    });
            } else {
                // Fetch translations when languages are different
                fetch(`getTranslationSuggestions?word=${encodeURIComponent(word)}&source=${encodeURIComponent(wordLanguage)}&target=${encodeURIComponent(translationLanguage)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.suggestions && data.suggestions.length > 0) {
                            showSuggestions(suggestionsDiv, data.suggestions, translationInput);
                        } else {
                            suggestionsDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching translation suggestions:', error);
                        suggestionsDiv.style.display = 'none';
                    });
            }
        }, 500);
    }
    
    function handleKeyDown(event, cardId, fieldType) {
        // Handle Enter/Return key
        if (event.key === 'Enter' || event.keyCode === 13) {
            event.preventDefault();
            
            if (fieldType === 'word') {
                // Move to translation field
                const translationInput = document.getElementById(`translation${cardId}`);
                if (translationInput) {
                    translationInput.focus();
                    // Trigger translation suggestions when moving to translation field
                    handleTranslationFocus(cardId);
                }
            } else if (fieldType === 'translation') {
                // Check if both fields are filled
                const wordInput = document.getElementById(`word${cardId}`);
                const translationInput = document.getElementById(`translation${cardId}`);
                
                if (wordInput && translationInput) {
                    const wordValue = wordInput.value.trim();
                    const translationValue = translationInput.value.trim();
                    
                    if (wordValue.length > 0 && translationValue.length > 0) {
                        // Both fields filled - create next card
                        addNewCard();
                    }
                }
            }
        }
    }
    
    function showSuggestions(suggestionsDiv, suggestions, inputField) {
        // Hide all other suggestions first to ensure only one dropdown is visible
        document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
            if (dropdown !== suggestionsDiv) {
                dropdown.style.display = 'none';
            }
        });
        
        suggestionsDiv.innerHTML = '';
        suggestions.forEach(suggestion => {
            const item = document.createElement('div');
            item.className = 'suggestion-item';
            item.textContent = suggestion;
            item.onclick = () => {
                inputField.value = suggestion;
                suggestionsDiv.style.display = 'none';
                checkLastCard();
            };
            suggestionsDiv.appendChild(item);
        });
        suggestionsDiv.style.display = 'block';
    }
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.classList.contains('card-input') && !e.target.closest('.suggestions-dropdown')) {
            document.querySelectorAll('.suggestions-dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    });
    
    function addNewCard() {
        cardCounter++;
        const cardsContainer = document.getElementById('cardsContainer');
        const newCard = document.createElement('div');
        newCard.className = 'card';
        newCard.setAttribute('data-card-id', cardCounter);
        newCard.innerHTML = `
            <button type="button" class="delete-card-button" onclick="deleteCard(${cardCounter})" id="deleteButton${cardCounter}">×</button>
            <div class="input-wrapper">
                <input type="text" class="card-input" placeholder="New word" id="word${cardCounter}" oninput="handleWordInput(${cardCounter})" onkeydown="handleKeyDown(event, ${cardCounter}, 'word')" onfocus="handleWordFocus(${cardCounter})" autocomplete="off">
                <div class="suggestions-dropdown" id="wordSuggestions${cardCounter}"></div>
            </div>
            <div class="input-wrapper">
                <input type="text" class="card-input" placeholder="Translation" id="translation${cardCounter}" oninput="handleTranslationInput(${cardCounter})" onkeydown="handleKeyDown(event, ${cardCounter}, 'translation')" onfocus="handleTranslationFocus(${cardCounter})" autocomplete="off">
                <div class="suggestions-dropdown" id="translationSuggestions${cardCounter}"></div>
            </div>
        `;
        cardsContainer.appendChild(newCard);
        
        // Disable add button after adding new card
        document.getElementById('addButton').disabled = true;
        
        // Update delete buttons visibility
        updateDeleteButtons();
        
        // Focus on the new word input
        document.getElementById(`word${cardCounter}`).focus();
    }
    
    function prepareFormData(event) {
        const setName = document.getElementById('setName').value.trim();
        const cards = document.querySelectorAll('.card');
        
        if (!setName) {
            alert('Please enter a set name');
            event.preventDefault();
            return false;
        }
        
        if (cards.length === 0) {
            alert('Please add at least one word and translation');
            event.preventDefault();
            return false;
        }
        
        const words = [];
        let hasValidCard = false;
        
        cards.forEach(card => {
            const cardId = card.getAttribute('data-card-id');
            const wordInput = document.getElementById(`word${cardId}`);
            const translationInput = document.getElementById(`translation${cardId}`);
            
            if (wordInput && translationInput) {
                const word = wordInput.value.trim();
                const translation = translationInput.value.trim();
                
                if (word.length > 0 && translation.length > 0) {
                    words.push({ word: word, translation: translation });
                    hasValidCard = true;
                }
            }
        });
        
        if (!hasValidCard) {
            alert('Please add at least one word and translation');
            event.preventDefault();
            return false;
        }
        
        // Remove any existing hidden inputs (in case form was submitted before)
        const form = document.getElementById('setForm');
        const existingHidden = form.querySelectorAll('input[type="hidden"][name^="words"]');
        existingHidden.forEach(input => input.remove());
        
        // Add hidden inputs for all words so PHP can read them
        words.forEach((wordData, index) => {
            const wordInput = document.createElement('input');
            wordInput.type = 'hidden';
            wordInput.name = `words[${index}][word]`;
            wordInput.value = wordData.word;
            form.appendChild(wordInput);
            
            const translationInput = document.createElement('input');
            translationInput.type = 'hidden';
            translationInput.name = `words[${index}][translation]`;
            translationInput.value = wordData.translation;
            form.appendChild(translationInput);
        });
        
        return true; // Allow form submission
    }
    
    // Initialize delete buttons visibility on page load
    window.addEventListener('DOMContentLoaded', function() {
        updateDeleteButtons();
    });
</script>
</body>
</html>

