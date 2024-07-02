<?php
session_start();
include("connect.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // استعلام SQL لتغيير حالة المشاهدة
    $sql = "UPDATE messages SET viewed = !viewed WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // استعلام لاسترجاع الحالة الجديدة
    $sql = "SELECT viewed FROM send2 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // إعادة الحالة الجديدة كاستجابة
    echo $row['viewed'] ? 'viewed' : 'not_viewed';
}

mysqli_close($conn);
?>
