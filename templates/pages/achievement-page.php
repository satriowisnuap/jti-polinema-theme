<?php
/**
 * Template Name: Prestasi
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main achievement-page">

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

            <div class="page-content achievement-page-content">

                <?php
                /*
                ==================================================
                ACHIEVEMENT METRICS SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/prestasi/achievement-metrics'
                );
                ?>

                <?php
                /*
                ==================================================
                ACHIEVEMENT FILTER SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/prestasi/achievement-filters'
                );
                ?>

                <?php
                /*
                ==================================================
                ACHIEVEMENT TABLE SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/prestasi/achievement-table'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();