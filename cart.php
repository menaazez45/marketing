<?php
session_start();
include("connect.php");

// التحقق من وجود العربة في الجلسة
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "عربتك فارغة.";
    exit;
}

// حذف منتج من العربة
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

// تعديل كمية المنتج
if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>العربة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
        }
        .action-btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .update-btn {
            background-color: #4CAF50;
        }
        .remove-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<h2 style="text-align: center;">العربة</h2>

<table>
    <tr>
        <th>الصورة</th>
        <th>اسم المنتج</th>
        <th>الوصف</th>
        <th>السعر</th>
        <th>الكمية</th>
        <th>الإجمالي</th>
        <th>إجراءات</th>
    </tr>
    <?php
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "' width='50'></td>";
        echo "<td>" . htmlspecialchars($item['name']) . "</td>";
        echo "<td>" . htmlspecialchars($item['descrip']) . "</td>";
        echo "<td>" . htmlspecialchars($item['price']) . " جنيه</td>";
        echo "<td>";
        echo "<form action='cart.php' method='post'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($item['id']) . "'>";
        echo "<input type='number' name='quantity' value='" . htmlspecialchars($item['quantity']) . "' min='1' class='quantity-input'>";
        echo "</td>";
        echo "<td>" . htmlspecialchars($subtotal) . " جنيه</td>";
        echo "<td>";
        echo "<input type='submit' name='update' value='تحديث' class='action-btn update-btn'>";
        echo "<input type='submit' name='remove' value='إزالة' class='action-btn remove-btn'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
    <tr>
        <td colspan="5" style="text-align: right;">الإجمالي:</td>
        <td colspan="2"><?php echo htmlspecialchars($total); ?> جنيه</td>
    </tr>
</table>

<div style="text-align: center; margin: 20px;">
    <a href="checkout.php">الانتقال إلى صفحة الدفع</a>
</div>

</body>
</html>
