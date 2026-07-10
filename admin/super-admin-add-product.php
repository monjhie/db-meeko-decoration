<?php require_once('super-admin-header.php'); ?>
<?php include('../db-connection.php');

$categoryQuery = "SELECT category_id, category_type FROM tbl_category";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = [];

if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $row;
    }
}
?>

<style>
  .btn-back {
    background-color: #000;
    color: #fff;
    border: 1px solid #000;
    padding: 8px 15px;
    font-weight: bold;
    transition: 0.3s ease;
    margin-bottom: 20px;
  }

  .btn-back:hover {
    background-color: #fff;
    color: #000;
    border-color: #000;
  }

  .btn-back i {
    margin-right: 8px;
  }

  @media (max-width: 576px) {
    .card h2 {
      font-size: 1.5rem;
    }
  }
</style>

<div class="container my-5">
  <div class="row mb-4">
    <div class="col-12">
      <a href="super-admin-products.php" class="btn btn-back">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="card shadow p-4 bg-white">
    <h2 class="text-center mb-4 text-dark">Add New Product</h2>
    <form action="../process/add-product-process.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label text-dark">Product Name</label>
        <input type="text" name="product_name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label text-dark">Product Price</label>
        <input type="number" step="0.01" name="product_price" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label text-dark">Quantity</label>
        <input type="number" name="product_quantity" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label text-dark">Item Details</label>
        <textarea name="product_details" class="form-control" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label text-dark">Description</label>
        <textarea name="product_description" class="form-control" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label text-dark">Product Photo</label>
        <input type="file" name="product_photo" class="form-control" accept="image/*" id="productPhoto" required>
        <div class="mt-3">
          <img id="photoPreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px; border: 1px solid #ccc; padding: 5px;" />
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label text-dark">Product Category</label>
        <select name="product_category" class="form-select" required>
          <option value="" disabled selected>Select category</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id']; ?>">
              <?= htmlspecialchars($category['category_type']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-dark px-5">Add Product</button>
      </div>
    </form>
  </div>
</div>

<script>
  $('#productPhoto').on('change', function () {
    const file = this.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#photoPreview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(file);
    } else {
      $('#photoPreview').hide().attr('src', '#');
    }
  });
</script>

<?php require_once('../footer.php'); ?>
