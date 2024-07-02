<?php
session_start();
include("connect.php");

// التحقق من وجود user_id في الجلسة أو في الطلب GET
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    die("User ID not defined.");
}

// استعلام لاسترداد معلومات المستخدم
$user_id_safe = mysqli_real_escape_string($conn, $user_id);
$user_sql = "SELECT username FROM users WHERE id = '$user_id_safe'";
$user_result = mysqli_query($conn, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);

// استعلام لاسترداد منتجات المستخدم
$sql = "SELECT * FROM products WHERE user_id = '$user_id_safe'";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang='ar'>
<head>
    <meta charset='UTF-8'>
    <title>منتجاتي</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        header p {
            margin: 5px 0 10px;
            font-size: 18px;
        }
        header a {
            color: #fff;
            background-color: #007bff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 10px;
            display: inline-block;
        }
        header a:hover {
            background-color: #0056b3;
        }
        main {
            margin-top: 60px; /* تعديل ارتفاع الرأس لضمان رؤية الجدول */
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto; /* محاذاة الصورة في المنتصف عند التصغير */
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        @media screen and (max-width: 600px) {
            header {
                position: static;
            }
            main {
                margin-top: 20px; /* تعديل ارتفاع الرأس لضمان رؤية الجدول */
            }
            table {
                font-size: 14px;
            }
            img {
                max-width: 80px;
                max-height: 80px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>منتجاتي</h1>
        <p>مرحبا، <?php echo htmlspecialchars($user_data['username']); ?></p>
        <a href='view_orders.php?user_id=<?php echo htmlspecialchars($user_id); ?>'>عرض الطلبات</a>
        <a href='your orders.php?user_id=<?php echo htmlspecialchars($user_id); ?>'>عرض منتجاتي</a>
    </header>
    <main>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <tr>
                    <th>الرقم التعريفي</th>
                    <th>اسم المنتج</th>
                    <th>الصورة</th>
                    <th>الوصف</th>
                    <th>السعر</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><img src='<?php echo htmlspecialchars($row['image']); ?>' alt='<?php echo htmlspecialchars($row['name']); ?>'></td>
                        <td><?php echo htmlspecialchars($row['descrip']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?> جنيه</td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>لا توجد منتجات</p>
        <?php } ?>
    </main>
</body>
</html>

<?php
// إغلاق الاتصال
mysqli_close($conn);
?>
