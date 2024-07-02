<!DOCTYPE html>
<html>
<head>
    <title>عرض المنتجات</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            float: right; /* تحديد الموقع على اليمين */
            margin-left: 20px; /* ترك مسافة من اليمين لتفادي التداخل */
        }
        th, td {
            border: px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    include("connect.php");

    // استعلام لاسترداد بيانات المنتجات
    $sql = "SELECT * FROM more";
    $result = mysqli_query($conn, $sql);

    // التحقق من وجود بيانات
    if (mysqli_num_rows($result) > 0) {
        // عرض البيانات في جدول HTML
        echo "<h2>المنتجات:</h2>";
        echo "<table>
        <tr>
        <th>الرقم التعريفي</th>
        <th>الاسم</th>
        <th>الصوره</th>
        <th>الوصف</th>
        <th>السعر</th>
        </tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td><img src='" . $row['image'] . "' width='100' height='100'></td>";
            echo "<td>" . $row['descrip'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "لا توجد منتجات";
    }

    // إغلاق الاتصال
    mysqli_close($conn);
    ?>
</body>
</html>
