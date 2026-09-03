<?php
/**
 * Single Template: Achievement
 * Post Type: prestasi
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

/*
==================================================
OPTIONAL STYLES
==================================================
*/
wp_enqueue_style(
    'jti-achievement-detail',
    get_template_directory_uri() . '/assets/css/sections/achievement-detail.css',
    ['webjti-app'],
    filemtime(get_template_directory() . '/assets/css/sections/achievement-detail.css')
);

get_header();

// Check if this is a default fallback or if the database is empty
$is_default = isset($_GET['default_achievement']) || !have_posts();
$default_id = isset($_GET['default_achievement']) ? sanitize_text_field($_GET['default_achievement']) : '';

$achievement = null;
$members = [];
$gallery = [];
$related = [];

if ($is_default) {
    if (empty($default_id)) {
        $default_id = 'default-1';
    }

    // Call helper function in query.php to retrieve fallback data
    $fallback_data = webjti_get_fallback_achievement_data($default_id);
    
    $achievement = $fallback_data['achievement'];
    $members     = $fallback_data['members'];
    $gallery     = $fallback_data['gallery'];
    $related     = $fallback_data['related'];
} else {
    // Real CPT inside normal loop
    if (have_posts()) {
        the_post();
        
        $post_id = get_the_ID();
        $title = get_field('judul_kompetisi') ?: get_the_title();
        $date = get_field('tanggal');
        $year = get_field('achievement_year') ?: get_field('tahun_prestasi');
        $level_raw = get_field('level') ?: get_field('tingkat');
        $winner = get_field('rank') ?: get_field('juara');
        
        $achievement = [
            'id' => $post_id,
            'judul_kompetisi' => $title,
            'juara' => $winner,
            'tingkat' => $level_raw,
            'tanggal' => $date,
            'tahun_prestasi' => $year,
            'penyelenggara' => get_field('organizer') ?: get_field('penyelenggara'),
            'lokasi' => get_field('location') ?: get_field('lokasi'),
            'bidang' => get_field('category') ?: get_field('bidang'),
            'jumlah_peserta' => get_field('participant_count') ?: get_field('jumlah_peserta'),
            'deskripsi' => get_field('deskripsi'),
        ];
    }
}

if ($achievement) {
    $badge_data = webjti_get_achievement_badges(
        $is_default ? null : ($achievement['id'] ?? null),
        $is_default ? $achievement : null
    );
    $achievement['badge_tahun'] = $badge_data['tahun'] ?? '';
    $achievement['badge_juara'] = $badge_data['juara'] ?? '';
    $achievement['badge_juara_class'] = $badge_data['juara_class'] ?? '';
    $achievement['badge_tingkat'] = $badge_data['tingkat'] ?? '';
    $achievement['badge_tingkat_class'] = $badge_data['tingkat_class'] ?? '';
}
?>

<main id="primary" class="site-main single-achievement-page">

    <div class="container container--wide single-achievement__container">

        <?php if ($achievement) : ?>

            <div class="single-achievement__layout">

                <!-- ==============================================
                BREADCRUMB
                =============================================== -->
                <?php
                get_template_part(
                    'template-parts/components/breadcrumb',
                    null,
                    [
                        'current_override' => 'Detail Prestasi'
                    ]
                );
                ?>

                <!-- ==============================================
                ACHIEVEMENT HEADER SECTION (100% WIDTH BANNER & META)
                =============================================== -->
                <?php
                get_template_part(
                    'template-parts/single/achievement/achievement-header',
                    null,
                    [
                        'achievement' => $achievement,
                        'is_default'  => $is_default
                    ]
                );
                ?>

                <!-- ==============================================
                ACHIEVEMENT BODY SECTIONS (CONTENT BLOCKS - 1 COLUMN)
                =============================================== -->
                <div class="single-achievement__content-blocks">

                    <?php
                    // 1. Anggota Tim Section
                    get_template_part(
                        'template-parts/single/achievement/achievement-team',
                        null,
                        [
                            'achievement' => $achievement,
                            'is_default'  => $is_default,
                            'members'     => $members
                        ]
                    );

                    // 2. Capaian Prestasi Section
                    get_template_part(
                        'template-parts/single/achievement/achievement-summary',
                        null,
                        [
                            'achievement' => $achievement,
                            'is_default'  => $is_default
                        ]
                    );

                    // 3. Deskripsi Kompetisi Section
                    get_template_part(
                        'template-parts/single/achievement/achievement-description',
                        null,
                        [
                            'achievement' => $achievement,
                            'is_default'  => $is_default
                        ]
                    );

                    // 4. Dokumentasi Kompetisi Gallery Section
                    get_template_part(
                        'template-parts/single/achievement/achievement-gallery',
                        null,
                        [
                            'achievement' => $achievement,
                            'is_default'  => $is_default,
                            'gallery'     => $gallery
                        ]
                    );
                    ?>

                </div><!-- .single-achievement__content-blocks -->

            </div><!-- .single-achievement__layout -->

        <?php else : ?>

            <div class="achievement-empty-state">
                <i class="ph ph-medal"></i>
                <h2><?php esc_html_e('Data Prestasi Tidak Ditemukan', 'webjti'); ?></h2>
                <p><?php esc_html_e('Mohon kembali ke halaman utama direktori Prestasi.', 'webjti'); ?></p>
                <a href="<?php echo esc_url(home_url('/student-affairs/achievement')); ?>" class="jti-btn jti-btn--primary">
                    <?php esc_html_e('Lihat Semua Prestasi', 'webjti'); ?>
                </a>
            </div>

        <?php endif; ?>

    </div><!-- .container -->

    <!-- ==============================================
    RELATED ACHIEVEMENTS SECTION (BG COLOR #F1F1F0)
    =============================================== -->
    <?php
    get_template_part(
        'template-parts/single/achievement/related-achievements',
        null,
        [
            'achievement' => $achievement,
            'is_default'  => $is_default,
            'related'     => $related
        ]
    );
    ?>

</main><!-- #primary -->

<?php
get_footer();