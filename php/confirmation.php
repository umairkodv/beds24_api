<?php
    // Get data passed from process_booking.php
    $roomName = htmlspecialchars($_GET['roomName']);
    $name     = htmlspecialchars($_GET['name']);
    $price    = htmlspecialchars($_GET['price']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .confirmation-details {
            margin-top: 20px;
        }

        .confirmation-details p {
            font-size: 18px;
            line-height: 1.6;
            margin: 8px 0;
            color: #555;
        }

        .price {
            color: #ff7b00;
            font-weight: bold;
            font-size: 20px;
        }

        .highlight {
            font-weight: bold;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin: 20px 0;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Booking Confirmation</h1>

        <div class="confirmation-details">
            <p><span class="highlight">Thank you,</span>                                                                                                                                                                         <?php echo $name; ?>!</p>
            <p>Your booking for <span class="highlight"><?php echo $roomName; ?></span> has been successfully confirmed.</p>
            <p><span class="highlight">Price:</span> <span class="price">$<?php echo $price; ?></span></p>

            <p>You will receive a confirmation email shortly.</p>

            <a href="../index.html" class="button">Back to Homepage</a>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for booking with us! We look forward to hosting you.</p>
        <p>&copy; 2025 Your Hotel Name</p>
    </div>

</body>
</html>
