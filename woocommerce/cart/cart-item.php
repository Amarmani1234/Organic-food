<?php
defined( 'ABSPATH' ) || exit;

$product   = $cart_item['data'];
$product_id = $cart_item['product_id'];

?>
<tr class="woocommerce-cart-form__cart-item">
    <td class="product-remove">
        <?php
        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
            '<a href="%s" class="remove" aria-label="%s">&times;</a>',
            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
            esc_html__( 'Remove this item', 'woocommerce' )
        ), $cart_item_key );
        ?>
    </td>
    <td class="product-thumbnail">
        <?php echo $product->get_image(); ?>
    </td>
    <td class="product-name">
        <?php echo $product->get_name(); ?>
    </td>
    <td class="product-price">
        <?php echo WC()->cart->get_product_price( $product ); ?>
    </td>
    <td class="product-quantity">
        <?php
        woocommerce_quantity_input( array(
            'input_name'  => "cart[{$cart_item_key}][qty]",
            'input_value' => $cart_item['quantity'],
        ), $product );
        ?>
    </td>
    <td class="product-subtotal">
        <?php echo WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ); ?>
    </td>
</tr>
