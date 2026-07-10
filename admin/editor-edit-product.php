<?php require_once('editor-header.php'); ?>
<?php

include('../db-connection.php');

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];

    $sql = "SELECT * FROM `tbl_items` WHERE `product_id` = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $product = $product[0];
    } else {
        echo 'Error: ' . $sql . "<br>" . mysqli_error($conn);
    }
}

$categories = [];
$categoryQuery = "SELECT category_type FROM tbl_category";
$categoryResult = mysqli_query($conn, $categoryQuery);

if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categories[] = $row['category_type'];
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
      <a href="editor-products.php" class="btn btn-back">
        <i class="bi bi-arrow-left"></i> Back
      </a>
    </div>
  </div>

  <div class="card shadow p-4">
    <h2 class="mb-4 text-center">
        Edit <?= htmlspecialchars($product['product_name']) ?>
    </h2>

    <form action="../process/editor-edit-product-process.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" id="product_name" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="product_quantity" class="form-label">Quantity</label>
            <input type="number" id="product_quantity" name="product_quantity" class="form-control" value="<?= $product['product_quantity'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="product_price" class="form-label">Price</label>
            <input type="number" step="0.01" id="product_price" name="product_price" class="form-control" value="<?= $product['product_price'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea id="product_description" name="product_description" class="form-control" rows="3"><?= htmlspecialchars($product['product_description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="product_details" class="form-label">Product Details</label>
            <textarea id="product_details" name="product_details" class="form-control" rows="3"><?= htmlspecialchars($product['product_details']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="product_category" class="form-label">Category</label>
            <select id="product_category" name="product_category" class="form-select" required>
                <option disabled selected>Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category) ?>" <?= $product['product_category'] == $category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="product_photo" class="form-label">Product Photo</label>
            <div class="mb-3 text-center">
                <img src="<?= !empty($product['product_photo']) ? '../uploads/' . htmlspecialchars($product['product_photo']) : '' ?>" alt="Product Photo" id="photo_preview" class="img-fluid rounded" style="max-height: 200px; <?= empty($product['product_photo']) ? 'display: none;' : '' ?>">
            </div>
            <input type="file" id="product_photo" name="product_photo" class="form-control" accept="image/*">
            <small class="text-muted">Upload a product image</small>
        </div>

        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
        <input type="hidden" name="current_image" value="<?= $product['product_photo'] ?>">

        <div class="text-center">
            <button type="submit" name="edit_product" class="btn btn-success px-5">Submit</button>
        </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#product_photo').change(function(e) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#photo_preview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(this.files[0]);
    });
  });
</script>

<?php require_once('../footer.php'); ?>
