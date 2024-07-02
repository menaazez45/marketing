<?php
session_start();
include("connect.php");

// الحصول على معرف الناشر من الجلسة
$publisher_id = $_SESSION['publisher_id'];

// استعلام لجلب الطلبات ومعلومات المستخدمين
$sql = "SELECT orders.product_id, orders.customer_name, orders.customer_email, orders.customer_address, 
               orders.payment_method, orders.order_date, orders.product_descrip, orders.product_name, 
               orders.order_status, orders.quantity 
        FROM orders 
        JOIN products ON orders.product_id = products.id 
        WHERE products.publisher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $publisher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الطلبات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            margin: 40px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        select {
            padding: 8px;
            border-radius: 5px;
        }
        .status-select {
            width: 150px;
        }
        .delete-btn {
            background-color: #ff4c4c;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>
<header>
    <h1>عرض الطلبات</h1>
</header>

<table>
    <tr>
        <th>رقم المنتج</th>
        <th>اسم العميل</th>
        <th>البريد الإلكتروني</th>
        <th>عنوان العميل</th>
        <th>طريقة الدفع</th>
        <th>تاريخ الطلب</th>
        <th>اسم المنتج</th>
        <th>وصف المنتج</th>
        <th>الكميه</th>
        <th>حالة الطلب</th>
        <th>الإجراء</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_descrip']) . "</td>";
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
        echo "<td>";
        echo "<form action='update_order_status.php' method='post'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
        echo "<select name='order_status' class='status-select'>";
        echo "<option value='يجب المراجعة' " . ($row['order_status'] == 'يجب المراجعة' ? 'selected' : '') . ">يجب المراجعة</option>";
        echo "<option value='قيد العمل' " . ($row['order_status'] == 'قيد العمل' ? 'selected' : '') . ">قيد العمل</option>";
        echo "<option value='قيد التسليم' " . ($row['order_status'] == 'قيد التسليم' ? 'selected' : '') . ">قيد التسليم</option>";
        echo "<option value='تم تسليمه' " . ($row['order_status'] == 'تم تسليمه' ? 'selected' : '') . ">تم تسليمه</option>";
        echo "</select>";
        echo "<input type='submit' value='حفظ'>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<form action='delete_order.php' method='post'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
        echo "<input type='submit' value='حذف' class='delete-btn'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
