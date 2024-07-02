<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    // حذف المنتج من الSESSION
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['id'] == $productId) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // إعادة ترتيب المفاتيح في الSESSION
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// إعادة توجيه المستخدم إلى صفحة عربة التسوق بعد الحذف
header("Location: cart.php");
exit();
?>
