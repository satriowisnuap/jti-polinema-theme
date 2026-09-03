<?php
/**
 * Sidebar Menu Item
 *
 * @package WebJTI_Theme
 */

$item = $args['item'] ?? [];

if (empty($item)) {
    return;
}

$request_uri  = $_SERVER['REQUEST_URI'] ?? '';
$current_path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
$item_path    = trim($item['slug'] ?? '', '/');

if (!function_exists('webjti_normalize_sidebar_key')) {
    function webjti_normalize_sidebar_key($path) {
        $path = trim($path, '/');
        // Remove section prefixes
        $path = preg_replace('#^(student-affairs|kemahasiswaan|about-us|tentang-kami|research|penelitian|program-khusus|program_khusus|akademik|program-studi|study_program)/#', '', $path);

        $aliases = [
            'magang'                         => 'magang',
            'pkl'                            => 'magang',
            'pkl-magang'                     => 'magang',
            'praktik-kerja-lapangan-magang'  => 'magang',
            'tata-tertib'                    => 'tata-tertib',
            'achievement'                    => 'achievement',
            'prestasi'                       => 'achievement',
            'history'                        => 'history',
            'sejarah'                        => 'history',
            'vision-mission'                 => 'vision-mission',
            'visi-misi-tujuan'               => 'vision-mission',
            'visi-misi-dan-tujuan'           => 'vision-mission',
            'organization-structure'         => 'organization-structure',
            'struktur-organisasi'            => 'organization-structure',
            'lecturer'                       => 'lecturer',
            'tenaga-pengajar'                => 'lecturer',
            'staff'                          => 'staff',
            'tenaga-kependidikan'            => 'staff',
            'sarana-prasarana'               => 'sarana-prasarana',
            'kerjasama'                      => 'kerjasama',
            'cooperation'                    => 'kerjasama',
            'organisasi-kemahasiswaan'       => 'organisasi-kemahasiswaan',
            'ormawa'                         => 'organisasi-kemahasiswaan',
            'pengembangan-karir'             => 'pengembangan-karir',
            'beasiswa'                       => 'beasiswa',
            'galeri-kemahasiswaan'           => 'galeri-kemahasiswaan',
            'jurnal'                         => 'jurnal',
            'research/jurnal'                => 'jurnal',
            'penelitian/jurnal'              => 'jurnal',
            'penelitian'                     => 'penelitian',
            'research/penelitian'            => 'penelitian',
            'pengabdian'                     => 'pengabdian',
            'research/pengabdian'            => 'pengabdian',
            'dedication'                     => 'pengabdian',
            'kelas-internasional'            => 'kelas-internasional',
            'double-degree'                  => 'double-degree',
            'alih-jenjang'                   => 'alih-jenjang',
            'rpl'                            => 'rpl',
            'd2-piranti-lunak'               => 'd2-piranti-lunak',
            'd3-mi-kediri'                   => 'd3-mi-kediri',
            'd3-mi-lumajang'                 => 'd3-mi-lumajang',
            'd4-teknik-informatika'          => 'd4-teknik-informatika',
            'd4-sistem-informasi-bisnis'     => 'd4-sistem-informasi-bisnis',
            's2-rekayasa-teknologi-informasi'=> 's2-rekayasa-teknologi-informasi',
            'aturan-akademik'                => 'aturan-akademik',
            'kalender-akademik'              => 'kalender-akademik',
        ];

        return $aliases[$path] ?? $path;
    }
}

$current_key  = webjti_normalize_sidebar_key($current_path);
$item_key     = webjti_normalize_sidebar_key($item_path);
$current_bare = basename($current_path);
$item_bare    = basename($item_path);

$is_active = ($current_path === $item_path) ||
             (!empty($item_path) && strpos($current_path, $item_path . '/') === 0) ||
             (!empty($current_key) && $current_key === $item_key) ||
             (!empty($current_bare) && $current_bare === $item_bare);

$icon_class = $is_active
    ? 'ph-fill ph-' . $item['icon']
    : 'ph ph-' . $item['icon'];

?>

<li class="sidebar-menu-item <?php echo $is_active ? 'active' : ''; ?>">

    <a
        href="<?php echo esc_url(home_url('/' . $item['slug'])); ?>"
        class="sidebar-menu-link"
    >

        <span class="sidebar-menu-icon">

            <i class="<?php echo esc_attr($icon_class); ?>"></i>

        </span>

        <span class="sidebar-menu-text">

            <?php echo esc_html($item['label']); ?>

        </span>

    </a>

</li>