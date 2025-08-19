<?php
function kaddora_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support( 'woocommerce' );
    add_theme_support('post-thumbnails');

    register_nav_menus(array(
      
    ));
}
add_action('after_setup_theme', 'kaddora_theme_setup');


function university_features() {
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
}
add_action('after_setup_theme','university_features');

function kaddora_enqueue_assets() {
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', array(), null, 'all');
    wp_enqueue_style('vendor', get_template_directory_uri() . '/assets/css/vendor.css', array(), filemtime(get_template_directory() . '/assets/css/vendor.css'));
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css', array(), filemtime(get_template_directory() . '/assets/css/style.css'));

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);

    wp_enqueue_script('jquery-old', get_template_directory_uri() . '/assets/js/jquery-1.11.0.min.js', array(), filemtime(get_template_directory() . '/assets/js/jquery-1.11.0.min.js'), true);
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery-old'), filemtime(get_template_directory() . '/assets/js/plugins.js'), true);
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery-old'), filemtime(get_template_directory() . '/assets/js/script.js'), true);
}
add_action('wp_enqueue_scripts', 'kaddora_enqueue_assets');

//-

add_action('admin_post_nopriv_custom_login_action', 'custom_handle_user_login');
add_action('admin_post_custom_login_action', 'custom_handle_user_login');

function custom_handle_user_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'custom_login_action') {
        if (!session_id()) {
            session_start();
        }
        if (!isset($_POST['custom_login_nonce']) || !wp_verify_nonce($_POST['custom_login_nonce'], 'custom-login-nonce')) {
            $_SESSION['login_error'] = 'Security verification failed.';
            wp_safe_redirect(wp_get_referer());
            exit;
        }

        $creds = array();
        $creds['user_login'] = sanitize_user($_POST['user_login']);
        $creds['user_password'] = sanitize_text_field($_POST['user_pass']);
        $creds['remember'] = isset($_POST['rememberme']) ? true : false;

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            $_SESSION['login_error'] = $user->get_error_message();
            wp_safe_redirect(wp_get_referer());
            exit;
        } else {
            $_SESSION['login_success'] = 'Login successful!';
            wp_safe_redirect(home_url('/dashboard/')); 
            exit;
        }
    }
}
//
add_action('admin_post_nopriv_custom_user_register', 'handle_custom_user_register');
add_action('admin_post_custom_user_register', 'handle_custom_user_register');
function handle_custom_user_register() {
    if (!isset($_POST['custom_user_register_nonce']) || !wp_verify_nonce($_POST['custom_user_register_nonce'], 'custom_user_register')) {
        wp_die('Nonce verification failed.');
    }
    $name     = sanitize_text_field($_POST['name']);
    $email    = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    if (email_exists($email)) {
        wp_redirect(home_url('?register=exists'));
        exit;
    }
    $userdata = array(
        'user_login'    => $email,
        'user_email'    => $email,
        'user_pass'     => $password,
        'display_name'  => $name,
        'first_name'    => $name,
        'role'          => 'subscriber' 
    );
    $user_id = wp_insert_user($userdata);

    if (!is_wp_error($user_id)) {
        wp_redirect(home_url('?register=success'));
        exit;
    } else {
        wp_redirect(home_url('?register=error'));
        exit;
    }
}
//
add_action('after_setup_theme', 'initialize_woocommerce_image_sizes');
function initialize_woocommerce_image_sizes() {
    if (!function_exists('wc_get_image_size')) return;

    $image_sizes = array(
        'woocommerce_thumbnail' => array(
            'width'  => 300,
            'height' => 300,
            'crop'   => true
        ),
        'woocommerce_gallery_thumbnail' => array(
            'width'  => 100,
            'height' => 100,
            'crop'   => true
        )
    );
    foreach ($image_sizes as $name => $size) {
        $current_size = wc_get_image_size($name);
        
        if (empty($current_size) || !isset($current_size['width'])) {
            update_option("woocommerce_{$name}_width", $size['width']);
            update_option("woocommerce_{$name}_height", $size['height']);
            update_option("woocommerce_{$name}_crop", $size['crop'] ? 1 : 0);
        }
    }
}




