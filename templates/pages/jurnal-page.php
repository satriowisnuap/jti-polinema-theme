<?php
/**
 * Template Name: Jurnal
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main jurnal-page">

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
                JURNAL PAGE CONTENT
                ==================================================
                */
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        $content = apply_filters( 'the_content', get_the_content() );
                        if ( ! empty( trim( strip_tags( $content ) ) ) ) {
                            echo '<div class="entry-content" style="margin-bottom: 3rem;">';
                            echo wp_kses_post( $content );
                            echo '</div>';
                        }
                    }
                }
                
                /*
                ==================================================
                JURNAL SECTION
                ==================================================
                */
                get_template_part(
                    'template-parts/sections/penelitian/jurnal-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();
