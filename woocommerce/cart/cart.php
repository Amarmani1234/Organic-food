<?php
defined( 'ABSPATH' ) || exit;

wc_print_notices();
do_action( 'woocommerce_before_cart' ); ?>

<div class="container my-5">
    <h2 class="mb-4 text-center"><?php esc_html_e( 'Shopping Cart', 'woocommerce' ); ?></h2>

    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail"><?php esc_html_e( 'Image', 'woocommerce' ); ?></th>
                        <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                        <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                        <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                        <th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    do_action( 'woocommerce_before_cart_contents' );

                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        wc_get_template( 
                            'cart/cart-item.php', 
                            array( 
                                'cart_item_key' => $cart_item_key, 
                                'cart_item'     => $cart_item 
                            ) 
                        );
                    }

                    do_action( 'woocommerce_cart_contents' );
                    ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" 
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> <?php esc_html_e( 'Continue Shopping', 'woocommerce' ); ?>
            </a>

            <button type="submit" class="btn btn-primary px-4" name="update_cart">
                <i class="bi bi-arrow-repeat"></i> <?php esc_html_e( 'Update Cart', 'woocommerce' ); ?>
            </button>
        </div>

        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <div class="mt-5">
        <?php do_action( 'woocommerce_cart_collaterals' ); ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
