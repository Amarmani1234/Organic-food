<?php
/* Template Name: Single Product */
get_header();
?>

<div class="container my-5">
    <div class="row">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
