<?php
/**
 * Template Name: Akademik - Study Program
 * Template Post Type: page, study_program
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main akademik-page study-program-page">

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
                CONTENT SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/akademik/study-program/content-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
