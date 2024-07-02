<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // التحقق من بيانات تسجيل الدخول
    $sql = "SELECT id FROM users WHERE username='$username' AND email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];

        // إعداد ملف تعريف ارتباط
        $cookie_name = "user_login";
        $cookie_value = $row['id'];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // ينتهي بعد 30 يوم

        header("Location: shop.php"); // تحويل المستخدم إلى صفحة mm
        exit();
    } else {
        $error_message = "خطأ في البريد الإلكتروني أو كلمة المرور.";
    }
}

// إغلاق الاتصال
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <style>
        /* أسلوب التنسيق */
    </style>
</head>
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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
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
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            width: 100%;
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
        .link {
            margin-top: 10px;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        <?php if (isset($error_message)) { echo '<div class="error">'.$error_message.'</div>'; } ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required>
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="تسجيل الدخول">
        </form>
        <div class="link">
            <a href="creat.php">إنشاء حساب</a>
        </div>
    </div>
</body>
</html>