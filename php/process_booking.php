<?php
require_once 'config.php'; // Ensure the correct API details

// Check if payment was successful
if (isset($_GET['payment_success']) && $_GET['payment_success'] == 'true') {
    // Collect form data from GET request
    $roomId   = $_GET['roomId'];
    $roomName = $_GET['roomName'];
    $price    = $_GET['totalPrice'];
    $checkin  = $_GET['checkin'];
    $checkout = $_GET['checkout'];
    $guests   = $_GET['guests'];
    $name     = $_GET['name'];
    $email    = $_GET['email'];
    $phone    = $_GET['phone'];

    // Debug: Ensure variables have correct values
    echo "Room Name: " . $roomName . "<br>";
    echo "Name: " . $name . "<br>";
    echo "Price: " . $price . "<br>";

                                                    // Initialize Beds24 API URL and API token
    $beds24_url     = "https://beds24.com/api/v2/"; // Beds24 API base URL
    $beds24_api_key = BED24_API_TOKEN;              // Use the token from config.php

    // Prepare the booking data in the format that Beds24 expects
    $booking_data = [
        [
            'roomId'    => $roomId,
            'status'    => 'confirmed',
            'arrival'   => $checkin,
            'departure' => $checkout,
            'numAdult'  => $guests,
            'numChild'  => 0,
            'title'     => 'Mr',
            'firstName' => $name,
            'lastName'  => '',
            'email'     => $email,
            'mobile'    => $phone,
            'address'   => '',
            'city'      => '',
            'state'     => '',
            'postcode'  => '',
            'country'   => 'Australia',
        ],
    ];

    // Use cURL to send the booking data to Beds24 API
    $ch = curl_init($beds24_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $beds24_api_key,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($booking_data));

    $response  = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status code
    curl_close($ch);

    // Check if the response is empty
    if (empty($response)) {
        die("Error: Empty response from Beds24 API.");
    }

    // Decode the JSON response
    $response_data = json_decode($response, true);

    // Check for errors in the response
    if (isset($response_data['errors']) && count($response_data['errors']) > 0) {
        foreach ($response_data['errors'] as $error) {
            die("Error: " . $error['message']);
        }
    }

    // If no error, booking was successful
    // Redirect to the confirmation page with the necessary details
    if (! empty($roomName) && ! empty($name) && ! empty($price)) {
        header("Location: confirmation.php?roomName=" . urlencode($roomName) . "&name=" . urlencode($name) . "&price=" . urlencode($price));
    } else {
        die("Error: Missing data for redirect.");
    }
    exit;
} else {
    echo "Payment failed.";
}
