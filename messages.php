<?php
session_start();
include("connect.php");

// Fetch messages from the database
$sql = "SELECT id, title FROM send2 WHERE viewed = 0"; // Assuming viewed is 0 for unread messages
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>";
        echo "<strong>ID:</strong> " . $row['id'] . "<br>";
        echo "<strong>Title:</strong> " . $row['title'] . "<br>";
        echo "<a href='showm.php?id=" . $row['id'] . "'>عرض المحتوى</a>";
        echo "</p>";
    }
} else {
    echo "لا توجد رسائل.";
}

mysqli_close($conn);
?>
