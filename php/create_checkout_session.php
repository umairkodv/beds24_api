<?php
header('Content-Type: application/json');
session_start();
// Get form data from POST request
$roomId        = $_POST['roomId'];
$roomName      = $_POST['roomName'];
$price         = $_POST['totalPrice'];
$checkin       = $_POST['checkin'];
$checkout      = $_POST['checkout'];
$guests        = $_POST['guests'];
$name          = $_POST['name'];
$email         = $_POST['email'];
$phone         = $_POST['phone'];
$pricePerNight = $_POST['pricePerNight'];

$_SESSION['roomId']        = $roomId;
$_SESSION['roomName']      = $roomName;
$_SESSION['totalPrice']    = $price;
$_SESSION['checkin']       = $checkin;
$_SESSION['checkout']      = $checkout;
$_SESSION['guests']        = $guests;
$_SESSION['name']          = $name;
$_SESSION['email']         = $email;
$_SESSION['phone']         = $phone;
$_SESSION['pricePerNight'] = $pricePerNight;
// Generate a unique external reference for the Boxcoin transaction
$externalReference = 'booking-' . time(); // Using a timestamp as a unique reference for each booking

// Prepare response with Boxcoin-specific data (we'll send this to the client)
$response = [
    'external_reference' => $externalReference,
    'price'              => $price,
];

// Return the response as JSON to be used on the client-side
echo json_encode($response);
exit;
