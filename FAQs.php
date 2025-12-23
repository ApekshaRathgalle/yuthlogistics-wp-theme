<?php
/*
Template Name: FAQs Page
*/
get_header();

// Get current page ID
$page_id = get_the_ID();

// Get ACF fields for FAQs Page
$banner_title = get_field('faqs_banner_title', $page_id) ?: 'FAQs';

// Build FAQs array from individual ACF fields
$faqs = array();

// Loop through up to 20 FAQ items
for ($i = 1; $i <= 20; $i++) {
    $question = get_field("faq_{$i}_question", $page_id);
    $answer = get_field("faq_{$i}_answer", $page_id);
    
    if (!empty($question) || !empty($answer)) {
        $faqs[] = array(
            'question' => $question,
            'answer' => $answer
        );
    }
}

// Default FAQs if no ACF data exists
if (empty($faqs)) {
    $faqs = array(
        array(
            'question' => 'Is your company family-owned?',
            'answer' => 'Yes, we are an Australian family-owned business, committed to reliable and professional logistics solutions.'
        ),
        array(
            'question' => 'Do you provide lifting assistance at delivery sites?',
            'answer' => 'Yes, our forklift operators can assist with unloading and positioning goods at the delivery site.'
        ),
        array(
            'question' => 'Are your services insured?',
            'answer' => 'Yes, all our services are fully insured to provide peace of mind and protection for your goods during transit.'
        ),
        array(
            'question' => 'How quickly can you arrange a delivery?',
            'answer' => 'For same-day services, we recommend booking as early as possible. For urgent requests, contact us directly to check availability.'
        ),
        array(
            'question' => 'What areas do you cover?',
            'answer' => 'We service metro and regional areas across Australia, ensuring efficient and timely transport solutions.'
        ),
        array(
            'question' => 'How long have you been in business?',
            'answer' => 'We have 15 years of experience in the industry and were established in 2016.'
        ),
        array(
            'question' => 'What are your operating hours?',
            'answer' => 'We operate 24/7, ensuring flexible and dependable transport services.'
        ),
        array(
            'question' => 'What type of forklifts do you use?',
            'answer' => 'We use the best all-terrain forklifts, which can unload from one side for sites with limited space. Our forklifts have a lifting capacity of up to 2.5 tonnes.'
        )
    );
}
?>

<!-- FAQs -->
<section class="faqs-section">
    <div class="banner">
        <div class="banner-content">
            <h1><?php echo esc_html($banner_title); ?></h1>
        </div>
    </div>
    
    <div class="faqs-container">
        <div class="faqs-content">
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <?php if (!empty($faq['question'])): ?>
                        <div class="faq-item">
                            <h3>
                                <span class="faq-icon">?</span>
                                <?php echo esc_html($faq['question']); ?>
                            </h3>
                            <?php if (!empty($faq['answer'])): ?>
                                <p><?php echo nl2br(esc_html($faq['answer'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
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