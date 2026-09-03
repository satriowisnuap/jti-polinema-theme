<?php

/* ========================================
   ACF FALLBACK FUNCTIONS (SAFE MODE IF ACF INACTIVE)
======================================== */

if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true) {
        if (false === $post_id || null === $post_id) {
            $post_id = get_the_ID();
        }
        if (is_numeric($post_id) && $post_id > 0) {
            return get_post_meta($post_id, $selector, true);
        }
        return false;
    }
}

if (!function_exists('the_field')) {
    function the_field($selector, $post_id = false, $format_value = true) {
        $value = get_field($selector, $post_id, $format_value);
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        echo $value;
    }
}

if (!function_exists('get_fields')) {
    function get_fields($post_id = false, $format_value = true) {
        if (false === $post_id || null === $post_id) {
            $post_id = get_the_ID();
        }
        if (is_numeric($post_id) && $post_id > 0) {
            return get_post_custom($post_id);
        }
        return false;
    }
}

if (!function_exists('have_rows')) {
    function have_rows($selector, $post_id = false) {
        return false;
    }
}

/* ========================================
   SAFE ACF FIELD HELPER
======================================== */

function webjti_field(
  $field_name,
  $post_id = false,
  $default = ''
) {
  if (false === $post_id || null === $post_id) {
    $post_id = get_the_ID();
  }

  if (function_exists('get_field')) {
    $value = get_field($field_name, $post_id);
    return !empty($value) ? $value : $default;
  }

  if (is_numeric($post_id) && $post_id > 0) {
    $value = get_post_meta($post_id, $field_name, true);
    return !empty($value) ? $value : $default;
  }

  return $default;
}

/* ========================================
   FORCE ALL WYSIWYG FIELDS TO VISUAL TAB ONLY
   Agar semua editor teks kaya lebih user-friendly (hanya tab Visual)
======================================== */
add_filter('acf/load_field/type=wysiwyg', function($field) {
    $field['tabs'] = 'visual';
    return $field;
});

/* ========================================
   FORCE DISABLE LEGACY STUDY PROGRAM ACF GROUPS
   Menonaktifkan grup field lama yang sudah digantikan oleh versi Unified.
   Ini berguna jika di lokal database masih ada versi lamanya.
======================================== */
add_filter('acf/load_field_group', function($field_group) {
    $legacy_groups = [
        'group_d4_teknik_informatika_page',
        'group_d4_sistem_informasi_bisnis_page',
        'group_s2_rekayasa_teknologi_informasi_page',
        'group_s2_rekayasa_page',
        'group_d3_mi_kediri_page',
        'group_d3_mi_lumajang_page'
    ];
    if (in_array($field_group['key'], $legacy_groups)) {
        $field_group['active'] = false;
    }
    return $field_group;
});

/* ========================================
   REGISTER GALLERY KEMAHASISWAAN PAGE FIELDS
======================================== */
add_action('acf/init', function() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_gallery_kemahasiswaan_page',
            'title' => 'Pengaturan Halaman Galeri Kemahasiswaan',
            'fields' => array(
                array(
                    'key' => 'field_gallery_page_title',
                    'label' => 'Judul Halaman',
                    'name' => 'gallery_page_title',
                    'type' => 'text',
                    'instructions' => 'Judul yang ditampilkan di atas galeri',
                    'default_value' => 'Galeri Kegiatan Mahasiswa',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/pages/gallery-kemahasiswaan-page.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
});

/* ========================================
   REGISTER JURNAL PAGE FIELDS
======================================== */
add_action('acf/init', function() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_jurnal_page_settings',
            'title' => 'Pengaturan Jurnal',
            'fields' => array(
                array(
                    'key' => 'field_jurnal_title',
                    'label' => 'Judul Jurnal',
                    'name' => 'jurnal_title',
                    'type' => 'text',
                    'default_value' => 'JIP (Jurnal Informatika Polinema)',
                ),
                array(
                    'key' => 'field_jurnal_cover_image',
                    'label' => 'Cover Jurnal',
                    'name' => 'jurnal_cover_image',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_jurnal_issn_print',
                    'label' => 'ISSN (Print)',
                    'name' => 'jurnal_issn_print',
                    'type' => 'text',
                    'default_value' => '2614-6371',
                ),
                array(
                    'key' => 'field_jurnal_issn_online',
                    'label' => 'E-ISSN (Online)',
                    'name' => 'jurnal_issn_online',
                    'type' => 'text',
                    'default_value' => '2407-070X',
                ),
                array(
                    'key' => 'field_jurnal_website_url',
                    'label' => 'URL Website Jurnal',
                    'name' => 'jurnal_website_url',
                    'type' => 'url',
                    'default_value' => 'https://jurnal.polinema.ac.id/index.php/jip/',
                ),
                array(
                    'key' => 'field_jurnal_sinta_url',
                    'label' => 'URL SINTA',
                    'name' => 'jurnal_sinta_url',
                    'type' => 'url',
                    'default_value' => 'https://sinta.kemdikbud.go.id/journals/',
                ),
                array(
                    'key' => 'field_jurnal_cta_text',
                    'label' => 'Teks Tombol Aksi',
                    'name' => 'jurnal_cta_text',
                    'type' => 'text',
                    'default_value' => 'Klik disini untuk Informasi lebih Lengkapnya',
                ),
                array(
                    'key' => 'field_jurnal_sidebar_content',
                    'label' => 'Konten Sidebar Kustom (Bawah Foto)',
                    'name' => 'jurnal_sidebar_content',
                    'type' => 'wysiwyg',
                    'toolbar' => 'basic',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/pages/jurnal-page.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }
});

/* ========================================
   REGISTER ORMAWA ACF FIELDS PROGRAMMATICALLY
======================================== */

add_action('acf/init', 'webjti_register_ormawa_fields');
function webjti_register_ormawa_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_ormawa_details',
            'title' => 'Detail Organisasi Kemahasiswaan',
            'fields' => array(
                array(
                    'key' => 'field_ormawa_history',
                    'label' => 'Sejarah',
                    'name' => 'history',
                    'type' => 'wysiwyg',
                    'instructions' => 'Sejarah singkat organisasi',
                    'required' => 0,
                    'media_upload' => 0,
                    'toolbar' => 'full',
                ),
                array(
                    'key' => 'field_ormawa_vision',
                    'label' => 'Visi',
                    'name' => 'vision',
                    'type' => 'wysiwyg',
                    'instructions' => 'Visi organisasi',
                    'required' => 0,
                    'media_upload' => 0,
                    'toolbar' => 'basic',
                ),
                array(
                    'key' => 'field_ormawa_mission',
                    'label' => 'Misi',
                    'name' => 'mission',
                    'type' => 'wysiwyg',
                    'instructions' => 'Misi organisasi',
                    'required' => 0,
                    'media_upload' => 0,
                    'toolbar' => 'basic',
                ),
                array(
                    'key' => 'field_ormawa_objective',
                    'label' => 'Tujuan',
                    'name' => 'objective',
                    'type' => 'wysiwyg',
                    'instructions' => 'Tujuan organisasi',
                    'required' => 0,
                    'media_upload' => 0,
                    'toolbar' => 'basic',
                ),
                array(
                    'key' => 'field_ormawa_program',
                    'label' => 'Program Kerja',
                    'name' => 'program',
                    'type' => 'wysiwyg',
                    'instructions' => 'Program kerja unggulan',
                    'required' => 0,
                    'media_upload' => 0,
                    'toolbar' => 'full',
                ),
                array(
                    'key' => 'field_ormawa_instagram',
                    'label' => 'Link Instagram',
                    'name' => 'instagram',
                    'type' => 'url',
                    'instructions' => 'Link profil Instagram (contoh: https://instagram.com/username)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_ormawa_facebook',
                    'label' => 'Link Facebook',
                    'name' => 'facebook',
                    'type' => 'url',
                    'instructions' => 'Link akun/halaman Facebook (contoh: https://facebook.com/username)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_ormawa_tiktok',
                    'label' => 'Link TikTok',
                    'name' => 'tiktok',
                    'type' => 'url',
                    'instructions' => 'Link profil TikTok (contoh: https://tiktok.com/@username)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_ormawa_website',
                    'label' => 'Link Website Resmi',
                    'name' => 'website',
                    'type' => 'url',
                    'instructions' => 'Link website resmi organisasi (contoh: https://ormawa.polinema.ac.id)',
                    'required' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ormawa',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => 'Metabox untuk detail Organisasi Kemahasiswaan',
            'show_in_rest' => 1,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_ormawa_gallery_details',
            'title' => 'Detail Foto Kegiatan Organisasi (Ormawa)',
            'fields' => array(
                array(
                    'key' => 'field_gallery_associated_ormawa',
                    'label' => 'Pilih Organisasi (Ormawa)',
                    'name' => 'associated_ormawa',
                    'type' => 'post_object',
                    'instructions' => 'Pilih Organisasi Kemahasiswaan (Ormawa) terkait jika ada (opsional)',
                    'required' => 0,
                    'post_type' => array(
                        0 => 'ormawa',
                    ),
                    'taxonomy' => '',
                    'allow_null' => 1,
                    'multiple' => 0,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_gallery_photo',
                    'label' => 'Media / Foto Kegiatan (Add Media)',
                    'name' => 'gallery_photo',
                    'type' => 'image',
                    'instructions' => 'Upload atau pilih foto/media kegiatan organisasi',
                    'required' => 1,
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_gallery_description',
                    'label' => 'Deskripsi / Keterangan',
                    'name' => 'description',
                    'type' => 'textarea',
                    'instructions' => 'Deskripsi singkat mengenai foto kegiatan ini',
                    'required' => 0,
                    'rows' => 3,
                    'new_lines' => 'br',
                ),
                array(
                    'key' => 'field_gallery_related_photo_1',
                    'label' => 'Foto Terkait 1',
                    'name' => 'related_photo_1',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_gallery_related_photo_2',
                    'label' => 'Foto Terkait 2',
                    'name' => 'related_photo_2',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_gallery_related_photo_3',
                    'label' => 'Foto Terkait 3',
                    'name' => 'related_photo_3',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_gallery_related_photo_4',
                    'label' => 'Foto Terkait 4',
                    'name' => 'related_photo_4',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ormawa_gallery',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'discussion',
                3 => 'comments',
                4 => 'revisions',
                5 => 'author',
                6 => 'featured_image',
            ),
            'active' => true,
            'description' => 'Metabox untuk detail foto kegiatan organisasi',
            'show_in_rest' => 1,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_lecturer_details',
            'title' => 'Detail Tenaga Pengajar',
            'fields' => array(
                array(
                    'key' => 'field_lecturer_laboratory',
                    'label' => 'Laboratorium / Lab Riset',
                    'name' => 'laboratory',
                    'type' => 'post_object',
                    'instructions' => 'Pilih Laboratorium dari CPT Laboratorium tempat dosen ini mengajar / meniti riset.',
                    'required' => 0,
                    'post_type' => array(
                        0 => 'laboratory',
                    ),
                    'taxonomy' => '',
                    'allow_null' => 1,
                    'multiple' => 0,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_lecturer_email_acf',
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'instructions' => 'Alamat email dosen (contoh: nama@polinema.ac.id).',
                    'required' => 0,
                    'wrapper' => array('width' => '100%'),
                ),
                array(
                    'key' => 'field_lecturer_expertise_acf',
                    'label' => 'Keahlian / Bidang Riset',
                    'name' => 'expertise',
                    'type' => 'textarea',
                    'instructions' => 'Masukkan keahlian atau bidang riset dosen. Pisahkan dengan koma jika lebih dari satu (contoh: Machine Learning, Computer Vision, Deep Learning).',
                    'required' => 0,
                    'rows' => 4,
                    'new_lines' => '',
                    'wrapper' => array('width' => '100%'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'lecturer',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'show_in_rest' => 1,
        ));

        acf_add_local_field_group(array(
            'key' => 'group_staff_details',
            'title' => 'Detail Tenaga Kependidikan',
            'fields' => array(
                array(
                    'key' => 'field_staff_nip',
                    'label' => 'NIP / NIDN',
                    'name' => 'nip',
                    'type' => 'text',
                    'instructions' => 'Masukkan NIP atau Nomor Identitas Staff.',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_staff_department_taxonomy',
                    'label' => 'Departemen Staff',
                    'name' => 'department',
                    'type' => 'taxonomy',
                    'taxonomy' => 'staff_department',
                    'field_type' => 'select',
                    'allow_null' => 1,
                    'add_term' => 1,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'id',
                    'multiple' => 0,
                    'instructions' => 'Pilih Departemen Staff dari dropdown, atau klik tombol + Tambah Departemen Staff Baru.',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'staff',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'description' => 'Metabox detail tenaga kependidikan',
            'show_in_rest' => 1,
        ));
    }
}

// Sync associated_ormawa meta to related_ormawa meta for compatibility
add_action('acf/save_post', function($post_id) {
    if (get_post_type($post_id) === 'ormawa_gallery') {
        $ormawa_id = get_field('associated_ormawa', $post_id);
        if ($ormawa_id) {
            update_post_meta($post_id, 'related_ormawa', $ormawa_id);
        }
    }
}, 20);

/* ========================================
   REGISTER ACF FIELD GROUPS (TATA TERTIB)
======================================== */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_6a1200tata_tertib',
        'title' => 'Content Block Tata Tertib',
        'fields' => [
            [
                'key' => 'field_6a1200_tt_title',
                'label' => 'Tata Tertib Header Title',
                'name' => 'tata_tertib_title',
                'type' => 'text',
                'default_value' => 'Tata Tertib Kehidupan Kampus',
            ],
            [
                'key' => 'field_d3_mi_kediri_achievements_sikap',
                'label' => 'Capaian Pembelajaran Sikap',
                'name' => 'd3_mi_kediri_achievements_sikap',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Sikap',
                'sub_fields' => [
                    [
                        'key' => 'field_d3_mi_kediri_ach_sikap_code',
                        'label' => 'Kode',
                        'name' => 'code',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_d3_mi_kediri_ach_sikap_desc',
                        'label' => 'Deskripsi',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'key' => 'field_d3_mi_kediri_achievements_pengetahuan',
                'label' => 'Capaian Pembelajaran Penguasaan Pengetahuan',
                'name' => 'd3_mi_kediri_achievements_pengetahuan',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Penguasaan Pengetahuan',
                'sub_fields' => [
                    [
                        'key' => 'field_d3_mi_kediri_ach_pengetahuan_code',
                        'label' => 'Kode',
                        'name' => 'code',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_d3_mi_kediri_ach_pengetahuan_desc',
                        'label' => 'Deskripsi',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'key' => 'field_d3_mi_kediri_achievements_khusus',
                'label' => 'Capaian Pembelajaran Keterampilan Khusus',
                'name' => 'd3_mi_kediri_achievements_khusus',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Keterampilan Khusus',
                'sub_fields' => [
                    [
                        'key' => 'field_d3_mi_kediri_ach_khusus_code',
                        'label' => 'Kode',
                        'name' => 'code',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_d3_mi_kediri_ach_khusus_desc',
                        'label' => 'Deskripsi',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'key' => 'field_d3_mi_kediri_achievements_umum',
                'label' => 'Capaian Pembelajaran Keterampilan Umum',
                'name' => 'd3_mi_kediri_achievements_umum',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Keterampilan Umum',
                'sub_fields' => [
                    [
                        'key' => 'field_d3_mi_kediri_ach_umum_code',
                        'label' => 'Kode',
                        'name' => 'code',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_d3_mi_kediri_ach_umum_desc',
                        'label' => 'Deskripsi',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
            [
                'key' => 'field_6a1200_tt_desc',
                'label' => 'Tata Tertib Header Description',
                'name' => 'tata_tertib_description',
                'type' => 'textarea',
                'default_value' => 'Tata tertib kehidupan kampus di Polinema disusun untuk menjaga ketertiban dan kedisiplinan di lingkungan kampus.',
            ],
            [
                'key' => 'field_6a1200_hak_title',
                'label' => 'Hak Mahasiswa Title',
                'name' => 'hak_title',
                'type' => 'text',
                'default_value' => 'Hak Mahasiswa',
            ],
            [
                'key' => 'field_6a1200_hak_icon',
                'label' => 'Hak Mahasiswa Icon',
                'name' => 'hak_icon',
                'type' => 'text',
                'default_value' => 'ph-user-check',
            ],
            [
                'key' => 'field_6a1200_hak_list',
                'label' => 'Hak Mahasiswa List',
                'name' => 'hak_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Hak Mahasiswa',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_hak_item_text',
                        'label' => 'Poin Hak',
                        'name' => 'item',
                        'type' => 'textarea',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_hak_content',
                'label' => 'Hak Mahasiswa Content (WYSIWYG)',
                'name' => 'hak_content',
                'type' => 'wysiwyg',
            ],
            [
                'key' => 'field_6a1200_kewajiban_title',
                'label' => 'Kewajiban Mahasiswa Title',
                'name' => 'kewajiban_title',
                'type' => 'text',
                'default_value' => 'Kewajiban Mahasiswa',
            ],
            [
                'key' => 'field_6a1200_kewajiban_icon',
                'label' => 'Kewajiban Mahasiswa Icon',
                'name' => 'kewajiban_icon',
                'type' => 'text',
                'default_value' => 'ph-clipboard-text',
            ],
            [
                'key' => 'field_6a1200_kewajiban_list',
                'label' => 'Kewajiban Mahasiswa List',
                'name' => 'kewajiban_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Kewajiban',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_kewajiban_item_text',
                        'label' => 'Poin Kewajiban',
                        'name' => 'item',
                        'type' => 'textarea',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_kewajiban_content',
                'label' => 'Kewajiban Mahasiswa Content (WYSIWYG)',
                'name' => 'kewajiban_content',
                'type' => 'wysiwyg',
            ],
            [
                'key' => 'field_6a1200_larangan_title',
                'label' => 'Larangan Title',
                'name' => 'larangan_title',
                'type' => 'text',
                'default_value' => 'Larangan bagi Mahasiswa',
            ],
            [
                'key' => 'field_6a1200_larangan_icon',
                'label' => 'Larangan Icon',
                'name' => 'larangan_icon',
                'type' => 'text',
                'default_value' => 'ph-warning-octagon',
            ],
            [
                'key' => 'field_6a1200_larangan_list',
                'label' => 'Larangan List',
                'name' => 'larangan_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Larangan',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_larangan_item_text',
                        'label' => 'Poin Larangan',
                        'name' => 'item',
                        'type' => 'textarea',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_larangan_content',
                'label' => 'Larangan Content (WYSIWYG)',
                'name' => 'larangan_content',
                'type' => 'wysiwyg',
            ],
            [
                'key' => 'field_6a1200_klasifikasi_title',
                'label' => 'Klasifikasi Section Title',
                'name' => 'klasifikasi_title',
                'type' => 'text',
                'default_value' => 'Klasifikasi dan Tingkat Pelanggaran',
            ],
            [
                'key' => 'field_6a1200_klasifikasi_icon',
                'label' => 'Klasifikasi Icon',
                'name' => 'klasifikasi_icon',
                'type' => 'text',
                'default_value' => 'ph-list-checks',
            ],
            [
                'key' => 'field_6a1200_klasifikasi_desc',
                'label' => 'Klasifikasi Description',
                'name' => 'klasifikasi_description',
                'type' => 'textarea',
                'default_value' => 'Pelanggaran terhadap tata tertib di atas dikategori menjadi 5 tingkat pelanggaran:',
            ],
            [
                'key' => 'field_6a1200_tingkat_list',
                'label' => 'Tingkat Pelanggaran List',
                'name' => 'tingkat_pelanggaran_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Tingkat Pelanggaran',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_tingkat_nama',
                        'label' => 'Tingkat Pelanggaran',
                        'name' => 'tingkat',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_6a1200_tingkat_kategori',
                        'label' => 'Kategori',
                        'name' => 'kategori',
                        'type' => 'text',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_akumulasi_title',
                'label' => 'Akumulasi Title',
                'name' => 'akumulasi_title',
                'type' => 'text',
                'default_value' => 'Aturan Akumulasi Pelanggaran',
            ],
            [
                'key' => 'field_6a1200_akumulasi_desc',
                'label' => 'Akumulasi Description',
                'name' => 'akumulasi_description',
                'type' => 'textarea',
                'default_value' => 'Pelanggaran Tata Tertib Kehidupan Kampus akan diakumulasikan untuk setiap kategori pelanggaran dan berlaku sepanjang mahasiswa masih tercatat sebagai mahasiswa di Polinema. Akumulasi Pelanggaran Tata Tertib Kehidupan kampus mengikuti aturan sebagai berikut:',
            ],
            [
                'key' => 'field_6a1200_akumulasi_list',
                'label' => 'Akumulasi List',
                'name' => 'akumulasi_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Tambah Aturan Akumulasi',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_akumulasi_rule_text',
                        'label' => 'Aturan Akumulasi',
                        'name' => 'rule',
                        'type' => 'textarea',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_sanksi_title',
                'label' => 'Sanksi Title',
                'name' => 'sanksi_title',
                'type' => 'text',
                'default_value' => 'Sanksi Pelanggaran',
            ],
            [
                'key' => 'field_6a1200_sanksi_icon',
                'label' => 'Sanksi Icon',
                'name' => 'sanksi_icon',
                'type' => 'text',
                'default_value' => 'ph-shield-warning',
            ],
            [
                'key' => 'field_6a1200_sanksi_list',
                'label' => 'Sanksi List',
                'name' => 'sanksi_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Tambah Sanksi',
                'sub_fields' => [
                    [
                        'key' => 'field_6a1200_sanksi_tingkat',
                        'label' => 'Tingkat Sanksi',
                        'name' => 'tingkat',
                        'type' => 'text',
                    ],
                    [
                        'key' => 'field_6a1200_sanksi_detail',
                        'label' => 'Detail Sanksi',
                        'name' => 'detail',
                        'type' => 'wysiwyg',
                    ]
                ]
            ],
            [
                'key' => 'field_6a1200_sanksi_content',
                'label' => 'Sanksi Content (WYSIWYG)',
                'name' => 'sanksi_content',
                'type' => 'wysiwyg',
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/pages/tata-tertib-page.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (KALENDER AKADEMIK)
    ======================================== */
    acf_add_local_field_group([
        'key' => 'group_kalender_akademik_page',
        'title' => 'Content Kalender Akademik',
        'fields' => [
            [
                'key' => 'field_kalender_akademik_title',
                'label' => 'Judul Kalender Akademik',
                'name' => 'kalender_akademik_title',
                'type' => 'text',
                'instructions' => 'Judul utama pada halaman kalender akademik',
                'default_value' => 'Kalender Akademik',
            ],
            [
                'key' => 'field_kalender_akademik_description',
                'label' => 'Deskripsi Kalender Akademik',
                'name' => 'kalender_akademik_description',
                'type' => 'wysiwyg',
                'instructions' => 'Deskripsi atau catatan seputar Kalender Akademik',
                'default_value' => 'Berikut adalah Kalender Akademik Jurusan Teknologi Informasi Polinema.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_kalender_akademik_image',
                'label' => 'Gambar Kalender Akademik',
                'name' => 'kalender_akademik_image',
                'type' => 'image',
                'instructions' => 'Upload atau pilih gambar Kalender Akademik (akan ditampilkan secara besar)',
                'return_format' => 'array',
                'preview_size' => 'large',
                'library' => 'all',
            ],
            [
                'key' => 'field_kalender_akademik_download_text',
                'label' => 'Teks Keterangan Download',
                'name' => 'kalender_akademik_download_text',
                'type' => 'text',
                'instructions' => 'Contoh: Untuk Download Kalender Akademik Tahun Akademik 2025 / 2026',
                'default_value' => 'Untuk Download Kalender Akademik Tahun Akademik 2025 / 2026',
            ],
            [
                'key' => 'field_kalender_akademik_download_file',
                'label' => 'File Download Kalender Akademik',
                'name' => 'kalender_akademik_download_file',
                'type' => 'file',
                'instructions' => 'Upload file dokumen (PDF/Gambar/Zip) yang dapat di-download',
                'return_format' => 'array',
                'library' => 'all',
            ],
            [
                'key' => 'field_kalender_akademik_download_url',
                'label' => 'Link Download Eksternal (Opsional)',
                'name' => 'kalender_akademik_download_url',
                'type' => 'url',
                'instructions' => 'Link alternatif jika file di-host di luar WordPress (misal: Google Drive)',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/pages/akademik/kalender-akademik-page.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (ALUR MAGANG CPT)
    ======================================== */
    acf_add_local_field_group([
        'key' => 'group_magang_alur_details',
        'title' => 'Detail Tahapan Alur Magang',
        'fields' => [

            [
                'key' => 'field_magang_step',
                'label' => 'Label Tahap',
                'name' => 'step',
                'type' => 'text',
                'instructions' => 'Contoh: Tahap 01, Langkah 1',
            ],
            [
                'key' => 'field_magang_content',
                'label' => 'Deskripsi / Konten',
                'name' => 'content',
                'type' => 'textarea',
                'instructions' => 'Masukkan deskripsi tahapan alur magang.',
                'rows' => 4,
            ],
            [
                'key' => 'field_magang_button_text',
                'label' => 'Teks Tombol Aksi',
                'name' => 'button_text',
                'type' => 'text',
                'instructions' => 'Contoh: Portal JTI, Upload Surat (kosongkan jika tidak ada tombol)',
            ],
            [
                'key' => 'field_magang_button_url',
                'label' => 'URL / Link Tombol',
                'name' => 'button_url',
                'type' => 'url',
                'instructions' => 'Contoh: https://jti.polinema.ac.id/portal',
            ],
            [
                'key' => 'field_magang_icon',
                'label' => 'Ikon Phosphor',
                'name' => 'icon',
                'type' => 'text',
                'instructions' => 'Class ikon Phosphor, contoh: ph-sign-in, ph-user-gear, ph-upload-simple',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'magang_alur',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (KATEGORI MAGANG TAXONOMY)
    ======================================== */
    acf_add_local_field_group([
        'key' => 'group_kategori_magang_info',
        'title' => 'Informasi Kategori Magang',
        'fields' => [
            [
                'key' => 'field_kat_magang_show_info',
                'label' => 'Tampilkan Box Informasi?',
                'name' => 'show_info_box',
                'type' => 'true_false',
                'message' => 'Ya, tampilkan box informasi di atas alur kategori ini',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => 'field_kat_magang_info_type',
                'label' => 'Tipe Box Informasi',
                'name' => 'info_box_type',
                'type' => 'select',
                'choices' => [
                    'info' => 'Info (Biru)',
                    'warning' => 'Warning (Kuning)',
                    'success' => 'Success (Hijau)',
                    'error' => 'Error (Merah)',
                ],
                'default_value' => 'info',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_kat_magang_show_info',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_kat_magang_info_title',
                'label' => 'Judul Informasi',
                'name' => 'info_box_title',
                'type' => 'text',
                'default_value' => 'Informasi Penting',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_kat_magang_show_info',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_kat_magang_info_icon',
                'label' => 'Ikon Informasi (Phosphor)',
                'name' => 'info_box_icon',
                'type' => 'text',
                'default_value' => 'ph-info',
                'instructions' => 'Contoh: ph-info, ph-lightbulb, ph-warning',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_kat_magang_show_info',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_kat_magang_info_content',
                'label' => 'Konten Informasi',
                'name' => 'info_box_content',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_kat_magang_show_info',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'kategori_magang',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (ATURAN AKADEMIK CPT)
    ======================================== */

    // Field Group untuk CPT Aturan Akademik (Setiap Sub-Judul)
    acf_add_local_field_group([
        'key'    => 'group_cpt_aturan_akademik',
        'title'  => 'Detail Aturan Akademik',
        'fields' => [
            [
                'key'          => 'field_aa_cpt_description',
                'label'        => 'Deskripsi Konten',
                'name'         => 'aa_description',
                'type'         => 'wysiwyg',
                'instructions' => 'Isi konten sub-judul ini. Mendukung paragraf biasa, bullet list (•), dan penomoran (1. 2. 3.).',
                'required'     => 0,
                'media_upload' => 0,
                'toolbar'      => 'full',
                'tabs'         => 'visual',
            ],
            // Field aa_icon dihapus dari form admin.
            // Icon di-generate otomatis dari judul via hook acf/save_post
            // menggunakan fungsi webjti_get_aturan_akademik_auto_icon().
            [
                'key'           => 'field_aa_cpt_image',
                'label'         => 'Gambar Pendukung (Opsional)',
                'name'          => 'aa_image',
                'type'          => 'image',
                'instructions'  => 'Upload foto atau diagram pendukung jika ada',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'          => 'field_aa_cpt_caption',
                'label'        => 'Caption Gambar (Opsional)',
                'name'         => 'aa_caption',
                'type'         => 'text',
                'instructions' => 'Keterangan di bawah foto',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'aturan_akademik',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (COMPANY PARTNER CPT)
    ======================================== */

    // ACF Fields for Company Partner CPT
    acf_add_local_field_group([
        'key' => 'group_company_partner_details',
        'title' => 'Detail Perusahaan Magang',
        'fields' => [
            [
                'key' => 'field_company_category',
                'label' => 'Bidang Industri / Kategori',
                'name' => 'category',
                'type' => 'text',
                'instructions' => 'Contoh: Telecommunication & IT, Banking, E-Commerce, Software House',
            ],
            [
                'key' => 'field_company_location',
                'label' => 'Lokasi / Kota',
                'name' => 'location',
                'type' => 'text',
                'instructions' => 'Contoh: Malang, Surabaya, Jakarta, Remote',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'company_partner',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (DEDICATION CPT)
    ======================================== */

    acf_add_local_field_group([
        'key' => 'group_dedication_details',
        'title' => 'Detail Pengabdian Masyarakat',
        'fields' => [
            [
                'key' => 'field_dedication_year',
                'label' => 'Tahun Pelaksanaan',
                'name' => 'year',
                'type' => 'text',
                'instructions' => 'Tahun pelaksanaan kegiatan pengabdian masyarakat (contoh: 2025, 2024)',
                'required' => 1,
                'default_value' => date('Y'),
            ],
            [
                'key' => 'field_dedication_leader',
                'label' => 'Ketua Tim',
                'name' => 'leader',
                'type' => 'select',
                'instructions' => 'Pilih Ketua Tim dari daftar Tenaga Pengajar, atau ketik nama baru (dosen luar) lalu tekan Enter',
                'required' => 1,
                'choices' => [],
                'default_value' => [],
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'placeholder' => 'Pilih atau ketik nama Ketua...',
                'allow_custom' => 1,
            ],
            [
                'key' => 'field_dedication_members',
                'label' => 'Anggota Tim',
                'name' => 'members',
                'type' => 'select',
                'instructions' => 'Pilih Anggota Tim dari daftar Tenaga Pengajar, atau ketik nama baru (dosen luar) lalu tekan Enter',
                'required' => 0,
                'choices' => [],
                'default_value' => [],
                'allow_null' => 1,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'placeholder' => 'Pilih atau ketik nama Anggota...',
                'allow_custom' => 1,
            ],
            [
                'key' => 'field_dedication_study_program',
                'label' => 'Program Studi',
                'name' => 'study_program',
                'type' => 'post_object',
                'instructions' => 'Pilih program studi yang terkait',
                'required' => 1,
                'post_type' => ['study_program', 'prodi', 'program_studi'],
                'return_format' => 'id',
                'ui' => 1,
            ],
            [
                'key' => 'field_dedication_scheme',
                'label' => 'Skema Pengabdian',
                'name' => 'scheme',
                'type' => 'post_object',
                'instructions' => 'Pilih skema pengabdian masyarakat',
                'required' => 1,
                'post_type' => ['dedication_scheme'],
                'return_format' => 'id',
                'ui' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'dedication',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (SARANA DAN PRASARANA PAGE)
    ======================================== */

    acf_add_local_field_group([
        'key'   => 'group_sarana_page',
        'title' => 'Sarana dan Prasarana - Header',
        'fields' => [
            [
                'key'           => 'field_sarana_intro_title',
                'label'         => 'Judul Header Halaman',
                'name'          => 'sarana_intro_title',
                'type'          => 'text',
                'instructions'  => 'Judul utama yang tampil di header halaman (kotak biru).',
                'default_value' => 'Sarana dan Prasarana',
            ],
            [
                'key'           => 'field_sarana_intro_desc',
                'label'         => 'Deskripsi Singkat Header',
                'name'          => 'sarana_intro_desc',
                'type'          => 'text',
                'instructions'  => 'Teks pendek di bawah judul header (opsional).',
                'default_value' => '',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/pages/sarana-prasarana-page.php',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (FASILITAS CPT)
    ======================================== */

    acf_add_local_field_group([
        'key'   => 'group_fasilitas_cpt',
        'title' => 'Detail Fasilitas',
        'fields' => [
            [
                'key'          => 'field_fasilitas_description',
                'label'        => 'Deskripsi Fasilitas',
                'name'         => 'fasilitas_description',
                'type'         => 'wysiwyg',
                'instructions' => 'Deskripsi lengkap mengenai fasilitas ini.',
                'toolbar'      => 'basic',
                'media_upload' => 0,
                'tabs'         => 'visual',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'fasilitas',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (KATEGORI FASILITAS TAXONOMY)
    ======================================== */

    acf_add_local_field_group([
        'key'   => 'group_kategori_fasilitas_taxonomy',
        'title' => 'Pengaturan Kategori Fasilitas',
        'fields' => [
            [
                'key'           => 'field_kategori_icon',
                'label'         => 'Icon Tab (Phosphor Class)',
                'name'          => 'kategori_icon',
                'type'          => 'text',
                'instructions'  => 'Nama class icon Phosphor untuk tombol tab kategori ini (contoh: ph-chalkboard-teacher, ph-users-three, ph-buildings, ph-monitor, ph-wheelchair). Lihat: phosphoricons.com',
                'default_value' => 'ph-folder',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'kategori_fasilitas',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (KERJASAMA PAGE)
    ======================================== */

    acf_add_local_field_group([
        'key'   => 'group_cooperation_page',
        'title' => 'Manajemen Konten Kerjasama',
        'fields' => [
            [
                'key'           => 'field_cooperation_title',
                'label'         => 'Judul Header Kerjasama',
                'name'          => 'cooperation_title',
                'type'          => 'text',
                'instructions'  => 'Judul section kerjasama. Kosongkan untuk menggunakan judul default.',
                'default_value' => 'Inisiasi Kerjasama - Jurusan Teknologi Informasi, Politeknik Negeri Malang',
            ],
            [
                'key'           => 'field_cooperation_description',
                'label'         => 'Konten Deskriptif',
                'name'          => 'cooperation_description',
                'type'          => 'wysiwyg',
                'instructions'  => 'Isi deskripsi / informasi lengkap mengenai kerjasama. Jika kosong, akan menggunakan teks default.',
                'media_upload'  => 1,
                'toolbar'       => 'full',
                'tabs'          => 'visual',
            ],
            [
                'key'           => 'field_cooperation_image',
                'label'         => 'Gambar Banner / Ilustrasi Kerjasama (Opsional)',
                'name'          => 'cooperation_image',
                'type'          => 'image',
                'instructions'  => 'Upload gambar banner atau ilustrasi untuk halaman kerjasama.',
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_cooperation_button_show',
                'label'         => 'Tampilkan Tombol Action / Redirect?',
                'name'          => 'cooperation_button_show',
                'type'          => 'true_false',
                'instructions'  => 'Aktifkan jika ingin mengarahkan pengunjung ke form/link luar (misal: Form Pengajuan Kerjasama).',
                'ui'            => 1,
                'default_value' => 0,
            ],
            [
                'key'           => 'field_cooperation_button_text',
                'label'         => 'Teks Tombol',
                'name'          => 'cooperation_button_text',
                'type'          => 'text',
                'instructions'  => 'Teks yang tampil di tombol (contoh: Ajukan Kerjasama / Hubungi Kami).',
                'default_value' => 'Ajukan Kerjasama',
                'conditional_logic' => [
                    [
                        [
                            'field'    => 'field_cooperation_button_show',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ],
            [
                'key'           => 'field_cooperation_button_url',
                'label'         => 'Link Destination (URL)',
                'name'          => 'cooperation_button_url',
                'type'          => 'url',
                'instructions'  => 'Tujuan URL saat tombol diklik (contoh: https://forms.gle/... atau mailto:jti@polinema.ac.id).',
                'default_value' => '',
                'conditional_logic' => [
                    [
                        [
                            'field'    => 'field_cooperation_button_show',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ],
            [
                'key'           => 'field_cooperation_button_target',
                'label'         => 'Buka Link di Tab Baru?',
                'name'          => 'cooperation_button_target',
                'type'          => 'select',
                'choices'       => [
                    '_blank' => 'Ya, buka di tab baru (_blank)',
                    '_self'  => 'Tidak, buka di tab yang sama (_self)',
                ],
                'default_value' => '_blank',
                'conditional_logic' => [
                    [
                        [
                            'field'    => 'field_cooperation_button_show',
                            'operator' => '==',
                            'value'    => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/pages/cooperation-page.php',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (MAGANG PAGE)
    ======================================== */

    acf_add_local_field_group([
        'key'   => 'group_magang_page_settings',
        'title' => 'Pengaturan Halaman Magang / PKL',
        'fields' => [

            // ============================
            // TAB: Box Info Magang Kolektif
            // ============================
            [
                'key'       => 'field_magang_acf_tab_kolektif',
                'label'     => 'Box Info: Magang Kolektif',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],
            [
                'key'           => 'field_magang_info_box_kolektif_show',
                'label'         => 'Tampilkan Box Informasi?',
                'name'          => 'magang_info_box_kolektif_show',
                'type'          => 'true_false',
                'instructions'  => 'Aktifkan untuk menampilkan kotak informasi di bagian atas section Magang Kolektif (tepat di bawah tombol tab).',
                'ui'            => 1,
                'default_value' => 1,
            ],
            [
                'key'           => 'field_magang_info_box_kolektif_type',
                'label'         => 'Tipe / Gaya Box',
                'name'          => 'magang_info_box_kolektif_type',
                'type'          => 'select',
                'choices'       => [
                    'info'    => 'Info (Biru)',
                    'warning' => 'Peringatan / Catatan (Kuning)',
                    'success' => 'Petunjuk / Sukses (Hijau)',
                ],
                'default_value' => 'info',
                'conditional_logic' => [[['field' => 'field_magang_info_box_kolektif_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_kolektif_title',
                'label'         => 'Judul Box Informasi',
                'name'          => 'magang_info_box_kolektif_title',
                'type'          => 'text',
                'default_value' => 'Informasi Penting: Magang Kolektif Mitra JTI',
                'conditional_logic' => [[['field' => 'field_magang_info_box_kolektif_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_kolektif_icon',
                'label'         => 'Ikon Phosphor',
                'name'          => 'magang_info_box_kolektif_icon',
                'type'          => 'text',
                'instructions'  => 'Contoh: ph-info, ph-lightbulb, ph-warning-circle, ph-check-circle',
                'default_value' => 'ph-info',
                'conditional_logic' => [[['field' => 'field_magang_info_box_kolektif_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_kolektif_content',
                'label'         => 'Isi / Konten Informasi',
                'name'          => 'magang_info_box_kolektif_content',
                'type'          => 'wysiwyg',
                'instructions'  => 'Isi penjelasan tambahan yang akan ditampilkan di bagian atas section Magang Kolektif.',
                'media_upload'  => 0,
                'toolbar'       => 'basic',
                'default_value' => '<p><strong>Magang Kolektif</strong> dikelola secara terpusat oleh Jurusan TI bekerjasama dengan Perusahaan Mitra resmi. Mahasiswa memilih dan mendaftar lowongan yang telah disediakan di portal.</p>',
                'conditional_logic' => [[['field' => 'field_magang_info_box_kolektif_show', 'operator' => '==', 'value' => '1']]],
            ],

            // ============================
            // TAB: Box Info Magang Mandiri
            // ============================
            [
                'key'       => 'field_magang_acf_tab_mandiri',
                'label'     => 'Box Info: Magang Mandiri',
                'name'      => '',
                'type'      => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ],
            [
                'key'           => 'field_magang_info_box_mandiri_show',
                'label'         => 'Tampilkan Box Informasi?',
                'name'          => 'magang_info_box_mandiri_show',
                'type'          => 'true_false',
                'instructions'  => 'Aktifkan untuk menampilkan kotak informasi di bagian atas section Magang Mandiri (tepat di bawah tombol tab).',
                'ui'            => 1,
                'default_value' => 0,
            ],
            [
                'key'           => 'field_magang_info_box_mandiri_type',
                'label'         => 'Tipe / Gaya Box',
                'name'          => 'magang_info_box_mandiri_type',
                'type'          => 'select',
                'choices'       => [
                    'info'    => 'Info (Biru)',
                    'warning' => 'Peringatan / Catatan (Kuning)',
                    'success' => 'Petunjuk / Sukses (Hijau)',
                ],
                'default_value' => 'warning',
                'conditional_logic' => [[['field' => 'field_magang_info_box_mandiri_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_mandiri_title',
                'label'         => 'Judul Box Informasi',
                'name'          => 'magang_info_box_mandiri_title',
                'type'          => 'text',
                'default_value' => 'Informasi Penting: Magang Mandiri',
                'conditional_logic' => [[['field' => 'field_magang_info_box_mandiri_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_mandiri_icon',
                'label'         => 'Ikon Phosphor',
                'name'          => 'magang_info_box_mandiri_icon',
                'type'          => 'text',
                'instructions'  => 'Contoh: ph-info, ph-lightbulb, ph-warning-circle, ph-check-circle',
                'default_value' => 'ph-lightbulb',
                'conditional_logic' => [[['field' => 'field_magang_info_box_mandiri_show', 'operator' => '==', 'value' => '1']]],
            ],
            [
                'key'           => 'field_magang_info_box_mandiri_content',
                'label'         => 'Isi / Konten Informasi',
                'name'          => 'magang_info_box_mandiri_content',
                'type'          => 'wysiwyg',
                'instructions'  => 'Isi penjelasan tambahan yang akan ditampilkan di bagian atas section Magang Mandiri.',
                'media_upload'  => 0,
                'toolbar'       => 'basic',
                'default_value' => '<p><strong>Magang Mandiri</strong> adalah program magang yang mahasiswa usulkan sendiri ke perusahaan atau instansi di luar daftar mitra resmi JTI. Pengajuan dilakukan melalui portal dengan verifikasi kelayakan dari tim magang jurusan.</p>',
                'conditional_logic' => [[['field' => 'field_magang_info_box_mandiri_show', 'operator' => '==', 'value' => '1']]],
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/pages/magang-page.php',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS (S2 REKAYASA TEKNOLOGI INFORMASI PAGE)
    ======================================== */

    acf_add_local_field_group([
        'key' => 'group_s2_rekayasa_teknologi_informasi_page', 
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman S2 Rekayasa Teknologi Informasi',
        'fields' => [
            [
                'key' => 'field_s2_rekayasa_intro',
                'label' => 'Intro Konten',
                'name' => 's2_rekayasa_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman S2 Rekayasa Teknologi Informasi.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_vision',
                'label' => 'Visi',
                'name' => 's2_rekayasa_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_mission',
                'label' => 'Misi',
                'name' => 's2_rekayasa_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_goals',
                'label' => 'Tujuan',
                'name' => 's2_rekayasa_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_strategies',
                'label' => 'Strategi',
                'name' => 's2_rekayasa_strategies',
                'type' => 'wysiwyg',
                'instructions' => 'Isi strategi program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_profiles',
                'label' => 'Profil Lulusan',
                'name' => 's2_rekayasa_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan dari daftar CPT profil_lulusan.',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 's2_rekayasa_outcomes',
                'type' => 'wysiwyg',
                'instructions' => 'Isi capaian lulusan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_bahan_kajian',
                'label' => 'Bahan Kajian',
                'name' => 's2_rekayasa_bahan_kajian',
                'type' => 'relationship',
                'instructions' => 'Pilih bahan kajian dari daftar CPT bahan_kajian.',
                'post_type' => ['bahan_kajian'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 's2_rekayasa_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang terkait dengan program studi ini.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_specialization_groups',
                'label' => 'Matakuliah Spesialisasi',
                'name' => 's2_rekayasa_specialization_groups',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah spesialisasi yang terkait dengan program studi ini.',
                'post_type' => ['mk_spesialis'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_expertise_groups',
                'label' => 'Bidang Keahlian',
                'name' => 's2_rekayasa_expertise_groups',
                'type' => 'relationship',
                'instructions' => 'Pilih bidang keahlian dari daftar CPT bidang_keahlian.',
                'post_type' => ['bidang_keahlian'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 's2_rekayasa_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_registration',
                'label' => 'Konten Pendaftaran',
                'name' => 's2_rekayasa_registration',
                'type' => 'wysiwyg',
                'instructions' => 'Isi informasi tahapan pendaftaran untuk program studi ini.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
        ],
        'location' => isset($s2_rekayasa_page_location)
            ? $s2_rekayasa_page_location
            : [
                [
                    [
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/pages/akademik/s2-rekayasa-teknologi-informasi-page.php',
                    ],
                ],
            ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_bahan_kajian_details',
        'title' => 'Detail Bahan Kajian',
        'fields' => [
            [
                'key' => 'field_bahan_kajian_category',
                'label' => 'Kategori',
                'name' => 'kategori',
                'type' => 'text',
                'instructions' => 'Kategori bahan kajian.',
            ],
            [
                'key' => 'field_bahan_kajian_description',
                'label' => 'Deskripsi',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Deskripsi singkat bahan kajian.',
                'rows' => 4,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'bahan_kajian',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_bidang_keahlian_details',
        'title' => 'Detail Bidang Keahlian',
        'fields' => [
            [
                'key' => 'field_bidang_keahlian_category',
                'label' => 'Kategori',
                'name' => 'kategori',
                'type' => 'text',
                'instructions' => 'Kategori bidang keahlian.',
            ],
            [
                'key' => 'field_bidang_keahlian_description',
                'label' => 'Deskripsi',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Deskripsi singkat bidang keahlian.',
                'rows' => 4,
            ],
            [
                'key' => 'field_bidang_keahlian_lecturers',
                'label' => 'Daftar Dosen',
                'name' => 'lecturers',
                'type' => 'relationship',
                'instructions' => 'Pilih dosen dari CPT Lecturers',
                'post_type' => 'lecturer',
                'return_format' => 'object',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'bidang_keahlian',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER LABORATORY ACF FIELDS PROGRAMMATICALLY
    ======================================== */
    acf_add_local_field_group([
        'key' => 'group_laboratory_details',
        'title' => 'Detail Laboratorium',
        'fields' => [
            [
                'key' => 'field_lab_code',
                'label' => 'Kode / Akronim Laboratorium',
                'name' => 'lab_code',
                'type' => 'text',
                'instructions' => 'contoh: NSC, RPL, IVSS, InLET, BA, DT, MMT, IS',
                'required' => 0,
            ],
            [
                'key' => 'field_lab_logo',
                'label' => 'Logo Laboratorium',
                'name' => 'logo',
                'type' => 'image',
                'instructions' => 'Upload logo laboratorium',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ],
            [
                'key' => 'field_lab_head',
                'label' => 'Kepala Laboratorium',
                'name' => 'lab_head',
                'type' => 'post_object',
                'instructions' => 'Pilih dosen Kepala Laboratorium',
                'post_type' => ['lecturer'],
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'object',
            ],
            [
                'key' => 'field_lab_members',
                'label' => 'Anggota & Peneliti Laboratorium',
                'name' => 'lab_members',
                'type' => 'post_object',
                'instructions' => 'Pilih dosen Anggota Laboratorium',
                'post_type' => ['lecturer'],
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'object',
            ],
            [
                'key' => 'field_lab_short_description',
                'label' => 'Deskripsi Singkat',
                'name' => 'short_description',
                'type' => 'textarea',
                'instructions' => 'Ringkasan singkat mengenai fokus dan kegiatan laboratorium',
                'rows' => 3,
            ],
            [
                'key' => 'field_lab_room_location',
                'label' => 'Ruangan / Lokasi',
                'name' => 'room_location',
                'type' => 'text',
                'instructions' => 'Lokasi atau nama ruangan, contoh: Gedung Sipil Lt. 4 / Gedung Utama JTI',
            ],
            [
                'key' => 'field_lab_profile_content',
                'label' => 'Profil Laboratorium',
                'name' => 'profile_content',
                'type' => 'wysiwyg',
                'instructions' => 'Teks penjelasan profil laboratorium.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
            [
                'key' => 'field_lab_vision',
                'label' => 'Visi Laboratorium',
                'name' => 'vision',
                'type' => 'wysiwyg',
                'instructions' => 'Visi laboratorium.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
            [
                'key' => 'field_lab_mission',
                'label' => 'Misi Laboratorium',
                'name' => 'mission',
                'type' => 'wysiwyg',
                'instructions' => 'Misi laboratorium.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
            [
                'key' => 'field_lab_focus_media',
                'label' => 'Media & Teks Fokus Riset',
                'name' => 'focus_media',
                'type' => 'wysiwyg',
                'instructions' => 'Teks tambahan dan gambar/media untuk bagian Fokus Riset.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
            [
                'key' => 'field_lab_sop_services',
                'label' => 'SOP & Layanan',
                'name' => 'sop_services',
                'type' => 'wysiwyg',
                'instructions' => 'Informasi SOP dan Layanan Laboratorium.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
            [
                'key' => 'field_lab_partnership_content',
                'label' => 'Kerjasama & Partnership',
                'name' => 'partnership_content',
                'type' => 'wysiwyg',
                'instructions' => 'Informasi Kerjasama dan Partnership Laboratorium.',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'laboratory',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
       REGISTER ACF FIELD GROUPS FOR LABORATORY SUB-CPTs
    ======================================== */

    // 1. Fasilitas & Peralatan, Kegiatan & Proyek, Perkuliahan Terkait (Title, Deskripsi Textarea, Pilih Lab)
    acf_add_local_field_group([
        'key'   => 'group_lab_feature_details',
        'title' => 'Detail Item Laboratorium',
        'fields' => [
            [
                'key'          => 'field_lab_feature_related_lab',
                'label'        => 'Pilih Laboratorium',
                'name'         => 'related_lab',
                'type'         => 'post_object',
                'instructions' => 'Pilih Laboratorium pemilik item ini.',
                'required'     => 1,
                'post_type'    => ['laboratory'],
                'return_format'=> 'id',
                'ui'           => 1,
                'allow_null'   => 0,
            ],
            [
                'key'          => 'field_lab_feature_item_description',
                'label'        => 'Deskripsi / Keterangan',
                'name'         => 'item_description',
                'type'         => 'textarea',
                'instructions' => 'Tuliskan deskripsi singkat mengenai item ini.',
                'required'     => 0,
                'rows'         => 4,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_facility',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_activity',
                ],
            ],
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_course',
                ],
            ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'     => true,
    ]);

    // 2. Fokus Riset (Hanya Title dari WP dan Pilih Lab)
    acf_add_local_field_group([
        'key'   => 'group_lab_focus_details',
        'title' => 'Detail Fokus Riset',
        'fields' => [
            [
                'key'          => 'field_lab_focus_related_lab',
                'label'        => 'Pilih Laboratorium',
                'name'         => 'related_lab',
                'type'         => 'post_object',
                'instructions' => 'Pilih Laboratorium yang memiliki Fokus Riset ini (Judul akan ditampilkan sebagai Tag/Badge).',
                'required'     => 1,
                'post_type'    => ['laboratory'],
                'return_format'=> 'id',
                'ui'           => 1,
                'allow_null'   => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_focus',
                ],
            ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'     => true,
    ]);

    // 3. Galeri Video
    acf_add_local_field_group([
        'key'   => 'group_lab_video_details',
        'title' => 'Detail Galeri Video',
        'fields' => [
            [
                'key'          => 'field_lab_video_related_lab',
                'label'        => 'Pilih Laboratorium',
                'name'         => 'related_lab',
                'type'         => 'post_object',
                'instructions' => 'Pilih Laboratorium pemilik video ini.',
                'required'     => 1,
                'post_type'    => ['laboratory'],
                'return_format'=> 'id',
                'ui'           => 1,
                'allow_null'   => 0,
            ],
            [
                'key'          => 'field_lab_video_youtube_link',
                'label'        => 'Link Video YouTube',
                'name'         => 'youtube_link',
                'type'         => 'url',
                'instructions' => 'Masukkan link video YouTube (contoh: https://www.youtube.com/watch?v=...).',
                'required'     => 1,
            ],
            [
                'key'          => 'field_lab_video_thumbnail',
                'label'        => 'Media / Thumbnail Video (Opsional Override)',
                'name'         => 'video_thumbnail',
                'type'         => 'image',
                'instructions' => 'Upload gambar thumbnail custom (jika dikosongkan, thumbnail YouTube akan digunakan otomatis).',
                'return_format'=> 'url',
                'preview_size' => 'medium',
                'library'      => 'all',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_video',
                ],
            ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'     => true,
    ]);

    // 4. Galeri Foto Laboratorium
    acf_add_local_field_group([
        'key'   => 'group_lab_gallery_details',
        'title' => 'Detail Galeri Foto',
        'fields' => [
            [
                'key'          => 'field_lab_gallery_related_lab',
                'label'        => 'Pilih Laboratorium',
                'name'         => 'related_lab',
                'type'         => 'post_object',
                'instructions' => 'Pilih Laboratorium pemilik foto galeri ini.',
                'required'     => 1,
                'post_type'    => ['laboratory'],
                'return_format'=> 'id',
                'ui'           => 1,
                'allow_null'   => 0,
            ],
            [
                'key'          => 'field_lab_gallery_single_image',
                'label'        => 'Foto Utama / Media',
                'name'         => 'gallery_image',
                'type'         => 'image',
                'instructions' => 'Upload media/foto galeri.',
                'return_format'=> 'array',
                'preview_size' => 'medium',
                'library'      => 'all',
            ],
            [
                'key'          => 'field_lab_gallery_images',
                'label'        => 'Foto Galeri (Banyak Foto / Opsional)',
                'name'         => 'lab_gallery_images',
                'type'         => 'gallery',
                'instructions' => 'Upload/pilih beberapa foto sekaligus jika ingin mengunggah lebih dari satu gambar.',
                'return_format'=> 'array',
                'insert'       => 'append',
                'library'      => 'all',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'lab_gallery',
                ],
            ],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'     => true,
    ]);

    /* ========================================
      REGISTER ACF FIELD GROUPS (D4 TEKNIK INFORMATIKA PAGE)
    ======================================== */

    $resolve_study_program = function ($slugs, $titles) {
        $slugs = (array) $slugs;
        $titles = (array) $titles;

        foreach ($slugs as $slug) {
            $program = get_page_by_path($slug, OBJECT, 'study_program');
            if ($program && isset($program->ID) && $program->ID > 0) {
                return $program;
            }
        }

        $program_ids = get_posts([
            'post_type'      => 'study_program',
            'post_status'    => ['publish', 'draft', 'pending', 'private'],
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        foreach ($program_ids as $program_id) {
            $post_title = get_the_title($program_id);
            foreach ($titles as $title) {
                if (strcasecmp($post_title, $title) === 0 || stripos($post_title, $title) !== false) {
                    return get_post($program_id);
                }
            }
        }

        return null;
    };

    $d4_ti_study_program = $resolve_study_program(['d4-teknik-informatika', 'd4-ti', 'sarjana-terapan-teknik-informatika'], ['D4 Teknik Informatika', 'D4 TI', 'Sarjana Terapan Teknik Informatika']);
    $d4_sib_study_program = $resolve_study_program(['d4-sistem-informasi-bisnis', 'd4-sib', 'sarjana-terapan-sistem-informasi-bisnis'], ['D4 Sistem Informasi Bisnis', 'D4 SIB', 'Sarjana Terapan Sistem Informasi Bisnis']);
    $s2_rekayasa_study_program = $resolve_study_program(['s2-rekayasa-teknologi-informasi', 's2-rekayasa', 'magister-terapan-rekayasa-teknologi-informasi'], ['S2 Rekayasa Teknologi Informasi', 'S2 Rekayasa', 'Magister Terapan Rekayasa Teknologi Informasi']);
    $d3_mi_kediri_study_program = $resolve_study_program(['d3-mi-kediri', 'd3-mi'], ['D3 Manajemen Informatika Kediri', 'D3 MI Kediri', 'D3 MI']);
    $d3_mi_lumajang_study_program = $resolve_study_program(['d3-mi-lumajang'], ['D3 Manajemen Informatika Lumajang', 'D3 MI Lumajang']);

    $d4_ti_page_location = [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/pages/akademik/d4-teknik-informatika-page.php',
            ],
        ],
    ];
    if ($d4_ti_study_program && $d4_ti_study_program->ID > 0) {
        $d4_ti_page_location[] = [
            [
                'param' => 'post',
                'operator' => '==',
                'value' => (int) $d4_ti_study_program->ID,
            ],
        ];
    }

    $d4_sib_page_location = [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/pages/akademik/d4-sistem-informasi-bisnis-page.php',
            ],
        ],
    ];
    if ($d4_sib_study_program && $d4_sib_study_program->ID > 0) {
        $d4_sib_page_location[] = [
            [
                'param' => 'post',
                'operator' => '==',
                'value' => (int) $d4_sib_study_program->ID,
            ],
        ];
    }

    $s2_rekayasa_page_location = [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/pages/akademik/s2-rekayasa-teknologi-informasi-page.php',
            ],
        ],
    ];
    if ($s2_rekayasa_study_program && $s2_rekayasa_study_program->ID > 0) {
        $s2_rekayasa_page_location[] = [
            [
                'param' => 'post',
                'operator' => '==',
                'value' => (int) $s2_rekayasa_study_program->ID,
            ],
        ];
    }

    $d3_mi_kediri_page_location = [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/pages/akademik/d3-mi-kediri-page.php',
            ],
        ],
    ];
    if ($d3_mi_kediri_study_program && $d3_mi_kediri_study_program->ID > 0) {
        $d3_mi_kediri_page_location[] = [
            [
                'param' => 'post',
                'operator' => '==',
                'value' => (int) $d3_mi_kediri_study_program->ID,
            ],
        ];
    }

    $d3_mi_lumajang_page_location = [
        [
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'templates/pages/akademik/d3-mi-lumajang-page.php',
            ],
        ],
    ];
    if ($d3_mi_lumajang_study_program && $d3_mi_lumajang_study_program->ID > 0) {
        $d3_mi_lumajang_page_location[] = [
            [
                'param' => 'post',
                'operator' => '==',
                'value' => (int) $d3_mi_lumajang_study_program->ID,
            ],
        ];
    }

    acf_add_local_field_group([
        'key' => 'group_d4_teknik_informatika_page', 
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman D4 Teknik Informatika',
        'fields' => [
            [
                'key' => 'field_d4_ti_intro',
                'label' => 'Intro Konten',
                'name' => 'd4_ti_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman D4 Teknik Informatika.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_ti_vision',
                'label' => 'Visi',
                'name' => 'd4_ti_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi D4 Teknik Informatika. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_ti_mission',
                'label' => 'Misi',
                'name' => 'd4_ti_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi D4 Teknik Informatika. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_ti_goals',
                'label' => 'Tujuan',
                'name' => 'd4_ti_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi D4 Teknik Informatika. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_ti_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 'd4_ti_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d4_ti_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 'd4_ti_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d4_ti_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 'd4_ti_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d4_ti_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 'd4_ti_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d4_ti_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 'd4_ti_outcomes',
                'type' => 'relationship',
                'instructions' => 'Pilih capaian lulusan (CPT Capaian Lulusan).',
                'post_type' => ['capaian_lulusan'],
                'taxonomy' => ['kategori_program_studi:d4-teknik-informatika'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_ti_profiles',
                'label' => 'Profil Lulusan',
                'name' => 'd4_ti_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan (CPT Profil Lulusan).',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:d4-teknik-informatika'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_ti_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 'd4_ti_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang ingin ditampilkan di halaman D4 Teknik Informatika.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:d4-teknik-informatika'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_ti_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 'd4_ti_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_ti_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 'd4_ti_pathway',
                'type' => 'relationship',
                'instructions' => 'Pilih Peta Jalan CPL (CPT Peta Jalan CPL).',
                'post_type' => ['peta_jalan_cpl'],
                'taxonomy' => ['kategori_program_studi:d4-teknik-informatika'],
                'filters' => ['search', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_ti_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 'd4_ti_buku_panduan_pdf',
                'type' => 'file',
                'instructions' => 'Unggah file PDF buku panduan akademik untuk ditampilkan sebagai preview.',
                'return_format' => 'array',
                'library' => 'all',
            ],
        ],
        'location' => $d4_ti_page_location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_d4_sistem_informasi_bisnis_page', 
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman D4 Sistem Informasi Bisnis',
        'fields' => [
            [
                'key' => 'field_d4_sib_program_description',
                'label' => 'Intro Konten',
                'name' => 'd4_sib_program_description',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman D4 Sistem Informasi Bisnis.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_sib_vision',
                'label' => 'Visi',
                'name' => 'd4_sib_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi D4 Sistem Informasi Bisnis.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_sib_mission',
                'label' => 'Misi',
                'name' => 'd4_sib_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi D4 Sistem Informasi Bisnis.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_sib_goals',
                'label' => 'Tujuan',
                'name' => 'd4_sib_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi D4 Sistem Informasi Bisnis.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_sib_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 'd4_sib_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d4_sib_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 'd4_sib_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d4_sib_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 'd4_sib_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d4_sib_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 'd4_sib_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d4_sib_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 'd4_sib_outcomes',
                'type' => 'relationship',
                'instructions' => 'Pilih capaian lulusan (CPT Capaian Lulusan).',
                'post_type' => ['capaian_lulusan'],
                'taxonomy' => ['kategori_program_studi:d4-sistem-informasi-bisnis'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_sib_profiles',
                'label' => 'Profil Lulusan',
                'name' => 'd4_sib_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan (CPT Profil Lulusan).',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:d4-sistem-informasi-bisnis'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_sib_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 'd4_sib_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang ditampilkan pada halaman D4 Sistem Informasi Bisnis.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:d4-sistem-informasi-bisnis'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_sib_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 'd4_sib_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d4_sib_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 'd4_sib_pathway',
                'type' => 'relationship',
                'instructions' => 'Pilih Peta Jalan CPL (CPT Peta Jalan CPL).',
                'post_type' => ['peta_jalan_cpl'],
                'taxonomy' => ['kategori_program_studi:d4-sistem-informasi-bisnis'],
                'filters' => ['search', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d4_sib_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 'd4_sib_buku_panduan_pdf',
                'type' => 'file',
                'instructions' => 'Unggah file PDF buku panduan akademik untuk ditampilkan sebagai preview.',
                'return_format' => 'array',
                'library' => 'all',
            ],
        ],
        // Attach this field group to both the D4 SIB page template and the Study Program CPT.
        'location' => $d4_sib_page_location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    // 5. S2 Rekayasa Teknologi Informasi Page
    acf_add_local_field_group([
        'key' => 'group_s2_rekayasa_page', 
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman S2 Rekayasa Teknologi Informasi',
        'fields' => [
            [
                'key' => 'field_s2_rekayasa_intro',
                'label' => 'Intro Konten',
                'name' => 's2_rekayasa_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman S2 Rekayasa Teknologi Informasi.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_vision',
                'label' => 'Visi',
                'name' => 's2_rekayasa_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi S2 Rekayasa Teknologi Informasi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_mission',
                'label' => 'Misi',
                'name' => 's2_rekayasa_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi S2 Rekayasa Teknologi Informasi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_goals',
                'label' => 'Tujuan',
                'name' => 's2_rekayasa_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi S2 Rekayasa Teknologi Informasi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 's2_rekayasa_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_s2_rekayasa_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 's2_rekayasa_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_s2_rekayasa_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 's2_rekayasa_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_s2_rekayasa_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 's2_rekayasa_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_s2_rekayasa_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 's2_rekayasa_outcomes',
                'type' => 'relationship',
                'instructions' => 'Pilih capaian lulusan (CPT Capaian Lulusan).',
                'post_type' => ['capaian_lulusan'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_profiles',
                'label' => 'Profil Lulusan',
                'name' => 's2_rekayasa_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan (CPT Profil Lulusan).',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 's2_rekayasa_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang terkait dengan Program Studi S2 Rekayasa Teknologi Informasi.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 's2_rekayasa_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_s2_rekayasa_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 's2_rekayasa_pathway',
                'type' => 'relationship',
                'instructions' => 'Pilih Peta Jalan CPL (CPT Peta Jalan CPL).',
                'post_type' => ['peta_jalan_cpl'],
                'taxonomy' => ['kategori_program_studi:s2-rekayasa-teknologi-informasi'],
                'filters' => ['search', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 's2_rekayasa_buku_panduan_pdf',
                'type' => 'file',
                'instructions' => 'Unggah file PDF buku panduan akademik untuk ditampilkan sebagai preview.',
                'return_format' => 'array',
                'library' => 'all',
            ],
            [
                'key' => 'field_s2_rekayasa_bahan_kajian',
                'label' => 'Bahan Kajian',
                'name' => 's2_rekayasa_bahan_kajian',
                'type' => 'relationship',
                'instructions' => 'Pilih bahan kajian (CPT Bahan Kajian) yang terkait dengan Program Studi S2 Rekayasa.',
                'post_type' => ['bahan_kajian'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_mk_spesialis',
                'label' => 'Mata Kuliah Spesialisasi',
                'name' => 's2_rekayasa_specialization_groups',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah spesialisasi (CPT Mata Kuliah Spesialis) yang terkait dengan S2 Rekayasa. Mata kuliah akan dikelompokkan berdasarkan nama spesialisasi.',
                'post_type' => ['mk_spesialis'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_s2_rekayasa_bidang_keahlian',
                'label' => 'Bidang Keahlian',
                'name' => 's2_rekayasa_bidang_keahlian',
                'type' => 'relationship',
                'instructions' => 'Pilih bidang keahlian (CPT Bidang Keahlian) yang terkait dengan Program Studi S2 Rekayasa.',
                'post_type' => ['bidang_keahlian'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],

            [
                'key' => 'field_s2_rekayasa_pendaftaran',
                'label' => 'Pendaftaran',
                'name' => 's2_rekayasa_pendaftaran',
                'type' => 'wysiwyg',
                'instructions' => 'Isi informasi pendaftaran. Gunakan fitur list (bullet) agar tampil sebagai dot list.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
        ],
        'location' => $s2_rekayasa_page_location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_capaian_lulusan_details',
        'title' => 'Capaian Lulusan',
        'fields' => [
            [
                'key' => 'field_capaian_lulusan_code',
                'label' => 'Kode',
                'name' => 'code',
                'type' => 'text',
                'instructions' => 'Masukkan kode capaian lulusan.',
                'required' => 1,
            ],
            [
                'key' => 'field_capaian_lulusan_description',
                'label' => 'Deskripsi',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Masukkan deskripsi capaian lulusan.',
                'rows' => 4,
            ],
            [
                'key' => 'field_capaian_lulusan_study_programs',
                'label' => 'Study Programs',
                'name' => 'study_programs',
                'type' => 'relationship',
                'instructions' => 'Pilih program studi yang terkait dengan capaian lulusan ini.',
                'post_type' => ['study_program'],
                'filters' => ['search', 'post_type'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'capaian_lulusan',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_peta_jalan_cpl_details',
        'title' => 'Detail Peta Jalan CPL',
        'fields' => [
            [
                'key' => 'field_peta_jalan_cpl_code',
                'label' => 'Kode CPL/CPP',
                'name' => 'code',
                'type' => 'text',
                'instructions' => 'Masukkan kode CPL/CPP.',
                'required' => 1,
            ],
            [
                'key' => 'field_peta_jalan_cpl_image',
                'label' => 'Gambar Peta Jalan',
                'name' => 'image',
                'type' => 'image',
                'instructions' => 'Upload gambar peta jalan.',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'peta_jalan_cpl',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_profil_lulusan_study_program',
        'title' => 'Profil Lulusan Program Studi',
        'fields' => [
            [
                'key' => 'field_profil_lulusan_study_program',
                'label' => 'Program Studi',
                'name' => 'study_program',
                'type' => 'post_object',
                'instructions' => 'Pilih Program Studi yang terkait dengan profil lulusan ini.',
                'post_type' => ['study_program'],
                'return_format' => 'id',
                'ui' => 1,
                'allow_null' => 1,
                'multiple' => 0,
            ],
            [
                'key' => 'field_profil_lulusan_description',
                'label' => 'Deskripsi Profil Lulusan',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Isi deskripsi profil lulusan.',
                'rows' => 4,
            ],
            [
                'key' => 'field_profil_lulusan_competencies',
                'label' => 'Kompetensi',
                'name' => 'competencies',
                'type' => 'textarea',
                'instructions' => 'Masukkan setiap kompetensi pada baris baru, misalnya satu kompetensi per baris.',
                'rows' => 6,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'profil_lulusan',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    /* ========================================
      REGISTER ACF FIELD GROUPS (D3 MI KEDIRI PAGE)
    ======================================== */


    acf_add_local_field_group([
        'key' => 'group_d3_mi_kediri_page',
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman D3 MI Kediri',
        'fields' => [
            [
                'key' => 'field_d3_mi_kediri_intro',
                'label' => 'Intro Konten',
                'name' => 'd3_mi_kediri_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman D3 MI Kediri.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_kediri_vision',
                'label' => 'Visi',
                'name' => 'd3_mi_kediri_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_kediri_mission',
                'label' => 'Misi',
                'name' => 'd3_mi_kediri_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_kediri_goals',
                'label' => 'Tujuan',
                'name' => 'd3_mi_kediri_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_kediri_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 'd3_mi_kediri_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d3_mi_kediri_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 'd3_mi_kediri_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d3_mi_kediri_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 'd3_mi_kediri_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d3_mi_kediri_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 'd3_mi_kediri_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d3_mi_kediri_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 'd3_mi_kediri_outcomes',
                'type' => 'relationship',
                'instructions' => 'Pilih capaian lulusan (CPT Capaian Lulusan) yang ditampilkan pada halaman ini.',
                'post_type' => ['capaian_lulusan'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-kediri'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_kediri_profiles',
                'label' => 'Profil Lulusan',
                'name' => 'd3_mi_kediri_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan (CPT Profil Lulusan) yang ditampilkan pada halaman ini.',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-kediri'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_kediri_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 'd3_mi_kediri_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang terkait dengan Program Studi D3 MI Kediri.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-kediri'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_kediri_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 'd3_mi_kediri_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_kediri_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 'd3_mi_kediri_pathway',
                'type' => 'relationship',
                'instructions' => 'Pilih Peta Jalan CPL (CPT Peta Jalan CPL).',
                'post_type' => ['peta_jalan_cpl'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-kediri'],
                'filters' => ['search', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_kediri_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 'd3_mi_kediri_buku_panduan_pdf',
                'type' => 'file',
                'instructions' => 'Unggah file PDF buku panduan akademik untuk ditampilkan sebagai preview.',
                'return_format' => 'array',
                'library' => 'all',
            ],
        ],
        'location' => $d3_mi_kediri_page_location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_d3_mi_lumajang_page',
        'active' => false, // Disabled in favor of unified
        'title' => 'Konten Halaman D3 MI Lumajang',
        'fields' => [
            [
                'key' => 'field_d3_mi_lumajang_intro',
                'label' => 'Intro Konten',
                'name' => 'd3_mi_lumajang_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman D3 MI Lumajang.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_lumajang_vision',
                'label' => 'Visi',
                'name' => 'd3_mi_lumajang_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_lumajang_mission',
                'label' => 'Misi',
                'name' => 'd3_mi_lumajang_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_lumajang_goals',
                'label' => 'Tujuan',
                'name' => 'd3_mi_lumajang_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi. Bisa disusun dalam paragraf atau daftar singkat.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_lumajang_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 'd3_mi_lumajang_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d3_mi_lumajang_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 'd3_mi_lumajang_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d3_mi_lumajang_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 'd3_mi_lumajang_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_d3_mi_lumajang_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 'd3_mi_lumajang_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_d3_mi_lumajang_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 'd3_mi_lumajang_outcomes',
                'type' => 'relationship',
                'instructions' => 'Pilih capaian lulusan (CPT Capaian Lulusan) yang ditampilkan pada halaman ini.',
                'post_type' => ['capaian_lulusan'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-lumajang'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_lumajang_profiles',
                'label' => 'Profil Lulusan',
                'name' => 'd3_mi_lumajang_profiles',
                'type' => 'relationship',
                'instructions' => 'Pilih profil lulusan (CPT Profil Lulusan) yang ditampilkan pada halaman ini.',
                'post_type' => ['profil_lulusan'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-lumajang'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_lumajang_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 'd3_mi_lumajang_mata_kuliah',
                'type' => 'relationship',
                'instructions' => 'Pilih mata kuliah yang terkait dengan Program Studi D3 MI Lumajang.',
                'post_type' => ['mata_kuliah'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-lumajang'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'elements' => '',
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_lumajang_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 'd3_mi_lumajang_tuition',
                'type' => 'wysiwyg',
                'instructions' => 'Isi biaya perkuliahan. Gunakan fitur list (bullet) agar tampil dengan baik.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_d3_mi_lumajang_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 'd3_mi_lumajang_pathway',
                'type' => 'relationship',
                'instructions' => 'Pilih Peta Jalan CPL (CPT Peta Jalan CPL).',
                'post_type' => ['peta_jalan_cpl'],
                'taxonomy' => ['kategori_program_studi:d3-manajemen-informatika-lumajang'],
                'filters' => ['search', 'taxonomy'],
                'min' => 0,
                'max' => 0,
                'return_format' => 'id',
            ],
            [
                'key' => 'field_d3_mi_lumajang_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 'd3_mi_lumajang_buku_panduan_pdf',
                'type' => 'file',
                'instructions' => 'Unggah file PDF buku panduan akademik untuk ditampilkan sebagai preview.',
                'return_format' => 'array',
                'library' => 'all',
            ],
        ],
        'location' => $d3_mi_lumajang_page_location,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);



    acf_add_local_field_group([
        'key' => 'group_mata_kuliah_details',
        'title' => 'Detail Mata Kuliah',
        'fields' => [
            [
                'key' => 'field_mata_kuliah_semester',
                'label' => 'Semester',
                'name' => 'semester',
                'type' => 'select',
                'choices' => [
                    'Semester 1' => 'Semester 1',
                    'Semester 2' => 'Semester 2',
                    'Semester 3' => 'Semester 3',
                    'Semester 4' => 'Semester 4',
                    'Semester 5' => 'Semester 5',
                    'Semester 6' => 'Semester 6',
                    'Semester 7' => 'Semester 7',
                    'Semester 8' => 'Semester 8',
                ],
                'ui' => 1,
            ],
            [
                'key' => 'field_mata_kuliah_sks',
                'label' => 'SKS',
                'name' => 'sks',
                'type' => 'number',
                'min' => 0,
            ],
            [
                'key' => 'field_mata_kuliah_kode_mk',
                'label' => 'Kode Mata Kuliah',
                'name' => 'kode_mk',
                'type' => 'text',
                'instructions' => 'Kode mata kuliah yang akan ditampilkan pada halaman akademik.',
            ],
            [
                'key' => 'field_mata_kuliah_keterangan',
                'label' => 'Keterangan',
                'name' => 'keterangan',
                'type' => 'text',
                'instructions' => 'Contoh: MK Wajib atau MK Pilihan Reguler.',
            ],
            [
                'key' => 'field_mata_kuliah_study_program',
                'label' => 'Study Program',
                'name' => 'study_program',
                'type' => 'post_object',
                'post_type' => ['study_program'],
                'return_format' => 'id',
                'ui' => 1,
                'allow_null' => 1,
                'multiple' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'mata_kuliah',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_mata_kuliah_spesialis_details',
        'title' => 'Detail Mata Kuliah Spesialis',
        'fields' => [
            [
                'key' => 'field_mk_spesialis_nama',
                'label' => 'Nama Mata Kuliah Spesialis',
                'name' => 'nama_mata_kuliah_spesialis',
                'type' => 'text',
                'instructions' => 'Masukkan grup/nama spesialisasi (misal: Computer Vision). Ini akan menggantikan pengelompokan semester.',
                'required' => 1,
            ],
            [
                'key' => 'field_mk_spesialis_sks',
                'label' => 'SKS',
                'name' => 'sks',
                'type' => 'number',
                'min' => 0,
            ],
            [
                'key' => 'field_mk_spesialis_study_program',
                'label' => 'Study Program',
                'name' => 'study_program',
                'type' => 'post_object',
                'post_type' => ['study_program'],
                'return_format' => 'id',
                'ui' => 1,
                'allow_null' => 1,
                'multiple' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'mk_spesialis',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

});

/* ========================================
   CUSTOM ACF POST OBJECT QUERY FILTERS
   ======================================== */

/* ──────────────────────────────────────────────────────────
   HELPER: webjti_get_all_assigned_lecturer_ids()
   Collects all lecturer IDs already assigned as Head of Lab
   or Lab Members across ALL published laboratory posts,
   optionally excluding one lab (the one currently being edited).
   ────────────────────────────────────────────────────────── */
function webjti_get_all_assigned_lecturer_ids( $exclude_lab_id = 0 ) {
    $assigned = [];

    $lab_posts = get_posts([
        'post_type'      => 'laboratory',
        'post_status'    => ['publish', 'draft', 'pending', 'future'],
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);

    foreach ( $lab_posts as $lab_id ) {

        // Skip the lab currently being edited so its own current
        // selections are not blocked (they will be re-validated on save).
        if ( (int) $lab_id === (int) $exclude_lab_id ) {
            continue;
        }

        // Head of Lab
        $head = get_field( 'lab_head', $lab_id );
        if ( ! empty( $head ) ) {
            $head_id = is_object( $head ) ? $head->ID : (int) $head;
            if ( $head_id ) {
                $assigned[ $head_id ] = $head_id;
            }
        }

        // Lab Members
        $members = get_field( 'lab_members', $lab_id );
        if ( ! empty( $members ) && is_array( $members ) ) {
            foreach ( $members as $m ) {
                $m_id = is_object( $m ) ? $m->ID : (int) $m;
                if ( $m_id ) {
                    $assigned[ $m_id ] = $m_id;
                }
            }
        }
    }

    return array_values( $assigned );
}

/* ──────────────────────────────────────────────────────────
   FILTER: Exclude already-assigned lecturers from the
   Head of Lab (lab_head) dropdown.
   ────────────────────────────────────────────────────────── */
add_filter( 'acf/fields/post_object/query/key=field_lab_head', function( $args, $field, $post_id ) {

    // Determine the lab post currently being edited
    $current_lab_id = (int) $post_id;

    // Collect all assigned lecturers from OTHER labs
    $excluded = webjti_get_all_assigned_lecturer_ids( $current_lab_id );

    // Also exclude lecturers already chosen as members in THIS lab
    $current_members = get_field( 'lab_members', $current_lab_id );
    if ( ! empty( $current_members ) && is_array( $current_members ) ) {
        foreach ( $current_members as $m ) {
            $m_id = is_object( $m ) ? $m->ID : (int) $m;
            if ( $m_id ) {
                $excluded[] = $m_id;
            }
        }
    }

    $excluded = array_unique( array_filter( $excluded ) );

    if ( ! empty( $excluded ) ) {
        $args['post__not_in'] = $excluded;
    }

    return $args;

}, 10, 3 );

/* ──────────────────────────────────────────────────────────
   FILTER: Exclude already-assigned lecturers from the
   Lab Members (lab_members) multi-select dropdown.
   ────────────────────────────────────────────────────────── */
add_filter( 'acf/fields/post_object/query/key=field_lab_members', function( $args, $field, $post_id ) {

    $current_lab_id = (int) $post_id;

    // Collect all assigned lecturers from OTHER labs
    $excluded = webjti_get_all_assigned_lecturer_ids( $current_lab_id );

    // Also exclude the lecturer currently chosen as Head of THIS lab
    $current_head = get_field( 'lab_head', $current_lab_id );
    if ( ! empty( $current_head ) ) {
        $head_id = is_object( $current_head ) ? $current_head->ID : (int) $current_head;
        if ( $head_id ) {
            $excluded[] = $head_id;
        }
    }

    $excluded = array_unique( array_filter( $excluded ) );

    if ( ! empty( $excluded ) ) {
        $args['post__not_in'] = $excluded;
    }

    return $args;

}, 10, 3 );

add_filter( 'acf/fields/relationship/query/key=field_d4_sib_profiles', function( $args, $field, $post_id ) {
    $current_post_id = absint( $post_id );
    if ( $current_post_id <= 0 ) {
        return $args;
    }

    $target_program_id = 0;
    $current_post_type = get_post_type( $current_post_id );

    if ( 'study_program' === $current_post_type ) {
        $target_program_id = $current_post_id;
    } else {
        $post_name = get_post_field( 'post_name', $current_post_id );
        if ( $post_name ) {
            $maybe = get_page_by_path( $post_name, OBJECT, 'study_program' );
            if ( $maybe && isset( $maybe->ID ) ) {
                $target_program_id = absint( $maybe->ID );
            }
        }
    }

    if ( $target_program_id > 0 ) {
        $args['meta_query'] = [
            [
                'key' => 'study_program',
                'value' => $target_program_id,
                'compare' => '=',
            ],
        ];
    }

    return $args;

}, 10, 3 );

/* ──────────────────────────────────────────────────────────
   SERVER-SIDE VALIDATION: acf/validate_save_post
   Hard-blocks saving if any lecturer is duplicated across labs.
   Runs in addition to the dropdown filter as a safety net.
   ────────────────────────────────────────────────────────── */
add_action( 'acf/validate_save_post', function() {

    // Only validate laboratory CPT edits
    $post_id  = isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0;
    $post_type = isset( $_POST['post_type'] ) ? sanitize_key( $_POST['post_type'] ) : '';

    if ( 'laboratory' !== $post_type || ! $post_id ) {
        return;
    }

    // Read submitted field values from $_POST['acf']
    $acf_input   = isset( $_POST['acf'] ) ? $_POST['acf'] : [];
    $head_key    = 'field_lab_head';
    $members_key = 'field_lab_members';

    $submitted_head_id    = ! empty( $acf_input[ $head_key ] ) ? (int) $acf_input[ $head_key ] : 0;
    $submitted_member_ids = ! empty( $acf_input[ $members_key ] ) && is_array( $acf_input[ $members_key ] )
        ? array_map( 'intval', $acf_input[ $members_key ] )
        : [];

    // ── Rule 1: Head cannot also be a member in the same lab ──
    if ( $submitted_head_id && in_array( $submitted_head_id, $submitted_member_ids, true ) ) {
        $head_name = get_the_title( $submitted_head_id );
        acf_add_validation_error(
            'acf[' . $head_key . ']',
            sprintf(
                /* translators: %s: lecturer name */
                __( 'Validation Error: "%s" is selected as both Head and Member of this laboratory. A lecturer can only hold one role per lab.', 'webjti' ),
                $head_name
            )
        );
    }

    // ── Rule 2: No member must appear as member in more than once ──
    if ( count( $submitted_member_ids ) !== count( array_unique( $submitted_member_ids ) ) ) {
        acf_add_validation_error(
            'acf[' . $members_key . ']',
            __( 'Validation Error: Duplicate researchers detected. Each lecturer may only appear once in the Members list.', 'webjti' )
        );
    }

    // ── Rule 3: Head or Members must not be assigned in any OTHER lab ──
    $assigned_elsewhere = webjti_get_all_assigned_lecturer_ids( $post_id );

    if ( $submitted_head_id && in_array( $submitted_head_id, $assigned_elsewhere, true ) ) {
        $head_name    = get_the_title( $submitted_head_id );
        $conflict_lab = webjti_find_lecturer_lab_assignment( $submitted_head_id, $post_id );
        acf_add_validation_error(
            'acf[' . $head_key . ']',
            sprintf(
                /* translators: %1$s: lecturer name, %2$s: lab title */
                __( 'Validation Error: "%1$s" is already assigned to "%2$s". A lecturer can only be assigned to one laboratory.', 'webjti' ),
                $head_name,
                $conflict_lab
            )
        );
    }

    foreach ( $submitted_member_ids as $member_id ) {
        if ( in_array( $member_id, $assigned_elsewhere, true ) ) {
            $member_name  = get_the_title( $member_id );
            $conflict_lab = webjti_find_lecturer_lab_assignment( $member_id, $post_id );
            acf_add_validation_error(
                'acf[' . $members_key . ']',
                sprintf(
                    /* translators: %1$s: lecturer name, %2$s: lab title */
                    __( 'Validation Error: "%1$s" is already assigned to "%2$s". A lecturer can only be assigned to one laboratory.', 'webjti' ),
                    $member_name,
                    $conflict_lab
                )
            );
        }
    }

}, 10 );

/* ──────────────────────────────────────────────────────────
   HELPER: webjti_find_lecturer_lab_assignment()
   Returns the title of the lab where the given lecturer
   is already assigned (excluding current lab being edited).
   ────────────────────────────────────────────────────────── */
function webjti_find_lecturer_lab_assignment( $lecturer_id, $exclude_lab_id = 0 ) {
    $lab_posts = get_posts([
        'post_type'      => 'laboratory',
        'post_status'    => ['publish', 'draft', 'pending', 'future'],
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);

    foreach ( $lab_posts as $lab_id ) {
        if ( (int) $lab_id === (int) $exclude_lab_id ) {
            continue;
        }

        $head = get_field( 'lab_head', $lab_id );
        if ( ! empty( $head ) ) {
            $head_id = is_object( $head ) ? $head->ID : (int) $head;
            if ( (int) $head_id === (int) $lecturer_id ) {
                return get_the_title( $lab_id );
            }
        }

        $members = get_field( 'lab_members', $lab_id );
        if ( ! empty( $members ) && is_array( $members ) ) {
            foreach ( $members as $m ) {
                $m_id = is_object( $m ) ? $m->ID : (int) $m;
                if ( (int) $m_id === (int) $lecturer_id ) {
                    return get_the_title( $lab_id );
                }
            }
        }
    }

    return __( 'another laboratory', 'webjti' );
}

/* ──────────────────────────────────────────────────────────
   DEDICATION CPT: Dynamic Lecturer Choices & Custom Tag Support
   Allows selecting existing lecturers OR typing custom text names into dropdown
   ────────────────────────────────────────────────────────── */
function webjti_load_lecturers_for_dedication_fields($field) {
    $field['choices'] = [];

    // Query published lecturers
    $lecturers = get_posts([
        'post_type'        => ['lecturer', 'dosen'],
        'posts_per_page'   => -1,
        'post_status'      => 'publish',
        'orderby'          => 'title',
        'order'            => 'ASC',
        'suppress_filters' => true,
    ]);

    if (!empty($lecturers)) {
        foreach ($lecturers as $l) {
            $field['choices'][$l->post_title] = $l->post_title;
        }
    }

    // Determine current post ID
    $post_id = 0;
    if (isset($_GET['post'])) {
        $post_id = (int)$_GET['post'];
    } elseif (isset($_POST['post_ID'])) {
        $post_id = (int)$_POST['post_ID'];
    } else {
        global $post;
        if (isset($post->ID)) {
            $post_id = $post->ID;
        }
    }

    // Also include existing saved custom string values for current post
    if ($post_id > 0) {
        $saved_val = get_post_meta($post_id, $field['name'], true);
        if (!empty($saved_val)) {
            $vals = is_array($saved_val) ? $saved_val : [$saved_val];
            foreach ($vals as $v) {
                if (is_numeric($v)) {
                    $t = get_the_title($v);
                    if ($t) {
                        $field['choices'][$t] = $t;
                    }
                } elseif (is_string($v) && !empty($v)) {
                    $v_trimmed = trim($v);
                    if (!empty($v_trimmed)) {
                        $field['choices'][$v_trimmed] = $v_trimmed;
                    }
                }
            }
        }
    }

    return $field;
}
add_filter('acf/load_field/key=field_dedication_leader', 'webjti_load_lecturers_for_dedication_fields');
add_filter('acf/load_field/key=field_dedication_members', 'webjti_load_lecturers_for_dedication_fields');

// Bypass strict choice validation for custom typed lecturer names
add_filter('acf/validate_value/key=field_dedication_leader', '__return_true', 10, 4);
add_filter('acf/validate_value/key=field_dedication_members', '__return_true', 10, 4);
add_filter('acf/validate_value/name=leader', '__return_true', 10, 4);
add_filter('acf/validate_value/name=members', '__return_true', 10, 4);

/* ──────────────────────────────────────────────────────────
   ADMIN FOOTER JS FOR SELECT2 CUSTOM TAGGING (CREATE NEW ITEM IN DROPDOWN)
   ────────────────────────────────────────────────────────── */
function webjti_dedication_select2_custom_tags_script() {
    ?>
    <script type="text/javascript">
    (function($) {
        function initDedicationTags() {
            if (typeof acf === 'undefined') return;

            // Force Select2 to allow custom tags (typing new name + Enter) for Dedication Leader and Members
            acf.add_filter('select2_args', function(options, $select, data, field, instance) {
                var isTarget = false;
                if (field) {
                    var k = field.get('key') || '';
                    var n = field.get('name') || '';
                    if (k === 'field_dedication_leader' || k === 'field_dedication_members' || n === 'leader' || n === 'members') {
                        isTarget = true;
                    }
                }
                if (!isTarget && $select && $select.length) {
                    var nameAttr = $select.attr('name') || '';
                    var keyAttr = $select.closest('[data-key]').attr('data-key') || '';
                    var nameDataAttr = $select.closest('[data-name]').attr('data-name') || '';
                    if (keyAttr === 'field_dedication_leader' || keyAttr === 'field_dedication_members' || nameDataAttr === 'leader' || nameDataAttr === 'members' || nameAttr.indexOf('leader') !== -1 || nameAttr.indexOf('members') !== -1) {
                        isTarget = true;
                    }
                }

                if (isTarget) {
                    options.tags = true;
                    options.createTag = function(params) {
                        var term = $.trim(params.term);
                        if (term === '') return null;
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    };
                }
                return options;
            });

            // Dynamically add created tag to <select> DOM element when selected
            $(document).on('select2:select', '.acf-field[data-name="leader"] select, .acf-field[data-name="members"] select, .acf-field[data-key="field_dedication_leader"] select, .acf-field[data-key="field_dedication_members"] select', function(e) {
                var data = e.params ? e.params.data : null;
                if (data && (data.newTag || data.id === data.text)) {
                    var $select = $(this);
                    var term = data.id;
                    if ($select.find("option[value='" + String(term).replace(/'/g, "\\'") + "']").length === 0) {
                        var newOption = new Option(data.text, term, true, true);
                        $select.append(newOption);
                    }
                }
            });
        }

        if (typeof acf !== 'undefined') {
            initDedicationTags();
        } else {
            $(document).ready(initDedicationTags);
        }
    })(jQuery);
    </script>
    <?php
}
add_action('admin_footer', 'webjti_dedication_select2_custom_tags_script', 99);
add_action('acf/input/admin_footer', 'webjti_dedication_select2_custom_tags_script', 99);

/* ========================================
   REGISTER BEASISWA ACF FIELDS (CPT & LANDING)
======================================== */
add_action('acf/init', function() {
    if (function_exists('acf_add_local_field_group')) {

        // Field Group for Landing Page Beasiswa
        acf_add_local_field_group(array(
            'key' => 'group_beasiswa_landing',
            'title' => 'Pengaturan Halaman Beasiswa',
            'fields' => array(
                array(
                    'key' => 'field_beasiswa_reqs',
                    'label' => 'Persyaratan Umum (Tab Persyaratan)',
                    'name' => 'beasiswa_requirements',
                    'type' => 'textarea',
                    'rows' => 6,
                    'instructions' => 'Ketik setiap syarat pada baris baru (tekan Enter untuk syarat berikutnya).'
                ),
                array(
                    'key' => 'field_beasiswa_faqs_accordion',
                    'label' => 'Pertanyaan yang Sering Diajukan (Tab FAQ)',
                    'name' => '',
                    'type' => 'accordion',
                    'open' => 1,
                    'multi_expand' => 1,
                ),
                array('key' => 'field_bf_q1', 'label' => 'Pertanyaan 1', 'name' => 'faq_1_q', 'type' => 'text'),
                array('key' => 'field_bf_a1', 'label' => 'Jawaban 1', 'name' => 'faq_1_a', 'type' => 'textarea', 'rows' => 3),
                
                array('key' => 'field_bf_q2', 'label' => 'Pertanyaan 2', 'name' => 'faq_2_q', 'type' => 'text'),
                array('key' => 'field_bf_a2', 'label' => 'Jawaban 2', 'name' => 'faq_2_a', 'type' => 'textarea', 'rows' => 3),
                
                array('key' => 'field_bf_q3', 'label' => 'Pertanyaan 3', 'name' => 'faq_3_q', 'type' => 'text'),
                array('key' => 'field_bf_a3', 'label' => 'Jawaban 3', 'name' => 'faq_3_a', 'type' => 'textarea', 'rows' => 3),
                
                array('key' => 'field_bf_q4', 'label' => 'Pertanyaan 4', 'name' => 'faq_4_q', 'type' => 'text'),
                array('key' => 'field_bf_a4', 'label' => 'Jawaban 4', 'name' => 'faq_4_a', 'type' => 'textarea', 'rows' => 3),
                
                array('key' => 'field_bf_q5', 'label' => 'Pertanyaan 5', 'name' => 'faq_5_q', 'type' => 'text'),
                array('key' => 'field_bf_a5', 'label' => 'Jawaban 5', 'name' => 'faq_5_a', 'type' => 'textarea', 'rows' => 3),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/pages/beasiswa-page.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));

        // Field Group for Detail Beasiswa CPT
        acf_add_local_field_group(array(
            'key' => 'group_beasiswa_detail',
            'title' => 'Pengaturan Data Beasiswa',
            'fields' => array(
                array(
                    'key' => 'field_bd_card_settings',
                    'label' => 'Pengaturan Tampilan Kartu (Landing Page)',
                    'name' => '',
                    'type' => 'accordion',
                    'open' => 1,
                    'multi_expand' => 1,
                ),
                array('key' => 'field_bd_icon', 'label' => 'Ikon Phosphor', 'name' => 'card_icon', 'type' => 'text', 'default_value' => 'ph-student', 'instructions' => 'Ikon yang muncul di Landing Page (contoh: ph-student)'),
                array('key' => 'field_bd_color', 'label' => 'Warna Gradien (CSS)', 'name' => 'card_color', 'type' => 'text', 'default_value' => 'linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%)'),
                array('key' => 'field_bd_short_desc', 'label' => 'Deskripsi Singkat', 'name' => 'card_description', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Deskripsi singkat yang tampil di kartu halaman depan'),
                
                array(
                    'key' => 'field_bd_hero_settings',
                    'label' => 'Pengaturan Header (Halaman Detail)',
                    'name' => '',
                    'type' => 'accordion',
                    'open' => 1,
                    'multi_expand' => 1,
                ),
                array('key' => 'field_bd_title', 'label' => 'Nama Beasiswa (Opsional)', 'name' => 'detail_title', 'type' => 'text', 'instructions' => 'Jika kosong, akan mengambil judul tulisan di atas'),
                array('key' => 'field_bd_provider', 'label' => 'Penyedia / Instansi', 'name' => 'detail_provider', 'type' => 'text'),
                array(
                    'key' => 'field_bd_deadline', 
                    'label' => 'Batas Pendaftaran', 
                    'name' => 'detail_deadline', 
                    'type' => 'date_picker',
                    'display_format' => 'd F Y',
                    'return_format' => 'd F Y',
                    'first_day' => 1
                ),
                array('key' => 'field_bd_amount', 'label' => 'Benefit / Cakupan', 'name' => 'detail_amount', 'type' => 'text'),
                array('key' => 'field_bd_quota', 'label' => 'Kuota Penerima', 'name' => 'detail_quota', 'type' => 'text'),
                array(
                    'key' => 'field_bd_status', 
                    'label' => 'Status Pendaftaran', 
                    'name' => 'detail_status', 
                    'type' => 'select', 
                    'choices' => array('Buka' => 'Buka', 'Tutup' => 'Tutup'),
                    'default_value' => 'Buka',
                    'return_format' => 'value'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'beasiswa',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }
});

/* ========================================
   REGISTER PROGRAM KHUSUS (RPL DLL) PAGE FIELDS
======================================== */
add_action('acf/init', function() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_program_khusus_rpl',
            'title' => 'Konten Program Khusus',
            'fields' => array(
                array(
                    'key' => 'field_rpl_tipe_program',
                    'label' => 'Tipe Program Khusus (Validasi Tipe)',
                    'name' => 'rpl_tipe_program',
                    'type' => 'select',
                    'instructions' => 'Pilih jenis program khusus (RPL, Alih Jenjang, Double Degree, atau Kelas Internasional)',
                    'required' => 1,
                    'choices' => array(
                        'rpl'                 => 'Rekognisi Pembelajaran Lampau (RPL)',
                        'alih_jenjang'        => 'Alih Jenjang',
                        'double_degree'       => 'Double Degree',
                        'kelas_internasional' => 'Kelas Internasional',
                    ),
                    'default_value' => 'rpl',
                    'allow_null' => 0,
                ),
                array(
                    'key' => 'field_rpl_deskripsi',
                    'label' => 'Deskripsi',
                    'name' => 'rpl_deskripsi',
                    'type' => 'wysiwyg',
                ),
                array(
                    'key' => 'field_rpl_persyaratan',
                    'label' => 'Persyaratan',
                    'name' => 'rpl_persyaratan',
                    'type' => 'wysiwyg',
                ),
                array(
                    'key' => 'field_rpl_format_biaya',
                    'label' => 'Format Rincian Biaya',
                    'name' => 'rpl_format_biaya',
                    'type' => 'radio',
                    'choices' => array(
                        'tabel' => 'Tabel (Alih Jenjang / RPL)',
                        'list'  => 'List (Kelas Internasional / Double Degree)',
                    ),
                    'default_value' => 'tabel',
                    'layout' => 'horizontal',
                ),
                array(
                    'key' => 'field_rpl_biaya_list',
                    'label' => 'Rincian Biaya (Tabel)',
                    'name' => 'rpl_biaya_list',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Tambah Rincian Biaya',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_rpl_format_biaya',
                                'operator' => '==',
                                'value' => 'tabel',
                            ),
                        ),
                    ),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_rpl_biaya_kelompok',
                            'label' => 'Kelompok Program',
                            'name' => 'kelompok_program',
                            'type' => 'text',
                            'instructions' => 'Misal: Transfer ke Sarjana Terapan',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_bidang',
                            'label' => 'Bidang',
                            'name' => 'bidang',
                            'type' => 'text',
                            'instructions' => 'Misal: Rekayasa',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_ipi_utama',
                            'label' => 'IPI - D-III Polinema Utama',
                            'name' => 'ipi_utama',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_ipi_psdku',
                            'label' => 'IPI - D-II/D-III PSDKU',
                            'name' => 'ipi_psdku',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_ipi_luar',
                            'label' => 'IPI - Luar Polinema',
                            'name' => 'ipi_luar',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_ukt',
                            'label' => 'UKT / Semester',
                            'name' => 'ukt',
                            'type' => 'text',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_biaya_pendaftaran',
                    'label' => 'Biaya Pendaftaran',
                    'name' => 'rpl_biaya_pendaftaran',
                    'type' => 'text',
                    'conditional_logic' => array(
                        array(
                            array('field' => 'field_rpl_format_biaya', 'operator' => '==', 'value' => 'list'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_biaya_ipi_rekayasa',
                    'label' => 'IPI Rekayasa (Polinema)',
                    'name' => 'rpl_biaya_ipi_rekayasa',
                    'type' => 'text',
                    'conditional_logic' => array(
                        array(
                            array('field' => 'field_rpl_format_biaya', 'operator' => '==', 'value' => 'list'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_biaya_ukt_per_semester',
                    'label' => 'UKT / Semester',
                    'name' => 'rpl_biaya_ukt_per_semester',
                    'type' => 'text',
                    'conditional_logic' => array(
                        array(
                            array('field' => 'field_rpl_format_biaya', 'operator' => '==', 'value' => 'list'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_biaya_mitra_list',
                    'label' => 'Rincian Biaya Kampus Mitra',
                    'name' => 'rpl_biaya_mitra_list',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Tambah Biaya Mitra',
                    'conditional_logic' => array(
                        array(
                            array('field' => 'field_rpl_format_biaya', 'operator' => '==', 'value' => 'list'),
                        ),
                    ),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_rpl_biaya_mitra_label',
                            'label' => 'Label/Deskripsi',
                            'name' => 'label',
                            'type' => 'text',
                            'instructions' => 'Misal: Biaya Pendidikan (Tuition Fee)',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_mitra_nominal',
                            'label' => 'Nominal',
                            'name' => 'nominal',
                            'type' => 'text',
                            'instructions' => 'Misal: 12000',
                        ),
                        array(
                            'key' => 'field_rpl_biaya_mitra_currency',
                            'label' => 'Mata Uang',
                            'name' => 'currency',
                            'type' => 'text',
                            'default_value' => 'CNY',
                            'instructions' => 'Misal: CNY, IDR, USD',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_biaya_catatan_tambahan',
                    'label' => 'Catatan Tambahan (List)',
                    'name' => 'rpl_biaya_catatan_tambahan',
                    'type' => 'wysiwyg',
                    'conditional_logic' => array(
                        array(
                            array('field' => 'field_rpl_format_biaya', 'operator' => '==', 'value' => 'list'),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_timeline_list',
                    'label' => 'Timeline',
                    'name' => 'rpl_timeline_list',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Tambah Timeline',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_rpl_timeline_title',
                            'label' => 'Judul Kegiatan',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_rpl_timeline_date',
                            'label' => 'Tanggal Pelaksanaan',
                            'name' => 'date',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_rpl_timeline_desc',
                            'label' => 'Keterangan Tambahan',
                            'name' => 'description',
                            'type' => 'wysiwyg',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_rpl_kontak',
                    'label' => 'Kontak Hubung',
                    'name' => 'rpl_kontak',
                    'type' => 'wysiwyg',
                ),
            ),
            'location' => array(
                array(
                    array('param' => 'post_type', 'operator' => '==', 'value' => 'program_khusus'),
                ),
                array(
                    array('param' => 'page_template', 'operator' => '==', 'value' => 'templates/pages/akademik/rpl-page.php'),
                ),
                array(
                    array('param' => 'page_template', 'operator' => '==', 'value' => 'templates/pages/akademik/alih-jenjang-page.php'),
                ),
                array(
                    array('param' => 'page_template', 'operator' => '==', 'value' => 'templates/pages/akademik/kelas-internasional-page.php'),
                ),
                array(
                    array('param' => 'page_template', 'operator' => '==', 'value' => 'templates/pages/akademik/double-degree-page.php'),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }
});

/* ========================================
   REGISTER ACF FIELD GROUPS (CAREER PROGRAM)
======================================== */
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_career_program',
        'title' => 'Detail Program Karir',
        'fields' => [
            [
                'key' => 'field_career_date',
                'label' => 'Tanggal / Deadline',
                'name' => 'career_date',
                'type' => 'text',
                'instructions' => 'Masukkan tanggal pelaksanaan atau deadline program. Contoh: 12 Agustus 2026 atau s/d 20 September 2026',
            ],
            [
                'key' => 'field_career_location',
                'label' => 'Lokasi / Penyelenggara',
                'name' => 'career_location',
                'type' => 'text',
                'instructions' => 'Masukkan lokasi pelaksanaan atau nama instansi penyelenggara.',
            ],
            [
                'key' => 'field_career_link',
                'label' => 'Tautan Pendaftaran / Info',
                'name' => 'career_link',
                'type' => 'url',
                'instructions' => 'Masukkan URL tautan untuk pendaftaran atau informasi lebih lanjut. Kosongkan jika tidak ada.',
            ],
            [
                'key' => 'field_career_registration_deadline',
                'label' => 'Batas Waktu Pendaftaran (Deadline)',
                'name' => 'career_registration_deadline',
                'type' => 'date_time_picker',
                'instructions' => 'Pilih batas waktu pendaftaran. Jika waktu ini terlewati, tombol pendaftaran akan terkunci (disable). Kosongkan jika tidak ada batas waktu otomatis.',
                'display_format' => 'Y-m-d H:i:s',
                'return_format' => 'Y-m-d H:i:s',
                'first_day' => 1,
            ],
            [
                'key' => 'field_career_gallery_1',
                'label' => 'Galeri Foto 1',
                'name' => 'career_gallery_1',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_career_gallery_2',
                'label' => 'Galeri Foto 2',
                'name' => 'career_gallery_2',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_career_gallery_3',
                'label' => 'Galeri Foto 3',
                'name' => 'career_gallery_3',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_career_gallery_4',
                'label' => 'Galeri Foto 4',
                'name' => 'career_gallery_4',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '25'],
            ],
            [
                'key' => 'field_career_gallery_5',
                'label' => 'Galeri Foto 5',
                'name' => 'career_gallery_5',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
            [
                'key' => 'field_career_gallery_6',
                'label' => 'Galeri Foto 6',
                'name' => 'career_gallery_6',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
            [
                'key' => 'field_career_gallery_7',
                'label' => 'Galeri Foto 7',
                'name' => 'career_gallery_7',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
            [
                'key' => 'field_career_gallery_8',
                'label' => 'Galeri Foto 8',
                'name' => 'career_gallery_8',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
            [
                'key' => 'field_career_gallery_9',
                'label' => 'Galeri Foto 9',
                'name' => 'career_gallery_9',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
            [
                'key' => 'field_career_gallery_10',
                'label' => 'Galeri Foto 10',
                'name' => 'career_gallery_10',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => ['width' => '20'],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'career_program',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);

    acf_add_local_field_group([
        'key' => 'group_study_program_page',
        'title' => 'Konten Halaman Program Studi (Unified)',
        'fields' => [
            [
                'key' => 'field_sp_intro',
                'label' => 'Intro Konten',
                'name' => 'sp_intro',
                'type' => 'wysiwyg',
                'instructions' => 'Isi paragraf pembuka halaman.',
                'media_upload' => 0,
                'toolbar' => 'full',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_vision',
                'label' => 'Visi',
                'name' => 'sp_vision',
                'type' => 'wysiwyg',
                'instructions' => 'Isi visi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_mission',
                'label' => 'Misi',
                'name' => 'sp_mission',
                'type' => 'wysiwyg',
                'instructions' => 'Isi misi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_goals',
                'label' => 'Tujuan',
                'name' => 'sp_goals',
                'type' => 'wysiwyg',
                'instructions' => 'Isi tujuan program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_strategy',
                'label' => 'Strategi',
                'name' => 'sp_strategy',
                'type' => 'wysiwyg',
                'instructions' => 'Isi strategi program studi.',
                'media_upload' => 0,
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_accreditation_1_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 1',
                'name' => 'sp_accreditation_1_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_sp_accreditation_1_image',
                'label' => 'Gambar Sertifikat Akreditasi 1',
                'name' => 'sp_accreditation_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_sp_accreditation_2_description',
                'label' => 'Deskripsi Sertifikat Akreditasi 2',
                'name' => 'sp_accreditation_2_description',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_sp_accreditation_2_image',
                'label' => 'Gambar Sertifikat Akreditasi 2',
                'name' => 'sp_accreditation_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_sp_outcomes',
                'label' => 'Capaian Lulusan',
                'name' => 'sp_outcomes',
                'type' => 'relationship',
                'post_type' => ['capaian_lulusan'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_profiles',
                'label' => 'Profil Lulusan',
                'name' => 'sp_profiles',
                'type' => 'relationship',
                'post_type' => ['profil_lulusan'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_mata_kuliah',
                'label' => 'Mata Kuliah Terkait',
                'name' => 'sp_mata_kuliah',
                'type' => 'relationship',
                'post_type' => ['mata_kuliah'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_mata_kuliah_spesialis',
                'label' => 'Mata Kuliah Spesialis',
                'name' => 'sp_mata_kuliah_spesialis',
                'type' => 'relationship',
                'post_type' => ['mk_spesialis'],
                'filters' => ['search', 'post_type'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_bahan_kajian',
                'label' => 'Bahan Kajian',
                'name' => 'sp_bahan_kajian',
                'type' => 'relationship',
                'post_type' => ['bahan_kajian'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_bidang_keahlian',
                'label' => 'Bidang Keahlian',
                'name' => 'sp_bidang_keahlian',
                'type' => 'relationship',
                'post_type' => ['bidang_keahlian'],
                'filters' => ['search', 'post_type', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_tuition',
                'label' => 'Biaya Perkuliahan',
                'name' => 'sp_tuition',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'tabs' => 'visual',
            ],
            [
                'key' => 'field_sp_pathway',
                'label' => 'Peta Jalan CPL',
                'name' => 'sp_pathway',
                'type' => 'relationship',
                'post_type' => ['peta_jalan_cpl'],
                'filters' => ['search', 'taxonomy'],
                'return_format' => 'id',
            ],
            [
                'key' => 'field_sp_buku_panduan_pdf',
                'label' => 'PDF Buku Panduan Akademik',
                'name' => 'sp_buku_panduan_pdf',
                'type' => 'file',
                'return_format' => 'array',
                'library' => 'all',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'study_program',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'show_in_rest' => 1,
    ]);
});
