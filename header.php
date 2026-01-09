<?php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header Section -->
<header>
    <!-- Top Bar -->
    <div class="topbar">
        <div class="contact-info">
            <span>
                <i class="fa-solid fa-phone"></i> 
                <?php echo esc_html(get_theme_mod('phone_number', '+042 30 30 433')); ?>
            </span>
            <span>
                <i class="fa-solid fa-envelope"></i> 
                <?php echo esc_html(get_theme_mod('email', 'admin@youthlogistics.com.au')); ?>
            </span>
        </div>

        <div class="social-media">
            <?php if (get_theme_mod('facebook_url', '#') !== '#'): ?>
                <a href="<?php echo esc_url(get_theme_mod('facebook_url', '#')); ?>" target="_blank" rel="noopener">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            <?php else: ?>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('instagram_url', '#') !== '#'): ?>
                <a href="<?php echo esc_url(get_theme_mod('instagram_url', '#')); ?>" target="_blank" rel="noopener">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            <?php else: ?>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('tiktok_url', '#') !== '#'): ?>
                <a href="<?php echo esc_url(get_theme_mod('tiktok_url', '#')); ?>" target="_blank" rel="noopener">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            <?php else: ?>
                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
            <?php endif; ?>
           <!-- Profile Icon with Dropdown -->
            <div class="profile-dropdown-wrapper">
                <a href="#" class="profile-icon-link" id="profileToggle" aria-label="User Menu">
                    <i class="fa-solid fa-user"></i>
                </a>
                
                <div class="profile-dropdown-menu" id="profileDropdown">
                    <?php if (is_user_logged_in()): 
                        $current_user = wp_get_current_user();
                    ?>
                        <div class="profile-user-info">
                            <i class="fa-solid fa-user-circle"></i>
                            <span><?php echo esc_html($current_user->display_name); ?></span>
                        </div>
                        <a href="<?php echo esc_url(get_permalink(get_option('doregister_profile_page_id'))); ?>">
                            <i class="fa-solid fa-id-card"></i> My Profile
                        </a>
                        <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">
                            <i class="fa-solid fa-sign-out-alt"></i> Logout
                        </a>
                    <?php else: ?>
                        <a href="<?php echo esc_url(get_permalink(get_option('doregister_login_page_id'))); ?>">
                            <i class="fa-solid fa-sign-in-alt"></i> Login
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_option('doregister_register_page_id'))); ?>">
                            <i class="fa-solid fa-user-plus"></i> Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
    
    <nav class="navbar">
        <!-- Logo -->
        <div class="logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
                <?php
            }
            ?>
        </div>
        
        <!-- Hamburger Menu -->
        <button class="hamburger" aria-label="Open menu" aria-expanded="false">
            <i class="fa-solid fa-bars" aria-hidden="true"></i>
        </button>
        
        <!-- Desktop Navigation -->
        <?php
        // Check if Primary menu exists in WordPress
        $menu_exists = has_nav_menu('primary');
        
        if ($menu_exists) {
            // Use WordPress menu system
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-links',
                'walker'         => new Custom_Nav_Walker(),
            ));
        } else {
            // Fallback: Use your original service dropdown logic
            // Query services for dropdown menu
            $services_nav_query = new WP_Query(array(
                'post_type' => 'service',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish'
            ));
            
            // Prepare all services (dynamic + default)
            $nav_services = array();
            
            // Add dynamic services
            if ($services_nav_query->have_posts()) {
                while ($services_nav_query->have_posts()) {
                    $services_nav_query->the_post();
                    $nav_services[] = array(
                        'title' => get_the_title(),
                        'url' => get_permalink()
                    );
                }
                wp_reset_postdata();
            }
            
            // Add default services
            //$nav_services[] = array('title' => 'Tailgate Haul and Truck with Forklift Service', 'url' => '#');
            //$nav_services[] = array('title' => 'Onsite Forklift Hire', 'url' => '#');
            //$nav_services[] = array('title' => 'Metro & regional Same-Day Delivery', 'url' => '#');
            //$nav_services[] = array('title' => 'Pallet Transport', 'url' => '#');
            //$nav_services[] = array('title' => 'Point A to B Transport', 'url' => '#');
            ?>
            
            <ul class="nav-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" <?php if (is_front_page()) echo 'class="active"'; ?>>Home</a></li>
                
                <?php if (!empty($nav_services)): ?>
                    <li class="dropdown">
                        <a href="#">Services <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($nav_services as $service): ?>
                                <li><a href="<?php echo esc_url($service['url']); ?>"><?php echo esc_html($service['title']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                
                <li><a href="#">About Us</a></li>
                <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Blog'))); ?>">Blog</a></li>
                <li><a href="#">FAQs</a></li>
            </ul>
        <?php } ?>
        
        <a href="<?php echo esc_url(get_permalink(get_page_by_title('Contact'))); ?>" class="contact-button">Contact Us</a>
        <span class="navbar-mobile">
            <i class="fa-solid fa-phone"></i>
        </span>
    </nav>
    
    <!-- Hamburger Menu Overlay -->
    <div class="hamburger-menu" id="hamburgerMenu" aria-hidden="true">
        <button class="hamburger-close" aria-label="Close menu">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
        <?php
        if ($menu_exists) {
            // Use WordPress menu for mobile
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
            ));
        } else {
            // Fallback: Original mobile menu with services
            ?>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <?php if (!empty($nav_services)): ?>
                    <li><a href="#">Services</a></li>
                    <?php foreach ($nav_services as $service): ?>
                        <li style="padding-left: 20px;"><a href="<?php echo esc_url($service['url']); ?>">→ <?php echo esc_html($service['title']); ?></a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Services'))); ?>">Services</a></li>
                <?php endif; ?>
                <li><a href="#">About Us</a></li>
                <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Blog'))); ?>">Blog</a></li>
                <li><a href="<?php echo esc_url(get_permalink(get_page_by_title('Contact'))); ?>">Contact Us</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        <?php } ?>
    </div>
</header>