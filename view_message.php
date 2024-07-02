<?php
session_start();
include("connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // استعلام SQL لاسترجاع تفاصيل الرسالة من قاعدة البيانات
    $sql = "SELECT id, title, content FROM send2 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "الرسالة غير موجودة";
        exit;
    }
} else {
    echo "لم يتم تحديد الرسالة";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الرسالة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .message-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<header>
    <h1>عرض الرسالة</h1>
</header>

<div class="message-container">
    <h2><?php echo $row['title']; ?></h2>
    <p><?php echo $row['content']; ?></p>
    <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
</div>

</body>
</html>
