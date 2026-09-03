<?php
/**
 * Navigation Menu Template
 *
 * @package WebJTI_Theme
 */

// Fallback function for the default menu matching Figma Mega Menus
if (!function_exists('webjti_default_primary_menu_fallback')) {
    function webjti_default_primary_menu_fallback() {
        // Detect which top-level menu section is currently active
        $request_uri   = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
        $current_slug  = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

        $nav_is_active = function( $slugs ) use ( $current_slug ) {
            foreach ( (array) $slugs as $slug ) {
                $slug = trim( $slug, '/' );
                if ( $current_slug === $slug || strpos( $current_slug, $slug . '/' ) === 0 ) {
                    return true;
                }
            }
            return false;
        };

        $is_lecturer_active = (isset($_GET['default_lecturer']) && !empty($_GET['default_lecturer'])) || 
                              is_singular('lecturer') || 
                              is_post_type_archive('lecturer') || 
                              is_page_template('templates/pages/lecturer-page.php') ||
                              $nav_is_active( [ 'lecturer', 'tenaga-pengajar' ] );

        $is_achievement_active = (isset($_GET['default_achievement']) && !empty($_GET['default_achievement'])) || 
                                 is_singular('achievement') || 
                                 is_post_type_archive('achievement') || 
                                 is_page_template('templates/pages/achievement-page.php') ||
                                 $nav_is_active( [ 'achievement', 'prestasi' ] );

        if ( isset($_GET['default_info']) && !empty($_GET['default_info']) ) {
            $current_page = 'information';
        } elseif ( $is_lecturer_active ) {
            $current_page = 'about-us';
        } elseif ( $is_achievement_active ) {
            $current_page = 'student-affairs';
        } elseif ( is_front_page() ) {
            $current_page = 'beranda';
        } elseif ( $nav_is_active( [ 'about-us', 'history', 'vision-mission', 'organization-structure', 'lecturer', 'staff', 'sarana-prasarana', 'kerjasama', 'tentang-kami', 'sejarah', 'visi-misi-tujuan', 'visi-misi-dan-tujuan', 'struktur-organisasi', 'tenaga-pengajar', 'tenaga-kependidikan' ] ) ) {
            $current_page = 'about-us';
        } elseif ( $nav_is_active( [ 'akademik', 'd3-mi-kediri', 'd3-mi-lumajang', 'd4-teknik-informatika', 'd4-sistem-informasi-bisnis', 's2-rekayasa-teknologi-informasi', 'kelas-internasional', 'double-degree', 'alih-jenjang', 'rpl', 'aturan-akademik', 'kalender-akademik', 'prodi', 'program-khusus', 'program_khusus', 'program-studi', 'study_program' ] ) ) {
            $current_page = 'akademik';
        } elseif ( $nav_is_active( [ 'student-affairs', 'tata-tertib', 'pkl', 'pkl-magang', 'organisasi-kemahasiswaan', 'pengembangan-karir', 'beasiswa', 'galeri-kemahasiswaan', 'kemahasiswaan' ] ) ) {
            $current_page = 'student-affairs';
        } elseif ( $nav_is_active( [ 'penelitian', 'research/penelitian', 'pengabdian', 'research/pengabdian', 'lab-nsc', 'lab-rpl', 'lab-ivss', 'lab-inlet', 'lab-ba', 'lab-dt', 'lab-mmt', 'lab-is', 'jurnal', 'research/jurnal' ] ) ) {
            $current_page = 'penelitian';
        } elseif ( $nav_is_active( [ 'information', 'news', 'announcement', 'event', 'informasi', 'berita', 'pengumuman', 'agenda' ] ) ) {
            $current_page = 'information';
        } else {
            $current_page = '';
        }
        ?>
        <ul id="primary-menu" class="primary-menu">
            <li class="mobile-menu-header">
                <span class="mobile-menu-title">Menu</span>
                <button type="button" class="mobile-menu-close" aria-label="Tutup Menu">
                    <i class="ph ph-x"></i>
                </button>
            </li>
            <!-- Beranda -->
            <li class="menu-item<?php echo $current_page === 'beranda' ? ' current-menu-item active' : ''; ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="menu-link">
                    Beranda
                </a>
            </li>

            <!-- Tentang Kami -->
            <li class="menu-item menu-item-has-dropdown<?php echo $current_page === 'about-us' ? ' current-menu-item active' : ''; ?>">
                <a href="<?php echo esc_url( site_url( '/about-us/history' ) ); ?>" class="menu-link menu-link--dropdown">
                    Tentang Kami
                    <i class="ph ph-caret-down caret-icon"></i>
                </a>
                <div class="mega-dropdown">
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Tentang Kami</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/about-us/history' ) ); ?>"<?php echo $nav_is_active(['history', 'sejarah']) ? ' class="text-orange"' : ''; ?>>Sejarah Kami</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/about-us/vision-mission' ) ); ?>"<?php echo $nav_is_active(['vision-mission', 'visi-misi']) ? ' class="text-orange"' : ''; ?>>Visi, Misi dan Tujuan</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Organisasi</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/about-us/organization-structure' ) ); ?>"<?php echo $nav_is_active(['organization-structure', 'struktur-organisasi']) ? ' class="text-orange"' : ''; ?>>Struktur Organisasi</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/about-us/lecturer' ) ); ?>"<?php echo $is_lecturer_active ? ' class="text-orange"' : ''; ?>>Tenaga Pengajar</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/about-us/staff' ) ); ?>"<?php echo $nav_is_active(['staff', 'tenaga-kependidikan']) ? ' class="text-orange"' : ''; ?>>Tenaga Kependidikan</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Fasilitas & Kerjasama</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/about-us/sarana-prasarana' ) ); ?>"<?php echo $nav_is_active(['sarana-prasarana']) ? ' class="text-orange"' : ''; ?>>Sarana dan Prasarana</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/about-us/kerjasama' ) ); ?>"<?php echo $nav_is_active(['kerjasama']) ? ' class="text-orange"' : ''; ?>>Kerjasama</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Akademik -->
            <li class="menu-item menu-item-has-dropdown<?php echo $current_page === 'akademik' ? ' current-menu-item active' : ''; ?>">
                <a href="#" class="menu-link menu-link--dropdown" onclick="return false;">
                    Akademik
                    <i class="ph ph-caret-down caret-icon"></i>
                </a>
                <div class="mega-dropdown mega-dropdown--wide">
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Program Pendidikan</span>
                        <ul class="mega-dropdown__list mega-dropdown__list--grouped">
                            <li class="mega-dropdown__group">
                                <span class="mega-dropdown__sublabel">Diploma III (D3)</span>
                                <a href="<?php echo esc_url( site_url( '/d3-mi-kediri' ) ); ?>">D3 Manajemen Informatika (Kediri)</a>
                                <a href="<?php echo esc_url( site_url( '/d3-mi-lumajang' ) ); ?>">D3 Manajemen Informatika (Lumajang)</a>
                            </li>
                            <li class="mega-dropdown__group">
                                <span class="mega-dropdown__sublabel">Sarjana Terapan</span>
                                <a href="<?php echo esc_url( site_url( '/d4-teknik-informatika' ) ); ?>">D4 Teknik Informatika</a>
                                <a href="<?php echo esc_url( site_url( '/d4-sistem-informasi-bisnis' ) ); ?>">D4 Sistem Informasi Bisnis</a>
                            </li>
                            <li class="mega-dropdown__group">
                                <span class="mega-dropdown__sublabel">Magister Terapan</span>
                                <a href="<?php echo esc_url( site_url( '/s2-rekayasa-teknologi-informasi' ) ); ?>">S2 Rekayasa Teknologi Informasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Program Khusus</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/kelas-internasional' ) ); ?>"<?php echo $nav_is_active(['kelas-internasional', 'program-khusus/kelas-internasional']) ? ' class="text-orange"' : ''; ?>>Kelas Internasional</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/double-degree' ) ); ?>"<?php echo $nav_is_active(['double-degree', 'program-khusus/double-degree']) ? ' class="text-orange"' : ''; ?>>Double Degree</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/alih-jenjang' ) ); ?>"<?php echo $nav_is_active(['alih-jenjang', 'program-khusus/alih-jenjang']) ? ' class="text-orange"' : ''; ?>>Alih Jenjang</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/rpl' ) ); ?>"<?php echo $nav_is_active(['rpl', 'program-khusus/rpl']) ? ' class="text-orange"' : ''; ?>>Rekognisi Pembelajaran Lampau (RPL)</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Layanan Akademik</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/aturan-akademik' ) ); ?>">Aturan Akademik</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/kalender-akademik' ) ); ?>">Kalender Akademik</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Kemahasiswaan -->
            <li class="menu-item menu-item-has-dropdown<?php echo $current_page === 'student-affairs' ? ' current-menu-item' : ''; ?>">
                <a href="<?php echo esc_url( site_url( '/student-affairs/achievement' ) ); ?>" class="menu-link menu-link--dropdown">
                    Kemahasiswaan
                    <i class="ph ph-caret-down caret-icon"></i>
                </a>
                <div class="mega-dropdown">
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Informasi Umum</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/tata-tertib' ) ); ?>">Tata Tertib</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/magang' ) ); ?>">Praktik Kerja Lapangan / Magang</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Pengembangan Mahasiswa</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/organisasi-kemahasiswaan' ) ); ?>"<?php echo ($nav_is_active(['organisasi-kemahasiswaan', 'ormawa']) || is_post_type_archive('ormawa') || is_singular('ormawa')) ? ' class="text-orange"' : ''; ?>>Organisasi Kemahasiswaan</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/achievement' ) ); ?>"<?php echo $is_achievement_active ? ' class="text-orange"' : ''; ?>>Prestasi</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/pengembangan-karir' ) ); ?>">Pengembangan Karir</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col">
                        <span class="mega-dropdown__label">Dukungan Mahasiswa</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/beasiswa' ) ); ?>">Beasiswa</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/student-affairs/galeri-kemahasiswaan' ) ); ?>">Galeri Kemahasiswaan</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Penelitian -->
            <li class="menu-item menu-item-has-dropdown<?php echo $current_page === 'penelitian' ? ' current-menu-item' : ''; ?>">
                <a href="#" class="menu-link menu-link--dropdown" onclick="return false;">
                    Penelitian
                    <i class="ph ph-caret-down caret-icon"></i>
                </a>
                <div class="mega-dropdown mega-dropdown--wide">
                    <div class="mega-dropdown__col mega-dropdown__col--narrow">
                        <span class="mega-dropdown__label">Kegiatan Utama</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/research/penelitian' ) ); ?>">Penelitian</a></li>
                            <li><a href="<?php echo esc_url( site_url( '/research/pengabdian' ) ); ?>">Pengabdian</a></li>
                        </ul>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col mega-dropdown__col--wide mega-dropdown__col--labs">
                        <span class="mega-dropdown__label">Laboratorium Riset</span>
                        <div class="mega-dropdown__subcols">
                            <?php
                            $all_labs = webjti_get_laboratories();
                            $total_labs = count($all_labs);
                            $half = ceil($total_labs / 2);
                            $labs_col1 = array_slice($all_labs, 0, $half);
                            $labs_col2 = array_slice($all_labs, $half);
                            ?>
                            <ul class="mega-dropdown__list">
                                <?php foreach ($labs_col1 as $lab) : ?>
                                    <li><a href="<?php echo esc_url($lab['permalink']); ?>"><?php echo esc_html($lab['title']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (!empty($labs_col2)) : ?>
                            <ul class="mega-dropdown__list">
                                <?php foreach ($labs_col2 as $lab) : ?>
                                    <li><a href="<?php echo esc_url($lab['permalink']); ?>"><?php echo esc_html($lab['title']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mega-dropdown__divider"></div>
                    <div class="mega-dropdown__col mega-dropdown__col--narrow">
                        <span class="mega-dropdown__label">Dukungan Mahasiswa</span>
                        <ul class="mega-dropdown__list">
                            <li><a href="<?php echo esc_url( site_url( '/research/jurnal' ) ); ?>">Jurnal</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Informasi -->
            <li class="menu-item<?php echo $current_page === 'information' ? ' current-menu-item active' : ''; ?>">
                <?php
                $info_page_id = get_theme_mod('jti_page_informasi');
                $info_page_link = $info_page_id ? get_permalink($info_page_id) : site_url('/information');
                ?>
                <a href="<?php echo esc_url( $info_page_link ); ?>" class="menu-link">
                    Informasi
                </a>
            </li>

            <!-- Mobile Contact Info -->
            <li class="mobile-contact-info">
                <?php
                $email = get_theme_mod('jti_topbar_email', 'jti@polinema.ac.id');
                $phone_text = get_theme_mod('jti_topbar_phone', '(0341) 404424');
                $phone_link = get_theme_mod('jti_topbar_phone_link', '+(0341) 404424');
                ?>
                <?php if ($email) : ?>
                    <span class="top-header-item"><i class="ph ph-envelope"></i><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
                <?php endif; ?>
                <?php if ($phone_text) : ?>
                    <span class="top-header-item"><i class="ph ph-phone"></i><a href="tel:<?php echo esc_attr($phone_link); ?>"><?php echo esc_html($phone_text); ?></a></span>
                <?php endif; ?>
            </li>
        </ul>
        <?php
    }
}

// Filter to change 'menu-item-has-children' to 'menu-item-has-dropdown' for CSS match
$jti_nav_class_filter = function($classes, $item, $args) {
    if ($args->theme_location === 'main_menu') {
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'menu-item-has-dropdown';
        }
        $classes[] = 'menu-item';

        // Swap active state on default_info fallback pages (which technically route to home page '/')
        if (isset($_GET['default_info']) && !empty($_GET['default_info'])) {
            $item_url = untrailingslashit($item->url);
            $home_url = untrailingslashit(home_url());
            $site_url = untrailingslashit(site_url());
            
            // Remove active classes from Beranda (Home)
            if ($item_url === $home_url || $item_url === $site_url || $item->title === 'Beranda') {
                $classes = array_filter($classes, function($cls) {
                    return strpos($cls, 'current') === false && strpos($cls, 'active') === false;
                });
            }
            // Add active classes to Informasi
            if (strpos($item->url, '/information') !== false || $item->title === 'Informasi') {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
            }
        }

        // Swap active state on default_lecturer fallback pages, singular lecturer detail pages, archives, page templates, or matching URLs
        $is_lecturer_page = (isset($_GET['default_lecturer']) && !empty($_GET['default_lecturer'])) || 
                            is_singular('lecturer') || 
                            is_post_type_archive('lecturer') || 
                            is_page_template('templates/pages/lecturer-page.php') ||
                            (isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], '/lecturer') !== false || strpos($_SERVER['REQUEST_URI'], '/tenaga-pengajar') !== false));
        
        if ($is_lecturer_page) {
            $item_url = untrailingslashit($item->url);
            $home_url = untrailingslashit(home_url());
            $site_url = untrailingslashit(site_url());
            $item_title_clean = str_replace([' ', '-'], '', strtolower($item->title));
            
            // Remove active classes from Beranda (Home)
            if ($item_url === $home_url || $item_url === $site_url || $item_title_clean === 'beranda') {
                $classes = array_filter($classes, function($cls) {
                    return strpos($cls, 'current') === false && strpos($cls, 'active') === false;
                });
            }
            // Add active classes to Tentang Kami (about-us)
            if (
                strpos($item->url, '/about-us') !== false || 
                strpos($item->url, '/tentang-kami') !== false || 
                $item_title_clean === 'tentangkami' ||
                $item_title_clean === 'aboutus'
            ) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
                $classes[] = 'current-menu-ancestor';
            }
            // Add active classes to Tenaga Pengajar (lecturer)
            if (
                strpos($item->url, '/lecturer') !== false || 
                strpos($item->url, '/tenaga-pengajar') !== false || 
                $item_title_clean === 'tenagapengajar' ||
                $item_title_clean === 'lecturer'
            ) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
            }
        }

        // Swap active state on default_achievement / prestasi pages
        $is_achievement_page = (isset($_GET['default_achievement']) && !empty($_GET['default_achievement'])) || 
                               is_singular('achievement') || 
                               is_post_type_archive('achievement') || 
                               is_page_template('templates/pages/achievement-page.php') ||
                               is_singular('ormawa') || 
                               is_post_type_archive('ormawa') ||
                               (isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], '/achievement') !== false || strpos($_SERVER['REQUEST_URI'], '/prestasi') !== false || strpos($_SERVER['REQUEST_URI'], '/organisasi-kemahasiswaan') !== false));
        
        if ($is_achievement_page) {
            $item_url = untrailingslashit($item->url);
            $home_url = untrailingslashit(home_url());
            $site_url = untrailingslashit(site_url());
            $item_title_clean = str_replace([' ', '-'], '', strtolower($item->title));
            
            // Remove active classes from Beranda (Home)
            if ($item_url === $home_url || $item_url === $site_url || $item_title_clean === 'beranda') {
                $classes = array_filter($classes, function($cls) {
                    return strpos($cls, 'current') === false && strpos($cls, 'active') === false;
                });
            }
            // Add active classes to Kemahasiswaan
            if (
                strpos($item->url, '/student-affairs') !== false || 
                strpos($item->url, '/kemahasiswaan') !== false || 
                $item_title_clean === 'kemahasiswaan' ||
                $item_title_clean === 'studentaffairs'
            ) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
                $classes[] = 'current-menu-ancestor';
            }
            // Add active classes to Prestasi
            if (
                strpos($item->url, '/achievement') !== false || 
                strpos($item->url, '/prestasi') !== false || 
                $item_title_clean === 'prestasi' ||
                $item_title_clean === 'achievement'
            ) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
            }
        }

        // Swap active state on Program Khusus pages (/program-khusus/* or /*)
        $uri_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
        $current_bare = basename($uri_path);
        $pk_slugs = ['kelas-internasional', 'double-degree', 'alih-jenjang', 'rpl'];

        $is_pk_page = is_singular('program_khusus') || 
                      strpos($uri_path, 'program-khusus') !== false || 
                      strpos($uri_path, 'program_khusus') !== false || 
                      in_array($current_bare, $pk_slugs, true) ||
                      is_page_template([
                          'templates/pages/akademik/kelas-internasional-page.php',
                          'templates/pages/akademik/double-degree-page.php',
                          'templates/pages/akademik/alih-jenjang-page.php',
                          'templates/pages/akademik/rpl-page.php',
                      ]);

        if ($is_pk_page) {
            $item_url = untrailingslashit($item->url);
            $home_url = untrailingslashit(home_url());
            $site_url = untrailingslashit(site_url());
            $item_title_clean = str_replace([' ', '-'], '', strtolower($item->title));

            // Remove active classes from Beranda (Home)
            if ($item_url === $home_url || $item_url === $site_url || $item_title_clean === 'beranda') {
                $classes = array_filter($classes, function($cls) {
                    return strpos($cls, 'current') === false && strpos($cls, 'active') === false;
                });
            }

            // Add active classes to Akademik
            if (
                strpos($item->url, '/akademik') !== false || 
                $item_title_clean === 'akademik'
            ) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
                $classes[] = 'current-menu-ancestor';
            }

            // Add active classes to specific Program Khusus link
            $item_bare = basename(trim(parse_url($item->url ?? '', PHP_URL_PATH), '/'));
            if ($current_bare && ($current_bare === $item_bare || strpos($item_url, $current_bare) !== false)) {
                $classes[] = 'current-menu-item';
                $classes[] = 'active';
            }
        }
    }
    return $classes;
};


// Filter to add 'menu-link' class to anchor tags
$jti_nav_link_filter = function($atts, $item, $args) {
    if ($args->theme_location === 'main_menu') {
        if (isset($atts['class'])) {
            $atts['class'] .= ' menu-link';
        } else {
            $atts['class'] = 'menu-link';
        }
        if (in_array('menu-item-has-children', $item->classes) || in_array('menu-item-has-dropdown', $item->classes)) {
            $atts['class'] .= ' menu-link--dropdown';
        }
    }
    return $atts;
};

add_filter('nav_menu_css_class', $jti_nav_class_filter, 10, 3);
add_filter('nav_menu_link_attributes', $jti_nav_link_filter, 10, 3);

$jti_nav_contact_append = function($items, $args) {
    if ($args->theme_location === 'main_menu') {
        $email = get_theme_mod('jti_topbar_email', 'jti@polinema.ac.id');
        $phone_text = get_theme_mod('jti_topbar_phone', '(0341) 404424');
        $phone_link = get_theme_mod('jti_topbar_phone_link', '+(0341) 404424');
        
        $contact_html = '<li class="mobile-contact-info">';
        if ($email) {
            $contact_html .= '<span class="top-header-item"><i class="ph ph-envelope"></i><a href="mailto:'.esc_attr($email).'">'.esc_html($email).'</a></span>';
        }
        if ($phone_text) {
            $contact_html .= '<span class="top-header-item"><i class="ph ph-phone"></i><a href="tel:'.esc_attr($phone_link).'">'.esc_html($phone_text).'</a></span>';
        }
        $contact_html .= '</li>';
        
        $items .= $contact_html;
    }
    return $items;
};
add_filter('wp_nav_menu_items', $jti_nav_contact_append, 10, 2);

$jti_nav_header_prepend = function($items, $args) {
    if ($args->theme_location === 'main_menu') {
        $header_html = '<li class="mobile-menu-header">';
        $header_html .= '<span class="mobile-menu-title">Menu</span>';
        $header_html .= '<button type="button" class="mobile-menu-close" aria-label="Tutup Menu"><i class="ph ph-x"></i></button>';
        $header_html .= '</li>';
        $items = $header_html . $items;
    }
    return $items;
};
add_filter('wp_nav_menu_items', $jti_nav_header_prepend, 10, 2);

?>

<div class="navigation-menu-wrapper" style="flex: 1; display: flex; justify-content: center; height: 100%;">
    <?php
    $menu_location = 'main_menu';
    $menu_locations = get_nav_menu_locations();
    $menu_id = $menu_locations[$menu_location] ?? 0;
    $menu_items = $menu_id ? wp_get_nav_menu_items($menu_id) : [];

    if (!empty($menu_items)) {
        wp_nav_menu([
            'theme_location'  => $menu_location,
            'menu_id'         => 'primary-menu',
            'container'       => false,
            'menu_class'      => 'primary-menu',
            'fallback_cb'     => 'webjti_default_primary_menu_fallback',
            'depth'           => 4, // Support for mega dropdowns (up to 4 levels for groups)
            'walker'          => new WebJTI_Mega_Menu_Walker(),
        ]);
    } else {
        webjti_default_primary_menu_fallback();
    }
    ?>
</div>

<?php
// Remove filters after output so they don't affect other menus (like footer menu)
remove_filter('nav_menu_css_class', $jti_nav_class_filter, 10);
remove_filter('nav_menu_link_attributes', $jti_nav_link_filter, 10);
remove_filter('wp_nav_menu_items', $jti_nav_contact_append, 10);
remove_filter('wp_nav_menu_items', $jti_nav_header_prepend, 10);
?>
