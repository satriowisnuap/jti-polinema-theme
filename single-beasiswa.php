<?php
/**
 * Single template for Beasiswa Custom Post Type
 *
 * @package WebJTI_Theme
 */

get_header();
?>

<main id="primary" class="site-main kemahasiswaan-page beasiswa-detail-page">

    <?php
    get_template_part(
        'template-parts/components/page-header'
    );
    ?>

    <div class="container container--wide">

        <div class="page-layout with-sidebar">

            <?php
            get_template_part(
                'template-parts/components/sidebar/sidebar'
            );
            ?>

            <div class="page-content documentation-content">

                <?php
                get_template_part(
                    'template-parts/sections/kemahasiswaan/beasiswa/detail-content-section'
                );
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php
get_footer();
