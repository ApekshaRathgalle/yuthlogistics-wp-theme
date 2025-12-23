<?php
/*
Template Name: Blog Archive
*/
get_header(); ?>

<!-- Blog Section -->
<section class="blog-page-section">
    <div class="blog-page-content">
        <div class="banner">
            <div class="banner-content">
                <h1><?php echo get_the_title(); ?></h1>
            </div>
        </div>
        <div class="blog-page-card-container">
            <div class="card-center">
                <div class="blog-page-cards">
                    <?php

                    echo '<!-- Template: Blog Archive -->';
                    echo '<!-- Post Count: ' . wp_count_posts()->publish . ' -->';
                    
                    // Query blog posts
                    $blog_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish'
                    );
                    
                    $blog_query = new WP_Query($blog_args);

                    echo '<!-- Found Posts: ' . $blog_query->found_posts . ' -->';
                  
                    
                    if ($blog_query->have_posts()) :
                        while ($blog_query->have_posts()) : $blog_query->the_post();
                    ?>
                        <article class="blog-page-card" onclick="window.location.href='<?php the_permalink(); ?>'">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('blog-card-image', array('alt' => get_the_title())); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/blog-default.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            
                            <div class="blog-page-card-content"> 
                                <h5><?php the_title(); ?></h5>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
                                <a href="<?php the_permalink(); ?>" class="service-btn">Read more &raquo;</a>
                            </div>
                        </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <div style="text-align: center; padding: 40px; width: 100%;">
                            <p style="font-size: 18px; color: #666;">No blog posts found.</p>
                            <p style="font-size: 14px; color: #999;">
                                Please create some posts in WordPress Admin → Posts → Add New
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
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

<?php get_footer(); ?>