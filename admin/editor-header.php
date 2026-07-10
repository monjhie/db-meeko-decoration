<?php
session_start();
include('../db-connection.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id']) || $_SESSION['user_role'] !== 'editor') {
    if (isset($_SESSION['user_role'])) {
        switch ($_SESSION['user_role']) {
            case 'admin':
                header('Location: admin-home.php');
                exit();
            case 'super_admin':
                header('Location: super-admin-home.php');
                exit();
            case 'user':
                header('Location: ../user/user-homepage.php');
                exit();
        }
    }

    session_destroy();
    header('Location: ../login.php');
    exit();
}

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
    <link rel="stylesheet" href="../bootstrap/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
</head>
    <style>
        #nav-logo {
            max-height: 50px;
            height: auto;
            width: auto;
        }
    </style>
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
                            <a class="nav-link active" aria-current="page" href="#">Hi, <?= htmlspecialchars($_SESSION['user_name']); ?>!</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="editor-home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="editor-products.php">Products</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto"> <!-- Right side text for navbar -->
                      <li class="nav-item">
                          <a class="nav-link" href="../logout.php">Log Out</a>
                      </li>
                  </ul>
                </div>
            </div>
        </nav>
    </header>
