<?php
require_once('../db-connection.php');
session_start();

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = floatval($_POST['product_price']);
    $quantity = intval($_POST['product_quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $details = mysqli_real_escape_string($conn, $_POST['product_details']);
    $category = mysqli_real_escape_string($conn, $_POST['product_category']);

    $sql = "SELECT product_photo FROM tbl_items WHERE product_id = $product_id AND user_id = $user_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $existing = mysqli_fetch_assoc($result);
    $photo = $existing['product_photo'];

    if (!empty($_FILES['product_photo']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["product_photo"]["name"]);
        if (move_uploaded_file($_FILES["product_photo"]["tmp_name"], $target_file)) {
            $photo = basename($_FILES["product_photo"]["name"]);
        }
    }

    $update_sql = "UPDATE tbl_items SET 
        product_name = '$name',
        product_price = $price,
        product_quantity = $quantity,
        product_description = '$description',
        product_details = '$details',
        product_photo = '$photo',
        product_category = '$category'
        WHERE product_id = $product_id AND user_id = $user_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../user/product-gallery.php?update=success");
        exit;
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
