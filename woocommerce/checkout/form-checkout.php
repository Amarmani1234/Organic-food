<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( __( 'You must be logged in to checkout.', 'woocommerce' ) );
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-6">
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        </div>

        <div class="col-6">
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
