<?php
session_start();
include("connect.php");

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الطلب</title>
</head>
<body>
    <h2>تم إتمام عملية الشراء بنجاح!</h2>
    <p>شكراً لشرائك. تم استقبال طلبك بنجاح وسيتم معالجته قريباً.</p>
    <a href="shop.php">العودة إلى قائمة المنتجات</a>
</body>
</html>
