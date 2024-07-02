<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>عرض الجدول من قاعدة البيانات</title>
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
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2{
            text-align: center;
        }
    </style>
</head>
<body>

<h2>جدول الرسائل</h2>

<table>
    <tr>
        <th>الرقم التسلسلي</th>
        <th>اسم المستخدم</th>
        <th>البريد الإلكتروني</th>
        <th>الرسالة</th>
    </tr>

    <?php
    include("connect.php");

    // استعلام SQL لاسترداد البيانات
    $sql = "SELECT id, username, email, send FROM send";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // عرض كل صف من البيانات كصفحة HTML
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["username"]. "</td><td>" . $row["email"]. "</td><td>" . $row["send"]. "</td></tr>";
        }
    } else {
        echo "0 نتائج";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
