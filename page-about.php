<?php

/*
Template Name: About Us Page
*/
get_header();

// Get current page ID
$page_id = get_the_ID();

$home_page_id = get_option('page_on_front');


// Get ACF fields for About Page
$banner_title = get_field('about_banner_title', $page_id) ?: 'About Us';
$intro_image = get_field('about_intro_image', $page_id);
$intro_title = get_field('about_intro_title', $page_id) ?: 'Know Us Better';
$intro_text = get_field('about_intro_text', $page_id);
$description_text = get_field('about_description_text', $page_id);
$services_list_title = get_field('about_services_list_title', $page_id) ?: 'What We Offer';
$vision_title = get_field('about_vision_title', $page_id) ?: 'Our Vision';
$vision_text = get_field('about_vision_text', $page_id);
$mission_title = get_field('about_mission_title', $page_id) ?: 'Our Mission';
$mission_text = get_field('about_mission_text', $page_id);

// Default intro text
if (empty($intro_text)) {
    $intro_text = "At Yuth Logistics, we're a family-owned business proudly delivering fast, secure, and professional transport solutions across Melbourne's Southeast. Since starting out in 2016, we've built 9 years of experience helping businesses of all sizes keep their operations running smoothly. Whether you need pallet transport, forklift deliveries, tail lift services, or commercial freight, we've got the right team and equipment to get the job done safely and on time.";
}

// Default description
if (empty($description_text)) {
    $description_text = "From job sites and warehouses to small businesses and major corporations, we provide reliable services tailored to your needs. We specialize in moving building supplies, machinery, and bulk goods, always ensuring secure handling from pickup to delivery.\n\nAt Yuth Logistics, we genuinely care about delivering hassle-free, cost-effective solutions you can count on. Our goal is simple—help you move what matters most, without delays or stress. When you work with us, you're choosing a team committed to professionalism, safety, and exceptional service every step of the way.";
}

// Default vision
if (empty($vision_text)) {
    $vision_text = "To be the trusted transport provider, recognised for exceptional service, experienced operators, and dependable solutions that keep businesses moving.";
}

// Default mission
if (empty($mission_text)) {
    $mission_text = "To deliver fast, reliable, and efficient transport services, focusing on exceptional service, skilled operators, and dependable solutions. We ensure safe handling and on-time deliveries, helping businesses streamline operations and confidently move forward.";
}

// Get intro image URL
$intro_image_url = get_template_directory_uri() . '/assets/about_page.jpg';
if (is_array($intro_image) && !empty($intro_image['url'])) {
    $intro_image_url = $intro_image['url'];
} elseif (is_string($intro_image) && !empty($intro_image)) {
    $intro_image_url = $intro_image;
}

// Default "What We Offer" services (hardcoded, no repeater needed)
$service_items = array(
    array(
        'service_item_title' => 'Point A to B Transport',
        'service_item_description' => 'Our drivers efficiently load and transport goods, ensuring safe, on-time, and reliable deliveries from Point A to Point B.'
    ),
    array(
        'service_item_title' => 'Onsite Forklift Hire',
        'service_item_description' => 'We provide onsite forklift hire with skilled operators and high-performance equipment to handle heavy loads at job sites, warehouses, or business locations.'
    ),
    array(
        'service_item_title' => 'Metro & Regional SAME-DAY Deliveries',
        'service_item_description' => 'We offer same-day delivery services across metro and regional areas, ensuring your shipments arrive quickly and without delays.'
    ),
    array(
        'service_item_title' => 'Pallet Transport',
        'service_item_description' => 'From warehouses to job sites, our palletised freight transport ensures safe, efficient, and streamlined logistics to keep your supply chain moving.'
    ),
    array(
        'service_item_title' => 'Tailgate, Forklift & Truck Deliveries',
        'service_item_description' => 'Our tailgate, Truck and forklift delivery services are designed for oversized, fragile, or heavy shipments, ensuring secure and efficient handling.'
    )
);
?>

<!-- Banner Section -->
<section class="about-page-section">
    <div class="banner">
        <div class="banner-content">
            <h1><?php echo esc_html($banner_title); ?></h1>
        </div>
    </div>

    <!-- About Content -->
    <div class="about-page-content">
        <!-- Know Us Better Section with Image -->
        <div class="about-intro">
            <div class="about-intro-image">
                <img src="<?php echo esc_url($intro_image_url); ?>" alt="<?php echo esc_attr($intro_title); ?>">
            </div>
            <div class="about-intro-text">
                <h2><?php echo esc_html($intro_title); ?></h2>
                <p><?php echo nl2br(esc_html($intro_text)); ?></p>
            </div>
        </div>

        <div class="about-description">
            <?php 
            $description_paragraphs = explode("\n\n", $description_text);
            foreach ($description_paragraphs as $paragraph) {
                if (!empty(trim($paragraph))) {
                    echo '<p>' . nl2br(esc_html(trim($paragraph))) . '</p>';
                }
            }
            ?>
        </div>

        <!-- What We Offer Section -->
        <div class="about-services-list">
            <h2><?php echo esc_html($services_list_title); ?></h2>
            
            <?php foreach ($service_items as $item): ?>
                <div class="service-item">
                    <h3><?php echo esc_html($item['service_item_title']); ?></h3>
                    <p><?php echo esc_html($item['service_item_description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Vision and Mission -->
        <div class="about-vision-mission">
            <div class="vision-mission-item">
                <h2><?php echo esc_html($vision_title); ?></h2>
                <p><?php echo nl2br(esc_html($vision_text)); ?></p>
            </div>

            <div class="vision-mission-item">
                <h2><?php echo esc_html($mission_title); ?></h2>
                <p><?php echo nl2br(esc_html($mission_text)); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services about-page-services" <?php 
?>>
    <?php
    // Get Services section ACF fields
    $services_subtitle = get_field('services_subtitle', $home_page_id) ?: 'Our Services';
    $services_title = get_field('services_title', $home_page_id) ?: 'Expert Logistics Services';
    
    // Query all services from custom post type
    $services_args = array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );
    $services_query = new WP_Query($services_args);
    
    // Collect service cards from custom post type only
    $all_service_cards = array();
    
    // Add dynamic services from custom post type
    if ($services_query->have_posts()) {
        while ($services_query->have_posts()) {
            $services_query->the_post();
            
            $service_icon = get_field('service_icon');
            $icon_url = '';
            if (is_array($service_icon) && !empty($service_icon['url'])) {
                $icon_url = $service_icon['url'];
            } elseif (is_string($service_icon) && !empty($service_icon)) {
                $icon_url = $service_icon;
            } else {
                // Use the featured image if service icon is not set
                if (has_post_thumbnail()) {
                    $icon_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                } else {
                    $icon_url = get_template_directory_uri() . '/assets/service-default.png';
                }
            }
            
            $short_desc = get_field('service_short_description');
            if (empty($short_desc)) {
                $short_desc = get_the_excerpt();
            }
            if (empty($short_desc)) {
                $short_desc = wp_trim_words(get_the_content(), 20, '...');
            }
            
            $all_service_cards[] = array(
                'icon' => $icon_url,
                'title' => get_the_title(),
                'description' => $short_desc,
                'link' => get_permalink(),
                'is_dynamic' => true
            );
        }
        wp_reset_postdata();
    }
    ?>
    
    <h2><?php echo esc_html($services_subtitle); ?></h2>
    <h1><?php echo esc_html($services_title); ?></h1>
    
    <div class="service-cards">
        <?php if (!empty($all_service_cards)): ?>
            <div class="owl-carousel service-carousel">
                <?php 
                $card_index = 0;
                foreach ($all_service_cards as $service):
                    $card_class = ($card_index === 0) ? 'service-card first-card' : 'service-card';
                    $card_index++;
                ?>
                    <div class="<?php echo esc_attr($card_class); ?>">
                        <img src="<?php echo esc_url($service['icon']); ?>" 
                             alt="<?php echo esc_attr($service['title']); ?>" 
                             class="service-icon">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo nl2br(esc_html($service['description'])); ?></p>
                        <a href="<?php echo esc_url($service['link']); ?>" class="service-btn">Read more &raquo;</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #fff; text-align: center; padding: 40px;">
                No services available. Please add services in <strong>WordPress Admin → Services</strong>.
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- Transport section -->
<section class="transport" <?php 
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