<?php require_once('user-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
  $delete_id = intval($_POST['delete_product_id']);
  $delete_sql = "DELETE FROM tbl_items WHERE product_id = $delete_id AND user_id = $user_id";
  mysqli_query($conn, $delete_sql);
}

$sql = "SELECT user_photo, full_name, user_name FROM tbl_users WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$category_sql = "SELECT DISTINCT product_category FROM tbl_items WHERE user_id = $user_id ORDER BY product_category ASC";
$category_result = mysqli_query($conn, $category_sql);
?>

<div class="container py-5">
  <h2 class="mb-4 fw-bold">My Profile</h2>

  <?php if ($user): ?>
    <div class="d-flex align-items-center mb-5 flex-wrap">
      <img 
        src="../uploads/<?= htmlspecialchars($user['user_photo']) ?>" 
        alt="Profile Photo" 
        class="rounded-circle me-4 mb-3 mb-md-0" 
        style="width: 120px; height: 120px; object-fit: cover;"
      />
      <div>
        <h3 class="mb-1"><?= htmlspecialchars($user['full_name']) ?></h3>
        <p class="text-muted mb-0" style="font-size: 1.2rem;">@<?= htmlspecialchars($user['user_name']) ?></p>
      </div>
    </div>
  <?php else: ?>
    <p class="text-muted">User not found.</p>
  <?php endif; ?>

  <h3 class="mb-4 fw-bold">Product Gallery</h3>

  <div class="row g-4 mb-5">
    <div class="col-6 col-md-3">
      <a href="upload-product.php?user_id=<?= urlencode($user_id) ?>" class="text-decoration-none">
        <div class="card text-center shadow-sm h-100">
          <div class="card-body d-flex justify-content-center align-items-center flex-column h-100">
            <span style="font-size: 4rem; color: #555;">+</span>
            <p class="mt-2 fw-bold text-dark">Add Product</p>
          </div>
        </div>
      </a>
    </div>
  </div>

  <?php while ($category_row = mysqli_fetch_assoc($category_result)): ?>
    <?php
      $category = $category_row['product_category'];
      $product_sql = "SELECT product_id, product_name, product_photo FROM tbl_items 
                      WHERE user_id = $user_id AND product_category = ? 
                      ORDER BY created_at DESC";
      $stmt = mysqli_prepare($conn, $product_sql);
      mysqli_stmt_bind_param($stmt, "s", $category);
      mysqli_stmt_execute($stmt);
      $product_result = mysqli_stmt_get_result($stmt);
    ?>

    <h4 class="mb-3"><?= htmlspecialchars($category) ?></h4>
    <div class="row g-4 mb-5">
      <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
        <div class="col-6 col-md-3">
          <div class="card shadow-sm h-100 d-flex flex-column">
            <img 
              src="../uploads/<?= htmlspecialchars($product['product_photo']) ?>" 
              alt="<?= htmlspecialchars($product['product_name']) ?>" 
              class="card-img-top"
              style="object-fit: cover; aspect-ratio: 1/1;"
            />
            <div class="card-body text-center d-flex flex-column justify-content-between flex-grow-1">
              <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>

              <a 
                href="view-product.php?product_id=<?= urlencode($product['product_id']) ?>" 
                class="btn btn-dark btn-sm mt-2"
              >
                View
              </a>

              <div class="row mt-2 gx-2">
                <div class="col">
                  <a 
                    href="user-edit-product.php?product_id=<?= urlencode($product['product_id']) ?>" 
                    class="btn btn-success btn-warning btn-sm w-100"
                  >
                    Edit
                  </a>
                </div>

                <div class="col">
                  <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                    <input type="hidden" name="delete_product_id" value="<?= $product['product_id'] ?>">
                    <button 
                      type="submit" 
                      class="btn btn-danger btn-sm w-100"
                    >
                      Delete
                    </button>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endwhile; ?>
</div>

<style>
  .card-img-top {
    width: 100%;
    border-top-left-radius: calc(0.25rem - 1px);
    border-top-right-radius: calc(0.25rem - 1px);
  }

  @media (max-width: 991.98px) { 
    .card-img-top {
      aspect-ratio: 4/3; 
    }
  }

  @media (max-width: 767.98px) { 
    .card {
      display: flex;
      flex-direction: column;
      height: auto;
    }
    .card-img-top {
      aspect-ratio: 1/1;
    }
    .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  }
</style>

<?php require_once('../footer.php'); ?>
