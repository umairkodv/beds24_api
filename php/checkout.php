<?php
    session_start(); // Start the session

    // Check if the payment was successful by looking for Boxcoin response parameters
    if (isset($_GET['cc'])) {
        // Debugging: Check session variables
        // Access session variables
        $roomId        = $_SESSION['roomId'] ?? '';
        $roomName      = $_SESSION['roomName'] ?? '';
        $totalPrice    = $_SESSION['totalPrice'] ?? 0;
        $checkin       = $_SESSION['checkin'] ?? '';
        $checkout      = $_SESSION['checkout'] ?? '';
        $guests        = $_SESSION['guests'] ?? 0;
        $pricePerNight = $_SESSION['pricePerNight'] ?? 0;
        $name          = $_SESSION['name'] ?? '';
        $email         = $_SESSION['email'] ?? '';
        $phone         = $_SESSION['phone'] ?? '';

        // echo $name;
        // die(); // You can remove this line after debugging

        // Assuming 'cc' means payment success, redirect to process_booking.php with required details
        header("Location: process_booking.php?payment_success=true&roomId=" . $roomId . "&roomName=" . urlencode($roomName) . "&totalPrice=" . $totalPrice . "&checkin=" . $checkin . "&checkout=" . $checkout . "&guests=" . $guests . "&name=" . urlencode($name) . "&email=" . $email . "&phone=" . $phone);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <h1 align="center">Complete Your Payment</h1>

    <div id="payment-container">
        <script id="boxcoin" src="https://www.wunderbar24.com/bc_payment_test/js/client.js"></script>
        <center>
            <div id="boxcoin-payment"></div>
        </center>
    </div>

    <script>
    // Retrieve session data
    const externalReference = sessionStorage.getItem('external_reference');
    const price = sessionStorage.getItem('price');

    if (externalReference && price) {
        // Dynamically add Boxcoin payment button
        document.getElementById('boxcoin-payment').setAttribute("data-bxc", "custom-" + externalReference);
        document.getElementById('boxcoin-payment').setAttribute("data-price", price);
        document.getElementById('boxcoin-payment').setAttribute("data-external-reference", externalReference);

        // Listen for payment success (Assuming Boxcoin triggers an event)
        window.addEventListener("message", function(event) {
            if (event.data && event.data.status === "success") {
                window.location.href = "process_booking.php?payment_success=true&external_reference=" + externalReference;
            }
        }, false);
    } else {
        alert("Payment details not found. Please restart the booking process.");
        window.location.href = "booking_process.php";
    }
</script>

</body>
</html>
