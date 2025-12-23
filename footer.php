<?php

// Get Footer Settings page ID
$footer_page_id = get_footer_settings_page_id();

// Get ACF fields from Footer Settings page
$footer_contact_title = $footer_page_id ? get_field('footer_contact_title', $footer_page_id) : '';
$footer_phone = $footer_page_id ? get_field('footer_phone', $footer_page_id) : '';
$footer_email = $footer_page_id ? get_field('footer_email', $footer_page_id) : '';
$footer_address = $footer_page_id ? get_field('footer_address', $footer_page_id) : '';
$footer_copyright_text = $footer_page_id ? get_field('footer_copyright_text', $footer_page_id) : '';
$footer_solution_text = $footer_page_id ? get_field('footer_solution_text', $footer_page_id) : '';
$footer_logo = $footer_page_id ? get_field('footer_logo', $footer_page_id) : '';

$footer_contact_title = $footer_contact_title ?: 'Contact Us';
$footer_phone = $footer_phone ?: get_theme_mod('phone_number', '+042 30 30 433');
$footer_email = $footer_email ?: get_theme_mod('email', 'admin@yuthlogistics.com.au');
$footer_address = $footer_address ?: get_theme_mod('address', 'Beaconsfield, Victoria 3807');
$footer_copyright_text = $footer_copyright_text ?: 'Yuthlogistics (Pvt) Ltd';
$footer_solution_text = $footer_solution_text ?: 'Solution by';


//  footer logo
$footer_logo_url = get_template_directory_uri() . '/assets/domedia.jpg';
if (is_array($footer_logo) && !empty($footer_logo['url'])) {
    $footer_logo_url = $footer_logo['url'];
} elseif (is_string($footer_logo) && !empty($footer_logo)) {
    $footer_logo_url = $footer_logo;
}
?>

<!-- Footer Section -->
<footer class="footer">
    <div class="footer-header">
        <div class="footer-contact">
            <h1><?php echo esc_html($footer_contact_title); ?></h1>
            <div>
                <p>
                    <i class="fa-solid fa-phone"></i> 
                    <?php echo esc_html($footer_phone); ?>
                </p>
                <p>
                    <i class="fa-solid fa-envelope"></i>
                    <?php echo esc_html($footer_email); ?>
                </p>
                <p>
                    <i class="fa-solid fa-map-marker"></i> 
                    <?php echo esc_html($footer_address); ?>
                </p>
            </div>
        </div>
        <div class="footer-links">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => 'wp_page_menu',
            ));
            ?>
        </div>
    </div>
    <div class="footer-bottom">
        <p>
            &copy; Copyright © <?php echo date('Y'); ?> <?php echo esc_html($footer_copyright_text); ?> | <?php echo esc_html($footer_solution_text); ?>
            <img src="<?php echo esc_url($footer_logo_url); ?>" 
                 alt="Footer Logo" 
                 style="height: 20px; vertical-align: middle;"> DoMedia
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>