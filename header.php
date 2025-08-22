<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>


    <?php
    if (class_exists('WooCommerce')) {
        $cart = WC()->cart;
    }
    ?>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
      <div class="offcanvas-header">
        <h5 id="offcanvasCartLabel">My Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">

        <?php if (class_exists('WooCommerce') && $cart && !$cart->is_empty()): ?>
          <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item):
            $_product = $cart_item['data'];
            $product_id = $cart_item['product_id'];
            ?>
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
              <div>
                <strong><?php echo $_product->get_name(); ?></strong><br>
                <small>Qty: <?php echo $cart_item['quantity']; ?></small>
              </div>
              <span><?php echo WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?></span>
            </div>
          <?php endforeach; ?>

          <!-- Cart Footer -->
          <div class="mt-3">
            <div class="d-flex justify-content-between mb-2">
              <strong>Total:</strong>
              <strong><?php echo WC()->cart->get_cart_total(); ?></strong>
            </div>
            <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-primary w-100 mb-2">View Cart</a>
            <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-success w-100">Checkout</a>
          </div>

        <?php else: ?>
          <p>Your cart is empty.</p>
        <?php endif; ?>

      </div>
    </div>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">

      <div class="offcanvas-header justify-content-between">
        <h4 class="fw-normal text-uppercase fs-6">Menu</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">

        <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
          <li class="nav-item border-dashed active">
            <a href="/categories" class="nav-link d-flex align-items-center gap-3 text-dark p-2">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#fruits"></use>
              </svg>
              <span>Fruits and vegetables</span>
            </a>
          </li>
          <!-- Other menu items remain the same -->
        </ul>
      </div>
    </div>
    <header>
      <div class="container-fluid">
        <div class="row py-3 border-bottom align-items-center">

          <!-- Logo + Toggler -->
          <div class="col-6 col-md-2 d-flex align-items-center gap-3">
            <a href="<?php echo home_url(); ?>" class="text-decoration-none d-flex align-items-center">
              <h5 class="mb-0">Kaddora Organic</h5>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#menu"></use>
              </svg>
            </button>
          </div>

          <!-- Search -->
          <div class="col-12 col-md-5">
            <div class="search-bar d-flex bg-light p-2 rounded-4 align-items-center">
              <form id="search-form" class="flex-grow-1 me-2" action="<?php echo home_url('/'); ?>" method="get">
                <input type="text" name="s" class="form-control border-0 bg-transparent"
                  placeholder="Search for more than 20,000 products">
              </form>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor"
                  d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
              </svg>
            </div>
          </div>

          <!-- Placeholder Nav (optional) -->
          <div class="col-md-2 d-none d-md-flex justify-content-center">
            <ul class="navbar-nav list-unstyled d-flex flex-row gap-3 fw-bold text-uppercase text-dark mb-0">
              <!-- Example Nav items -->
            </ul>
          </div>

          <!-- Cart + Auth -->
          <div class="col-6 col-md-3 d-flex justify-content-end align-items-center gap-3">
            <ul class="d-flex list-unstyled mb-0 align-items-center gap-3">

              <li>
                <a href="#" class="p-2">
                  <svg width="24" height="24">
                    <use xlink:href="#wishlist"></use>
                  </svg>
                </a>
              </li>

              <li>
                <a href="javascript:void(0)" class="p-2 d-flex align-items-center text-decoration-none text-gray"
                  data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                  <svg width="24" height="24" class="me-1">
                    <use xlink:href="#shopping-bag"></use>
                  </svg>
                  My Cart
                </a>
              </li>

              <!-- Auth -->
              <div class="d-flex gap-2 auth-button">
                <?php if (is_user_logged_in()):
                  $current_user = wp_get_current_user(); ?>
                  <li class="nav-item">
                    <span class="nav-link text-gray">Welcome,
                      <?php echo esc_html($current_user->user_firstname); ?></span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo wp_logout_url(site_url('/login')); ?>">Logout</a>
                  </li>
                <?php else: ?>
                  <li class="nav-item <?php if (is_page('login') || wp_get_post_parent_id(0) == 181)
                    echo 'current-menu-item'; ?>">
                    <a class="nav-link" href="<?php echo site_url('/login'); ?>">Login</a>
                  </li>
                  <li class="nav-item <?php if (is_page('sign-up') || wp_get_post_parent_id(0) == 182)
                    echo 'current-menu-item'; ?>">
                    <a class="nav-link" href="<?php echo site_url('/sign-up'); ?>">Sign Up</a>
                  </li>
                <?php endif; ?>
              </div>

            </ul>
          </div>
        </div>
      </div>
    </header>


    <header style="background-color:#6bb252;">
      <div class="container">
        <div class="row py-3 border-bottom">
          <div class="col-12">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'footerLocationOne',
              'container' => false,
              'menu_class' => 'd-flex justify-content-center gap-3 gap-lg-4 fw-bold',
              'fallback_cb' => false,
              'items_wrap' => '<ul id="footer-menu" class="%2$s" style="color:white; list-style:none; padding:0; margin:0;">%3$s</ul>'
            ));
            ?>
          </div>
        </div>
      </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      window.addEventListener('load', function() {
        document.querySelector('.preloader-wrapper').style.display = 'none';
      });
    </script>
</body>
</html>