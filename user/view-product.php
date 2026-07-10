<?php require_once('user-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
if (isset($_GET['product_id'])) {
  $product_id = intval($_GET['product_id']);

  $sql = "SELECT * FROM tbl_items WHERE product_id = $product_id";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
  } else {
    echo "<div class='container py-5'><p class='text-danger'>Product not found.</p></div>";
    require_once('footer.php');
    exit();
  }
} else {
  echo "<div class='container py-5'><p class='text-danger'>Invalid product ID.</p></div>";
  require_once('footer.php');
  exit();
}
?>

<div class="container py-5">

  <div class="mb-3">
    <a href="user-shop.php" class="btn btn-dark">Go to Shop</a>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-sm p-4">
        <div class="row align-items-center gy-4 flex-column flex-md-row">
          
          <div class="col-md-6 text-center">
            <img src="../uploads/<?= htmlspecialchars($product['product_photo']) ?>" 
                 class="img-fluid rounded" 
                 style="max-height: 400px; object-fit: cover;">
          </div>

          <div class="col-md-6">
            <h2 class="fw-bold mb-3"><?= htmlspecialchars($product['product_name']) ?></h2>
            <p class="fs-5"><strong>Price:</strong> ₱<?= number_format($product['product_price'], 2) ?></p>
            <p><strong>Available Quantity:</strong> <?= htmlspecialchars($product['product_quantity']) ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($product['product_category']) ?></p>
            <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($product['product_description'])) ?></p>
            <p><strong>Details:</strong><br><?= nl2br(htmlspecialchars($product['product_details'])) ?></p>

            <form action="#" method="POST" class="mt-3">
              <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
              
              <div class="mb-2">
                <label for="quantity" class="form-label"><strong>Quantity:</strong></label>
                <input type="number" name="quantity" id="quantity" class="form-control" 
                       value="1" min="1" max="<?= $product['product_quantity'] ?>" required>
              </div>
              
              <button type="submit" class="btn btn-primary w-100" style="background-color: black;">
                Add to Cart
              </button>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once('../footer.php'); ?>
