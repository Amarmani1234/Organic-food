<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' ); ?>

<div class="container my-5 shop-archive">
    <header class="woocommerce-products-header mb-4 text-center">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title display-5 fw-bold">
                <?php woocommerce_page_title(); ?>
            </h1>
        <?php endif; ?>

        <div class="text-muted">
            <?php do_action( 'woocommerce_archive_description' ); ?>
        </div>
    </header>

    <main class="shop-products">
        <?php if ( woocommerce_product_loop() ) : ?>

            <?php do_action( 'woocommerce_before_shop_loop' ); ?>

            <div class="row">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>
            </div>

            <?php do_action( 'woocommerce_after_shop_loop' ); ?>

        <?php else : ?>
            <div class="alert alert-warning text-center">
                <?php do_action( 'woocommerce_no_products_found' ); ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php get_footer( 'shop' ); ?>
