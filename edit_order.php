<?php
session_start();
include("connect.php");


$user_id = $_SESSION['user_id']; // يفترض أن user_id مخزن في الجلسة

// التحقق من أن المستخدم قام بتسجيل الدخول
if (!isset($user_id)) {
    echo "يرجى تسجيل الدخول لتعديل الطلب.";
    exit;
}

// التحقق من وجود معرف الطلب في الرابط
if (!isset($_GET['id'])) {
    echo "معرف الطلب غير محدد.";
    exit;
}

$product_id = $_GET['id'];

// جلب بيانات الطلب من قاعدة البيانات
$sql = "SELECT * FROM orders WHERE product_id = '$product_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "لا يمكن العثور على الطلب.";
    exit;
}

$row = mysqli_fetch_assoc($result);

// إذا تم إرسال نموذج التعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];
    $phone = $_POST['phone'];
    $color = $_POST['color'];
    $payment_method = $_POST['payment_method'];

    // تحديث بيانات الطلب في قاعدة البيانات
    $update_sql = "UPDATE orders SET customer_name = '$customer_name', customer_email = '$customer_email', customer_address = '$customer_address', phone = '$phone', color = '$color', payment_method = '$payment_method' WHERE product_id = '$product_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "تم تعديل الطلب بنجاح!";
    } else {
        echo "حدث خطأ أثناء تعديل الطلب: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل الطلب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .edit-form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .edit-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="edit-form">
    <h2>تعديل الطلب</h2>
    <form action="edit_order.php?id=<?php echo $product_id; ?>" method="post">
        <div class="form-group">
            <label for="customer_name">الاسم الكامل:</label>
            <input type="text" id="customer_name" name="customer_name" value="<?php echo $row['customer_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="customer_email">البريد الإلكتروني:</label>
            <input type="email" id="customer_email" name="customer_email" value="<?php echo $row['customer_email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="customer_address">عنوان الشحن:</label>
            <input type="text" id="customer_address" name="customer_address" value="<?php echo $row['customer_address']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">رقم الهاتف:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
        </div>
        <div class="form-group">
            <label for="color">اللون:</label>
            <input type="text" id="color" name="color" value="<?php echo $row['color']; ?>" required>
        </div>
        <div class="form-group">
            <label for="payment_method">طريقة الدفع:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="cash_on_delivery" <?php if ($row['payment_method'] == 'cash_on_delivery') echo 'selected'; ?>>الدفع عند الاستلام</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="edit" value="حفظ التعديلات">
        </div>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
