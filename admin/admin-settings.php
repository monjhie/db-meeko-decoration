<?php require_once('admin-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
$query = "SELECT * FROM tbl_settings WHERE settings_id = 1";
$result = mysqli_query($conn, $query);
$settings = mysqli_fetch_assoc($result);
?>

<div class="container my-5" id="livePreviewSection">
  <h2>Live Preview</h2>
  <div class="hero">
    <div class="container py-5">
      <div class="row mb-4 align-items-center flex-lg-row-reverse">
        <div class="col-md-6 col-xl-7 mb-4 mb-lg-0">
          <img id="heroPreview" src="../uploads/<?php echo $settings['settings_hero']; ?>" alt="Hero" class="w-100 h-auto rounded">
        </div>

        <div class="col-md-6 col-xl-5 text-center text-md-start">
          <h1 id="headlinePreview" class="fw-bolder display-4"><?php echo htmlspecialchars($settings['settings_headline']); ?></h1>
          <p id="subheadlinePreview" class="lead"><?php echo htmlspecialchars($settings['settings_subheadline']); ?></p>
          <p id="textsectionPreview" class="quote"><?php echo htmlspecialchars($settings['settings_textsection']); ?></p>
          <a class="btn btn-lg btn-primary" style="background-color: black;" href="#" role="button">Shop Now</a>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5 d-flex justify-content-center">
    <div class="card shadow" style="width: 100%; max-width: 700px;">
      <div class="card-body">
        <h2 class="card-title mb-4">Website Settings</h2>
        <form action="../process/admin-update-settings-process.php" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label class="form-label">Headline:</label>
            <input type="text" id="headlineInput" name="settings_headline" value="<?php echo htmlspecialchars($settings['settings_headline']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Subheadline:</label>
            <input type="text" id="subheadlineInput" name="settings_subheadline" value="<?php echo htmlspecialchars($settings['settings_subheadline']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Text Section:</label>
            <textarea id="textsectionInput" name="settings_textsection" class="form-control" rows="4"><?php echo htmlspecialchars($settings['settings_textsection']); ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Current Hero Image: <br> Note: Please make sure that you will only use webpage banner.</label><br>
            <img id="currentHeroImage" src="../uploads/<?php echo $settings['settings_hero']; ?>" alt="Hero Image" width="300"><br><br>
            <input type="file" id="heroImageInput" name="settings_hero" accept="image/*" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Current Logo:</label><br>
            <img id="currentLogoImage" src="../uploads/<?php echo $settings['settings_logo']; ?>" alt="Logo" width="150"><br><br>
            <input type="file" id="logoImageInput" name="settings_logo" accept="image/*" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Website Title:</label>
            <input type="text" name="settings_webtitle" value="<?php echo htmlspecialchars($settings['settings_webtitle']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Tagline:</label>
            <input type="text" name="settings_tagline" value="<?php echo htmlspecialchars($settings['settings_tagline']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Facebook:</label>
            <input type="text" name="settings_facebook" value="<?php echo htmlspecialchars($settings['settings_facebook']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Instagram:</label>
            <input type="text" name="settings_instagram" value="<?php echo htmlspecialchars($settings['settings_instagram']); ?>" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Twitter:</label>
            <input type="text" name="settings_twitter" value="<?php echo htmlspecialchars($settings['settings_twitter']); ?>" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary w-100" style="background-color: black;" >Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<button id="showPreviewBtn" style="position: fixed; bottom: 20px; right: 20px; background-color: black; color: white; border: none; padding: 15px 20px; border-radius: 50px; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
  Show Live Preview
</button>

<hr>


<script>
  $('#headlineInput').on('input', function () {
    $('#headlinePreview').text($(this).val());
  });

  $('#subheadlineInput').on('input', function () {
    $('#subheadlinePreview').text($(this).val());
  });

  $('#textsectionInput').on('input', function () {
    $('#textsectionPreview').text($(this).val());
  });

  $('#heroImageInput').on('change', function (e) {
    var file = e.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#heroPreview').attr('src', e.target.result);
        $('#currentHeroImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(file);
    }
  });

  $('#logoImageInput').on('change', function (e) {
    var file = e.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#currentLogoImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(file);
    }
  });

  $('#showPreviewBtn').on('click', function () {
    $('html, body').animate({
      scrollTop: $('#livePreviewSection').offset().top
    }, 500);
  });
</script>

<?php require_once('../footer.php'); ?>
