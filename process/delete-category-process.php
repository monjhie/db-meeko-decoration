<?php
include('../db-connection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryId = $_GET['id'];

    $sql = "DELETE FROM tbl_category WHERE category_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $categoryId);

        if ($stmt->execute()) {
            // If successful, redirect to the page with a success message
            header("Location: ../admin/super-admin-add-category.php?success=1");
            exit();
        } else {
            // If deletion failed, redirect with an error message
            header("Location: ../admin/super-admin-add-category.php?error=1");
            exit();
        }
    } else {
        // If SQL statement preparation fails
        header("Location: ../admin/super-admin-add-category.php?error=1");
        exit();
    }
} else {
    // If no category ID is passed
    header("Location: ../admin/super-admin-add-category.php?error=1");
    exit();
}

// Close the database connection
$conn->close();
?>
