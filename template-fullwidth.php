<?php
/**
 * Template Name: Full Width 
 */

get_header(); ?>

<div class="full-width-content">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php get_footer(); ?>