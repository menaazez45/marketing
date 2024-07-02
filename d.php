<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المنتجات</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .buy-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>عرض المنتجات</h2>
    <table>
        <thead>
            <tr>
                
                <th>الاسم</th>
                <th>الصورة</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>شراء</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // اتصال بقاعدة البيانات
            include("connect.php");

            // استعلام لاسترداد بيانات المنتجات
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            // التحقق من وجود بيانات
            if (mysqli_num_rows($result) > 0) {
                // عرض البيانات
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                   
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td><img src='" . $row['image'] . "' width='100' height='100'></td>";
                    echo "<td>" . $row['descrip'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td><a href='cart.php?product_id=" . $row['id'] . "' class='buy-btn'>شراء</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>لا توجد منتجات</td></tr>";
            }

            // إغلاق الاتصال
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>

