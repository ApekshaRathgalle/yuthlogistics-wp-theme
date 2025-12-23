<?php
/**
 * Template for Single Service
 */
get_header();

// Get current service ID
$service_id = get_the_ID();

// Get ACF fields for Service
$banner_title = get_the_title();
$service_overview = get_field('service_overview', $service_id);
$service_details_title = get_field('service_details_title', $service_id) ?: 'Our ' . get_the_title() . ' Services';
$service_details_image = get_field('service_details_image', $service_id);

$why_work_title = get_field('why_work_title', $service_id) ?: 'Why Work With Us?';
$why_work_image = get_field('why_work_image', $service_id);

$who_benefits_title = get_field('who_benefits_title', $service_id) ?: 'Who Benefits?';
$who_benefits_image = get_field('who_benefits_image', $service_id);

// Default overview
if (empty($service_overview)) {
    $service_overview = get_the_content();
}

// Build gallery images array from individual fields
$gallery_images = array();
for ($i = 1; $i <= 4; $i++) {
    $image = get_field("service_gallery_image_{$i}", $service_id);
    if (is_array($image) && !empty($image['url'])) {
        $gallery_images[] = $image['url'];
    } elseif (is_string($image) && !empty($image)) {
        $gallery_images[] = $image;
    }
}

// Default gallery images if none uploaded
if (empty($gallery_images)) {
    $gallery_images = array(
        get_template_directory_uri() . '/assets/service1.png',
        get_template_directory_uri() . '/assets/service2.png',
        get_template_directory_uri() . '/assets/service3.png',
        get_template_directory_uri() . '/assets/service4.png',
    );
}

// Default service details image
$details_image_url = get_template_directory_uri() . '/assets/whychoose.jpg';
if (is_array($service_details_image) && !empty($service_details_image['url'])) {
    $details_image_url = $service_details_image['url'];
} elseif (is_string($service_details_image) && !empty($service_details_image)) {
    $details_image_url = $service_details_image;
}

// Build service details points array from individual fields
$service_details_points = array();
for ($i = 1; $i <= 6; $i++) {
    $point = get_field("service_detail_point_{$i}", $service_id);
    if (!empty($point)) {
        $service_details_points[] = array('point' => $point);
    }
}

// Default service details points
if (empty($service_details_points)) {
    $service_details_points = array(
        array('point' => 'Tailgate lift assistance for easy loading and unloading.'),
        array('point' => 'Forklift support for oversized and palletized deliveries.'),
        array('point' => 'Reliable truck transport ensures safe, damage-free deliveries.'),
        array('point' => 'Expert handling of fragile and high-value items.'),
    );
}

// Default why work image
$why_work_image_url = get_template_directory_uri() . '/assets/whychooseus.jpg';
if (is_array($why_work_image) && !empty($why_work_image['url'])) {
    $why_work_image_url = $why_work_image['url'];
} elseif (is_string($why_work_image) && !empty($why_work_image)) {
    $why_work_image_url = $why_work_image;
}

// Build why work points array from individual fields
$why_work_points = array();
for ($i = 1; $i <= 5; $i++) {
    $point = get_field("why_work_point_{$i}", $service_id);
    if (!empty($point)) {
        $why_work_points[] = array('point' => $point);
    }
}

// Default why work points
if (empty($why_work_points)) {
    $why_work_points = array(
        array('point' => 'Trained professionals ensuring safe and precise handling.'),
        array('point' => 'Reliable equipment for smooth lifting and transport.'),
        array('point' => 'Cost-effective solutions to minimize labor and delays.'),
        array('point' => 'Fast response times for urgent or scheduled deliveries.'),
        array('point' => 'Flexible scheduling to accommodate your business needs.'),
    );
}

// Default who benefits image
$who_benefits_image_url = get_template_directory_uri() . '/assets/who-benefits.jpg';
if (is_array($who_benefits_image) && !empty($who_benefits_image['url'])) {
    $who_benefits_image_url = $who_benefits_image['url'];
} elseif (is_string($who_benefits_image) && !empty($who_benefits_image)) {
    $who_benefits_image_url = $who_benefits_image;
}

// Build who benefits points array from individual fields
$who_benefits_points = array();
for ($i = 1; $i <= 5; $i++) {
    $point = get_field("who_benefits_point_{$i}", $service_id);
    if (!empty($point)) {
        $who_benefits_points[] = array('point' => $point);
    }
}

// Default who benefits points
if (empty($who_benefits_points)) {
    $who_benefits_points = array(
        array('point' => 'Construction Sites'),
        array('point' => 'Warehouses & Logistics'),
        array('point' => 'Retail & Commercial Businesses'),
        array('point' => 'Freight & Transport Companies'),
        array('point' => 'Manufacturers & Distributors'),
    );
}

// Query OTHER services (exclude current service)
$other_services_args = array(
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'post__not_in'   => array($service_id), // Exclude current service
);
$other_services_query = new WP_Query($other_services_args);

// Build array of other services
$other_service_cards = array();
if ($other_services_query->have_posts()) {
    while ($other_services_query->have_posts()) {
        $other_services_query->the_post();
        $other_svc_id = get_the_ID();
        
        // Get service icon
        $service_icon = get_field('service_icon', $other_svc_id);
        $icon_url = '';
        if (is_array($service_icon) && !empty($service_icon['url'])) {
            $icon_url = $service_icon['url'];
        } elseif (is_string($service_icon) && !empty($service_icon)) {
            $icon_url = $service_icon;
        } else {
            if (has_post_thumbnail($other_svc_id)) {
                $icon_url = get_the_post_thumbnail_url($other_svc_id, 'thumbnail');
            } else {
                $icon_url = get_template_directory_uri() . '/assets/service-default.png';
            }
        }
        
        // Get service background image (for Services.php style)
        $bg_field = get_field('service_background_image', $other_svc_id);
        $bg_url = '';
        if (is_array($bg_field) && !empty($bg_field['url'])) {
            $bg_url = $bg_field['url'];
        } elseif (is_string($bg_field) && !empty($bg_field)) {
            $bg_url = $bg_field;
        } else {
            $bg_url = get_template_directory_uri() . '/assets/service_p1.jpg';
        }
        
        // Get short description
        $short_desc = get_field('service_short_description', $other_svc_id);
        if (empty($short_desc)) {
            $short_desc = get_the_excerpt();
        }
        if (empty($short_desc)) {
            $short_desc = wp_trim_words(get_the_content(), 20, '...');
        }
        
        $other_service_cards[] = array(
            'icon' => $icon_url,
            'bg' => $bg_url,
            'title' => get_the_title(),
            'description' => $short_desc,
            'link' => get_permalink($other_svc_id),
        );
    }
    wp_reset_postdata();
}
?>

<!-- Banner Section -->
<section class="single-service-banner">
    <div class="banner">
        <div class="banner-content">
            <h1><?php echo esc_html($banner_title); ?></h1>
        </div>
    </div>
</section>

<!-- Service Overview Section -->
<section class="single-service-overview">
    <div class="service-overview-container">
        <div class="service-overview-content">
            <h2>Service Overview</h2>
            
            <!-- Custom Gallery Layout with Fancybox -->
            <?php if (count($gallery_images) >= 4): ?>
                <div class="service-overview-gallery">
                    <!-- First image - large, left side -->
                    <div class="gallery-item gallery-large">
                        <a href="<?php echo esc_url($gallery_images[0]); ?>" 
                           data-fancybox="service-gallery" 
                           data-caption="<?php echo esc_attr($banner_title); ?>">
                            <img src="<?php echo esc_url($gallery_images[0]); ?>" 
                                 alt="<?php echo esc_attr($banner_title); ?>">
                        </a>
                    </div>
                    
                    <!-- Right column with 3 images -->
                    <div class="gallery-right-column">
                        <!-- Second image - tall, top right -->
                        <div class="gallery-item gallery-tall">
                            <a href="<?php echo esc_url($gallery_images[1]); ?>" 
                               data-fancybox="service-gallery" 
                               data-caption="<?php echo esc_attr($banner_title); ?>">
                                <img src="<?php echo esc_url($gallery_images[1]); ?>" 
                                     alt="<?php echo esc_attr($banner_title); ?>">
                            </a>
                        </div>
                        
                        <!-- Third and fourth images stacked vertically on the far right -->
                        <div class="gallery-vertical-stack">
                            <div class="gallery-item gallery-small">
                                <a href="<?php echo esc_url($gallery_images[2]); ?>" 
                                   data-fancybox="service-gallery" 
                                   data-caption="<?php echo esc_attr($banner_title); ?>">
                                    <img src="<?php echo esc_url($gallery_images[2]); ?>" 
                                         alt="<?php echo esc_attr($banner_title); ?>">
                                </a>
                            </div>
                            <div class="gallery-item gallery-small">
                                <a href="<?php echo esc_url($gallery_images[3]); ?>" 
                                   data-fancybox="service-gallery" 
                                   data-caption="<?php echo esc_attr($banner_title); ?>">
                                    <img src="<?php echo esc_url($gallery_images[3]); ?>" 
                                         alt="<?php echo esc_attr($banner_title); ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Fallback for less than 4 images -->
                <div class="service-overview-gallery">
                    <?php foreach ($gallery_images as $image_url): ?>
                        <div class="gallery-item">
                            <a href="<?php echo esc_url($image_url); ?>" 
                               data-fancybox="service-gallery" 
                               data-caption="<?php echo esc_attr($banner_title); ?>">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($banner_title); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Text comes AFTER gallery -->
            <div class="service-overview-text">
                <?php echo wpautop(wp_kses_post($service_overview)); ?>
            </div>
        </div>
    </div>
</section>


<!-- Service Details Section -->
<section class="single-service-details">
    <div class="service-details-container">
        <div class="service-details-image">
            <img src="<?php echo esc_url($details_image_url); ?>" alt="<?php echo esc_attr($banner_title); ?>">
        </div>
        
        <div class="service-details-content">
            <h2><?php echo esc_html($service_details_title); ?></h2>
            <ul class="service-details-list">
                <?php foreach ($service_details_points as $point): ?>
                    <?php if (!empty($point['point'])): ?>
                        <li><?php echo esc_html($point['point']); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- Why Work With Us Section -->
<section class="single-service-why">
    <div class="service-why-container">
        <div class="service-why-content">
            <h2><?php echo esc_html($why_work_title); ?></h2>
            <ul class="service-why-list">
                <?php foreach ($why_work_points as $point): ?>
                    <?php if (!empty($point['point'])): ?>
                        <li><?php echo esc_html($point['point']); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="service-why-image">
            <img src="<?php echo esc_url($why_work_image_url); ?>" alt="Why Work With Us">
        </div>
    </div>
</section>

<!-- Who Benefits Section -->
<section class="single-service-benefits">
    <div class="service-benefits-container">
        <div class="service-benefits-image">
            <img src="<?php echo esc_url($who_benefits_image_url); ?>" alt="Who Benefits">
        </div>
        
        <div class="service-benefits-content">
            <h2><?php echo esc_html($who_benefits_title); ?></h2>
            <ul class="service-benefits-list">
                <?php foreach ($who_benefits_points as $point): ?>
                    <?php if (!empty($point['point'])): ?>
                        <li><?php echo esc_html($point['point']); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- Other Services Section -->
<?php if (!empty($other_service_cards)): ?>
<section class="services other-services-section">
    <h2>Our Services</h2>
    <h1>Other Expert Logistics Services</h1>
    
    <div class="service-cards">
        <div class="owl-carousel other-services-carousel">
            <?php foreach ($other_service_cards as $service): ?>
                <div class="service-box">
                    <div class="service-box-bg">
                        <img src="<?php echo esc_url($service['bg']); ?>" alt="<?php echo esc_attr($service['title']); ?> Background">
                    </div>

                    <div class="service-box-icon">
                        <img src="<?php echo esc_url($service['icon']); ?>" alt="<?php echo esc_attr($service['title']); ?>">
                    </div>

                    <div class="service-box-content">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo nl2br(esc_html($service['description'])); ?></p>
                        <a href="<?php echo esc_url($service['link']); ?>" class="service-btn">View more &raquo;</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Transport CTA Section -->
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