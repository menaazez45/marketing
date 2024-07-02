<?php
session_start();
include("connect.php");

// التحقق من وجود جلسة مستخدم صالحة


$user_id = $_SESSION['user_id'];

// التحقق من وجود معرف المنتج في الطلب POST
if (!isset($_POST['product_id'])) {
    die("معرف المنتج غير محدد.");
}

$product_id = $_POST['product_id'];

// استعلام لاسترداد بيانات المنتج
$sql = "SELECT * FROM products WHERE id = '$product_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // استعراض البيانات المرسلة عبر الطلب POST
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $descrip = mysqli_real_escape_string($conn, $_POST['descrip']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // إذا تم تحديد ملف الصورة
    if ($_FILES['image']['size'] > 0) {
        $target_dir = "صور/"; // المجلد المستهدف لحفظ الصور
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // التحقق من صحة الصورة
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            die("لم يتم رفع ملف الصورة بنجاح.");
            $uploadOk = 0;
        }

        // التحقق من حجم الصورة
        if ($_FILES["image"]["size"] > 500000) {
            die("عذرًا، ملف الصورة كبير جدًا.");
            $uploadOk = 0;
        }

        // قبول أنواع الملفات الصور المسموح بها
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            die("عذرًا، فقط ملفات JPG, JPEG, PNG & GIF يمكن تحميلها.");
            $uploadOk = 0;
        }

        // إذا لم يحدث أي مشكلة، حاول تحميل الملف
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // قم بتحديث قاعدة البيانات مع اسم الملف
                $image_path = mysqli_real_escape_string($conn, $target_file);
                $update_sql = "UPDATE products 
                               SET name = '$name', descrip = '$descrip', price = '$price', image = '$image_path' 
                               WHERE id = '$product_id'";
                if (mysqli_query($conn, $update_sql)) {
                    echo "تم تحديث المنتج بنجاح.";
                } else {
                    echo "خطأ في تحديث المنتج: " . mysqli_error($conn);
                }
            } else {
                echo "عذرًا، حدث خطأ أثناء تحميل ملف الصورة.";
            }
        }
    } else {
        // إذا لم يتم تحديث الصورة، فقط قم بتحديث بقية البيانات
        $update_sql = "UPDATE products 
                       SET name = '$name', descrip = '$descrip', price = '$price' 
                       WHERE id = '$product_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "تم تحديث المنتج بنجاح.";
        } else {
            echo "خطأ في تحديث المنتج: " . mysqli_error($conn);
        }
    }
} else {
    echo "لا يمكن العثور على المنتج أو ليس لديك الصلاحية لتعديله.";
}

mysqli_close($conn);
?>
