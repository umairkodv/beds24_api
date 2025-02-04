<?php
include 'config.php';

function fetchFromBed24($endpoint, $params = []) {
    $url = "https://beds24.com/api/v2/" . $endpoint . "?" . http_build_query($params);

    $headers = [
        'accept: application/json',
        'token: ' . BED24_API_TOKEN
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 401) {
        error_log("⚠️ API Authentication Failed: Token is missing or invalid.");
    }

    return json_decode($response, true);
}
?>
