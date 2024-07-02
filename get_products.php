<?php
include("connect.php");

// استقبال القيم المرسلة عبر الطلب GET
$startIndex = $_GET['start'];
$endIndex = $_GET['end'];

// استعلام لاسترداد بيانات المنتجات مع اسم المستخدم الذي نشرها
$sql = "SELECT products.*, users.username 
        FROM products 
        JOIN users ON products.user_id = users.id 
        LIMIT $startIndex, $endIndex";
$result = mysqli_query($conn, $sql);

// التحقق من وجود بيانات
if (mysqli_num_rows($result) > 0) {
    // عرض البيانات في جدول HTML
    echo "<table>
        <tr>
        <th>الرقم التعريفي</th>
        <th>اسم المنتج</th>
        <th>الصورة</th>
        <th>الوصف</th>
        <th>السعر</th>
        <th>الناشر</th>
        <th>شراء</th>
        <th>تعديل</th>
        <th>حذف</th>
        <th>الكمية</th>
        </tr>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td><img src='" . $row['image'] . "' width='100' height='100'></td>";
        echo "<td>" . $row['descrip'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['username'] . "</td>"; // عرض اسم المستخدم
        // تحويل المستخدم إلى صفحة cart.php مع تفاصيل المنتج
        echo "<td><a href='cart.php?product_id=" . $row['id'] . "&name=" . urlencode($row['name']) . "&price=" . $row['price'] . "&image=" . urlencode($row['image']) . "'>شراء</a></td>";
        // إضافة زر تعديل
        echo "<td><a href='edit_product.php?product_id=" . $row['id'] . "'>تعديل</a></td>";
        // إضافة زر حذف
        echo "<td><a href='delete_product.php?product_id=" . $row['id'] . "'>حذف</a></td>";
        // إضافة زر إضافة إلى عربة التسوق
        echo "<td><form method='post' action='cart.php'>";
        echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' required>";
        echo "<input type='submit' value='إضافة إلى العربة'>";
        echo "</form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "لا توجد منتجات";
}

// إغلاق الاتصال
mysqli_close($conn);
?>
<br>
