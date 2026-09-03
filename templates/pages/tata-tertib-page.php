<?php
/**
 * Template Name: Tata Tertib Kehidupan Kampus
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main tata-tertib-page">

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
                HAK MAHASISWA SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/tata-tertib/hak-mahasiswa-section'
                );

                /*
                ==================================================
                KEWAJIBAN MAHASISWA SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/tata-tertib/kewajiban-mahasiswa-section'
                );

                /*
                ==================================================
                LARANGAN MAHASISWA SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/tata-tertib/larangan-mahasiswa-section'
                );

                /*
                ==================================================
                KLASIFIKASI SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/tata-tertib/klasifikasi-section'
                );

                /*
                ==================================================
                SANKSIS SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/kemahasiswaan/tata-tertib/sanksi-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
