<?php
// تحقق من زر الإرسال
if(isset($_POST['submit'])) {
    // بيانات قاعدة البيانات
    include("connect.php");
  
    // الحصول على بيانات المستخدم من نموذج إنشاء الحساب
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $country_code = $_POST['country_code'];

    // التحقق مما إذا كان اسم المستخدم أو البريد الإلكتروني موجود بالفعل
    $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' OR phone = '$phone'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        echo "اسم المستخدم أو البريد الإلكتروني او رقم الهاتف موجود بالفعل!";
    } else {
        // التحقق من مطابقة كلمات المرور
        if ($password !== $confirm_password) {
            echo "كلمات المرور غير متطابقة!";
        } else {
            // استعلام لإدخال بيانات المستخدم إلى قاعدة البيانات
            $sql = "INSERT INTO users (username, email, password, phone, country_code) VALUES ('$username', '$email', '$password', '$phone', '$country_code')";

            if (mysqli_query($conn, $sql)) {
                echo "تم إنشاء الحساب بنجاح!";
                header("Location: index.php");
                exit(); // 
            } else {
                echo "خطأ: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
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
    <title>إنشاء حساب</title>
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
        input[type="text"],
        input[type="email"],
        input[type="password"] {
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
        #phone{
            width: 290px;
            height: 25px;
        }
    </style>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password !== confirmPassword) {
                alert("كلمات المرور غير متطابقة!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>إنشاء حساب جديد</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm();">
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">البريد الإلكتروني:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">تأكيد كلمة المرور:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        
        <label for="country_code">رمز الدولة:</label>
        <input id="country_code" type="text" name="country_code" pattern="[0-9]+" title="الرجاء إدخال رمز الدولة بشكل صحيح" required>

        <label for="phone">رقم الهاتف:</label>
        <input id="phone" type="tel" name="phone" pattern="[0-9]+" title="الرجاء إدخال أرقام فقط لرقم الهاتف" required><br><br>
        
        <input type="submit" name="submit" value="إنشاء الحساب">
    </form>
    <br>
    <a href="index.php">تسجيل الدخول</a>
</body>
</html>
