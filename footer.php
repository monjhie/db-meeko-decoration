<?php
include_once('db-connection.php');


$settings_query = "SELECT * FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_query);
$settings = mysqli_fetch_assoc($settings_result);

$facebook = isset($settings['settings_facebook']) ? $settings['settings_facebook'] : '#';
$instagram = isset($settings['settings_instagram']) ? $settings['settings_instagram'] : '#';
$twitter = isset($settings['settings_twitter']) ? $settings['settings_twitter'] : '#';
$webtitle = isset($settings['settings_webtitle']) ? $settings['settings_webtitle'] : '#';
?>

<footer class="bg-black text-white text-center py-4">
  <div class="container">
    <p class="mb-0">© 2025 <?= htmlspecialchars($webtitle) ?>. All Rights Reserved.</p>
    <p class="mt-2">
      <a href="<?= htmlspecialchars($facebook) ?>" class="text-white me-3"><i class="bi bi-facebook"></i></a>
      <a href="<?= htmlspecialchars($instagram) ?>" class="text-white me-3"><i class="bi bi-instagram"></i></a>
      <a href="<?= htmlspecialchars($twitter) ?>" class="text-white"><i class="bi bi-twitter-x"></i></a>
    </p>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</footer>
</body>
</html>
