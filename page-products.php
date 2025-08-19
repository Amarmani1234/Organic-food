<?php
/* Template Name: All Products */
get_header(); ?>

<div class="container my-5">
    <h1 class="text-center mb-4"><?php the_title(); ?></h1>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filter</h5>
                    <form method="GET" action="" class="row g-3">
                        <!-- Category -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Category</label>
                            <?php
                            wp_dropdown_categories(array(
                                'taxonomy' => 'product_cat',
                                'name'     => 'product_cat',
                                'orderby'  => 'name',
                                'show_option_all' => 'All Categories',
                                'value_field' => 'slug',
                                'selected' => isset($_GET['product_cat']) ? $_GET['product_cat'] : '',
                                'class'    => 'form-select'
                            ));
                            ?>
                        </div>

                        <!-- Price -->
                        <div class="col-6">
                            <label class="form-label fw-bold">Min Price</label>
                            <input type="number" name="min_price" class="form-control" placeholder="₹ Min"
                                   value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : ''; ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Max Price</label>
                            <input type="number" name="max_price" class="form-control" placeholder="₹ Max"
                                   value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : ''; ?>">
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-success w-100">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9 col-md-8">
            <div class="row g-4">
                <?php
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
                    while ($loop->have_posts()) : $loop->the_post(); ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <a href="<?php the_permalink(); ?>" class="d-flex justify-content-center align-items-center p-3">
                                    <?php woocommerce_template_loop_product_thumbnail(); ?>
                                </a>
                                <div class="card-body text-center">
                                    <h6 class="card-title"><?php the_title(); ?></h6>
                                    <p class="text-success fw-bold mb-2"><?php woocommerce_template_loop_price(); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-success">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                } else {
                    echo '<p class="text-center">No products found</p>';
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
