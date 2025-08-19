<?php
/* Template Name: All Product Categories */
get_header(); ?>

<div class="container">
    <h1><?php the_title(); ?></h1>
    <div class="product-categories">
        <?php echo do_shortcode('[product_categories number="0" hide_empty="0"]'); ?>
    </div>
</div>

<?php get_footer(); ?>