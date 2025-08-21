<?php defined( 'ABSPATH' ) || exit; ?>

<div class="container my-5">
  <div class="row">
    
    <!-- LEFT SIDE: CART ITEMS -->
    <div class="col-md-8 m-10">
      <h2 class="mb-4">Cart</h2>
      <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Product</th>
              <th class="text-center">Quantity</th>
              <th class="text-end">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
              $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
              $product_id = $cart_item['product_id'];

              if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
            ?>
              <tr>
                <!-- Product Info -->
                <td>
                  <div class="d-flex align-items-center">
                    <div class="me-3">
                      <?php echo $_product->get_image( 'thumbnail', ['class'=>'img-fluid rounded'] ); ?>
                    </div>
                    <div>
                      <?php if ( ! $product_permalink ) : ?>
                        <span class="fw-bold"><?php echo $_product->get_name(); ?></span>
                      <?php else : ?>
                        <a href="<?php echo esc_url( $product_permalink ); ?>" class="fw-bold text-decoration-none">
                          <?php echo $_product->get_name(); ?>
                        </a>
                      <?php endif; ?>
                      <div>
                        <span class="text-muted text-decoration-line-through me-2">
                          <?php echo wc_price( $_product->get_regular_price() ); ?>
                        </span>
                        <span class="fw-bold">
                          <?php echo wc_price( $_product->get_sale_price() ?: $_product->get_price() ); ?>
                        </span>
                      </div>
                      <?php if ( $_product->is_on_sale() ) : ?>
                        <span class="badge bg-light text-dark mt-1">
                          SAVE <?php echo wc_price( $_product->get_regular_price() - $_product->get_sale_price() ); ?>
                        </span>
                      <?php endif; ?>
                      <div>
                        <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" 
                           class="small text-danger text-decoration-none">Remove item</a>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Quantity -->
                <td class="text-center">
                  <?php
                    woocommerce_quantity_input( [
                      'input_name'  => "cart[{$cart_item_key}][qty]",
                      'input_value' => $cart_item['quantity'],
                      'max_value'   => $_product->get_max_purchase_quantity(),
                      'min_value'   => 1,
                      'classes'     => ['form-control', 'text-center'],
                    ], $_product, false );
                  ?>
                </td>

                <!-- Subtotal -->
                <td class="text-end">
                  <?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?>
                </td>
              </tr>
            <?php endif; endforeach; ?>
          </tbody>
        </table>

        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-outline-secondary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
            Update Cart
          </button>
          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        </div>
      </form>
    </div>

    <!-- RIGHT SIDE: CART TOTALS -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Cart Totals</h5>
          <hr>
          <?php wc_get_template( 'cart/cart-totals.php' ); ?>
          <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-success w-100 mt-3" style="background-color:red;">
            Proceed to Checkout
          </a>
        </div>
      </div>
    </div>
    
  </div>
</div>
