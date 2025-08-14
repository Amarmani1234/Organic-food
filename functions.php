<?php
function kaddora_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kaddora'),
    ));
    load_theme_textdomain('kaddora', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'kaddora_theme_setup');

function kaddora_custom_post_types() {
    register_post_type('doctor', array(
        'labels' => array(
            'name' => __('Doctors', 'kaddora'),
            'singular_name' => __('Doctor', 'kaddora')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-users',
    ));
    
    register_post_type('service', array(
        'labels' => array(
            'name' => __('Services', 'kaddora'),
            'singular_name' => __('Service', 'kaddora')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-tools',
    ));
    
    register_post_type('department', array(
        'labels' => array(
            'name' => __('Departments', 'kaddora'),
            'singular_name' => __('Department', 'kaddora')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-building',
    ));
}
add_action('init', 'kaddora_custom_post_types');

//  Contact Info----------------------------

if ( ! function_exists( 'kaddora_customize_register' ) ) {
    function kaddora_customize_register( $wp_customize ) {
        $wp_customize->add_section('contact_info', array(
            'title'    => __('Contact Info', 'kaddora'),
            'priority' => 30,
        ));        
        $wp_customize->add_setting('phone_number', array(
            'default'           => '+98360994063',
            'sanitize_callback' => 'sanitize_text_field',
        ));       
        $wp_customize->add_control('phone_number', array(
            'label'   => __('Phone Number', 'kaddora'),
            'section' => 'contact_info',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('kaddora_email', array(
            'default'           => 'admin@gmail.com',
            'sanitize_callback' => 'sanitize_email',
        ));
        
        $wp_customize->add_control('kaddora_email', array(
            'label'   => __('Email Address', 'kaddora'),
            'section' => 'contact_info',
            'type'    => 'email',
        ));

        $wp_customize->add_section('social_media', array(
            'title'    => __('Social Media', 'kaddora'),
            'priority' => 35,
        ));

        // Social Media URLs
        $socials = array(
            'facebook_url'  => __('Facebook URL', 'kaddora'),
            'twitter_url'   => __('Twitter URL', 'kaddora'),
            'instagram_url' => __('Instagram URL', 'kaddora'),
            'linkedin_url'  => __('LinkedIn URL', 'kaddora'),
            'youtube_url'   => __('YouTube URL', 'kaddora'),
        );

        foreach ( $socials as $key => $label ) {
            $wp_customize->add_setting($key, array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control($key, array(
                'label'   => $label,
                'section' => 'social_media',
                'type'    => 'url',
            ));
        }
        
    $wp_customize->add_section('doctors_section', array(
        'title' => __('Doctors Section', 'kaddora'),
        'panel' => 'section_titles',
    ));
    
    $wp_customize->add_setting('doctors_title', array(
        'default' => 'Doctors',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('doctors_title', array(
        'label' => __('Title', 'kaddora'),
        'section' => 'doctors_section',
        'type' => 'text',
    ));
}
add_action('customize_register', 'kaddora_customize_register');
}
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $li_attributes = '';
        $class_names = $value = '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-menu dropdown-menu-end';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $active_class = ($item->current || $item->current_item_ancestor || in_array('current-page-ancestor', $classes)) ? 'active' : '';
        $nav_link_class = 'nav-link ' . $active_class;
        $attributes .= ($args->walker->has_children) ? ' class="' . $nav_link_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"' : ' class="' . $nav_link_class . '"';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

//-------------------Custom ---------------------
function kaddora_add_doctor_meta_boxes() {
    add_meta_box(
        'doctor_details',
        __('Doctor Details', 'kaddora'),
        'kaddora_doctor_meta_box_callback',
        'doctor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kaddora_add_doctor_meta_boxes');

function kaddora_doctor_meta_box_callback($post) {
    wp_nonce_field('kaddora_save_doctor_data', 'kaddora_doctor_meta_box_nonce');
    
    $position = get_post_meta($post->ID, 'doctor_position', true);
    $social_twitter = get_post_meta($post->ID, 'social_twitter', true);
    // Add other fields
    
    ?>
    <p>
        <label for="doctor_position"><?php _e('Position:', 'kaddora'); ?></label>
        <input type="text" id="doctor_position" name="doctor_position" value="<?php echo esc_attr($position); ?>" class="widefat">
    </p>
    <p>
        <label for="social_twitter"><?php _e('Twitter URL:', 'kaddora'); ?></label>
        <input type="url" id="social_twitter" name="social_twitter" value="<?php echo esc_url($social_twitter); ?>" class="widefat">
    </p>
    <?php
}

function kaddora_save_doctor_data($post_id) {
    if (!isset($_POST['kaddora_doctor_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['kaddora_doctor_meta_box_nonce'], 'kaddora_save_doctor_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['doctor_position'])) {
        update_post_meta($post_id, 'doctor_position', sanitize_text_field($_POST['doctor_position']));
    }
    
    if (isset($_POST['social_twitter'])) {
        update_post_meta($post_id, 'social_twitter', esc_url_raw($_POST['social_twitter']));
    }
}
add_action('save_post', 'kaddora_save_doctor_data');

function pageBanner($args = NULL) {
    if (!$args) {
        $args = array();
    }
    
    if (!isset($args['title']) || empty($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle']) || empty($args['subtitle'])) {
        if (function_exists('get_field') && get_field('page_banner_subtitle')) {
            $args['subtitle'] = get_field('page_banner_subtitle');
        } else {
            $args['subtitle'] = '';
        }
    }

    if (!isset($args['photo']) || empty($args['photo'])) {
        if (function_exists('get_field') && get_field('page_banner_background_image') && !is_archive() && !is_home()) {
            $image = get_field('page_banner_background_image');
            if ($image && isset($image['sizes']['pageBanner'])) {
                $args['photo'] = $image['sizes']['pageBanner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg'); 
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo esc_url($args['photo']); ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo esc_html($args['title']); ?></h1>
            <?php if ($args['subtitle']) : ?>
                <div class="page-banner__intro">
                    <p><?php echo esc_html($args['subtitle']); ?></p>
                </div>
            <?php endif; ?>
        </div>  
    </div>
    <?php 
}

function university_features() {
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
}
add_action('after_setup_theme','university_features');
//
function kaddora_enqueue_scripts() {
    $theme_uri = get_template_directory_uri();    
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

function kaddora_enqueue_styles() {s
    $theme_uri = get_template_directory_uri();
    
    wp_enqueue_style('bootstrap', $theme_uri . '/assets/bootstrap4/bootstrap.min.css');    
    wp_enqueue_style('font-awesome', $theme_uri . '/assets/css/font-awesome.min.css');
    wp_enqueue_style('owl-carousel', $theme_uri . '/assets/css/owl.carousel.css');
    wp_enqueue_style('owl-theme', $theme_uri . '/assets/css/owl.theme.default.css');
    wp_enqueue_style('animate', $theme_uri . '/assets/css/animate.css');
    wp_enqueue_style('kaddora-main-style', $theme_uri . '/assets/css/main_styles.css');
    wp_enqueue_style('kaddora-responsive', $theme_uri . '/assets/css/responsive.css');
    
    wp_enqueue_style('kaddora-google-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);
    
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css');
}
add_action('wp_enqueue_scripts', 'kaddora_enqueue_styles');
//
function medilab_customize_register($wp_customize) {

    $wp_customize->add_section('medilab_hero_section', array(
        'title'    => __('Hero Section', 'medilab'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('medilab_hero_bg', array(
        'default'   => get_template_directory_uri() . '/assets/img/hero-bg.jpg',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'medilab_hero_bg', array(
        'label'    => __('Hero Background Image', 'medilab'),
        'section'  => 'medilab_hero_section',
        'settings' => 'medilab_hero_bg',
    )));
    
    $wp_customize->add_setting('medilab_welcome_title', array(
        'default'   => 'WELCOME TO MEDILAB',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_welcome_title', array(
        'label'    => __('Welcome Title', 'medilab'),
        'section'  => 'medilab_hero_section',
        'type'     => 'text',
    ));
    
  
    $wp_customize->add_setting('medilab_welcome_subtitle', array(
        'default'   => 'We are team of talented designers making websites with Bootstrap',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_welcome_subtitle', array(
        'label'    => __('Welcome Subtitle', 'medilab'),
        'section'  => 'medilab_hero_section',
        'type'     => 'textarea',
    ));
    

    $wp_customize->add_section('medilab_why_section', array(
        'title'    => __('Why Choose Section', 'medilab'),
        'priority' => 31,
    ));
    
    $wp_customize->add_setting('medilab_why_title', array(
        'default'   => 'Why Choose Medilab?',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_why_title', array(
        'label'    => __('Why Title', 'medilab'),
        'section'  => 'medilab_why_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('medilab_why_content', array(
        'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad corporis.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_why_content', array(
        'label'    => __('Why Content', 'medilab'),
        'section'  => 'medilab_why_section',
        'type'     => 'textarea',
    ));
    
    $wp_customize->add_setting('medilab_why_link', array(
        'default'   => '#about',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_why_link', array(
        'label'    => __('Why Link URL', 'medilab'),
        'section'  => 'medilab_why_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('medilab_why_link_text', array(
        'default'   => 'Learn More',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('medilab_why_link_text', array(
        'label'    => __('Why Link Text', 'medilab'),
        'section'  => 'medilab_why_section',
        'type'     => 'text',
    ));
    
    $wp_customize->add_section('medilab_icon_boxes_section', array(
        'title'    => __('Icon Boxes', 'medilab'),
        'priority' => 32,
    ));
    

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting('medilab_icon_box_icon_' . $i, array(
            'default'   => ($i == 1 ? 'bi-clipboard-data' : ($i == 2 ? 'bi-gem' : 'bi-inboxes')),
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('medilab_icon_box_icon_' . $i, array(
            'label'    => sprintf(__('Icon Box %d Icon Class', 'medilab'), $i),
            'section'  => 'medilab_icon_boxes_section',
            'type'     => 'text',
            'description' => __('Use Bootstrap Icons class names (e.g., "bi-clipboard-data")', 'medilab'),
        ));
        
        $wp_customize->add_setting('medilab_icon_box_title_' . $i, array(
            'default'   => ($i == 1 ? 'Corporis voluptates officia eiusmod' : 
                           ($i == 2 ? 'Ullamco laboris ladore pan' : 'Labore consequatur incidid dolore')),
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('medilab_icon_box_title_' . $i, array(
            'label'    => sprintf(__('Icon Box %d Title', 'medilab'), $i),
            'section'  => 'medilab_icon_boxes_section',
            'type'     => 'text',
        ));
        
        $wp_customize->add_setting('medilab_icon_box_content_' . $i, array(
            'default'   => ($i == 1 ? 'Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip' : 
                           ($i == 2 ? 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt' : 
                            'Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere')),
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('medilab_icon_box_content_' . $i, array(
            'label'    => sprintf(__('Icon Box %d Content', 'medilab'), $i),
            'section'  => 'medilab_icon_boxes_section',
            'type'     => 'textarea',
        ));
    }
}
add_action('customize_register', 'medilab_customize_register');

//------------------------Header LOgo------------------------------>
function mytheme_custom_logo_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 50,
        'width'       => 50, 
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'mytheme_custom_logo_setup');
//-------------------------End Logo-------------------------------->

//------------------------------Footer----------------------------->
function mytheme_register_menus() {
    register_nav_menus([
        'social-menu' => __('Social Media Links', 'mytheme'),
        'footerLocationOne' => __('Footer Useful Links', 'mytheme'),
        'footerLocationTwo' => __('Footer Our Services', 'mytheme'),
    ]);
}
add_action('init', 'mytheme_register_menus');

// Footer customizer settings
function mytheme_footer_customize_register($wp_customize) {
    // Address
    $wp_customize->add_setting('footer_address', [
        'default' => '1st FLOOR, B-33, SECTOR 63, NOIDA, 201301',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    
    $wp_customize->add_control('footer_address', [
        'label' => __('Footer Address', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'textarea',
    ]);
    
    // Phone
    $wp_customize->add_setting('footer_phone', [
        'default' => '+91 8360994063',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('footer_phone', [
        'label' => __('Footer Phone', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ]);
    
    // Email
    $wp_customize->add_setting('footer_email', [
        'default' => 'theme@kaddora.com',
        'sanitize_callback' => 'sanitize_email',
    ]);
    
    $wp_customize->add_control('footer_email', [
        'label' => __('Footer Email', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'email',
    ]);
    
    // Custom Links Section----------------------------------
    $wp_customize->add_setting('mytheme_footer_title', [
        'default' => 'Hic solutasetp',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('mytheme_footer_title', [
        'label' => __('Custom Footer Links Title', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ]);

        $wp_customize->add_setting('mytheme_footer_links', [
        'default' => 'Ipsam,Laudantium dolorum,Dinera,Trodelas,Flexo',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

        $wp_customize->add_control('mytheme_footer_links', [
        'label' => __('Custom Footer Links (comma separated)', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ]);
//------------------------fourth footer----------------------
        $wp_customize->add_setting('mytheme_footer_titles', [
        'default' => 'Hic solutasetp',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('mytheme_footer_titles', [
        'label' => __('Custom Footer Links Title', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_setting('mytheme_footer_linkss', [
        'default' => 'Kaddora,Laudantium dolorum,Dinera,Trodelas,Flexo',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('mytheme_footer_linkss', [
        'label' => __('Custom Footer Links (comma separated)', 'mytheme'),
        'section' => 'footer_section',
        'type' => 'text',
    ]);
    
    $wp_customize->add_section('footer_section', [
        'title' => __('Footer Settings', 'mytheme'),
        'priority' => 120,
    ]);
}
add_action('customize_register', 'mytheme_footer_customize_register');
//---------------------------End Footer---------------------------->

//------------------Doctor Section--------------------------------->

function theme_customize_stats_register($wp_customize) {
    // Add Stats Section
    $wp_customize->add_section('stats_section', array(
        'title'    => __('Stats Section', 'your-theme-textdomain'),
        'priority' => 120,
    ));

    // Define stats items
    $stats_items = array(
        'stat_doctors'     => array('default_icon' => 'fa-solid fa-user-doctor', 'default_label' => 'Doctors'),
        'stat_departments' => array('default_icon' => 'fa-regular fa-hospital', 'default_label' => 'Departments'),
        'stat_labs'        => array('default_icon' => 'fas fa-flask', 'default_label' => 'Labs'),
        'stat_awards'      => array('default_icon' => 'fas fa-award', 'default_label' => 'Awards')
    );

    // Loop through stats items and add controls
    foreach ($stats_items as $key => $item) {
        // Number setting
        $wp_customize->add_setting($key . '_number', array(
            'default'   => 0,
            'transport' => 'refresh',
            'sanitize_callback' => 'absint'
        ));
        
        $wp_customize->add_control($key . '_number', array(
            'label'    => sprintf(__('%s Number', 'your-theme-textdomain'), $item['default_label']),
            'section'  => 'stats_section',
            'type'     => 'number',
        ));

        // Label setting
        $wp_customize->add_setting($key . '_label', array(
            'default'   => $item['default_label'],
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control($key . '_label', array(
            'label'    => sprintf(__('%s Label', 'your-theme-textdomain'), $item['default_label']),
            'section'  => 'stats_section',
            'type'     => 'text',
        ));

        // Icon setting
        $wp_customize->add_setting($key . '_icon', array(
            'default'   => $item['default_icon'],
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control($key . '_icon', array(
            'label'    => sprintf(__('%s Icon', 'your-theme-textdomain'), $item['default_label']),
            'section'  => 'stats_section',
            'type'     => 'text',
            'description' => __('Use Font Awesome icon classes', 'your-theme-textdomain'),
        ));
    }
}
add_action('customize_register', 'theme_customize_stats_register');
//---------------End doctor Section--------------------------------->

//-----------------------------------Services Section---------------->
function mytheme_customize_register($wp_customize) {
    // Create a new section for Services (better than using 'title_tagline')
    $wp_customize->add_section('services_section', array(
        'title'    => __('Services Section', 'your-textdomain'),
        'priority' => 120,
    ));

    // Services Section Title
    $wp_customize->add_setting('services_title', array(
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('services_title', array(
        'label'    => __('Services Section Title', 'your-textdomain'),
        'section'  => 'services_section',
        'type'     => 'text',
    ));

    // Services Section Subtitle
    $wp_customize->add_setting('services_subtitle', array(
        'default'           => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('services_subtitle', array(
        'label'    => __('Services Section Subtitle', 'your-textdomain'),
        'section'  => 'services_section',
        'type'     => 'textarea', // Changed to textarea for better multiline support
    ));

    // Number of Services to Show
    $wp_customize->add_setting('services_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('services_count', array(
        'label'       => __('Number of Services to Show', 'your-textdomain'),
        'section'     => 'services_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    // Add settings for each service item (up to the maximum number)
    for ($i = 1; $i <= 20; $i++) {
        // Service Title
        $wp_customize->add_setting("service_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("service_{$i}_title", array(
            'label'    => sprintf(__('Service %d Title', 'your-textdomain'), $i),
            'section'  => 'services_section',
            'type'     => 'text',
            'active_callback' => function() use ($i) {
                return get_theme_mod('services_count', 6) >= $i;
            },
        ));

        // Service Description
        $wp_customize->add_setting("service_{$i}_description", array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("service_{$i}_description", array(
            'label'    => sprintf(__('Service %d Description', 'your-textdomain'), $i),
            'section'  => 'services_section',
            'type'     => 'textarea',
            'active_callback' => function() use ($i) {
                return get_theme_mod('services_count', 6) >= $i;
            },
        ));

        // Service Icon
        $wp_customize->add_setting("service_{$i}_icon", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("service_{$i}_icon", array(
            'label'    => sprintf(__('Service %d Icon Class (Font Awesome)', 'your-textdomain'), $i),
            'section'  => 'services_section',
            'type'     => 'text',
            'description' => __('Example: fas fa-heartbeat', 'your-textdomain'),
            'active_callback' => function() use ($i) {
                return get_theme_mod('services_count', 6) >= $i;
            },
        ));
    }
}
add_action('customize_register', 'mytheme_customize_register');
//------------------End Services section----------------------------->


//---------------------Department-------------------------------------->

function customize_departments_section($wp_customize) {

    $wp_customize->add_section('departments_section', array(
        'title'    => __('Departments Section', 'your-theme'),
        'priority' => 120,
    ));

    // Section Title
    $wp_customize->add_setting('departments_title', array(
        'default'           => 'Departments',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('departments_title', array(
        'label'    => __('Section Title', 'your-theme'),
        'section'  => 'departments_section',
        'type'     => 'text',
    ));

    // Section Subtitle
    $wp_customize->add_setting('departments_subtitle', array(
        'default'           => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('departments_subtitle', array(
        'label'    => __('Section Subtitle', 'your-theme'),
        'section'  => 'departments_section',
        'type'     => 'textarea',
    ));

    // Departments Repeater
    $wp_customize->add_setting('departments_repeater', array(
        'default' => '',
        'sanitize_callback' => 'your_theme_sanitize_repeater',
    ));
    $wp_customize->add_control(new Your_Theme_Repeater_Control($wp_customize, 'departments_repeater', array(
        'label' => __('Departments', 'your-theme'),
        'section' => 'departments_section',
        'box_title' => __('Department', 'your-theme'),
        'add_label' => __('Add Department', 'your-theme'),
        'fields' => array(
            'title' => array(
                'type' => 'text',
                'label' => __('Title', 'your-theme'),
                'default' => '',
            ),
            'subtitle' => array(
                'type' => 'text',
                'label' => __('Subtitle', 'your-theme'),
                'default' => '',
            ),
            'description' => array(
                'type' => 'textarea',
                'label' => __('Description', 'your-theme'),
                'default' => '',
            ),
            'image' => array(
                'type' => 'media',
                'label' => __('Image', 'your-theme'),
                'default' => '',
            ),
        ),
    )));
}
add_action('customize_register', 'customize_departments_section');

// Sanitize repeater value
function your_theme_sanitize_repeater($input) {
    $input_decoded = json_decode($input, true);
    if (!empty($input_decoded)) {
        foreach ($input_decoded as $box_key => $box) {
            foreach ($box as $key => $value) {
                $input_decoded[$box_key][$key] = wp_kses_post(force_balance_tags($value));
            }
        }
        return json_encode($input_decoded);
    }
    return $input;
}

// Repeater Control Class
if (class_exists('WP_Customize_Control')) {
    class Your_Theme_Repeater_Control extends WP_Customize_Control {
        public $type = 'repeater';
        public $box_title = '';
        public $add_label = '';
        public $fields = array();

        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <div class="your-theme-repeater-control" data-fields='<?php echo json_encode($this->fields); ?>' 
                 data-box-title="<?php echo esc_attr($this->box_title); ?>" 
                 data-add-label="<?php echo esc_attr($this->add_label); ?>">
                <div class="repeater-fields">
                    <?php
                    if (!empty($this->value())) {
                        $boxes = json_decode($this->value());
                        if (!empty($boxes)) {
                            foreach ($boxes as $box) {
                                ?>
                                <div class="repeater-box">
                                    <div class="repeater-box-title"><?php echo esc_html($this->box_title); ?></div>
                                    <div class="repeater-box-content">
                                        <?php
                                        foreach ($this->fields as $field_key => $field) {
                                            $value = isset($box->$field_key) ? $box->$field_key : '';
                                            ?>
                                            <div class="repeater-field">
                                                <label><?php echo esc_html($field['label']); ?></label>
                                                <?php
                                                switch ($field['type']) {
                                                    case 'text':
                                                        echo '<input type="text" class="repeater-field-' . esc_attr($field_key) . '" value="' . esc_attr($value) . '">';
                                                        break;
                                                    case 'textarea':
                                                        echo '<textarea class="repeater-field-' . esc_attr($field_key) . '">' . esc_textarea($value) . '</textarea>';
                                                        break;
                                                    case 'media':
                                                        $image_url = $value;
                                                        $image_class = empty($image_url) ? 'hidden' : '';
                                                        ?>
                                                        <div class="repeater-media-upload">
                                                            <div class="repeater-media-preview <?php echo esc_attr($image_class); ?>">
                                                                <img src="<?php echo esc_url($image_url); ?>" alt="">
                                                            </div>
                                                            <input type="hidden" class="repeater-field-<?php echo esc_attr($field_key); ?>" value="<?php echo esc_url($image_url); ?>">
                                                            <button type="button" class="button repeater-media-upload-btn"><?php _e('Select Image'); ?></button>
                                                            <button type="button" class="button repeater-media-remove-btn"><?php _e('Remove'); ?></button>
                                                        </div>
                                                        <?php
                                                        break;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <button type="button" class="button repeater-box-remove"><?php _e('Remove'); ?></button>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <button type="button" class="button repeater-add"><?php echo esc_html($this->add_label); ?></button>
                <input type="hidden" class="repeater-data" <?php $this->link(); ?>>
            </div>
            <?php
        }
    }
}
//-------------------------End Department------------------------->
//------------------------Doctors--------------------------------->
function customize_doctors_section($wp_customize) {
    // Add Doctors Section
    $wp_customize->add_section('doctors_section', array(
        'title'    => __('Doctors Section', 'your-theme'),
        'priority' => 130,
    ));

    // Section Title
    $wp_customize->add_setting('doctors_title', array(
        'default'           => 'Doctors',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('doctors_title', array(
        'label'    => __('Section Title', 'your-theme'),
        'section'  => 'doctors_section',
        'type'     => 'text',
    ));

    // Section Subtitle
    $wp_customize->add_setting('doctors_subtitle', array(
        'default'           => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('doctors_subtitle', array(
        'label'    => __('Section Subtitle', 'your-theme'),
        'section'  => 'doctors_section',
        'type'     => 'textarea',
    ));

    // Doctors Repeater
    $wp_customize->add_setting('doctors_repeater', array(
        'default' => '',
        'sanitize_callback' => 'your_theme_sanitize_repeater',
    ));
    $wp_customize->add_control(new Your_Theme_Repeater_Control($wp_customize, 'doctors_repeater', array(
        'label' => __('Doctors', 'your-theme'),
        'section' => 'doctors_section',
        'box_title' => __('Doctor', 'your-theme'),
        'add_label' => __('Add Doctor', 'your-theme'),
        'fields' => array(
            'name' => array(
                'type' => 'text',
                'label' => __('Name', 'your-theme'),
                'default' => '',
            ),
            'position' => array(
                'type' => 'text',
                'label' => __('Position', 'your-theme'),
                'default' => '',
            ),
            'description' => array(
                'type' => 'textarea',
                'label' => __('Description', 'your-theme'),
                'default' => '',
            ),
            'image' => array(
                'type' => 'media',
                'label' => __('Image', 'your-theme'),
                'default' => '',
            ),
            'twitter' => array(
                'type' => 'text',
                'label' => __('Twitter URL', 'your-theme'),
                'default' => '',
            ),
            'facebook' => array(
                'type' => 'text',
                'label' => __('Facebook URL', 'your-theme'),
                'default' => '',
            ),
            'instagram' => array(
                'type' => 'text',
                'label' => __('Instagram URL', 'your-theme'),
                'default' => '',
            ),
            'linkedin' => array(
                'type' => 'text',
                'label' => __('LinkedIn URL', 'your-theme'),
                'default' => '',
            ),
        ),
    )));
}
add_action('customize_register', 'customize_doctors_section');
//---------------------End Doctor----------------------------->
//--------------------Frequently------------------------------>
function customize_faq_section($wp_customize) {
  
    $wp_customize->add_section('faq_section', array(
        'title'    => __('FAQ Section', 'kaddora'),
        'priority' => 140,
    ));

    $wp_customize->add_setting('faq_title', array(
        'default'           => 'Frequently Asked Questions',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('faq_title', array(
        'label'    => __('Section Title', 'kaddora'),
        'section'  => 'faq_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('faq_subtitle', array(
        'default'           => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('faq_subtitle', array(
        'label'    => __('Section Subtitle', 'kaddora'),
        'section'  => 'faq_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'customize_faq_section');

//-------------------Testimonials----------------------------->
function kaddora_register_testimonial_cpt() {
    $labels = array(
        'name'               => __('Testimonials', 'kaddora'),
        'singular_name'      => __('Testimonial', 'kaddora'),
        'add_new'            => __('Add New', 'kaddora'),
        'add_new_item'       => __('Add New Testimonial', 'kaddora'),
        'edit_item'          => __('Edit Testimonial', 'kaddora'),
        'new_item'           => __('New Testimonial', 'kaddora'),
        'view_item'          => __('View Testimonial', 'kaddora'),
        'search_items'       => __('Search Testimonials', 'kaddora'),
        'not_found'          => __('No Testimonials Found', 'kaddora'),
        'not_found_in_trash' => __('No Testimonials found in Trash', 'kaddora'),
        'menu_name'          => __('Testimonials', 'kaddora')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonial'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'          => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-testimonial',
        'show_in_rest'       => true
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'kaddora_register_testimonial_cpt');

function kaddora_add_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'kaddora'),
        'kaddora_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kaddora_add_testimonial_meta_boxes');

function kaddora_testimonial_meta_box_callback($post) {
    wp_nonce_field('kaddora_testimonial_save_meta', 'kaddora_testimonial_meta_nonce');
    
    $position = get_post_meta($post->ID, '_testimonial_position', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    ?>
    <p>
        <label for="testimonial_position"><?php _e('Position/Role', 'kaddora'); ?></label>
        <input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr($position); ?>" class="widefat">
    </p>
    <p>
        <label for="testimonial_rating"><?php _e('Star Rating (1-5)', 'kaddora'); ?></label>
        <select id="testimonial_rating" name="testimonial_rating" class="widefat">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <?php
}

function kaddora_save_testimonial_meta($post_id) {
    if (!isset($_POST['kaddora_testimonial_meta_nonce']) || 
        !wp_verify_nonce($_POST['kaddora_testimonial_meta_nonce'], 'kaddora_testimonial_save_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['testimonial_position'])) {
        update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['testimonial_position']));
    }

    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', absint($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'kaddora_save_testimonial_meta');

function kaddora_customize_testimonials($wp_customize) {
    $wp_customize->add_section('kaddora_testimonials_section', array(
        'title' => __('Testimonials Section', 'kaddora'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('testimonials_title', array(
        'default' => 'Testimonials',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('testimonials_title', array(
        'label' => __('Title', 'kaddora'),
        'section' => 'kaddora_testimonials_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('testimonials_description', array(
        'default' => 'What our clients say about us.',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('testimonials_description', array(
        'label' => __('Description', 'kaddora'),
        'section' => 'kaddora_testimonials_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'kaddora_customize_testimonials');
//-------------------------End Testimonial--------------------->
//-------------------Gallery Start------------------------------>

// Gallery Custom Post Type
function kaddora_register_gallery_cpt() {
    $labels = array(
        'name'               => __('Gallery', 'kaddora'),
        'singular_name'      => __('Gallery Item', 'kaddora'),
        'add_new'            => __('Add New Image', 'kaddora'),
        'add_new_item'       => __('Add New Gallery Image', 'kaddora'),
        'edit_item'          => __('Edit Gallery Image', 'kaddora'),
        'new_item'           => __('New Gallery Image', 'kaddora'),
        'view_item'          => __('View Gallery Image', 'kaddora'),
        'search_items'       => __('Search Gallery Images', 'kaddora'),
        'not_found'          => __('No images found', 'kaddora'),
        'not_found_in_trash' => __('No images found in Trash', 'kaddora'),
        'menu_name'          => __('Gallery', 'kaddora')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'           => array('slug' => 'gallery'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'          => array('title', 'thumbnail'),
        'menu_icon'         => 'dashicons-format-gallery',
        'show_in_rest'       => true,
    );

    register_post_type('gallery', $args);
}
add_action('init', 'kaddora_register_gallery_cpt');

// Gallery Customizer
function kaddora_customize_gallery_section($wp_customize) {
    $wp_customize->add_section('kaddora_gallery_section', array(
        'title'    => __('Gallery Section', 'kaddora'),
        'priority' => 31,
    ));

    $wp_customize->add_setting('gallery_title', array(
        'default'           => 'Gallery',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('gallery_title', array(
        'label'   => __('Gallery Section Title', 'kaddora'),
        'section' => 'kaddora_gallery_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('gallery_description', array(
        'default'           => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('gallery_description', array(
        'label'   => __('Gallery Description', 'kaddora'),
        'section' => 'kaddora_gallery_section',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'kaddora_customize_gallery_section');

//-------------------End Gallery--------------------------------->
// ------------------Contact Field------------------------------->

// Contact Customizer
function kaddora_contact_customizer($wp_customize) {
    $wp_customize->add_section('kaddora_contact_section', array(
        'title'    => __('Contact Section', 'kaddora'),
        'priority' => 120,
    ));
    
    $wp_customize->add_setting('contact_title', array(
        'default'   => 'Contact',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('contact_title', array(
        'label'    => __('Contact Title', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'text'
    ));

    $wp_customize->add_setting('contact_subtitle', array(
        'default'   => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    $wp_customize->add_control('contact_subtitle', array(
        'label'    => __('Contact Subtitle', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'textarea'
    ));
    
    $wp_customize->add_setting('contact_address', array(
        'default'   => '1st FLOOR, B-33, SECTOR 63, NOIDA, 201301',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('contact_address', array(
        'label'    => __('Address', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'text'
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default'   => '+91 8360994063',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Phone Number', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'text'
    ));

    $wp_customize->add_setting('contact_email', array(
        'default'   => 'theme@kaddora.com',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('contact_email', array(
        'label'    => __('Email Address', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'email'
    ));

    $wp_customize->add_setting('contact_map_embed', array(
        'default'   => 'https://www.google.com/maps/embed?pb=...',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('contact_map_embed', array(
        'label'    => __('Google Maps Embed URL', 'kaddora'),
        'section'  => 'kaddora_contact_section',
        'type'     => 'url'
    ));
}
add_action('customize_register', 'kaddora_contact_customizer');

// Contact Form Database Table
function kaddora_create_contact_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kaddora_contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        subject varchar(255) NOT NULL,
        message text NOT NULL,
        ip_address varchar(45) NOT NULL,
        submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        is_read boolean DEFAULT 0 NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'kaddora_create_contact_table');

// Contact Form Submission Handler
function kaddora_handle_contact_submission() {
    if (isset($_POST['kaddora_contact_nonce']) && wp_verify_nonce($_POST['kaddora_contact_nonce'], 'kaddora_contact_submit')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'kaddora_contact_submissions';

        $data = array(
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'subject' => sanitize_text_field($_POST['subject']),
            'message' => sanitize_textarea_field($_POST['message']),
            'ip_address' => $_SERVER['REMOTE_ADDR']
        );

        $wpdb->insert($table_name, $data);

        // Send email notification
        $to = get_theme_mod('contact_email', get_option('admin_email'));
        $subject = "New Contact Submission: " . $data['subject'];
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $email_body = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> {$data['name']}</p>
            <p><strong>Email:</strong> {$data['email']}</p>
            <p><strong>Subject:</strong> {$data['subject']}</p>
            <p><strong>Message:</strong></p>
            <p>{$data['message']}</p>
            <p><strong>IP Address:</strong> {$data['ip_address']}</p>
            <p><strong>Date:</strong> " . current_time('mysql') . "</p>
        ";

        wp_mail($to, $subject, $email_body, $headers);

        wp_redirect(add_query_arg('contact_submitted', '1', wp_get_referer()));
        exit;
    }
}
add_action('admin_post_nopriv_kaddora_contact_submit', 'kaddora_handle_contact_submission');
add_action('admin_post_kaddora_contact_submit', 'kaddora_handle_contact_submission');

// Contact Submissions Admin Page
function kaddora_contact_admin_menu() {
    add_menu_page(
        __('Contact Submissions', 'kaddora'),
        __('Contact Submissions', 'kaddora'),
        'manage_options',
        'kaddora-contact-submissions',
        'kaddora_contact_submissions_page',
        'dashicons-email-alt',
        20
    );
}
add_action('admin_menu', 'kaddora_contact_admin_menu');

function kaddora_contact_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kaddora_contact_submissions';
    
    // Handle actions
    if (isset($_GET['action']) && isset($_GET['id']) && current_user_can('manage_options')) {
        $id = intval($_GET['id']);
        if ($_GET['action'] === 'mark_read') {
            $wpdb->update($table_name, array('is_read' => 1), array('id' => $id));
        } elseif ($_GET['action'] === 'mark_unread') {
            $wpdb->update($table_name, array('is_read' => 0), array('id' => $id));
        } elseif ($_GET['action'] === 'delete') {
            $wpdb->delete($table_name, array('id' => $id));
        }
    }

    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    
    echo '<div class="wrap"><h1>' . esc_html__('Contact Form Submissions', 'kaddora') . '</h1>';
    
    if ($submissions) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>IP</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr></thead><tbody>';
        
        foreach ($submissions as $sub) {
            $read_status = $sub->is_read ? 'read' : 'unread';
            echo '<tr class="' . $read_status . '">';
            echo '<td>' . $sub->id . '</td>';
            echo '<td>' . esc_html($sub->name) . '</td>';
            echo '<td>' . esc_html($sub->email) . '</td>';
            echo '<td>' . esc_html($sub->subject) . '</td>';
            echo '<td>' . esc_html(substr($sub->message, 0, 100)) . '...</td>';
            echo '<td>' . esc_html($sub->ip_address) . '</td>';
            echo '<td>' . esc_html($sub->submission_date) . '</td>';
            echo '<td>' . ($sub->is_read ? 'Read' : 'Unread') . '</td>';
            echo '<td>
                    <a href="?page=kaddora-contact-submissions&action=mark_' . ($sub->is_read ? 'unread' : 'read') . '&id=' . $sub->id . '">' . ($sub->is_read ? 'Mark Unread' : 'Mark Read') . '</a> | 
                    <a href="?page=kaddora-contact-submissions&action=delete&id=' . $sub->id . '" onclick="return confirm(\'Are you sure?\')">Delete</a> | 
                    <a href="#" onclick="alert(\'' . esc_js($sub->message) . '\')">View Full</a>
                  </td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>' . esc_html__('No submissions yet.', 'kaddora') . '</p>';
    }
    
    echo '</div>';
    echo '<style>
        tr.unread { font-weight: bold; }
        .widefat td, .widefat th { vertical-align: middle; }
    </style>';
}

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
