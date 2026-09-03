<?php
/**
 * Archive Template for Information Custom Post Type
 *
 * @package WebJTI_Theme
 */

get_header();

?>

<main id="primary" class="site-main information-page">

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

            <div class="page-content information-page-content">

                <?php
                /*
                ==================================================
                SHARED LAYOUT COMPONENT
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/informasi/information-layout'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
