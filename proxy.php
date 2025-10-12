<?php
// Ustawienie nagłówków
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Konfiguracja
$etherscanApiKey = 'MCGDEP3KKNK33IU3VBQMCP3QS86WMFPQE6'; // Klucz do Etherscan
$ethplorerApiKey = 'freekey'; // Darmowy klucz do Ethplorer
$tokenAddress = '0xED9114c614aD6b948a1EA21f062F6e1D0b4e8308';
$chainId = 1; // ID sieci Ethereum Mainnet

// Sprawdzanie akcji
$action = isset($_GET['action']) ? $_GET['action'] : '';
$apiUrl = '';

switch ($action) {
    case 'getSupply':
        $apiUrl = "https://api.etherscan.io/v2/api?chainid={$chainId}&module=stats&action=tokensupply&contractaddress={$tokenAddress}&apikey={$etherscanApiKey}";
        break;
        
    // === NOWA AKCJA DLA DANYCH O POSIADACZACH I TRANSFERACH ===
    case 'getTokenInfo':
        $apiUrl = "https://api.ethplorer.io/getTokenInfo/{$tokenAddress}?apiKey={$ethplorerApiKey}";
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Nieprawidłowa akcja.']);
        exit;
}

// Wykonanie zapytania cURL
if (!function_exists('curl_init')) {
    http_response_code(500);
    echo json_encode(['error' => 'Rozszerzenie cURL nie jest włączone na serwerze PHP.']);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Zwrot odpowiedzi
if ($httpCode >= 200 && $httpCode < 300) {
    echo $response;
} else {
    http_response_code($httpCode);
    echo json_encode(['error' => 'Zewnętrzne API zwróciło błąd.', 'status_code' => $httpCode]);
}

exit;