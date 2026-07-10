<?php
include('../db-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo '<pre>'; var_dump($_POST, $_FILES); echo '</pre>';

    $photo = $_POST['current_image'] ?? '';

    if (!empty($_FILES["product_photo"]["name"])) {
        $target_dir = "../uploads/";
        $image_name = basename($_FILES["product_photo"]["name"]);
        $target_file_path = $target_dir . $image_name;

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["product_photo"]["tmp_name"], $target_file_path)) {
                $photo = $image_name;
            } else {
                echo "File upload failed.";
            }
        }
    }

    $id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $details = mysqli_real_escape_string($conn, $_POST['product_details']);
    $category = mysqli_real_escape_string($conn, $_POST['product_category']);

    // echo '<pre>'; var_dump($id, $name, $quantity, $price, $description, $details, $category, $photo); echo '</pre>';

    $sql = "UPDATE `tbl_items` SET 
        `product_name` = '$name',
        `product_quantity` = '$quantity',
        `product_price` = '$price',
        `product_description` = '$description',
        `product_details` = '$details',
        `product_category` = '$category',
        `product_photo` = '$photo'
        WHERE `product_id` = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'Product updated successfully.';
        header("Location: ../admin/super-admin-products.php?success=1");
    } else {
        echo 'Error: ' . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
