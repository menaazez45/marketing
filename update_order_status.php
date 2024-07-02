<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['order_status'])) {
    $product_id = $_POST['product_id'];
    $order_status = $_POST['order_status'];

    // SQL query to update the order status
    $update_query = "UPDATE orders SET order_status = '$order_status' WHERE product_id = $product_id";

    // Execute the update query
    if (mysqli_query($conn, $update_query)) {
        echo "تم تحديث حالة الطلب بنجاح!";
        header('Location: orders.php'); // إعادة التوجيه إلى صفحة عرض الطلبات
        exit();
    } else {
        echo "حدث خطأ: " . mysqli_error($conn);
    }
} else {
    echo "طلب غير صالح!";
}

mysqli_close($conn);
?>
