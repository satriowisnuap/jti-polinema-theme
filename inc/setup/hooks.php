<?php

/* ========================================
   AUTO-ICON: ATURAN AKADEMIK
   Meng-generate nama icon Phosphor secara
   otomatis berdasarkan kata kunci dari judul
   post CPT 'aturan_akademik'.
======================================== */

/**
 * Mengembalikan nama icon Phosphor (tanpa prefix "ph-")
 * berdasarkan kata kunci yang ditemukan di judul atau konten.
 *
 * @param string|int $title_or_id  Judul post atau post ID.
 * @param string     $content      Konten opsional untuk pencocokan lebih akurat.
 * @return string  Nama icon Phosphor tanpa prefix "ph-".
 */
if (!function_exists('webjti_get_aturan_akademik_auto_icon')) {
    function webjti_get_aturan_akademik_auto_icon($title_or_id = '', $content = '') {

        // Ambil judul dari post ID jika integer dikirim
        if (is_numeric($title_or_id)) {
            $title = strtolower(get_the_title((int) $title_or_id));
        } else {
            $title = strtolower((string) $title_or_id);
        }

        $haystack = $title . ' ' . strtolower($content);

        // ─── Tabel keyword → icon ────────────────────────────────────────
        $map = [
            // Pembelajaran & Proses
            'pembelajaran'       => 'chalkboard-teacher',
            'perkuliahan'        => 'chalkboard-teacher',
            'kuliah'             => 'chalkboard-teacher',
            'proses'             => 'arrow-circle-right',
            'kegiatan'           => 'list-checks',

            // Jadwal & Waktu
            'jadwal'             => 'calendar-blank',
            'kalender'           => 'calendar-blank',
            'waktu'              => 'clock',
            'semester'           => 'calendar-dots',
            'periode'            => 'calendar-dots',

            // Kehadiran & Absensi
            'kehadiran'          => 'user-check',
            'ketidakhadiran'     => 'user-minus',
            'absensi'            => 'clipboard-text',
            'absen'              => 'clipboard-text',
            'hadir'              => 'user-check',

            // Evaluasi & Ujian
            'evaluasi'           => 'clipboard-text',
            'ujian'              => 'exam',
            'uts'                => 'note-pencil',
            'uas'                => 'note-pencil',
            'kuis'               => 'question',
            'tugas'              => 'pencil-line',
            'praktikum'          => 'flask',
            'laporan'            => 'file-text',

            // Penilaian & Nilai
            'penilaian'          => 'star',
            'nilai'              => 'star',
            'indeks'             => 'chart-bar',
            'ipk'                => 'chart-bar',
            'ip '                => 'chart-bar',
            'skala'              => 'list-numbers',
            'grade'              => 'star',

            // Kelulusan & Predikat
            'kelulusan'          => 'graduation-cap',
            'lulus'              => 'graduation-cap',
            'yudisium'           => 'graduation-cap',
            'wisuda'             => 'graduation-cap',
            'predikat'           => 'trophy',
            'cumlaude'           => 'trophy',
            'cum laude'          => 'trophy',
            'pujian'             => 'trophy',
            'memuaskan'          => 'medal',

            // Status & Administrasi
            'status'             => 'identification-card',
            'aktif'              => 'user-circle-check',
            'cuti'               => 'pause-circle',
            'non-aktif'          => 'user-circle-minus',
            'nonaktif'           => 'user-circle-minus',
            'registrasi'         => 'clipboard',
            'daftar'             => 'list-bullets',
            'administrasi'       => 'folder-open',
            'dokumen'            => 'file',

            // SKS & Kurikulum
            'sks'                => 'books',
            'kurikulum'          => 'books',
            'mata kuliah'        => 'book-open',
            'matakuliah'         => 'book-open',
            'kompetensi'         => 'certificate',

            // Penelitian & Tugas Akhir
            'penelitian'         => 'flask',
            'skripsi'            => 'file-doc',
            'tesis'              => 'file-doc',
            'tugas akhir'        => 'file-doc',
            'ta '                => 'file-doc',
            'pkl'                => 'briefcase',
            'magang'             => 'briefcase',
            'kerja praktik'      => 'briefcase',
            'kerja lapangan'     => 'briefcase',

            // Tata Tertib & Pelanggaran
            'pelanggaran'        => 'warning',
            'sanksi'             => 'prohibit',
            'disiplin'           => 'shield-check',
            'tata tertib'        => 'shield-check',
            'peraturan'          => 'scales',
            'kebijakan'          => 'scales',
            'larangan'           => 'prohibit',

            // Organisasi & Kemahasiswaan
            'mahasiswa'          => 'users',
            'kemahasiswaan'      => 'users-three',
            'organisasi'         => 'users-three',
            'ormawa'             => 'users-three',
            'beasiswa'           => 'currency-circle-dollar',

            // Hak & Kewajiban
            'hak'                => 'hand',
            'kewajiban'          => 'check-circle',
            'tanggung jawab'     => 'check-circle',

            // Fasilitas & Layanan
            'fasilitas'          => 'buildings',
            'layanan'            => 'headset',
            'laboratorium'       => 'flask',
            'perpustakaan'       => 'books',
        ];

        foreach ($map as $keyword => $icon) {
            if (str_contains($haystack, $keyword)) {
                return $icon;
            }
        }

        // Fallback default
        return 'book-open';
    }
}

/* ========================================
   AUTO-SAVE ICON: ATURAN AKADEMIK
   Setiap kali post CPT 'aturan_akademik'
   disimpan, icon di-generate otomatis dari
   judul dan disimpan ke post meta 'aa_icon'.
   Field tidak perlu diisi manual oleh admin.
======================================== */
add_action('acf/save_post', function($post_id) {

    if (get_post_type($post_id) !== 'aturan_akademik') {
        return;
    }

    $title   = get_the_title($post_id);
    $content = get_field('aa_description', $post_id) ?: '';

    // Strip HTML tags dari konten WYSIWYG
    $content_plain = wp_strip_all_tags($content);

    // Generate icon dari judul + konten
    $icon = webjti_get_aturan_akademik_auto_icon($title, $content_plain);

    // Simpan ke post meta (selalu di-overwrite otomatis)
    update_post_meta($post_id, 'aa_icon', $icon);

}, 20);

/* ========================================
   FEATURED NEWS — SINGLE SELECTION
   Otomatis menonaktifkan featured_news
   di post lain saat satu post disimpan
   dengan featured_news = 1 (true)
======================================== */

add_action('acf/save_post', function($post_id) {

  // Hanya berlaku untuk post type 'information'
  if (get_post_type($post_id) !== 'information') {
    return;
  }

  // Cek apakah post ini di-set sebagai featured
  $is_featured = get_field('featured_news', $post_id);

  if (!$is_featured) {
    return;
  }

  // Cari semua post information lain yang juga featured
  $others = new WP_Query([
    'post_type'      => 'information',
    'posts_per_page' => -1,
    'post_status'    => 'any',
    'post__not_in'   => [$post_id],
    'meta_query'     => [
      [
        'key'   => 'featured_news',
        'value' => '1',
      ],
    ],
  ]);

  if ($others->have_posts()) {
    while ($others->have_posts()) {
      $others->the_post();
      // Nonaktifkan featured_news di post lain
      update_field('featured_news', false, get_the_ID());
    }
    wp_reset_postdata();
  }

}, 20);

/* ========================================
   DEFAULT INFO INTERCEPTOR & SMART SEARCH REDIRECT
   Mengalihkan pencarian dengan 1 hasil langsung ke halaman terkait,
   serta mengadopsi rute fallback simulasi kustom.
======================================== */

add_action('template_redirect', function() {

  // Let real Study Program CPT slugs use single-study_program.php.
  // This prevents legacy simulated routes from shadowing matching CPT posts.
  $request_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  $request_slug = basename($request_path);
  if ($request_slug && get_page_by_path($request_slug, OBJECT, 'study_program')) {
    return;
  }

  // 1. Automatic Page / Fallback Routing for Akademik Pages (HIGHEST PRIORITY)
  global $wp;
  
  $possible_paths = [];
  if (!empty($wp->request)) {
    $possible_paths[] = trim((string) $wp->request, '/');
  }
  $server_path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  if (!empty($server_path)) {
    $possible_paths[] = $server_path;
  }

  $akademik_routes = [
    'd2-piranti-lunak'                => '/templates/pages/akademik/study-program-page.php',
    'd3-mi-kediri'                    => '/templates/pages/akademik/study-program-page.php',
    'd3-mi-lumajang'                  => '/templates/pages/akademik/study-program-page.php',
    'd4-teknik-informatika'           => '/templates/pages/akademik/study-program-page.php',
    'sarjana-terapan-teknik-informatika' => '/templates/pages/akademik/study-program-page.php',
    'd4-sistem-informasi-bisnis'      => '/templates/pages/akademik/study-program-page.php',
    'sarjana-terapan-sistem-informasi-bisnis' => '/templates/pages/akademik/study-program-page.php',
    's2-rekayasa-teknologi-informasi' => '/templates/pages/akademik/study-program-page.php',
    'magister-terapan-rekayasa-teknologi-informasi' => '/templates/pages/akademik/study-program-page.php',
    'kelas-internasional'             => '/templates/pages/akademik/kelas-internasional-page.php',
    'double-degree'                   => '/templates/pages/akademik/double-degree-page.php',
    'alih-jenjang'                    => '/templates/pages/akademik/alih-jenjang-page.php',
    'rpl'                             => '/templates/pages/akademik/rpl-page.php',
    'aturan-akademik'                 => '/templates/pages/akademik/aturan-akademik-page.php',
    'kalender-akademik'               => '/templates/pages/akademik/kalender-akademik-page.php',
    'kalender-akademik-2'             => '/templates/pages/akademik/kalender-akademik-page.php',
    'student-affairs/magang'          => '/templates/pages/magang-page.php',
    'student-affairs/tata-tertib'     => '/templates/pages/tata-tertib-page.php',
    'praktik-kerja-lapangan-magang'   => '/templates/pages/magang-page.php',
    'pkl-magang'                      => '/templates/pages/magang-page.php',
    'pkl'                             => '/templates/pages/magang-page.php',
    'magang'                          => '/templates/pages/magang-page.php',
    'tata-tertib'                     => '/templates/pages/tata-tertib-page.php',
    'jurnal'                          => '/templates/pages/jurnal-page.php',
    'research/jurnal'                 => '/templates/pages/jurnal-page.php',
    'penelitian/jurnal'               => '/templates/pages/jurnal-page.php',
    'research/penelitian'             => '/templates/pages/penelitian-page.php',
    'penelitian'                      => '/templates/pages/penelitian-page.php',   // backward compat
    'penelitian/halaman-penelitian'   => '/templates/pages/penelitian-page.php',   // backward compat
    'research/pengabdian'             => '/templates/pages/dedication-page.php',
    'pengabdian'                      => '/templates/pages/dedication-page.php',   // backward compat
  ];

  // Support both bare akademik slugs and /akademik/ /study_program/ /program-khusus/ prefixed routes.
  $prefixed_akademik_routes = [];
  foreach ($akademik_routes as $route => $template_path) {
    if (strpos($route, 'akademik/') !== 0) {
      $prefixed_akademik_routes['akademik/' . $route] = $template_path;
      $prefixed_akademik_routes['study_program/' . $route] = $template_path;
      $prefixed_akademik_routes['program-studi/' . $route] = $template_path;
      $prefixed_akademik_routes['program-khusus/' . $route] = $template_path;
      $prefixed_akademik_routes['program_khusus/' . $route] = $template_path;
    }
  }
  $akademik_routes += $prefixed_akademik_routes;

  $matched_template = null;
  foreach ($possible_paths as $p) {
    if (strpos($p, 'index.php/') === 0) {
      $p = substr($p, 10);
    }
    $p = trim($p, '/');
    $bare = basename($p);

    if (isset($akademik_routes[$p])) {
      $matched_template = $akademik_routes[$p];
      break;
    } elseif (isset($akademik_routes[$bare])) {
      $matched_template = $akademik_routes[$bare];
      break;
    }
  }

  if ($matched_template) {
    $template_file = get_template_directory() . $matched_template;
    if (file_exists($template_file)) {
      status_header(200);
      include $template_file;
      exit;
    }
  }

  // 2. Redirect child lecturer CPTs (education, certification, course) to parent lecturer
  if (is_singular(['lecturer_education', 'lecturer_certification', 'lecturer_course', 'pendidikan_dosen', 'sertifikasi_dosen', 'matkul_dosen', 'lecturer_certificati'])) {
    $lecturer = get_field('lecturer', get_the_ID());
    $lecturer_id = null;
    if (is_array($lecturer)) {
      $lecturer_id = !empty($lecturer[0]) ? (is_object($lecturer[0]) ? $lecturer[0]->ID : $lecturer[0]) : null;
    } elseif (is_object($lecturer)) {
      $lecturer_id = $lecturer->ID;
    } else {
      $lecturer_id = $lecturer;
    }

    if ($lecturer_id && get_post_status($lecturer_id) === 'publish') {
      wp_safe_redirect(get_permalink($lecturer_id));
      exit;
    } else {
      wp_safe_redirect(home_url('/lecturer'));
      exit;
    }
  }

  // 3. Smart Search Redirect
  if ( is_search() ) {
    global $wp_query;
    if ( isset( $wp_query->posts ) && count( $wp_query->posts ) === 1 ) {
      $single_post = $wp_query->posts[0];
      wp_safe_redirect( get_permalink( $single_post->ID ) );
      exit;
    }
  }

  if (isset($_GET['default_info']) && !empty($_GET['default_info'])) {
    include get_template_directory() . '/templates/singles/single-information.php';
    exit;
  }

  if (isset($_GET['default_lecturer']) && !empty($_GET['default_lecturer'])) {
    include get_template_directory() . '/templates/singles/single-lecturer.php';
    exit;
  }

  if (isset($_GET['default_achievement']) && !empty($_GET['default_achievement'])) {
    include get_template_directory() . '/templates/singles/single-achievement.php';
    exit;
  }

}, 0);

/* ========================================
   PREVENT CANONICAL REDIRECT FOR AKADEMIK & STUDY PROGRAM ROUTES
   ======================================== */
add_filter('redirect_canonical', function($redirect_url, $requested_url) {
  global $wp;
  $path = isset($wp->request) && !empty($wp->request) ? trim((string)$wp->request, '/') : trim((string)parse_url($requested_url, PHP_URL_PATH), '/');
  if (strpos($path, 'index.php/') === 0) {
    $path = substr($path, 10);
  }
  $bare = basename($path);

  $akademik_slugs = [
    'd2-piranti-lunak',
    'd3-mi-kediri',
    'd3-mi-lumajang',
    'd4-teknik-informatika',
    'sarjana-terapan-teknik-informatika',
    'd4-sistem-informasi-bisnis',
    'sarjana-terapan-sistem-informasi-bisnis',
    's2-rekayasa-teknologi-informasi',
    'magister-terapan-rekayasa-teknologi-informasi',
    'kelas-internasional',
    'double-degree',
    'alih-jenjang',
    'rpl',
    'aturan-akademik',
    'kalender-akademik',
    'kalender-akademik-2',
    'magang',
    'tata-tertib',
    'jurnal',
    'penelitian',
    'pengabdian',
    'dedication',
  ];

  if (in_array($bare, $akademik_slugs, true) || in_array($path, $akademik_slugs, true)) {
    return false;
  }

  return $redirect_url;
}, 10, 2);

/* ========================================
   TEMPLATE INCLUDE FALLBACK FOR AKADEMIK ROUTES
   ======================================== */
add_filter('template_include', function($template) {
  global $wp, $wp_query;

  $possible_paths = [];
  if (!empty($wp->request)) {
    $possible_paths[] = trim((string) $wp->request, '/');
  }
  $server_path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  if (!empty($server_path)) {
    $possible_paths[] = $server_path;
  }

  $akademik_routes = [
    'd2-piranti-lunak'                => '/templates/pages/akademik/study-program-page.php',
    'd3-mi-kediri'                    => '/templates/pages/akademik/study-program-page.php',
    'd3-mi-lumajang'                  => '/templates/pages/akademik/study-program-page.php',
    'd4-teknik-informatika'           => '/templates/pages/akademik/study-program-page.php',
    'sarjana-terapan-teknik-informatika' => '/templates/pages/akademik/study-program-page.php',
    'd4-sistem-informasi-bisnis'      => '/templates/pages/akademik/study-program-page.php',
    'sarjana-terapan-sistem-informasi-bisnis' => '/templates/pages/akademik/study-program-page.php',
    's2-rekayasa-teknologi-informasi' => '/templates/pages/akademik/study-program-page.php',
    'magister-terapan-rekayasa-teknologi-informasi' => '/templates/pages/akademik/study-program-page.php',
    'kelas-internasional'             => '/templates/pages/akademik/kelas-internasional-page.php',
    'double-degree'                   => '/templates/pages/akademik/double-degree-page.php',
    'alih-jenjang'                    => '/templates/pages/akademik/alih-jenjang-page.php',
    'rpl'                             => '/templates/pages/akademik/rpl-page.php',
    'aturan-akademik'                 => '/templates/pages/akademik/aturan-akademik-page.php',
    'kalender-akademik'               => '/templates/pages/akademik/kalender-akademik-page.php',
    'kalender-akademik-2'             => '/templates/pages/akademik/kalender-akademik-page.php',
    'student-affairs/magang'          => '/templates/pages/magang-page.php',
    'student-affairs/tata-tertib'     => '/templates/pages/tata-tertib-page.php',
    'praktik-kerja-lapangan-magang'   => '/templates/pages/magang-page.php',
    'pkl-magang'                      => '/templates/pages/magang-page.php',
    'pkl'                             => '/templates/pages/magang-page.php',
    'magang'                          => '/templates/pages/magang-page.php',
    'tata-tertib'                     => '/templates/pages/tata-tertib-page.php',
    'jurnal'                          => '/templates/pages/jurnal-page.php',
    'research/jurnal'                 => '/templates/pages/jurnal-page.php',
    'penelitian/jurnal'               => '/templates/pages/jurnal-page.php',
    'research/penelitian'             => '/templates/pages/penelitian-page.php',
    'penelitian'                      => '/templates/pages/penelitian-page.php',
    'research/pengabdian'             => '/templates/pages/dedication-page.php',
    'pengabdian'                      => '/templates/pages/dedication-page.php',
  ];

  foreach ($possible_paths as $p) {
    if (strpos($p, 'index.php/') === 0) {
      $p = substr($p, 10);
    }
    $p = trim($p, '/');
    $bare = basename($p);

    if (isset($akademik_routes[$p])) {
      $file = get_template_directory() . $akademik_routes[$p];
      if (file_exists($file)) {
        if (isset($wp_query)) {
          $wp_query->is_404 = false;
        }
        status_header(200);
        return $file;
      }
    } elseif (isset($akademik_routes[$bare])) {
      $file = get_template_directory() . $akademik_routes[$bare];
      if (file_exists($file)) {
        if (isset($wp_query)) {
          $wp_query->is_404 = false;
        }
        status_header(200);
        return $file;
      }
    }
  }

  return $template;
}, 99);

/* ========================================
   SET CORRECT BROWSER TAB TITLE FOR SIMULATED ROUTES
   ======================================== */
add_filter('document_title_parts', function($parts) {
  global $wp;
  $request_path = isset($wp->request) ? $wp->request : trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  
  if (strpos($request_path, 'index.php/') === 0) {
      $request_path = substr($request_path, 10);
  }
  
  $route_titles = [
    'd2-piranti-lunak'                => 'D2 Piranti Lunak',
    'd3-mi-kediri'                    => 'D3 MI Kediri',
    'd3-mi-lumajang'                  => 'D3 MI Lumajang',
    'd4-teknik-informatika'           => 'D4 Teknik Informatika',
    'sarjana-terapan-teknik-informatika' => 'Sarjana Terapan Teknik Informatika',
    'd4-sistem-informasi-bisnis'      => 'D4 Sistem Informasi Bisnis',
    'sarjana-terapan-sistem-informasi-bisnis' => 'Sarjana Terapan Sistem Informasi Bisnis',
    's2-rekayasa-teknologi-informasi' => 'S2 Rekayasa Teknologi Informasi',
    'magister-terapan-rekayasa-teknologi-informasi' => 'Magister Terapan Rekayasa Teknologi Informasi',
    'kelas-internasional'             => 'Kelas Internasional',
    'double-degree'                   => 'Double Degree',
    'alih-jenjang'                    => 'Alih Jenjang',
    'rpl'                             => 'RPL',
    'aturan-akademik'                 => 'Aturan Akademik',
    'kalender-akademik'               => 'Kalender Akademik',
    'student-affairs/magang'          => 'Magang / Praktik Kerja Lapangan',
    'student-affairs/tata-tertib'     => 'Tata Tertib',
    'praktik-kerja-lapangan-magang'   => 'Magang / Praktik Kerja Lapangan',
    'pkl-magang'                      => 'Magang / Praktik Kerja Lapangan',
    'pkl'                             => 'Magang / Praktik Kerja Lapangan',
    'magang'                          => 'Magang / Praktik Kerja Lapangan',
    'tata-tertib'                     => 'Tata Tertib',
    'jurnal'                          => 'Jurnal',
    'research/jurnal'                 => 'Jurnal',
    'penelitian/jurnal'               => 'Jurnal',
    'research/penelitian'             => 'Penelitian',
    'penelitian'                      => 'Penelitian',
    'penelitian/halaman-penelitian'   => 'Penelitian',
    'research/pengabdian'             => 'Pengabdian',
    'pengabdian'                      => 'Pengabdian',
  ];

  if (isset($route_titles[$request_path])) {
    $parts['title'] = $route_titles[$request_path];
  }

  return $parts;
});

/* ========================================
   INCLUDE CUSTOM POST TYPES IN SEARCH QUERY
   Memastikan kueri pencarian utama menggeledah data CPT kustom
======================================== */
add_action( 'pre_get_posts', function( $query ) {
  if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
    // Only search in these specific post types
    $query->set( 'post_type', [ 'post', 'page', 'information', 'lecturer', 'staff', 'achievement', 'ormawa' ] );
  }
});

/* ========================================
   AJAX FILTER INFORMASI
======================================== */

add_action('wp_ajax_jti_filter_informasi', 'jti_ajax_filter_informasi');
add_action('wp_ajax_nopriv_jti_filter_informasi', 'jti_ajax_filter_informasi');

function jti_ajax_filter_informasi() {
  $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'all';
  $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
  $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
  
  $posts_per_page = 6;
  $data = webjti_get_filtered_information($type, $search, $paged, $posts_per_page);
  
  ob_start();
  if (!empty($data['posts'])) {
    foreach ($data['posts'] as $item) {
      $info = [
        'url'          => $item['permalink'] ?? $item['url'] ?? '',
        'image'        => $item['image'] ?? '',
        'title'        => $item['title'] ?? '',
        'category'     => $item['category'] ?? $item['tag'] ?? '',
        'date'         => $item['date'] ?? '',
        'reading_time' => $item['reading_time'] ?? '',
        'excerpt'      => $item['excerpt'] ?? '',
      ];
      get_template_part(
        'template-parts/cards/information-card',
        null,
        [
          'info' => $info,
        ]
      );
    }
  } else {
    ?>
    <div class="information-no-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 24px; width: 100%;">
      <i class="ph ph-newspaper" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;"></i>
      <h3 style="color: var(--neutral-09); margin-bottom: 8px; font-weight: 500; font-size: 20px;">Tidak Ada Informasi</h3>
      <p style="color: var(--neutral-06); font-size: 16px;">Maaf, tidak ada berita, pengumuman, atau agenda yang sesuai dengan kriteria filter atau pencarian Anda.</p>
    </div>
    <?php
  }
  $content_html = ob_get_clean();
  
  $pagination_html = '';
  if ($data['max_pages'] > 1) {
    $pagination_links = paginate_links([
      'total'     => $data['max_pages'],
      'current'   => $paged,
      'prev_next' => true,
      'prev_text' => '<i class="ph ph-arrow-left"></i> Sebelumnya',
      'next_text' => 'Selanjutnya <i class="ph ph-arrow-right"></i>',
      'type'      => 'plain',
    ]);
    if ($pagination_links) {
      $pagination_html = '<div class="pagination-container">' . $pagination_links . '</div>';
    }
  }
  
  wp_send_json_success([
    'content'    => $content_html,
    'pagination' => $pagination_html,
  ]);
}

/* ========================================
   SINGLE TEMPLATE ROUTING FILTER
   Automatically routes templates in templates/singles/
======================================== */
add_filter('single_template', function($template) {
  global $post;
  if ($post) {
    $post_type = $post->post_type;
    $custom_template = get_template_directory() . '/templates/singles/single-' . $post_type . '.php';
    if (file_exists($custom_template)) {
      return $custom_template;
    }
    // Fallback for prestasi CPT mapped to single-achievement.php
    if ($post_type === 'achievement') {
      $achievement_template = get_template_directory() . '/templates/singles/single-achievement.php';
      if (file_exists($achievement_template)) {
        return $achievement_template;
      }
    }
  }
  return $template;
});

/* ========================================
   ORMAWA ARCHIVE — BATAS 6 CARD PER HALAMAN
   Memastikan halaman organisasi kemahasiswaan
   hanya menampilkan 6 card per halaman dan
   pagination otomatis aktif.
======================================== */
add_action('pre_get_posts', function($query) {
  if (
    !is_admin() &&
    $query->is_main_query() &&
    $query->is_post_type_archive('ormawa')
  ) {
    $query->set('posts_per_page', 6);
    $query->set('orderby', 'menu_order');
    $query->set('order', 'ASC');
  }
});



