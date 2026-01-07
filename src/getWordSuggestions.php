<?php
// getWordSuggestions.php - Get word autocomplete suggestions using Groq
header('Content-Type: application/json');

$config = require 'config.php';
$groqKey = $config['groq_api_key'] ?? '';

if (empty($groqKey)) {
    echo json_encode(['error' => 'Groq API key not configured']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $partialWord = trim($_GET['word'] ?? '');
    $language = trim($_GET['language'] ?? 'English');
    
    if (empty($partialWord) || strlen($partialWord) < 2) {
        echo json_encode(['suggestions' => []]);
        exit;
    }
    
    // Use Groq to suggest words
    $prompt = "Suggest exactly 3 common words in $language that start with '$partialWord'. 
Return ONLY a JSON array of words, no explanations, no markdown, just: [\"word1\", \"word2\", \"word3\"]";
    
    $url = "https://api.groq.com/openai/v1/chat/completions";
    
    $data = [
        'model' => 'llama-3.1-8b-instant',
        'messages' => [
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 100
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $groqKey
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        if (isset($result['choices'][0]['message']['content'])) {
            $content = $result['choices'][0]['message']['content'];
            // Clean up response (remove markdown if present)
            $content = preg_replace('/```json\n?/', '', $content);
            $content = preg_replace('/```\n?/', '', $content);
            $content = trim($content);
            
            // Try to extract JSON array
            if (preg_match('/\[.*\]/s', $content, $matches)) {
                $content = $matches[0];
            }
            
            $suggestions = json_decode($content, true);
            if (is_array($suggestions)) {
                echo json_encode(['suggestions' => array_slice($suggestions, 0, 3)]);
                exit;
            }
        }
    }
    
    // Fallback: return empty suggestions
    echo json_encode(['suggestions' => []]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>

