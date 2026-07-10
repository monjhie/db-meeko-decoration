<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db-connection.php');

if (isset($_POST['add_admin'])) {
    $full_name = trim($_POST['full_name']);
    $user_name = trim($_POST['user_name']);
    $user_email = trim($_POST['user_email']);
    $user_password = trim($_POST['user_password']);
    $user_role = trim($_POST['user_role']);

    if (empty($full_name) || empty($user_name) || empty($user_email) || empty($user_password) || empty($user_role)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../admin/super-admin-role.php");
        exit();
    }

    $check_query = "SELECT id FROM tbl_users WHERE user_email = ? OR user_name = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $user_email, $user_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "The email or username already exists. Please choose another.";
        header("Location: ../admin/super-admin-role.php");
        exit();
    }
    mysqli_stmt_close($stmt);

    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

    $query = "INSERT INTO tbl_users (full_name, user_name, user_email, user_password, user_role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $full_name, $user_name, $user_email, $hashed_password, $user_role);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Admin added successfully!";
        header("Location: ../admin/super-admin-role.php");
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header("Location: ../admin/super-admin-role.php");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../admin/super-admin-role.php");
    exit();
}
?>
