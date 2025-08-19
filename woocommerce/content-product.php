<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<div class="col-md-4 col-sm-6 mb-4">
    <div class="card h-100 shadow-sm border-0 hover-shadow transition">
        
        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', ['class' => 'card-img-top rounded-top'] ); ?>
            <?php else : ?>
                <img src="<?php echo wc_placeholder_img_src(); ?>" alt="Placeholder" class="card-img-top rounded-top" />
            <?php endif; ?>
        </a>

        <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2 text-truncate">
                <a href="<?php the_permalink(); ?>" class="text-dark fw-semibold">
                    <?php the_title(); ?>
                </a>
            </h5>

            <p class="card-text text-muted small mb-3">
                <?php echo wp_trim_words( get_the_excerpt(), 12 ); ?>
            </p>

            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold text-success">
                        <?php echo $product->get_price_html(); ?>
                    </span>
                    <?php woocommerce_template_loop_rating(); ?>
                </div>

                <?php woocommerce_template_loop_add_to_cart( [
                    'class' => 'btn btn-primary w-100 add_to_cart_button ajax_add_to_cart',
                ] ); ?>
            </div>
        </div>
    </div>
</div>
