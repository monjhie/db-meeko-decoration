<?php require_once('user-header.php'); ?>
<?php include('../db-connection.php'); ?>

<?php
$settings_query = "SELECT * FROM tbl_settings LIMIT 1";
$settings_result = mysqli_query($conn, $settings_query);
$settings = mysqli_fetch_assoc($settings_result);

$headline = isset($settings['settings_headline']) ? $settings['settings_headline'] : "Meeko's Home Decorations";
$subheadline = isset($settings['settings_subheadline']) ? $settings['settings_subheadline'] : "Inspired by Meeko, Created for You.";
$textsection = isset($settings['settings_textsection']) ? $settings['settings_textsection'] : "Decorating your home is not just about filling a space with furniture, but creating a sanctuary that reflects your style, comfort, and the memories you cherish.";
$hero = isset($settings['settings_hero']) ? $settings['settings_hero'] : "hero";
?>

<div class="hero">
  <div class="container py-5">
    <div class="row mb-4 align-items-center flex-lg-row-reverse">
      <div class="col-md-6 col-xl-7 mb-4 mb-lg-0">
        <img src="../uploads/<?php echo htmlspecialchars($hero); ?>" alt="Hero" class="w-100 h-auto rounded">
      </div>

      <div class="col-md-6 col-xl-5 text-center text-md-start">
        <h1 class="fw-bolder display-4"><?php echo htmlspecialchars($headline); ?></h1>
        <p class="lead"><?php echo htmlspecialchars($subheadline); ?></p>
        <p class="quote"><?php echo htmlspecialchars($textsection); ?></p>
        <a class="btn btn-lg btn-primary" style="background-color: black;" href="user-shop.php" role="button">Shop Now</a>
      </div>
    </div>
  </div>
</div>

<div class="container py-5">
  <div class="row mb-4 text-center">
    <h2 class="fw-bold">Featured Products</h2>
  </div>

  <?php
  $sql = "SELECT product_id, product_name, product_photo FROM tbl_items";
  $result = mysqli_query($conn, $sql);
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $totalProducts = count($products);

  if ($totalProducts > 0) {
  ?>

  <div class="d-flex justify-content-center align-items-center mb-4">
    <button id="prevBtn" class="btn btn-dark me-3">&lt;</button>

    <div class="overflow-hidden" style="max-width: 100%; width: 100%;">
      <div id="productWrapper" class="d-flex" style="transition: transform 0.3s ease;">
        <?php foreach ($products as $product) { ?>
          <div class="card mx-2 shadow-sm product-card" style="width: 18rem; flex: 0 0 auto;">
            <img src="../uploads/<?= htmlspecialchars($product['product_photo']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
              <a href="view-product.php?product_id=<?= $product['product_id'] ?>" class="btn btn-dark">View</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <button id="nextBtn" class="btn btn-dark ms-3">&gt;</button>
  </div>

  <?php } else { ?>
    <p class="text-center">No products available.</p>
  <?php } ?>

</div>

<div class="container py-5">
  <div class="row mb-4 text-center">
    <h2 class="fw-bold">Have a Question or Inquiry?</h2>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-4">Product Inquiry</h5>

          <form action="submit-inquiry.php" method="POST">
            <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Your Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="inquiry" class="form-label">Your Inquiry/Problem</label>
              <textarea class="form-control" id="inquiry" name="inquiry" rows="4" required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary" style="background-color: black;">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once('../footer.php'); ?>

<script>
  $(document).ready(function() {
    var $wrapper = $('#productWrapper');
    var $cards = $('.product-card');
    var totalCards = $cards.length;
    var position = 0;
    var autoplayInterval;

    function getCardsPerView() {
      var width = $(window).width();
      if (width < 576) { return 1; } 
      else if (width < 768) { return 2; } 
      else { return 3; }
    }

    function updateCardWidth() {
      var cardsPerView = getCardsPerView();
      var containerWidth = $('.overflow-hidden').width();
      var cardWidth = containerWidth / cardsPerView - 16;
      $cards.css('width', cardWidth + 'px');
    }

    function slide() {
      var cardWidth = $('.product-card').outerWidth(true);
      var moveX = -position * cardWidth;
      $wrapper.css('transform', 'translateX(' + moveX + 'px)');
    }

    function nextSlide() {
      var cardsPerView = getCardsPerView();
      position++;
      if (position > totalCards - cardsPerView) {
        position = 0;
      }
      slide();
    }

    function prevSlide() {
      var cardsPerView = getCardsPerView();
      position--;
      if (position < 0) {
        position = totalCards - cardsPerView;
      }
      slide();
    }

    function startAutoplay() {
      autoplayInterval = setInterval(nextSlide, 3000);
    }

    function stopAutoplay() {
      clearInterval(autoplayInterval);
    }

    updateCardWidth();
    slide();
    startAutoplay();

    $(window).resize(function() {
      updateCardWidth();
      slide();
    });

    $('#nextBtn').click(function() {
      stopAutoplay();
      nextSlide();
      startAutoplay();
    });

    $('#prevBtn').click(function() {
      stopAutoplay();
      prevSlide();
      startAutoplay();
    });
  });
</script>
