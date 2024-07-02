<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
</head>
<body>
    <?php
    // البيانات الخاصة بالاتصال بقاعدة البيانات
  include("connect.php");

    // التحقق من البيانات المرسلة عبر النموذج POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $descrip = $_POST['descrip'];
        $image = $_POST['image'];
        $price = $_POST['price'];

        // استعداد استعلام SQL لإدراج البيانات
        $sql = "INSERT INTO `products`( `name`, `image`, `descrip`, `price`) VALUES ('$name','$image','$descrip','$price')";

        if (mysqli_query($conn, $sql)) {
            echo "تمت إضافة المنتج بنجاح";
        } else {
            echo "خطأ في إضافة المنتج: " . mysqli_error($conn);
        }
    }
    ?>

    <h2>إضافة منتج</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
    اسم المنتج: <input type="text" name="name" required><br>
    الوصف: <textarea name="descrip" required></textarea><br>
    السعر: <input type="text" name="price" required><br>
    صورة المنتج: <input type="file" name="image" required><br>
    <input type="submit" name="include_page" value="Include Page">
</form>


    <?php
    // إغلاق الاتصال بقاعدة البيانات
    mysqli_close($conn);
    ?>
</body>
</html>
