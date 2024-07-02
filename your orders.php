<?php
session_start();
include("connect.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id']; // يفترض أن user_id مخزن في الجلسة

// التحقق من أن المستخدم قام بتسجيل الدخول
if (!isset($user_id)) {
    echo "يرجى تسجيل الدخول لعرض الطلبات.";
    exit;
}

// جلب الطلبات من قاعدة البيانات مع الانضمام بين الجدولين
$sql = "SELECT o.product_id, o.order_date, o.quantity, o.customer_name, p.name AS name, p.descrip AS descrip, o.product_id 
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الطلبات المقدمة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .orders-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .orders-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .order-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item h3 {
            margin: 0;
            font-size: 18px;
        }
        .order-item p {
            margin: 5px 0;
            color: #666;
        }
        .edit-delete-links {
            margin-top: 10px;
        }
        .edit-delete-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .edit-delete-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="orders-container">
    <h2>الطلبات المقدمة</h2>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="order-item">';
            echo '<h3>المنتج: ' . $row['name'] . '</h3>';
            echo '<p>وصف المنتج: ' . $row['descrip'] . '</p>';
            echo '<p>الكمية: ' . $row['quantity'] . '</p>';
            echo '<p>الاسم الكامل: ' . $row['customer_name'] . '</p>';
            echo '<p>تاريخ الطلب: ' . $row['order_date'] . '</p>';
            
            // روابط تعديل وحذف الطلب
            echo '<div class="edit-delete-links">';
            echo '<a href="edit_order.php?id=' . $row['product_id'] . '">تعديل</a>';
            echo '<a href="delete_order.php?id=' . $row['product_id'] . '">حذف</a>';
            echo '</div>';
            
            echo '</div>';
        }
    } else {
        echo '<p>لم تقم بتقديم أي طلبات بعد.</p>';
    }
    ?>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
