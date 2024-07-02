

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        /* أسلوب CSS للصورة */
        img {
            border: 1px solid #ccc; /* إضافة حدود */
            max-width: 200px; /* تحديد العرض الأقصى للصورة */
            height: auto; /* السماح للصورة بالتكيف مع الارتفاع الطبيعي */
        }

        /* أسلوب CSS لعناصر الـ div التي تحتوي على المنتجات */
        .product {
            display: inline-block; /* عرض العناصر جنبًا إلى جنب */
            margin: 10px; /* تباعد بين العناصر */
            vertical-align: top; /* تحديد محاذاة العناصر لأعلى */
        }
    </style>
</head>
<body>
    <h1>Product Details</h1>
    <?php
        include("connect.php");

        // Fetch products from the database
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<img src='" . $row["image"] . "' alt='Product Image'>";
                echo "<h2>" . $row["name"] . "</h2>";
                echo "<p>" . $row["descrip"] . "</p>";
                echo "<form method='post' action='cart.php'>";
                echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
                echo "<input type='hidden' name='descrip' value='" . $row["descrip"] . "'>";
                echo "<input type='hidden' name='image' value='" . $row["image"] . "'>";
                echo "<button type='submit'>Buy</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }

        // Close database connection
        $conn->close();
    ?>
</body>
</html>
