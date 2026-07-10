<?php
include('../db-connection.php');

$uploadDir = '../uploads/';

$query = "SELECT * FROM tbl_settings WHERE settings_id = 1";
$result = mysqli_query($conn, $query);
$currentSettings = mysqli_fetch_assoc($result);

$logoName = $currentSettings['settings_logo'];
if (isset($_FILES['settings_logo']) && $_FILES['settings_logo']['error'] == 0) {
    $ext = pathinfo($_FILES['settings_logo']['name'], PATHINFO_EXTENSION);
    $logoName = 'logo_' . time() . '.' . $ext;
    move_uploaded_file($_FILES['settings_logo']['tmp_name'], $uploadDir . $logoName);
}

$heroName = $currentSettings['settings_hero'];
if (isset($_FILES['settings_hero']) && $_FILES['settings_hero']['error'] == 0) {
    $ext = pathinfo($_FILES['settings_hero']['name'], PATHINFO_EXTENSION);
    $heroName = 'hero_' . time() . '.' . $ext;
    move_uploaded_file($_FILES['settings_hero']['tmp_name'], $uploadDir . $heroName);
}

$webTitle = mysqli_real_escape_string($conn, $_POST['settings_webtitle']);
$tagline = mysqli_real_escape_string($conn, $_POST['settings_tagline']);
$facebook = mysqli_real_escape_string($conn, $_POST['settings_facebook']);
$instagram = mysqli_real_escape_string($conn, $_POST['settings_instagram']);
$twitter = mysqli_real_escape_string($conn, $_POST['settings_twitter']);
$headline = mysqli_real_escape_string($conn, $_POST['settings_headline']);
$subheadline = mysqli_real_escape_string($conn, $_POST['settings_subheadline']);
$textsection = mysqli_real_escape_string($conn, $_POST['settings_textsection']);

$updateQuery = "
UPDATE tbl_settings SET 
  settings_logo = '$logoName',
  settings_webtitle = '$webTitle',
  settings_tagline = '$tagline',
  settings_facebook = '$facebook',
  settings_instagram = '$instagram',
  settings_twitter = '$twitter',
  settings_headline = '$headline',
  settings_subheadline = '$subheadline',
  settings_textsection = '$textsection',
  settings_hero = '$heroName'
WHERE settings_id = 1
";

if (mysqli_query($conn, $updateQuery)) {
    header('Location: ../admin/super-admin-settings.php?status=success');
} else {
    header('Location: ../admin/super-admin-settings.php?status=error');
}
?>
