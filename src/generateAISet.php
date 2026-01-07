<?php
// generateAISet.php - Handle AI vocabulary set generation
session_start();
$pdo = require 'db.php';
$config = require 'config.php';

// Get user ID from session
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['error' => 'Please log in']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = trim($_POST['topic'] ?? '');
    $wordCount = intval($_POST['wordCount'] ?? 10);
    $level = trim($_POST['level'] ?? 'beginner');
    $termsLanguage = trim($_POST['termsLanguage'] ?? 'English');
    $translationLanguage = trim($_POST['translationLanguage'] ?? 'English');
    
    if (empty($topic) || $wordCount < 1 || $wordCount > 50) {
        echo json_encode(['error' => 'Invalid input. Topic is required and word count must be between 1 and 50.']);
        exit;
    }
    
    if (empty($termsLanguage) || empty($translationLanguage)) {
        echo json_encode(['error' => 'Both terms language and translation language are required.']);
        exit;
    }
    
    // Language codes mapping
    $langCodes = [
        'English' => 'en', 'Spanish' => 'es', 'French' => 'fr', 'German' => 'de',
        'Italian' => 'it', 'Portuguese' => 'pt', 'Russian' => 'ru', 'Chinese' => 'zh',
        'Japanese' => 'ja', 'Korean' => 'ko', 'Arabic' => 'ar', 'Dutch' => 'nl',
        'Polish' => 'pl', 'Turkish' => 'tr', 'Swedish' => 'sv', 'Norwegian' => 'no',
        'Danish' => 'da', 'Finnish' => 'fi', 'Greek' => 'el', 'Hebrew' => 'he'
    ];
    
    $sourceCode = $langCodes[$termsLanguage] ?? 'en';
    $targetCode = $langCodes[$translationLanguage] ?? 'en';
    
    // Get Groq API key from config
    $groqKey = $config['groq_api_key'] ?? '';
    
    if (empty($groqKey)) {
        echo json_encode(['error' => 'Groq API key not configured. Please add your key to config.php']);
        exit;
    }
    
    // Create the prompt for the model
    $levelDescription = [
        'beginner' => 'beginner level (A1 - simple, common words, basic vocabulary)',
        'elementary' => 'elementary level (A2 - basic words and phrases, everyday situations)',
        'pre-intermediate' => 'pre-intermediate level (B1 - moderately complex words, can handle simple conversations)',
        'intermediate' => 'intermediate level (B2 - complex words, can discuss various topics fluently)',
        'advanced' => 'advanced level (C1 - sophisticated words, fluent communication)',
        'proficient' => 'proficient level (C2 - very sophisticated words, near-native vocabulary)'
    ];
    
    $levelDesc = $levelDescription[$level] ?? 'beginner level (A1 - simple, common words)';
    
    // Function to get translation from MyMemory
    function getTranslationFromMyMemory($word, $sourceCode, $targetCode) {
        $url = "https://api.mymemory.translated.net/get";
        $params = http_build_query([
            'q' => $word,
            'langpair' => $sourceCode . '|' . $targetCode
        ]);
        
        $ch = curl_init($url . '?' . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['responseData']['translatedText'])) {
                $translation = trim($result['responseData']['translatedText']);
                // Basic validation - reject obvious errors
                if (!empty($translation) && 
                    strlen($translation) >= 1 && 
                    !preg_match('/^[?\.!]+$/', $translation) &&
                    !in_array(strtolower($translation), ['translation', 'error', 'not found', 'no translation', 'undefined', 'null'])) {
                    return $translation;
                }
            }
        }
        return null;
    }
    
    // Check if languages are the same - if so, generate explanations instead of translations
    if ($termsLanguage === $translationLanguage) {
        $prompt = "Generate a vocabulary list for learning about '$topic' at $levelDesc in $termsLanguage. 
Create exactly $wordCount word-explanation pairs in JSON format.
The words (terms) should be in $termsLanguage.
For each word, provide an explanation in $termsLanguage (1-18 words) that helps someone understand the word.
IMPORTANT: The explanation should NOT mention the word itself.
Explanations can be:
- Synonyms (e.g., for 'happy': \"joyful, pleased, content\")
- Complete sentences (e.g., for 'book': \"A written work that contains pages and tells a story\")
- Mix of both formats
Return ONLY a valid JSON array with this exact format (no markdown, no code blocks, just the JSON):
[
    {\"word\": \"example word in $termsLanguage\", \"translation\": \"explanation in $termsLanguage (1-18 words, no mention of the word)\"},
    {\"word\": \"another word in $termsLanguage\", \"translation\": \"another explanation in $termsLanguage (1-18 words, no mention of the word)\"}
]
Make sure:
- The words (terms) are in $termsLanguage
- The explanations are in $termsLanguage
- Explanations are 1-18 words
- Do NOT mention the word itself in the explanation
- Include variety: some with synonyms, some with sentences
- The words are appropriate for $levelDesc
- All words are related to the topic: $topic
- Return exactly $wordCount pairs
- Return ONLY the JSON array, nothing else";
    } else {
        // Generate only words, translations will come from MyMemory
        $prompt = "Generate a vocabulary list for learning about '$topic' at $levelDesc. 
Create exactly $wordCount words in $termsLanguage.
Return ONLY a valid JSON array with this exact format (no markdown, no code blocks, just the JSON):
[
    {\"word\": \"example word in $termsLanguage\"},
    {\"word\": \"another word in $termsLanguage\"},
    {\"word\": \"third word in $termsLanguage\"}
]
Make sure:
- The words (terms) are in $termsLanguage
- The words are appropriate for $levelDesc
- All words are related to the topic: $topic
- Return exactly $wordCount words
- Return ONLY the JSON array, nothing else";
    }

    // Use Groq API (OpenAI-compatible format)
    // Using Mixtral model - fast and good quality
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
        'max_tokens' => 2000
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
        echo json_encode(['error' => 'Connection error: ' . $curlError]);
        exit;
    }
    
    if ($httpCode !== 200) {
        $errorData = json_decode($response, true);
        $errorMsg = $errorData['error']['message'] ?? $errorData['error']['code'] ?? substr($response, 0, 200);
        echo json_encode(['error' => 'AI API error (HTTP ' . $httpCode . '): ' . $errorMsg]);
        exit;
    }
    
    $result = json_decode($response, true);
    
    // Groq returns response in 'choices' array with 'message' content (OpenAI format)
    if (!isset($result['choices'][0]['message']['content'])) {
        echo json_encode(['error' => 'Invalid API response format. Response: ' . substr(json_encode($result), 0, 200)]);
        exit;
    }
    
    // Extract the generated text
    $generatedText = $result['choices'][0]['message']['content'];
    
    // Clean up the response (remove markdown code blocks if present)
    $generatedText = preg_replace('/```json\n?/', '', $generatedText);
    $generatedText = preg_replace('/```\n?/', '', $generatedText);
    $generatedText = trim($generatedText);
    
    // Try to extract JSON from the response if it's embedded in text
    if (preg_match('/\[.*\]/s', $generatedText, $matches)) {
        $generatedText = $matches[0];
    }
    
    // Parse JSON
    $words = json_decode($generatedText, true);
    
    if (!is_array($words) || empty($words)) {
        // If parsing failed, try to extract word pairs manually
        echo json_encode(['error' => 'Failed to parse AI response. Response: ' . substr($generatedText, 0, 200)]);
        exit;
    }
    
    // Validate and process words array
    $validWords = [];
    
    if ($termsLanguage === $translationLanguage) {
        // Same language: AI generates word-explanation pairs
        foreach ($words as $wordData) {
            if (isset($wordData['word']) && isset($wordData['translation'])) {
                $word = trim($wordData['word']);
                $translation = trim($wordData['translation']);
                
                if ($word !== '' && $translation !== '') {
                    $validWords[] = [
                        'word' => $word,
                        'translation' => $translation
                    ];
                }
            }
        }
    } else {
        // Different languages: AI generates only words, fetch translations from MyMemory
        $generatedWords = [];
        foreach ($words as $wordData) {
            if (isset($wordData['word'])) {
                $word = trim($wordData['word']);
                if ($word !== '') {
                    $generatedWords[] = $word;
                }
            }
        }
        
        if (empty($generatedWords)) {
            echo json_encode(['error' => 'No valid words generated']);
            exit;
        }
        
        // Limit to requested word count
        $generatedWords = array_slice($generatedWords, 0, $wordCount);
        
        // Fetch translations from MyMemory for each word
        foreach ($generatedWords as $word) {
            $translation = getTranslationFromMyMemory($word, $sourceCode, $targetCode);
            if ($translation !== null) {
                $validWords[] = [
                    'word' => $word,
                    'translation' => $translation
                ];
            } else {
                // If translation fails, still add the word with empty translation (or skip it)
                // For now, we'll skip words without translations
            }
        }
        
        if (empty($validWords)) {
            echo json_encode(['error' => 'Failed to get translations for generated words']);
            exit;
        }
    }
    
    if (empty($validWords)) {
        echo json_encode(['error' => 'No valid words generated']);
        exit;
    }
    
    // Limit to requested word count
    $validWords = array_slice($validWords, 0, $wordCount);
    
    // Generate set name - map to readable format
    $levelNames = [
        'beginner' => 'Beginner (A1)',
        'elementary' => 'Elementary (A2)',
        'pre-intermediate' => 'Pre-Intermediate (B1)',
        'intermediate' => 'Intermediate (B2)',
        'advanced' => 'Advanced (C1)',
        'proficient' => 'Proficient (C2)'
    ];
    
    $levelDisplayName = $levelNames[$level] ?? 'Beginner (A1)';
    $setName = ucfirst($topic) . " - " . $levelDisplayName;
    
    // Store in session instead of saving to database
    // User will review and save in edit-set.php
    $_SESSION['ai_generated_set'] = [
        'name' => $setName,
        'words' => $validWords,
        'wordLanguage' => $termsLanguage,
        'translationLanguage' => $translationLanguage
    ];
    
    // Return success with data (not saving to database yet)
    echo json_encode([
        'success' => true,
        'message' => 'Set generated successfully with ' . count($validWords) . ' words!',
        'words' => $validWords,
        'setName' => $setName
    ]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>

