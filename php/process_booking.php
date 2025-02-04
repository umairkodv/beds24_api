<?php
                           // Include the config file for API details
require_once 'config.php'; // Make sure config.php is in the same directory or provide the correct path

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    // Collect form data from GET request
    $roomId   = $_GET['roomId'];
    $roomName = $_GET['roomName'];
    $price    = $_GET['price'];
    $checkin  = $_GET['checkin'];
    $checkout = $_GET['checkout'];
    $guests   = $_GET['guests'];
    $name     = $_GET['name'];
    $email    = $_GET['email'];
    $phone    = $_GET['phone'];

                                                  // Initialize Beds24 API call for booking
    $beds24_url     = BED24_API_URL . "bookings"; // Use the constant from config.php
    $beds24_api_key = BED24_API_TOKEN;            // Use the constant from config.php

    // Prepare the booking data
    $booking_data = [
        'roomId'   => $roomId,
        'checkin'  => $checkin,
        'checkout' => $checkout,
        'guests'   => $guests,
        'name'     => $name,
        'email'    => $email,
        'phone'    => $phone,
        'price'    => $price,
    ];

    // Debug the booking data (Optional, can be removed in production)
    // echo "<pre>";
    // print_r($booking_data); // Check if all data is correctly prepared
    // echo "</pre>";

    // Use cURL to send the booking data to Beds24 API
    $ch = curl_init($beds24_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $beds24_api_key,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($booking_data));

    // Debugging: Show the headers sent
    curl_setopt($ch, CURLOPT_HEADER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // Check if the booking was successful
    if ($response === false) {
        die("Error: Unable to make booking request.");
    }

    $response_data = json_decode($response, true);

    // Debug the full response from Beds24 (Optional)
    // echo "<pre>";
    // print_r($response_data); // Inspect full response from Beds24
    // echo "</pre>";

    // Check for errors in the response data
    if (isset($response_data['error'])) {
        die("Error: Booking failed on Beds24 API. " . $response_data['error']);
    }

    // Further check if response data contains an error code
    if (isset($response_data['code'])) {
        die("Error Code: " . $response_data['code'] . ". Message: " . $response_data['error']);
    }

    // If no error, booking was successful
    // Redirect to the confirmation page with the necessary details
    header("Location: confirmation.php?roomName=" . urlencode($roomName) . "&name=" . urlencode($name) . "&price=" . urlencode($price));
    exit;
} else {
    echo "Payment failed.";
}
