<?php
/**
 * Theme Functions
 * 
 * @package Kaddora
 */

// ============================
// Theme Setup
// ============================
function kaddora_theme_setup() {
    // Let WordPress handle <title> tags
    add_theme_support('title-tag');

    // Enable Featured Images
    add_theme_support('post-thumbnails');

    // Register Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kaddora'),
        'footer'  => __('Footer Menu', 'kaddora')
    ));
}
add_action('after_setup_theme', 'kaddora_theme_setup');

// ============================
// Enqueue Styles & Scripts
// ============================
function kaddora_enqueue_scripts() {
    $theme_uri = get_template_directory_uri();    

    // ==== CSS ====
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('vendor', $theme_uri . '/assets/css/vendor.css', array(), null);
    wp_enqueue_style('kaddora-style', $theme_uri . '/assets/css/style.css', array(), null);

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        array(),
        null
    );

    // ==== JS ====
    wp_enqueue_script('jquery');
    wp_enqueue_script('popper', $theme_uri . '/assets/bootstrap4/popper.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap', $theme_uri . '/assets/bootstrap4/bootstrap.min.js', array('jquery', 'popper'), null, true);    
    wp_enqueue_script('isotope', $theme_uri . '/assets/js/isotope.pkgd.min.js', array('jquery'), null, true);
    wp_enqueue_script('owl-carousel', $theme_uri . '/assets/js/owl.carousel.js', array('jquery'), null, true);
    wp_enqueue_script('easing', $theme_uri . '/assets/js/easing.js', array('jquery'), null, true);    
    wp_enqueue_script('kaddora-main', $theme_uri . '/assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('customizer-repeater', $theme_uri . '/assets/js/customizer-repeater.js', array('jquery'), null, true);
    wp_enqueue_script('faq', $theme_uri . '/assets/js/faq.js', array('jquery'), null, true);
    wp_enqueue_script('kaddora-appointment-form', $theme_uri . '/assets/js/appointment-form.js', array('jquery'), null, true);
    wp_enqueue_script('custom', $theme_uri . '/assets/js/custom.js', array('jquery'), null, true);
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'kaddora_enqueue_scripts');


