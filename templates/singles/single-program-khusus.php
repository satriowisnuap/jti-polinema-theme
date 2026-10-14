<?php
/**
 * Single Template: Program Khusus
 * Post Type: program_khusus
 *
 * @package WebJTI_Theme
 */

get_header();

if (!have_posts()) {
    echo '<div class="container container--wide"><p>Konten tidak ditemukan.</p></div>';
    get_footer();
    return;
}

the_post();

?>

<main id="primary" class="site-main akademik-page program-khusus-page">

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
                    'template-parts/sections/akademik/program-khusus/content-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
