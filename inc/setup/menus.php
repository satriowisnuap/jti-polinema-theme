<?php
/**
 * Register Theme Menus
 *
 * @package WebJTI_Theme
 */

function webjti_register_menus()
{
    register_nav_menus([

        'main_menu' => __(
            'Menu Utama',
            'webjti-theme'
        ),

        'sidebar_menu' => __(
            'Menu Sidebar',
            'webjti-theme'
        ),

        'footer_menu' => __(
            'Menu Footer',
            'webjti-theme'
        ),

        'footer_programs' => __(
            'Footer - Program Studi',
            'webjti-theme'
        ),

        'footer_academic' => __(
            'Footer - Akademik',
            'webjti-theme'
        ),

        'footer_research' => __(
            'Footer - Penelitian',
            'webjti-theme'
        ),

        'mobile_menu' => __(
            'Menu Mobile',
            'webjti-theme'
        ),

        'sidebar-about-us' =>
            __('Sidebar Tentang Kami', 'webjti-theme'),

        'sidebar-akademik' =>
            __('Sidebar Akademik', 'webjti-theme'),

        'sidebar-student-affairs' =>
            __('Sidebar Kemahasiswaan', 'webjti-theme'),

        'sidebar-penelitian' =>
            __('Sidebar Penelitian', 'webjti-theme'),

    ]);
}

add_action(
    'after_setup_theme',
    'webjti_register_menus'
);

/**
 * Fix active menu classes for Program Khusus CPT
 */
add_filter('nav_menu_css_class', 'webjti_cpt_active_menu_classes', 10, 2);
function webjti_cpt_active_menu_classes($classes, $item) {
    $uri_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $current_bare = basename($uri_path);
    $template_slug = get_page_template_slug();
    
    $pk_slugs = ['kelas-internasional', 'double-degree', 'alih-jenjang', 'rpl'];
    
    $is_pk = is_singular('program_khusus') || 
             strpos($uri_path, 'program-khusus') !== false || 
             strpos($uri_path, 'program_khusus') !== false ||
             in_array($current_bare, $pk_slugs, true) ||
             in_array($template_slug, [
                 'templates/pages/akademik/kelas-internasional-page.php',
                 'templates/pages/akademik/double-degree-page.php',
                 'templates/pages/akademik/alih-jenjang-page.php',
                 'templates/pages/akademik/rpl-page.php',
             ], true);

    if ($is_pk) {
        $tipe_program = is_singular('program_khusus') ? get_post_meta(get_the_ID(), '_pk_tipe_program', true) : '';
        $item_title_clean = strtolower(trim($item->title));
        $url_path = trim(parse_url($item->url ?? '', PHP_URL_PATH), '/');
        $item_bare = basename($url_path);

        // 1. Highlight "Akademik" in main menu
        if ($item_title_clean === 'akademik' || strpos($item->url, '/akademik') !== false) {
            $classes[] = 'current-menu-ancestor';
            $classes[] = 'current-menu-item';
            $classes[] = 'active';
        }

        // 2. Highlight specific Program Khusus in menu / sidebar
        $is_match = false;
        if ($current_bare && ($current_bare === $item_bare || strpos($url_path, $current_bare) !== false)) {
            $is_match = true;
        } elseif ($tipe_program === 'rpl' && strpos($url_path, 'rpl') !== false) {
            $is_match = true;
        } elseif ($tipe_program === 'alih_jenjang' && strpos($url_path, 'alih-jenjang') !== false) {
            $is_match = true;
        } elseif ($tipe_program === 'double_degree' && strpos($url_path, 'double-degree') !== false) {
            $is_match = true;
        } elseif ($tipe_program === 'kelas_internasional' && strpos($url_path, 'kelas-internasional') !== false) {
            $is_match = true;
        }

        if ($is_match) {
            $classes[] = 'current-menu-item';
            $classes[] = 'active';
        }
    }
    
    return array_unique($classes);
}