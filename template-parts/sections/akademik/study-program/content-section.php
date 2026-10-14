<?php
/**
 * Dynamic Akademik Content Section - Study Program
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wp, $post;

$page_id = 0;
$program_slug = '';
$program_post = null;
$has_acf = function_exists('get_field');

// 1. Resolve requested path / slug from URL
$request_uri = isset($wp->request) && !empty($wp->request) ? $wp->request : trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
if (strpos($request_uri, 'index.php/') === 0) {
    $request_uri = substr($request_uri, 10);
}
$request_uri = trim($request_uri, '/');
$slug_parts = explode('/', $request_uri);
$url_slug = end($slug_parts);

$slug_aliases = [
    'sarjana-terapan-teknik-informatika' => 'd4-teknik-informatika',
    'sarjana-terapan-sistem-informasi-bisnis' => 'd4-sistem-informasi-bisnis',
    'magister-terapan-rekayasa-teknologi-informasi' => 's2-rekayasa-teknologi-informasi',
];
$lookup_slug = $slug_aliases[$url_slug] ?? $url_slug;

// 2. Identify the study program post
if (is_singular('study_program') || (isset($post) && $post instanceof WP_Post && $post->post_type === 'study_program')) {
    $program_post = $post;
    $page_id = $post->ID;
    $program_slug = $post->post_name;
} else {
    // Try finding the study_program post by slug or path
    $maybe_post = get_page_by_path($lookup_slug, OBJECT, 'study_program');
    if (!$maybe_post && $lookup_slug !== $url_slug) {
        $maybe_post = get_page_by_path($url_slug, OBJECT, 'study_program');
    }

    if (!$maybe_post) {
        $found = get_posts([
            'post_type'      => 'study_program',
            'name'           => $lookup_slug,
            'post_status'    => ['publish', 'draft', 'pending', 'private'],
            'posts_per_page' => 1,
        ]);
        if (!empty($found)) {
            $maybe_post = $found[0];
        }
    }

    // If still not found, try title matching
    if (!$maybe_post) {
        $title_mappings = [
            'd4-teknik-informatika' => ['D4 Teknik Informatika', 'Sarjana Terapan Teknik Informatika', 'Teknik Informatika'],
            'd4-sistem-informasi-bisnis' => ['D4 Sistem Informasi Bisnis', 'Sarjana Terapan Sistem Informasi Bisnis', 'Sistem Informasi Bisnis'],
            's2-rekayasa-teknologi-informasi' => ['S2 Rekayasa Teknologi Informasi', 'Magister Terapan Rekayasa Teknologi Informasi', 'Rekayasa Teknologi Informasi'],
            'd3-mi-kediri' => ['D3 Manajemen Informatika Kediri', 'D3 MI Kediri', 'Manajemen Informatika Kediri'],
            'd3-mi-lumajang' => ['D3 Manajemen Informatika Lumajang', 'D3 MI Lumajang', 'Manajemen Informatika Lumajang'],
            'd2-piranti-lunak' => ['D2 Pengembangan Piranti Lunak Situs', 'D2 Piranti Lunak', 'Piranti Lunak Situs'],
        ];

        if (isset($title_mappings[$lookup_slug])) {
            $all_programs = get_posts([
                'post_type'      => 'study_program',
                'post_status'    => ['publish', 'draft', 'pending', 'private'],
                'posts_per_page' => -1,
            ]);

            foreach ($all_programs as $p) {
                foreach ($title_mappings[$lookup_slug] as $keyword) {
                    if (stripos($p->post_title, $keyword) !== false) {
                        $maybe_post = $p;
                        break 2;
                    }
                }
            }
        }
    }

    if ($maybe_post) {
        $program_post = $maybe_post;
        $page_id = absint($maybe_post->ID);
        $program_slug = $maybe_post->post_name;
    } else {
        $page_id = absint(get_the_ID());
        $program_slug = $lookup_slug;
    }
}

// 3. Determine Program Title
$akademik_titles = [
    'd2-piranti-lunak'                => 'D2 Pengembangan Piranti Lunak Situs',
    'd3-mi-kediri'                    => 'D3 Manajemen Informatika (Kediri)',
    'd3-mi-lumajang'                  => 'D3 Manajemen Informatika (Lumajang)',
    'd4-teknik-informatika'           => 'D4 Teknik Informatika',
    'sarjana-terapan-teknik-informatika' => 'Sarjana Terapan Teknik Informatika',
    'd4-sistem-informasi-bisnis'      => 'D4 Sistem Informasi Bisnis',
    'sarjana-terapan-sistem-informasi-bisnis' => 'Sarjana Terapan Sistem Informasi Bisnis',
    's2-rekayasa-teknologi-informasi' => 'S2 Rekayasa Teknologi Informasi',
    'magister-terapan-rekayasa-teknologi-informasi' => 'Magister Terapan Rekayasa Teknologi Informasi',
];

if ($program_post && !empty($program_post->post_title)) {
    $program_title = $program_post->post_title;
} elseif (isset($akademik_titles[$program_slug])) {
    $program_title = $akademik_titles[$program_slug];
} elseif (isset($akademik_titles[$lookup_slug])) {
    $program_title = $akademik_titles[$lookup_slug];
} elseif ($page_id > 0 && get_the_title($page_id)) {
    $program_title = get_the_title($page_id);
} else {
    $program_title = ucwords(str_replace('-', ' ', $program_slug ?: 'Program Studi'));
}

$resolve_image_url = function ($value) {
    if (empty($value)) {
        return '';
    }

    if (is_array($value)) {
        if (!empty($value['url'])) {
            return $value['url'];
        }

        if (!empty($value['sizes']['full'])) {
            return $value['sizes']['full'];
        }

        if (!empty($value['sizes']['large'])) {
            return $value['sizes']['large'];
        }

        if (!empty($value['id'])) {
            return wp_get_attachment_image_url($value['id'], 'full');
        }
    }

    if (is_int($value) || is_numeric($value)) {
        return wp_get_attachment_image_url((int) $value, 'full');
    }

    if (is_string($value)) {
        return $value;
    }

    return '';
};

$format_wysiwyg_list = function ($content, $default_items = []) {
    if (empty(trim((string) $content))) {
        if (empty($default_items)) {
            return '';
        }
        $items_html = '';
        foreach ($default_items as $item) {
            $items_html .= '<li>' . esc_html($item) . '</li>';
        }
        return '<ul class="akademik-program-section__dot-list">' . $items_html . '</ul>';
    }

    $content = str_replace('<ul>', '<ul class="akademik-program-section__dot-list">', $content);
    $content = str_replace('<ol>', '<ol class="akademik-program-section__dot-list">', $content);
    return wp_kses_post($content);
};

// 4. Resolve Old Prefix for Fallback
$old_prefix = '';
if (in_array($program_slug, ['d4-teknik-informatika', 'sarjana-terapan-teknik-informatika', 'd4-ti']) || in_array($lookup_slug, ['d4-teknik-informatika', 'sarjana-terapan-teknik-informatika'])) {
    $old_prefix = 'd4_ti_';
} elseif (in_array($program_slug, ['d4-sistem-informasi-bisnis', 'sarjana-terapan-sistem-informasi-bisnis', 'd4-sib']) || in_array($lookup_slug, ['d4-sistem-informasi-bisnis', 'sarjana-terapan-sistem-informasi-bisnis'])) {
    $old_prefix = 'd4_sib_';
} elseif (in_array($program_slug, ['s2-rekayasa-teknologi-informasi', 'magister-terapan-rekayasa-teknologi-informasi', 's2-rekayasa']) || in_array($lookup_slug, ['s2-rekayasa-teknologi-informasi', 'magister-terapan-rekayasa-teknologi-informasi'])) {
    $old_prefix = 's2_rekayasa_';
} elseif (in_array($program_slug, ['d3-mi-kediri', 'd3-mi']) || in_array($lookup_slug, ['d3-mi-kediri'])) {
    $old_prefix = 'd3_mi_kediri_';
} elseif ($program_slug === 'd3-mi-lumajang' || $lookup_slug === 'd3-mi-lumajang') {
    $old_prefix = 'd3_mi_lumajang_';
} elseif ($program_slug === 'd2-piranti-lunak' || $lookup_slug === 'd2-piranti-lunak') {
    $old_prefix = 'd2_pl_';
}

$get_unified_field = function($unified_key, $old_key_suffix, $post_id) use ($old_prefix, $has_acf) {
    if (!$has_acf || !$post_id) return '';
    $value = get_field('sp_' . $unified_key, $post_id);
    if ((empty($value) || (is_array($value) && empty($value)))) {
        $value = get_field($unified_key, $post_id);
    }
    if ((empty($value) || (is_array($value) && empty($value))) && $old_prefix) {
        $value = get_field($old_prefix . $old_key_suffix, $post_id);
    }
    return $value;
};

// 5. Intro Content
$intro_suffix = ($old_prefix === 'd4_sib_') ? 'program_description' : 'intro';
$intro_content = $get_unified_field('intro', $intro_suffix, $page_id);

if (empty($intro_content) && $program_post && !empty($program_post->post_content)) {
    $intro_content = apply_filters('the_content', $program_post->post_content);
}

if (empty($intro_content)) {
    $intro_content = '<p>Program Studi ' . esc_html($program_title) . ' Politeknik Negeri Malang menyelenggarakan pendidikan vokasi unggulan yang berfokus pada inovasi, keahlian terapan, dan transformasi digital berbasis industri.</p>';
}

// 6. Vision, Mission, Goals
$vision_val = $get_unified_field('vision', 'vision', $page_id);
$vision_html = !empty($vision_val) ? $format_wysiwyg_list($vision_val) : $format_wysiwyg_list('', [
    'Menjadi program studi vokasi unggul yang menghasilkan lulusan kompeten, profesional, dan siap bersaing di tingkat nasional maupun internasional.'
]);

$mission_val = $get_unified_field('mission', 'mission', $page_id);
$mission_html = !empty($mission_val) ? $format_wysiwyg_list($mission_val) : $format_wysiwyg_list('', [
    'Menyelenggarakan pendidikan terapan berkualitas yang relevan dengan perkembangan industri dan teknologi.',
    'Meningkatkan penelitian terapan dan pengabdian kepada masyarakat berbasis kebutuhan riil industri.',
    'Menjalin kemitraan strategis dengan dunia usaha, industri, dan institusi akademik global.'
]);

$goals_val = $get_unified_field('goals', 'goals', $page_id);
$goals_html = !empty($goals_val) ? $format_wysiwyg_list($goals_val) : $format_wysiwyg_list('', [
    'Menghasilkan lulusan yang berkepribadian baik, memiliki keahlian profesional, dan berdaya saing tinggi.',
    'Menghasilkan karya inovatif dan teknologi terapan yang bermanfaat bagi masyarakat dan industri.',
    'Mewujudkan tata kelola program studi yang transparan, akuntabel, dan berorientasi mutu berkelanjutan.'
]);

// 7. Accreditation
$accreditation_items = [];
if ($has_acf && $page_id > 0) {
    $desc_1 = $get_unified_field('accreditation_1_description', 'accreditation_1_description', $page_id);
    $img_1 = $get_unified_field('accreditation_1_image', 'accreditation_1_image', $page_id);
    if (!empty($desc_1) || !empty($img_1)) {
        $accreditation_items[] = [
            'description' => $desc_1,
            'image' => $resolve_image_url($img_1),
        ];
    }

    $desc_2 = $get_unified_field('accreditation_2_description', 'accreditation_2_description', $page_id);
    $img_2 = $get_unified_field('accreditation_2_image', 'accreditation_2_image', $page_id);
    if (!empty($desc_2) || !empty($img_2)) {
        $accreditation_items[] = [
            'description' => $desc_2,
            'image' => $resolve_image_url($img_2),
        ];
    }
}

if (empty($accreditation_items)) {
    $accreditation_items = [
        [
            'description' => 'Program Studi ' . esc_html($program_title) . ' terakreditasi baik dan terus meningkatkan kualitas kurikulum serta sistem pembelajaran sesuai kebutuhan industri.',
            'image' => '',
        ],
    ];
}

// 8. Outcomes (Capaian Lulusan)
$outcome_ids = $get_unified_field('outcomes', 'outcomes', $page_id);
if (empty($outcome_ids) && ($page_id > 0 || !empty($program_slug))) {
    $tax_slugs = array_unique(array_filter([$program_slug, $lookup_slug, $url_slug]));
    $linked_cpl = get_posts([
        'post_type'      => 'capaian_lulusan',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'kategori_program_studi',
                'field'    => 'slug',
                'terms'    => $tax_slugs,
            ],
        ],
    ]);
    if (!empty($linked_cpl)) {
        $outcome_ids = $linked_cpl;
    }
}

$outcome_rows = [];
if (!empty($outcome_ids) && is_array($outcome_ids)) {
    $outcome_ids = array_filter(array_map('absint', (array) $outcome_ids));
    if (!empty($outcome_ids)) {
        $outcome_query = new WP_Query([
            'post_type'      => 'capaian_lulusan',
            'post__in'       => $outcome_ids,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        if ($outcome_query->have_posts()) {
            while ($outcome_query->have_posts()) {
                $outcome_query->the_post();
                $outcome_id = get_the_ID();
                $outcome_rows[] = [
                    'code'        => trim((string) (get_field('code', $outcome_id) ?: get_the_title($outcome_id))),
                    'description' => trim((string) (get_field('description', $outcome_id) ?: get_the_excerpt($outcome_id) ?: '')),
                ];
            }
            wp_reset_postdata();
        }
    }
}

// 9. Courses (Mata Kuliah)
$selected_course_ids = $get_unified_field('mata_kuliah', 'mata_kuliah', $page_id);
if (empty($selected_course_ids) && ($page_id > 0 || !empty($program_slug))) {
    $tax_slugs = array_unique(array_filter([$program_slug, $lookup_slug, $url_slug]));
    $linked_courses = get_posts([
        'post_type'      => 'mata_kuliah',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'kategori_program_studi',
                'field'    => 'slug',
                'terms'    => $tax_slugs,
            ],
        ],
    ]);
    if (!empty($linked_courses)) {
        $selected_course_ids = $linked_courses;
    } elseif ($page_id > 0) {
        $meta_courses = get_posts([
            'post_type'      => 'mata_kuliah',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'     => 'study_program',
                    'value'   => $page_id,
                    'compare' => '=',
                ],
            ],
        ]);
        if (!empty($meta_courses)) {
            $selected_course_ids = $meta_courses;
        }
    }
}

$courses = [];
if (!empty($selected_course_ids) && is_array($selected_course_ids)) {
    $selected_course_ids = array_filter(array_map('absint', $selected_course_ids));
    if (!empty($selected_course_ids)) {
        $course_query = new WP_Query([
            'post_type'      => 'mata_kuliah',
            'post_status'    => 'publish',
            'post__in'       => $selected_course_ids,
            'posts_per_page' => -1,
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
        ]);

        if ($course_query->have_posts()) {
            while ($course_query->have_posts()) {
                $course_query->the_post();
                $course_id = get_the_ID();
                $courses[] = [
                    'id'         => $course_id,
                    'title'      => trim((string) (get_field('nama_mk', $course_id) ?: get_the_title($course_id))),
                    'code'       => trim((string) get_field('kode_mk', $course_id)),
                    'sks'        => (int) get_field('sks', $course_id),
                    'keterangan' => trim((string) get_field('keterangan', $course_id)),
                    'semester'   => trim((string) (get_field('semester', $course_id) ?: 'Semester 1')),
                ];
            }
            wp_reset_postdata();
        }
    }
}

$subjects_by_semester = [];
foreach (range(1, 8) as $semester_number) {
    $semester_label = 'Semester ' . $semester_number;
    $subjects_by_semester[$semester_label] = [];
}

foreach ($courses as $course) {
    $semester_label = $course['semester'] ?: 'Semester 1';
    if (!isset($subjects_by_semester[$semester_label])) {
        $subjects_by_semester[$semester_label] = [];
    }

    $subjects_by_semester[$semester_label][] = [
        'name'       => $course['title'],
        'code'       => $course['code'],
        'sks'        => $course['sks'],
        'keterangan' => $course['keterangan'],
    ];
}

$subjects_pages = array_chunk($subjects_by_semester, 3, true);

// 10. Tuition (Biaya Perkuliahan)
$tuition_raw = $get_unified_field('tuition', 'tuition', $page_id);
$tuition_html = !empty($tuition_raw) ? $format_wysiwyg_list($tuition_raw) : '';

// 11. Pathway (Peta Jalan CPL)
$pathway_ids = $get_unified_field('pathway', 'pathway', $page_id);
if (empty($pathway_ids) && ($page_id > 0 || !empty($program_slug))) {
    $tax_slugs = array_unique(array_filter([$program_slug, $lookup_slug, $url_slug]));
    $linked_pathways = get_posts([
        'post_type'      => 'peta_jalan_cpl',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'kategori_program_studi',
                'field'    => 'slug',
                'terms'    => $tax_slugs,
            ],
        ],
    ]);
    if (!empty($linked_pathways)) {
        $pathway_ids = $linked_pathways;
    }
}

$pathway_rows = [];
if (!empty($pathway_ids) && is_array($pathway_ids)) {
    $pathway_ids = array_filter(array_map('absint', (array) $pathway_ids));
    if (!empty($pathway_ids)) {
        $pathway_query = new WP_Query([
            'post_type'      => 'peta_jalan_cpl',
            'post__in'       => $pathway_ids,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        if ($pathway_query->have_posts()) {
            while ($pathway_query->have_posts()) {
                $pathway_query->the_post();
                $pid = get_the_ID();
                $code = get_field('code', $pid) ?: get_the_title($pid);
                $image_val = get_field('image', $pid);
                $image = $resolve_image_url($image_val);
                
                $pathway_rows[] = [
                    'code'  => trim((string) $code),
                    'image' => $image,
                ];
            }
            wp_reset_postdata();
        }
    }
}

// 12. Guidebook PDF
$pdf_url = '';
if ($has_acf && $page_id > 0) {
    $pdf_value = $get_unified_field('buku_panduan_pdf', 'buku_panduan_pdf', $page_id);
    $pdf_url = $resolve_image_url($pdf_value);
}

// 13. Profiles (Profil Lulusan)
$profiles = [];
if ($has_acf && $page_id > 0) {
    $profiles_raw = $get_unified_field('profiles', 'profiles', $page_id);
    if (empty($profiles_raw)) {
        $tax_slugs = array_unique(array_filter([$program_slug, $lookup_slug, $url_slug]));
        $linked_profiles = get_posts([
            'post_type'      => 'profil_lulusan',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [
                [
                    'taxonomy' => 'kategori_program_studi',
                    'field'    => 'slug',
                    'terms'    => $tax_slugs,
                ],
            ],
        ]);
        if (!empty($linked_profiles)) {
            $profiles_raw = $linked_profiles;
        } elseif ($page_id > 0) {
            $meta_profiles = get_posts([
                'post_type'      => 'profil_lulusan',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'meta_query'     => [
                    [
                        'key'     => 'study_program',
                        'value'   => $page_id,
                        'compare' => '=',
                    ],
                ],
            ]);
            if (!empty($meta_profiles)) {
                $profiles_raw = $meta_profiles;
            }
        }
    }

    $parse_sp_competencies = function ($value) {
        $value = trim((string) $value);
        if ($value === '') {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $value);
        return array_values(array_filter(array_map('trim', $lines), function ($line) {
            return $line !== '';
        }));
    };

    if (!empty($profiles_raw)) {
        if (is_array($profiles_raw) && !empty($profiles_raw) && (is_int($profiles_raw[0]) || is_string($profiles_raw[0]) || (is_object($profiles_raw[0]) && isset($profiles_raw[0]->ID)))) {
            $profile_ids = [];
            foreach ($profiles_raw as $value) {
                if (is_object($value) && isset($value->ID)) {
                    $profile_ids[] = absint($value->ID);
                } elseif (is_scalar($value)) {
                    $profile_ids[] = absint($value);
                }
            }
            $profile_ids = array_values(array_filter($profile_ids));

            if (!empty($profile_ids)) {
                $profile_query = new WP_Query([
                    'post_type'      => 'profil_lulusan',
                    'post__in'       => $profile_ids,
                    'orderby'        => 'post__in',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                ]);

                if ($profile_query->have_posts()) {
                    while ($profile_query->have_posts()) {
                        $profile_query->the_post();
                        $pid = get_the_ID();

                        $profiles[] = [
                            'title'        => get_the_title($pid),
                            'description'  => trim((string) (get_field('description', $pid) ?: get_the_excerpt($pid))),
                            'competencies' => $parse_sp_competencies(get_field('competencies', $pid)),
                        ];
                    }
                    wp_reset_postdata();
                }
            }
        } elseif (is_array($profiles_raw)) {
            foreach ($profiles_raw as $profile) {
                if (!is_array($profile)) {
                    continue;
                }

                $title = trim(wp_strip_all_tags((string) ($profile['title'] ?? '')));
                $description = trim(wp_strip_all_tags((string) ($profile['description'] ?? '')));
                $competencies = $parse_sp_competencies($profile['competencies'] ?? '');

                if ($title === '' && $description === '' && empty($competencies)) {
                    continue;
                }

                $profiles[] = [
                    'title'        => $title,
                    'description'  => $description,
                    'competencies' => $competencies,
                ];
            }
        } elseif (is_string($profiles_raw) && trim($profiles_raw) !== '') {
            $profiles[] = [
                'title'        => 'Profil Lulusan',
                'description'  => trim(wp_strip_all_tags($profiles_raw)),
                'competencies' => [],
            ];
        }
    }
}

// 14. Tab Setup
$tabs = [
    ['id' => 'program', 'label' => 'Program Studi'],
];

if (!empty($profiles)) {
    $tabs[] = ['id' => 'profil', 'label' => 'Profil Lulusan'];
}

if (!empty($outcome_rows)) {
    $tabs[] = ['id' => 'capaian', 'label' => 'Capaian Lulusan'];
}

if (!empty($courses)) {
    $tabs[] = ['id' => 'mata-kuliah', 'label' => 'Mata Kuliah'];
}

if (!empty($tuition_html)) {
    $tabs[] = ['id' => 'biaya', 'label' => 'Biaya Perkuliahan'];
}

if (!empty($pathway_rows)) {
    $tabs[] = ['id' => 'peta-jalan', 'label' => 'Peta Jalan CPL'];
}

if (!empty($pdf_url)) {
    $tabs[] = ['id' => 'buku-panduan', 'label' => 'Buku Panduan'];
}
?>

<div class="tabs-container akademik-tabs">
    <div class="akademik-tabs__nav">
        <?php foreach ($tabs as $index => $tab) : ?>
            <button
                class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                type="button"
                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                data-tab="<?php echo esc_attr($tab['id']); ?>"
            >
                <?php echo esc_html($tab['label']); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="akademik-tabs__panels">
        <div class="tab-panel active" data-panel="program" aria-hidden="false">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title'   => esc_html($program_title),
                        'icon'    => 'ph-buildings',
                        'content' => $intro_content,
                        'class'   => 'content-block--strong-title',
                    ]
                );
                ?>

                <div class="akademik-program-section__grid">
                    <?php if (!empty($vision_html)) : ?>
                    <article class="akademik-program-section__card">
                        <h2>Visi</h2>
                        <?php echo $vision_html; ?>
                    </article>
                    <?php endif; ?>

                    <?php if (!empty($mission_html)) : ?>
                    <article class="akademik-program-section__card">
                        <h2>Misi</h2>
                        <?php echo $mission_html; ?>
                    </article>
                    <?php endif; ?>
                </div>

                <?php if (!empty($goals_html)) : ?>
                <article class="akademik-program-section__card">
                    <h2>Tujuan</h2>
                    <?php echo $goals_html; ?>
                </article>
                <?php endif; ?>

                <article class="akademik-program-section__card">
                    <h2>Sertifikat Akreditasi</h2>
                    <div class="d4-ti-accreditation-list">
                        <?php foreach ($accreditation_items as $accreditation_item) : ?>
                            <div class="d4-ti-accreditation-item">
                                <?php if (!empty($accreditation_item['description'])) : ?>
                                    <p><?php echo esc_html($accreditation_item['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php 
                    $has_any_image = false;
                    foreach ($accreditation_items as $item) {
                        if (!empty($item['image'])) {
                            $has_any_image = true;
                            break;
                        }
                    }
                    ?>
                    
                    <div class="d4-ti-accreditation-preview">
                        <div class="d4-ti-accreditation-preview__label">Sertifikat</div>
                        <div class="d4-ti-accreditation-preview-list">
                            <?php if ($has_any_image): ?>
                                <?php foreach ($accreditation_items as $index => $accreditation_item) : 
                                    if (!empty($accreditation_item['image'])) :
                                        $label = $index === 0 ? 'Sertifikat 1' : 'Sertifikat 2';
                                ?>
                                    <button class="d4-ti-zoom-trigger" type="button" data-full-image="<?php echo esc_url($accreditation_item['image']); ?>">
                                        <img src="<?php echo esc_url($accreditation_item['image']); ?>" alt="<?php echo esc_attr($label); ?>">
                                        <span><?php echo esc_html($label); ?></span>
                                    </button>
                                <?php endif; endforeach; ?>
                            <?php else: ?>
                                <button class="d4-ti-zoom-trigger" type="button" data-full-image="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png'); ?>">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png'); ?>" alt="Placeholder Sertifikat Akreditasi">
                                    <span>Akreditasi</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </section>
        </div>

        <?php if (!empty($profiles)) : ?>
        <div class="tab-panel" data-panel="profil" aria-hidden="true">
            <section class="akademik-program-section">
                <div class="akademik-program-section__grid">
                    <?php foreach ($profiles as $profile) : ?>
                        <?php
                        $competencies = is_array($profile['competencies'] ?? null) ? $profile['competencies'] : [];
                        $profile_content_html = '<p>' . esc_html((string) ($profile['description'] ?? '')) . '</p>';
                        if (!empty($competencies)) {
                            $profile_content_html .= '<ul class="akademik-program-section__dot-list">';
                            foreach ($competencies as $competency) {
                                $profile_content_html .= '<li>' . esc_html((string) $competency) . '</li>';
                            }
                            $profile_content_html .= '</ul>';
                        }
                        get_template_part(
                            'template-parts/components/content-block',
                            null,
                            [
                                'title'   => (string) ($profile['title'] ?? ''),
                                'icon'    => 'ph-graduation-cap',
                                'content' => $profile_content_html,
                                'class'   => 'content-block--strong-title',
                            ]
                        );
                        ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
        <?php endif; ?>

        <?php if (!empty($outcome_rows)) : ?>
        <div class="tab-panel" data-panel="capaian" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card akademik-program-section__table-card">
                    <h2>Capaian Lulusan</h2>
                    <div class="akademik-program-section__table-wrap">
                        <table class="akademik-program-section__table">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Kode</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($outcome_rows as $outcome) : ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($outcome['code']); ?></strong></td>
                                        <td><?php echo esc_html($outcome['description']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </div>
        <?php endif; ?>

        <?php if (!empty($courses)) : ?>
        <div class="tab-panel" data-panel="mata-kuliah" aria-hidden="true">
            <section class="akademik-program-section">
                <?php if (!empty($subjects_pages)) : ?>
                <?php foreach ($subjects_pages as $page_index => $page_subjects) : ?>
                    <div class="akademik-program-section__page" data-page="<?php echo esc_attr($page_index); ?>"<?php echo $page_index === 0 ? ' style="display:block;"' : ' style="display:none;"'; ?>>
                        <?php foreach ($page_subjects as $semester_label => $semester_subjects) : ?>
                            <?php if ($semester_label === 'Semester 6' || $semester_label === 'Semester 7' || $semester_label === 'Semester 8') : ?>
                                    <?php
                                        $mandatory = [];
                                        $package1 = [];
                                        $package2 = [];

                                        foreach ($semester_subjects as $s) {
                                            $k = strtolower((string) ($s['keterangan'] ?? ''));
                                            if (strpos($k, 'wajib') !== false) {
                                                $mandatory[] = $s;
                                            } elseif (strpos($k, 'reguler') !== false || strpos($k, 'pilihan reguler') !== false) {
                                                $package1[] = $s;
                                            } elseif (strpos($k, 'magang') !== false) {
                                                $package2[] = $s;
                                            } else {
                                                $mandatory[] = $s;
                                            }
                                        }

                                        while (count($mandatory) < 3) {
                                            $mandatory[] = ['code' => '-', 'name' => '(Belum ada mata kuliah wajib)', 'sks' => '-', 'keterangan' => 'MK Wajib'];
                                        }
                                    ?>

                                    <article class="akademik-program-section__card akademik-program-section__table-card">
                                        <h2><?php echo esc_html($semester_label); ?></h2>
                                        <div class="akademik-program-section__table-wrap">
                                            <?php
                                                $mandatory_total_sks = array_sum(array_map(function ($item) {
                                                    return intval($item['sks'] ?? 0);
                                                }, $mandatory));
                                                $package1_total_sks = array_sum(array_map(function ($item) {
                                                    return intval($item['sks'] ?? 0);
                                                }, $package1));
                                                $package2_total_sks = array_sum(array_map(function ($item) {
                                                    return intval($item['sks'] ?? 0);
                                                }, $package2));
                                            ?>
                                            <table class="akademik-program-section__table" id="semester-6-table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode MK</th>
                                                        <th>Mata Kuliah</th>
                                                        <th>SKS</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($mandatory as $index => $m) : ?>
                                                        <tr class="mandatory-row">
                                                            <td><?php echo esc_html($index + 1); ?></td>
                                                            <td><?php echo esc_html($m['code']); ?></td>
                                                            <td><?php echo esc_html($m['name']); ?></td>
                                                            <td><?php echo esc_html($m['sks']); ?></td>
                                                            <td><?php echo esc_html($m['keterangan']); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                    <tr class="package-header" data-package-label>
                                                        <td colspan="5" class="package-band">Paket Pilihan 1 - Reguler</td>
                                                    </tr>

                                                    <?php if (!empty($package1)) : ?>
                                                        <?php foreach ($package1 as $p_index => $p) : ?>
                                                            <tr class="package-row package-1" data-package="1">
                                                                <td><?php echo esc_html(count($mandatory) + $p_index + 1); ?></td>
                                                                <td><?php echo esc_html($p['code']); ?></td>
                                                                <td><?php echo esc_html($p['name']); ?></td>
                                                                <td><?php echo esc_html($p['sks']); ?></td>
                                                                <td><?php echo esc_html($p['keterangan']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr class="package-row package-1" data-package="1">
                                                            <td colspan="5">Belum ada mata kuliah pada Paket Pilihan 1 - Reguler.</td>
                                                        </tr>
                                                    <?php endif; ?>

                                                    <?php if (!empty($package2)) : ?>
                                                        <?php foreach ($package2 as $p_index => $p) : ?>
                                                            <tr class="package-row package-2" data-package="2" style="display:none;">
                                                                <td><?php echo esc_html(count($mandatory) + $p_index + 1); ?></td>
                                                                <td><?php echo esc_html($p['code']); ?></td>
                                                                <td><?php echo esc_html($p['name']); ?></td>
                                                                <td><?php echo esc_html($p['sks']); ?></td>
                                                                <td><?php echo esc_html($p['keterangan']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr class="package-row package-2" data-package="2" style="display:none;">
                                                            <td colspan="5">Belum ada mata kuliah pada Paket Pilihan 2 - Magang.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4"><strong>Total SKS</strong></td>
                                                        <td><strong id="semester-6-total-value"><?php echo esc_html($mandatory_total_sks + $package1_total_sks); ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="akademik-program-section__table-actions package-toggle-group">
                                            <button type="button" class="package-toggle-btn active" data-package="1">Paket Pilihan 1 - Reguler</button>
                                            <button type="button" class="package-toggle-btn" data-package="2">Paket Pilihan 2 - Magang</button>
                                        </div>
                                    </article>

                                <?php else : ?>
                                    <article class="akademik-program-section__card akademik-program-section__table-card">
                                        <h2><?php echo esc_html($semester_label); ?></h2>
                                        <div class="akademik-program-section__table-wrap">
                                            <?php $semester_total_sks = 0; ?>
                                            <table class="akademik-program-section__table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode MK</th>
                                                        <th>Mata Kuliah</th>
                                                        <th>SKS</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($semester_subjects)) : ?>
                                                        <?php foreach ($semester_subjects as $index => $subject) : ?>
                                                            <?php $semester_total_sks += intval($subject['sks'] ?? 0); ?>
                                                            <tr>
                                                                <td><?php echo esc_html($index + 1); ?></td>
                                                                <td><?php echo esc_html($subject['code']); ?></td>
                                                                <td><?php echo esc_html($subject['name']); ?></td>
                                                                <td><?php echo esc_html($subject['sks']); ?></td>
                                                                <td><?php echo esc_html($subject['keterangan']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="5">Belum ada mata kuliah untuk <?php echo esc_html($semester_label); ?>.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: right; padding-right: 16px;"><strong>Total SKS</strong></td>
                                                        <td style="text-align: center;"><strong><?php echo esc_html($semester_total_sks); ?></strong></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </article>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="akademik-program-section__pagination" data-mata-kuliah-pagination>
                        <?php foreach ($subjects_pages as $page_index => $page_subjects) : ?>
                            <button
                                type="button"
                                class="akademik-program-section__pagination-btn <?php echo $page_index === 0 ? 'active' : ''; ?>"
                                data-pagination-page="<?php echo esc_attr($page_index); ?>"
                            >
                                <?php echo esc_html($page_index + 1); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <article class="akademik-program-section__card">
                        <p>Belum ada data mata kuliah yang tersedia untuk <?php echo esc_html($program_title); ?>.</p>
                    </article>
                <?php endif; ?>
            </section>
        </div>
        <?php endif; ?>

        <?php if (!empty($tuition_html)) : ?>
        <div class="tab-panel" data-panel="biaya" aria-hidden="true">
            <section class="akademik-program-section">
                <?php
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title'   => 'Biaya Perkuliahan',
                        'icon'    => 'ph-wallet',
                        'content' => $tuition_html,
                        'class'   => 'content-block--strong-title',
                    ]
                );
                ?>
            </section>
        </div>
        <?php endif; ?>

        <?php if (!empty($pathway_rows)) : ?>
        <div class="tab-panel" data-panel="peta-jalan" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card akademik-program-section__table-card">
                    <h2>Peta Jalan CPL</h2>
                    <div class="akademik-program-section__table-wrap">
                        <table class="akademik-program-section__table akademik-program-section__table--3cols">
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center; white-space: nowrap;">No</th>
                                    <th style="width: 30%; text-align: center;">Kode CPL/CPP</th>
                                    <th style="text-align: center;">Gambar Peta Jalan CPL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pathway_rows as $index => $row) : ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo esc_html($index + 1); ?></td>
                                        <td style="text-align: center;"><strong><?php echo esc_html($row['code']); ?></strong></td>
                                        <td style="text-align: center;">
                                            <?php if (!empty($row['image'])) : ?>
                                                <button class="d4-ti-zoom-trigger d4-ti-zoom-trigger--inline" type="button" data-full-image="<?php echo esc_url($row['image']); ?>">
                                                    <img src="<?php echo esc_url($row['image']); ?>" alt="Peta Jalan CPL <?php echo esc_attr($row['code']); ?>" style="max-width: 300px; border-radius: 8px;">
                                                </button>
                                            <?php else : ?>
                                                <button class="d4-ti-zoom-trigger d4-ti-zoom-trigger--inline" type="button" data-full-image="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png'); ?>">
                                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png'); ?>" alt="Placeholder Peta Jalan CPL <?php echo esc_attr($row['code']); ?>" style="max-width: 300px; border-radius: 8px;">
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </div>
        <?php endif; ?>

        <?php if (!empty($pdf_url)) : ?>
        <div class="tab-panel" data-panel="buku-panduan" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card">
                    <h2>Buku Panduan Akademik</h2>
                    <div class="d4-ti-pdf-preview">
                        <iframe class="d4-ti-pdf-frame" src="<?php echo esc_url($pdf_url); ?>" title="Preview PDF Buku Panduan Akademik"></iframe>
                    </div>
                </article>
            </section>
        </div>
        <?php endif; ?>
    </div>
</div>

<div id="d4-ti-image-modal" class="d4-ti-modal" hidden>
    <div class="d4-ti-modal__overlay" data-dismiss="true"></div>
    <div class="d4-ti-modal__content">
        <button class="d4-ti-modal__close" type="button" aria-label="Tutup gambar" data-dismiss="true">×</button>
        <img id="d4-ti-modal-image" src="" alt="Perbesar gambar">
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('d4-ti-image-modal');
    if (!modal) {
        return;
    }

    const modalImage = document.getElementById('d4-ti-modal-image');
    const triggers = document.querySelectorAll('.d4-ti-zoom-trigger');

    const closeModal = () => {
        modal.hidden = true;
        document.body.style.overflow = '';
    };

    triggers.forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const url = trigger.getAttribute('data-full-image');
            if (!url) {
                return;
            }

            modalImage.setAttribute('src', url);
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
        });
    });

    modal.addEventListener('click', (event) => {
        if (event.target.matches('[data-dismiss="true"]')) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (modal.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            closeModal();
        }
    });
})();
</script>

<script>
(function () {
    const parseSks = (value) => {
        const parsed = parseInt((value || '').toString().replace(/[^0-9\-]/g, ''), 10);
        return Number.isNaN(parsed) ? 0 : parsed;
    };

    const updateSemester6Total = (article) => {
        if (!article) {
            return;
        }

        let total = 0;
        article.querySelectorAll('.mandatory-row').forEach((row) => {
            const sksCell = row.querySelector('td:nth-child(4)');
            total += parseSks(sksCell?.textContent);
        });

        article.querySelectorAll('.package-row').forEach((row) => {
            if (row.style.display !== 'none') {
                const sksCell = row.querySelector('td:nth-child(4)');
                total += parseSks(sksCell?.textContent);
            }
        });

        const totalCell = article.querySelector('#semester-6-total-value');
        if (totalCell) {
            totalCell.textContent = total;
        }
    };

    const packageButtons = document.querySelectorAll('.package-toggle-btn');
    if (packageButtons && packageButtons.length) {
        packageButtons.forEach((btn) => {
            btn.addEventListener('click', function () {
                const packageId = this.getAttribute('data-package');
                const article = this.closest('.akademik-program-section__card');
                if (!article) return;

                article.querySelectorAll('.package-toggle-btn').forEach((b) => b.classList.toggle('active', b === this));

                const header = article.querySelector('[data-package-label] .package-band') || article.querySelector('[data-package-label]');
                if (header) {
                    header.textContent = packageId === '1' ? 'Paket Pilihan 1 - Reguler' : 'Paket Pilihan 2 - Magang';
                }

                article.querySelectorAll('.package-row').forEach((row) => {
                    const rowPackage = row.getAttribute('data-package');
                    if (rowPackage === packageId) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateSemester6Total(article);
            });
        });
    }

    const semester6Table = document.getElementById('semester-6-table');
    if (semester6Table) {
        const semester6Card = semester6Table.closest('.akademik-program-section__card');
        if (semester6Card) {
            updateSemester6Total(semester6Card);
        }
    }
})();
</script>
