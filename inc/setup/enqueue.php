<?php

/* ========================================
   ENQUEUE STYLES & SCRIPTS
======================================== */

function webjti_enqueue_assets() {

  /* ========================================
     CSS
  ======================================== */

  $header_css_path = get_template_directory() . '/assets/css/sections/header.css';
  $sidebar_css_path = get_template_directory() . '/assets/css/components/sidebar-submenu.css';
  $app_css_path = get_template_directory() . '/assets/css/app.css';
  $css_version = max(
    filemtime($app_css_path),
    file_exists($header_css_path) ? filemtime($header_css_path) : 0,
    file_exists($sidebar_css_path) ? filemtime($sidebar_css_path) : 0
  );

  wp_enqueue_style(
    'webjti-app',
    get_template_directory_uri()
      . '/assets/css/app.css',
    [],
    $css_version
  );

  wp_enqueue_style(
    'webjti-mahasiswa-modal',
    get_template_directory_uri()
      . '/assets/css/components/mahasiswa-modal.css',
    [],
    filemtime(
      get_template_directory()
      . '/assets/css/components/mahasiswa-modal.css'
    )
  );

  /* ========================================
     JS - CORE
  ======================================== */

  wp_enqueue_script(
    'webjti-main',
    get_template_directory_uri()
      . '/assets/js/core/main.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/main.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-navigation',
    get_template_directory_uri()
      . '/assets/js/core/navigation.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/navigation.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-api',
    get_template_directory_uri()
      . '/assets/js/core/api.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/api.js'
    ),
    true
  );

  /* ========================================
     JS - COMPONENTS
  ======================================== */

  wp_enqueue_script(
    'webjti-slider',
    get_template_directory_uri()
      . '/assets/js/components/slider.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/slider.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-tabs',
    get_template_directory_uri()
      . '/assets/js/components/tabs.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/tabs.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-video-modal',
    get_template_directory_uri()
      . '/assets/js/components/video-modal.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/video-modal.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-mahasiswa-modal',
    get_template_directory_uri()
      . '/assets/js/components/mahasiswa-modal.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/mahasiswa-modal.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-dosen-modal',
    get_template_directory_uri()
      . '/assets/js/components/dosen-modal.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/dosen-modal.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-gallery-lightbox',
    get_template_directory_uri()
      . '/assets/js/components/gallery-lightbox.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/gallery-lightbox.js'
    ),
    true
  );

  if (
    is_page_template('templates/pages/gallery-kemahasiswaan-page.php') ||
    is_page('gallery-kemahasiswaan') ||
    is_page('galeri-kemahasiswaan') ||
    is_page('gallery') ||
    is_page('galeri')
  ) {
    wp_enqueue_script(
      'webjti-gallery-detail-modal',
      get_template_directory_uri()
        . '/assets/js/components/gallery-detail-modal.js',
      [],
      filemtime(
        get_template_directory()
        . '/assets/js/components/gallery-detail-modal.js'
      ),
      true
    );
  }

  wp_enqueue_script(
    'webjti-lecturer-card',
    get_template_directory_uri()
      . '/assets/js/components/lecturer-card.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/lecturer-card.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-staff-card',
    get_template_directory_uri()
      . '/assets/js/components/staff-card.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/staff-card.js'
    ),
    true
  );

  /* ========================================
     JS - SECTIONS
  ======================================== */

  wp_enqueue_script(
    'webjti-hero-slider',
    get_template_directory_uri()
      . '/assets/js/sections/hero-slider.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/sections/hero-slider.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-information',
    get_template_directory_uri()
      . '/assets/js/sections/information.js',
    ['webjti-main'],
    filemtime(
      get_template_directory()
      . '/assets/js/sections/information.js'
    ),
    true
  );

  wp_localize_script(
    'webjti-information',
    'jti_ajax',
    [
      'ajax_url' => admin_url('admin-ajax.php'),
    ]
  );

  wp_enqueue_script(
    'webjti-organization',
    get_template_directory_uri()
      . '/assets/js/sections/organization.js',
    ['webjti-main'],
    filemtime(
      get_template_directory()
      . '/assets/js/sections/organization.js'
    ),
    true
  );

  if ( is_singular('lecturer') || is_singular('laboratory') || is_singular('ormawa') ) {
    wp_enqueue_script(
      'webjti-gallery-auto-slider',
      get_template_directory_uri()
        . '/assets/js/sections/ormawa-gallery.js',
      [],
      filemtime(
        get_template_directory()
        . '/assets/js/sections/ormawa-gallery.js'
      ),
      true
    );

    wp_enqueue_script(
      'webjti-lecturer-publications',
      get_template_directory_uri()
        . '/assets/js/sections/lecturer-publications.js',
      ['webjti-slider'],
      filemtime(
        get_template_directory()
        . '/assets/js/sections/lecturer-publications.js'
      ),
      true
    );
  }


  wp_enqueue_style(
    'phosphor-regular',
    'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css',
    [],
    '2.1.1'
  );

  wp_enqueue_style(
    'phosphor-fill',
    'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css',
    [],
    '2.1.1'
  );

  if ( is_singular('lecturer') || is_singular('laboratory') || isset($_GET['default_lecturer']) ) {
    wp_enqueue_style(
      'jti-lecturer-detail',
      get_template_directory_uri() . '/assets/css/lecturer-detail.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/lecturer-detail.css')
    );
  }

  $request_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
  $program_khusus_routes = [
    'kelas-internasional',
    'double-degree',
    'alih-jenjang',
    'rpl',
    'akademik/kelas-internasional',
    'akademik/double-degree',
    'akademik/alih-jenjang',
    'akademik/rpl',
    'program-khusus/kelas-internasional',
    'program-khusus/double-degree',
    'program-khusus/alih-jenjang',
    'program-khusus/rpl',
  ];

  if (
    is_singular('program_khusus') ||
    is_page_template([
      'templates/pages/akademik/kelas-internasional-page.php',
      'templates/pages/akademik/double-degree-page.php',
      'templates/pages/akademik/alih-jenjang-page.php',
      'templates/pages/akademik/rpl-page.php',
    ]) ||
    in_array($request_path, $program_khusus_routes, true)
  ) {
    wp_enqueue_style(
      'jti-program-khusus',
      get_template_directory_uri() . '/assets/css/program-khusus.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/program-khusus.css')
    );
  }

  if ( is_singular('achievement') || isset($_GET['default_achievement']) ) {
    wp_enqueue_style(
      'jti-achievement-detail',
      get_template_directory_uri() . '/assets/css/sections/achievement-detail.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/sections/achievement-detail.css')
    );
  }

  if ( is_singular('ormawa') || is_post_type_archive('ormawa') ) {
    wp_enqueue_style(
      'jti-ormawa-detail',
      get_template_directory_uri() . '/assets/css/ormawa-detail.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/ormawa-detail.css')
    );
  }

  // Aturan Akademik accordion script
  // Pakai is_page_template() — lebih reliable daripada membandingkan get_page_template_slug() manual
  if (is_page_template('templates/pages/akademik/aturan-akademik-page.php')) {
    wp_enqueue_script(
      'webjti-aturan-akademik-accordion',
      get_template_directory_uri() . '/assets/js/sections/aturan-akademik-accordion.js',
      ['webjti-main'],
      filemtime(get_template_directory() . '/assets/js/sections/aturan-akademik-accordion.js'),
      true
    );
  }

}

add_action(
  'wp_enqueue_scripts',
  'webjti_enqueue_assets'
);

function webjti_enqueue_fonts() {

    wp_enqueue_style(
        'webjti-google-fonts',
        'https://fonts.googleapis.com/css2?family=Chivo+Mono:wght@100..900&display=swap',
        [],
        null
    );

}

add_action('wp_enqueue_scripts', 'webjti_enqueue_fonts');