<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    
    // Update the viewed status in the database
    $update_sql = "UPDATE send2 SET viewed = 1 WHERE id = $message_id";
    mysqli_query($conn, $update_sql);
    
    echo "Success";
}

mysqli_close($conn);
?>
