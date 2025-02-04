<?php
    if (! isset($_GET['roomId'], $_GET['roomName'], $_GET['price'], $_GET['checkin'], $_GET['checkout'], $_GET['guests'])) {
        die("Invalid booking request.");
    }

    $roomId   = htmlspecialchars($_GET['roomId']);
    $roomName = htmlspecialchars($_GET['roomName']);
    $price    = htmlspecialchars($_GET['price']);
    $checkin  = htmlspecialchars($_GET['checkin']);
    $checkout = htmlspecialchars($_GET['checkout']);
    $guests   = htmlspecialchars($_GET['guests']);
?>
<style>
    .checkout-card p {
    font-size: 18px;
    margin: 10px 0;
}

/* Booking Form */
.booking-form {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: left;
}

.booking-form .form-group {
    margin-bottom: 15px;
}

.booking-form input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

/* Confirm Button */
.confirm-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: 0.3s;
}

.confirm-btn:hover {
    background: #0056b3;
}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Confirm Your Booking</h1>

        <div class="checkout-card">
            <p><strong>Room:</strong>                                                                                                                                                     <?php echo $roomName; ?></p>
            <p><strong>Price:</strong> <span style="color: #ff7b00; font-weight: bold;">$<?php echo $price; ?></span> per night</p>
            <p><strong>Check-in:</strong>                                                                                                                                                                     <?php echo $checkin; ?></p>
            <p><strong>Check-out:</strong>                                                                                                                                                                         <?php echo $checkout; ?></p>
            <p><strong>Guests:</strong>                                                                                                                                                             <?php echo $guests; ?></p>
        </div>

        <form class="booking-form" action="create_checkout_session.php" method="POST">
            <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">
            <input type="hidden" name="roomName" value="<?php echo $roomName; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
            <input type="hidden" name="guests" value="<?php echo $guests; ?>">

            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" placeholder="Enter your phone number" required>
            </div>

            <button class="confirm-btn" type="submit">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>
