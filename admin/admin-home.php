<?php require_once('admin-header.php'); ?>

<style>
  .dashboard-title {
    font-weight: bold;
    text-align: center;
    margin-top: 30px;
    font-size: 2rem;
  }

  .custom-card {
    min-height: 350px;
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
      <div class="dashboard-title">Dashboard</div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="row justify-content-center">

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-box display-4 text-light"></i>
          <h5 class="card-title mt-3">Product</h5>
          <p class="card-text mt-2">View, edit, and manage all products in your inventory. Keep listings up to date with real-time changes.</p>
          <a href="admin-products.php" class="btn btn-outline-light w-100 mt-auto">View</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-gear display-4 text-light"></i>
          <h5 class="card-title mt-3">General Settings</h5>
          <p class="card-text mt-2">Modify the site title, tagline, logo, social media links, contact details, banners, and text sections.</p>
          <a href="admin-settings.php" class="btn btn-outline-light w-100 mt-auto">View</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-tags display-4 text-light"></i>
          <h5 class="card-title mt-3">Add Category</h5>
          <p class="card-text mt-2">Organize your products by adding new categories to improve navigation and product discovery.</p>
          <a href="admin-add-category.php" class="btn btn-outline-light w-100 mt-auto">Add Now</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
      <div class="card text-center shadow-sm border-0 bg-dark text-white custom-card">
        <div class="card-body d-flex flex-column">
          <i class="bi bi-tags display-4 text-light"></i>
          <h5 class="card-title mt-3">Add Product</h5>
          <p class="card-text mt-2">Add new products with complete details like pricing, stock, description, and photos.</p>
          <a href="admin-add-product.php" class="btn btn-outline-light w-100 mt-auto">Add Now</a>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once('../footer.php'); ?>
