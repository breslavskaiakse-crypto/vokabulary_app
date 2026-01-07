<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chat - Vocabulary app:)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
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
        h1 {
            color: #6b4c93;
            margin: 20px 0;
            text-align: center;
            font-size: 2.5em;
        }
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-height: 400px;
            max-height: calc(100vh - 250px);
        }
        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            max-width: 80%;
            word-wrap: break-word;
        }
        .message.user {
            background-color: #9b7fb8;
            color: white;
            margin-left: auto;
            text-align: right;
        }
        .message.assistant {
            background-color: #f0f0f0;
            color: #333;
            margin-right: auto;
        }
        .message-label {
            font-size: 0.8em;
            font-weight: bold;
            margin-bottom: 5px;
            opacity: 0.8;
        }
        .chat-input-container {
            display: flex;
            gap: 10px;
            background-color: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .chat-input {
            flex: 1;
            padding: 15px;
            font-size: 1.1em;
            border: 2px solid #9b7fb8;
            border-radius: 8px;
            outline: none;
        }
        .chat-input:focus {
            border-color: #6b4c93;
        }
        .send-button {
            padding: 15px 30px;
            font-size: 1.1em;
            background-color: #9b7fb8;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .send-button:hover:not(:disabled) {
            background-color: #8a6fa5;
        }
        .send-button:disabled {
            background-color: #c4b5d4;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #9b7fb8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .error-message {
            background-color: #ffebee;
            color: #f44336;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <button class="home-button" onclick="window.location.href='index.php'" title="Home">🏠</button>
    <h1>AI Chat</h1>
    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="message assistant">
                <div class="message-label">AI Assistant</div>
                <div>Hello! I'm your AI assistant. How can I help you today?</div>
            </div>
        </div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="userInput" placeholder="Type your message here..." onkeypress="handleKeyPress(event)">
            <button class="send-button" id="sendButton" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function sendMessage() {
            const input = document.getElementById('userInput');
            const message = input.value.trim();
            
            if (!message) {
                return;
            }

            // Disable input and button
            input.disabled = true;
            const sendButton = document.getElementById('sendButton');
            sendButton.disabled = true;
            sendButton.innerHTML = '<div class="loading"></div>';

            // Add user message to chat
            addMessage('user', message);
            input.value = '';

            // Send to backend
            const formData = new FormData();
            formData.append('message', message);

            fetch('chatHandler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addMessage('assistant', data.response);
                } else {
                    addMessage('assistant', 'Error: ' + (data.error || 'Failed to get response'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                addMessage('assistant', 'Error: Could not connect to the server. Please try again.');
            })
            .finally(() => {
                // Re-enable input and button
                input.disabled = false;
                sendButton.disabled = false;
                sendButton.textContent = 'Send';
                input.focus();
            });
        }

        function addMessage(role, content) {
            const messagesDiv = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message ' + role;
            
            const label = document.createElement('div');
            label.className = 'message-label';
            label.textContent = role === 'user' ? 'You' : 'AI Assistant';
            messageDiv.appendChild(label);
            
            const contentDiv = document.createElement('div');
            contentDiv.textContent = content;
            messageDiv.appendChild(contentDiv);
            
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    </script>
</body>
</html>

