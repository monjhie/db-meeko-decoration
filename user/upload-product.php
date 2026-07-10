<?php require_once('user-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$cat_sql = "SELECT category_id, category_type FROM tbl_category ORDER BY category_type ASC";
$cat_result = mysqli_query($conn, $cat_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
  $product_price = (float) $_POST['product_price'];
  $product_quantity = (int) $_POST['product_quantity'];
  $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
  $product_details = mysqli_real_escape_string($conn, $_POST['product_details']);
  $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);

  $photo_name = '';
  if (isset($_FILES['product_photo']) && $_FILES['product_photo']['error'] == 0) {
    $target_dir = "../uploads/";
    $photo_name = time() . '_' . basename($_FILES["product_photo"]["name"]);
    $target_file = $target_dir . $photo_name;
    move_uploaded_file($_FILES["product_photo"]["tmp_name"], $target_file);
  }

  $sql = "INSERT INTO tbl_items 
  (user_id, product_name, product_price, product_quantity, product_description, product_details, product_photo, product_category, created_at, updated_at) 
  VALUES 
  ($user_id, '$product_name', $product_price, $product_quantity, '$product_description', '$product_details', '$photo_name', '$product_category', NOW(), NOW())";

  if (mysqli_query($conn, $sql)) {
    header("Location: product-gallery.php");
    exit();
  } else {
    $error = "Error adding product: " . mysqli_error($conn);
  }
}
?>

<div class="container py-5">
  <h2 class="mb-4 fw-bold">Upload Product</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Price</label>
          <input type="number" step="0.01" name="product_price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Quantity</label>
          <input type="number" name="product_quantity" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Description</label>
          <textarea name="product_description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Details</label>
          <textarea name="product_details" class="form-control" required></textarea>
        </div>


        <div class="mb-3 text">
          <label class="form-label">Product Photo</label>
          <input type="file" name="product_photo" class="form-control mx-auto" id="product-photo" required>
          <div class="mt-3 text-center">
            <img id="photo-preview" src="#" alt="Image Preview" style="max-width: 100%; display: none; object-fit: cover; height: 200px;">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Category</label>
          <select name="product_category" class="form-select" required>
            <option value="" disabled selected>Select Category</option>
            <?php while ($cat = mysqli_fetch_assoc($cat_result)): ?>
              <option value="<?= htmlspecialchars($cat['category_type']) ?>">
                <?= htmlspecialchars($cat['category_type']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-dark">Upload</button>
        </div>
      </form>
    </div>
  </div>

</div>

<?php require_once('../footer.php'); ?>


<script>
  $('#product-photo').change(function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#photo-preview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(file);
    }
  });
</script>
