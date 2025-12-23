<?php
/**
 * Template Name: Do Register
 */

get_header(); ?>

<div class="Do-register">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php get_footer(); ?>