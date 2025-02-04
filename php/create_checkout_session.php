<?php
header('Content-Type: application/json');

// Set your Stripe secret key
$stripe_secret_key = 'sk_test_51QNhA3CZMEjSlLSVpRC3TBZoFCMlw5zEV0F00m45OOoLpIcU6fvMN7DN8Jznz1EYz372818tvZORHffZCfTSCE0P00YaboZbjo';

// Get form data from POST request
$roomId   = $_POST['roomId'];
$roomName = $_POST['roomName'];
$price    = $_POST['price'];
$checkin  = $_POST['checkin'];
$checkout = $_POST['checkout'];
$guests   = $_POST['guests'];
$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];

// Prepare Stripe API data
$stripe_data = [
    'payment_method_types' => ['card'],
    'customer_email'       => $email,
    'line_items'           => [[
        'price_data' => [
            'currency'     => 'usd',
            'product_data' => ['name' => "Room: $roomName"],
            'unit_amount'  => $price * 100, // Convert price to cents
        ],
        'quantity'   => 1,
    ]],
    'mode'                 => 'payment',
    'success_url'          => 'http://localhost:8080/bed24-rooms/php/process_booking.php?success=true&' . http_build_query($_POST), // Local Success URL
    'cancel_url'           => 'http://localhost:8080/bed24-rooms/php/checkout.php?canceled=true',                                   // Local Cancel URL
];

// Convert data to JSON
$json_data = json_encode($stripe_data);

// Initialize cURL session
$ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $stripe_secret_key,
    'Content-Type: application/x-www-form-urlencoded',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($stripe_data));

// Execute cURL request
$response = curl_exec($ch);
curl_close($ch);

// Decode response
$stripe_response = json_decode($response, true);

// Check if session was created successfully
if (isset($stripe_response['url'])) {
    // Redirect user to Stripe Checkout
    header("Location: " . $stripe_response['url']);
    exit;
} else {
    die("Error: " . $stripe_response['error']['message']);
}
