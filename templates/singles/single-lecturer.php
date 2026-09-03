<?php
/**
 * Template Name: Lecturer Detail
 * Template Post Type: lecturer
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

/*
==================================================
OPTIONAL STYLES
==================================================
*/
wp_enqueue_style(
    'jti-lecturer-detail',
    get_template_directory_uri() . '/assets/css/lecturer-detail.css',
    ['webjti-app'],
    filemtime(get_template_directory() . '/assets/css/lecturer-detail.css')
);

// Check if this is a default fallback or if the database is empty
$is_default = isset($_GET['default_lecturer']) || !have_posts();
$default_id = isset($_GET['default_lecturer']) ? sanitize_text_field($_GET['default_lecturer']) : '';

$lecturer = null;
$educations = [];
$certifications = [];
$courses = [
    'odd' => [],
    'even' => []
];
$publications = [];

$prev_name = '';
$prev_url = '';
$next_name = '';
$next_url = '';

if ($is_default) {
    if (empty($default_id)) {
        $default_id = 'default-1';
    }

    // Call isolated helper function to retrieve fallback profile and navigation cycling
    $fallback_data = webjti_get_fallback_lecturer_data($default_id);
    
    $lecturer       = $fallback_data['lecturer'];
    $educations     = $fallback_data['educations'];
    $certifications = $fallback_data['certifications'];
    $courses        = $fallback_data['courses'];
    $publications   = $fallback_data['publications'];
    $prev_name      = $fallback_data['prev_name'];
    $prev_url       = $fallback_data['prev_url'];
    $next_name      = $fallback_data['next_name'];
    $next_url       = $fallback_data['next_url'];
} else {
    // Real Lecturer CPT inside standard loop
    if (have_posts()) {
        the_post();
        $post_id        = get_the_ID();
        $lecturer       = webjti_get_single_lecturer($post_id);
        $educations     = webjti_get_lecturer_education($post_id);
        $certifications = webjti_get_lecturer_certifications($post_id);
        $courses        = webjti_get_lecturer_courses($post_id);
        $publications   = webjti_get_lecturer_publications($post_id);

        // Dynamic Previous & Next Lecturer CPT Name-based Navigation
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ($prev_post) {
            $prev_name = $prev_post->post_title;
            $prev_url = get_permalink($prev_post->ID);
        }
        if ($next_post) {
            $next_name = $next_post->post_title;
            $next_url = get_permalink($next_post->ID);
        }
    }
}

?>

<main id="primary" class="site-main single-lecturer-page">

    <div class="container container--wide">

        <?php
        /*
        ==================================================
        BREADCRUMB
        ==================================================
        */
        get_template_part(
            'template-parts/components/breadcrumb',
            null,
            [
                'current_override' => 'Detail Tenaga Pengajar'
            ]
        );
        ?>

        <?php if ($lecturer) : ?>

            <div class="lecturer-detail-layout">

                <!-- ==========================================
                SIDEBAR (LEFT COLUMN)
                =========================================== -->
                <aside class="lecturer-sidebar-col">
                    <?php
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-sidebar',
                        null,
                        [
                            'lecturer' => $lecturer
                        ]
                    );
                    ?>
                </aside>

                <!-- ==========================================
                MAIN CONTENT (RIGHT COLUMN)
                =========================================== -->
                <div class="lecturer-main-content">

                    <?php
                    /*
                    ==========================================
                    SOCIAL SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-social',
                        null,
                        [
                            'lecturer' => $lecturer
                        ]
                    );

                    /*
                    ==========================================
                    EXPERTISE SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-expertise',
                        null,
                        [
                            'lecturer' => $lecturer
                        ]
                    );

                    /*
                    ==========================================
                    EDUCATION SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-education',
                        null,
                        [
                            'education' => $educations
                        ]
                    );

                    /*
                    ==========================================
                    CERTIFICATION SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-sertification',
                        null,
                        [
                            'certifications' => $certifications
                        ]
                    );

                    /*
                    ==========================================
                    COURSE SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-courses',
                        null,
                        [
                            'courses' => $courses
                        ]
                    );

                    /*
                    ==========================================
                    PUBLICATION SECTION
                    ==========================================
                    */
                    get_template_part(
                        'template-parts/single/lecturer/lecturer-publication',
                        null,
                        [
                            'publications' => $publications,
                            'sinta_link' => $lecturer['sinta'] ?? ''
                        ]
                    );
                    ?>

                </div><!-- .lecturer-main-content -->

            </div><!-- .lecturer-detail-layout -->

            <!-- ==========================================
            LECTURER NAVIGATION (BOTTOM PREV / NEXT BAR)
            =========================================== -->
            <?php if ($prev_url || $next_url) : ?>
                <nav class="lecturer-navigation">
                    <div class="lecturer-navigation__inner">
                        <?php if ($prev_url) : ?>
                            <a href="<?php echo esc_url($prev_url); ?>" class="lecturer-nav-link lecturer-nav-link--prev">
                                <span class="lecturer-nav-label">
                                    <i class="ph ph-arrow-left"></i>
                                    <?php esc_html_e('Sebelumnya', 'webjti'); ?>
                                </span>
                                <span class="lecturer-nav-name"><?php echo esc_html($prev_name); ?></span>
                            </a>
                        <?php else : ?>
                            <div class="lecturer-nav-placeholder"></div>
                        <?php endif; ?>

                        <?php if ($next_url) : ?>
                            <a href="<?php echo esc_url($next_url); ?>" class="lecturer-nav-link lecturer-nav-link--next">
                                <span class="lecturer-nav-label">
                                    <?php esc_html_e('Selanjutnya', 'webjti'); ?>
                                    <i class="ph ph-arrow-right"></i>
                                </span>
                                <span class="lecturer-nav-name"><?php echo esc_html($next_name); ?></span>
                            </a>
                        <?php else : ?>
                            <div class="lecturer-nav-placeholder"></div>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <div class="lecturer-empty-state">
                <i class="ph ph-users-three"></i>
                <h2><?php esc_html_e('Tenaga Pengajar Tidak Ditemukan', 'webjti'); ?></h2>
                <p><?php esc_html_e('Mohon kembali ke halaman utama Tenaga Pengajar.', 'webjti'); ?></p>
                <a href="<?php echo esc_url(home_url('/lecturer')); ?>" class="jti-btn jti-btn--primary">
                    <?php esc_html_e('Lihat Semua Tenaga Pengajar', 'webjti'); ?>
                </a>
            </div>

        <?php endif; ?>

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();