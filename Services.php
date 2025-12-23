<?php
/*
Template Name: Services Page
*/
get_header();

// Get current page ID
$page_id = get_the_ID();

// Get ACF fields for Services Page
$banner_title = get_field('services_page_banner_title', $page_id) ?: 'Services';
$services_intro = get_field('services_intro_text', $page_id);

// Query Services from CPT
$services_args = array(
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'post_status'    => 'publish',
);
$services_query = new WP_Query($services_args);

// Build array of services (dynamic from CPT)
$service_items = array();
if ($services_query->have_posts()) {
    while ($services_query->have_posts()) {
        $services_query->the_post();
        $svc_id = get_the_ID();
        
        // Get service icon
        $icon_field = get_field('service_icon', $svc_id);
        $icon_url = '';
        if (is_array($icon_field) && !empty($icon_field['url'])) {
            $icon_url = $icon_field['url'];
        } elseif (is_string($icon_field) && !empty($icon_field)) {
            $icon_url = $icon_field;
        } else {
            $icon_url = get_template_directory_uri() . '/assets/service1.png';
        }
        
        // Get service background image
        $bg_field = get_field('service_background_image', $svc_id);
        $bg_url = '';
        if (is_array($bg_field) && !empty($bg_field['url'])) {
            $bg_url = $bg_field['url'];
        } elseif (is_string($bg_field) && !empty($bg_field)) {
            $bg_url = $bg_field;
        } else {
            $bg_url = get_template_directory_uri() . '/assets/service_p1.jpg';
        }
        
        // Get short description
        $short_desc = get_field('service_short_description', $svc_id);
        if (empty($short_desc)) {
            $short_desc = get_the_excerpt();
        }
        if (empty($short_desc)) {
            $short_desc = wp_trim_words(get_the_content(), 25, '...');
        }
        
        // Get service link
        $svc_link = get_field('service_link', $svc_id);
        if (empty($svc_link)) {
            $svc_link = get_permalink();
        }

        $service_items[] = array(
            'title'       => get_the_title(),
            'icon'        => $icon_url,
            'bg'          => $bg_url,
            'description' => $short_desc,
            'link'        => $svc_link,
        );
    }
    wp_reset_postdata();
}

// Fallback default services (if none created in CPT)
if (empty($service_items)) {
    $service_items = array(
        array(
            'title' => 'Tailgate Haul and Truck with Forklift Service',
            'icon'  => get_template_directory_uri() . '/assets/service1.png',
            'bg'    => get_template_directory_uri() . '/assets/service_p1.jpg',
            'description' => 'Seamless goods transportation across Victoria, ensuring timely, secure, and insured deliveries.',
            'link' => '#'
        ),
        array(
            'title' => 'Onsite Forklift Hire',
            'icon'  => get_template_directory_uri() . '/assets/service2.png',
            'bg'    => get_template_directory_uri() . '/assets/service_p2.jpg',
            'description' => 'Specialize in solutions for securely moving heavy-duty equipment safely and efficiently.',
            'link' => '#'
        ),
        array(
            'title' => 'Metro & Regional Same-Day Delivery',
            'icon'  => get_template_directory_uri() . '/assets/service3.png',
            'bg'    => get_template_directory_uri() . '/assets/service_p3.jpg',
            'description' => 'Reliable same-day delivery for urgent shipments across metro and regional areas with efficiency.',
            'link' => '#'
        ),
        array(
            'title' => 'Pallet Transport',
            'icon'  => get_template_directory_uri() . '/assets/service4.png',
            'bg'    => get_template_directory_uri() . '/assets/service_p4.jpg',
            'description' => 'Secure palletized freight transport with flexible options and timely delivery.',
            'link' => '#'
        ),
        array(
            'title' => 'Point A to B Transport',
            'icon'  => get_template_directory_uri() . '/assets/service5.png',
            'bg'    => get_template_directory_uri() . '/assets/service_p5.jpg',
            'description' => 'All terrain forklifts with skilled operators for precise material handling at job sites, homes or yards.',
            'link' => '#'
        ),
    );
}
?>

<!-- Services -->
<section class="services-section">
    <div class="banner">
        <div class="banner-content">
            <h1><?php echo esc_html($banner_title); ?></h1>
        </div>
    </div>

    <div class="services-container">
        <div class="services-content">
            <?php if (!empty($services_intro)): ?>
                <div class="services-intro" style="max-width:1200px;margin:0 auto 40px;text-align:center;">
                    <p style="font-size:18px;color:#666;line-height:1.6;"><?php echo nl2br(esc_html($services_intro)); ?></p>
                </div>
            <?php endif; ?>

            <div class="service-boxes">
                <?php foreach ($service_items as $item): ?>
                    <div class="service-box">
                        <div class="service-box-bg">
                            <img src="<?php echo esc_url($item['bg']); ?>" alt="<?php echo esc_attr($item['title']); ?> Background">
                        </div>

                        <div class="service-box-icon">
                            <img src="<?php echo esc_url($item['icon']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                        </div>

                        <div class="service-box-content">
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo nl2br(esc_html($item['description'])); ?></p>
                            <a href="<?php echo esc_url($item['link']); ?>" class="service-btn">View more &raquo;</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>

<!-- Transport section -->
<section class="transport" <?php 
    $home_page_id = get_option('page_on_front');
    $transport_bg = get_field('transport_background_image', $home_page_id);
    $transport_bg_url = '';
    if (is_array($transport_bg)) {
        $transport_bg_url = $transport_bg['url'];
    } elseif (is_string($transport_bg) && !empty($transport_bg)) {
        $transport_bg_url = $transport_bg;
    }
    if ($transport_bg_url): 
        echo 'style="background-image: url(\'' . esc_url($transport_bg_url) . '\');"';
    endif; 
?>>
    <?php
    $transport_title = get_field('transport_title', $home_page_id);
    $transport_description = get_field('transport_description', $home_page_id);
    $transport_button_text_ = get_field('transport_button_text_', $home_page_id) ?: 'Contact Us';
    $transport_button_url = get_field('transport_button_url', $home_page_id) ?: '#';
    
    if (empty($transport_title)) {
        $transport_title = "Looking for<br>Reliable Transport?";
    }
    if (empty($transport_description)) {
        $transport_description = "Save Time. Save Money.<br>Choose Yuth Logistics Today.";
    }
    ?>
    
    <div class="transport-parent">
        <h2><?php echo wp_kses_post($transport_title); ?></h2>
        <p><?php echo wp_kses_post($transport_description); ?></p>
        <a href="<?php echo esc_url($transport_button_url); ?>" class="transport-button">
            <?php echo esc_html($transport_button_text_); ?>
        </a>
    </div>
</section>

<?php get_footer(); ?>