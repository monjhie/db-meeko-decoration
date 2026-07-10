<?php
require_once('../db-connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['categoryName']);

    if (!empty($category)) {
        $stmt = $conn->prepare("INSERT INTO tbl_category (category_type) VALUES (?)");
        $stmt->bind_param("s", $category);

        if ($stmt->execute()) {
            header('Location: ../admin/editor-add-category.php?success=1');
            exit();
        } else {
            echo "Error inserting category.";
        }

        $stmt->close();
    } else {
        echo "Category name cannot be empty.";
    }
} else {
    echo "Invalid request.";
}
?>
