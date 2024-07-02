<?php
session_start();
include("connect.php");

// التحقق من وجود العربة في الجلسة
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "عربتك فارغة.";
    exit;
}

// التحقق من إرسال نموذج الشراء
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // تنظيف واستخدام mysqli_real_escape_string للبيانات المدخلة
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $order_date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id']; // يفترض أنه مخزن في الجلسة
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);

    // إضافة الطلبات إلى قاعدة البيانات
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];

        // استعلام INSERT مع ON DUPLICATE KEY UPDATE
        $sql = "INSERT INTO orders (product_id, quantity, order_date, customer_name, customer_email, customer_address, payment_method, user_id, phone, color) 
                VALUES ('$product_id', '$quantity', '$order_date', '$customer_name', '$customer_email', '$customer_address', '$payment_method', '$user_id', '$phone', '$color')
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        
        mysqli_query($conn, $sql);
    }

    // إفراغ العربة بعد الشراء
    unset($_SESSION['cart']);

    echo "تم تقديم الطلب بنجاح!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إتمام الشراء</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .checkout-form {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .checkout-form h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="checkout-form">
    <h2>إتمام الشراء</h2>
    <form action="checkout.php" method="post">
        <div class="form-group">
            <label for="customer_name">الاسم الكامل:</label>
            <input type="text" id="customer_name" name="customer_name" required>
        </div>
        <div class="form-group">
            <label for="customer_email">البريد الإلكتروني:</label>
            <input type="email" id="customer_email" name="customer_email" required>
        </div>
        <div class="form-group">
            <label for="customer_address">عنوان الشحن:</label>
            <input type="text" id="customer_address" name="customer_address" required>
        </div>
        <div class="from-group">
            <label for="phone">:رقم الهاتف</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        <br>
        <div class="form-group">
            <label for="color">:اللون</label>
            <input type="text" id="color" name="color" required>
        </div>
        <div class="form-group">
            <label for="payment_method">طريقة الدفع:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="cash_on_delivery">الدفع عند الاستلام</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="checkout" value="إتمام الشراء">
        </div>
    </form>
</div>

</body>
</html>
<?php
mysqli_close($conn);
?>
