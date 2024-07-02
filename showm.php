<?php
session_start();
include("connect.php");





// Retrieve messages from the database
$sql = "SELECT id, title, viewed FROM send2";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الرسائل</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: blue;
            color: white;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<header>
    <h1>عرض الرسائل</h1>
</header>

<table>
    <tr>
        <th>ID</th>
        <th>العنوان</th>
        <th>الحالة</th>
        <th>الإجراء</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . ($row['viewed'] ? 'تمت المشاهدة' : 'لم تتم المشاهدة') . "</td>";
        echo "<td>";
        echo "<a href='show_message.php?id=" . $row['id'] . "'>عرض</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>