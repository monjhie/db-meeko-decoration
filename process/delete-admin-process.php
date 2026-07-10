<?php
require_once('../db-connection.php');

if (isset($_GET['id'])) {
    $userId = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "SELECT * FROM tbl_users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $deleteSql = "DELETE FROM tbl_users WHERE id = '$userId'";
        if (mysqli_query($conn, $deleteSql)) {
            header("Location: ../admin/super-admin-role.php?message=User deleted successfully");
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
