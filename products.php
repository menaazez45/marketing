<?php
session_start();
include("connect.php");

// استعلام SQL لاسترجاع المنتجات من قاعدة البيانات
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// التحقق من إرسال نموذج الإضافة إلى العربة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    // استرجاع بيانات المنتج من قاعدة البيانات
    $id = $_POST['product_id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $query_result = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_result) > 0) {
        $product = mysqli_fetch_assoc($query_result);
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $user_id = $_SESSION['user_id']; // بافتراض أن معرف المستخدم مخزن في الجلسة

        // إضافة المنتج إلى الجلسة
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'descrip' => $product['descrip'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity,
            'user_id' => $user_id
        ];

        // إعادة توجيه المستخدم إلى صفحة العربة بعد الإضافة
        header('Location: cart.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>صفحة المنتجات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 10%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            overflow-x: auto; /* تمكين التمرير الأفقي عند الحاجة */
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            white-space: nowrap; /* منع الفواصل الزائدة عند التمرير الأفقي */
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
        }
        .color-circle {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .action-links {
            text-align: center;
            margin-top: 10px;
        }
        .delete-link, .edit-link {
            color: red;
            cursor: pointer;
            margin-right: 10px;
        }
        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }
            img {
                max-width: 80px;
            }
            .quantity-input {
                width: 40px;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>صفحة المنتجات</h1>
</header>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<table>";

    echo "<tr><th>الصورة</th><th>اسم المنتج</th><th>الوصف</th><th>السعر</th><th>الكمية</th><th>الإضافة إلى العربة</th><th>التعديل</th><th>الحذف</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "'></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['descrip'] . "</td>";
        echo "<td>" . $row['price'] . " جنيه</td>";
        echo "<td>";
        echo "<form action='products.php' method='post'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' class='quantity-input'>";
        echo "</td>";
        echo "<td>";
        echo "<input type='submit' value='إضافة إلى العربة'>";
        echo "</form>";
        echo "</td>";
        echo "<td><a href='edit_product.php?id=" . $row['id'] . "' class='edit-link'>تعديل</a></td>";
        echo "<td><a href='delete_product.php?id=" . $row['id'] . "' class='delete-link'>حذف</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center;'>لا توجد منتجات</p>";
}

mysqli_close($conn);
?>
</body>
</html>

