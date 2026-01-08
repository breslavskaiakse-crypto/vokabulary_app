<?php
// getWrongAnswers.php - Generate wrong translation answers for multiple choice questions
header('Content-Type: application/json');

session_start();
$config = require 'config.php';
$groqApiKey = $config['groq_api_key'] ?? '';

if (empty($groqApiKey)) {
    echo json_encode(['error' => 'AI API key not configured']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $word = trim($_GET['word'] ?? '');
    $correctTranslation = trim($_GET['correctTranslation'] ?? '');
    $language = trim($_GET['language'] ?? 'English');
    $count = intval($_GET['count'] ?? 3);
    $existingTranslationsJson = $_GET['existingTranslations'] ?? '[]';
    $existingTranslations = json_decode($existingTranslationsJson, true) ?? [];
    
    if (empty($word) || empty($correctTranslation) || $count < 1) {
        echo json_encode(['error' => 'Missing required parameters']);
        exit;
    }
    
    // Limit count to reasonable number
    $count = min($count, 5);
    
    $existingList = !empty($existingTranslations) ? implode(', ', array_slice($existingTranslations, 0, 5)) : 'none';
    $prompt = "Generate exactly $count wrong translation options for a multiple choice vocabulary test.
The correct word is '$word' and its correct translation is '$correctTranslation' in $language.
Generate $count different wrong translations that:
- Are plausible but incorrect
- Are in $language
- Are similar in difficulty/level to '$correctTranslation'
- Are NOT the same as '$correctTranslation'
- Are NOT the same as '$word'
- Are different from each other
" . (!empty($existingTranslations) ? "- Are NOT any of these existing translations: $existingList\n" : "") . "
Return ONLY a valid JSON array with this exact format (no markdown, no code blocks, just the JSON):
[
    \"wrong translation 1 in $language\",
    \"wrong translation 2 in $language\",
    \"wrong translation 3 in $language\"
]
Make sure:
- All translations are in $language
- They are plausible but incorrect answers
- They are different from '$correctTranslation'
" . (!empty($existingTranslations) ? "- They are different from the existing translations: $existingList\n" : "") . "- Return exactly $count wrong translations
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
        'temperature' => 0.8,
        'max_tokens' => 200
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
        echo json_encode(['error' => 'AI API error']);
        exit;
    }
    
    $result = json_decode($response, true);
    $wrongAnswers = [];
    
    if (isset($result['choices'][0]['message']['content'])) {
        $content = trim($result['choices'][0]['message']['content']);
        
        // Extract JSON array
        if (preg_match('/\[.*\]/s', $content, $matches)) {
            $jsonContent = $matches[0];
        } else {
            $jsonContent = $content;
        }
        
        $answers = json_decode($jsonContent, true);
        
        if (is_array($answers)) {
            foreach ($answers as $answer) {
                $answer = trim($answer);
                // Filter out answers that are the same as correct translation, the word itself, or existing translations
                $isDuplicate = false;
                foreach ($existingTranslations as $existing) {
                    if (strtolower($answer) === strtolower($existing)) {
                        $isDuplicate = true;
                        break;
                    }
                }
                if (!empty($answer) && 
                    !$isDuplicate &&
                    strtolower($answer) !== strtolower($correctTranslation) &&
                    strtolower($answer) !== strtolower($word)) {
                    $wrongAnswers[] = $answer;
                    if (count($wrongAnswers) >= $count) break;
                }
            }
        }
    }
    
    echo json_encode(['wrongAnswers' => array_slice($wrongAnswers, 0, $count)]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>

