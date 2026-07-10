<?php
include('../db-connection.php');

if (isset($_POST['edit_role'])) {
    
    $id = $_POST['id'];
    $user_role = $_POST['user_role'];

    if (!is_numeric($id)) {
        die('Invalid user ID.');
    }

    $sql = "UPDATE `tbl_users` SET `user_role`='$user_role' WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: ../admin/super-admin-role.php?success=1');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
