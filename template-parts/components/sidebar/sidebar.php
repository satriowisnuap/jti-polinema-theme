<?php
/**
 * Sidebar Navigation Component
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/*
========================================
DETECT CURRENT SECTION
========================================
*/

$request_uri =
    $_SERVER['REQUEST_URI'] ?? '';

$uri_path =
    trim(
        parse_url($request_uri, PHP_URL_PATH),
        '/'
    );

$template_slug = get_page_template_slug();
$menu_location = '';

if (
    strpos($uri_path, 'about-us') !== false ||
    strpos($uri_path, 'tentang-kami') !== false ||
    strpos($uri_path, 'sarana') !== false ||
    strpos($uri_path, 'kerjasama') !== false ||
    strpos($uri_path, 'cooperation') !== false ||
    in_array($template_slug, [
        'templates/pages/history-page.php',
        'templates/pages/vision-mission-page.php',
        'templates/pages/organizational-page.php',
        'templates/pages/cooperation-page.php',
        'templates/pages/sarana-prasarana-page.php',
    ], true)
) {

    $menu_location =
        'sidebar-about-us';

} elseif (
    is_singular('study_program') ||
    is_singular('program_khusus') ||
    strpos($template_slug, 'templates/pages/akademik/') === 0 ||
    strpos($uri_path, 'akademik') === 0 ||
    strpos($uri_path, 'study_program') === 0 ||
    strpos($uri_path, 'program-khusus') === 0 ||
    strpos($uri_path, 'program_khusus') === 0 ||
    strpos($uri_path, 'program-studi') === 0 ||
    in_array($uri_path, [
        // Program Pendidikan
        'd2-piranti-lunak',
        'd3-mi-kediri',
        'd3-mi-lumajang',
        'd4-teknik-informatika',
        'd4-sistem-informasi-bisnis',
        's2-rekayasa-teknologi-informasi',
        // Program Khusus
        'kelas-internasional',
        'double-degree',
        'alih-jenjang',
        'rpl',
        // Layanan Akademik
        'aturan-akademik',
        'kalender-akademik',
    ], true) ||
    // Support sub-pages under any of these slugs
    strpos($uri_path, 'd2-piranti-lunak/') === 0 ||
    strpos($uri_path, 'd3-mi-kediri/') === 0 ||
    strpos($uri_path, 'd3-mi-lumajang/') === 0 ||
    strpos($uri_path, 'd4-teknik-informatika/') === 0 ||
    strpos($uri_path, 'd4-sistem-informasi-bisnis/') === 0 ||
    strpos($uri_path, 's2-rekayasa-teknologi-informasi/') === 0 ||
    strpos($uri_path, 'kelas-internasional/') === 0 ||
    strpos($uri_path, 'double-degree/') === 0 ||
    strpos($uri_path, 'alih-jenjang/') === 0 ||
    strpos($uri_path, 'rpl/') === 0 ||
    strpos($uri_path, 'aturan-akademik/') === 0 ||
    strpos($uri_path, 'kalender-akademik/') === 0
) {

    $menu_location =
        'sidebar-akademik';


} elseif (
    strpos($uri_path, 'student-affairs') === 0 ||
    strpos($uri_path, 'kemahasiswaan') === 0 ||
    strpos($uri_path, 'organisasi-kemahasiswaan') === 0 ||
    strpos($uri_path, 'tata-tertib') === 0 ||
    strpos($uri_path, 'magang') === 0 ||
    strpos($uri_path, 'pkl') === 0 ||
    strpos($uri_path, 'prestasi') === 0 ||
    strpos($uri_path, 'achievement') === 0 ||
    strpos($uri_path, 'pengembangan-karir') === 0 ||
    strpos($uri_path, 'beasiswa') === 0 ||
    strpos($uri_path, 'galeri-kemahasiswaan') === 0
) {

    $menu_location =
        'sidebar-student-affairs';

} elseif (
    strpos($uri_path, 'penelitian') === 0 ||
    strpos($uri_path, 'pengabdian') === 0 ||
    strpos($uri_path, 'dedication') === 0 ||
    strpos($uri_path, 'research/') === 0 ||
    strpos($uri_path, 'penelitian') !== false ||
    strpos($uri_path, 'pengabdian') !== false ||
    strpos($uri_path, 'dedication') !== false ||
    strpos($uri_path, 'jurnal') !== false ||
    $template_slug === 'templates/pages/jurnal-page.php'
) {

    $menu_location =
        'sidebar-penelitian';
}

/*
========================================
STOP IF NO SECTION
========================================
*/

if (!$menu_location) {
    return;
}

?>

<aside class="sidebar sidebar-submenu">

    <div class="sidebar-inner">

        <?php

        /*
        ========================================
        USE WP MENU IF EXISTS
        ========================================
        */

        if (
            has_nav_menu($menu_location)
        ) :

            wp_nav_menu([
                'theme_location' => $menu_location,
                'container'      => false,
                'items_wrap'     => '<div id="%1$s" class="sidebar-groups-wrapper %2$s">%3$s</div>',
                'walker'         => new WebJTI_Sidebar_Menu_Walker(),
            ]);

        else :

            /*
            ========================================
            FALLBACK MENU
            ========================================
            */

            get_template_part(
                'template-parts/components/sidebar/sidebar-fallback',
                null,
                [
                    'menu_location' => $menu_location,
                ]
            );

        endif;

        ?>

    </div>

</aside>