<?php require_once('editor-header.php'); ?>
<?php

include('../db-connection.php');

$settings_sql = "SELECT settings_webtitle FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_sql);
$settings = mysqli_fetch_assoc($settings_result);

$webtitle = $settings['settings_webtitle'] ?? "Website Title";
?>

<style>
  .page-title {
    font-weight: bold;
    text-align: center;
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 2rem;
    color: #333;
  }

  .custom-card {
    min-height: 350px; /* Adjust height here */
    transition: transform 0.3s ease;
  }

  .custom-card:hover {
    transform: translateY(-5px);
  }

  @media (max-width: 576px) {
    .custom-card {
      min-height: 300px;
    }
  }
</style>

<div class="container">
  <div class="row">
    <div class="col">
      <div class="page-title">Manage <?= htmlspecialchars($webtitle) ?> Shop</div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="row justify-content-center">

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-tags display-4 text-light"></i>
          <h5 class="card-title mt-3">Product</h5>
          <p class="card-text mt-2">Manage products and inventory, update product details, monitor stock levels, and organize listings efficiently.</p>
          <a href="editor-products.php" class="btn btn-outline-light w-100 mt-auto">View</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-tags display-4 text-light"></i>
          <h5 class="card-title mt-3">Add Product</h5>
          <p class="card-text mt-2">Add new products to your store with detailed information including price, quantity, images, and more.</p>
          <a href="editor-add-product.php" class="btn btn-outline-light w-100 mt-auto">Add</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-tags display-4 text-light"></i>
          <h5 class="card-title mt-3">Add Category</h5>
          <p class="card-text mt-2">Create and manage categories to group products logically and help customers find items easily.</p>
          <a href="editor-add-category.php" class="btn btn-outline-light w-100 mt-auto">Add</a>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once('../footer.php'); ?>
