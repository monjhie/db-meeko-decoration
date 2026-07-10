<?php
include('../db-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = (float) $_POST['product_price'];
    $product_quantity = (int) $_POST['product_quantity'];
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_details = mysqli_real_escape_string($conn, $_POST['product_details']);
    $category_id = (int) $_POST['product_category'];

    $categoryQuery = "SELECT category_type FROM tbl_category WHERE category_id = '$category_id'";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
        $category = mysqli_fetch_assoc($categoryResult);
        $category_type = $category['category_type'];

        if (isset($_FILES['product_photo']) && $_FILES['product_photo']['error'] === 0) {
            $photo = $_FILES['product_photo'];
            $file_name = basename($photo['name']);
            $file_tmp = $photo['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($file_ext, $allowed_exts)) {
                $upload_dir = '../uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $new_file_name = uniqid('prod_', true) . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $relative_path = '../uploads/' . $new_file_name;

                    $sql = "INSERT INTO tbl_items 
                            (product_name, product_price, product_quantity, product_description, product_details, product_photo, product_category)
                            VALUES 
                            ('$product_name', '$product_price', '$product_quantity', '$product_description', '$product_details', '$relative_path', '$category_type')";

                    if (mysqli_query($conn, $sql)) {
                        header('Location: ../admin/admin-products.php?status=success');
                        exit();
                    } else {
                        echo "Database Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "Failed to upload the image.";
                }
            } else {
                echo "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            echo "Image upload failed or no file uploaded.";
        }
    } else {
        echo "Invalid category selected.";
    }
} else {
    echo "Invalid request.";
}
?>
