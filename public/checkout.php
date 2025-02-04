<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Checkout</h1>
    <?php
        $checkin = $_GET['checkin'] ?? '';
        $checkout = $_GET['checkout'] ?? '';
        $amount = $_GET['amount'] ?? '0';
    ?>

    <p>Check-in Date: <?php echo htmlspecialchars($checkin); ?></p>
    <p>Check-out Date: <?php echo htmlspecialchars($checkout); ?></p>
    <p>Total Amount: $<?php echo htmlspecialchars($amount); ?></p>

    <button>Confirm Booking</button>
</body>
</html>
