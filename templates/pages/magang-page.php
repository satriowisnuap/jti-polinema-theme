<?php
/**
 * Template Name: Praktik Kerja Lapangan / Magang
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main magang-page">

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
                ALUR MAGANG / PKL SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/magang/alur-section'
                );

                /*
                ==================================================
                DAFTAR PERUSAHAAN MAGANG TABLE SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/magang/company-table-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
