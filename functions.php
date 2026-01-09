<?php
// Enqueue styles and scripts
function yuth_logistics_enqueue_assets() {
    // owl carousel css
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
    wp_enqueue_style('owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', array(), '2.3.4');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    
    // Fancybox CSS for gallery lightbox
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css', array(), '5.0');
    
    // my css file
    wp_enqueue_style('yuth-logistics-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    
    // built-in jQuery in wordpress
    wp_enqueue_script('jquery');
    
    // owl carousel js
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    
    // Fancybox JS for gallery lightbox
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', array('jquery'), '5.0', true);
    
    // custom script
    wp_enqueue_script('yuth-logistics-script', get_template_directory_uri() . '/js/script.js', array('jquery', 'owl-carousel-js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'yuth_logistics_enqueue_assets');


// Theme support
function yuth_logistics_setup() {
    // to manage the document title - no need to hardcode in header.php
    add_theme_support('title-tag');
    
    // featured images support
    add_theme_support('post-thumbnails');

    // Add custom image sizes
    add_image_size('blog-card-image', 280, 280, true);
    
    // custom logo support for header
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'yuth-logistics'),
        'footer'  => __('Footer Menu', 'yuth-logistics'),
        'mobile'  => __('Mobile Menu', 'yuth-logistics'),
    ));
}
add_action('after_setup_theme', 'yuth_logistics_setup');

// Add theme customizer options
function yuth_logistics_customize_register($wp_customize) {
    // Contact Information Section
    $wp_customize->add_section('contact_info', array(
        'title'    => __('Contact Information', 'yuth-logistics'),
        'priority' => 30,
    ));
    
    // Phone Number
    $wp_customize->add_setting('phone_number', array(
        'default'           => '+042 30 30 433',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('phone_number', array(
        'label'   => __('Phone Number', 'yuth-logistics'),
        'section' => 'contact_info',
        'type'    => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('email', array(
        'default'           => 'admin@youthlogistics.com.au',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('email', array(
        'label'   => __('Email', 'yuth-logistics'),
        'section' => 'contact_info',
        'type'    => 'email',
    ));
    
    // Address
    $wp_customize->add_setting('address', array(
        'default'           => 'Beaconsfield, Victoria 3807',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('address', array(
        'label'   => __('Address', 'yuth-logistics'),
        'section' => 'contact_info',
        'type'    => 'text',
    ));
    
    // Social Media Section
    $wp_customize->add_section('social_media', array(
        'title'    => __('Social Media', 'yuth-logistics'),
        'priority' => 31,
    ));
    
    // Facebook
    $wp_customize->add_setting('facebook_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('facebook_url', array(
        'label'   => __('Facebook URL', 'yuth-logistics'),
        'section' => 'social_media',
        'type'    => 'url',
    ));
    
    // Instagram
    $wp_customize->add_setting('instagram_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('instagram_url', array(
        'label'   => __('Instagram URL', 'yuth-logistics'),
        'section' => 'social_media',
        'type'    => 'url',
    ));
    
    // TikTok
    $wp_customize->add_setting('tiktok_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('tiktok_url', array(
        'label'   => __('TikTok URL', 'yuth-logistics'),
        'section' => 'social_media', 
        'type'    => 'url',
    ));
}
add_action('customize_register', 'yuth_logistics_customize_register');

function get_footer_settings_page_id() {
    // Try to get the page by slug first
    $page = get_page_by_path('footer-settings');
    
    // If not found by slug, try by title
    if (!$page) {
        $page = get_page_by_title('Footer Settings');
    }
    
    return $page ? $page->ID : false;
}

// Register Custom Post Type for Services
function yuth_logistics_register_services_cpt() {
    $labels = array(
        'name'                  => 'Services',
        'singular_name'         => 'Service',
        'menu_name'             => 'Services',
        'add_new'               => 'Add New Service',
        'add_new_item'          => 'Add New Service',
        'edit_item'             => 'Edit Service',
        'new_item'              => 'New Service',
        'view_item'             => 'View Service',
        'search_items'          => 'Search Services',
        'not_found'             => 'No services found',
        'not_found_in_trash'    => 'No services found in trash',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'menu_icon'             => 'dashicons-portfolio',
        'menu_position'         => 5,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'               => array('slug' => 'services'),
        'capability_type'       => 'post',
    );
    
    register_post_type('service', $args);
}
add_action('init', 'yuth_logistics_register_services_cpt');

// Custom Walker Class for Navigation Menu
class Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        
        if ($args->walker->has_children && $depth === 0) {
            $item_output .= ' <i class="fa fa-caret-down"></i>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Fallback for primary menu if no menu is set
function default_primary_menu() {
    echo '<ul class="nav-links">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    
    // Services dropdown
    $services_query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    ));
    
    if ($services_query->have_posts()) {
        echo '<li class="dropdown">';
        echo '<a href="#">Services <i class="fa fa-caret-down"></i></a>';
        echo '<ul class="dropdown-menu">';
        while ($services_query->have_posts()) {
            $services_query->the_post();
            echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
        }
        wp_reset_postdata();
        echo '</ul>';
        echo '</li>';
    }
    
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('About'))) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('Blog'))) . '">Blog</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('FAQs'))) . '">FAQs</a></li>';
    echo '</ul>';
}

// Fallback for mobile menu
function default_mobile_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    
    // Services
    $services_query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    ));
    
    if ($services_query->have_posts()) {
        echo '<li><a href="#">Services</a></li>';
        while ($services_query->have_posts()) {
            $services_query->the_post();
            echo '<li style="padding-left: 20px;"><a href="' . esc_url(get_permalink()) . '">→ ' . esc_html(get_the_title()) . '</a></li>';
        }
        wp_reset_postdata();
    }
    
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('About'))) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('Blog'))) . '">Blog</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('Contact'))) . '">Contact Us</a></li>';
    echo '<li><a href="' . esc_url(get_permalink(get_page_by_title('FAQs'))) . '">FAQs</a></li>';
    echo '</ul>';
}

function add_services_to_nav_menu($items, $args) {
    // Only apply to primary menu
    if ($args->theme_location != 'primary') {
        return $items;
    }
    
    // Query all services
    $services_query = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    ));
    
    // Collect services
    $all_services = array();
    
    // Add dynamic services from CPT
    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            $all_services[] = array(
                'title' => get_the_title(),
                'url' => get_permalink()
            );
        }
        wp_reset_postdata();
    }
    
    // Service submenu creation
    if (!empty($all_services)) {
        $submenu_html = '<ul class="dropdown-menu">';
        foreach ($all_services as $service) {
            $submenu_html .= '<li><a href="' . esc_url($service['url']) . '">' . esc_html($service['title']) . '</a></li>';
        }
        $submenu_html .= '</ul>';
        
        // Try to find Services link with multiple patterns
        $found = false;
        
        // Pattern 1: Simple Services link
        if (preg_match('/<li[^>]*class="[^"]*menu-item[^"]*"[^>]*>.*?<a[^>]*>Services<\/a>.*?<\/li>/is', $items)) {
            $items = preg_replace_callback(
                '/(<li[^>]*class="[^"]*)(menu-item)([^"]*"[^>]*>)(.*?)(<a[^>]*>)(Services)(<\/a>)(.*?)(<\/li>)/is',
                function($m) use ($submenu_html) {
                    $li_class = $m[1] . $m[2] . ' dropdown' . $m[3];
                    return $li_class . $m[4] . $m[5] . $m[6] . ' <i class="fa fa-caret-down"></i>' . $m[7] . $submenu_html . $m[8] . $m[9];
                },
                $items,
                1
            );
            $found = true;
        }
        
        // If not found, try to add it after Home (if exists)
        if (!$found && strpos($items, 'Home') !== false) {
            $services_li = '<li class="dropdown menu-item"><a href="#">Services <i class="fa fa-caret-down"></i></a>' . $submenu_html . '</li>';
            $items = preg_replace(
                '/(<li[^>]*>.*?Home.*?<\/li>)/is',
                '$1' . $services_li,
                $items,
                1
            );
        }
    }
    
    return $items;
}
add_filter('wp_nav_menu_items', 'add_services_to_nav_menu', 10, 2);

//  Why Choose Us Cards
function yuth_logistics_register_why_choose_us_cpt() {
    $labels = array(
        'name'                  => 'Why Choose Us',
        'singular_name'         => 'Why Choose Us Card',
        'menu_name'             => 'Why Choose Us',
        'add_new'               => 'Add New Card',
        'add_new_item'          => 'Add New Card',
        'edit_item'             => 'Edit Card',
        'new_item'              => 'New Card',
        'view_item'             => 'View Card',
        'search_items'          => 'Search Cards',
        'not_found'             => 'No cards found',
        'not_found_in_trash'    => 'No cards found in trash',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => false,
        'menu_icon'             => 'dashicons-star-filled',
        'menu_position'         => 6,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => false,
        'capability_type'       => 'post',
    );
    
    register_post_type('why_choose_us', $args);
}
add_action('init', 'yuth_logistics_register_why_choose_us_cpt');


//DoContact plugin services

function yuth_logistics_docontact_services( $default_services ) {
    // Query all services from custom post type
    $services_args = array(
        'post_type'      => 'service',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
        'post_status'    => 'publish'
    );
    
    $services_query = new WP_Query( $services_args );
    
    $services = array();
    
    if ( $services_query->have_posts() ) {
        while ( $services_query->have_posts() ) {
            $services_query->the_post();
            $services[] = get_the_title();
        }
        wp_reset_postdata();
    }
    
    // If no services found in CPT, return default services
    if ( empty( $services ) ) {
        return $default_services;
    }
    
    return $services;
}
add_filter( 'docontact_services_list', 'yuth_logistics_docontact_services' );




// Dynamic services list for Contact Form 7
function yuth_logistics_cf7_dynamic_services($tag) {
    if (!is_a($tag, 'WPCF7_FormTag')) {
        return $tag;
    }

    // Only apply to the 'service' field
    if ($tag->name !== 'service') {
        return $tag;
    }

    // Query all services from custom post type
    $services_args = array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
        'post_status' => 'publish'
    );
    $services_query = new WP_Query($services_args);

    $services = array();
    
    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            $services[] = get_the_title();
        }
        wp_reset_postdata();
    }

    // If no services found, return default options
    if (empty($services)) {
        $services = array(
            'Tailgate Haul and Truck with Forklift Service',
            'Pallet Transport',
            'Same Day Delivery',
            'Interstate Freight',
            'Warehouse Services',
            'Other'
        );
    }

    // Set the values property correctly
    $tag->values = $services;
    $tag->labels = $services;
    $tag->pipes = new WPCF7_Pipes($services);
    
    return $tag;
}
add_filter('wpcf7_form_tag', 'yuth_logistics_cf7_dynamic_services', 10, 1);

add_action('init', function() {
    update_option('doregister_profile_page_id', 30); // Your actual profile page ID
}, 1);

add_action('init', function() {
    update_option('doregister_login_page_id', 25); // Your actual login page ID
}, 1);


add_action('init', function() {
    update_option('doregister_login_page_id', 25); // Replace with actual Login page ID
    update_option('doregister_register_page_id', 23); // Replace with actual Register page ID  
    update_option('doregister_profile_page_id', 30); // Replace with actual Profile page ID
}, 1);

?>