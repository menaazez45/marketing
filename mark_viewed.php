<?php
session_start();
include("connect.php");


if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // استعلام SQL لتغيير حالة المشاهدة إلى تمت المشاهدة
    $sql = "UPDATE send2 SET viewed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

mysqli_close($conn);
?>
