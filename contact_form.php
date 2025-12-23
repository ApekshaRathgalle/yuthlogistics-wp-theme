<?php

/*Template Name: Contact Form Page*/

get_header(); 
?>

<!-- Contact Form Modal/Popup -->
<div class="contact-form-overlay" id="contactFormOverlay" data-home-url="<?php echo esc_url(home_url('/')); ?>">
    <div class="contact-form-container">
        <!-- Close Button -->
        <button class="contact-form-close" id="closeContactForm" aria-label="Close form">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Form Header -->
        <div class="contact-form-header">
            <h3>Get In Touch</h3>
            <h1>Book Your Logistics</h1>
        </div>

        <!-- Contact Form 7 Integration -->
        <div class="contact-form">
            <?php 
            // This will use the dynamic services from the filter
            echo do_shortcode('[contact-form-7 id="4f00a74" title="Untitled"]'); 
            ?>
        </div>
    </div>
</div>

<?php 

get_footer(); 
?>