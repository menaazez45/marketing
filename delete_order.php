<?php
session_start();
include("connect.php");

$user_id = $_SESSION['user_id']; // يفترض أن user_id مخزن في الجلسة

// التحقق من أن المستخدم قام بتسجيل الدخول
if (!isset($user_id)) {
    echo "يرجى تسجيل الدخول لحذف الطلب.";
    exit;
}

// التحقق من وجود معرف الطلب في الرابط
if (!isset($_GET['id'])) {
    echo "معرف الطلب غير محدد.";
    exit;
}

$product_id = $_GET['id'];

// حذف الطلب من قاعدة البيانات
$sql = "DELETE FROM orders WHERE product_id = '$product_id' AND user_id = '$user_id'";
if (mysqli_query($conn, $sql)) {
    echo "تم حذف الطلب بنجاح!";
} else {
    echo "حدث خطأ أثناء حذف الطلب: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
