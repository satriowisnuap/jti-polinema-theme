<?php


/* ========================================
   GET ORGANIZATION STRUCTURE
======================================== */

function webjti_get_organization_structure() {
  $query_args = [
    'post_type'      => 'organization_structu',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'order_number',
    'order'          => 'ASC',
  ];

  $query = new WP_Query($query_args);

  if (!$query->have_posts()) {
    $query_args = [
      'post_type'      => 'organization_structu',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'title',
      'order'          => 'ASC',
    ];
    $query = new WP_Query($query_args);
  }

  $db_items = [];

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $post_id = get_the_ID();

      $lecturer_val = function_exists('get_field') ? get_field('lecturer', $post_id) : get_post_meta($post_id, 'lecturer', true);
      $position_val = function_exists('get_field') ? get_field('position', $post_id) : get_post_meta($post_id, 'position', true);
      $order_number = function_exists('get_field') ? get_field('order_number', $post_id) : get_post_meta($post_id, 'order_number', true);
      $expandable   = function_exists('get_field') ? get_field('expandable', $post_id) : get_post_meta($post_id, 'expandable', true);

      $lecturer_name = '';
      $lecturer_photo = '';
      $lecturer_id = 0;

      if ($lecturer_val) {
        $lecturer_id = is_object($lecturer_val) ? $lecturer_val->ID : (int) $lecturer_val;
        $lecturer_name = get_the_title($lecturer_id);
        $lecturer_photo = get_the_post_thumbnail_url($lecturer_id, 'medium');
      }

      $position_title = '';
      $position_type = '';
      $related_study_program = '';

      if ($position_val) {
        $position_id = is_object($position_val) ? $position_val->ID : (int) $position_val;
        $position_title = get_the_title($position_id);
        if (function_exists('get_field')) {
          $position_type = get_field('position_type', $position_id);
          $study_prog_val = get_field('related_study_program', $position_id);
          if ($study_prog_val) {
            $sp_id = is_object($study_prog_val) ? $study_prog_val->ID : (int) $study_prog_val;
            $related_study_program = get_the_title($sp_id);
          }
        }
      }

      $db_items[] = [
        'id'                    => $post_id,
        'struct_title'          => get_the_title(),
        'lecturer_id'           => $lecturer_id,
        'lecturer_name'         => $lecturer_name,
        'lecturer_photo'        => $lecturer_photo,
        'position_title'        => $position_title,
        'position_type'         => $position_type,
        'related_study_program' => $related_study_program,
        'order_number'          => (int) $order_number,
        'expandable'            => !empty($expandable),
      ];
    }
    wp_reset_postdata();
  }

  // Default structure data matching complete JTI organizational diagram
  $placeholder_base = get_template_directory_uri() . '/assets/images/placeholders/';

  $default_head = [
    'name'     => 'Murqi Astiningrum, S.T., M.Kom.',
    'position' => 'Ketua Jurusan',
    'photo'    => $placeholder_base . 'bu mungki.png',
  ];

  $default_secretary = [
    'name'     => 'Luqman Affandi, S.Kom., MMSI',
    'position' => 'Sekretaris Jurusan',
    'photo'    => $placeholder_base . 'bu ana.png',
  ];

  $default_coordinators = [
    [
      'id'           => 's2-rti',
      'name'         => 'Dr. Eng. Rosa Andrie Asmara, S.ST., M.T.',
      'position'     => 'Koordinator Program Studi',
      'program'      => 'S2 Magister Terapan Rekayasa Teknologi Informasi',
      'photo'        => $placeholder_base . 'pak hendra.png',
      'expandable'   => true,
      'member_count' => 1,
      'is_expanded'  => false,
      'members'      => [
        [
          'name'     => 'Dr. Ir. M. Sarosa, M.T.',
          'position' => 'Koordinator Kurikulum',
          'program'  => 'S2 Magister Terapan Rekayasa Teknologi Informasi',
          'photo'    => $placeholder_base . 'pak yoga.png',
        ],
      ]
    ],
    [
      'id'           => 'd4-ti',
      'name'         => 'Dr. Ely Setyo Astuti, S.T., M.T.',
      'position'     => 'Koordinator Program Studi',
      'program'      => 'D4 Teknik Informatika',
      'photo'        => $placeholder_base . 'bu ana.png',
      'expandable'   => true,
      'member_count' => 6,
      'is_expanded'  => true,
      'members'      => [
        [
          'name'     => 'Imam Fahrur Rozi, S.T., M.T.',
          'position' => 'Koordinator Kurikulum',
          'program'  => 'D4 Teknik Informatika',
          'photo'    => $placeholder_base . 'pak hendra.png',
        ],
        [
          'name'     => 'Wilda Imama Sabilla, S.Kom., M.CV.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Rekayasa Perangkat Lunak D4 TI',
          'photo'    => $placeholder_base . 'bu devi.png',
        ],
        [
          'name'     => 'Mamiktuul Hijriah, S.Kom., M.T.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Visi Cerdas dan Sistem Cerdas D4 TI',
          'photo'    => $placeholder_base . 'bu ana.png',
        ],
        [
          'name'     => 'Vipkas Alisjahbana, S.T., M.Kom.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Jaringan dan Keamanan Siber D4 TI',
          'photo'    => $placeholder_base . 'pak yoga.png',
        ],
        [
          'name'     => 'Atiqah Nurul Asri, S.Pd., M.Ed.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Multimedia dan Perangkat Bergerak D4 TI',
          'photo'    => $placeholder_base . 'bu devi.png',
        ],
        [
          'name'     => 'Usman Nurhasan, S.Kom., M.T.',
          'position' => 'Koordinator Prakerin & Kerjasama',
          'program'  => 'D4 Teknik Informatika',
          'photo'    => $placeholder_base . 'pak hendra.png',
        ],
      ]
    ],
    [
      'id'           => 'd4-sib',
      'name'         => 'Hendra Pradibta, S.E., M.Sc.',
      'position'     => 'Koordinator Program Studi',
      'program'      => 'D4 Sistem Informasi Bisnis',
      'photo'        => $placeholder_base . 'pak hendra.png',
      'expandable'   => true,
      'member_count' => 6,
      'is_expanded'  => false,
      'members'      => [
        [
          'name'     => 'Anugrah Nur Rahmanto, S.Kom., M.Kom.',
          'position' => 'Koordinator Kurikulum',
          'program'  => 'D4 Sistem Informasi Bisnis',
          'photo'    => $placeholder_base . 'pak yoga.png',
        ],
        [
          'name'     => 'Dwi Puspitasari, S.Kom., M.Kom.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Sistem Informasi D4 SIB',
          'photo'    => $placeholder_base . 'bu ana.png',
        ],
        [
          'name'     => 'Ely Setyo Astuti, S.T., M.T.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Analisa Bisnis D4 SIB',
          'photo'    => $placeholder_base . 'bu ana.png',
        ],
        [
          'name'     => 'Meyti Eka Apriyani, S.ST., M.T.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Teknologi Data D4 SIB',
          'photo'    => $placeholder_base . 'bu devi.png',
        ],
        [
          'name'     => 'Faiz Ushbah Mubarok, S.Pd., M.Pd.',
          'position' => 'Koordinator Bidang Keahlian',
          'program'  => 'Informatika Terapan D4 SIB',
          'photo'    => $placeholder_base . 'pak hendra.png',
        ],
        [
          'name'     => 'Kadek Suarjuna Batubulan, S.Kom., M.T.',
          'position' => 'Koordinator Prakerin & Kerjasama',
          'program'  => 'D4 Sistem Informasi Bisnis',
          'photo'    => $placeholder_base . 'pak yoga.png',
        ],
      ]
    ],
    [
      'id'           => 'd2-ppls',
      'name'         => 'Pramana Yoga Saputra, S.Kom., M.MT.',
      'position'     => 'Koordinator Program Studi',
      'program'      => 'D2 Pengembangan Piranti Lunak Situs',
      'photo'        => $placeholder_base . 'pak yoga.png',
      'expandable'   => true,
      'member_count' => 2,
      'is_expanded'  => false,
      'members'      => [
        [
          'name'     => 'Ariyadi, S.Kom., M.Kom.',
          'position' => 'Koordinator Kurikulum',
          'program'  => 'D2 PPLS',
          'photo'    => $placeholder_base . 'pak hendra.png',
        ],
        [
          'name'     => 'Faris Candra Setyawan, S.ST., M.T.',
          'position' => 'Koordinator Prakerin & Kerjasama',
          'program'  => 'D2 PPLS',
          'photo'    => $placeholder_base . 'pak yoga.png',
        ],
      ]
    ],
  ];

  $default_lab_heads = [
    [
      'name'     => 'M. Nanda Arfan Azizi, S.Kom., M.T.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Jaringan dan Keamanan Siber',
      'photo'    => $placeholder_base . 'pak yoga.png',
      'icon'     => 'ph-shield-check',
    ],
    [
      'name'     => 'Pikir Wisnu Wijayanto, S.E., S.Kom., M.Kom.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Rekayasa Perangkat Lunak',
      'photo'    => $placeholder_base . 'pak hendra.png',
      'icon'     => 'ph-brackets-curly',
    ],
    [
      'name'     => 'Agi Putra Kharisma, S.ST., M.T.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Visi Cerdas dan Sistem Cerdas',
      'photo'    => $placeholder_base . 'pak yoga.png',
      'icon'     => 'ph-eye',
    ],
    [
      'name'     => 'Erfan Rohadi, ST., M.Eng., Ph.D.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Sistem Informasi',
      'photo'    => $placeholder_base . 'pak hendra.png',
      'icon'     => 'ph-database',
    ],
    [
      'name'     => 'Vivi Nur Wijayaningrum, S.Kom., M.Kom.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Analisa Bisnis',
      'photo'    => $placeholder_base . 'bu ana.png',
      'icon'     => 'ph-chart-bar',
    ],
    [
      'name'     => 'Habibie Ed Dien, S.Kom., M.MT.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Teknologi Data',
      'photo'    => $placeholder_base . 'pak yoga.png',
      'icon'     => 'ph-hard-drives',
    ],
    [
      'name'     => 'M. Harliss, S.Kom., M.Kom.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Multimedia dan Perangkat Bergerak',
      'photo'    => $placeholder_base . 'pak hendra.png',
      'icon'     => 'ph-device-mobile',
    ],
    [
      'name'     => 'Septian Enggar Sukmana, S.Pd., M.MT.',
      'position' => 'Kepala Laboratorium',
      'lab'      => 'Informatika Terapan',
      'photo'    => $placeholder_base . 'pak yoga.png',
      'icon'     => 'ph-gear',
    ],
  ];

  $default_committees = [
    [
      'name'     => 'Dimas Wahyu Wibowo, S.T., M.T.',
      'position' => 'Dosen Pembimbing Kemahasiswaan',
      'category' => 'Kemahasiswaan',
      'photo'    => $placeholder_base . 'pak hendra.png',
      'icon'     => 'ph-users-three',
    ],
    [
      'name'     => 'Dr. Indra Gita Anugrah, S.Kom., M.Kom.',
      'position' => 'Majelis Skripsi dan Tugas Akhir',
      'category' => 'Akademik & Tugas Akhir',
      'photo'    => $placeholder_base . 'pak yoga.png',
      'icon'     => 'ph-certificate',
    ],
  ];

  $default_academic_advisors = [
    'title'       => 'Dosen Pembimbing Akademik',
    'description' => 'Dosen Pembimbing Akademik (PA) bertugas mendampingi dan membimbing seluruh mahasiswa Jurusan Teknologi Informasi dalam perencanaan studi dan pengembangan akademik selama masa perkuliahan.',
  ];

  // Dynamically map DB items if populated from WP-Admin
  $final_head              = $default_head;
  $final_secretary         = $default_secretary;
  $final_coordinators      = [];
  $final_lab_heads         = [];
  $final_committees        = [];
  $final_academic_advisors = $default_academic_advisors;

  if (!empty($db_items)) {
    $db_coords_map = [];
    $db_sub_members = [];

    foreach ($db_items as $item) {
      $p_type = strtolower($item['position_type'] ?? '');
      $photo  = !empty($item['lecturer_photo']) ? $item['lecturer_photo'] : ($placeholder_base . 'bu mungki.png');

      if ($p_type === 'head') {
        $final_head = [
          'name'     => $item['lecturer_name'] ?: $item['struct_title'],
          'position' => $item['position_title'] ?: 'Ketua Jurusan',
          'photo'    => $photo,
          'lecturer_id' => $item['lecturer_id'] ?? 0,
        ];
      } elseif ($p_type === 'secretary') {
        $final_secretary = [
          'name'     => $item['lecturer_name'] ?: $item['struct_title'],
          'position' => $item['position_title'] ?: 'Sekretaris Jurusan',
          'photo'    => $photo,
          'lecturer_id' => $item['lecturer_id'] ?? 0,
        ];
      } elseif ($p_type === 'study_program_coordinator') {
        $prog_name = !empty($item['related_study_program']) ? $item['related_study_program'] : $item['position_title'];
        $coord_key = sanitize_title($prog_name);

        $db_coords_map[$coord_key] = [
          'id'           => $coord_key,
          'name'         => $item['lecturer_name'] ?: $item['struct_title'],
          'position'     => $item['position_title'] ?: 'Koordinator Program Studi',
          'program'      => $prog_name,
          'photo'        => $photo,
          'expandable'   => !empty($item['expandable']),
          'member_count' => 0,
          'is_expanded'  => false,
          'members'      => [],
          'lecturer_id'  => $item['lecturer_id'] ?? 0,
        ];
      } elseif (in_array($p_type, ['curriculum_coordinator', 'expertise_coordinator', 'internship_coordinator'], true)) {
        $db_sub_members[] = $item;
      } elseif ($p_type === 'laboratory_head') {
        $final_lab_heads[] = [
          'name'     => $item['lecturer_name'] ?: $item['struct_title'],
          'position' => $item['position_title'] ?: 'Kepala Laboratorium',
          'lab'      => $item['related_study_program'] ?: 'Laboratorium JTI',
          'photo'    => $photo,
          'icon'     => 'ph-flask',
          'lecturer_id' => $item['lecturer_id'] ?? 0,
        ];
      } elseif (in_array($p_type, ['student_affair', 'final_project_head'], true)) {
        $final_committees[] = [
          'name'     => $item['lecturer_name'] ?: $item['struct_title'],
          'position' => $item['position_title'],
          'category' => $item['related_study_program'] ?: 'Kemahasiswaan & TA',
          'photo'    => $photo,
          'icon'     => 'ph-users-three',
          'lecturer_id' => $item['lecturer_id'] ?? 0,
        ];
      }
    }

    // Attach sub-members to coordinators if available
    if (!empty($db_coords_map)) {
      foreach ($db_sub_members as $sub) {
        $sub_prog = $sub['related_study_program'] ?? '';
        $prog_key = sanitize_title($sub_prog);
        $target_key = '';

        foreach ($db_coords_map as $c_key => $c_val) {
          $c_prog_key = sanitize_title($c_val['program'] ?? '');
          if ($prog_key && ($prog_key === $c_prog_key || strpos($c_key, $prog_key) !== false || strpos($prog_key, $c_key) !== false)) {
            $target_key = $c_key;
            break;
          }
        }

        if (!$target_key) {
          // Check position_title for keywords like 'D4 TI', 'D4 SIB', 'S2 RTI', 'D2 PPLS'
          $sub_pos = strtolower($sub['position_title'] ?? '');
          foreach ($db_coords_map as $c_key => $c_val) {
            if (strpos($c_key, 'd4-ti') !== false && (strpos($sub_pos, 'd4 ti') !== false || strpos($sub_pos, 'informatika') !== false)) {
              $target_key = $c_key;
              break;
            } elseif (strpos($c_key, 'd4-sib') !== false && (strpos($sub_pos, 'd4 sib') !== false || strpos($sub_pos, 'bisnis') !== false)) {
              $target_key = $c_key;
              break;
            } elseif (strpos($c_key, 's2-rti') !== false && (strpos($sub_pos, 's2') !== false || strpos($sub_pos, 'rti') !== false)) {
              $target_key = $c_key;
              break;
            } elseif (strpos($c_key, 'd2-ppls') !== false && (strpos($sub_pos, 'd2') !== false || strpos($sub_pos, 'ppls') !== false)) {
              $target_key = $c_key;
              break;
            }
          }
        }

        if (!$target_key) {
          $keys = array_keys($db_coords_map);
          $target_key = $keys[0] ?? '';
        }

        if ($target_key && isset($db_coords_map[$target_key])) {
          $db_coords_map[$target_key]['members'][] = [
            'name'     => $sub['lecturer_name'] ?: $sub['struct_title'],
            'position' => $sub['position_title'],
            'program'  => $sub['related_study_program'] ?: $db_coords_map[$target_key]['program'],
            'photo'    => !empty($sub['lecturer_photo']) ? $sub['lecturer_photo'] : ($placeholder_base . 'bu ana.png'),
            'lecturer_id' => $sub['lecturer_id'] ?? 0,
          ];
          $db_coords_map[$target_key]['member_count']++;
          $db_coords_map[$target_key]['expandable'] = true;
        }
      }
      $final_coordinators = array_values($db_coords_map);
    }
  }

  if (empty($final_coordinators)) {
    $final_coordinators = $default_coordinators;
  }
  if (empty($final_lab_heads)) {
    $final_lab_heads = $default_lab_heads;
  }
  if (empty($final_committees)) {
    $final_committees = $default_committees;
  }

  return [
    'db_items'          => $db_items,
    'head'              => $final_head,
    'secretary'         => $final_secretary,
    'coordinators'      => $final_coordinators,
    'lab_heads'         => $final_lab_heads,
    'committees'        => $final_committees,
    'academic_advisors' => $final_academic_advisors,
  ];
}

/* ========================================
   GET ACHIEVEMENTS
======================================== */

function webjti_get_achievements($args = []) {

  $default_args = [
    'post_type'      => 'achievement',
    'posts_per_page' => 6,
    'post_status'    => 'publish'
  ];

  $query_args =
    wp_parse_args(
      $args,
      $default_args
    );

  return new WP_Query(
    $query_args
  );

}

/* ========================================
   GET LECTURERS
======================================== */

// function webjti_get_lecturers($args = []) {

//   $default_args = [
//     'post_type'      => 'lecturer',
//     'posts_per_page' => -1,
//     'post_status'    => 'publish'
//   ];

//   $query_args =
//     wp_parse_args(
//       $args,
//       $default_args
//     );

//   return new WP_Query(
//     $query_args
//   );

// }

/* ========================================
   GET HERO SLIDES
======================================== */

function webjti_get_hero_slides() {
  $post_types = [
    'information',
  ];

  $posts_per_page = 4;

  $query_args = [
    'post_type' => $post_types,
    'posts_per_page' => $posts_per_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
  ];

  $query_args =
    apply_filters(
      'webjti_hero_query_args',
      $query_args
    );

  $query = new WP_Query($query_args);

  $slides = [];

  while ($query->have_posts()) {

    $query->the_post();

    $post_type =
      get_post_type();

    $post_type_obj =
      get_post_type_object($post_type);

    $category_value =
      function_exists('get_field')
        ? strtolower(get_field('category'))
        : '';

    $category_map = [
      'news' => 'Berita',
      'announcement' => 'Pengumuman',
      'event' => 'Agenda',
      'berita' => 'Berita',
      'pengumuman' => 'Pengumuman',
      'agenda' => 'Agenda',
    ];

    $category_label = $category_map[$category_value] ?? 'Berita';

    $slides[] = [

      'id' =>
        get_the_ID(),

      'title' =>
        get_the_title(),

      'permalink' =>
        get_permalink(),

      'category' =>
        $category_label,

      'image' =>
        has_post_thumbnail()
          ? get_the_post_thumbnail_url(
              get_the_ID(),
              'full'
            )
          : get_template_directory_uri()
              . '/assets/images/placeholders/hero-placeholder.jpg',

      'date' =>
        date_i18n('j F Y', get_post_time('U')),

    ];

  }

  wp_reset_postdata();

  if (count($slides) < $posts_per_page) {

    $remaining =
      $posts_per_page - count($slides);

    $exclude_ids =
      wp_list_pluck($slides, 'id');

    $default_query =
      new WP_Query([
        'post_type' => $post_types,
        'posts_per_page' => $remaining,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'meta_key' => 'featured_news',
        'meta_value' => 1,
        'post__not_in' => $exclude_ids,
      ]);

    while ($default_query->have_posts()) {

      $default_query->the_post();

      $post_type =
        get_post_type();

      $post_type_obj =
        get_post_type_object($post_type);

      $category_value =
        function_exists('get_field')
          ? get_field('category')
          : '';

      $category_map = [
        'news' => 'Berita',
        'announcement' => 'Pengumuman',
        'event' => 'Agenda',
      ];

      $category_label = $category_map[$category_value] ?? 'Berita';

      $slides[] = [

        'id' =>
          get_the_ID(),

        'title' =>
          get_the_title(),

        'permalink' =>
          get_permalink(),

        'category' =>
          $category_label,

        'image' =>
          has_post_thumbnail()
            ? get_the_post_thumbnail_url(
                get_the_ID(),
                'full'
              )
            : get_template_directory_uri()
                . '/assets/images/placeholders/hero-placeholder.jpg',

        'date' =>
          date_i18n('j F Y', get_post_time('U')),

      ];

    }

    wp_reset_postdata();

  }

  if (empty($slides) && !get_theme_mod('jti_disable_default_posts')) {

    $remaining =
      $posts_per_page;

    $default_slides = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.jpg',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.jpg',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.jpg',
        'date'      => date_i18n('j F Y'),
      ],
    ];

    $default_to_add =
      array_slice(
        $default_slides,
        0,
        $remaining
      );

    $slides =
      array_merge(
        $slides,
        $default_to_add
      );

  }

  return $slides;

}

/* ========================================
   GET INFORMATION POSTS
======================================== */

function webjti_get_information_posts() {

  $spotlight_query =
    new WP_Query([

      'post_type' => [
        'information',
      ],

      'posts_per_page' => 1,

      'meta_query' => [
        [
          'key'   => 'featured_news',
          'value' => '1',
        ],
      ],

      'orderby' => 'date',

      'order' => 'DESC',

      'post_status' =>
        'publish',

    ]);

  $spotlight = null;
  $spotlight_id = 0;

  if ($spotlight_query->have_posts()) {

    $spotlight_query->the_post();

    $spotlight =
      webjti_format_news_post();

    $spotlight_id =
      get_the_ID();

  }

  wp_reset_postdata();

  $list_query =
    new WP_Query([

      'post_type' => [
        'information',
      ],

      'posts_per_page' =>
        $spotlight ? 4 : 5,

      'post__not_in' =>
        $spotlight_id
          ? [$spotlight_id]
          : [],

      'orderby' => 'date',

      'order' => 'DESC',

      'post_status' =>
        'publish',

    ]);

  $list_posts = [];

  while ($list_query->have_posts()) {

    $list_query->the_post();

    if (!$spotlight) {

      $spotlight =
        webjti_format_news_post();

      $spotlight_id =
        get_the_ID();

    }

    else {

      $list_posts[] =
        webjti_format_news_post();

    }

  }

  wp_reset_postdata();

  wp_reset_postdata();

  // Combine spotlight and list posts
  $all_posts = [];
  if ($spotlight) {
    $all_posts[] = $spotlight;
  }
  foreach ($list_posts as $p) {
    $all_posts[] = $p;
  }

  // Pad with defaults if less than 5
  if (empty($all_posts) && !get_theme_mod('jti_disable_default_posts')) {
    $remaining = 5;
    $default_slides = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '5 min',
        'excerpt'   => 'Selamat datang di website resmi Jurusan Teknologi Informasi Politeknik Negeri Malang.'
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.jpg',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '3 min',
        'excerpt'   => 'Informasi mengenai pelaksanaan registrasi ulang mahasiswa untuk semester ganjil mendatang.'
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '6 min',
        'excerpt'   => 'Jurusan Teknologi Informasi menyelenggarakan workshop kurikulum bersama para pakar industri.'
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.jpg',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '4 min',
        'excerpt'   => 'Telah dibuka penerimaan mahasiswa baru jalur kelas kerja sama industri untuk tahun ajaran ini.'
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.jpg',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '7 min',
        'excerpt'   => 'Prestasi membanggakan kembali diraih oleh JTI di tingkat nasional sebagai jurusan berkinerja terbaik.'
      ],
    ];

    $default_to_add = array_slice($default_slides, 0, $remaining);
    
    // Ensure we don't add duplicates if hero slides used the exact same default posts
    // We append them to all_posts
    $all_posts = array_merge($all_posts, $default_to_add);
  }

  // Re-assign spotlight and posts
  $spotlight = !empty($all_posts) ? $all_posts[0] : null;
  $list_posts = count($all_posts) > 1 ? array_slice($all_posts, 1) : [];

  return [

    'spotlight' =>
      $spotlight,

    'posts' =>
      $list_posts,

  ];

}

/* ========================================
   GET STUDY PROGRAMS
======================================== */

function webjti_get_study_programs($limit = 6) {

  $query =
    new WP_Query([

      'post_type' =>
        'study_program',

      'posts_per_page' =>
        $limit,

      'orderby' =>
        'menu_order',

      'order' =>
        'ASC',

      'post_status' =>
        'publish',

    ]);

  if (!$query->have_posts()) {
    return [
      [
        'id'            => 0,
        'title'         => __('D-IV Teknik Informatika', 'webjti'),
        'description'   => __('Menghasilkan lulusan yang kompeten dalam rekayasa perangkat lunak, kecerdasan buatan, keamanan siber, dan pemrograman mobile/web.', 'webjti'),
        'permalink'     => '#',
        'badge'         => '',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-code',
      ],
      [
        'id'            => 0,
        'title'         => __('D-IV Sistem Informasi Bisnis', 'webjti'),
        'description'   => __('Mengintegrasikan teknologi informasi dengan manajemen bisnis untuk merancang sistem cerdas yang efisien dan mendukung keputusan strategis.', 'webjti'),
        'permalink'     => '#',
        'badge'         => '',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-database',
      ],
      [
        'id'            => 0,
        'title'         => __('D-III Manajemen Informatika', 'webjti'),
        'description'   => __('Menghasilkan tenaga ahli madya yang kompeten di bidang pengembangan aplikasi web, mobile, basis data, dan jaringan komputer.', 'webjti'),
        'permalink'     => '#',
        'badge'         => 'PSDKU Kediri',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-desktop',
      ]
    ];
  }

  $programs = [];

  $fallback_icons = [

    'ph ph-code',

    'ph ph-database',

    'ph ph-desktop',

    'ph ph-cpu',

    'ph ph-devices',

    'ph ph-terminal-window',

  ];

  $icon_counter = 0;

  while ($query->have_posts()) {

    $query->the_post();

    $post_id = get_the_ID();

    $icon_field =
      function_exists('get_field')
        ? get_field('program_icon')
        : '';

    $description = get_the_excerpt();

    if (!$description) {

      $description = wp_trim_words(get_the_content(), 20, '...');

    }

    if (!$description) {

      $description =
        __('Deskripsi program studi belum tersedia.', 'webjti');

    }

    // Get Campus Label Taxonomy Branch Badge
    $badge = '';
    $terms = get_the_terms($post_id, 'campus_label');
    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $badge = $term->name;
        break;
      }
    }

    $icon_url = '';

    if (
      is_array($icon_field) &&
      isset($icon_field['url'])
    ) {

      $icon_url =
        $icon_field['url'];

    }

    elseif (
      is_string($icon_field) &&
      filter_var(
        $icon_field,
        FILTER_VALIDATE_URL
      )
    ) {

      $icon_url =
        $icon_field;

    }

    elseif (
      is_numeric($icon_field)
    ) {

      $icon_url =
        wp_get_attachment_url(
          $icon_field
        );

    }

    if (empty($icon_url) && has_post_thumbnail($post_id)) {
      $icon_url = get_the_post_thumbnail_url($post_id, 'full');
    }

    $programs[] = [

      'id' =>
        $post_id,

      'title' =>
        get_the_title(),

      'description' =>
        $description,

      'permalink' =>
        get_permalink(),

      'badge' =>
        $badge,

      'icon_url' =>
        $icon_url,

      'fallback_icon' =>
        !$icon_url
          ? $fallback_icons[
              $icon_counter % count($fallback_icons)
            ]
          : '',

    ];

    $icon_counter++;

  }

  wp_reset_postdata();

  return $programs;

}

/* ========================================
   GET HISTORY TIMELINE
======================================== */

function webjti_get_history_timeline() {

  $query =
    new WP_Query([

      'post_type' =>
        'history_timeline',

      'posts_per_page' =>
        -1,

      'post_status' =>
        'publish',

    ]);

  if (!$query->have_posts()) {
    $query =
      new WP_Query([

        'post_type' =>
          'timeline_sejarah',

        'posts_per_page' =>
          -1,

        'post_status' =>
          'publish',

      ]);
  }

  $default_items = [
    [
      'year' => '2005',
      'title' => 'Titik Awal',
      'content' => 'D3 Manajemen Informatika berdiri dengan SK Nomor 2001/D/T/2005 di bawah Jurusan Teknik Elektro, diawali 92 mahasiswa, 6 dosen tetap, 1 teknisi, dan 1 tenaga administrasi.',
      'icon_url' => '',
      'icon_class' => 'ph-rocket-launch'
    ],
    [
      'year' => '2010',
      'title' => 'Ekspansi ke Sarjana Terapan',
      'content' => 'Polinema mendirikan Program Studi D4 Teknik Informatika sesuai kebutuhan masyarakat dan industri. Awalnya 49 mahasiswa. Lima tahun kemudian, jumlahnya melonjak menjadi 553 mahasiswa.',
      'icon_url' => '',
      'icon_class' => 'ph-graduation-cap'
    ],
    [
      'year' => '2015',
      'title' => 'Jurusan Mandiri',
      'content' => 'Berdasarkan SK Direktur Nomor 53, Jurusan Teknologi Informasi resmi berdiri sebagai jurusan tersendiri yang menaungi Prodi D3 MI dan D4 TI, total 1.289 mahasiswa (409 D3 MI dan 880 D4 TI).',
      'icon_url' => '',
      'icon_class' => 'ph-chart-polar'
    ],
    [
      'year' => '2019',
      'title' => 'Ekspansi PSDKU',
      'content' => 'JTI memperluas jangkauan dengan three PSDKU: D3 Manajemen Informatika Kediri, D3 Manajemen Informatika Pamekasan, dan D3 Teknologi Informasi Lumajang.',
      'icon_url' => '',
      'icon_class' => 'ph-globe'
    ],
    [
      'year' => '2020',
      'title' => 'Era Program Baru',
      'content' => 'Sesuai kebutuhan industri dan arahan Kemendikbudristek, D3 Manajemen Informatika di kampus utama diubah D4 Sistem Informasi Bisnis. Ditambah 2 program baru: D2 Pengembangan Piranti Lunak Situs dan S2 Magister Terapan Rekayasa Teknologi Informasi.',
      'icon_url' => '',
      'icon_class' => 'ph-star'
    ]
  ];

  if (!$query->have_posts()) {
    return $default_items;
  }

  $items = [];
  $fallback_icons = [
    'ph-rocket-launch',
    'ph-graduation-cap',
    'ph-chart-polar',
    'ph-globe',
    'ph-star'
  ];
  $index = 0;

  while ($query->have_posts()) {

    $query->the_post();
    $post_id = get_the_ID();

    // 1. Retrieve Year (tahun)
    $year =
      function_exists('get_field')
        ? get_field('tahun', $post_id)
        : get_post_meta($post_id, 'tahun', true);

    if (!$year) {
      $year = get_post_meta($post_id, '_timeline_year', true);
    }
    if (!$year) {
      $year = '-';
    }

    // 2. Retrieve Title (timeline_title)
    $title =
      function_exists('get_field')
        ? get_field('timeline_title', $post_id)
        : get_post_meta($post_id, 'timeline_title', true);

    if (!$title) {
      $title = get_the_title($post_id);
    }

    // 3. Retrieve Description (description)
    $description =
      function_exists('get_field')
        ? get_field('description', $post_id)
        : get_post_meta($post_id, 'description', true);

    if (!$description) {
      $description = get_the_content(null, false, $post_id);
    }

    // 4. Retrieve Icon (timeline_ikon)
    $ikon =
      function_exists('get_field')
        ? get_field('timeline_ikon', $post_id)
        : get_post_meta($post_id, 'timeline_ikon', true);

    if (!$ikon) {
      $ikon = get_post_meta($post_id, 'ikon', true);
    }
    if (!$ikon) {
      $ikon = get_post_meta($post_id, '_timeline_icon', true);
    }

    $icon_url = '';
    $icon_class = '';

    if (!empty($ikon)) {
      if (is_array($ikon)) {
        $icon_url = isset($ikon['url']) ? $ikon['url'] : '';
      } elseif (is_numeric($ikon)) {
        $icon_url = wp_get_attachment_image_url($ikon, 'full');
      } elseif (filter_var($ikon, FILTER_VALIDATE_URL)) {
        $icon_url = $ikon;
      } else {
        // String class name
        $icon_class = $ikon;
      }
    }

    // Assign fallback icon class dynamically if none is set
    if (empty($icon_url) && empty($icon_class)) {
      $year_clean = (int) $year;
      if ($year_clean === 2005) {
        $icon_class = 'ph-rocket-launch';
      } elseif ($year_clean === 2010) {
        $icon_class = 'ph-graduation-cap';
      } elseif ($year_clean === 2015) {
        $icon_class = 'ph-chart-polar';
      } elseif ($year_clean === 2019) {
        $icon_class = 'ph-globe';
      } elseif ($year_clean === 2020) {
        $icon_class = 'ph-star';
      } else {
        $icon_class = $fallback_icons[$index % count($fallback_icons)];
      }
    }

    $items[] = [
      'title' => $title,
      'content' => apply_filters('the_content', $description),
      'year' => $year,
      'icon_url' => $icon_url,
      'icon_class' => $icon_class,
    ];

    $index++;

  }

  wp_reset_postdata();

  // Sort chronologically ascending
  usort($items, function($a, $b) {
    $year_a = (int) $a['year'];
    $year_b = (int) $b['year'];
    if ($year_a === $year_b) {
      return 0;
    }
    return ($year_a < $year_b) ? -1 : 1;
  });

  return $items;

}

/* ========================================
   GET MAGANG ALUR
======================================== */

function webjti_get_magang_alur() {
  $terms = get_terms([
      'taxonomy'   => 'kategori_magang',
      'hide_empty' => false,
  ]);

  $grouped_data = [];
  $has_db_posts = false;

  if (!is_wp_error($terms) && !empty($terms)) {
      foreach ($terms as $term) {
          $query = new WP_Query([
              'post_type'      => ['magang_alur', 'alur_magang'],
              'posts_per_page' => -1,
              'post_status'    => 'publish',
              'orderby'        => 'menu_order title',
              'order'          => 'ASC',
              'tax_query'      => [
                  [
                      'taxonomy' => 'kategori_magang',
                      'field'    => 'term_id',
                      'terms'    => $term->term_id,
                  ],
              ],
          ]);

          $items = [];
          if ($query->have_posts()) {
              $has_db_posts = true;
              $index = 1;
              while ($query->have_posts()) {
                  $query->the_post();
                  $post_id = get_the_ID();

                  $step = function_exists('get_field') ? get_field('step', $post_id) : get_post_meta($post_id, 'step', true);
                  if (!$step) {
                      $step = sprintf('Tahap %02d', $index);
                  }

                  $title = function_exists('get_field') ? get_field('title', $post_id) : get_post_meta($post_id, 'title', true);
                  if (!$title) {
                      $title = get_the_title($post_id);
                  }

                  $content = function_exists('get_field') ? get_field('content', $post_id) : get_post_meta($post_id, 'content', true);
                  if (!$content) {
                      $content = get_the_content(null, false, $post_id);
                  }

                  $button_text = function_exists('get_field') ? get_field('button_text', $post_id) : get_post_meta($post_id, 'button_text', true);
                  $button_url  = function_exists('get_field') ? get_field('button_url', $post_id) : get_post_meta($post_id, 'button_url', true);

                  $ikon = function_exists('get_field') ? get_field('icon', $post_id) : get_post_meta($post_id, 'icon', true);

                  $icon_url   = '';
                  $icon_class = '';

                  if (!empty($ikon)) {
                      if (is_array($ikon)) {
                          $icon_url = isset($ikon['url']) ? $ikon['url'] : '';
                      } elseif (is_numeric($ikon)) {
                          $icon_url = wp_get_attachment_image_url($ikon, 'full');
                      } elseif (filter_var($ikon, FILTER_VALIDATE_URL)) {
                          $icon_url = $ikon;
                      } else {
                          $icon_class = $ikon;
                      }
                  }

                  if (empty($icon_url) && empty($icon_class)) {
                      $fallback_icons = [
                          'ph-sign-in',
                          'ph-user-gear',
                          'ph-magnifying-glass',
                          'ph-clock-clockwise',
                          'ph-file-text',
                          'ph-upload-simple',
                          'ph-clipboard-text',
                      ];
                      $icon_class = $fallback_icons[($index - 1) % count($fallback_icons)];
                  }

                  $items[] = [
                      'step'        => $step,
                      'title'       => $title,
                      'content'     => apply_filters('the_content', $content),
                      'button_text' => $button_text,
                      'button_url'  => $button_url,
                      'icon_url'    => $icon_url,
                      'icon_class'  => $icon_class,
                  ];
                  $index++;
              }
              wp_reset_postdata();
          }

          $term_acf_id = 'kategori_magang_' . $term->term_id;
          
          $show_info = function_exists('get_field') ? get_field('show_info_box', $term_acf_id) : false;
          $info_type = function_exists('get_field') ? get_field('info_box_type', $term_acf_id) : 'info';
          $info_title = function_exists('get_field') ? get_field('info_box_title', $term_acf_id) : 'Informasi Penting';
          $info_icon = function_exists('get_field') ? get_field('info_box_icon', $term_acf_id) : 'ph-info';
          $info_content = function_exists('get_field') ? get_field('info_box_content', $term_acf_id) : '';

          $grouped_data[] = [
              'term_id'     => $term->term_id,
              'name'        => $term->name,
              'slug'        => $term->slug,
              'items'       => $items,
              'show_info'   => $show_info,
              'info_type'   => $info_type,
              'info_title'  => $info_title,
              'info_icon'   => $info_icon,
              'info_content'=> $info_content,
          ];
      }
  }

  if (empty($grouped_data)) {
      $grouped_data[] = [
          'term_id' => 'kolektif',
          'name' => 'Magang Kolektif',
          'slug' => 'kolektif',
          'show_info' => true,
          'info_type' => 'info',
          'info_title'=> 'Informasi Penting: Magang Kolektif Mitra JTI',
          'info_icon' => 'ph-info',
          'info_content'=> '<p><strong>Magang Kolektif</strong> dikelola secara terpusat oleh Jurusan TI bekerjasama dengan Perusahaan Mitra resmi. Mahasiswa memilih dan mendaftar lowongan yang telah disediakan di portal.</p>',
          'items' => [
              [
                  'step'        => 'Tahap 01',
                  'title'       => 'Login Portal JTI & Cek Lowongan Mitra',
                  'content'     => 'Mahasiswa melakukan login ke Portal JTI menggunakan NIM untuk melihat alokasi lowongan magang kolektif mitra industri.',
                  'button_text' => 'Portal JTI',
                  'button_url'  => 'https://jti.polinema.ac.id/portal',
                  'icon_url'    => '',
                  'icon_class'  => 'ph-sign-in',
              ],
              [
                  'step'        => 'Tahap 02',
                  'title'       => 'Lengkapi Profile & Pilih Perusahaan Mitra',
                  'content'     => 'Lengkapi kelengkapan profil diri dan daftar ke perusahaan mitra magang kolektif yang sesuai kriteria.',
                  'button_text' => 'Cari Lowongan',
                  'button_url'  => 'https://jti.polinema.ac.id/portal',
                  'icon_url'    => '',
                  'icon_class'  => 'ph-magnifying-glass',
              ]
          ]
      ];
      $grouped_data[] = [
          'term_id' => 'mandiri',
          'name' => 'Magang Mandiri',
          'slug' => 'mandiri',
          'show_info' => true,
          'info_type' => 'warning',
          'info_title'=> 'Informasi Penting: Magang Mandiri',
          'info_icon' => 'ph-lightbulb',
          'info_content'=> '<p><strong>Magang Mandiri</strong> adalah program magang yang mahasiswa usulkan sendiri ke perusahaan atau instansi di luar daftar mitra resmi JTI. Pengajuan dilakukan melalui portal dengan verifikasi kelayakan dari tim magang jurusan.</p>',
          'items' => [
              [
                  'step'        => 'Tahap 01',
                  'title'       => 'Login Portal JTI & Verifikasi Kelayakan',
                  'content'     => 'Mahasiswa melakukan login ke Portal JTI dan memastikan telah memenuhi syarat akademis untuk pengajuan Magang Mandiri.',
                  'button_text' => 'Portal JTI',
                  'button_url'  => 'https://jti.polinema.ac.id/portal',
                  'icon_url'    => '',
                  'icon_class'  => 'ph-sign-in',
              ],
              [
                  'step'        => 'Tahap 02',
                  'title'       => 'Pengajuan Instansi / Perusahaan Target',
                  'content'     => 'Input data calon perusahaan/instansi tujuan magang mandiri di Portal JTI untuk pengajuan rekomendasi Jurusan.',
                  'button_text' => 'Ajukan Perusahaan',
                  'button_url'  => 'https://jti.polinema.ac.id/portal',
                  'icon_url'    => '',
                  'icon_class'  => 'ph-buildings',
              ]
          ]
      ];
  }

  return $grouped_data;
}

/* ========================================
   GET COMPANY PARTNERS (PERUSAHAAN MAGANG)
======================================== */

function webjti_get_company_partners($search = '', $paged = 1, $posts_per_page = 5) {
  $search = sanitize_text_field($search);
  $paged  = max(1, intval($paged));

  $query_args = [
    'post_type'      => 'company_partner',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
  ];

  if (!empty($search)) {
    $query_args['s'] = $search;
  }

  $query = new WP_Query($query_args);

  $default_companies = [
    [
      'name'         => 'PT Telkom Indonesia (Persero) Tbk',
      'category'     => 'Telecommunication & Digital Services',
      'location'     => 'Jakarta / Malang',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Bank Central Asia Tbk (BCA)',
      'category'     => 'Banking & Financial Technology',
      'location'     => 'Jakarta / Tangerang',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT GoTo Gojek Tokopedia Tbk',
      'category'     => 'E-Commerce & On-Demand Services',
      'location'     => 'Jakarta / Remote',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Paragon Technology and Innovation',
      'category'     => 'Manufacturing & Information System',
      'location'     => 'Tangerang / Jakarta',
      'status'       => 'Terbatas',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Astra International Tbk',
      'category'     => 'Automotive & Digital Solutions',
      'location'     => 'Jakarta / Surabaya',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Bank Mandiri (Persero) Tbk',
      'category'     => 'Banking & Digital Banking',
      'location'     => 'Jakarta / Surabaya',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Shopee International Indonesia',
      'category'     => 'E-Commerce & Tech Industry',
      'location'     => 'Jakarta / Remote',
      'status'       => 'Terbatas',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Solusi Teknologi Nusantara',
      'category'     => 'Software Engineering & Web Dev',
      'location'     => 'Malang',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Inovasi Solusi Digital',
      'category'     => 'Artificial Intelligence & Data',
      'location'     => 'Surabaya / Malang',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
    [
      'name'         => 'PT Telekomunikasi Selular (Telkomsel)',
      'category'     => 'Network & Cloud Infrastructure',
      'location'     => 'Jakarta / Malang',
      'status'       => 'Tersedia',
      'website'      => 'https://jti.polinema.ac.id/portal',
      'logo'         => '',
    ],
  ];

  if (!$query->have_posts()) {
    $filtered = $default_companies;
    if (!empty($search)) {
      $filtered = array_filter($default_companies, function($item) use ($search) {
        $search_lower = strtolower($search);
        return strpos(strtolower($item['name']), $search_lower) !== false ||
               strpos(strtolower($item['category']), $search_lower) !== false ||
               strpos(strtolower($item['location']), $search_lower) !== false;
      });
      $filtered = array_values($filtered);
    }

    $total_items = count($filtered);
    $max_pages   = ceil($total_items / $posts_per_page);
    $offset      = ($paged - 1) * $posts_per_page;
    $paged_rows  = array_slice($filtered, $offset, $posts_per_page);

    return [
      'rows'        => $paged_rows,
      'total'       => $total_items,
      'max_pages'   => max(1, $max_pages),
      'paged'       => $paged,
      'is_fallback' => true,
    ];
  }

  $rows = [];
  while ($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();

    $category = function_exists('get_field') ? get_field('category', $post_id) : get_post_meta($post_id, 'category', true);
    $location = function_exists('get_field') ? get_field('location', $post_id) : get_post_meta($post_id, 'location', true);
    $status   = function_exists('get_field') ? get_field('quota_status', $post_id) : get_post_meta($post_id, 'quota_status', true);
    $website  = function_exists('get_field') ? get_field('website_url', $post_id) : get_post_meta($post_id, 'website_url', true);
    $logo     = get_the_post_thumbnail_url($post_id, 'thumbnail');

    $rows[] = [
      'id'       => $post_id,
      'name'     => get_the_title($post_id),
      'category' => $category ?: 'Teknologi Informasi',
      'location' => $location ?: 'Indonesia',
      'status'   => $status ?: 'Tersedia',
      'website'  => $website ?: 'https://jti.polinema.ac.id/portal',
      'logo'     => $logo ?: '',
    ];
  }

  $max_pages   = $query->max_num_pages;
  $total_items = $query->found_posts;

  wp_reset_postdata();

  return [
    'rows'        => $rows,
    'total'       => $total_items,
    'max_pages'   => $max_pages,
    'paged'       => $paged,
    'is_fallback' => false,
  ];
}


/* ========================================
   GET LECTURERS
======================================== */

function webjti_get_term_names($post_id, $taxonomy) {

  $terms =
    get_the_terms(
      $post_id,
      $taxonomy
    );

  if (empty($terms) || is_wp_error($terms)) {
    return [];
  }

  return array_values(
    array_filter(
      wp_list_pluck(
        $terms,
        'name'
      )
    )
  );

}

/**
 * Smart Lecturer Placeholder Photo Resolver
 * Maps specific fallback lecturer names to their high-fidelity placeholder assets in the theme
 */
function webjti_get_lecturer_placeholder_photo($name, $fallback_index = null) {
  $theme_uri = get_template_directory_uri();
  
  if (stripos($name, 'Devi') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu devi.png';
  }
  if (stripos($name, 'Yoga') !== false) {
    return $theme_uri . '/assets/images/placeholders/pak yoga.png';
  }
  if (stripos($name, 'Hendra') !== false) {
    return $theme_uri . '/assets/images/placeholders/pak hendra.png';
  }
  if (stripos($name, 'Ana') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu ana.png';
  }
  if (stripos($name, 'Mungki') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu mungki.png';
  }
  
  // If we have a fallback index, choose a gender-appropriate placeholder from the 5 existing photos!
  if ($fallback_index !== null) {
    // Cast to int in case it's a string ID
    $index_num = (int)$fallback_index;
    
    $is_female = false;
    $female_keywords = ['Siti', 'Fitri', 'Vitri', 'Yuliana', 'Riza', 'Dewi', 'Hasana', 'Hidayah', 'Dewi', 'S.Si.'];
    foreach ($female_keywords as $kw) {
      if (stripos($name, $kw) !== false) {
        $is_female = true;
        break;
      }
    }
    
    $female_photos = [
      $theme_uri . '/assets/images/placeholders/bu devi.png',
      $theme_uri . '/assets/images/placeholders/bu mungki.png',
      $theme_uri . '/assets/images/placeholders/bu ana.png',
    ];
    
    $male_photos = [
      $theme_uri . '/assets/images/placeholders/pak yoga.png',
      $theme_uri . '/assets/images/placeholders/pak hendra.png',
    ];
    
    if ($is_female) {
      return $female_photos[$index_num % count($female_photos)];
    } else {
      return $male_photos[$index_num % count($male_photos)];
    }
  }
  
  return $theme_uri . '/assets/images/placeholders/default-avatar.png';
}

function webjti_get_lecturers($args = []) {

  $default_args = [

    'post_type' => 'lecturer',

    'posts_per_page' =>
      10,

    'post_status' =>
      'publish',

    'orderby' =>
      'title',

    'order' =>
      'ASC',

  ];

  $query_args =
    wp_parse_args(
      $args,
      $default_args
    );

  $query =
    new WP_Query($query_args);

  if (!$query->have_posts()) {
    $campuses = [
      'Kampus Utama'     => ['D-IV Teknik Informatika', 'D-IV Sistem Informasi Bisnis'],
      'PSDKU Lumajang'   => ['D-III Teknologi Informasi'],
      'PSDKU Kediri'     => ['D-III Manajemen Informatika'],
      'PSDKU Pamekasan'  => ['D-III Manajemen Informatika']
    ];

    $lecturers = [];
    $skills_pool = [
      ['Decision Support System', 'Data Science', 'Machine Learning', 'Big Data Analytics'],
      ['Image Processing', 'Computer Vision', 'Artificial Intelligence', 'Pattern Recognition'],
      ['Business Intelligence', 'Enterprise Resource Planning', 'Database Systems', 'System Analysis'],
      ['E-Business', 'IT Governance', 'Project Management', 'Digital Marketing'],
      ['Web Programming', 'Mobile Application Development', 'UI/UX Design', 'Interaction Design'],
      ['Computer Networks', 'Cloud Computing', 'Internet of Things', 'Network Security'],
      ['Database Management', 'Object-Oriented Programming', 'Software Engineering'],
      ['Algorithm Design', 'Data Structure', 'Embedded Systems', 'Microcontroller']
    ];

    $names = [
      'Kampus Utama' => [
        'Yoga Pristyanto, S.Kom., M.Eng.',
        'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.',
        'Devi Yuniarto, S.Kom., M.T.',
        'Hendra Pradibta, S.E., M.Sc.',
        'Usman Nurhasan, S.Kom., M.T.'
      ],
      'PSDKU Lumajang' => [
        'M. Ali Fikri, S.Kom., M.Kom.',
        'Riza Agustina, S.ST., M.T.',
        'Agus Herwanto, S.T., M.Cs.',
        'Indra Kharisma, S.Kom., M.T.',
        'Ana Anggraini, S.Si., M.Si.'
      ],
      'PSDKU Kediri' => [
        'Yuliana Rachmawati, S.Kom., M.T.',
        'Didik Dwi Prasetya, S.T., M.T.',
        'Bambang Hariadi, S.Kom., M.T.',
        'Fitri Rahmawati, S.ST., M.Eng.',
        'Mungki Puspitasari, S.Kom., M.Kom.'
      ],
      'PSDKU Pamekasan' => [
        'Achmad Budi Setiawan, S.T., M.Cs.',
        'Siti Nurul Hasana, S.ST., M.T.',
        'Faisal Muttaqin, S.Kom., M.Kom.',
        'Ahmad Faruq, S.T., M.Eng.',
        'Nurul Hidayah, S.Kom., M.T.'
      ]
    ];

    $nip_base = 198002060000000000;
    $nidn_base = 10000000;
    $card_index = 1;

    foreach ($campuses as $campus => $prodis) {
      for ($i = 0; $i < 5; $i++) {
        $prodi = $prodis[$i % count($prodis)];
        $name = $names[$campus][$i];
        $skills = $skills_pool[($card_index - 1) % count($skills_pool)];

        $lecturers[] = [
          'id'               => 'default-' . $card_index,
          'name'             => $name,
          'title'            => 'Dosen ' . $prodi,
          'study_program'    => $prodi,
          'nip'              => (string)($nip_base + $card_index * 123456789),
          'nidn'             => '00' . ($nidn_base + $card_index * 987),
          'laboratory'       => 'Lab Rekayasa Perangkat Lunak ' . ($card_index),
          'campus_location'  => $campus,
          'skills'           => $skills,
          'photo'            => webjti_get_lecturer_placeholder_photo($name, $card_index),
          'permalink'        => home_url('/?default_lecturer=default-' . $card_index),
        ];
        $card_index++;
      }
    }
    return $lecturers;
  }

  $lecturers = [];

  while ($query->have_posts()) {

    $query->the_post();

    /*
    ========================================
    PHOTO
    ========================================
    */

    $photo =
      get_the_post_thumbnail_url(
        get_the_ID(),
        'medium'
      );

    $default_photo = webjti_get_lecturer_placeholder_photo(get_the_title(), get_the_ID());

    /*
    ========================================
    SKILLS
    ========================================
    */

    $skills =
      webjti_get_term_names(
        get_the_ID(),
        'expertise'
      );

    if (empty($skills)) {

      $skills =
        get_field(
          'bidang_keahlian'
        );

    }

    if (empty($skills)) {

      $skills = [];

    }

    elseif (!is_array($skills)) {

      $skills =
        explode(',', $skills);

    }

    $skills =
      array_map(
        'trim',
        $skills
      );

    /*
    ========================================
    DATA
    ========================================
    */

    $laboratory_terms =
      webjti_get_term_names(
        get_the_ID(),
        'laboratory'
      );

    $campus_terms =
      webjti_get_term_names(
        get_the_ID(),
        'campus_location'
      );

    $lecturers[] = [

      'id' =>
        get_the_ID(),

      'name' =>
        get_the_title(),

      'title' =>
        get_the_excerpt(),

      'nip' =>
        get_field('nip') ?: '-',

      'nidn' =>
        get_field('nidn') ?: '-',

      'laboratory' =>
        !empty($laboratory_terms)
          ? implode(', ', $laboratory_terms)
          : webjti_get_lecturer_laboratory_name(get_the_ID()),

      'laboratory_url' =>
        webjti_get_lecturer_laboratory_url(get_the_ID()),

      'campus_location' =>
        !empty($campus_terms)
          ? implode(', ', $campus_terms)
          : (get_field('campus_location') ?: ''),

      'skills' =>
        $skills,

      'skills_display' =>
        array_slice(
          $skills,
          0,
          2
        ),

      'remaining_skills' =>
        max(
          count($skills) - 2,
          0
        ),

      'photo' =>
        $photo ?: $default_photo,

      'permalink' =>
        get_permalink(),

    ];

  }

  wp_reset_postdata();

  return $lecturers;

}

/**
 * Get Staff Members (Tenaga Kependidikan)
 * Handles dynamic CPT queries and supports 20 high-fidelity gender-appropriate fallback cards.
 */
function webjti_get_staff($args = []) {
  $default_args = [
    'post_type' => 'staff',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'ASC',
  ];

  $query_args = wp_parse_args($args, $default_args);
  $query = new WP_Query($query_args);

  if (!$query->have_posts()) {
    $departments = [
      'Akademik'             => 'Akademik D4 Teknik Informatika',
      'PLP'                  => 'Pranata Laboratorium Pendidikan (PLP)',
      'Administrasi Jurusan' => 'Administrasi Jurusan / Akademik',
      'Administrasi BMN'     => 'Administrasi Barang Milik Negara (BMN)',
      'Teknisi Jurusan'      => 'Teknisi Jurusan'
    ];

    $names = [
      'Akademik' => [
        'Ana Agustina, S.M.',
        'Hendra Wijaya, A.Md.',
        'Devi Kartika, S.E.',
        'Yoga Pratama, S.ST.'
      ],
      'PLP' => [
        'Mungki Widiastuti, A.Md.',
        'Budi Santoso, S.ST.',
        'Siti Aminah, A.Md.',
        'Achmad Fauzi, S.T.'
      ],
      'Administrasi Jurusan' => [
        'Riza Agustina, S.AP.',
        'Didik Hermawan, A.Md.',
        'Fitri Rahmawati, S.AP.',
        'Bambang Wijaya, S.E.'
      ],
      'Administrasi BMN' => [
        'Yuliana Rachmawati, S.E.',
        'Agus Setiawan, A.Md.',
        'Dewi Anggraini, S.E.',
        'Faisal Muttaqin, S.E.'
      ],
      'Teknisi Jurusan' => [
        'Ahmad Faruq, A.Md.T.',
        'Siti Nurul Hasana, A.Md.T.',
        'Fikri Hermawan, A.Md.T.',
        'Nurul Hidayah, A.Md.T.'
      ]
    ];

    $nip_base = 199002062019031000;
    $staff_list = [];
    $card_index = 1;

    foreach ($names as $dept_key => $dept_names) {
      $position = $departments[$dept_key];
      foreach ($dept_names as $name) {
        $staff_list[] = [
          'id'               => 'default-staff-' . $card_index,
          'name'             => $name,
          'position'         => $position,
          'nip'              => (string)($nip_base + $card_index * 987654),
          'photo'            => webjti_get_lecturer_placeholder_photo($name, $card_index),
          'department'       => $dept_key,
        ];
        $card_index++;
      }
    }
    return $staff_list;
  }

  $staff_list = [];
  while ($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();

    $photo = get_the_post_thumbnail_url($post_id, 'medium');

    $dept_terms = webjti_get_term_names($post_id, 'staff_department');
    $department = !empty($dept_terms) ? implode(', ', $dept_terms) : '';
    if (empty($department)) {
      $department = get_field('department', $post_id) ?: get_field('departemen', $post_id) ?: get_field('unit', $post_id) ?: get_field('staff_department', $post_id) ?: '';
    }

    $position = get_the_excerpt($post_id);
    if (empty($position)) {
      $position = get_field('jabatan', $post_id) ?: '-';
    }

    if (empty($department)) {
      if (stripos($position, 'PLP') !== false || stripos($position, 'Pranata') !== false) {
        $department = 'PLP';
      } elseif (stripos($position, 'Akademik') !== false) {
        $department = 'Akademik';
      } elseif (stripos($position, 'BMN') !== false || stripos($position, 'Barang Milik') !== false) {
        $department = 'Administrasi BMN';
      } elseif (stripos($position, 'Teknisi') !== false) {
        $department = 'Teknisi Jurusan';
      } elseif (stripos($position, 'Administrasi Jurusan') !== false) {
        $department = 'Administrasi Jurusan';
      } else {
        $department = 'Administrasi Jurusan';
      }
    }

    $staff_list[] = [
      'id'               => $post_id,
      'name'             => get_the_title($post_id),
      'position'         => $position,
      'nip'              => get_field('nip', $post_id) ?: '-',
      'photo'            => $photo ?: webjti_get_lecturer_placeholder_photo(get_the_title($post_id), $post_id),
      'department'       => $department,
    ];
  }
  wp_reset_postdata();

  return $staff_list;
}


/**
 * Query Helpers
 *
 * @package WebJTI_Theme
 */

/* ========================================
   SINGLE LECTURER & POSITION RESOLVER
======================================== */

function webjti_get_lecturer_position($lecturer_id = null) {
  $lecturer_id = $lecturer_id ?: get_the_ID();
  if (!$lecturer_id) return 'Tenaga Pengajar';

  // 1. Try ACF 'position' field on Lecturer post
  $position_val = function_exists('get_field') ? get_field('position', $lecturer_id) : get_post_meta($lecturer_id, 'position', true);
  if ($position_val) {
    if (is_object($position_val) && isset($position_val->post_title)) {
      return $position_val->post_title;
    } elseif (is_numeric($position_val)) {
      $title = get_the_title($position_val);
      if ($title) return $title;
    } elseif (is_string($position_val) && !empty($position_val)) {
      return $position_val;
    }
  }

  // 2. Try CPT organization_structu referencing this lecturer
  $struct_query = new WP_Query([
    'post_type'      => 'organization_structu',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => [
      [
        'key'     => 'lecturer',
        'value'   => $lecturer_id,
        'compare' => '=',
      ]
    ]
  ]);

  if ($struct_query->have_posts()) {
    $struct_query->the_post();
    $struct_id = get_the_ID();
    $pos_obj = function_exists('get_field') ? get_field('position', $struct_id) : get_post_meta($struct_id, 'position', true);
    wp_reset_postdata();

    if ($pos_obj) {
      if (is_object($pos_obj) && isset($pos_obj->post_title)) {
        return $pos_obj->post_title;
      } elseif (is_numeric($pos_obj)) {
        $title = get_the_title($pos_obj);
        if ($title) return $title;
      }
    }
  }
  wp_reset_postdata();

  // 3. Try legacy ACF 'jabatan' field
  $jabatan = function_exists('get_field') ? get_field('jabatan', $lecturer_id) : get_post_meta($lecturer_id, 'jabatan', true);
  if (!empty($jabatan) && is_string($jabatan)) {
    return $jabatan;
  }

  return 'Tenaga Pengajar';
}

function webjti_get_single_lecturer($post_id = null) {

  $post_id =
    $post_id ?: get_the_ID();

  if (!$post_id) {
    return null;
  }

  /*
  ========================================
  PHOTO
  ========================================
  */

  $acf_photo =
    get_field(
      'foto',
      $post_id
    );

  $photo = '';

  if (is_array($acf_photo)) {

    $photo =
      $acf_photo['url'] ?? '';

  }

  elseif (is_string($acf_photo)) {

    $photo =
      $acf_photo;

  }

  if (!$photo) {

    $photo =
      get_the_post_thumbnail_url(
        $post_id,
        'large'
      );

  }

  if (!$photo) {
    $photo = webjti_get_lecturer_placeholder_photo(get_the_title($post_id), $post_id);
  }

  /*
  ========================================
  SKILLS
  ========================================
  */

  $skills =
    webjti_get_term_names(
      $post_id,
      'expertise'
    );

  if (empty($skills)) {

    $skills =
      get_field(
        'bidang_keahlian',
        $post_id
      );

  }

  if (empty($skills)) {

    $skills = [];

  }

  elseif (!is_array($skills)) {

    $skills =
      explode(',', $skills);

  }

  $skills =
    array_filter(
      array_map(
        'trim',
        $skills
      )
    );

  /*
  ========================================
  DATA
  ========================================
  */

  $laboratory_terms =
    webjti_get_term_names(
      $post_id,
      'laboratory'
    );

  $campus_terms =
    webjti_get_term_names(
      $post_id,
      'campus_location'
    );

  $study_program_raw = get_field('study_program', $post_id) ?: get_field('program_studi', $post_id);

  $parse_acf_obj = function($val) {
      if (empty($val)) return '';
      $titles = [];
      $items = is_array($val) ? $val : [$val];
      foreach ($items as $item) {
          if (is_object($item) && isset($item->post_title)) $titles[] = $item->post_title;
          elseif (is_numeric($item)) $titles[] = get_the_title($item);
          elseif (is_string($item)) $titles[] = $item;
      }
      return implode(', ', $titles);
  };

  return [

    'id' =>
      $post_id,

    'name' =>
      get_the_title($post_id),

    'position' =>
      webjti_get_lecturer_position($post_id),

    'study_program' =>
      $parse_acf_obj($study_program_raw),

    'nip' =>
      get_field(
        'nip',
        $post_id
      ),

    'nidn' =>
      get_field(
        'nidn',
        $post_id
      ),

    'laboratory' =>
      !empty($laboratory_terms)
        ? implode(', ', $laboratory_terms)
        : webjti_get_lecturer_laboratory_name($post_id),

    'laboratory_url' =>
      webjti_get_lecturer_laboratory_url($post_id),

    'campus_location' =>
      !empty($campus_terms)
        ? implode(', ', $campus_terms)
        : get_field(
          'campus_location',
          $post_id
        ),

    'office_address' =>
      get_field('office_address', $post_id) ?: get_field('alamat_kantor', $post_id),

    'website' =>
      get_field(
        'website',
        $post_id
      ),

    'linkedin' =>
      get_field(
        'linkedin',
        $post_id
      ),

    'google_scholar' =>
      get_field(
        'google_scholar',
        $post_id
      ),

    'sinta' =>
      get_field(
        'sinta',
        $post_id
      ),

    'email' =>
      get_field(
        'email',
        $post_id
      ),

    'skills' =>
      $skills,

    'photo' =>
      $photo,

    'permalink' =>
      get_permalink($post_id),

    'excerpt' =>
      get_the_excerpt($post_id),

    'content' =>
      apply_filters(
        'the_content',
        get_post_field(
          'post_content',
          $post_id
        )
      ),

  ];

}

/* ========================================
   LECTURER EDUCATION
======================================== */

function webjti_get_lecturer_education($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        ['lecturer_education', 'pendidikan_dosen'],

      'posts_per_page' =>
        -1,

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $educations = [];

  while ($query->have_posts()) {
    $query->the_post();

    // --- ROBUST PHP FILTERING ---
    $assigned_lecturer = get_field('lecturer');
    $is_match = false;
    
    if (!empty($assigned_lecturer)) {
      $items = is_array($assigned_lecturer) ? $assigned_lecturer : [$assigned_lecturer];
      foreach ($items as $item) {
        $item_id = is_object($item) ? $item->ID : $item;
        if ((int)$item_id === (int)$lecturer_id) {
          $is_match = true;
          break;
        }
      }
    }
    
    if (!$is_match) continue;
    // ----------------------------

    $educations[] = [

      'degree' =>
        get_field('degree') ?: get_field('jenjang'),

      'institution' =>
        get_field('institution') ?: get_field('institusi'),

      'start_year' =>
        get_field('start_year') ?: get_field('tahun_mulai'),

      'end_year' =>
        get_field('end_year') ?: get_field('tahun_selesai'),

    ];

  }

  wp_reset_postdata();

  usort($educations, function($a, $b) {
      $a_year = intval($a['end_year'] ?: 0);
      $b_year = intval($b['end_year'] ?: 0);
      return $b_year - $a_year; // DESC
  });

  return $educations;

}

/* ========================================
   LECTURER CERTIFICATIONS
======================================== */

function webjti_get_lecturer_certifications($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        ['lecturer_certification', 'sertifikasi_dosen', 'lecturer_certificati'],

      'posts_per_page' =>
        -1,

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $certifications = [];

  while ($query->have_posts()) {
    $query->the_post();

    // --- ROBUST PHP FILTERING ---
    $assigned_lecturer = get_field('lecturer');
    $is_match = false;
    
    if (!empty($assigned_lecturer)) {
      $items = is_array($assigned_lecturer) ? $assigned_lecturer : [$assigned_lecturer];
      foreach ($items as $item) {
        $item_id = is_object($item) ? $item->ID : $item;
        if ((int)$item_id === (int)$lecturer_id) {
          $is_match = true;
          break;
        }
      }
    }
    
    if (!$is_match) continue;
    // ----------------------------

    $certifications[] = [

      'title' =>
        get_field('title') ?: get_field('certification_name') ?: get_field('nama_sertifikasi'),

      'institution' =>
        get_field('issuer') ?: get_field('institution') ?: get_field('lembaga'),

      'start_year' =>
        get_field('start_date') ?: get_field('start_year') ?: get_field('tahun_mulai'),

      'end_year' =>
        get_field('end_date') ?: get_field('end_year') ?: get_field('tahun_selesai'),

    ];

  }

  wp_reset_postdata();

  return $certifications;

}

/* ========================================
   LECTURER COURSES
======================================== */

function webjti_get_lecturer_courses($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        ['lecturer_course', 'matkul_dosen'],

      'posts_per_page' =>
        -1,

    ]);

  if (!$query->have_posts()) {
    return [
      'odd' => [],
      'even' => [],
    ];
  }

  $odd = [];
  $even = [];

  while ($query->have_posts()) {
    $query->the_post();

    // --- ROBUST PHP FILTERING ---
    $assigned_lecturer = get_field('lecturer');
    $is_match = false;
    
    if (!empty($assigned_lecturer)) {
      $items = is_array($assigned_lecturer) ? $assigned_lecturer : [$assigned_lecturer];
      foreach ($items as $item) {
        $item_id = is_object($item) ? $item->ID : $item;
        if ((int)$item_id === (int)$lecturer_id) {
          $is_match = true;
          break;
        }
      }
    }
    
    if (!$is_match) continue;
    // ----------------------------

    $course_names =
      get_field('course_name') ?: get_field('course_names') ?: get_field('courses') ?: get_field('nama_mata_kuliah');

    $semester =
      strtolower(
        get_field('semester') ?: get_field('term') ?: ''
      );

    $course_names =
      explode(
        ',',
        $course_names
      );

    foreach ($course_names as $course) {

      $course =
        trim($course);

      if (!$course) {
        continue;
      }

      if (
        strpos(
          $semester,
          'ganjil'
        ) !== false
      ) {

        $odd[] = $course;

      } else {

        $even[] = $course;

      }

    }

  }

  wp_reset_postdata();

  return [

    'odd' =>
      $odd,

    'even' =>
      $even,

  ];

}

/* ========================================
   LECTURER PUBLICATIONS
======================================== */

function webjti_get_lecturer_publications($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        'lecturer_publication',

      'posts_per_page' =>
        -1,

      'meta_query' => [
        'relation' => 'OR',
        [
          'key' =>
            'lecturer',
          'value' =>
            '"' . $lecturer_id . '"',
          'compare' =>
            'LIKE',
        ],
        [
          'key' =>
            'lecturer',
          'value' =>
            $lecturer_id,
          'compare' =>
            '=',
        ]
      ],

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $publications = [];

  while ($query->have_posts()) {

    $query->the_post();

    $publications[] = [

      'title' =>
        get_field(
          'publication_title'
        ) ?: get_the_title(),

      'year' =>
        get_field(
          'publication_year'
        ) ?: 0,

      'citations' =>
        get_field(
          'citation_count'
        ) ?: 0,

      'url' =>
        get_field(
          'publication_url'
        ) ?: '#',

      'category' =>
        get_field(
          'publication_category'
        ) ?: '',

    ];

  }

  wp_reset_postdata();

  return $publications;

}

/* ========================================
   LECTURER FALLBACK / MOCK DATA GENERATOR
======================================== */

function webjti_get_fallback_lecturer_data($default_id = 'default-1') {
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

  // Retrieve fallback lecturer details
  $all_lecturers = webjti_get_lecturers(['posts_per_page' => -1]);
  $current_idx = -1;
  foreach ($all_lecturers as $idx => $item) {
    if ($item['id'] === $default_id) {
      $lecturer = $item;
      $current_idx = $idx;
      break;
    }
  }

  if (!$lecturer && !empty($all_lecturers)) {
    $lecturer = $all_lecturers[0];
    $current_idx = 0;
    $default_id = $lecturer['id'];
  }

  if ($lecturer) {
    // Construct detailed mock profile fields
    $lecturer['position'] = $lecturer['title'] ?? 'Dosen';
    $lecturer['office_address'] = 'Ruang Dosen Jurusan Teknologi Informasi, Lantai 4 Gedung Sipil, POLINEMA';
    $lecturer['website'] = 'https://jti.polinema.ac.id';
    $lecturer['linkedin'] = 'https://linkedin.com';
    $lecturer['google_scholar'] = 'https://scholar.google.com';
    $lecturer['sinta'] = 'https://sinta.kemdikbud.go.id';
    $lecturer['email'] = strtolower(str_replace(' ', '', str_replace(',', '', explode('.', $lecturer['name'])[0]))) . '@polinema.ac.id';

    // 1. Education
    $educations = [
      [
        'degree' => 'S3 Doktor Teknik Informatika',
        'institution' => 'Shenyang Aerospace University',
        'start_year' => '2016',
        'end_year' => '2020',
      ],
      [
        'degree' => 'S2 Magister Engineering',
        'institution' => 'Institut Teknologi Bandung (ITB)',
        'start_year' => '2010',
        'end_year' => '2012',
      ],
      [
        'degree' => 'S1 Teknik Informatika',
        'institution' => 'Politeknik Negeri Malang (POLINEMA)',
        'start_year' => '2003',
        'end_year' => '2007',
      ]
    ];

    // 2. Certifications
    $certifications = [
      [
        'title' => 'Certified Big Data Professional (CBDP)',
        'institution' => 'IBM Corporation',
        'start_year' => '2022',
        'end_year' => '2025',
      ],
      [
        'title' => 'Oracle Certified Java Developer',
        'institution' => 'Oracle Corp.',
        'start_year' => '2019',
        'end_year' => '2022',
      ]
    ];

    // 3. Courses
    $courses = [
      'odd' => [
        'Pemrograman Web Lanjut',
        'Desain Antarmuka Pengguna (UI/UX)',
        'Kecerdasan Buatan (Artificial Intelligence)',
        'Analisis dan Desain Sistem'
      ],
      'even' => [
        'Sistem Pendukung Keputusan (DSS)',
        'Struktur Data & Algoritma',
        'Rekayasa Perangkat Lunak',
        'Metodologi Penelitian'
      ]
    ];

    // 4. Publications
    $publications = [
      [
        'title' => 'A Comprehensive Study on Decision Support System Algorithms for Student Academic Classification',
        'year' => 2023,
        'citations' => 38,
        'url' => 'https://scholar.google.com',
      ],
      [
        'title' => 'Implementation of Machine Learning and Predictive Analytics in Higher Education Risk Mitigation',
        'year' => 2022,
        'citations' => 29,
        'url' => 'https://scholar.google.com',
      ],
      [
        'title' => 'Design of Smart Learning Environments and Classroom Assistive Technologies based on IoT',
        'year' => 2021,
        'citations' => 17,
        'url' => 'https://scholar.google.com',
      ]
    ];

    // Dynamic cycling for Next & Prev fallback posts
    if ($current_idx !== -1 && !empty($all_lecturers)) {
      if ($current_idx > 0) {
        $prev_item = $all_lecturers[$current_idx - 1];
        $prev_name = $prev_item['name'];
        $prev_url = home_url('/?default_lecturer=' . $prev_item['id']);
      }
      if ($current_idx < count($all_lecturers) - 1) {
        $next_item = $all_lecturers[$current_idx + 1];
        $next_name = $next_item['name'];
        $next_url = home_url('/?default_lecturer=' . $next_item['id']);
      }
    }
  }

  return [
    'lecturer' => $lecturer,
    'educations' => $educations,
    'certifications' => $certifications,
    'courses' => $courses,
    'publications' => $publications,
    'prev_name' => $prev_name,
    'prev_url' => $prev_url,
    'next_name' => $next_name,
    'next_url' => $next_url,
  ];
}

/* ========================================
   PRESTASI (ACHIEVEMENT) HELPERS & FALLBACKS
======================================== */

/**
 * Helper to Get Ketua Tim Name from Anggota Prestasi
 */
function webjti_get_achievement_ketua($achievement_id) {
  $query = new WP_Query([
    'post_type'      => 'achievement_member',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => [
      'relation' => 'AND',
      [
        'key'     => 'prestasi',
        'value'   => $achievement_id,
        'compare' => '=',
      ],
      [
        'key'     => 'role',
        'value'   => 'ketua',
        'compare' => '=',
      ]
    ]
  ]);

  if (!$query->have_posts()) {
    $query = new WP_Query([
      'post_type'      => 'achievement_member',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
      'meta_query'     => [
        'relation' => 'AND',
        [
          'key'     => 'achievement',
          'value'   => $achievement_id,
          'compare' => '=',
        ],
        [
          'key'     => 'role',
          'value'   => 'ketua',
          'compare' => '=',
        ]
      ]
    ]);
  }

  $ketua_name = '-';
  $prodi_lbl = '-';
  $prodi_id = 0;

  if ($query->have_posts()) {
    $query->the_post();
    $ketua_name = get_field('member_name') ?: get_field('nama') ?: get_the_title();
    
    // Fetch study program (Prodi) from the member
    $study_program = get_field('study_program');
    if ($study_program) {
      if (is_object($study_program)) {
        $prodi_lbl = $study_program->post_title;
        $prodi_id = $study_program->ID;
      } elseif (is_numeric($study_program)) {
        $prodi_lbl = get_the_title($study_program);
        $prodi_id = $study_program;
      }
    }
  }
  wp_reset_postdata();

  return [
    'name' => $ketua_name,
    'prodi_lbl' => $prodi_lbl,
    'prodi_id' => $prodi_id
  ];
}

/**
 * Get Unique List of Achievement Years
 */
function webjti_get_achievement_years() {
  if (post_type_exists('achievement')) {
    $all_prestasi_ids = get_posts([
      'post_type'      => 'achievement',
      'post_status'    => 'publish',
      'posts_per_page' => -1,
      'fields'         => 'ids',
    ]);

    $tahun_list = [];
    foreach ($all_prestasi_ids as $post_id) {
      $tahun = get_field('achievement_year', $post_id) ?: get_field('tahun_prestasi', $post_id);
      if ($tahun) {
        $tahun_list[] = (string) $tahun;
      }
    }

    $tahun_list = array_unique($tahun_list);
    rsort($tahun_list);

    if (!empty($tahun_list)) {
      return $tahun_list;
    }
  }

  return ['2025', '2024', '2023'];
}

/**
 * Get Achievement Metrics (Total, Nasional, Internasional, PKM)
 */
function webjti_get_achievement_metrics() {
  if (post_type_exists('achievement')) {
    $query = new WP_Query([
      'post_type'      => 'achievement',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
    ]);

    if ($query->have_posts()) {
      $total = $query->post_count;
      $nasional = 0;
      $internasional = 0;
      $pkm = 0;

      while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        $level = get_field('level', $post_id) ?: get_field('tingkat', $post_id);
        $level = strtolower((string)$level);
        if ($level === 'nasional') {
          $nasional++;
        } elseif ($level === 'internasional') {
          $internasional++;
        }

        $is_pkm = get_field('is_pkm', $post_id);
        if ($is_pkm && ($is_pkm === '1' || $is_pkm === 1 || $is_pkm === true || strtolower((string)$is_pkm) === 'yes' || strtolower((string)$is_pkm) === 'true')) {
          $pkm++;
        }
      }
      wp_reset_postdata();

      return [
        'total'         => $total,
        'nasional'      => $nasional,
        'internasional' => $internasional,
        'pkm'           => $pkm,
      ];
    }
  }

  // Calculate from mock dataset fallback
  $result = webjti_get_achievements_list([], 1, 9999);
  $rows = $result['rows'];

  $total = count($rows);
  $nasional = 0;
  $internasional = 0;
  $pkm = 0;

  foreach ($rows as $r) {
    $tingkat = '';
    if (isset($r['tingkat_raw'])) {
      $tingkat = strtolower($r['tingkat_raw']);
    } elseif (isset($r['tingkat_class'])) {
      $tingkat = str_replace('tingkat-', '', $r['tingkat_class']);
    } else {
      $tingkat = strtolower($r['tingkat']);
    }

    if ($tingkat === 'nasional') {
      $nasional++;
    } elseif ($tingkat === 'internasional') {
      $internasional++;
    }

    if (!empty($r['is_pkm'])) {
      $pkm++;
    }
  }

  return [
    'total'         => $total,
    'nasional'      => $nasional,
    'internasional' => $internasional,
    'pkm'           => $pkm,
  ];
}

/**
 * Unified Helper to Get Achievements (DB or Fallback)
 */
function webjti_get_achievements_list($filters = [], $paged = 1, $posts_per_page = 10) {
  $has_posts = false;
  if (post_type_exists('achievement')) {
    $count_query = new WP_Query([
      'post_type'      => 'achievement',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
    ]);
    if ($count_query->have_posts()) {
      $has_posts = true;
    }
    wp_reset_postdata();
  }

  $f_prodi   = !empty($filters['prodi']) ? sanitize_text_field($filters['prodi']) : '';
  $f_tahun   = !empty($filters['tahun']) ? sanitize_text_field($filters['tahun']) : '';
  $f_juara   = !empty($filters['juara']) ? sanitize_text_field($filters['juara']) : '';
  $f_tingkat = !empty($filters['tingkat']) ? sanitize_text_field($filters['tingkat']) : '';
  $f_search  = !empty($filters['q']) ? sanitize_text_field($filters['q']) : (!empty($filters['s']) ? sanitize_text_field($filters['s']) : '');

  $prodi_labels = [];
  $study_programs_data = webjti_get_study_programs(-1);
  if (!empty($study_programs_data)) {
      foreach ($study_programs_data as $sp) {
          if (!empty($sp['id']) && $sp['id'] !== 0) {
              $label = $sp['title'];
              if (!empty($sp['badge'])) {
                  $label .= ' (' . $sp['badge'] . ')';
              }
              $slug = get_post_field('post_name', $sp['id']);
              $value = str_replace('-', '_', $slug);
              $prodi_labels[$value] = $label;
          }
      }
  }
  
  if (empty($prodi_labels)) {
      $prodi_labels = [
          'd2_ppls'                         => 'D2 Pengembangan Piranti Lunak Situs',
          'd3_mi_kediri'                    => 'D3 Manajemen Informatika (Kediri)',
          'd3_mi_lumajang'                  => 'D3 Manajemen Informatika (Lumajang)',
          'd4_teknik_informatika'           => 'D4 Teknik Informatika',
          'd4_sistem_informasi_bisnis'      => 'D4 Sistem Informasi Bisnis',
          's2_rekayasa_teknologi_informasi' => 'S2 Rekayasa Teknologi Informasi',
      ];
  }

  $juara_labels = [
    'juara_1'   => 'Juara 1',
    'juara_2'   => 'Juara 2',
    'juara_3'   => 'Juara 3',
    'harapan_1' => 'Harapan 1',
    'harapan_2' => 'Harapan 2',
    'finalis'   => 'Finalis',
  ];

  $tingkat_labels = [
    'internasional' => 'Internasional',
    'nasional'      => 'Nasional',
    'regional'      => 'Regional',
    'lokal'         => 'Lokal',
  ];

  if ($has_posts) {
    // Database Query
    $meta_query = ['relation' => 'AND'];

    if (!empty($f_prodi)) {
      $meta_query[] = [
        'key'     => 'program_studi',
        'value'   => $f_prodi,
        'compare' => '=',
      ];
    }
    if (!empty($f_tahun)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'achievement_year',
          'value'   => $f_tahun,
          'compare' => '=',
        ],
        [
          'key'     => 'tahun_prestasi',
          'value'   => $f_tahun,
          'compare' => '=',
        ]
      ];
    }
    if (!empty($f_juara)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'rank',
          'value'   => $f_juara,
          'compare' => '=',
        ],
        [
          'key'     => 'juara',
          'value'   => $f_juara,
          'compare' => '=',
        ]
      ];
    }
    if (!empty($f_tingkat)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'level',
          'value'   => $f_tingkat,
          'compare' => '=',
        ],
        [
          'key'     => 'tingkat',
          'value'   => $f_tingkat,
          'compare' => '=',
        ]
      ];
    }

    $args = [
      'post_type'      => 'achievement',
      'posts_per_page' => $posts_per_page,
      'paged'          => $paged,
      'post_status'    => 'publish',
    ];

    if (count($meta_query) > 1) {
      $args['meta_query'] = $meta_query;
    }
    if (!empty($f_search)) {
      $args['s'] = $f_search;
    }

    $query = new WP_Query($args);
    $rows = [];

    while ($query->have_posts()) {
      $query->the_post();

      $post_id     = get_the_ID();
      $ketua_details = webjti_get_achievement_ketua($post_id);
      $ketua_val   = $ketua_details['name'];

      $prodi_val   = get_field('program_studi', $post_id) ?: get_field('prodi', $post_id);
      $prodi_lbl   = '-';
      if ($prodi_val) {
        if (is_numeric($prodi_val)) {
          $prodi_lbl = get_the_title($prodi_val);
          $terms = get_the_terms($prodi_val, 'campus_label');
          if (!empty($terms) && !is_wp_error($terms)) {
            $prodi_lbl .= ' (' . $terms[0]->name . ')';
          }
        } elseif (is_object($prodi_val)) {
          $prodi_lbl = get_the_title($prodi_val->ID);
          $terms = get_the_terms($prodi_val->ID, 'campus_label');
          if (!empty($terms) && !is_wp_error($terms)) {
            $prodi_lbl .= ' (' . $terms[0]->name . ')';
          }
        } else {
          $prodi_lbl = isset($prodi_labels[$prodi_val]) ? $prodi_labels[$prodi_val] : $prodi_val;
        }
      } else {
        $prodi_lbl = $ketua_details['prodi_lbl'];
      }
      $judul_val   = get_field('judul_kompetisi', $post_id) ?: get_the_title($post_id);
      $tahun_val   = get_field('achievement_year', $post_id) ?: get_field('tahun_prestasi', $post_id) ?: '-';
      $juara_val   = get_field('rank', $post_id) ?: get_field('juara', $post_id) ?: '-';
      $juara_lbl   = isset($juara_labels[$juara_val]) ? $juara_labels[$juara_val] : $juara_val;
      $juara_cls   = str_replace('_', '-', $juara_val);
      $tingkat_val = get_field('level', $post_id) ?: get_field('tingkat', $post_id) ?: '-';
      $tingkat_lbl = isset($tingkat_labels[$tingkat_val]) ? $tingkat_labels[$tingkat_val] : $tingkat_val;
      $tingkat_cls = 'tingkat-' . $tingkat_val;
      $is_pkm      = get_field('is_pkm', $post_id) ? true : false;

      $rows[] = [
        'prodi'         => $prodi_lbl,
        'ketua'         => $ketua_val,
        'judul'         => $judul_val,
        'tahun'         => $tahun_val,
        'juara'         => $juara_lbl,
        'juara_class'   => $juara_cls,
        'tingkat'       => $tingkat_lbl,
        'tingkat_class' => $tingkat_cls,
        'url'           => get_permalink($post_id),
        'is_pkm'        => $is_pkm,
      ];
    }
    wp_reset_postdata();

    return [
      'rows'      => $rows,
      'max_pages' => $query->max_num_pages,
      'is_mock'   => false,
    ];
  }

  // Generate mock fallback achievements
  $mock_data = [
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Evan Carlisle',
      'judul'       => 'InnovateTech Challenge 2024: Pioneering the Future of Technology and Innovation',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Liam Thornton',
      'judul'       => 'The Ultimate Coding Challenge: Test Your Skills and Push Your Limits',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Jasper Quinn',
      'judul'       => 'Innovators Hackathon: A Creative Challenge to Transform Ideas into Reality',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Nina Caldwell',
      'judul'       => 'Annual Creative Writing Contest for Aspiring Authors',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Owen Mercer',
      'judul'       => 'Innovative Tech Startup Pitch Competition',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Zara Whitman',
      'judul'       => 'Exciting Photography Showdown and Exhibition',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Maya Ellison',
      'judul'       => 'Worldwide Creative Sprint Contest: A Global Event Showcasing Innovative Ideas and Rapid Prototyping',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Maya Ellison',
      'judul'       => 'Global Innovation Design Sprint Event: An International Gathering to Accelerate Creative Solutions and Design Thinking',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_kediri',
      'prodi'       => 'D3 Manajemen Informatika (Kediri)',
      'ketua'       => 'Leo Vance',
      'judul'       => 'East Java Web Development Competency Cup',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_lumajang',
      'prodi'       => 'D3 Manajemen Informatika (Lumajang)',
      'ketua'       => 'Sophia Rivers',
      'judul'       => 'Lumajang Smart City Hackathon & Digital Transformation',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd2_ppls',
      'prodi'       => 'D2 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Marcus Brody',
      'judul'       => 'Polinema Internal UI/UX Competition and Creative Showcase',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'lokal',
      'tingkat'     => 'Lokal',
      'tingkat_class' => 'tingkat-lokal',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 's2_rekayasa_teknologi_informasi',
      'prodi'       => 'S2 Rekayasa Teknologi Informasi',
      'ketua'       => 'Elena Rostova',
      'judul'       => 'International Conference on Applied IT: Best Paper and Presentation Award',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Lucas Thorne',
      'judul'       => 'National Cyber Security Capture The Flag Competition',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Chloe Vance',
      'judul'       => 'Business Plan Competition at Universitas Brawijaya',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Ethan Hunt',
      'judul'       => 'Indonesian Robot Contest: Autonomous Division Championship',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_kediri',
      'prodi'       => 'D3 Manajemen Informatika (Kediri)',
      'ketua'       => 'Natasha Romanoff',
      'judul'       => 'National Mobile App Innovation Showcase',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 's2_rekayasa_teknologi_informasi',
      'prodi'       => 'S2 Rekayasa Teknologi Informasi',
      'ketua'       => 'Bruce Banner',
      'judul'       => 'IEEE Big Data Analytics Challenge: Predictive Modeling Category',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Tony Stark',
      'judul'       => 'Global AI Hackathon: Generative Agents Division Grand Prize',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd2_ppls',
      'prodi'       => 'D2 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Steve Rogers',
      'judul'       => 'Polinema Web Design Competition: Modern Web Showcase',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'lokal',
      'tingkat'     => 'Lokal',
      'tingkat_class' => 'tingkat-lokal',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd3_mi_lumajang',
      'prodi'       => 'D3 Manajemen Informatika (Lumajang)',
      'ketua'       => 'Peter Parker',
      'judul'       => 'Jember Game Development Expo: Indie Game Showcase',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ]
  ];

  // Dynamically set fallback URLs default-1 to default-N matching the exact row index
  foreach ($mock_data as $i => &$item) {
    $mock_index = $i + 1;
    $item['url'] = home_url('/?default_achievement=default-' . $mock_index);
  }
  unset($item);

  // Perform in-memory PHP filtering
  $filtered = [];
  foreach ($mock_data as $item) {
    if (!empty($f_prodi) && $item['prodi_raw'] !== $f_prodi) {
      continue;
    }
    if (!empty($f_tahun) && $item['tahun'] !== $f_tahun) {
      continue;
    }
    if (!empty($f_juara) && $item['juara_raw'] !== $f_juara) {
      continue;
    }
    if (!empty($f_tingkat) && $item['tingkat_raw'] !== $f_tingkat) {
      continue;
    }

    if (!empty($f_search)) {
      $match = false;
      if (stripos($item['judul'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['ketua'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['tahun'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['prodi'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['juara'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['tingkat'], $f_search) !== false) {
        $match = true;
      }
      if (!$match) {
        continue;
      }
    }

    $filtered[] = $item;
  }

  // In-memory pagination
  $total_count = count($filtered);
  $max_pages = ceil($total_count / $posts_per_page);
  $max_pages = $max_pages > 0 ? $max_pages : 1;

  $start_index = ($paged - 1) * $posts_per_page;
  $paginated_rows = array_slice($filtered, $start_index, $posts_per_page);

  return [
    'rows'      => $paginated_rows,
    'max_pages' => $max_pages,
    'is_mock'   => true,
  ];
}

function webjti_get_achievement_badges($post_id = null, $achievement = null) {
  $juara_labels = [
    'juara_1'   => 'Juara 1',
    'juara_2'   => 'Juara 2',
    'juara_3'   => 'Juara 3',
    'harapan_1' => 'Harapan 1',
    'harapan_2' => 'Harapan 2',
    'finalis'   => 'Finalis',
  ];

  $tingkat_labels = [
    'internasional' => 'Internasional',
    'nasional'      => 'Nasional',
    'regional'      => 'Regional',
    'lokal'         => 'Lokal',
  ];

  if ($achievement) {
    $tahun_val = $achievement['tahun_prestasi'] ?? '-';
    $juara_val = $achievement['juara'] ?? '-';
    $tingkat_val = $achievement['tingkat'] ?? '-';
  } else {
    $post_id = $post_id ?: get_the_ID();
    $tahun_val = get_field('achievement_year', $post_id) ?: get_field('tahun_prestasi', $post_id) ?: '-';
    $juara_val = get_field('rank', $post_id) ?: get_field('juara', $post_id) ?: '-';
    $tingkat_val = get_field('level', $post_id) ?: get_field('tingkat', $post_id) ?: '-';
  }

  $juara_lbl = $juara_labels[$juara_val] ?? $juara_val;
  $juara_cls = $juara_val === '-' ? '' : str_replace('_', '-', $juara_val);

  $tingkat_lbl = $tingkat_labels[$tingkat_val] ?? $tingkat_val;
  $tingkat_cls = $tingkat_val === '-' ? '' : 'tingkat-' . $tingkat_val;

  return [
    'tahun'         => $tahun_val,
    'juara'         => $juara_lbl,
    'juara_class'   => $juara_cls,
    'tingkat'       => $tingkat_lbl,
    'tingkat_class' => $tingkat_cls,
  ];
}

/* ========================================
   GET FILTERED INFORMATION (NEWS, ANNOUNCEMENT, EVENT)
======================================== */

function webjti_get_filtered_information($type = 'all', $search = '', $paged = 1, $posts_per_page = 6) {
  $type = strtolower($type);
  $search = trim($search);
  
  $meta_query = [];
  if ($type !== 'all' && $type !== 'semua' && !empty($type)) {
    $category_map = [
      'berita' => ['news', 'berita'],
      'pengumuman' => ['announcement', 'pengumuman'],
      'agenda' => ['event', 'agenda']
    ];
    $acf_value = $category_map[$type] ?? [$type];
    $meta_query[] = [
      'key' => 'category',
      'value' => $acf_value,
      'compare' => 'IN'
    ];
  }
  
  $args = [
    'post_type' => 'information',
    'posts_per_page' => -1, // Query all to handle fallback combination in memory
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
  ];
  
  if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
  }
  
  if (!empty($search)) {
    $args['s'] = $search;
  }
  
  $query = new WP_Query($args);
  $real_posts = [];
  
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $real_posts[] = webjti_format_news_post();
    }
    wp_reset_postdata();
  }
  
  // Decide whether to merge with defaults/fallbacks
  $show_defaults = empty($real_posts) && !get_theme_mod('jti_disable_default_posts');
  $all_posts = $real_posts;
  
  if ($show_defaults) {
    // 12 Premium high-fidelity default posts
    $default_posts = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => '20 Mei 2026',
        'reading_time' => '5 min',
        'excerpt'   => 'Selamat datang di website resmi Jurusan Teknologi Informasi Politeknik Negeri Malang.'
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.jpg',
        'date'      => '19 Mei 2026',
        'reading_time' => '3 min',
        'excerpt'   => 'Informasi mengenai pelaksanaan registrasi ulang mahasiswa untuk semester ganjil mendatang.'
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => '18 Mei 2026',
        'reading_time' => '6 min',
        'excerpt'   => 'Jurusan Teknologi Informasi menyelenggarakan workshop kurikulum bersama para pakar industri.'
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.jpg',
        'date'      => '17 Mei 2026',
        'reading_time' => '4 min',
        'excerpt'   => 'Telah dibuka penerimaan mahasiswa baru jalur kelas kerja sama industri untuk tahun ajaran ini.'
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.jpg',
        'date'      => '16 Mei 2026',
        'reading_time' => '7 min',
        'excerpt'   => 'Prestasi membanggakan kembali diraih oleh JTI di tingkat nasional sebagai jurusan berkinerja terbaik.'
      ],
      [
        'id'        => 'default-6',
        'title'     => 'PLAY IT 2026 Secara Resmi Dibuka dengan Antusiasme yang Luar Biasa',
        'permalink' => home_url('/?default_info=default-6'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Event tahunan PLAY IT 2026 resmi dibuka dengan berbagai rangkaian kegiatan menarik seperti hackathon dan seminar.'
      ],
      [
        'id'        => 'default-7',
        'title'     => 'JTI Memperkenalkan Program Inovasi Lingkungan Baru',
        'permalink' => home_url('/?default_info=default-7'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'JTI meluncurkan inisiatif kampus hijau terbaru untuk mengurangi emisi karbon di seluruh gedung perkuliahan.'
      ],
      [
        'id'        => 'default-8',
        'title'     => 'Mahasiswa JTI Gelar Pengabdian Masyarakat di Desa',
        'permalink' => home_url('/?default_info=default-8'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Program kerja bakti mahasiswa JTI membantu pembangunan infrastruktur digital di desa-desa terpencil.'
      ],
      [
        'id'        => 'default-9',
        'title'     => 'Dosen JTI Publikasikan Penelitian di Jurnal Internasional',
        'permalink' => home_url('/?default_info=default-9'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Penelitian inovatif dosen JTI mengenai integrasi AI dan IoT diakui di kancah ilmiah internasional.'
      ],
      [
        'id'        => 'default-10',
        'title'     => 'Mahasiswa JTI Adakan Workshop Teknologi untuk Pelajar Kota',
        'permalink' => home_url('/?default_info=default-10'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Workshop coding gratis diselenggarakan untuk pelajar SMA guna mengenalkan dasar-dasar pemrograman.'
      ],
      [
        'id'        => 'default-11',
        'title'     => 'PLAY IT 2026 Resmi Dibuka dengan Antusiasme Tinggi',
        'permalink' => home_url('/?default_info=default-11'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Ratusan peserta dari seluruh Indonesia berkumpul untuk bersaing di ajang hackathon PLAY IT 2026.'
      ],
      [
        'id'        => 'default-12',
        'title'     => 'JTI Menyelenggarakan Hackathon Tingkat Nasional',
        'permalink' => home_url('/?default_info=default-12'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => '14 April 2026',
        'reading_time' => '9 min',
        'excerpt'   => 'Kompetisi hackathon bergengsi dengan total hadiah puluhan juta rupiah resmi dibuka untuk mahasiswa aktif.'
      ],
    ];
    
    // Filter defaults in PHP memory
    $filtered_defaults = [];
    foreach ($default_posts as $dp) {
      // Check category match
      if ($type !== 'all' && $type !== 'semua' && !empty($type)) {
        if (strtolower($dp['category']) !== strtolower($type)) {
          continue;
        }
      }
      
      // Check search match
      if (!empty($search)) {
        $match = false;
        if (stripos($dp['title'], $search) !== false) {
          $match = true;
        }
        if (stripos($dp['excerpt'], $search) !== false) {
          $match = true;
        }
        if (!$match) {
          continue;
        }
      }
      
      $filtered_defaults[] = $dp;
    }
    
    // Combine real posts and default posts (avoiding duplicates if title is identical)
    $real_titles = array_map('strtolower', array_column($real_posts, 'title'));
    foreach ($filtered_defaults as $fd) {
      if (!in_array(strtolower($fd['title']), $real_titles)) {
        $all_posts[] = $fd;
      }
    }
  }
  
  // Paginate the combined posts
  $total_count = count($all_posts);
  $max_pages = ceil($total_count / $posts_per_page);
  $max_pages = $max_pages > 0 ? $max_pages : 1;
  
  $start_index = ($paged - 1) * $posts_per_page;
  $paginated_posts = array_slice($all_posts, $start_index, $posts_per_page);
  
  return [
    'posts' => $paginated_posts,
    'max_pages' => $max_pages,
    'total_posts' => $total_count,
  ];
}

/* ========================================
   GET FALLBACK ACHIEVEMENT DATA
   ======================================== */
function webjti_get_fallback_achievement_data($default_id = 'default-1') {
  $mock_items = [
    1 => ['ketua' => 'Evan Carlisle', 'judul' => 'InnovateTech Challenge 2024: Pioneering the Future of Technology and Innovation', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'D4 Pengembangan Piranti Lunak Situs', 'is_pkm' => false],
    2 => ['ketua' => 'Liam Thornton', 'judul' => 'The Ultimate Coding Challenge: Test Your Skills and Push Your Limits', 'tahun' => '2025', 'juara' => 'juara_2', 'tingkat' => 'internasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    3 => ['ketua' => 'Jasper Quinn', 'judul' => 'Innovators Hackathon: A Creative Challenge to Transform Ideas into Reality', 'tahun' => '2023', 'juara' => 'juara_3', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    4 => ['ketua' => 'Nina Caldwell', 'judul' => 'Annual Creative Writing Contest for Aspiring Authors', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => true],
    5 => ['ketua' => 'Owen Mercer', 'judul' => 'Innovative Tech Startup Pitch Competition', 'tahun' => '2024', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    6 => ['ketua' => 'Zara Whitman', 'judul' => 'Exciting Photography Showdown and Exhibition', 'tahun' => '2025', 'juara' => 'juara_2', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => true],
    7 => ['ketua' => 'Maya Ellison', 'judul' => 'Worldwide Creative Sprint Contest: A Global Event Showcasing Innovative Ideas and Rapid Prototyping', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    8 => ['ketua' => 'Maya Ellison', 'judul' => 'Global Innovation Design Sprint Event: An International Gathering to Accelerate Creative Solutions and Design Thinking', 'tahun' => '2025', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    9 => ['ketua' => 'Leo Vance', 'judul' => 'East Java Web Development Competency Cup', 'tahun' => '2024', 'juara' => 'juara_2', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Kediri)', 'is_pkm' => false],
    10 => ['ketua' => 'Sophia Rivers', 'judul' => 'Lumajang Smart City Hackathon & Digital Transformation', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Lumajang)', 'is_pkm' => false],
    11 => ['ketua' => 'Marcus Brody', 'judul' => 'Polinema Internal UI/UX Competition and Creative Showcase', 'tahun' => '2023', 'juara' => 'juara_3', 'tingkat' => 'lokal', 'prodi' => 'D2 Pengembangan Piranti Lunak Situs', 'is_pkm' => false],
    12 => ['ketua' => 'Elena Rostova', 'judul' => 'International Conference on Applied IT: Best Paper and Presentation Award', 'tahun' => '2025', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'S2 Rekayasa Teknologi Informasi', 'is_pkm' => false],
    13 => ['ketua' => 'Lucas Thorne', 'judul' => 'National Cyber Security Capture The Flag Competition', 'tahun' => '2024', 'juara' => 'juara_2', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    14 => ['ketua' => 'Chloe Vance', 'judul' => 'Business Plan Competition at Universitas Brawijaya', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'regional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    15 => ['ketua' => 'Ethan Hunt', 'judul' => 'Indonesian Robot Contest: Autonomous Division Championship', 'tahun' => '2025', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    16 => ['ketua' => 'Natasha Romanoff', 'judul' => 'National Mobile App Innovation Showcase', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D3 Manajemen Informatika (Kediri)', 'is_pkm' => false],
    17 => ['ketua' => 'Bruce Banner', 'judul' => 'IEEE Big Data Analytics Challenge: Predictive Modeling Category', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'S2 Rekayasa Teknologi Informasi', 'is_pkm' => false],
    18 => ['ketua' => 'Tony Stark', 'judul' => 'Global AI Hackathon: Generative Agents Division Grand Prize', 'tahun' => '2025', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => true],
    19 => ['ketua' => 'Steve Rogers', 'judul' => 'Polinema Web Design Competition: Modern Web Showcase', 'tahun' => '2023', 'juara' => 'juara_2', 'tingkat' => 'lokal', 'prodi' => 'D2 Pengembangan Piranti Lunak Situs', 'is_pkm' => true],
    20 => ['ketua' => 'Peter Parker', 'judul' => 'Jember Game Development Expo: Indie Game Showcase', 'tahun' => '2024', 'juara' => 'juara_3', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Lumajang)', 'is_pkm' => false],
  ];

  $index = 1;
  if (preg_match('/default-(\d+)/', $default_id, $matches)) {
    $index = intval($matches[1]);
  }
  if (!isset($mock_items[$index])) {
    $index = 1;
  }
  $item = $mock_items[$index];

  $cover_image_index = (($index - 1) % 5) + 1;
  $gallery = [
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . $cover_image_index . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index) % 5) + 1) . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index + 1) % 5) + 1) . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index + 2) % 5) + 1) . '.png']
  ];

  $fallback = [
    'id' => 'default-' . $index,
    'judul_kompetisi' => $item['judul'],
    'juara' => $item['juara'],
    'tingkat' => $item['tingkat'],
    'tanggal' => '20 Mei ' . $item['tahun'],
    'tahun_prestasi' => $item['tahun'],
    'penyelenggara' => 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',
    'lokasi' => 'Politeknik Negeri Malang',
    'bidang' => $item['is_pkm'] ? 'Program Kreativitas Mahasiswa (PKM)' : 'Rekayasa Perangkat Lunak & IT',
    'jumlah_peserta' => '150+ Tim Seluruh Indonesia',
    'deskripsi' => 'Prestasi membanggakan kembali dipersembahkan oleh mahasiswa Jurusan Teknologi Informasi Politeknik Negeri Malang. Dalam ajang bergengsi ' . $item['judul'] . ', tim berhasil bersaing ketat dengan ratusan universitas terkemuka lainnya dan dinobatkan sebagai penerima penghargaan juara. Solusi inovatif yang ditawarkan berhasil menarik perhatian dewan juri.',
    'gallery' => $gallery,
  ];

  // Cycle the placeholders based on index to make them look realistic
  $pembimbing_photo = ($index % 2 === 0) ? 'pak yoga.png' : 'bu mungki.png';
  $pembimbing_name  = ($index % 2 === 0) ? 'Hariyady, S.Kom., M.T.' : 'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.';
  
  $ketua_photo = ($index % 2 === 0) ? 'bu devi.png' : 'pak hendra.png';
  
  $anggota_1_photo = ($index % 2 === 0) ? 'bu ana.png' : 'bu devi.png';
  $anggota_1_name  = ($index % 2 === 0) ? 'Sarah Connor' : 'Nina Caldwell';
  
  $anggota_2_photo = ($index % 2 === 0) ? 'bu mungki.png' : 'bu ana.png';
  $anggota_2_name  = ($index % 2 === 0) ? 'Chloe Vance' : 'Zara Whitman';

  $members = [
    // 1. Dosen Pembimbing (Top row left/right)
    [
      'name' => $pembimbing_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $pembimbing_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'pembimbing',
      'role_label' => 'Dosen Pembimbing',
      'identifier' => 'NIP: 198001012005011' . str_pad($index, 3, '0', STR_PAD_LEFT)
    ],
    // 2. Ketua Tim (Top row left/right)
    [
      'name' => $item['ketua'],
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $ketua_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'ketua',
      'role_label' => 'Ketua Tim',
      'identifier' => 'NIM: 2141720' . str_pad($index, 3, '0', STR_PAD_LEFT)
    ],
    // 3. Anggota Tim 1 (Bottom row)
    [
      'name' => $anggota_1_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $anggota_1_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'anggota_1',
      'role_label' => 'Anggota Tim',
      'identifier' => 'NIM: 2141762025'
    ],
    // 4. Anggota Tim 2 (Bottom row)
    [
      'name' => $anggota_2_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $anggota_2_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'anggota_2',
      'role_label' => 'Anggota Tim',
      'identifier' => 'NIM: 2141762026'
    ]
  ];

  $related = [];
  $next_1 = ($index % 20) + 1;
  $next_2 = (($index + 1) % 20) + 1;

  foreach ([$next_1, $next_2] as $idx) {
    if (isset($mock_items[$idx])) {
      $r_item = $mock_items[$idx];
      $related[] = [
        'id' => 'default-' . $idx,
        'url' => home_url('/?default_achievement=default-' . $idx),
        'title' => $r_item['judul'],
        'excerpt' => 'Prestasi tingkat ' . ucfirst($r_item['tingkat']) . ' yang diraih oleh tim yang diketuai oleh ' . $r_item['ketua'] . ' pada tahun ' . $r_item['tahun'] . '.',
        'date' => '20 Mei ' . $r_item['tahun'],
        'image' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . (($idx % 5) + 1) . '.png'
      ];
    }
  }

  return [
    'achievement' => $fallback,
    'members' => $members,
    'gallery' => $gallery,
    'related' => $related
  ];
}

/* ========================================
   GET FALLBACK INFORMATION DATA
   ======================================== */
function webjti_get_fallback_information_data($default_id = 'default-1') {
  $defaults = [
      'default-1' => [
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.jpg',
        'date'      => '20 Mei 2026',
        'reading_time' => '5',
        'content'   => '
            <p class="lead">Selamat datang di website resmi Jurusan Teknologi Informasi (JTI) Politeknik Negeri Malang. Sebagai salah satu pilar utama pendidikan vokasi teknologi di Indonesia, JTI berkomitmen untuk mencetak lulusan yang tidak hanya unggul secara akademis, namun juga memiliki kesiapan kerja yang matang dalam menghadapi gelombang transformasi digital global saat ini.</p>
            
            <h2>Visi & Misi Pengembangan</h2>
            <p>JTI POLINEMA memegang teguh komitmen untuk menjadi pusat pendidikan vokasi di bidang teknologi informasi yang diakui secara nasional maupun internasional. Kami mengintegrasikan kurikulum berbasis kompetensi yang dirancang selaras dengan kebutuhan nyata dunia usaha dan dunia industri (DUDI).</p>
            
            <blockquote>
                "Inovasi tiada henti adalah kunci utama kami. Di JTI, mahasiswa dibimbing untuk tidak sekadar menjadi pengguna teknologi, melainkan kreator dan inovator yang mampu memberikan solusi nyata atas kompleksitas permasalahan industri."
                <cite>— Kepala Jurusan Teknologi Informasi POLINEMA</cite>
            </blockquote>
            
            <h2>Program Studi Unggulan Kami</h2>
            <p>Untuk menunjang akselerasi karier mahasiswa di sektor teknologi, kami menyelenggarakan beberapa program studi sarjana terapan (D4) yang telah terakreditasi sangat baik, di antaranya:</p>
            <ul>
                <li><strong>D4 Teknik Informatika:</strong> Berfokus pada pengembangan rekayasa perangkat lunak skala enterprise, kecerdasan buatan (AI), keamanan siber, dan komputasi awan (Cloud Computing).</li>
                <li><strong>D4 Sistem Informasi Bisnis:</strong> Memadukan keahlian analitis teknologi informasi dengan strategi manajemen bisnis modern untuk menghasilkan analis sistem dan technopreneur andal.</li>
                <li><strong>D2 Fast Track (Jalur Cepat):</strong> Program akselerasi yang dirancang khusus bersinergi erat dengan Sekolah Menengah Kejuruan (SMK) mitra untuk menghasilkan asisten desainer perangkat lunak dalam waktu singkat.</li>
            </ul>

            <h2>Fasilitas Laboratorium Modern</h2>
            <p>Proses pembelajaran praktis didukung penuh oleh keberadaan belasan laboratorium komputer berspesifikasi tinggi yang disesuaikan dengan fokus keahlian masing-masing bidang minat:</p>
            <ol>
                <li><strong>Laboratorium Database & Enterprise:</strong> Tempat eksplorasi administrasi basis data skala besar dan arsitektur enterprise.</li>
                <li><strong>Laboratorium Jaringan & Keamanan Siber:</strong> Difasilitasi perangkat Cisco premium untuk pembelajaran routing, switching, dan pertahanan siber.</li>
                <li><strong>Laboratorium Game & Mobile Apps:</strong> Laboratorium khusus pengembangan game multi-platform dan aplikasi mobile native.</li>
            </ol>
            
            <p>Melalui sinergi erat kurikulum berkualitas, fasilitas mutakhir, serta dukungan dosen praktisi tersertifikasi internasional, JTI POLINEMA siap memandu langkah Anda menuju masa depan cemerlang di industri teknologi informasi dunia.</p>
        '
      ],
      'default-2' => [
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.jpg',
        'date'      => '19 Mei 2026',
        'reading_time' => '3',
        'content'   => '
            <p class="lead">Diberitahukan kepada seluruh mahasiswa aktif Jurusan Teknologi Informasi Politeknik Negeri Malang bahwa pelaksanaan proses administrasi dan daftar ulang akademik untuk Semester Ganjil Tahun Ajaran 2026/2027 akan segera dibuka. Proses ini wajib diselesaikan secara tertib sesuai lini masa yang ditetapkan.</p>
            
            <h2>Alur Proses Registrasi Ulang</h2>
            <p>Untuk mempermudah administrasi Anda, proses daftar ulang dibagi menjadi tiga tahapan utama yang terintegrasi secara daring (online):</p>
            <ol>
                <li><strong>Validasi Data Mahasiswa:</strong> Lakukan login pada Sistem Informasi Akademik (SIAKAD) POLINEMA dan pastikan seluruh data profil, alamat, serta riwayat akademis Anda sudah terbarui dengan benar.</li>
                <li><strong>Pembayaran Uang Kuliah Tunggal (UKT):</strong> Lakukan pembayaran tagihan semester ganjil melalui bank mitra resmi (Bank Mandiri, BRI, BNI, atau BTN) menggunakan nomor induk mahasiswa (NIM) sebagai kode pembayaran.</li>
                <li><strong>Unggah Bukti & Persetujuan KRS:</strong> Unggah bukti transfer pembayaran UKT ke sistem SIAKAD untuk membuka akses pengisian Kartu Rencana Studi (KRS). Segera hubungi Dosen Pembina Akademik (DPA) Anda untuk melakukan bimbingan rencana kelas dan menyetujui KRS Anda.</li>
            </ol>
            
            <blockquote>
                <strong>PENTING:</strong> Kelalaian atau keterlambatan dalam melakukan registrasi ulang tanpa pemberitahuan resmi dan dispensasi tertulis dari pihak jurusan dapat menyebabkan status akademik mahasiswa dinonaktifkan secara otomatis untuk semester berjalan.
            </blockquote>
            
            <h2>Dokumen Syarat Wajib</h2>
            <p>Pastikan Anda telah memindai (scan) beberapa berkas berikut untuk diunggah dalam format PDF dengan ukuran maksimal 1MB:</p>
            <ul>
                <li>Kartu Tanda Mahasiswa (KTM) aktif.</li>
                <li>Slip/Bukti Pembayaran UKT Semester Ganjil asli dari bank.</li>
                <li>Kartu Hasil Studi (KHS) Semester Genap sebelumnya yang telah ditandatangani DPA.</li>
            </ul>
            
            <p>Pertanyaan lebih lanjut mengenai kendala teknis pembayaran atau sistem SIAKAD dapat ditanyakan langsung ke loket Administrasi Jurusan JTI pada jam kerja operasional (Senin s.d. Jumat pukul 08.00 - 15.30 WIB).</p>
        '
      ],
      'default-3' => [
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.jpg',
        'date'      => '18 Mei 2026',
        'reading_time' => '6',
        'content'   => '
            <p class="lead">Dalam rangka meningkatkan relevansi lulusan dengan perkembangan industri digital yang sangat dinamis, Jurusan Teknologi Informasi menyelenggarakan Workshop Tahunan Revitalisasi Kurikulum. Agenda penting ini mempertemukan jajaran akademisi internal dengan belasan praktisi serta pimpinan teknologi (CTO) dari berbagai perusahaan terkemuka tanah air.</p>
            
            <h2>Tujuan Utama Sinkronisasi</h2>
            <p>Kegiatan ini difokuskan pada perancangan kurikulum berbasis <em>Project-Based Learning</em> (PBL). Model ini memungkinkan mahasiswa belajar memecahkan studi kasus riil yang dialami oleh mitra industri langsung di dalam ruang kelas dengan bimbingan dosen dan mentor industri terkait.</p>
            
            <blockquote>
                "Kesenjangan kompetensi (skill gap) antara dunia kampus dan industri harus terus ditekan. Kurikulum baru JTI ini dirancang sangat fleksibel, mengadopsi tren teknologi terkini seperti AI Engineering, Cloud DevOps, dan Data Analytics."
                <cite>— Direktur Teknologi (CTO) Perusahaan Teknologi Finansial Mitra JTI</cite>
            </blockquote>
            
            <h2>Topik Pembahasan Strategis</h2>
            <p>Terdapat tiga pilar utama yang dibahas secara intensif dalam sesi diskusi kelompok terpumpun (FGD) workshop kali ini:</p>
            <ul>
                <li><strong>Integrasi Kecerdasan Buatan (AI):</strong> Penyusunan silabus pemograman dasar dan lanjut yang mulai menyisipkan metodologi prompt engineering serta pemanfaatan LLM secara bijak dan etis.</li>
                <li><strong>Standarisasi Cloud Computing:</strong> Kesepakatan penyelarasan materi praktikum jaringan dengan sertifikasi global seperti AWS Academy dan Google Cloud Education.</li>
                <li><strong>Metodologi Agile & Scrum:</strong> Penerapan simulasi kerja tim Scrum pada tugas proyek akhir mahasiswa untuk membiasakan mereka dengan workflow kolaborasi industri modern.</li>
            </ul>
            
            <h2>Rangkaian Lini Masa Agenda</h2>
            <p>Workshop kurikulum ini berlangsung secara hibrida selama dua hari penuh:</p>
            <ol>
                <li><strong>Hari ke-1 (Sesi Panel Utama):</strong> Pemaparan tren serapan industri kerja oleh kementerian terkait dan presentasi masukan dari dewan penasihat industri JTI.</li>
                <li><strong>Hari ke-2 (FGD Paralel Program Studi):</strong> Pemecahan forum ke dalam masing-masing prodi untuk merevisi daftar mata kuliah, deskripsi silabus, dan instrumen penilaian proyek mahasiswa.</li>
            </ol>
            
            <p>Hasil dari revitalisasi kurikulum ini diharapkan dapat diimplementasikan sepenuhnya mulai tahun akademik ajaran baru semester ganjil mendatang demi melahirkan talenta digital yang siap berkontribusi langsung sejak hari pertama bekerja.</p>
        '
      ],
      'default-4' => [
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.jpg',
        'date'      => '17 Mei 2026',
        'reading_time' => '4',
        'content'   => '
            <p class="lead">Kabar gembira bagi para calon mahasiswa baru! Jurusan Teknologi Informasi Politeknik Negeri Malang resmi membuka seleksi penerimaan mahasiswa baru jalur khusus kelas kerja sama industri. Program ini dirancang strategis untuk memberikan jaminan pengalaman kerja nyata dan kesempatan magang eksklusif di perusahaan raksasa multinasional.</p>
            
            <h2>Mengapa Memilih Kelas Kerja Sama?</h2>
            <p>Berbeda dengan kelas reguler pada umumnya, mahasiswa kelas kerja sama industri akan mendapatkan kurikulum khusus yang disusun bersama oleh tim JTI POLINEMA dan pimpinan tim engineering perusahaan mitra. Selain itu, mentor-mentor teknis dari industri akan terlibat langsung mengajar beberapa sesi kelas praktikum.</p>
            
            <blockquote>
                "Program kelas kerja sama ini adalah jalur ekspres berkarir di industri tech. Mahasiswa tidak hanya belajar teori, tetapi langsung magang berbayar dan berkesempatan direkrut langsung begitu lulus tanpa melalui proses seleksi umum yang panjang."
                <cite>— VP of Talent Acquisition Mitra Korporat JTI</cite>
            </blockquote>
            
            <h2>Mitra Perusahaan Unggulan</h2>
            <p>Pada periode penerimaan tahun ini, JTI membuka kelas khusus yang berkolaborasi erat dengan beberapa institusi terpercaya:</p>
            <ul>
                <li><strong>Korporasi Telekomunikasi Nasional:</strong> Berfokus pada keahlian infrastruktur jaringan seluler 5G, keamanan siber, dan IoT skala kota pintar.</li>
                <li><strong>Penyedia Layanan Cloud Global:</strong> Pembelajaran mendalam berstandar kurikulum internasional dengan spesialisasi arsitektur cloud server dan virtualisasi data.</li>
                <li><strong>Software House Multinasional:</strong> Berfokus pada akselerasi Full-stack Web Development dan rekayasa perangkat lunak kualitas produksi.</li>
            </ul>

            <h2>Syarat dan Alur Pendaftaran</h2>
            <p>Prosedur pendaftaran dapat dilakukan dengan mudah melalui portal seleksi PMB POLINEMA:</p>
            <ol>
                <li><strong>Pendaftaran Online:</strong> Isi formulir lengkap dan unggah nilai rapor semester 1 s.d 5 di situs resmi pendaftaran.</li>
                <li><strong>Ujian Tulis Berbasis Komputer:</strong> Mengikuti tes potensi akademik (TPA), logika pemograman dasar, dan tes kemampuan bahasa Inggris secara mandiri.</li>
                <li><strong>Wawancara User Industri:</strong> Calon mahasiswa yang lolos tes tulis akan diwawancarai langsung oleh perwakilan dari perusahaan mitra terkait kecocokan minat serta motivasi belajar.</li>
            </ol>
            
            <p>Segera daftarkan diri Anda dan raih kesempatan emas belajar langsung dari pakar industri terbaik serta bangun pondasi karier global Anda bersama kelas kerja sama JTI POLINEMA!</p>
        '
      ],
      'default-5' => [
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.jpg',
        'date'      => '16 Mei 2026',
        'reading_time' => '7',
        'content'   => '
            <p class="lead">Prestasi gemilang kembali ditorehkan oleh segenap civitas akademika Jurusan Teknologi Informasi POLINEMA. JTI secara resmi dinobatkan sebagai "Jurusan Kinerja Akademik Terbaik Tahun Ini" dalam malam penganugerahan Dies Natalis Politeknik Negeri Malang atas kontribusi luar biasa dalam riset terapan dan penyerapan lulusan industri tertinggi.</p>
            
            <h2>Kriteria Utama Penilaian</h2>
            <p>Penghargaan bergengsi ini diraih setelah melalui rangkaian penilaian ketat oleh dewan juri independen yang mengukur kinerja seluruh jurusan di lingkungan kampus. Terdapat beberapa parameter keunggulan mutlak yang berhasil dipenuhi oleh JTI:</p>
            
            <blockquote>
                "Penghargaan ini adalah buah manis dari kerja keras, dedikasi, serta kolaborasi harmonis seluruh dosen, staf kependidikan, serta mahasiswa JTI yang tiada henti berkreasi dan menembus batas prestasi di berbagai ajang nasional."
                <cite>— Sekretaris Jurusan Teknologi Informasi POLINEMA</cite>
            </blockquote>
            
            <h2>Pilar Keunggulan JTI</h2>
            <p>Beberapa poin emas yang melatarbelakangi penganugerahan penghargaan terbaik ini di antaranya:</p>
            <ul>
                <li><strong>Penyerapan Kerja Tercepat:</strong> Berdasarkan data pelacakan lulusan terbaru (tracer study), lebih dari 88% lulusan JTI berhasil mendapatkan pekerjaan layak di sektor teknologi dalam kurun waktu kurang dari 3 bulan pasca kelulusan.</li>
                <li><strong>Riset Terapan Berskala Nasional:</strong> Keberhasilan para dosen JTI memperoleh hibah penelitian kompetitif nasional untuk pengembangan sistem cerdas pertanian presisi dan e-government daerah.</li>
                <li><strong>Prestasi Mahasiswa Internasional:</strong> Kemenangan beruntun tim mahasiswa JTI dalam kompetisi inovasi perangkat lunak tingkat Asia Pasifik dan kompetisi siber nasional.</li>
            </ul>

            <h2>Komitmen Masa Depan</h2>
            <p>Piala penghargaan ini tidak membuat JTI berpuas diri. Justru pencapaian ini dipandang sebagai pemacu semangat untuk terus meningkatkan mutu tridharma perguruan tinggi:</p>
            <ol>
                <li><strong>Peningkatan Kualitas Jurnal:</strong> Menargetkan peningkatan publikasi riset terapan di jurnal bereputasi tinggi Scopus Q1 dan Q2.</li>
                <li><strong>Perluasan Kerja Sama Global:</strong> Menjajaki program gelar ganda (double degree) baru dengan universitas sains terapan terkemuka di Eropa dan Asia Timur.</li>
                <li><strong>Sertifikasi Mahasiswa Internasional:</strong> Memberikan fasilitas subsidi penuh bagi mahasiswa berprestasi untuk mengambil sertifikasi kompetensi industri global (RedHat, Oracle, AWS).</li>
            </ol>
            
            <p>Segenap jajaran pimpinan JTI mengucapkan terima kasih sebesar-besarnya kepada seluruh elemen pendukung, mitra industri, orang tua mahasiswa, serta alumni atas kepercayaan yang senantiasa diberikan demi bersama-sama mewujudkan JTI POLINEMA yang unggul dan mendunia.</p>
        '
      ],
  ];

  if (array_key_exists($default_id, $defaults)) {
    return $defaults[$default_id];
  }
  return $defaults['default-1'];
}

/**
 * Get Dedications (Pengabdian Kepada Masyarakat) grouped by execution year
 *
 * @param array $args Optional query arguments
 * @return array Multi-dimensional array grouped by year
 */
function webjti_get_dedications($args = []) {
  $defaults = [
    'post_type'      => 'dedication',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value',
    'meta_key'       => 'year',
    'order'          => 'DESC',
  ];

  $query_args = wp_parse_args($args, $defaults);
  $query = new WP_Query($query_args);

  $dedications_by_year = [];

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $post_id = get_the_ID();

      $year = get_field('year', $post_id) ?: get_the_date('Y', $post_id);
      $title = get_the_title($post_id);

      // Resolve Leader (Ketua)
      $leader_raw = get_field('leader', $post_id);
      $leader_name = '-';
      if (!empty($leader_raw)) {
        if (is_object($leader_raw)) {
          $leader_name = $leader_raw->post_title;
        } elseif (is_numeric($leader_raw)) {
          $leader_name = get_the_title($leader_raw);
        } elseif (is_array($leader_raw) && isset($leader_raw['post_title'])) {
          $leader_name = $leader_raw['post_title'];
        } elseif (is_array($leader_raw)) {
          $leader_name = implode(', ', array_filter(array_map('trim', $leader_raw)));
        } elseif (is_string($leader_raw)) {
          $leader_name = trim($leader_raw);
        }
      }

      // Resolve Members (Anggota - excluding leader)
      $members_raw = get_field('members', $post_id);
      $members = [];
      if (!empty($members_raw)) {
        if (is_string($members_raw)) {
          // Split multiline or comma-separated string input
          $members_list = preg_split('/[\r\n,]+/', $members_raw);
        } elseif (is_array($members_raw)) {
          $members_list = $members_raw;
        } else {
          $members_list = [$members_raw];
        }

        foreach ($members_list as $m_item) {
          $m_name = '';
          if (is_object($m_item)) {
            $m_name = $m_item->post_title;
          } elseif (is_numeric($m_item)) {
            $m_name = get_the_title($m_item);
          } elseif (is_array($m_item)) {
            $m_name = $m_item['post_title'] ?? $m_item['name'] ?? $m_item['member_name'] ?? (is_string(reset($m_item)) ? reset($m_item) : '');
          } elseif (is_string($m_item)) {
            $m_name = $m_item;
          }

          $m_name = trim($m_name);
          if (!empty($m_name) && strcasecmp($m_name, trim($leader_name)) !== 0) {
            $members[] = $m_name;
          }
        }
      }

      // Resolve Study Program
      $sp_raw = get_field('study_program', $post_id);
      $study_program = 'D4 Teknik Informatika';
      if ($sp_raw) {
        if (is_object($sp_raw)) {
          $study_program = $sp_raw->post_title;
        } elseif (is_numeric($sp_raw)) {
          $study_program = get_the_title($sp_raw);
        } elseif (is_array($sp_raw) && isset($sp_raw['post_title'])) {
          $study_program = $sp_raw['post_title'];
        }
      }

      // Resolve Scheme (Skema)
      $scheme_raw = get_field('scheme', $post_id);
      $scheme = 'Pengabdian Hibah Internal';
      if ($scheme_raw) {
        if (is_object($scheme_raw)) {
          $scheme = $scheme_raw->post_title;
        } elseif (is_numeric($scheme_raw)) {
          $scheme = get_the_title($scheme_raw);
        } elseif (is_array($scheme_raw) && isset($scheme_raw['post_title'])) {
          $scheme = $scheme_raw['post_title'];
        }
      }

      $dedications_by_year[$year][] = [
        'id'            => $post_id,
        'year'          => $year,
        'title'         => $title,
        'leader'        => $leader_name,
        'members'       => $members,
        'study_program' => $study_program,
        'scheme'        => $scheme,
      ];
    }
    wp_reset_postdata();
  }

  // Fallback data if no CPT entries exist in database yet
  if (empty($dedications_by_year)) {
    $dedications_by_year = [
      '2025' => [
        [
          'id'            => 101,
          'year'          => '2025',
          'title'         => 'Penerapan Sistem IoT Smart Farming & Monitoring Cuaca untuk Kelompok Tani Desa Batu',
          'leader'        => 'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.',
          'members'       => [
            'Dwi Puspitasari, S.Kom., M.Kom.',
            'Usman Nurhasan, S.Kom., M.T.',
            'Jasmin Kusumawati, S.T., M.T.',
            'Imam Fahrur Rozi, S.T., M.T.',
            'Vivin Nur Hafifah, S.P., M.P.',
          ],
          'study_program' => 'D4 Teknik Informatika',
          'scheme'        => 'Pengabdian Hibah Unggulan Internal POLINEMA',
        ],
        [
          'id'            => 102,
          'year'          => '2025',
          'title'         => 'Pendampingan Digitalisasi UMKM Batik Melalui E-Commerce & Payment Gateway System',
          'leader'        => 'Dwi Puspitasari, S.Kom., M.Kom.',
          'members'       => [
            'Ariadi Retno Tri Hayati, S.T., M.T.',
            'M. Nurudin, S.ST., M.T.',
            'Rudy Ariyanto, S.ST., M.T.',
            'Indra Khatulistiwa, S.T., M.Kom.',
          ],
          'study_program' => 'D4 Sistem Informasi Bisnis',
          'scheme'        => 'Pengabdian Kemitraan UMKM Berkelanjutan',
        ],
        [
          'id'            => 103,
          'year'          => '2025',
          'title'         => 'Pelatihan Cyber Security Awareness dan Pengamanan Data Publik bagi Aparat Desa Malang',
          'leader'        => 'Usman Nurhasan, S.Kom., M.T.',
          'members'       => [
            'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.',
            'Syahroni Wahyu Iriananda, S.T., M.T.',
            'Atiqah Nurul Asri, S.Pd., M.Pd.',
            'Hendra Pradibta, S.E., M.Sc.',
            'Eka Larasati Amalia, S.ST., M.T.',
          ],
          'study_program' => 'D4 Teknik Informatika',
          'scheme'        => 'Pengabdian Masyarakat Mandiri Terapan',
        ],
      ],
      '2024' => [
        [
          'id'            => 201,
          'year'          => '2024',
          'title'         => 'Pengembangan Sistem Manajemen Inventaris Koperasi Desa Berbasis Mobile Apps',
          'leader'        => 'Imam Fahrur Rozi, S.T., M.T.',
          'members'       => [
            'Septian Enggar Sukmana, S.Pd., M.MT.',
            'Mustika Mentari, S.Kom., M.Kom.',
            'Ade Ismail, S.Kom., M.TI.',
            'M. Naufal, S.ST., M.Kom.',
          ],
          'study_program' => 'D3 Manajemen Informatika',
          'scheme'        => 'Pengabdian Hibah Reguler POLINEMA',
        ],
        [
          'id'            => 202,
          'year'          => '2024',
          'title'         => 'Edukasi Etika Penggunaan AI & Prompt Engineering bagi Guru SMA/SMK se-Kota Malang',
          'leader'        => 'Jasmin Kusumawati, S.T., M.T.',
          'members'       => [
            'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.',
            'Dwi Puspitasari, S.Kom., M.Kom.',
            'Luqman Affandi, S.Kom., M.M.',
            'Kusnadi, S.T., M.T.',
            'Anisah, S.T., M.T.',
            'Farid Angga Pribadi, S.Kom., M.Kom.',
          ],
          'study_program' => 'D4 Teknik Informatika',
          'scheme'        => 'Pengabdian Kemitraan Sekolah Menengah',
        ],
        [
          'id'            => 203,
          'year'          => '2024',
          'title'         => 'Implementasi Website Desa Wisata Terpadu & Virtual Tour 360 Derajat di Kabupaten Pasuruan',
          'leader'        => 'Rudy Ariyanto, S.ST., M.T.',
          'members'       => [
            'Ariadi Retno Tri Hayati, S.T., M.T.',
            'M. Nurudin, S.ST., M.T.',
            'Eka Larasati Amalia, S.ST., M.T.',
            'Hendra Pradibta, S.E., M.Sc.',
          ],
          'study_program' => 'D4 Sistem Informasi Bisnis',
          'scheme'        => 'Pengabdian Kolaborasi Nasional',
        ],
      ],
      '2023' => [
        [
          'id'            => 301,
          'year'          => '2023',
          'title'         => 'Pelatihan Literasi Digital & Pengelolaan Media Sosial Promosi UMKM Kerajinan Tangan',
          'leader'        => 'Ariadi Retno Tri Hayati, S.T., M.T.',
          'members'       => [
            'Dwi Puspitasari, S.Kom., M.Kom.',
            'Imam Fahrur Rozi, S.T., M.T.',
            'Syahroni Wahyu Iriananda, S.T., M.T.',
            'Vivin Nur Hafifah, S.P., M.P.',
            'Mustika Mentari, S.Kom., M.Kom.',
          ],
          'study_program' => 'D4 Sistem Informasi Bisnis',
          'scheme'        => 'Pengabdian Masyarakat Mandiri Terapan',
        ],
        [
          'id'            => 302,
          'year'          => '2023',
          'title'         => 'Perancangan Sistem Rekam Medis Digital Berbasis Web untuk Puskesmas Pembantu',
          'leader'        => 'Syahroni Wahyu Iriananda, S.T., M.T.',
          'members'       => [
            'Usman Nurhasan, S.Kom., M.T.',
            'Septian Enggar Sukmana, S.Pd., M.MT.',
            'M. Nurudin, S.ST., M.T.',
            'Kusnadi, S.T., M.T.',
          ],
          'study_program' => 'D4 Teknik Informatika',
          'scheme'        => 'Pengabdian Hibah Reguler POLINEMA',
        ],
      ],
    ];
  }

  // Ensure descending order by year
  krsort($dedications_by_year);

  return $dedications_by_year;
}

/**
 * Get Laboratories for Penelitian Preview Page
 * Supports dynamic CPT queries and rich fallback cards for JTI Laboratories.
 *
 * @param array $args
 * @return array
 */
function webjti_get_laboratories($args = []) {
  $query_args = wp_parse_args($args, [
    'post_type'      => 'laboratory',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
  ]);

  $query = new WP_Query($query_args);
  $labs = [];

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $post_id = get_the_ID();

      // Head of Lab
      $head_obj = get_field('lab_head', $post_id);
      $head_name = '-';
      $head_photo = '';
      $head_sinta = 'https://sinta.kemdikbud.go.id';

      if (!empty($head_obj)) {
        if (is_object($head_obj)) {
          $head_id = $head_obj->ID;
          $head_name = $head_obj->post_title;
        } else {
          $head_id = (int)$head_obj;
          $head_name = get_the_title($head_id);
        }
        $head_photo = get_the_post_thumbnail_url($head_id, 'thumbnail');
        $head_sinta_field = get_field('sinta', $head_id);
        if ($head_sinta_field) {
          $head_sinta = $head_sinta_field;
        }
      }

      // Members count
      $members = get_field('lab_members', $post_id);
      $member_count = is_array($members) ? count($members) : 0;
      if ($member_count === 0) {
        $member_count = rand(6, 12);
      }

      // Research Focus (CPT + Taxonomy fallback)
      $focus_tags = [];
      
      // Get from CPT (Use get_posts to avoid overriding global $post in loop)
      $cpt_focus_posts = get_posts([
        'post_type'      => 'lab_focus',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
          [
            'key'     => 'related_lab',
            'value'   => $post_id,
            'compare' => '=',
          ],
        ],
      ]);
      if (!empty($cpt_focus_posts)) {
        foreach ($cpt_focus_posts as $f_post) {
          $focus_tags[] = get_the_title($f_post->ID);
        }
      }
      
      // Merge from taxonomy
      $rf_terms = get_the_terms($post_id, 'research_focus');
      if (!empty($rf_terms) && !is_wp_error($rf_terms)) {
        foreach ($rf_terms as $term) {
          $focus_tags[] = $term->name;
        }
      }
      $focus_tags = array_unique($focus_tags);

      // Logo & Custom Icon
      $logo = get_field('logo', $post_id);
      if (!$logo) {
        $logo = get_the_post_thumbnail_url($post_id, 'medium');
      }

      $custom_icon = get_field('sidebar_icon', $post_id) ?: get_field('lab_icon', $post_id) ?: get_field('icon', $post_id);

      $lab_title = get_the_title($post_id);

      $labs[] = [
        'id'                => $post_id,
        'code'              => get_field('lab_code', $post_id) ?: strtoupper(substr($lab_title, 0, 4)),
        'title'             => $lab_title,
        'short_description' => get_field('short_description', $post_id) ?: get_the_excerpt($post_id),
        'logo'              => $logo,
        'icon'              => $custom_icon,
        'head_name'         => $head_name,
        'head_photo'        => $head_photo ?: webjti_get_lecturer_placeholder_photo($head_name, $post_id),
        'head_sinta_url'    => $head_sinta,
        'member_count'      => $member_count,
        'research_focus'    => $focus_tags,
        'room_location'     => get_field('room_location', $post_id) ?: 'Gedung JTI Polinema',
        'website_url'       => get_field('lab_website_url', $post_id),
        'permalink'         => get_permalink($post_id),
      ];
    }
    wp_reset_postdata();
  }

  // Fallback data if no laboratory CPT posts exist
  if (empty($labs)) {
    $labs = [
      [
        'id'                => 1,
        'code'              => 'NSC',
        'title'             => 'Laboratorium Jaringan dan Keamanan Siber (NSC)',
        'short_description' => 'Fokus pada riset keamanan infrastruktur jaringan, audit sistem keamanan, cloud security, penetration testing, dan analisis malware.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-nsc.svg',
        'head_name'         => 'Mungki Puspitasari, S.Kom., M.Kom.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Mungki Puspitasari, S.Kom., M.Kom.', 1),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701234',
        'member_count'      => 8,
        'research_focus'    => ['Cyber Security', 'Network Infrastructure', 'Cloud Security', 'Ethical Hacking'],
        'room_location'     => 'Gedung Sipil Lt. 4',
        'permalink'         => home_url('/lab-nsc'),
      ],
      [
        'id'                => 2,
        'code'              => 'RPL',
        'title'             => 'Laboratorium Rekayasa Perangkat Lunak (RPL)',
        'short_description' => 'Mengembangkan penelitian metode rekayasa perangkat lunak modern, arsitektur microservices, DevOps, dan kualitas perangkat lunak.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-rpl.svg',
        'head_name'         => 'Didik Dwi Prasetya, S.T., M.T.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Didik Dwi Prasetya, S.T., M.T.', 2),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701235',
        'member_count'      => 12,
        'research_focus'    => ['Software Architecture', 'DevOps & CI/CD', 'Web & Mobile Dev', 'Agile Engineering'],
        'room_location'     => 'Gedung Sipil Lt. 4',
        'permalink'         => home_url('/lab-rpl'),
      ],
      [
        'id'                => 3,
        'code'              => 'IVSS',
        'title'             => 'Laboratorium Visi Cerdas dan Sistem Cerdas (IVSS)',
        'short_description' => 'Riset komputasi cerdas, Computer Vision, Deep Learning, pengenalan pola, dan otomatisasi berbasis kecerdasan buatan.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-ivss.svg',
        'head_name'         => 'Bambang Hariadi, S.Kom., M.T.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Bambang Hariadi, S.Kom., M.T.', 3),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701236',
        'member_count'      => 10,
        'research_focus'    => ['Artificial Intelligence', 'Computer Vision', 'Deep Learning', 'Pattern Recognition'],
        'room_location'     => 'Gedung JTI Lt. 3',
        'permalink'         => home_url('/lab-ivss'),
      ],
      [
        'id'                => 4,
        'code'              => 'InLET',
        'title'             => 'Information and Learning Engineering Technology Laboratory (InLET)',
        'short_description' => 'Inovasi teknologi pembelajaran digital, Educational Technology, E-Learning Platforms, dan Smart Learning Analytics.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-inlet.svg',
        'head_name'         => 'Fitri Rahmawati, S.ST., M.Eng.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Fitri Rahmawati, S.ST., M.Eng.', 4),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701237',
        'member_count'      => 7,
        'research_focus'    => ['EdTech', 'Learning Analytics', 'E-Learning', 'Adaptive Learning'],
        'room_location'     => 'Gedung JTI Lt. 3',
        'permalink'         => home_url('/lab-inlet'),
      ],
      [
        'id'                => 5,
        'code'              => 'BA',
        'title'             => 'Laboratorium Analisa Bisnis (BA)',
        'short_description' => 'Analisis proses bisnis enterprise, Enterprise Resource Planning (ERP), Business Process Management, dan Digital Transformation.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-ba.svg',
        'head_name'         => 'Ariadi Retno Tri Hayati, S.T., M.T.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Ariadi Retno Tri Hayati, S.T., M.T.', 5),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701238',
        'member_count'      => 9,
        'research_focus'    => ['Business Intelligence', 'ERP Systems', 'Business Process Analytics', 'Digital Strategy'],
        'room_location'     => 'Gedung Sipil Lt. 3',
        'permalink'         => home_url('/lab-ba'),
      ],
      [
        'id'                => 6,
        'code'              => 'DT',
        'title'             => 'Laboratorium Teknologi Data (DT)',
        'short_description' => 'Riset Big Data Analytics, Data Mining, Natural Language Processing (NLP), Data Warehouse, dan Knowledge Graph.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-dt.svg',
        'head_name'         => 'Usman Nurhasan, S.Kom., M.T.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Usman Nurhasan, S.Kom., M.T.', 6),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701239',
        'member_count'      => 11,
        'research_focus'    => ['Big Data', 'Data Mining', 'Natural Language Processing', 'Data Engineering'],
        'room_location'     => 'Gedung JTI Lt. 4',
        'permalink'         => home_url('/lab-dt'),
      ],
      [
        'id'                => 7,
        'code'              => 'MMT',
        'title'             => 'Laboratorium Multimedia dan Perangkat Bergerak (MMT)',
        'short_description' => 'Pengembangan teknologi Augmented/Virtual Reality (AR/VR), game development, aplikasi mobile lintas platform, dan desain UI/UX.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-mmt.svg',
        'head_name'         => 'Septian Enggar Sukmana, S.Pd., M.MT.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Septian Enggar Sukmana, S.Pd., M.MT.', 7),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701240',
        'member_count'      => 9,
        'research_focus'    => ['AR/VR', 'Mobile App Development', 'Game Tech', 'UI/UX Design'],
        'room_location'     => 'Gedung JTI Lt. 4',
        'permalink'         => home_url('/lab-mmt'),
      ],
      [
        'id'                => 8,
        'code'              => 'IS',
        'title'             => 'Laboratorium Informatika Terapan (IS)',
        'short_description' => 'Penerapan teknologi informasi untuk solusi industri, Internet of Things (IoT), Embedded Systems, dan Smart City.',
        'logo'              => get_template_directory_uri() . '/assets/images/placeholder/lab-is.svg',
        'head_name'         => 'Achmad Budi Setiawan, S.T., M.Cs.',
        'head_photo'        => webjti_get_lecturer_placeholder_photo('Achmad Budi Setiawan, S.T., M.Cs.', 8),
        'head_sinta_url'    => 'https://sinta.kemdikbud.go.id/authors/profile/6701241',
        'member_count'      => 8,
        'research_focus'    => ['Internet of Things', 'Embedded Systems', 'Smart Agriculture', 'Applied IT'],
        'room_location'     => 'Gedung Sipil Lt. 3',
        'permalink'         => home_url('/lab-is'),
      ],
    ];
  }

  return $labs;
}

/**
 * Match a text string to a published CPT laboratory post ID
 */
function webjti_match_laboratory_post_by_string($text) {
    if (empty($text) || !is_string($text)) return 0;

    $labs = get_posts([
        'post_type'      => 'laboratory',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);

    if (empty($labs)) return 0;

    $clean_text = strtolower(trim($text));

    foreach ($labs as $lab) {
        $title = strtolower($lab->post_title);
        $code  = strtolower(function_exists('get_field') ? (get_field('lab_code', $lab->ID) ?: '') : '');

        if ($title === $clean_text || (!empty($code) && $code === $clean_text)) {
            return $lab->ID;
        }

        if (!empty($code) && strpos($clean_text, $code) !== false) {
            return $lab->ID;
        }

        if (strpos($clean_text, $title) !== false || strpos($title, $clean_text) !== false) {
            return $lab->ID;
        }
    }

    return 0;
}

/**
 * Smart resolver to get Laboratory name for a given lecturer.
 * Handles fallback for legacy text data and reverse lookup in CPT laboratory.
 */
function webjti_get_lecturer_laboratory_name($lecturer_id) {
    if (!$lecturer_id) return '-';

    // 1. Direct ACF field (post_object ID or post object)
    $lab_field = function_exists('get_field') ? (get_field('laboratory', $lecturer_id) ?: get_field('laboratorium', $lecturer_id)) : get_post_meta($lecturer_id, 'laboratory', true);
    if (!empty($lab_field)) {
        if (is_numeric($lab_field) && (int)$lab_field > 0) {
            $title = get_the_title((int)$lab_field);
            if (!empty($title)) return $title;
        } elseif (is_object($lab_field) && isset($lab_field->post_title)) {
            return $lab_field->post_title;
        } elseif (is_array($lab_field) && isset($lab_field[0])) {
            $first = $lab_field[0];
            if (is_object($first) && isset($first->post_title)) return $first->post_title;
            if (is_numeric($first)) return get_the_title((int)$first);
        }
    }

    // 2. Reverse lookup in CPT laboratory (if lecturer is Head or Member of a lab)
    if (function_exists('webjti_find_lecturer_lab_assignment')) {
        $lab_title = webjti_find_lecturer_lab_assignment($lecturer_id);
        if (!empty($lab_title) && $lab_title !== __('another laboratory', 'webjti')) {
            return $lab_title;
        }
    }

    // 3. Legacy text meta check & fuzzy matching
    $legacy_string = get_post_meta($lecturer_id, 'laboratorium', true) ?: get_post_meta($lecturer_id, 'laboratory', true);
    if (!empty($legacy_string) && is_string($legacy_string) && !is_numeric($legacy_string)) {
        $matched_lab_id = webjti_match_laboratory_post_by_string($legacy_string);
        if ($matched_lab_id > 0) {
            return get_the_title($matched_lab_id);
        }
        return $legacy_string;
    }

    return '-';
}

/**
 * Smart resolver to get Laboratory permalink / URL for a given lecturer.
 */
function webjti_get_lecturer_laboratory_url($lecturer_id) {
    if (!$lecturer_id) return '';

    // 1. Direct ACF field (post_object ID or post object)
    $lab_field = function_exists('get_field') ? (get_field('laboratory', $lecturer_id) ?: get_field('laboratorium', $lecturer_id)) : get_post_meta($lecturer_id, 'laboratory', true);
    if (!empty($lab_field)) {
        if (is_numeric($lab_field) && (int)$lab_field > 0) {
            $link = get_permalink((int)$lab_field);
            if ($link) return $link;
        } elseif (is_object($lab_field) && isset($lab_field->ID)) {
            $link = get_permalink($lab_field->ID);
            if ($link) return $link;
        }
    }

    // 2. Reverse lookup in CPT laboratory
    $lab_posts = get_posts([
        'post_type'      => 'laboratory',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);
    foreach ($lab_posts as $l_id) {
        $head = function_exists('get_field') ? get_field('lab_head', $l_id) : 0;
        $h_id = is_object($head) ? $head->ID : (int)$head;
        if ($h_id === (int)$lecturer_id) {
            return get_permalink($l_id);
        }

        $members = function_exists('get_field') ? get_field('lab_members', $l_id) : [];
        if (!empty($members) && is_array($members)) {
            foreach ($members as $m) {
                $m_id = is_object($m) ? $m->ID : (int)$m;
                if ($m_id === (int)$lecturer_id) {
                    return get_permalink($l_id);
                }
            }
        }
    }

    // 3. Match by name
    $lab_name = webjti_get_lecturer_laboratory_name($lecturer_id);
    $matched_id = webjti_match_laboratory_post_by_string($lab_name);
    if ($matched_id > 0) {
        return get_permalink($matched_id);
    }

    return '';
}

/**
 * Bidirectional Sync & Automatic Migration Hook for Lecturers and Laboratories
 */
add_action('save_post', function($post_id, $post, $update) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!$post || $post->post_status === 'auto-draft' || $post->post_type === 'revision') return;

    if ($post->post_type === 'laboratory') {
        $head = function_exists('get_field') ? get_field('lab_head', $post_id) : 0;
        if ($head) {
            $head_id = is_object($head) ? $head->ID : (int)$head;
            if ($head_id > 0) {
                if (function_exists('update_field')) {
                    update_field('laboratory', $post_id, $head_id);
                }
                update_post_meta($head_id, 'laboratory', $post_id);
                update_post_meta($head_id, 'laboratorium', $post_id);
            }
        }

        $members = function_exists('get_field') ? get_field('lab_members', $post_id) : [];
        if (!empty($members) && is_array($members)) {
            foreach ($members as $m) {
                $m_id = is_object($m) ? $m->ID : (int)$m;
                if ($m_id > 0) {
                    if (function_exists('update_field')) {
                        update_field('laboratory', $post_id, $m_id);
                    }
                    update_post_meta($m_id, 'laboratory', $post_id);
                    update_post_meta($m_id, 'laboratorium', $post_id);
                }
            }
        }
    }

    if ($post->post_type === 'lecturer') {
        $lab_val = function_exists('get_field') ? (get_field('laboratory', $post_id) ?: get_field('laboratorium', $post_id)) : get_post_meta($post_id, 'laboratory', true);

        if (empty($lab_val) || (!is_numeric($lab_val) && is_string($lab_val))) {
            $resolved_lab_title = webjti_get_lecturer_laboratory_name($post_id);
            $matched_id = webjti_match_laboratory_post_by_string($resolved_lab_title);
            if ($matched_id > 0) {
                if (function_exists('update_field')) {
                    update_field('laboratory', $matched_id, $post_id);
                }
                update_post_meta($post_id, 'laboratory', $matched_id);
                update_post_meta($post_id, 'laboratorium', $matched_id);
            }
        } elseif (is_numeric($lab_val) && (int)$lab_val > 0) {
            update_post_meta($post_id, 'laboratory', (int)$lab_val);
            update_post_meta($post_id, 'laboratorium', (int)$lab_val);
        }
    }
}, 25, 3);

/**
 * Auto Migration Routine: Sync all existing lecturer posts with CPT laboratory IDs
 */
add_action('admin_init', function() {
    if (get_option('webjti_lecturer_lab_migration_v2')) return;

    $lecturers = get_posts([
        'post_type'      => 'lecturer',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ]);

    if (!empty($lecturers)) {
        foreach ($lecturers as $lec) {
            $lec_id = $lec->ID;
            $lab_val = get_post_meta($lec_id, 'laboratory', true) ?: get_post_meta($lec_id, 'laboratorium', true);

            if (empty($lab_val) || !is_numeric($lab_val)) {
                $lab_name = webjti_get_lecturer_laboratory_name($lec_id);
                $matched_id = webjti_match_laboratory_post_by_string($lab_name);
                if ($matched_id > 0) {
                    if (function_exists('update_field')) {
                        update_field('laboratory', $matched_id, $lec_id);
                    }
                    update_post_meta($lec_id, 'laboratory', $matched_id);
                    update_post_meta($lec_id, 'laboratorium', $matched_id);
                }
            }
        }
    }

    update_option('webjti_lecturer_lab_migration_v2', 1);
});

/**
 * Get filtered career programs
 *
 * @param string $type
 * @param string $search
 * @param int $paged
 * @param int $posts_per_page
 * @return array
 */
function webjti_get_filtered_career($type = 'all', $search = '', $paged = 1, $posts_per_page = 9) {
    $args = [
        'post_type'      => 'career_program',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    if ($type !== 'all' && !empty($type)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'career_category',
                'field'    => 'slug',
                'terms'    => $type
            ]
        ];
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);

    $posts = [];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            
            $terms = wp_get_post_terms($post_id, 'career_category', ['fields' => 'names']);
            $category_name = !empty($terms) && !is_wp_error($terms) ? $terms[0] : '';

            $posts[] = [
                'id'       => $post_id,
                'title'    => get_the_title(),
                'url'      => get_permalink(),
                'image'    => get_the_post_thumbnail_url($post_id, 'large'),
                'excerpt'  => wp_trim_words(get_the_excerpt(), 15),
                'date'     => webjti_field('career_date', $post_id, get_the_date('d F Y')),
                'location' => webjti_field('career_location', $post_id, '-'),
                'category' => $category_name,
            ];
        }
        wp_reset_postdata();
    }

    return [
        'posts'         => $posts,
        'max_pages'     => $query->max_num_pages,
        'total_posts'   => $query->found_posts,
        'current_page'  => $paged
    ];
}
