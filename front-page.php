<?php
/**
 * Front Page Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main front-page">

    <?php

    /*
    ==================================================
    HERO SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/hero-section'
    );

    /*
    ==================================================
    LATEST NEWS SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/information-section'
    );

    /*
    ==================================================
    STATS SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/stats-section'
    );

    /*
    ==================================================
    STUDY PROGRAMS SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/study-programs-section'
    );

    /*
    ==================================================
    VIDEO SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/video-section'
    );

    /*
    ==================================================
    CAMPUS SECTION
    ==================================================
    */

    get_template_part(
        'template-parts/sections/landing/campus-section'
    );

    ?>

</main><!-- #primary -->

<?php

get_footer();