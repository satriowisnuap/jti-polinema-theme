<?php

/* ========================================
   THEME SUPPORT
======================================== */

function webjti_theme_support() {

  add_theme_support('title-tag');

  add_theme_support('post-thumbnails');

  add_theme_support('html5', [
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ]);

  add_theme_support('custom-logo');

  add_theme_support('customize-selective-refresh-widgets');

}

add_action(
  'after_setup_theme',
  'webjti_theme_support'
);

// Hide Admin Bar on the front-end
add_filter('show_admin_bar', '__return_false');

function webjti_register_custom_page_templates($post_templates, $wp_theme, $post, $post_type) {
    if ($post_type === 'page') {
        $post_templates['templates/pages/history-page.php'] = 'Sejarah Kami';
        $post_templates['templates/pages/vision-mission-page.php'] = 'Visi Misi Tujuan';
        $post_templates['templates/pages/organizational-page.php'] = 'Struktur Organisasi';
        $post_templates['templates/pages/cooperation-page.php'] = 'Kerjasama';
        $post_templates['templates/pages/lecturer-page.php'] = 'Tenaga Pengajar';
        $post_templates['templates/pages/staff-page.php'] = 'Tenaga Kependidikan';
        $post_templates['templates/pages/information-page.php'] = 'Informasi';
        $post_templates['templates/pages/achievement-page.php'] = 'Prestasi';
        $post_templates['templates/pages/tata-tertib-page.php'] = 'Tata Tertib Kehidupan Kampus';
        $post_templates['templates/pages/magang-page.php'] = 'Praktik Kerja Lapangan / Magang';
        $post_templates['templates/pages/jurnal-page.php'] = 'Jurnal';
        $post_templates['templates/pages/sarana-prasarana-page.php'] = 'Sarana dan Prasarana';
        $post_templates['templates/pages/gallery-kemahasiswaan-page.php'] = 'Gallery Kemahasiswaan';
        $post_templates['templates/pages/akademik/d2-piranti-lunak-page.php'] = 'Akademik - D2 Pengembangan Piranti Lunak Situs';
        $post_templates['templates/pages/akademik/d3-mi-kediri-page.php'] = 'Akademik - D3 Manajemen Informatika Kediri';
        $post_templates['templates/pages/akademik/d3-mi-lumajang-page.php'] = 'Akademik - D3 Manajemen Informatika Lumajang';
        $post_templates['templates/pages/akademik/d4-teknik-informatika-page.php'] = 'Akademik - D4 Teknik Informatika';
        $post_templates['templates/pages/akademik/d4-sistem-informasi-bisnis-page.php'] = 'Akademik - D4 Sistem Informasi Bisnis';
        $post_templates['templates/pages/akademik/s2-rekayasa-teknologi-informasi-page.php'] = 'Akademik - S2 Rekayasa Teknologi Informasi';
        $post_templates['templates/pages/akademik/kelas-internasional-page.php'] = 'Akademik - Kelas Internasional';
        $post_templates['templates/pages/akademik/double-degree-page.php'] = 'Akademik - Double Degree';
        $post_templates['templates/pages/akademik/alih-jenjang-page.php'] = 'Akademik - Alih Jenjang';
        $post_templates['templates/pages/akademik/rpl-page.php'] = 'Akademik - Rekognisi Pembelajaran Lampau (RPL)';
        $post_templates['templates/pages/akademik/aturan-akademik-page.php'] = 'Akademik - Aturan Akademik';
        $post_templates['templates/pages/akademik/kalender-akademik-page.php'] = 'Akademik - Kalender Akademik';
        $post_templates['templates/pages/beasiswa-page.php'] = 'Kemahasiswaan - Beasiswa';
    }
    return $post_templates;
}
add_filter('theme_page_templates', 'webjti_register_custom_page_templates', 10, 4);

/**
 * Disable archives for Lecturer and Kependidikan custom post types to resolve slug conflicts with static Pages.
 */
function webjti_disable_cpt_archives($args, $post_type) {
    if (in_array($post_type, ['lecturer', 'kependidikan'], true)) {
        $args['has_archive'] = false;
    }
    return $args;
}
add_filter('register_post_type_args', 'webjti_disable_cpt_archives', 99, 2);