<?php

get_header();

// Get the Home Page ID
$home_page_id = get_option('page_on_front');

// Hero section ACF field groups 
$hero_title = get_field('hero_title', $home_page_id) ?: 'Seamless Logistics,';
$hero_title2 = get_field('hero_title2', $home_page_id) ?: 'Simplified for You.';
$hero_description = get_field('hero_description', $home_page_id) ?: 'Fast, safe, and seamless deliveries — logistics experts in Melbourne\'s South East.';
$hero_subtitle = get_field('hero_subtitle', $home_page_id) ?: 'Family Owned and Operated';
$hero_button_text = get_field('hero_button_text', $home_page_id) ?: 'Explore Services';
$hero_button_url = get_field('hero_button_url', $home_page_id) ?: '#';
// Get background image - check if it's an array and extract URL
$hero_bg_image_data = get_field('hero_background_image', $home_page_id);
$hero_bg_image = '';
if (is_array($hero_bg_image_data)) {
    $hero_bg_image = $hero_bg_image_data['url'];
} elseif (is_string($hero_bg_image_data)) {
    $hero_bg_image = $hero_bg_image_data;
}

?>

<!-- Hero Section -->
<section class="hero" <?php if($hero_bg_image): ?>style="--hero-bg: url('<?php echo esc_url($hero_bg_image); ?>');"<?php endif; ?>>
    <h1><?php echo wp_kses_post($hero_title); ?></h1>
    <h1><?php echo wp_kses_post($hero_title2); ?></h1>
    <p><?php echo nl2br(esc_html($hero_description)); ?></p>
    <h2><?php echo esc_html($hero_subtitle); ?></h2>
    <a href="<?php echo esc_url($hero_button_url); ?>" class="explore-button">
        <?php echo esc_html($hero_button_text); ?>
    </a>
</section>


<!-- Services Section -->
<section class="services" <?php 
    // Get services background image
    $services_bg = get_field('services_background_image', $home_page_id);
    $services_bg_url = '';
    if (is_array($services_bg)) {
        $services_bg_url = $services_bg['url'];
    } elseif (is_string($services_bg) && !empty($services_bg)) {
        $services_bg_url = $services_bg;
    }
    if ($services_bg_url): 
        echo 'style="background-image: url(\'' . esc_url($services_bg_url) . '\'); background-size: cover; background-position: center;"';
    endif; 
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

<!-- About us Section -->
<section class="about-us">
    <div class="about-container">
      <?php
       $about_image = get_field('about_image', $home_page_id);
       $founded_year = get_field('founded_year', $home_page_id) ?: '2022';
       $overlay_title_line_1 = get_field('overlay_title_line_1', $home_page_id) ?: 'Experts in';
       $overlay_title_line_2 = get_field('overlay_title_line_2', $home_page_id) ?: ' Moving and Delivering';
       $about_subtitle = get_field('about_subtitle', $home_page_id) ?: 'About Us';
       $about_title = get_field('about_title', $home_page_id) ?: 'Expert Logistics Services';
       $about_description_ = get_field('about_description_', $home_page_id);
       $about_button_text = get_field('about_button_text', $home_page_id) ?: 'Read more';
       $about_button_url_ = get_field('about_button_url_', $home_page_id) ?: '#';
       
       $about_image_url = get_template_directory_uri() . '/assets/image.png';
        if (is_array($about_image)) {
            $about_image_url = $about_image['url'];
        } elseif (is_string($about_image) && !empty($about_image)) {
            $about_image_url = $about_image;
        }

        if (empty($about_description_)) {
            $about_description_ = "Since 2016, Youth Logistics has provided fast, secure, and professional solutions across Melbourne's Southeast. With 9 years of experience, our family-owned business specializes in pallet transport, deliveries, tail lift services, and commercial freight, ensuring on-time, cost-effective deliveries of building supplies, machinery, and bulk goods to businesses, warehouses, and job sites.";
        }
        ?>

       


        <figure class="about-image about-image-card">
            <img src="<?php echo esc_url($about_image_url); ?>" 
             alt="<?php echo esc_attr($about_title); ?>">

            <div class="about-badge">
                Founded in <?php echo esc_html($founded_year); ?>
            </div>

            <div class="about-overlay">
                <h3><?php echo esc_html($overlay_title_line_1); ?></h3>
                <h3><?php echo esc_html($overlay_title_line_2); ?></h3>
            </div>
        </figure>

        <div class="about-content">
            <h2><?php echo esc_html($about_subtitle); ?></h2>
            <h1><?php echo esc_html($about_title); ?></h1>
            <div class="about-description_">
                <?php echo nl2br(esc_html($about_description_)); ?>
            </div>
            <a href="<?php echo esc_url($about_button_url_); ?>" class="readmore-button">
                <?php echo esc_html($about_button_text); ?>
            </a>
        </div>
    </div>
</section>

<!-- why choose us section-->
<section class="why-choose-us">
    <?php
    // Get Why Choose Us section ACF fields
    $why_subtitle = get_field('why_subtitle', $home_page_id) ?: 'Why Choose Us?';
    $why_title = get_field('why_title', $home_page_id) ?: "What makes us\nDifferent?";
    
    // Query all "Why Choose Us" cards from custom post type
    $why_args = array(
        'post_type' => 'why_choose_us',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
        'post_status' => 'publish'
    );
    $why_query = new WP_Query($why_args);
    
   
    $all_why_cards = array();
    
    // Add dynamic cards from custom post type
    if ($why_query->have_posts()) {
        while ($why_query->have_posts()) {
            $why_query->the_post();
            
            $card_icon = get_field('why_card_icon');
            $icon_url = '';
            if (is_array($card_icon) && !empty($card_icon['url'])) {
                $icon_url = $card_icon['url'];
            } elseif (is_string($card_icon) && !empty($card_icon)) {
                $icon_url = $card_icon;
            } else {
                // Use featured image if icon not set
                if (has_post_thumbnail()) {
                    $icon_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                } else {
                    $icon_url = get_template_directory_uri() . '/assets/why1.png';
                }
            }
            
            $card_desc = get_field('why_card_description');
            if (empty($card_desc)) {
                $card_desc = get_the_content();
            }
            if (empty($card_desc)) {
                $card_desc = get_the_excerpt();
            }
            
            $all_why_cards[] = array(
                'icon' => $icon_url,
                'title' => get_the_title(),
                'description' => $card_desc,
                'is_dynamic' => true
            );
        }
        wp_reset_postdata();
    }
    
    // Add default/fallback cards if no dynamic cards exist
    if (empty($all_why_cards)) {
        $all_why_cards = array(
            array(
                'icon' => get_template_directory_uri() . '/assets/why1.png',
                'title' => 'Reliable Deliveries',
                'description' => "Ensuring on-time and\ntransport.",
                'is_dynamic' => false
            ),
            array(
                'icon' => get_template_directory_uri() . '/assets/why2.png',
                'title' => "Skilled\nProfessionals",
                'description' => "Trained drivers and\nforklift operators for safe",
                'is_dynamic' => false
            ),
            array(
                'icon' => get_template_directory_uri() . '/assets/why3.png',
                'title' => 'Safe Handling',
                'description' => "Secure loading, transport,\n& unloading to prevent\ndamage.",
                'is_dynamic' => false
            ),
            array(
                'icon' => get_template_directory_uri() . '/assets/why4.png',
                'title' => "Advanced\nEquipment",
                'description' => "Modern trucks, forklifts,\nand tailgate lifts for\nefficiency.",
                'is_dynamic' => false
            )
        );
    }
    ?>
    
    <h3 class="subtitle"><?php echo esc_html($why_subtitle); ?></h3>
    <h2><?php echo nl2br(esc_html($why_title)); ?></h2>
    
    <div class="why-blog-cards">
        <?php foreach ($all_why_cards as $card): ?>
            <div class="why-blog-card">
                <img src="<?php echo esc_url($card['icon']); ?>" 
                     alt="<?php echo esc_attr($card['title']); ?>" 
                     class="why-blog-img">
                <h3><?php echo nl2br(esc_html($card['title'])); ?></h3>
                <p><?php echo nl2br(esc_html($card['description'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- blog section-->
<section class="blog-section">
    <?php
    // Get Blog section ACF fields
    $blog_subtitle = get_field('blog_subtitle', $home_page_id) ?: 'Our Blog';
    $blog_title = get_field('blog_title', $home_page_id) ?: 'Insights from the Logistics World';
    $blog_posts_count = get_field('blog_posts_count', $home_page_id) ?: 6;
    
    // Query latest blog posts from WordPress (same as archio.php)
    $blog_args = array(
        'post_type' => 'post',
        'posts_per_page' => $blog_posts_count,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );
    $blog_query = new WP_Query($blog_args);
    ?>
    
    <div>
        <h3 class="title"><?php echo esc_html($blog_subtitle); ?></h3>
        <h2><?php echo nl2br(esc_html($blog_title)); ?></h2>
        
        <div class="blog-cards">
            <?php if ($blog_query->have_posts()): ?>
                <div class="ph-bl-bb-1 owl-carousel dark-owl-dots">
                    <?php 
                    while ($blog_query->have_posts()): 
                        $blog_query->the_post();
                        
                        // Get featured image 
                        $thumbnail_url = get_template_directory_uri() . '/assets/blog-default.jpg';
                        if (has_post_thumbnail()) {
                            $thumbnail_id = get_post_thumbnail_id();
                            $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'blog-card-image');
                            if ($thumbnail) {
                                $thumbnail_url = $thumbnail[0];
                            }
                        }
                    ?>
                        <div class="blog-card">
                            <div class="blog-image">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" 
                                     alt="<?php echo esc_attr(get_the_title()); ?>">
                            </div>
                            <div class="blog-content">
                                <h3><?php echo esc_html(wp_trim_words(get_the_title(), 10, '...')); ?></h3>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-readmore">
                                    Read more &raquo;
                                </a>
                            </div>
                        </div>
                    <?php 
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else: ?>
                <!-- Fallback: Show default cards if no posts exist -->
                <div class="ph-bl-bb-1 owl-carousel dark-owl-dots">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/blog1.jpg'); ?>" alt="Local Partnerships">
                        </div>
                        <div class="blog-content">
                            <h3>How Local Partnerships <br> Logistics Efficiency significantly</h3>
                            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="blog-readmore">Read more &raquo;</a>
                        </div>
                    </div>
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/blog2.jpg'); ?>" alt="Peak Seasons">
                        </div>
                        <div class="blog-content">
                            <h3>Managing Logistics During <br> Peak Seasons</h3>
                            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="blog-readmore">Read more &raquo;</a>
                        </div>
                    </div>
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/blog3.jpg'); ?>" alt="Experience">
                        </div>
                        <div class="blog-content">
                            <h3>The Power of Experience <br> How Logistics Teams Grow through experience</h3>
                            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="blog-readmore">Read more &raquo;</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Transport section-->
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
    // Get Transport section ACF fields
    $transport_title = get_field('transport_title', $home_page_id);
    $transport_description = get_field('transport_description', $home_page_id);
    $transport_button_text_ = get_field('transport_button_text_', $home_page_id) ?: 'Contact Us';
    $transport_button_url = get_field('transport_button_url', $home_page_id) ?: '#';
    
    // Default values
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


<?php
get_footer();
?>