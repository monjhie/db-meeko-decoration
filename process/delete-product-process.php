<?php
include('../db-connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "DELETE FROM tbl_items WHERE product_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../admin/super-admin-products.php');
            exit();
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request.';
}

mysqli_close($conn);
?>
