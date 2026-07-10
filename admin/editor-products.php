<?php require_once('editor-header.php'); ?>
<?php include('../db-connection.php');

$limit = 6; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT product_id, product_photo, product_name, product_price, product_quantity, product_description, product_details, product_category FROM tbl_items LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$count_sql = "SELECT COUNT(*) AS total FROM tbl_items";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];
$total_pages = ceil($total_products / $limit);

if ($result) {
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>

<style>
  .btn-custom {
    background-color: black;
    color: white;
    border: none;
    margin: 5px;
  }
  .btn-custom:hover {
    background-color: #333;
    color: white;
  }

  .pagination .page-link {
    color: black !important;
    background-color: white !important;
    border: 1px solid #dee2e6;
  }

  .pagination .active .page-link {
    background-color: black !important;
    color: white !important;
    border-color: black !important;
  }

  .pagination .page-link:hover {
    background-color: #f0f0f0 !important;
  }

  .button-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  @media (max-width: 768px) {
    table th, table td {
      font-size: 12px;
    }
  }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center mt-5 fw-bold">PRODUCT LIST</h2>

    <div class="button-group">
        <a href="editor-add-product.php" class="btn btn-custom">+ Add Product</a>
        <a href="editor-add-category.php" class="btn btn-custom">+ Add Category</a>
        <a href="../export-product.php" class="btn btn-custom">Export Products</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Item Details</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $ctr = $offset + 1;?>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $ctr++; ?></td>
                            <td><img src="../uploads/<?= htmlspecialchars($item['product_photo']) ?>" alt="Decoration Image" width="100" class="img-fluid"></td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= htmlspecialchars($item['product_quantity']) ?></td>
                            <td>₱<?= number_format($item['product_price'], 2) ?></td>
                            <td><?= htmlspecialchars($item['product_description']) ?></td>
                            <td><?= htmlspecialchars($item['product_details']) ?></td>
                            <td><?= htmlspecialchars($item['product_category']) ?></td>
                            <td>
                                <a href="editor-edit-product.php?product_id=<?= $item['product_id'] ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                <a href="../process/editor-delete-product-process.php?product_id=<?= $item['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No items found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-4">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php require_once('../footer.php'); ?>
