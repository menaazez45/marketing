<?php
session_start();


include("connect.php");

// التحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    echo "<p>يجب تسجيل الدخول لعرض هذه الصفحة.</p>";
    exit();
}

// التحقق من وجود معلومات المنتج المراد تعديله
if (!isset($_GET['id'])) {
    echo "<p>لا يوجد معرف منتج محدد للتعديل.</p>";
    exit();
}

$productId = intval($_GET['id']); // تأكد من أن المعرف هو عدد صحيح
$userId = $_SESSION['user_id'];

// استعلام SQL لاسترجاع المنتج المحدد
$sql = "SELECT * FROM products WHERE id = $productId AND user_id = $userId";
$result = mysqli_query($conn, $sql);

// التحقق من وجود المنتج وأنه يتبع للمستخدم الحالي
if (mysqli_num_rows($result) != 1) {
    echo "<p>لا يمكن العثور على المنتج أو ليس لديك الصلاحية لتعديله.</p>";
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">تعديل المنتج</h2>

<form action="update_product.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['id']); ?>">
    
    <label for="product_name">اسم المنتج:</label><br>
    <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>"><br>
    
    <label for="product_descrip">الوصف:</label><br>
    <textarea id="product_descrip" name="product_descrip"><?php echo htmlspecialchars($row['descrip']); ?></textarea><br>
    
    <label for="product_price">السعر (بالجنيه المصري):</label><br>
    <input type="text" id="product_price" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>"><br>
    
    <label for="product_image">الصورة:</label><br>
    <input type="file" id="product_image" name="product_image"><br><br>

    <label for="country">لو محدود في دوله او مجموعة دول من فضلك اكتبهم هنا و لو مش محدود ممكن تكتب جميع الدول:</label><br>
    <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($row['country']); ?>"><br>

    <label for="color">اللون:</label><br>
    <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($row['color']); ?>"><br>
    
    <input type="submit" value="حفظ التعديلات">
</form>

</body>
</html>

<?php
mysqli_close($conn);
?>
