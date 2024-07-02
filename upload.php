<?php
session_start();
include("connect.php");

// التحقق من وجود جلسة مستخدم صالحة
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['descrip']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
  //  $color = mysqli_real_escape_string($conn, $_POST['color']); // استقبال بيانات اللون من النموذج
    //$country = mysqli_real_escape_string($conn, $_POST['country']);

    // رفع الصورة
    $target_dir = "صور/"; // اسم المجلد هنا
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // التحقق من صحة الصورة
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        echo "تم رفع الصورة بنجاح - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $error_message = "لم يتم رفع الصوره بنجاح.";
        $uploadOk = 0;
    }

    // التحقق من حجم الصورة
    if ($_FILES["image"]["size"] > 90000000000000000000000000) {
        $error_message = "عذرًا، ملفك كبير جدًا.";
        $uploadOk = 0;
    }

    // التحقق من نوع الملف
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $error_message = "عذرًا، فقط ملفات JPG, JPEG, PNG & GIF يمكن تحميلها.";
        $uploadOk = 0;
    }

    // إذا كان هناك مشكلة في التحميل
    if ($uploadOk == 0) {
        $error_message = "عذرًا، ملفك لم يتم تحميله.";
    // إذا كان كل شيء على ما يرام، حاول تحميل الملف
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "تم حفظ " . htmlspecialchars(basename($_FILES["image"]["name"])) . ".";
        } else {
            $error_message = "عذرًا، حدث خطأ أثناء تحميل الصوره.";
        }
    }

    // إذا كانت لا توجد أخطاء في تحميل الصورة وكان هناك user_id، قم بإدراج بيانات المنتج في قاعدة البيانات
    if (empty($error_message) && isset($user_id)) {
        $image = mysqli_real_escape_string($conn, $target_file);
        // استعلام لإدخال بيانات المنتج إلى قاعدة البيانات
        $sql = "INSERT INTO products (user_id, name, descrip, price, image) VALUES ('$user_id', '$name', '$description', '$price', '$image')";

        if (mysqli_query($conn, $sql)) {
            echo "تم نشر المنتج بنجاح!";
        } else {
            $error_message = "خطأ في نشر المنتج: " . mysqli_error($conn);
        }
    } elseif (empty($error_message)) {
        $error_message = "حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.";
    }
}

// إغلاق الاتصال
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نشر منتج جديد</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }
        input[type="text"],
        textarea,
        input[type="number"],
        input[type="file"] {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>نشر منتج جديد</h2>
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="name">اسم المنتج:</label>
            <input type="text" id="name" name="name" required>
            <label for="descrip">الوصف:</label>
            <textarea id="descrip" name="descrip" rows="4" required placeholder="يرجي زكر الالوان و الدول"></textarea>
            <!-- <label for="country">لو محدود في دوله او مجموعة دول من فضلك اكتبهم هنا و لو مش محدود ممكن تكتب جميع الدول :</label>
            <input type="text" id="country" name="country"> -->
            <label for="price">السعر:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
            <label for="image">الصورة:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <!-- <label for="color">اللون:</label>
            <input type="text" id="color" name="color" required> -->
            <input type="submit" value="نشر المنتج">
        </form>
    </div>
</body>
</html>