<?php require_once('header.php'); ?>
<?php include('db-connection.php'); ?>

<?php
$category_sql = "SELECT DISTINCT product_category FROM tbl_items ORDER BY product_category ASC";
$category_result = mysqli_query($conn, $category_sql);
?>

<style>
  .sticky-sidebar { position: sticky; top: 20px; }
  .search-container { margin-bottom: 15px; }
  @media (max-width: 767.98px) { .card img { height: 150px !important; } }
  @media (max-width: 575.98px) { .sticky-sidebar { position: static; } }

  .pagination a {
    color: black !important;
    background-color: white !important;
    border: 1px solid #dee2e6;
    padding: 6px 12px;
    margin: 0 3px;
    text-decoration: none;
    border-radius: 4px;
  }

  .pagination a.active {
    font-weight: bold;
    background-color: black !important;
    color: white !important;
    border-color: black;
  }

  .category-link {
    color: black;
  }

  .pagination a:hover {
    background-color: #f0f0f0 !important;
  }

  .category-link.active {
    background-color: black !important;
    color: white !important;
    padding: 6px 12px;
    border-radius: 4px;
    display: inline-block;
  }
</style>

<div class="container py-5">
  <h2 class="mb-4 fw-bold">Shop</h2>

  <div class="row">
    <div class="col-lg-3 mb-4 mb-lg-0">
      <div class="sticky-sidebar p-3 bg-light rounded shadow-sm">
        <div class="search-container">
          <input type="text" id="searchInput" class="form-control" placeholder="Search for products..." />
        </div>

        <h5 class="fw-bold mt-4">Categories</h5>
        <ul class="list-unstyled">
          <li class="mb-2">
            <a href="#" class="category-link text-decoration-none active" data-category="">All Products</a>
          </li>
          <?php while ($cat = mysqli_fetch_assoc($category_result)) : ?>
            <li class="mb-2">
              <a href="#" 
                 class="category-link text-decoration-none" 
                 data-category="<?= htmlspecialchars($cat['product_category']) ?>">
                <?= htmlspecialchars($cat['product_category']) ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>

        <h5 class="fw-bold mt-4">Price Range</h5>
        <div class="mb-2">
          <input type="number" id="minPrice" class="form-control" placeholder="Min Price" min="0" />
        </div>
        <div class="mb-2">
          <input type="number" id="maxPrice" class="form-control" placeholder="Max Price" min="0" />
        </div>
      </div>
    </div>

    <div class="col-lg-9">
      <div id="productList" class="row">
        <!-- Product 'to te -->
      </div>
      <div id="paginationLinks" class="mt-4">
        <!-- Sa Pagination ^_^ -->
      </div>
    </div>
  </div>
</div>

<?php require_once('footer.php'); ?>

<script>
$(document).ready(function(){

  let currentPage = 1;

  function loadProducts(page = 1, search = '', category = '', minPrice = '', maxPrice = '') {
    $.ajax({
      url: "search-products.php",
      type: "GET",
      data: { 
        page: page, 
        search: search, 
        category: category,
        minPrice: minPrice,
        maxPrice: maxPrice
      },
      dataType: "json",
      success: function(response) {
        $('#productList').html(response.products);
        $('#paginationLinks').html(response.pagination);
      }
    });
  }

  loadProducts();

  function triggerSearch() {
    const searchQuery = $('#searchInput').val();
    const selectedCategory = $('.category-link.active').data('category');
    const minPrice = $('#minPrice').val();
    const maxPrice = $('#maxPrice').val();
    currentPage = 1;
    loadProducts(currentPage, searchQuery, selectedCategory, minPrice, maxPrice);
  }

  $('#searchInput').on('keyup', triggerSearch);

  $(document).on('click', '.category-link', function(e) {
    e.preventDefault();
    $('.category-link').removeClass('active');
    $(this).addClass('active');
    triggerSearch();
  });

  $('#minPrice, #maxPrice').on('input', triggerSearch);

  $(document).on('click', '.pagination a', function(e) {
    e.preventDefault();
    currentPage = $(this).data('page');
    const searchQuery = $('#searchInput').val();
    const selectedCategory = $('.category-link.active').data('category');
    const minPrice = $('#minPrice').val();
    const maxPrice = $('#maxPrice').val();
    loadProducts(currentPage, searchQuery, selectedCategory, minPrice, maxPrice);
  });

});
</script>
