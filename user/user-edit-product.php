<?php require_once('user-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
$user_id = $_SESSION['id'];

if (!isset($_GET['product_id'])) {
    echo "No product ID provided.";
    exit;
}

$product_id = intval($_GET['product_id']);
$sql = "SELECT * FROM tbl_items WHERE product_id = $product_id AND user_id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Product not found.";
    exit;
}

$product = mysqli_fetch_assoc($result);

$category_sql = "SELECT category_type FROM tbl_category ORDER BY category_type ASC";
$category_result = mysqli_query($conn, $category_sql);
?>

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0">Edit Product</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="../process/user-edit-product.php" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Price</label>
          <input type="number" name="product_price" class="form-control" value="<?= htmlspecialchars($product['product_price']) ?>" step="0.01" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Quantity</label>
          <input type="number" name="product_quantity" class="form-control" value="<?= htmlspecialchars($product['product_quantity']) ?>" min="0" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Description</label>
          <textarea name="product_description" class="form-control" rows="3" required><?= htmlspecialchars($product['product_description']) ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Product Details</label>
          <textarea name="product_details" class="form-control" rows="4"><?= htmlspecialchars($product['product_details']) ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Current Product Image</label><br>
          <img id="previewImage" src="../uploads/<?= htmlspecialchars($product['product_photo']) ?>" alt="Product Image" style="width:150px;height:150px;object-fit:cover;" class="rounded mb-2">
          <input type="file" name="product_photo" id="product_photo" class="form-control">
        </div>

        <div class="mb-4">
          <label class="form-label">Product Category</label>
          <select name="product_category" class="form-select" required>
            <option value="" disabled>Select Category</option>
            <?php while ($row = mysqli_fetch_assoc($category_result)): ?>
              <option value="<?= htmlspecialchars($row['category_type']) ?>" <?= $row['category_type'] == $product['product_category'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['category_type']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-dark text-white">Update Product</button>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#product_photo').on('change', function () {
      var file = this.files[0];
      if (file && file.type.startsWith('image/')) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#previewImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
      }
    });
  });
</script>

<?php require_once('../footer.php'); ?>
