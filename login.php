<?php
session_start();
include('db-connection.php');

if (isset($_SESSION['id'])) {
    if ($_SESSION['user_role'] === 'super_admin') {
        header('Location:' . BASE_URL . 'admin/super-admin-home.php');
    } elseif ($_SESSION['user_role'] === 'admin') {
        header('Location:' . BASE_URL . 'admin/admin-home.php');
    } elseif ($_SESSION['user_role'] === 'editor') {
        header('Location:' . BASE_URL . 'admin/editor-home.php');
    } elseif ($_SESSION['user_role'] === 'user') {
        header('Location:' . BASE_URL . 'user/user-homepage.php');
    } else {
        session_destroy();
        header('Location: login.php');
        exit();
    }
    exit();
}

$alert_msg = '';

if (isset($_POST['login_submit'])) {
    $user_input = trim($_POST['user_input']);
    $user_password = $_POST['user_password'];

    $sql = "SELECT * FROM `tbl_users` WHERE `user_name` = ? OR `user_email` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user_input, $user_input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            if (password_verify($user_password, $row['user_password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_email'] = $row['user_email'];
                $_SESSION['user_role'] = $row['user_role'];

                if ($_SESSION['user_role'] === 'super_admin') {
                    header('Location:' . BASE_URL . 'admin/super-admin-home.php');
                } elseif ($_SESSION['user_role'] === 'admin') {
                    header('Location:' . BASE_URL . 'admin/admin-home.php');
                } elseif ($_SESSION['user_role'] === 'editor') {
                    header('Location:' . BASE_URL . 'admin/editor-home.php');
                } elseif ($_SESSION['user_role'] === 'user') {
                    header('Location:' . BASE_URL . 'user/user-homepage.php');
                } else {
                    session_destroy();
                    header('Location: login.php');
                }
                exit();
            } else {
                $alert_msg = '<div class="alert alert-danger" role="alert">Incorrect password. Please try again.</div>';
            }
        } else {
            $alert_msg = '<div class="alert alert-danger" role="alert">No account found with that username or email.</div>';
        }
    } else {
        $alert_msg = '<div class="alert alert-danger" role="alert">Database error: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<?php
$settings_sql = "SELECT settings_webtitle, settings_logo, settings_tagline FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = mysqli_fetch_assoc($settings_result);

$webtitle = $settings['settings_webtitle'] ?? "Website Title";
$tagline = $settings['settings_tagline'] ?? "Tagline";
$logo_path = (!empty($settings['settings_logo']) && file_exists("uploads/" . $settings['settings_logo']))
    ? 'uploads/' . $settings['settings_logo']
    : 'assets/pictures/logo.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($webtitle) ?> - Login</title>
    <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($logo_path) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/pictures/login-background.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
        }
        .card {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }
        .tagline {
            font-size: 18px;
            color: #777;
            margin-bottom: 20px;
            font-family: 'Arial', sans-serif;
            font-style: italic;
        }
        #login-logo {
            height: 80px;
            width: 80px;
        }
        @media (max-width: 576px) {
            .card {
                padding: 20px;
                width: 90%;
            }
        }
        .guest-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .guest-link a {
            color: #000;
            text-decoration: underline;
        }
        .guest-link a:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 text-center" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            <img src="<?= htmlspecialchars($logo_path) ?>" id="login-logo" class="img-fluid mb-3" alt="Meeko's Haven Logo">
            <div class="logo"><?= htmlspecialchars($webtitle) ?></div>
            <div class="tagline"><?= htmlspecialchars($tagline) ?></div>
            <form action="login.php" method="POST">
                <?= $alert_msg; ?>
                <div class="mb-3">
                    <input type="text" name="user_input" class="form-control" placeholder="Username or Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="user_password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="login_submit" class="btn btn-dark w-100">Login</button>
            </form>
            <div class="mt-3">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
            <div class="guest-link">
            <p><a href="index.php">Proceed as Guest</a></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
