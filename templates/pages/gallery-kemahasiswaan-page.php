<?php
/**
 * Template Name: Gallery Kemahasiswaan
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main gallery-page">

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

            <div class="page-content gallery-page-content">

                <?php
                // Fetch dynamic title from ACF
                $gallery_page_title = webjti_field('gallery_page_title', get_the_ID(), 'Galeri Kegiatan Mahasiswa');
                ?>

                <!-- ============================================================
                     DYNAMIC GALLERY TITLE
                ============================================================ -->
                <header class="cooperation-section__header gallery-page__header" style="margin-bottom: 1.5rem; padding-bottom: 1.25rem;">
                    <div class="cooperation-section__icon-wrap">
                        <i class="ph-fill ph-image" aria-hidden="true"></i>
                    </div>
                    <h1 class="cooperation-section__title" style="margin-bottom: 0;">
                        <?php echo esc_html($gallery_page_title); ?>
                    </h1>
                </header>

                <?php
                /*
                ==================================================
                GALLERY GRID SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/gallery/gallery-grid'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
