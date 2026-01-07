<?php
// getTranslationSuggestions.php - Get translation suggestions using MyMemory Translation API
header('Content-Type: application/json');

// Function to validate if a translation is acceptable
function isValidTranslation($translation, $originalWord) {
    if (empty($translation)) {
        return false;
    }
    
    $translation = trim($translation);
    
    // Minimum length check (at least 1 character)
    if (strlen($translation) < 1) {
        return false;
    }
    
    // Only reject obvious errors (just punctuation marks)
    if (preg_match('/^[?\.!]+$/', $translation)) {
        return false;
    }
    
    // Reject obvious error messages
    $errorMessages = ['translation', 'error', 'not found', 'no translation', 'undefined', 'null'];
    if (in_array(strtolower($translation), $errorMessages)) {
        return false;
    }
    
    // Check punctuation: if original word has no punctuation, translation should have no punctuation
    // But be very lenient - only reject if translation has ONLY punctuation (no letters at all)
    $originalPunctuation = preg_replace('/[a-zA-Zа-яА-Я0-9\s\u4e00-\u9fff]/u', '', trim($originalWord));
    $translationPunctuation = preg_replace('/[a-zA-Zа-яА-Я0-9\s\u4e00-\u9fff]/u', '', $translation);
    
    // Only reject if original has no punctuation AND translation has ONLY punctuation (no letters/numbers)
    if (empty($originalPunctuation) && !empty($translationPunctuation)) {
        // Check if translation has any letters or numbers - if it has them, allow it even with punctuation
        if (!preg_match('/[a-zA-Zа-яА-Я0-9\u4e00-\u9fff]/u', $translation)) {
            return false; // Translation has only punctuation, reject
        }
        // If translation has letters/numbers, allow it even if it has punctuation
    }
    
    return true;
}

// Function to check if a translation is likely an infinitive form
function isLikelyInfinitive($translation, $targetLangCode) {
    $translation = trim(strtolower($translation));
    
    // Common infinitive endings by language
    $infinitivePatterns = [
        'es' => ['/ar$/', '/er$/', '/ir$/'],  // Spanish: -ar, -er, -ir
        'fr' => ['/er$/', '/ir$/', '/re$/'],  // French: -er, -ir, -re
        'de' => ['/en$/', '/n$/'],            // German: -en, -n
        'it' => ['/are$/', '/ere$/', '/ire$/'], // Italian: -are, -ere, -ire
        'pt' => ['/ar$/', '/er$/', '/ir$/'],  // Portuguese: -ar, -er, -ir
        'nl' => ['/en$/'],                    // Dutch: -en
        'pl' => ['/ć$/', '/c$/', '/ć$/'],     // Polish: various infinitive endings
        'ru' => ['/ть$/', '/ти$/'],            // Russian: -ть, -ти
        'en' => ['/^to\s+/'],                 // English: "to" prefix
    ];
    
    if (isset($infinitivePatterns[$targetLangCode])) {
        foreach ($infinitivePatterns[$targetLangCode] as $pattern) {
            if (preg_match($pattern, $translation)) {
                return true;
            }
        }
    }
    
    // For English, check if it starts with "to"
    if ($targetLangCode === 'en' && preg_match('/^to\s+/', $translation)) {
        return true;
    }
    
    return false;
}

// Function to detect if a translation looks like a conjugated verb form
function isLikelyConjugated($translation, $targetLangCode) {
    $translation = trim($translation);
    
    // Conjugated forms often have common endings that differ from infinitive
    $conjugatedPatterns = [
        'es' => ['/o$/', '/as$/', '/a$/', '/amos$/', '/áis$/', '/an$/'],  // Spanish conjugations
        'fr' => ['/e$/', '/es$/', '/ons$/', '/ez$/', '/ent$/'],           // French conjugations
        'de' => ['/e$/', '/st$/', '/t$/', '/en$/'],                       // German conjugations
        'it' => ['/o$/', '/i$/', '/a$/', '/iamo$/', '/ate$/', '/ano$/'],  // Italian conjugations
    ];
    
    if (isset($conjugatedPatterns[$targetLangCode])) {
        foreach ($conjugatedPatterns[$targetLangCode] as $pattern) {
            if (preg_match($pattern, strtolower($translation))) {
                // But check if it's not an infinitive first
                if (!isLikelyInfinitive($translation, $targetLangCode)) {
                    return true;
                }
            }
        }
    }
    
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $word = trim($_GET['word'] ?? '');
    $sourceLang = trim($_GET['source'] ?? 'English');
    $targetLang = trim($_GET['target'] ?? 'English');
    
    if (empty($word)) {
        echo json_encode(['suggestions' => []]);
        exit;
    }
    
    // LibreTranslate language codes (lowercase ISO 639-1 codes)
    $langCodes = [
        'English' => 'en',
        'Spanish' => 'es',
        'French' => 'fr',
        'German' => 'de',
        'Italian' => 'it',
        'Portuguese' => 'pt',
        'Russian' => 'ru',
        'Chinese' => 'zh',
        'Japanese' => 'ja',
        'Korean' => 'ko',
        'Arabic' => 'ar',
        'Dutch' => 'nl',
        'Polish' => 'pl',
        'Turkish' => 'tr',
        'Swedish' => 'sv',
        'Norwegian' => 'no',
        'Danish' => 'da',
        'Finnish' => 'fi',
        'Greek' => 'el',
        'Hebrew' => 'he'
    ];
    
    $sourceCode = $langCodes[$sourceLang] ?? 'en';
    $targetCode = $langCodes[$targetLang] ?? 'en';
    
    if ($sourceCode === $targetCode) {
        echo json_encode(['suggestions' => [$word]]);
        exit;
    }
    
    // Store suggestions with their metadata for sorting
    $suggestionsData = [];
    
    // Use MyMemory Translation API (free, 10,000 words/day, no API key needed)
    $url = "https://api.mymemory.translated.net/get";
    $params = http_build_query([
        'q' => $word,
        'langpair' => $sourceCode . '|' . $targetCode
    ]);
    
    $ch = curl_init($url . '?' . $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        
        // Get main translation
        if (isset($result['responseData']['translatedText'])) {
            $translation = trim($result['responseData']['translatedText']);
            // Very lenient validation - only reject if it's obviously an error
            if (!empty($translation) && 
                strlen($translation) >= 1 && 
                !preg_match('/^[?\.!]+$/', $translation) &&
                !in_array(strtolower($translation), ['translation', 'error', 'not found', 'no translation', 'undefined', 'null'])) {
                
                $isInfinitive = isLikelyInfinitive($translation, $targetCode);
                $isConjugated = isLikelyConjugated($translation, $targetCode);
                
                $suggestionsData[] = [
                    'text' => $translation,
                    'quality' => 1.0,
                    'isInfinitive' => $isInfinitive,
                    'isConjugated' => $isConjugated
                ];
            }
        }
        
        // Get alternative translations from matches
        if (isset($result['matches']) && is_array($result['matches'])) {
            foreach ($result['matches'] as $match) {
                if (isset($match['translation']) && count($suggestionsData) < 3) {
                    $altTranslation = trim($match['translation']);
                    // Very lenient validation - only reject if it's obviously an error
                    if (!empty($altTranslation) && 
                        strlen($altTranslation) >= 1 && 
                        !preg_match('/^[?\.!]+$/', $altTranslation) &&
                        !in_array(strtolower($altTranslation), ['translation', 'error', 'not found', 'no translation', 'undefined', 'null'])) {
                        
                        // Check for duplicates
                        $alreadyExists = false;
                        foreach ($suggestionsData as $existing) {
                            if (strtolower($existing['text']) === strtolower($altTranslation)) {
                                $alreadyExists = true;
                                break;
                            }
                        }
                        
                        if (!$alreadyExists) {
                            $isInfinitive = isLikelyInfinitive($altTranslation, $targetCode);
                            $isConjugated = isLikelyConjugated($altTranslation, $targetCode);
                            
                            $suggestionsData[] = [
                                'text' => $altTranslation,
                                'quality' => 0.8,
                                'isInfinitive' => $isInfinitive,
                                'isConjugated' => $isConjugated
                            ];
                            
                            if (count($suggestionsData) >= 3) break;
                        }
                    }
                }
            }
        }
    }
    
    // Sort suggestions:
    // 1. Infinitives first (highest priority)
    // 2. Then by quality (highest quality first)
    // 3. Conjugated forms last
    usort($suggestionsData, function($a, $b) {
        // Infinitives come first
        if ($a['isInfinitive'] && !$b['isInfinitive']) return -1;
        if (!$a['isInfinitive'] && $b['isInfinitive']) return 1;
        
        // If both are infinitives or both are not, sort by quality
        if ($a['isInfinitive'] === $b['isInfinitive']) {
            // Conjugated forms go last
            if ($a['isConjugated'] && !$b['isConjugated']) return 1;
            if (!$a['isConjugated'] && $b['isConjugated']) return -1;
            
            // Then by quality (higher quality first)
            return $b['quality'] <=> $a['quality'];
        }
        
        return 0;
    });
    
    // Extract just the text from sorted suggestions
    $suggestions = array_map(function($item) {
        return $item['text'];
    }, array_slice($suggestionsData, 0, 3));
    
    // Return up to 3 suggestions
    echo json_encode(['suggestions' => $suggestions]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
