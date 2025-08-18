<?php
/* Template Name: All Products */
get_header(); ?>

<div class="container">
    <h1><?php the_title(); ?></h1>

    <!-- Filter Section -->
    <div class="product-filters">
        <form method="GET" action="">
            <div class="filter-item">
                <label for="category">Category:</label>
                <?php
                wp_dropdown_categories(array(
                    'taxonomy' => 'product_cat',
                    'name'     => 'product_cat',
                    'orderby'  => 'name',
                    'show_option_all' => 'All Categories',
                    'value_field' => 'slug',
                    'selected' => isset($_GET['product_cat']) ? $_GET['product_cat'] : ''
                ));
                ?>
            </div>

            <div class="filter-item">
                <label for="min_price">Price Range:</label>
                <input type="number" name="min_price" placeholder="Min" value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : ''; ?>">
                <input type="number" name="max_price" placeholder="Max" value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : ''; ?>">
            </div>

            <button type="submit">Apply Filters</button>
        </form>
    </div>

    <!-- Products Section -->
    <div class="products-list">
        <?php
        // Get filter values
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        if (!empty($_GET['product_cat'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['product_cat']),
                ),
            );
        }

        if (!empty($_GET['min_price']) || !empty($_GET['max_price'])) {
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => array(
                    !empty($_GET['min_price']) ? floatval($_GET['min_price']) : 0,
                    !empty($_GET['max_price']) ? floatval($_GET['max_price']) : 9999999
                ),
                'compare' => 'BETWEEN',
                'type'    => 'NUMERIC'
            );
        }

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
            woocommerce_product_loop_start();
            while ($loop->have_posts()) : $loop->the_post();
                wc_get_template_part('content', 'product');
            endwhile;
            woocommerce_product_loop_end();
        } else {
            echo '<p>No products found</p>';
        }
        wp_reset_postdata();
        ?>
    </div>
</div>

<?php get_footer(); ?>
