<?php
defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="col-md-6">
    <!-- Product Image -->
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <?php echo woocommerce_get_product_thumbnail( 'large' ); ?>
        </div>
    </div>
</div>

<div class="col-md-6">
    <!-- Product Details -->
    <h1 class="fw-bold mb-3"><?php the_title(); ?></h1>
    
    <p class="text-muted mb-3"><?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?></p>
    
    <div class="mb-3">
        <span class="fs-3 fw-bold text-success">
            <?php echo $product->get_price_html(); ?>
        </span>
    </div>

    <!-- Add to cart -->
    <div class="mb-4">
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>

    <!-- Meta Info -->
    <ul class="list-unstyled text-muted">
        <li><strong>Category:</strong> <?php echo wc_get_product_category_list( $product->get_id() ); ?></li>
        <li><strong>Tags:</strong> <?php echo wc_get_product_tag_list( $product->get_id() ); ?></li>
    </ul>
</div>
