<?php
session_start();
include("connect.php");

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Prepare the data for insertion into the orders table
    $customer_name = $_POST['name'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];
    $payment_method = $_POST['payment'];
    $order_date = date('Y-m-d H:i:s'); // Current date and time

    // Insert each product in the cart into the orders table
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        $product_name = $item['name'];
        $product_descrip = $item['descrip'];
        $quantity = $item['quantity']; // Assuming quantity is part of each item in the cart

        // SQL query to insert into orders table
        $insert_query = "INSERT INTO orders (customer_name, customer_email, customer_address, payment_method, order_date, product_name, product_descrip, quantity)
                         VALUES ('$customer_name', '$customer_email', '$customer_address', '$payment_method', '$order_date', '$product_name', '$product_descrip', '$quantity')";

        // Execute the insert query
        if (mysqli_query($conn, $insert_query)) {
            // Order successfully inserted
            echo "تم ارسال الطلب بنجاح!";
        } else {
            // Handle any errors, including duplicate primary key
            if (mysqli_errno($conn) == 1062) {
                echo "حدث خطأ: تم بالفعل تسجيل الطلب.";
            } else {
                echo "حدث خطأ: " . mysqli_error($conn);
            }
        }
    }

    // Clear the cart after successful insertion
    unset($_SESSION['cart']);
} else {
    echo "عربة التسوق فارغة!";
}

mysqli_close($conn);
?>
