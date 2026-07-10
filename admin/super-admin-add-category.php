<?php require_once('super-admin-header.php'); ?>

<style>
  .btn-black-delete {
    background-color: #000;
    color: #fff;
    border: 1px solid #000;
    transition: 0.3s ease;
  }
  .btn-black-delete:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
  }

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


  @media (max-width: 768px) {
    .btn-back {
      width: 100%; 
      text-align: center; 
    }

    .container {
      padding-left: 15px;
      padding-right: 15px;
    }
  }
</style>

<div class="container my-5">
  <div class="row mb-4">
    <div class="col-12">
      <a href="super-admin-products.php" class="btn btn-back">
        <i class="bi bi-arrow-left"></i> Go to product list
      </a>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12 col-md-6">
      <h2 class="text-dark">Category Types</h2>
    </div>
    <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
      <button id="addCategoryBtn" class="btn btn-dark">Add Category</button>
    </div>
  </div>

  <ul class="list-group" id="categoryList">
    <?php
      include('../db-connection.php');

      $result = $conn->query("SELECT * FROM tbl_category");

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<li class='list-group-item bg-white text-dark border-dark d-flex justify-content-between align-items-center' data-id='" . $row['category_id'] . "'>
                  " . htmlspecialchars($row['category_type']) . "
                  <button class='btn btn-sm btn-black-delete delete-category'>
                    <i class='bi bi-trash'></i>
                  </button>
                </li>";
        }
      } else {
        echo "<li class='list-group-item bg-white text-dark border-dark'>No categories found.</li>";
      }

    ?>
  </ul>

</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addCategoryForm" action="../process/add-category-process.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Enter category name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Save Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('#addCategoryBtn').click(function() {
      $('#addCategoryModal').modal('show');
    });

    $('#categoryList').on('click', '.delete-category', function() {
      var categoryId = $(this).closest('li').data('id');
      
      if (confirm("Are you sure you want to delete this category?")) {
        window.location.href = '../process/delete-category-process.php?id=' + categoryId;
      }
    });
  });
</script>

<?php require_once('../footer.php'); ?>
