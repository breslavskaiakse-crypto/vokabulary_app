<?php
// modelsai.php - List available Groq models using direct API call

$config = require 'config.php';

// Get Groq API key from config
$groqApiKey = $config['groq_api_key'] ?? '';

if (empty($groqApiKey)) {
    die("Error: Groq API key not found in config.php\n");
}

// Call Groq API directly to list models
$url = "https://api.groq.com/openai/v1/models";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $groqApiKey
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "<!DOCTYPE html>\n";
echo "<html><head><title>Available Groq Models</title>\n";
echo "<style>body { font-family: Arial, sans-serif; padding: 20px; background-color: #e6d9f2; }";
echo "h1 { color: #6b4c93; }";
echo "pre { background: white; padding: 15px; border-radius: 8px; overflow-x: auto; }";
echo "table { background: white; border-collapse: collapse; width: 100%; margin-top: 20px; }";
echo "th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }";
echo "th { background-color: #9b7fb8; color: white; }";
echo ".error { color: #f44336; background: #ffebee; padding: 15px; border-radius: 8px; }</style></head><body>\n";
echo "<h1>Available Groq Models</h1>\n";

if ($curlError) {
    echo "<div class='error'>Connection error: " . htmlspecialchars($curlError) . "</div>\n";
} elseif ($httpCode !== 200) {
    echo "<div class='error'>API error (HTTP $httpCode): " . htmlspecialchars(substr($response, 0, 500)) . "</div>\n";
} else {
    $models = json_decode($response, true);
    
    if (isset($models['data']) && is_array($models['data'])) {
        echo "<table>\n";
        echo "<tr><th>Model ID</th><th>Object</th><th>Created</th><th>Owned By</th></tr>\n";
        
        foreach ($models['data'] as $model) {
            $id = htmlspecialchars($model['id'] ?? 'N/A');
            $object = htmlspecialchars($model['object'] ?? 'N/A');
            $created = isset($model['created']) ? date('Y-m-d H:i:s', $model['created']) : 'N/A';
            $ownedBy = htmlspecialchars($model['owned_by'] ?? 'N/A');
            
            echo "<tr>";
            echo "<td><strong>$id</strong></td>";
            echo "<td>$object</td>";
            echo "<td>$created</td>";
            echo "<td>$ownedBy</td>";
            echo "</tr>\n";
        }
        
        echo "</table>\n";
        
        echo "<h2>Raw JSON Response:</h2>\n";
        echo "<pre>" . htmlspecialchars(json_encode($models, JSON_PRETTY_PRINT)) . "</pre>\n";
    } else {
        echo "<p>No models found or unexpected response format.</p>\n";
        echo "<h2>Raw Response:</h2>\n";
        echo "<pre>" . htmlspecialchars($response) . "</pre>\n";
    }
}

echo "</body></html>\n";
?>