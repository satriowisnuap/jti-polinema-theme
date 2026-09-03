<?php
/**
 * Template Name: Sarana dan Prasarana
 * Template Post Type: page
 *
 * Halaman Sarana dan Prasarana JTI dengan tab kategori fasilitas
 * dan daftar item fasilitas yang bisa diatur via ACF.
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main sarana-page">

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
                SARANA DAN PRASARANA SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/sarana/sarana-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
