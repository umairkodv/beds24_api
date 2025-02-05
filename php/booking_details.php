<?php
    session_start(); // Start the session

    // Check if required parameters are passed
    if (! isset($_GET['roomId'], $_GET['roomName'], $_GET['price'], $_GET['checkin'], $_GET['checkout'], $_GET['guests'])) {
        die("Invalid booking request.");
    }

    $roomId     = $_GET['roomId'];
    $roomName   = $_GET['roomName'];
    $totalPrice = $_GET['price'];
    $checkin    = $_GET['checkin'];
    $checkout   = $_GET['checkout'];
    $guests     = $_GET['guests'];

    // Convert dates to DateTime objects
    $checkinDate  = new DateTime($checkin);
    $checkoutDate = new DateTime($checkout);

    // Calculate total nights
    $totalNights = $checkinDate->diff($checkoutDate)->days;

    // Extra fees (e.g., cleaning fees)
    $cleaningFee = 3;
    $totalPrice += $cleaningFee;

    // Discount (currently set to zero)
    $discount = 0;
    $totalPrice -= $discount;

    // Calculate price per night
    $pricePerNight = $totalPrice / ($totalNights * $guests);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .checkout-card p { font-size: 18px; margin: 10px 0; }
        .booking-form { background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); text-align: left; }
        .booking-form .form-group { margin-bottom: 15px; margin-left: 15px; }
        .booking-form input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }

        /* Align form fields in a row */
        .form-group-inline {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .form-group-inline .form-group {
            flex: 1;
        }

        .confirm-btn { background: #007bff; color: white; border: none; padding: 12px 20px; font-size: 18px; border-radius: 5px; cursor: pointer; width: 100%; transition: 0.3s; }
        .confirm-btn:hover { background: #0056b3; }

        /* Align coupon field and button in a row */
        .coupon-container {
            display: flex;
            justify-content: space-between;
            gap: 45px;
        }

        .coupon-container .form-group {
            flex: 1;
        }

        .coupon-btn { background: #28a745; color: white;
    border: none;
    padding: 12px 13px 12px 8px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s; }
        .coupon-btn:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Confirm Your Booking</h1>

        <div class="checkout-card">
            <p><strong>Room:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php echo $roomName; ?></p>
            <p><strong>Price per Night:</strong> <span style="color: #ff7b00; font-weight: bold;">$<?php echo number_format($pricePerNight, 2); ?></span></p>
            <p><strong>Check-in:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php echo $checkin; ?></p>
            <p><strong>Check-out:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php echo $checkout; ?></p>
            <p><strong>Total Nights:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php echo $totalNights; ?></p>
            <p><strong>Guests:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php echo $guests; ?></p>
            <p><strong>Cleaning Fee:</strong> <span style="color: #ff7b00; font-weight: bold;">$<?php echo number_format($cleaningFee, 2); ?></span></p>
            <p><strong>Discount:</strong> <span style="color: #ff7b00; font-weight: bold;">$<?php echo number_format($discount, 2); ?></span></p>
            <p><strong>Total Price (including fees and discounts):</strong> <span style="color: #ff7b00; font-weight: bold;">$<?php echo number_format($totalPrice, 2); ?></span></p>
        </div>


        <form id="booking-form" class="booking-form" method="POST">
            <input type="hidden" name="roomId" value="<?php echo $roomId; ?>">
            <input type="hidden" name="roomName" value="<?php echo $roomName; ?>">
            <input type="hidden" name="pricePerNight" value="<?php echo $pricePerNight; ?>">
            <input type="hidden" name="totalNights" value="<?php echo $totalNights; ?>">
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
            <input type="hidden" name="guests" value="<?php echo $guests; ?>">

            <div class="form-group-inline">
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
            </div>

            <!-- Coupon Code -->
            <div class="coupon-container">
                <div class="form-group">
                    <label for="coupon">Coupon Code:</label>
                    <input type="text" id="coupon" name="coupon" placeholder="Enter coupon code" />
                </div>
                <button type="button" class="coupon-btn" onclick="verifyCoupon()">Verify</button>
            </div>

            <p id="coupon-message" style="color: red;"></p>

            <button class="confirm-btn" type="submit">Proceed to Payment</button>
        </form>
    </div>

    <script>
        function verifyCoupon() {
            const couponCode = document.getElementById('coupon').value;
            const couponMessage = document.getElementById('coupon-message');

            // Simulate coupon verification
            if (couponCode === 'DISCOUNT10') {
                couponMessage.textContent = 'Coupon is valid! You get a 10% discount.';
            } else {
                couponMessage.textContent = 'Coupon is not valid.';
            }
        }
    </script>
</body>
</html>
<script>
document.querySelector('.booking-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('create_checkout_session.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response:', response);  // Log the response for debugging
        return response.json(); // Parse the response once
    })
    .then(data => {
        console.log('Response Data:', data);  // Log the parsed JSON response

        if (data && data.external_reference && data.price) {
            sessionStorage.setItem('external_reference', data.external_reference);
            sessionStorage.setItem('price', data.price);
            sessionStorage.setItem('roomId', "<?php echo $roomId; ?>");
            sessionStorage.setItem('roomName', "<?php echo $roomName; ?>");
            sessionStorage.setItem('totalPrice', "<?php echo $totalPrice; ?>");
            sessionStorage.setItem('checkin', "<?php echo $checkin; ?>");
            sessionStorage.setItem('checkout', "<?php echo $checkout; ?>");
            sessionStorage.setItem('guests', "<?php echo $guests; ?>");

            window.location.href = 'checkout.php';
        } else {
            alert('Error: Invalid response from the server');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
});




</script>