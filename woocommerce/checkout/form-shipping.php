<?php
defined( 'ABSPATH' ) || exit;

$fields = $checkout->get_checkout_fields( 'shipping' );
?>
<div class="woocommerce-shipping-fields">
    <h3><?php esc_html_e( 'Shipping details', 'woocommerce' ); ?></h3>

    <?php foreach ( $fields as $key => $field ) : ?>
        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    <?php endforeach; ?>
</div>
