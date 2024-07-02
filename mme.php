<?php
session_start();
include("connect.php");






// Retrieve orders from the database
$sql = "SELECT product_id, customer_name, customer_email, customer_address, payment_method, order_date, product_descrip, product_name FROM orders";
$result = mysqli_query($conn, $sql);

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
            width: 90%;
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
        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #0056b3;
        }
        form {
            display: inline;
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
        <th>وصف المنتج</th>
        <th>اسم المنتج</th>
        <th>الإجراء</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_descrip']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>";
        echo "<form action='delete_order.php' method='post' onsubmit='return confirm(\"هل أنت متأكد أنك تريد حذف هذا الطلب؟\");'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
        echo "<input type='submit' value='حذف'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
<?php
mysqli_close($conn);
?>
