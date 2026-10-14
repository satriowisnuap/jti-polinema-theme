<?php
/**
 * Template Name: Visi Misi Tujuan
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main vision-mission-page">

    <?php
    /*
    ==================================================
    PAGE HEADER
    ==================================================
    */
    get_template_part(
        'template-parts/components/page-header'
    );
    ?>

    <div class="container container--wide">

        <div class="page-layout with-sidebar">

            <?php
            /*
            ==================================================
            SIDEBAR NAVIGATION
            ==================================================
            */
            get_template_part(
                'template-parts/components/sidebar/sidebar'
            );
            ?>

            <div class="page-content documentation-content">

                <?php
                /*
                ==================================================
                VISION SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/about us/vision-mission/vision-section'
                );

                /*
                ==================================================
                MISSION SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/about us/vision-mission/mission-section'
                );

                /*
                ==================================================
                GOALS SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/about us/vision-mission/goals-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();