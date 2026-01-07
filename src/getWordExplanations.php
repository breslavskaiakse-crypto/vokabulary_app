<?php
// getWordExplanations.php - Get word explanations using Groq AI when source and target languages are the same
header('Content-Type: application/json');

session_start();
$config = require 'config.php';
$groqApiKey = $config['groq_api_key'] ?? '';

if (empty($groqApiKey)) {
    echo json_encode(['suggestions' => []]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $word = trim($_GET['word'] ?? '');
    $language = trim($_GET['language'] ?? 'English');
    
    if (empty($word) || strlen($word) < 2) {
        echo json_encode(['suggestions' => []]);
        exit;
    }
    
    $prompt = "Provide exactly 3 different explanations for the word '$word' in $language. 
    Each explanation should be 1-18 words.
    IMPORTANT: Do NOT mention the word '$word' itself in any explanation.
    These explanations will be used on the back of a vocabulary card, so they should help someone guess the word.
    
    Provide a variety:
    - One explanation should be synonyms (e.g., for 'happy': \"joyful, pleased, content\")
    - One explanation should be a complete sentence (e.g., for 'book': \"A written work that contains pages and tells a story\")
    - One explanation can be either synonyms or a sentence
    
    Return ONLY a valid JSON array with this exact format (no markdown, no code blocks, just the JSON):
    [
        \"first explanation in $language (synonyms or sentence, 1-18 words)\",
        \"second explanation in $language (synonyms or sentence, 1-18 words)\",
        \"third explanation in $language (synonyms or sentence, 1-18 words)\"
    ]
    Examples for the word 'happy': 
    - Synonyms: [\"joyful, pleased, content\", \"feeling good and positive\", \"in a state of joy and satisfaction\"]
    - Sentence: [\"A feeling of joy and contentment\", \"Someone who feels good and positive\", \"The opposite of sad\"]
    Make sure:
    - All explanations are in $language
    - Each explanation is 1-18 words
    - Do NOT include the word '$word' in any explanation
    - Include at least one with synonyms and at least one complete sentence
    - Return exactly 3 explanations
    - Return ONLY the JSON array, nothing else";
    
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
        'max_tokens' => 250
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $groqApiKey
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError || $httpCode !== 200) {
        echo json_encode(['suggestions' => []]);
        exit;
    }
    
    $result = json_decode($response, true);
    $suggestions = [];
    
    if (isset($result['choices'][0]['message']['content'])) {
        $content = trim($result['choices'][0]['message']['content']);
        
        // Try to extract JSON from the response (might be wrapped in markdown)
        if (preg_match('/\[.*\]/s', $content, $matches)) {
            $jsonContent = $matches[0];
        } else {
            $jsonContent = $content;
        }
        
        $explanations = json_decode($jsonContent, true);
        
        if (is_array($explanations)) {
            foreach ($explanations as $explanation) {
                $explanation = trim($explanation);
                // Remove the word itself if it appears in the explanation (case-insensitive)
                $explanation = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '', $explanation);
                $explanation = trim($explanation);
                // Remove extra spaces
                $explanation = preg_replace('/\s+/', ' ', $explanation);
                
                // Only add if explanation is not empty and doesn't contain the word
                if (!empty($explanation) && 
                    strlen($explanation) > 0 && 
                    stripos($explanation, $word) === false &&
                    strlen($explanation) <= 200) { // Limit to 200 characters (allows up to ~18 words)
                    $suggestions[] = $explanation;
                    if (count($suggestions) >= 3) break;
                }
            }
        }
    }
    
    echo json_encode(['suggestions' => array_slice($suggestions, 0, 3)]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>

