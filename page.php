<?php get_header(); ?>
<section class="page-content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><?php the_title(); ?></h2>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <h1>Kaddora Organic Food Processing Noida</h2>
                
</article>
    <?php endwhile; ?>
    <?php endif; ?>
</section>


<?php if (has_post_thumbnail()) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail('professorLandscape'); ?>
        <?php the_post_thumbnail('professorPortrait'); ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>



