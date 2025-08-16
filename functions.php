<?php
// Enqueue theme styles and scripts we add something
function kaddora_enqueue_assets() {
    // CSS
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', array(), null, 'all');
    wp_enqueue_style('vendor', get_template_directory_uri() . '/assets/css/vendor.css', array(), filemtime(get_template_directory() . '/assets/css/vendor.css'));
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(get_template_directory() . '/assets/css/style.css'));

    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);

    // JS
    wp_enqueue_script('jquery-old', get_template_directory_uri() . '/assets/js/jquery-1.11.0.min.js', array(), filemtime(get_template_directory() . '/assets/js/jquery-1.11.0.min.js'), true);
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery-old'), filemtime(get_template_directory() . '/assets/js/plugins.js'), true);
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery-old'), filemtime(get_template_directory() . '/assets/js/script.js'), true);
}
add_action('wp_enqueue_scripts', 'kaddora_enqueue_assets');
