<!DOCTYPE html>
<html>
<head>
    <title>عرض منتجات قمصان النساء</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Lightbox-->
    <link rel="stylesheet" href="vendor/lightbox2/css/lightbox.min.css">
    <!-- Range slider-->
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Bootstrap select-->
    <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="vendor/owl.carousel2/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel2/assets/owl.theme.default.css">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>

<?php
// Includ the header file
include("header.php");
?>

<h2>عرض منتجات قمصان النساء</h2>

<table>
    <tr>
        <th>الصورة</th>
        <th>الاسم</th>
        <th>السعر</th>
        <th>الوصف</th>
    </tr>
    <?php
    // Connect to the database
    include("connect.php");

    // Query to retrieve Women's T-Shirts products
    $sql = "SELECT * FROM `Women's T-Shirts`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display each product as a row in the table
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "'></td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['price'] . " </td>";
            echo "<td>" . $row['descrip'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>لا توجد منتجات متاحة في هذا الجدول.</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
