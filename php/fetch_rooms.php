<?php
header('Content-Type: application/json');
include 'functions.php';

$from   = $_GET['from'] ?? date('Y-m-d');
$to     = $_GET['to'] ?? date('Y-m-d', strtotime('+1 day'));
$guests = $_GET['guests'] ?? 1; // Default to 1 guest if not provided

// Fetch room availability and prices from Beds24 API
$params = [
    'startDate'     => $from,
    'endDate'       => $to,
    'includePrices' => 'true',
];

$response = fetchFromBed24("inventory/rooms/calendar", $params);

if (! isset($response['success']) || ! $response['success']) {
    echo json_encode(["error" => "Invalid API response", "details" => $response]);
    exit;
}

// Extract room details
$rooms = [];
foreach ($response["data"] as $room) {
    if (! empty($room["calendar"])) {
        $basePrice = $room["calendar"][0]["price1"] ?? 0;

        // Assuming the price increases per guest. Modify this logic as per your pricing rules.
        $totalPrice = $basePrice * (int) $guests;

        $rooms[] = [
            "id"    => $room["roomId"],
            "name"  => $room["name"],
            "price" => $totalPrice, // Adjusted price based on guests
        ];
    }
}

echo json_encode(["rooms" => $rooms]);
