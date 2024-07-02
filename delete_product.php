<?php
session_start();
include("connect.php");

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // التحقق من هوية المستخدم الحالي
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // التحقق من أن المنتج ينتمي إلى المستخدم الحالي
        $sql = "SELECT * FROM products WHERE id = $productId AND user_id = $userId";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // قم بحذف المنتج
            $sqlDelete = "DELETE FROM products WHERE id = $productId";

            if (mysqli_query($conn, $sqlDelete)) {
                echo "<p>تم حذف المنتج بنجاح.</p>";
            } else {
                echo "<p>حدث خطأ أثناء حذف المنتج: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>لا يمكنك حذف هذا المنتج، حيث أنه ليس منتجك.</p>";
        }
    } else {
        echo "<p>يجب تسجيل الدخول لحذف المنتج.</p>";
    }

    mysqli_close($conn);
} else {
    echo "<p>طلب غير صحيح.</p>";
}
?>
