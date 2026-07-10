<?php
include('../db-connection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryId = $_GET['id'];

    $sql = "DELETE FROM tbl_category WHERE category_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $categoryId);

        if ($stmt->execute()) {
            header("Location: ../admin/editor-add-category.php?success=1");
            exit();
        } else {
            header("Location: ../admin/editor-add-category.php?error=1");
            exit();
        }
    } else {
        header("Location: ../admin/editor-add-category.php?error=1");
        exit();
    }
} else {
    header("Location: ../admin/editor-add-category.php?error=1");
    exit();
}

$conn->close();
?>
