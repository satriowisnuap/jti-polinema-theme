<?php
/**
 * Archive Template for Laboratory Custom Post Type
 *
 * @package WebJTI_Theme
 */

get_header();

?>

<main id="primary" class="site-main laboratory-archive-page">

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

            <div class="page-content laboratory-archive-content">

                <?php
                /*
                ==================================================
                PENELITIAN LABORATORY PREVIEW SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/penelitian/penelitian-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
