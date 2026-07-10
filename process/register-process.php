<?php
session_start();
include '../db-connection.php'; 

function redirectWithAlert($type, $message) {
    $_SESSION['alert_msg'] = "<div class='alert alert-$type'>$message</div>";
    header('Location: ../register.php');
    exit();
}

if (isset($_POST['register_submit'])) {

    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];

        $secretKey = "6Lc9wzIrAAAAAAVc1I96cJAyatEn1jL-_6yHlW7l";
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip=$ip";

        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            redirectWithAlert('danger', 'Captcha verification failed. Please try again.');
        }
    } else {
        redirectWithAlert('danger', 'Please complete the captcha.');
    }

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_password = $_POST['user_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($user_password !== $confirm_password) {
        redirectWithAlert('danger', 'Passwords do not match!');
    }

    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    $photo_name = 'default-profile.jpg'; 
    if (isset($_FILES['user_photo']) && $_FILES['user_photo']['error'] === UPLOAD_ERR_OK) {
        $photo_tmp = $_FILES['user_photo']['tmp_name'];
        $photo_ext = strtolower(pathinfo($_FILES['user_photo']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($photo_ext, $allowed_ext)) {
            redirectWithAlert('danger', 'Invalid photo format. Allowed: JPG, JPEG, PNG, GIF.');
        }

        $new_photo_name = uniqid('user_', true) . '.' . $photo_ext;
        $upload_path = '../uploads/' . $new_photo_name;

        if (move_uploaded_file($photo_tmp, $upload_path)) {
            $photo_name = $new_photo_name;
        } else {
            $error = error_get_last();
            redirectWithAlert('danger', 'Failed to upload photo. Error: ' . ($error['message'] ?? 'Unknown'));
        }
    }

    $user_role = 'user';

    $insert = mysqli_query($conn, "INSERT INTO tbl_users (full_name, user_name, user_email, user_password, user_photo, user_role) VALUES ('$full_name', '$user_name', '$user_email', '$hashed_password', '$photo_name', '$user_role')");

    if ($insert) {
        redirectWithAlert('success', 'Registration successful! You can now login.');
    } else {
        redirectWithAlert('danger', 'Failed to register user. Error: ' . mysqli_error($conn));
    }

} else {
    redirectWithAlert('danger', 'Invalid access.');
}
?>
