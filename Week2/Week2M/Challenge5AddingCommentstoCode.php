<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $price = 50;# Initial price of the item
        $discount = 10;/* Discount amount to be subtracted from the price */
        $finalPrice = $price - $discount; // Calculate final price after discount
        echo "Total price: $". $finalPrice;
    ?>
</body>
</html>