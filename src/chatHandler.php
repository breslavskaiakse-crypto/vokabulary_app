<?php
// chatHandler.php - Handle chat messages with Groq API
header('Content-Type: application/json');

$config = require 'config.php';
$groqKey = $config['groq_api_key'] ?? '';

if (empty($groqKey)) {
    echo json_encode(['success' => false, 'error' => 'Groq API key not configured']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'error' => 'Message is required']);
        exit;
    }
    
    // Use Groq API with llama-3.1-8b-instant model
    $url = "https://api.groq.com/openai/v1/chat/completions";
    
    $data = [
        'model' => 'llama-3.1-8b-instant',
        'messages' => [
            [
                'role' => 'user',
                'content' => $message
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 2048
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $groqKey
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        echo json_encode(['success' => false, 'error' => 'Connection error: ' . $curlError]);
        exit;
    }
    
    if ($httpCode !== 200) {
        $errorData = json_decode($response, true);
        $errorMsg = $errorData['error']['message'] ?? $errorData['error']['code'] ?? substr($response, 0, 200);
        echo json_encode(['success' => false, 'error' => 'API error (HTTP ' . $httpCode . '): ' . $errorMsg]);
        exit;
    }
    
    $result = json_decode($response, true);
    
    if (!isset($result['choices'][0]['message']['content'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid API response format']);
        exit;
    }
    
    $aiResponse = $result['choices'][0]['message']['content'];
    
    echo json_encode([
        'success' => true,
        'response' => $aiResponse
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>

