<?php
include("connect.php");

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];
    
    // Retrieve the message from the database
    $sql = "SELECT id, title, content, image_path, viewed FROM send2 WHERE id = $message_id";
    $result = mysqli_query($conn, $sql);
    $message = mysqli_fetch_assoc($result);

    // تحديث حالة الرسالة إلى "تمت المشاهدة"
    $update_sql = "UPDATE send2 SET viewed = 1 WHERE id = $message_id";
    mysqli_query($conn, $update_sql);

    mysqli_close($conn);
} else {
    echo "No message ID provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الرسالة</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
        }
        .message-container {
            width: 80%;
            max-width: 800px;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message-container h2 {
            margin-top: 0;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .message-container p {
            line-height: 1.6;
            color: #666;
            margin-bottom: 20px;
            font-size: 18px;
        }
        .message-container img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<header>
    <h1>عرض الرسالة</h1>
</header>

<div class="message-container">
    <h2><?php echo htmlspecialchars($message['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($message['content'])); ?></p>
    <?php if (!empty($message['image_path'])): ?>
        <img src="<?php echo htmlspecialchars($message['image_path']); ?>" alt="Message Image">
    <?php endif; ?>
</div>

</body>
</html>
