<?php
/**
 * The template for displaying all single study programs.
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_slug = get_post_field('post_name', get_post());

// Load the unified academic study program page template
$template_path = locate_template("templates/pages/akademik/study-program-page.php");

if ($template_path) {
    include $template_path;
} else {
    // Fallback
    get_header();
    ?>
    <main id="primary" class="site-main akademik-page default-study-program-page">
        <?php get_template_part('template-parts/components/page-header'); ?>
        <div class="container container--wide">
            <div class="page-layout with-sidebar">
                <?php get_template_part('template-parts/components/sidebar/sidebar'); ?>
                <div class="page-content documentation-content">
                    <section class="akademik-program-section">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) :
                                the_post();
                                ?>
                                <article class="akademik-program-section__card">
                                    <h2><?php the_title(); ?></h2>
                                    <?php the_content(); ?>
                                </article>
                                <?php
                            endwhile;
                        endif;
                        ?>
                    </section>
                </div><!-- .page-content -->
            </div><!-- .page-layout -->
        </div><!-- .container -->
    </main><!-- #primary -->
    <?php
    get_footer();
}