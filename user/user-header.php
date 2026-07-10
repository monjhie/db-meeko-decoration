<?php
session_start();
include('../db-connection.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id']) || $_SESSION['user_role'] !== 'user') {
    if (isset($_SESSION['user_role'])) {
        switch ($_SESSION['user_role']) {
            case 'super_admin':
                header('Location: ../admin/super-admin-home.php');
                exit();
            case 'editor':
                header('Location: ../admin/editor-home.php');
                exit();
            case 'admin':
                header('Location: ../admin/admin-home.php');
                exit();
        }
    }

    session_destroy();
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];
$sql = "SELECT user_name, user_photo FROM tbl_users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$user_name = $row['user_name'] ?? 'User';
$user_photo = (!empty($row['user_photo']) && file_exists("../uploads/" . $row['user_photo']))
    ? '../uploads/' . $row['user_photo']
    : '../assets/pictures/default-profile.jpg';

$settings_sql = "SELECT settings_webtitle, settings_logo FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = mysqli_fetch_assoc($settings_result);

$webtitle = $settings['settings_webtitle'] ?? "Website Title";
$logo_path = (!empty($settings['settings_logo']) && file_exists("../uploads/" . $settings['settings_logo']))
    ? '../uploads/' . $settings['settings_logo']
    : '../assets/pictures/logo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($webtitle) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($logo_path) ?>">
    <script src="../js/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/style.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@300;400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <style>
        .user-photo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 8px;
        }

        #nav-logo {
            max-height: 50px;
            height: auto;
            width: auto;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img src="<?= htmlspecialchars($logo_path) ?>" class="img-fluid" alt="Site Logo" id="nav-logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user-homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user-shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product-gallery.php">Product Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../ResponsivePersonalWebsite/">About</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= htmlspecialchars($user_photo) ?>" alt="User Photo" class="user-photo">
                            <span><?= htmlspecialchars($user_name) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="product-gallery.php"><i class="bi bi-images me-2"></i>Product Gallery</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
</body>
</html>
