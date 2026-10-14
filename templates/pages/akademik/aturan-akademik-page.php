<?php
/**
 * Template Name: Akademik - Aturan Akademik
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main akademik-page aturan-akademik-page">

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
                    'template-parts/sections/akademik/aturan-akademik/content-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

// Fallback: pastikan accordion script selalu ter-init di halaman ini
add_action('wp_footer', function () {
    // Cek apakah script sudah di-enqueue atau di-print — jika belum, inject inline
    if (!wp_script_is('webjti-aturan-akademik-accordion', 'enqueued') && !wp_script_is('webjti-aturan-akademik-accordion', 'done')) {
        echo '<script src="' . esc_url(get_template_directory_uri() . '/assets/js/sections/aturan-akademik-accordion.js') . '"></script>';
    }
}, 99);

get_footer();
