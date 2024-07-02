<?php
// تحقق من زر الإرسال
if (isset($_POST['submit'])) {
    // بيانات قاعدة البيانات
    include("connect.php");
    
    // الحصول على بيانات المستخدم من نموذج إنشاء الحساب
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = '';

    // التحقق من رفع الصورة
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
        // تحديد مسار التخزين للصور المرفوعة
        $target_dir = "صور/";
        $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // التحقق من نوع الملف
        $check = getimagesize($_FILES["image_path"]["tmp_name"]);
        if ($check !== false) {
            // نقل الملف إلى المسار المحدد
            if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "خطأ في رفع الملف.";
                exit;
            }
        } else {
            echo "الملف ليس صورة.";
            exit;
        }
    }

    // استعلام لإدخال بيانات المستخدم إلى قاعدة البيانات
    $sql = "INSERT INTO send2 (title, content, image_path) VALUES ('$title', '$content', '$image_path')";

    if (mysqli_query($conn, $sql)) {
        echo "تم الارسال بنجاح!";
        header("Location: showm.php");
        exit();
    } else {
        echo "خطأ: " . $sql . "<br>" . mysqli_error($conn);
    }

    // إغلاق الاتصال
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال رساله</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            text-align: right;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>ارسال رساله</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="title">العنوان</label>
        <input type="text" name="title" required>

        <label for="content">المحتوي</label>
        <input type="text" name="content" required>

        <label for="image">الصوره</label>
        <input type="file" name="image_path" accept="image/*">

        <input type="submit" name="submit" value="ارسال">
    </form>
    <br>
</body>
</html>
