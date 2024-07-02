<?php
session_start();
include("connect.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $userId = $_SESSION['user_id'];

    // التحقق من أن المنتج ينتمي إلى المستخدم الحالي
    $sql = "SELECT * FROM products WHERE id = $productId AND user_id = $userId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // استرجاع القيم من النموذج
        $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
        $productDescrip = mysqli_real_escape_string($conn, $_POST['product_descrip']);
        $productPrice = mysqli_real_escape_string($conn, $_POST['product_price']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $color = mysqli_real_escape_string($conn, $_POST['color']);

        // تحديث البيانات في قاعدة البيانات
        $sql = "UPDATE products SET name = '$productName', descrip = '$productDescrip', price = '$productPrice', country = '$country', color = '$color' WHERE id = $productId AND user_id = $userId";

        if (mysqli_query($conn, $sql)) {
            $update_successful = true;
        } else {
            $update_successful = false;
        }

        // تحديث الصورة إذا تم تحميلها
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES['product_image']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // تحقق من نوع الملف
            $check = getimagesize($_FILES['product_image']['tmp_name']);
            if ($check !== false) {
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                    // تحديث مسار الصورة في قاعدة البيانات
                    $sql = "UPDATE products SET image = '$targetFile' WHERE id = $productId AND user_id = $userId";
                    mysqli_query($conn, $sql);
                }
            }
        }
    } else {
        $update_successful = false;
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تحديث المنتج</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = "shop.php";
        }, 5000);
    </script>
</head>
<body>
    <?php if ($update_successful): ?>
        <h2>تم تحديث المنتج بنجاح. سيتم تحويلك إلى صفحة المنتجات بعد 5 ثوانٍ.</h2>
    <?php else: ?>
        <h2>حدث خطأ أثناء تحديث المنتج. يرجى المحاولة مرة أخرى.</h2>
    <?php endif; ?>
</body>
</html>
