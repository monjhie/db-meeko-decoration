<?php
session_start();
$alert_msg = isset($_SESSION['alert_msg']) ? $_SESSION['alert_msg'] : '';
unset($_SESSION['alert_msg']);
?>
<?php
include('db-connection.php');
$settings_sql = "SELECT settings_webtitle, settings_logo FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = mysqli_fetch_assoc($settings_result);

$webtitle = $settings['settings_webtitle'] ?? "Website Title";
$logo_path = (!empty($settings['settings_logo']) && file_exists("uploads/" . $settings['settings_logo']))
    ? 'uploads/' . $settings['settings_logo']
    : 'assets/pictures/logo.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($webtitle) ?> - Register</title>
    <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($logo_path) ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 900px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .circle-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .form-section {
            padding-left: 30px;
        }
        @media (max-width: 768px) {
            .card { max-width: 100%; margin-top: 30px; }
            .form-section { padding-left: 0; margin-top: 20px; }
            .circle-img { width: 100px; height: 100px; }
            .logo { font-size: 24px; }
        }
        @media (max-width: 576px) {
            .circle-img { width: 80px; height: 80px; }
            .logo { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 text-center">
        <div class="card-body d-flex flex-column flex-md-row justify-content-center align-items-center">

            <form action="process/register-process.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-md-row justify-content-center align-items-center w-100">
                <!-- Left side: Profile photo -->
                <div class="d-flex flex-column justify-content-center align-items-center mb-4 mb-md-0">
                    <div class="logo">Choose Profile Photo</div>
                    <img id="preview" src="assets/pictures/default-profile.jpg" class="circle-img" alt="Profile Preview" />
                    <input type="file" name="user_photo" id="user_photo" class="form-control mt-2" accept="image/*" />
                </div>

                <!-- Right side: Registration Form -->
                <div class="form-section">
                    <h2 class="mb-3">Register</h2>
                    <?= $alert_msg; ?>
                    <div class="mb-3">
                        <input type="text" name="full_name" class="form-control" placeholder="Full Name" required />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="user_name" class="form-control" placeholder="Username" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="user_email" class="form-control" placeholder="Email" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="user_password" class="form-control" placeholder="Password" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required />
                    </div>

                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="6Lc9wzIrAAAAABKcsbWAu2ihV8h_Dh8Z-pQbupxk"></div>
                    </div>

                    <button type="submit" name="register_submit" class="btn btn-dark w-100">Register</button>

                    <div class="mt-3">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){
    $('#user_photo').on('change', function(event){
        var input = event.target;
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});
</script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
