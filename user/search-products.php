<?php
include('../db-connection.php');

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$minPrice = isset($_GET['minPrice']) ? (float)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? (float)$_GET['maxPrice'] : 0;

$where = "WHERE 1";
if (!empty($search)) {
  $where .= " AND product_name LIKE '%$search%'";
}
if (!empty($category)) {
  $where .= " AND product_category = '$category'";
}
if ($minPrice > 0) {
  $where .= " AND product_price >= $minPrice";
}
if ($maxPrice > 0) {
  $where .= " AND product_price <= $maxPrice";
}

$count_sql = "SELECT COUNT(*) AS total FROM tbl_items $where";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];
$total_pages = ceil($total_products / $limit);

$product_sql = "SELECT * FROM tbl_items $where ORDER BY product_id DESC LIMIT $offset, $limit";
$product_result = mysqli_query($conn, $product_sql);

$products_html = '
<style>
  .card-link-wrapper {
    color: inherit;
    text-decoration: none;
  }
  .card-link-wrapper:hover {
    text-decoration: none;
  }
</style>
';

while ($row = mysqli_fetch_assoc($product_result)) {
  $photo_path = $row['product_photo'];
  if (strpos($photo_path, '../uploads/') !== 0) {
    $photo_path = '../uploads/' . $photo_path;
  }

  $product_id = urlencode($row['product_id']);
  $products_html .= '
    <div class="col-6 col-md-3 mb-4">
      <a href="view-product.php?product_id=' . $product_id . '" class="card-link-wrapper">
        <div class="card h-100 shadow-sm">
          <img src="' . htmlspecialchars($photo_path) . '" class="card-img-top" style="height:200px;object-fit:cover;" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">' . htmlspecialchars($row['product_name']) . '</h5>
            <p class="card-text">Available: ' . number_format($row['product_quantity']) . '</p>
            <p class="card-text">₱' . number_format($row['product_price'], 2) . '</p>
            <span class="btn btn-primary mt-auto view-btn">Buy</span>
          </div>
        </div>
      </a>
    </div>
  ';
}

if ($products_html == '') {
  $products_html = '<p class="text-muted">No products found.</p>';
}

$pagination_html = '<nav><ul class="pagination justify-content-center">';
for ($i = 1; $i <= $total_pages; $i++) {
  $active = ($i == $page) ? ' active' : '';
  $pagination_html .= '<li class="page-item' . $active . '"><a href="#" class="page-link" data-page="' . $i . '">' . $i . '</a></li>';
}
$pagination_html .= '</ul></nav>';

echo json_encode([
  'products' => $products_html,
  'pagination' => $pagination_html
]);
?>
