<?php
/**
 * Template for displaying WooCommerce Shop/Archive pages
 * Converted from Block Template to PHP, keeping same classes/styles
 *
 * @package Beauty_Ecommerce_X
 */

get_header();
?>

<main class="wp-block-group">

    <?php
    // WooCommerce Breadcrumbs
    if ( function_exists( 'woocommerce_breadcrumb' ) ) {
        echo '<div class="wp-block-woocommerce-breadcrumbs has-mono-2-color has-text-color">';
        woocommerce_breadcrumb();
        echo '</div>';
    }
    ?>

    <?php
    // Archive Title (Shop/Category)
    echo '<div class="wp-block-query-title alignwide">';
    woocommerce_page_title();
    echo '</div>';
    ?>

    <?php
    // Store Notices
    echo '<div class="wp-block-woocommerce-store-notices">';
    wc_print_notices();
    echo '</div>';
    ?>

    <div class="wp-block-group alignwide" style="display:flex;flex-wrap:nowrap;justify-content:space-between;">
        <div class="wp-block-woocommerce-product-results-count">
            <?php woocommerce_result_count(); ?>
        </div>

        <div class="wp-block-woocommerce-catalog-sorting">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>

    <div class="wp-block-woocommerce-product-collection alignwide">

        <?php if ( woocommerce_product_loop() ) : ?>

            <?php woocommerce_product_loop_start(); ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    <div <?php wc_product_class( 'wp-block-woocommerce-product-template', get_the_ID() ); ?>>

                        <div class="wp-block-woocommerce-product-image">
                            <?php woocommerce_template_loop_product_thumbnail(); ?>
                        </div>

                        <h3 class="wp-block-post-title has-text-align-center" style="margin-top:15px;margin-bottom:5px;font-size:22px;">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <div class="wp-block-woocommerce-product-price has-mono-2-color has-text-color has-superbfont-xsmall-font-size" style="text-align:center;margin-bottom:1.3rem;">
                            <?php woocommerce_template_loop_price(); ?>
                        </div>

                        <div class="wp-block-woocommerce-product-button" style="text-align:center;margin-bottom:1rem;font-size:15px;">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>

                    </div>
                <?php endwhile; ?>

            <?php woocommerce_product_loop_end(); ?>

            <div class="wp-block-group" style="padding-bottom:var(--wp--preset--spacing--superbspacing-medium)">
                <div class="wp-block-query-pagination" style="font-size:20px;display:flex;justify-content:center;">
                    <div class="wp-block-query-pagination-previous">
                        <?php previous_posts_link( __( '← Previous', 'woocommerce' ) ); ?>
                    </div>

                    <div class="wp-block-query-pagination-numbers">
                        <?php
                        global $wp_query;
                        echo paginate_links( array(
                            'total'   => $wp_query->max_num_pages,
                            'current' => max( 1, get_query_var( 'paged' ) ),
                            'mid_size'=> 1,
                        ) );
                        ?>
                    </div>

                    <div class="wp-block-query-pagination-next">
                        <?php next_posts_link( __( 'Next →', 'woocommerce' ), $wp_query->max_num_pages ); ?>
                    </div>
                </div>
            </div>

        <?php else : ?>

            <div class="wp-block-woocommerce-product-collection-no-results">
                <div class="wp-block-group" style="display:flex;flex-direction:column;justify-content:center;flex-wrap:wrap;">
                    <p class="has-medium-font-size"><strong><?php esc_html_e( 'No results found', 'woocommerce' ); ?></strong></p>
                    <p>
                        <?php esc_html_e( 'You can try', 'woocommerce' ); ?>
                        <a class="wc-link-clear-any-filters" href="#"><?php esc_html_e( 'clearing any filters', 'woocommerce' ); ?></a>
                        <?php esc_html_e( 'or head to our', 'woocommerce' ); ?>
                        <a class="wc-link-stores-home" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                            <?php esc_html_e( 'store\'s home', 'woocommerce' ); ?>
                        </a>
                    </p>
                </div>
            </div>

        <?php endif; ?>

    </div><!-- .wp-block-woocommerce-product-collection -->

</main>

<?php get_footer(); ?>
