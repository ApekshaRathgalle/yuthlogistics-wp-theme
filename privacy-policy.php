<?php
/*
Template Name: Privacy Policy Page
*/
get_header();

// Get current page ID
$page_id = get_the_ID();

// Get ACF fields for Privacy Policy Page
$banner_title = get_field('privacy_banner_title', $page_id) ?: 'Privacy Policy';

// Build sections array from individual ACF fields
$privacy_sections = array();

// Loop through up to 20 sections (to catch all your fields including section_9)
for ($i = 1; $i <= 20; $i++) {
    $heading = get_field("section_{$i}_heading", $page_id);
    $content = get_field("section_{$i}_content", $page_id);
    
    if (!empty($heading) || !empty($content)) {
        $privacy_sections[] = array(
            'section_heading' => $heading,
            'section_content' => $content
        );
    }
}

// Default sections if no ACF data exists
if (empty($privacy_sections)) {
    $privacy_sections = array(
        array(
            'section_heading' => 'Who we are',
            'section_content' => 'Our website address is: https://yuthlogistics.com.au.'
        ),
        array(
            'section_heading' => 'Comments',
            'section_content' => "When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor's IP address and browser user agent string to help spam detection.\n\nAn anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment."
        ),
        array(
            'section_heading' => 'Media',
            'section_content' => 'If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.'
        ),
        array(
            'section_heading' => 'Cookies',
            'section_content' => "If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.\n\nIf you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.\n\nWhen you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select \"Remember Me\", your login will persist for two weeks. If you log out of your account, the login cookies will be removed.\n\nIf you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day."
        ),
        array(
            'section_heading' => 'Embedded Content from other websites',
            'section_content' => "Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.\n\nThese websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website."
        ),
        array(
            'section_heading' => 'Who we share your data with',
            'section_content' => 'If you request a password reset, your IP address will be included in the reset email.'
        ),
        array(
            'section_heading' => 'How long we retain your data',
            'section_content' => "If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.\n\nFor users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information."
        ),
        array(
            'section_heading' => 'What rights you have over your data',
            'section_content' => 'If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.'
        ),
        array(
            'section_heading' => 'Where we send your data',
            'section_content' => 'Visitor comments may be checked through an automated spam detection service.'
        )
    );
}
?>

<!-- Privacy Policy -->
<section class="privacy-policy-section">
    <div class="banner">
        <div class="banner-content">
            <h1><?php echo esc_html($banner_title); ?></h1>
        </div>
    </div>
    
    <div class="privacy-policy-container">
        <div class="privacy-policy-content">
            <?php if (!empty($privacy_sections)): ?>
                <?php foreach ($privacy_sections as $section): ?>
                    <?php if (!empty($section['section_heading'])): ?>
                        <h2><?php echo esc_html($section['section_heading']); ?></h2>
                    <?php endif; ?>
                    
                    <?php if (!empty($section['section_content'])): ?>
                        <?php 
                        // Split content by double line breaks to create paragraphs
                        $paragraphs = explode("\n\n", $section['section_content']);
                        foreach ($paragraphs as $paragraph) {
                            if (!empty(trim($paragraph))) {
                                echo '<p>' . nl2br(esc_html(trim($paragraph))) . '</p>';
                            }
                        }
                        ?>
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