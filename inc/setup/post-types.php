<?php
/**
 * Register Custom Post Types for the theme
 *
 * @package WebJTI_Theme
 */

function webjti_register_theme_post_types() {

    // Register Ormawa Custom Post Type
    $labels = [
        'name'               => _x('Organisasi Kemahasiswaan', 'post type general name', 'webjti'),
        'singular_name'      => _x('Organisasi Kemahasiswaan', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Organisasi Mahasiswa', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Organisasi Mahasiswa', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'ormawa', 'webjti'),
        'add_new_item'       => __('Tambah Organisasi Kemahasiswaan Baru', 'webjti'),
        'new_item'           => __('Organisasi Kemahasiswaan Baru', 'webjti'),
        'edit_item'          => __('Edit Organisasi Kemahasiswaan', 'webjti'),
        'view_item'          => __('Lihat Organisasi Kemahasiswaan', 'webjti'),
        'all_items'          => __('Semua Organisasi Kemahasiswaan', 'webjti'),
        'search_items'       => __('Cari Organisasi Kemahasiswaan', 'webjti'),
        'parent_item_colon'  => __('Induk Organisasi Kemahasiswaan:', 'webjti'),
        'not_found'          => __('Tidak ada organisasi kemahasiswaan ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada organisasi kemahasiswaan di Sampah.', 'webjti')
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'student-affairs/organisasi-kemahasiswaan', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'       => true,
    ];

    register_post_type('ormawa', $args);

    // Register Galeri Kemahasiswaan
    $gallery_labels = [
        'name'               => _x('Galeri Kemahasiswaan', 'post type general name', 'webjti'),
        'singular_name'      => _x('Galeri', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Galeri Mahasiswa', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Galeri', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Galeri', 'ormawa_gallery', 'webjti'),
        'add_new_item'       => __('Tambah Galeri Baru', 'webjti'),
        'new_item'           => __('Galeri Baru', 'webjti'),
        'edit_item'          => __('Edit Galeri', 'webjti'),
        'view_item'          => __('Lihat Galeri', 'webjti'),
        'all_items'          => __('Semua Galeri', 'webjti'),
        'search_items'       => __('Cari Galeri', 'webjti'),
        'parent_item_colon'  => __('Parent Galeri:', 'webjti'),
        'not_found'          => __('Tidak ada galeri ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada galeri di Sampah.', 'webjti')
    ];

    $gallery_args = [
        'labels'             => $gallery_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=ormawa',
        'menu_icon'          => 'dashicons-format-gallery',
        'menu_position'      => 21,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => ['title'],
        'show_in_rest'       => true,
    ];

    register_post_type('ormawa_gallery', $gallery_args);

    // Register Academic Regulations
    $aturan_labels = [
        'name'               => _x('Aturan Akademik', 'post type general name', 'webjti'),
        'singular_name'      => _x('Aturan Akademik', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Aturan Akademik', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Aturan Akademik', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Sub-Judul', 'aturan_akademik', 'webjti'),
        'add_new_item'       => __('Tambah Aturan Akademik Baru', 'webjti'),
        'new_item'           => __('Aturan Akademik Baru', 'webjti'),
        'edit_item'          => __('Edit Aturan Akademik', 'webjti'),
        'view_item'          => __('Lihat Aturan Akademik', 'webjti'),
        'all_items'          => __('Semua Aturan Akademik', 'webjti'),
        'search_items'       => __('Cari Aturan Akademik', 'webjti'),
        'not_found'          => __('Tidak ada aturan akademik ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada aturan akademik di Sampah.', 'webjti')
    ];

    $aturan_args = [
        'labels'             => $aturan_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => ['title', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('aturan_akademik', $aturan_args);

    // Register Alur Magang
    $alur_labels = [
        'name'               => _x('Alur Magang', 'post type general name', 'webjti'),
        'singular_name'      => _x('Alur Magang', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Alur Magang', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Alur Magang', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'magang_alur', 'webjti'),
        'add_new_item'       => __('Tambah Tahapan Alur Magang', 'webjti'),
        'new_item'           => __('Alur Magang Baru', 'webjti'),
        'edit_item'          => __('Edit Alur Magang', 'webjti'),
        'view_item'          => __('Lihat Alur Magang', 'webjti'),
        'all_items'          => __('Semua Alur Magang', 'webjti'),
        'search_items'       => __('Cari Alur Magang', 'webjti'),
        'not_found'          => __('Tidak ada data alur magang.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada data alur magang di Sampah.', 'webjti')
    ];

    $alur_args = [
        'labels'             => $alur_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-list-view',
        'supports'           => ['title', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('magang_alur', $alur_args);

    // Register Kategori Magang Taxonomy
    $kat_magang_labels = [
        'name'              => _x('Kategori Magang', 'taxonomy general name', 'webjti'),
        'singular_name'     => _x('Kategori Magang', 'taxonomy singular name', 'webjti'),
        'search_items'      => __('Cari Kategori Magang', 'webjti'),
        'all_items'         => __('Semua Kategori', 'webjti'),
        'edit_item'         => __('Edit Kategori', 'webjti'),
        'update_item'       => __('Update Kategori', 'webjti'),
        'add_new_item'      => __('Tambah Kategori Baru', 'webjti'),
        'new_item_name'     => __('Nama Kategori Baru', 'webjti'),
        'menu_name'         => __('Kategori Magang', 'webjti'),
        'back_to_items'     => __('← Kembali ke Kategori', 'webjti'),
    ];

    register_taxonomy('kategori_magang', ['magang_alur'], [
        'labels'            => $kat_magang_labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);

    // Register Company Partner
    $company_labels = [
        'name'               => _x('Perusahaan Magang', 'post type general name', 'webjti'),
        'singular_name'      => _x('Perusahaan Magang', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Perusahaan Magang', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Perusahaan Magang', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Perusahaan', 'company_partner', 'webjti'),
        'add_new_item'       => __('Tambah Perusahaan Magang Baru', 'webjti'),
        'new_item'           => __('Perusahaan Magang Baru', 'webjti'),
        'edit_item'          => __('Edit Perusahaan Magang', 'webjti'),
        'view_item'          => __('Lihat Perusahaan Magang', 'webjti'),
        'all_items'          => __('Semua Perusahaan Magang', 'webjti'),
        'search_items'       => __('Cari Perusahaan Magang', 'webjti'),
        'not_found'          => __('Tidak ada data perusahaan magang.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada data perusahaan magang di Sampah.', 'webjti')
    ];

    $company_args = [
        'labels'             => $company_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-building',
        'supports'           => ['title', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('company_partner', $company_args);

    // Register Dedication (Community Service / Pengabdian) CPT
    $dedication_labels = [
        'name'               => _x('Pengabdian Masyarakat', 'post type general name', 'webjti'),
        'singular_name'      => _x('Pengabdian Masyarakat', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Pengabdian Masyarakat', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Pengabdian Masyarakat', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'dedication', 'webjti'),
        'add_new_item'       => __('Tambah Pengabdian Baru', 'webjti'),
        'new_item'           => __('Pengabdian Baru', 'webjti'),
        'edit_item'          => __('Edit Pengabdian', 'webjti'),
        'view_item'          => __('Lihat Pengabdian', 'webjti'),
        'all_items'          => __('Semua Pengabdian', 'webjti'),
        'search_items'       => __('Cari Pengabdian', 'webjti'),
        'parent_item_colon'  => __('Induk Pengabdian:', 'webjti'),
        'not_found'          => __('Tidak ada pengabdian masyarakat ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada pengabdian masyarakat di Sampah.', 'webjti')
    ];

    $dedication_args = [
        'labels'             => $dedication_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'research/pengabdian', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 27,
        'menu_icon'          => 'dashicons-heart',
        'supports'           => ['title', 'editor', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('dedication', $dedication_args);

    // Register Dedication Scheme CPT (Submenu under Dedication)
    $scheme_labels = [
        'name'               => _x('Skema Pengabdian', 'post type general name', 'webjti'),
        'singular_name'      => _x('Skema Pengabdian', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Skema Pengabdian', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Skema Pengabdian', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Skema', 'dedication_scheme', 'webjti'),
        'add_new_item'       => __('Tambah Skema Pengabdian Baru', 'webjti'),
        'new_item'           => __('Skema Pengabdian Baru', 'webjti'),
        'edit_item'          => __('Edit Skema Pengabdian', 'webjti'),
        'view_item'          => __('Lihat Skema Pengabdian', 'webjti'),
        'all_items'          => __('Semua Skema Pengabdian', 'webjti'),
        'search_items'       => __('Cari Skema Pengabdian', 'webjti'),
        'not_found'          => __('Tidak ada skema pengabdian ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada skema pengabdian di Sampah.', 'webjti')
    ];

    $scheme_args = [
        'labels'             => $scheme_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=dedication',
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => ['title'],
        'show_in_rest'       => true,
    ];

    register_post_type('dedication_scheme', $scheme_args);

    // Register Lecturer (Tenaga Pengajar) CPT
    $lecturer_labels = [
        'name'               => _x('Tenaga Pengajar', 'post type general name', 'webjti'),
        'singular_name'      => _x('Tenaga Pengajar', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Tenaga Pengajar', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Tenaga Pengajar', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'lecturer', 'webjti'),
        'add_new_item'       => __('Tambah Tenaga Pengajar Baru', 'webjti'),
        'new_item'           => __('Tenaga Pengajar Baru', 'webjti'),
        'edit_item'          => __('Edit Tenaga Pengajar', 'webjti'),
        'view_item'          => __('Lihat Tenaga Pengajar', 'webjti'),
        'all_items'          => __('Semua Tenaga Pengajar', 'webjti'),
        'search_items'       => __('Cari Tenaga Pengajar', 'webjti'),
        'not_found'          => __('Tidak ada tenaga pengajar ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada tenaga pengajar di Sampah.', 'webjti')
    ];

    $lecturer_args = [
        'labels'             => $lecturer_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'tenaga-pengajar', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'       => true,
    ];

    register_post_type('lecturer', $lecturer_args);

    // Register Lecturer Sub-CPTs
    register_post_type('lecturer_education', [
        'labels' => [
            'name'          => 'Pendidikan Dosen',
            'singular_name' => 'Pendidikan Dosen',
            'add_new'       => 'Tambah Baru',
            'add_new_item'  => 'Tambah Pendidikan Dosen Baru',
            'edit_item'     => 'Edit Pendidikan Dosen',
            'all_items'     => 'Semua Pendidikan Dosen',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=lecturer',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    register_post_type('lecturer_certification', [
        'labels' => [
            'name'          => 'Sertifikasi Dosen',
            'singular_name' => 'Sertifikasi Dosen',
            'add_new'       => 'Tambah Baru',
            'add_new_item'  => 'Tambah Sertifikasi Dosen Baru',
            'edit_item'     => 'Edit Sertifikasi Dosen',
            'all_items'     => 'Semua Sertifikasi Dosen',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=lecturer',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    register_post_type('lecturer_publication', [
        'labels' => [
            'name'          => 'Publikasi Dosen',
            'singular_name' => 'Publikasi Dosen',
            'add_new'       => 'Tambah Baru',
            'add_new_item'  => 'Tambah Publikasi Dosen Baru',
            'edit_item'     => 'Edit Publikasi Dosen',
            'all_items'     => 'Semua Publikasi Dosen',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=lecturer',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    register_post_type('lecturer_course', [
        'labels' => [
            'name'          => 'Mata Kuliah Dosen',
            'singular_name' => 'Mata Kuliah Dosen',
            'add_new'       => 'Tambah Baru',
            'add_new_item'  => 'Tambah Mata Kuliah Dosen Baru',
            'edit_item'     => 'Edit Mata Kuliah Dosen',
            'all_items'     => 'Semua Mata Kuliah Dosen',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=lecturer',
        'supports'     => ['title', 'editor', 'custom-fields'],
        'show_in_rest' => true,
    ]);

    // Register Expertise (Bidang Keahlian) Taxonomy for Lecturer CPT
    $expertise_tax_labels = [
        'name'          => _x('Bidang Keahlian', 'taxonomy general name', 'webjti'),
        'singular_name' => _x('Bidang Keahlian', 'taxonomy singular name', 'webjti'),
        'search_items'  => __('Cari Bidang Keahlian', 'webjti'),
        'all_items'     => __('Semua Bidang Keahlian', 'webjti'),
        'edit_item'     => __('Edit Bidang Keahlian', 'webjti'),
        'update_item'   => __('Update Bidang Keahlian', 'webjti'),
        'add_new_item'  => __('Tambah Bidang Keahlian', 'webjti'),
        'new_item_name' => __('Nama Bidang Keahlian Baru', 'webjti'),
        'menu_name'     => __('Bidang Keahlian', 'webjti'),
    ];

    register_taxonomy('expertise', ['lecturer'], [
        'labels'            => $expertise_tax_labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'bidang-keahlian', 'with_front' => false],
        'show_in_rest'      => true,
    ]);

    // Register Campus Location (Lokasi Kampus) Taxonomy for Lecturer CPT
    $campus_tax_labels = [
        'name'          => _x('Lokasi Kampus', 'taxonomy general name', 'webjti'),
        'singular_name' => _x('Lokasi Kampus', 'taxonomy singular name', 'webjti'),
        'search_items'  => __('Cari Lokasi Kampus', 'webjti'),
        'all_items'     => __('Semua Lokasi Kampus', 'webjti'),
        'edit_item'     => __('Edit Lokasi Kampus', 'webjti'),
        'update_item'   => __('Update Lokasi Kampus', 'webjti'),
        'add_new_item'  => __('Tambah Lokasi Kampus', 'webjti'),
        'new_item_name' => __('Nama Lokasi Kampus Baru', 'webjti'),
        'menu_name'     => __('Lokasi Kampus', 'webjti'),
    ];

    register_taxonomy('campus_location', ['lecturer'], [
        'labels'            => $campus_tax_labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'lokasi-kampus', 'with_front' => false],
        'show_in_rest'      => true,
    ]);

    // Remove any Laboratory submenus under Tenaga Pengajar (data is retrieved from CPT Laboratorium)
    add_action('admin_menu', function() {
        remove_submenu_page('edit.php?post_type=lecturer', 'edit-tags.php?taxonomy=laboratory&post_type=lecturer');
        remove_submenu_page('edit.php?post_type=lecturer', 'edit-tags.php?taxonomy=laboratories&post_type=lecturer');
        remove_submenu_page('edit.php?post_type=lecturer', 'edit-tags.php?taxonomy=laboratorium&post_type=lecturer');
        remove_submenu_page('edit.php?post_type=lecturer', 'edit.php?post_type=laboratory');
    }, 9999);

    // Register Study Program CPT
    $sp_labels = [
        'name'               => _x('Program Studi', 'post type general name', 'webjti'),
        'singular_name'      => _x('Program Studi', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Program Studi', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Program Studi', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'study_program', 'webjti'),
        'add_new_item'       => __('Tambah Program Studi Baru', 'webjti'),
        'new_item'           => __('Program Studi Baru', 'webjti'),
        'edit_item'          => __('Edit Program Studi', 'webjti'),
        'view_item'          => __('Lihat Program Studi', 'webjti'),
        'all_items'          => __('Semua Program Studi', 'webjti'),
        'search_items'       => __('Cari Program Studi', 'webjti'),
        'not_found'          => __('Tidak ada program studi ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada program studi di Sampah.', 'webjti')
    ];

    $sp_args = [
        'labels'             => $sp_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'program-studi', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'show_in_rest'       => true,
    ];

    register_post_type('study_program', $sp_args);

    // Remove slug prefix for Study Program CPT
    add_filter('post_type_link', function ($post_link, $post) {
        if ('study_program' === $post->post_type && 'publish' === $post->post_status) {
            $post_link = str_replace('/program-studi/', '/', $post_link);
        }
        return $post_link;
    }, 10, 2);

    add_action('pre_get_posts', function ($query) {
        if (!is_admin() && $query->is_main_query()) {
            $name = $query->get('name');
            $pagename = $query->get('pagename');
            if (!empty($name) || !empty($pagename)) {
                $target_slug = basename($name ?: $pagename);
                global $wpdb;
                $found_pt = $wpdb->get_var($wpdb->prepare(
                    "SELECT post_type FROM $wpdb->posts WHERE post_name = %s AND post_status = 'publish' LIMIT 1",
                    $target_slug
                ));
                if ($found_pt === 'study_program') {
                    $query->set('post_type', 'study_program');
                    $query->set('name', $target_slug);
                    $query->set('pagename', '');
                    $query->is_single = true;
                    $query->is_page = false;
                    $query->is_404 = false;
                }
            }
        }
    });

    // ── Register Fasilitas CPT ─────────────────────────────────────
    $fasilitas_labels = [
        'name'               => _x('Fasilitas', 'post type general name', 'webjti'),
        'singular_name'      => _x('Fasilitas', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Fasilitas', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Fasilitas', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Fasilitas', 'fasilitas', 'webjti'),
        'add_new_item'       => __('Tambah Fasilitas Baru', 'webjti'),
        'new_item'           => __('Fasilitas Baru', 'webjti'),
        'edit_item'          => __('Edit Fasilitas', 'webjti'),
        'view_item'          => __('Lihat Fasilitas', 'webjti'),
        'all_items'          => __('Semua Fasilitas', 'webjti'),
        'search_items'       => __('Cari Fasilitas', 'webjti'),
        'not_found'          => __('Tidak ada data fasilitas.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada data fasilitas di Sampah.', 'webjti'),
    ];

    $fasilitas_args = [
        'labels'             => $fasilitas_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 28,
        'menu_icon'          => 'dashicons-building',
        'supports'           => ['title', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('fasilitas', $fasilitas_args);

    // ── Register Kategori Fasilitas Taxonomy ───────────────────────
    $kat_fasilitas_labels = [
        'name'              => _x('Kategori Fasilitas', 'taxonomy general name', 'webjti'),
        'singular_name'     => _x('Kategori Fasilitas', 'taxonomy singular name', 'webjti'),
        'search_items'      => __('Cari Kategori Fasilitas', 'webjti'),
        'all_items'         => __('Semua Kategori', 'webjti'),
        'edit_item'         => __('Edit Kategori', 'webjti'),
        'update_item'       => __('Update Kategori', 'webjti'),
        'add_new_item'      => __('Tambah Kategori Baru', 'webjti'),
        'new_item_name'     => __('Nama Kategori Baru', 'webjti'),
        'menu_name'         => __('Kategori Fasilitas', 'webjti'),
        'back_to_items'     => __('← Kembali ke Kategori', 'webjti'),
    ];

    register_taxonomy('kategori_fasilitas', ['fasilitas'], [
        'labels'            => $kat_fasilitas_labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);

    // ── Register Laboratory CPT ──────────────────────────────────────
    $lab_labels = [
        'name'               => _x('Laboratorium', 'post type general name', 'webjti'),
        'singular_name'      => _x('Laboratorium', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Laboratorium', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Laboratorium', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Laboratorium', 'laboratory', 'webjti'),
        'add_new_item'       => __('Tambah Laboratorium Baru', 'webjti'),
        'new_item'           => __('Laboratorium Baru', 'webjti'),
        'edit_item'          => __('Edit Laboratorium', 'webjti'),
        'view_item'          => __('Lihat Laboratorium', 'webjti'),
        'all_items'          => __('Semua Laboratorium', 'webjti'),
        'search_items'       => __('Cari Laboratorium', 'webjti'),
        'not_found'          => __('Tidak ada laboratorium ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada laboratorium di Sampah.', 'webjti'),
    ];

    $lab_args = [
        'labels'             => $lab_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'research/laboratory', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 29,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => ['title', 'thumbnail'],
        'show_in_rest'       => true, // Restores standard Classic Visual Editor
    ];

    register_post_type('laboratory', $lab_args);

    // ── Register Laboratory Features CPTs (Submenus under Laboratories) ──
    register_post_type('lab_facility', [
        'labels' => [
            'name'          => 'Fasilitas & Peralatan',
            'singular_name' => 'Fasilitas Lab',
            'add_new'       => 'Tambah Fasilitas',
            'add_new_item'  => 'Tambah Fasilitas Lab Baru',
            'edit_item'     => 'Edit Fasilitas Lab',
            'all_items'     => 'Fasilitas & Peralatan',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    register_post_type('lab_activity', [
        'labels' => [
            'name'          => 'Kegiatan & Proyek',
            'singular_name' => 'Kegiatan Lab',
            'add_new'       => 'Tambah Kegiatan',
            'add_new_item'  => 'Tambah Kegiatan Lab Baru',
            'edit_item'     => 'Edit Kegiatan Lab',
            'all_items'     => 'Kegiatan & Proyek',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    register_post_type('lab_course', [
        'labels' => [
            'name'          => 'Perkuliahan Terkait',
            'singular_name' => 'Perkuliahan Lab',
            'add_new'       => 'Tambah Perkuliahan',
            'add_new_item'  => 'Tambah Perkuliahan Lab Baru',
            'edit_item'     => 'Edit Perkuliahan Lab',
            'all_items'     => 'Perkuliahan Terkait',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    register_post_type('lab_focus', [
        'labels' => [
            'name'          => 'Fokus Riset',
            'singular_name' => 'Fokus Riset',
            'add_new'       => 'Tambah Fokus Riset',
            'add_new_item'  => 'Tambah Fokus Riset Baru',
            'edit_item'     => 'Edit Fokus Riset',
            'all_items'     => 'Fokus Riset',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    register_post_type('lab_gallery', [
        'labels' => [
            'name'          => 'Galeri Foto',
            'singular_name' => 'Galeri Foto',
            'add_new'       => 'Tambah Galeri',
            'add_new_item'  => 'Tambah Galeri Foto Baru',
            'edit_item'     => 'Edit Galeri Foto',
            'all_items'     => 'Galeri Foto',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    register_post_type('lab_video', [
        'labels' => [
            'name'          => 'Galeri Video',
            'singular_name' => 'Galeri Video',
            'add_new'       => 'Tambah Video',
            'add_new_item'  => 'Tambah Galeri Video Baru',
            'edit_item'     => 'Edit Galeri Video',
            'all_items'     => 'Galeri Video',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=laboratory',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    $rf_labels = [
        'name'                       => _x('Fokus Riset', 'taxonomy general name', 'webjti'),
        'singular_name'              => _x('Fokus Riset', 'taxonomy singular name', 'webjti'),
        'search_items'               => __('Cari Fokus Riset', 'webjti'),
        'popular_items'              => __('Fokus Riset Populer', 'webjti'),
        'all_items'                  => __('Semua Fokus Riset', 'webjti'),
        'edit_item'                  => __('Edit Fokus Riset', 'webjti'),
        'update_item'                => __('Update Fokus Riset', 'webjti'),
        'add_new_item'               => __('Tambah Fokus Riset Baru', 'webjti'),
        'new_item_name'              => __('Nama Fokus Riset Baru', 'webjti'),
        'separate_items_with_commas' => __('Pisahkan Fokus Riset dengan koma', 'webjti'),
        'add_or_remove_items'        => __('Tambah atau hapus Fokus Riset', 'webjti'),
        'choose_from_most_used'      => __('Pilih dari Fokus Riset yang sering digunakan', 'webjti'),
        'not_found'                  => __('Fokus Riset tidak ditemukan.', 'webjti'),
        'menu_name'                  => __('Fokus Riset', 'webjti'),
    ];
    register_taxonomy('research_focus', ['laboratory'], [
        'labels'            => $rf_labels,
        'hierarchical'      => false,           // Tag-style: flat, auto-slug from name
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'research-focus', 'with_front' => false],
        'show_in_rest'      => true,
        'show_tagcloud'     => false,           // No description / tag cloud needed
        'meta_box_cb'       => 'post_tags_meta_box', // Flat tag-style input box in CPT edit screen
    ]);

    // Force unregister research_focus taxonomy to eliminate duplicate focus menus
    unregister_taxonomy_for_object_type('research_focus', 'laboratory');
    unregister_taxonomy('research_focus');



    // Register Mata Kuliah CPT
    $mata_kuliah_labels = [
        'name'               => _x('Mata Kuliah', 'post type general name', 'webjti'),
        'singular_name'      => _x('Mata Kuliah', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Mata Kuliah', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Mata Kuliah', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'mata_kuliah', 'webjti'),
        'add_new_item'       => __('Tambah Mata Kuliah Baru', 'webjti'),
        'new_item'           => __('Mata Kuliah Baru', 'webjti'),
        'edit_item'          => __('Edit Mata Kuliah', 'webjti'),
        'view_item'          => __('Lihat Mata Kuliah', 'webjti'),
        'all_items'          => __('Semua Mata Kuliah', 'webjti'),
        'search_items'       => __('Cari Mata Kuliah', 'webjti'),
        'not_found'          => __('Tidak ada mata kuliah ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada mata kuliah di Sampah.', 'webjti'),
    ];

    $mata_kuliah_args = [
        'labels'             => $mata_kuliah_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => ['slug' => 'mata-kuliah', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 27,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => ['title', 'editor', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('mata_kuliah', $mata_kuliah_args);

    // Register Mata Kuliah Spesialis CPT
    $mk_spesialis_labels = [
        'name'               => _x('Mata Kuliah Spesialis', 'post type general name', 'webjti'),
        'singular_name'      => _x('Mata Kuliah Spesialis', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Mata Kuliah Spesialis', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Mata Kuliah Spesialis', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'mata_kuliah_spesialis', 'webjti'),
        'add_new_item'       => __('Tambah Mata Kuliah Spesialis Baru', 'webjti'),
        'new_item'           => __('Mata Kuliah Spesialis Baru', 'webjti'),
        'edit_item'          => __('Edit Mata Kuliah Spesialis', 'webjti'),
        'view_item'          => __('Lihat Mata Kuliah Spesialis', 'webjti'),
        'all_items'          => __('Mata Kuliah Spesialis', 'webjti'),
        'search_items'       => __('Cari Mata Kuliah Spesialis', 'webjti'),
        'not_found'          => __('Tidak ada mata kuliah spesialis ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada mata kuliah spesialis di Sampah.', 'webjti'),
    ];

    $mk_spesialis_args = [
        'labels'             => $mk_spesialis_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => ['title'],
        'show_in_rest'       => true,
    ];

    register_post_type('mk_spesialis', $mk_spesialis_args);

    // Register Bahan Kajian CPT
    $bahan_kajian_labels = [
        'name'               => _x('Bahan Kajian', 'post type general name', 'webjti'),
        'singular_name'      => _x('Bahan Kajian', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Bahan Kajian', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Bahan Kajian', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'bahan_kajian', 'webjti'),
        'add_new_item'       => __('Tambah Bahan Kajian Baru', 'webjti'),
        'new_item'           => __('Bahan Kajian Baru', 'webjti'),
        'edit_item'          => __('Edit Bahan Kajian', 'webjti'),
        'view_item'          => __('Lihat Bahan Kajian', 'webjti'),
        'all_items'          => __('Semua Bahan Kajian', 'webjti'),
        'search_items'       => __('Cari Bahan Kajian', 'webjti'),
        'not_found'          => __('Tidak ada bahan kajian ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada bahan kajian di Sampah.', 'webjti'),
    ];

    $bahan_kajian_args = [
        'labels'             => $bahan_kajian_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => ['slug' => 'bahan-kajian', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 28,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('bahan_kajian', $bahan_kajian_args);

    // Register Bidang Keahlian CPT
    $bidang_keahlian_labels = [
        'name'               => _x('Bidang Keahlian', 'post type general name', 'webjti'),
        'singular_name'      => _x('Bidang Keahlian', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Bidang Keahlian', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Bidang Keahlian', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'bidang_keahlian', 'webjti'),
        'add_new_item'       => __('Tambah Bidang Keahlian Baru', 'webjti'),
        'new_item'           => __('Bidang Keahlian Baru', 'webjti'),
        'edit_item'          => __('Edit Bidang Keahlian', 'webjti'),
        'view_item'          => __('Lihat Bidang Keahlian', 'webjti'),
        'all_items'          => __('Semua Bidang Keahlian', 'webjti'),
        'search_items'       => __('Cari Bidang Keahlian', 'webjti'),
        'not_found'          => __('Tidak ada bidang keahlian ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada bidang keahlian di Sampah.', 'webjti'),
    ];

    $bidang_keahlian_args = [
        'labels'             => $bidang_keahlian_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => ['slug' => 'bidang-keahlian', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 29,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'taxonomies'         => [],
        'show_in_rest'       => true,
    ];

    register_post_type('bidang_keahlian', $bidang_keahlian_args);

    // Register Kategori Program Studi Taxonomy (Used to filter CPTs per program studi)
    $kat_prodi_labels = [
        'name'              => _x('Kategori Program Studi', 'taxonomy general name', 'webjti'),
        'singular_name'     => _x('Kategori Program Studi', 'taxonomy singular name', 'webjti'),
        'search_items'      => __('Cari Kategori Program Studi', 'webjti'),
        'all_items'         => __('Semua Kategori', 'webjti'),
        'edit_item'         => __('Edit Kategori', 'webjti'),
        'update_item'       => __('Update Kategori', 'webjti'),
        'add_new_item'      => __('Tambah Kategori Baru', 'webjti'),
        'new_item_name'     => __('Nama Kategori Baru', 'webjti'),
        'menu_name'         => __('Kategori Prodi', 'webjti'),
        'back_to_items'     => __('← Kembali ke Kategori', 'webjti'),
    ];

    register_taxonomy('kategori_program_studi', ['study_program', 'profil_lulusan', 'capaian_lulusan', 'peta_jalan_cpl', 'mata_kuliah'], [
        'labels'            => $kat_prodi_labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);

    $default_prodi_categories = [
        'd3-manajemen-informatika-kediri' => __('D3 Manajemen Informatika (Kediri)', 'webjti'),
        'd3-manajemen-informatika-lumajang' => __('D3 Manajemen Informatika (PSDKU Lumajang)', 'webjti'),
        'd4-teknik-informatika' => __('D4 Teknik Informatika', 'webjti'),
        'd4-sistem-informasi-bisnis' => __('D4 Sistem Informasi Bisnis', 'webjti'),
        's2-rekayasa-teknologi-informasi' => __('S2 Rekayasa Teknologi Informasi', 'webjti'),
    ];

    foreach ($default_prodi_categories as $slug => $name) {
        if (!term_exists($slug, 'kategori_program_studi')) {
            wp_insert_term($name, 'kategori_program_studi', ['slug' => $slug]);
        }
    }

    // Register Profil Lulusan CPT
    $profil_labels = [
        'name'               => _x('Profil Lulusan', 'post type general name', 'webjti'),
        'singular_name'      => _x('Profil Lulusan', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Profil Lulusan', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Profil Lulusan', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'profil_lulusan', 'webjti'),
        'add_new_item'       => __('Tambah Profil Lulusan Baru', 'webjti'),
        'new_item'           => __('Profil Lulusan Baru', 'webjti'),
        'edit_item'          => __('Edit Profil Lulusan', 'webjti'),
        'view_item'          => __('Lihat Profil Lulusan', 'webjti'),
        'all_items'          => __('Semua Profil Lulusan', 'webjti'),
        'search_items'       => __('Cari Profil Lulusan', 'webjti'),
        'not_found'          => __('Tidak ada profil lulusan ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada profil lulusan di Sampah.', 'webjti'),
    ];

    $profil_args = [
        'labels'             => $profil_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => ['slug' => 'profil-lulusan', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => ['title', 'editor', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('profil_lulusan', $profil_args);

    // Register Capaian Lulusan taxonomy
    $capaian_tabel_labels = [
        'name'              => _x('Tabel Capaian Lulusan', 'taxonomy general name', 'webjti'),
        'singular_name'     => _x('Tabel Capaian Lulusan', 'taxonomy singular name', 'webjti'),
        'search_items'      => __('Cari Tabel', 'webjti'),
        'all_items'         => __('Semua Tabel', 'webjti'),
        'edit_item'         => __('Edit Tabel', 'webjti'),
        'update_item'       => __('Update Tabel', 'webjti'),
        'add_new_item'      => __('Tambah Tabel Baru', 'webjti'),
        'new_item_name'     => __('Nama Tabel Baru', 'webjti'),
        'menu_name'         => __('Tabel Capaian', 'webjti'),
        'back_to_items'     => __('← Kembali ke Tabel', 'webjti'),
    ];

    register_taxonomy('capaian_lulusan_tabel', ['study_program', 'capaian_lulusan'], [
        'labels'            => $capaian_tabel_labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    ]);

    $default_capaian_tables = [
        'sikap' => __('Sikap', 'webjti'),
        'penguasaan-pengetahuan' => __('Penguasaan Pengetahuan', 'webjti'),
        'keterampilan-khusus' => __('Keterampilan Khusus', 'webjti'),
        'keterampilan-umum' => __('Keterampilan Umum', 'webjti'),
    ];

    foreach ($default_capaian_tables as $slug => $name) {
        if (!term_exists($slug, 'capaian_lulusan_tabel')) {
            wp_insert_term($name, 'capaian_lulusan_tabel', ['slug' => $slug]);
        }
    }

    // Register Capaian Lulusan CPT
    $capaian_labels = [
        'name'               => _x('Capaian Lulusan', 'post type general name', 'webjti'),
        'singular_name'      => _x('Capaian Lulusan', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Capaian Lulusan', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Capaian Lulusan', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'capaian_lulusan', 'webjti'),
        'add_new_item'       => __('Tambah Capaian Lulusan Baru', 'webjti'),
        'new_item'           => __('Capaian Lulusan Baru', 'webjti'),
        'edit_item'          => __('Edit Capaian Lulusan', 'webjti'),
        'view_item'          => __('Lihat Capaian Lulusan', 'webjti'),
        'all_items'          => __('Semua Capaian Lulusan', 'webjti'),
        'search_items'       => __('Cari Capaian Lulusan', 'webjti'),
        'not_found'          => __('Tidak ada capaian lulusan ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada capaian lulusan di Sampah.', 'webjti'),
    ];

    $capaian_args = [
        'labels'             => $capaian_labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=study_program',
        'query_var'          => true,
        'rewrite'            => ['slug' => 'capaian-lulusan', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => ['title', 'editor', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('capaian_lulusan', $capaian_args);

    // Register Peta Jalan CPL CPT (Submenu under Capaian Lulusan)
    register_post_type('peta_jalan_cpl', [
        'labels' => [
            'name'          => 'Peta Jalan CPL',
            'singular_name' => 'Peta Jalan CPL',
            'add_new'       => 'Tambah Peta Jalan',
            'add_new_item'  => 'Tambah Peta Jalan CPL Baru',
            'edit_item'     => 'Edit Peta Jalan CPL',
            'all_items'     => 'Peta Jalan CPL',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => 'edit.php?post_type=study_program',
        'supports'     => ['title'],
        'show_in_rest' => false,
    ]);

    // Register Beasiswa CPT
    $beasiswa_labels = [
        'name'               => _x('Beasiswa', 'post type general name', 'webjti'),
        'singular_name'      => _x('Beasiswa', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Beasiswa', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Beasiswa', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'beasiswa', 'webjti'),
        'add_new_item'       => __('Tambah Beasiswa Baru', 'webjti'),
        'new_item'           => __('Beasiswa Baru', 'webjti'),
        'edit_item'          => __('Edit Beasiswa', 'webjti'),
        'view_item'          => __('Lihat Beasiswa', 'webjti'),
        'all_items'          => __('Semua Beasiswa', 'webjti'),
        'search_items'       => __('Cari Beasiswa', 'webjti'),
        'not_found'          => __('Tidak ada beasiswa ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada beasiswa di Sampah.', 'webjti'),
    ];

    $beasiswa_args = [
        'labels'             => $beasiswa_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'beasiswa', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 30,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('beasiswa', $beasiswa_args);

    // Register Career Program Category (Taxonomy)
    $career_cat_labels = [
        'name'              => _x('Kategori Karir', 'taxonomy general name', 'webjti'),
        'singular_name'     => _x('Kategori Karir', 'taxonomy singular name', 'webjti'),
        'search_items'      => __('Cari Kategori Karir', 'webjti'),
        'all_items'         => __('Semua Kategori', 'webjti'),
        'parent_item'       => __('Kategori Induk', 'webjti'),
        'parent_item_colon' => __('Kategori Induk:', 'webjti'),
        'edit_item'         => __('Edit Kategori', 'webjti'),
        'update_item'       => __('Update Kategori', 'webjti'),
        'add_new_item'      => __('Tambah Kategori Baru', 'webjti'),
        'new_item_name'     => __('Nama Kategori Baru', 'webjti'),
        'menu_name'         => __('Kategori Karir', 'webjti'),
    ];
    $career_cat_args = [
        'hierarchical'      => true,
        'labels'            => $career_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'kategori-karir'],
        'show_in_rest'      => true,
    ];
    register_taxonomy('career_category', ['career_program'], $career_cat_args);

    // Register Career Program Custom Post Type
    $career_labels = [
        'name'               => _x('Pengembangan Karir', 'post type general name', 'webjti'),
        'singular_name'      => _x('Program Karir', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Pengembangan Karir', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Program Karir', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'karir', 'webjti'),
        'add_new_item'       => __('Tambah Program Karir Baru', 'webjti'),
        'new_item'           => __('Program Karir Baru', 'webjti'),
        'edit_item'          => __('Edit Program Karir', 'webjti'),
        'view_item'          => __('Lihat Program Karir', 'webjti'),
        'all_items'          => __('Semua Program Karir', 'webjti'),
        'search_items'       => __('Cari Program Karir', 'webjti'),
        'not_found'          => __('Tidak ada program karir ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada program karir di Sampah.', 'webjti')
    ];
    $career_args = [
        'labels'             => $career_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'pengembangan-karir', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'       => true,
    ];
    register_post_type('career_program', $career_args);

    // Register Program Khusus (RPL / Alih Jenjang) CPT
    $pk_labels = [
        'name'               => _x('Program Khusus', 'post type general name', 'webjti'),
        'singular_name'      => _x('Program Khusus', 'post type singular name', 'webjti'),
        'menu_name'          => _x('Program Khusus', 'admin menu', 'webjti'),
        'name_admin_bar'     => _x('Program Khusus', 'add new on admin bar', 'webjti'),
        'add_new'            => _x('Tambah Baru', 'program_khusus', 'webjti'),
        'add_new_item'       => __('Tambah Program Khusus Baru', 'webjti'),
        'new_item'           => __('Program Khusus Baru', 'webjti'),
        'edit_item'          => __('Edit Program Khusus', 'webjti'),
        'view_item'          => __('Lihat Program Khusus', 'webjti'),
        'all_items'          => __('Semua Program Khusus', 'webjti'),
        'search_items'       => __('Cari Program Khusus', 'webjti'),
        'not_found'          => __('Tidak ada program khusus ditemukan.', 'webjti'),
        'not_found_in_trash' => __('Tidak ada program khusus di Sampah.', 'webjti')
    ];

    $pk_args = [
        'labels'             => $pk_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'program-khusus', 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 24,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        // Use editor for full `deskripsi`, and custom fields for the rest
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
        'show_in_rest'       => true,
    ];

    register_post_type('program_khusus', $pk_args);

    // Register Taxonomy for Program Khusus Type
    register_taxonomy('tipe_program_khusus', ['program_khusus'], [
        'labels' => [
            'name'              => _x('Tipe Program Khusus', 'taxonomy general name', 'webjti'),
            'singular_name'     => _x('Tipe Program Khusus', 'taxonomy singular name', 'webjti'),
            'search_items'      => __('Cari Tipe Program', 'webjti'),
            'all_items'         => __('Semua Tipe Program', 'webjti'),
            'edit_item'         => __('Edit Tipe Program', 'webjti'),
            'update_item'       => __('Update Tipe Program', 'webjti'),
            'add_new_item'      => __('Tambah Tipe Program Baru', 'webjti'),
            'new_item_name'     => __('Nama Tipe Program Baru', 'webjti'),
            'menu_name'         => __('Tipe Program', 'webjti'),
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'tipe-program-khusus', 'with_front' => false],
    ]);

    // Ensure default terms exist
    $default_terms = [
        'rpl'                 => 'Rekognisi Pembelajaran Lampau (RPL)',
        'alih_jenjang'        => 'Alih Jenjang',
        'double_degree'       => 'Double Degree',
        'kelas_internasional' => 'Kelas Internasional',
    ];
    foreach ($default_terms as $slug => $name) {
        if (!term_exists($slug, 'tipe_program_khusus')) {
            wp_insert_term($name, 'tipe_program_khusus', ['slug' => $slug]);
        }
    }

    // Add meta boxes for Program Khusus to capture template fields
    add_action('add_meta_boxes', function() {
        add_meta_box('pk_details', __('Detail & Validasi Program Khusus', 'webjti'), 'webjti_render_pk_metabox', 'program_khusus', 'normal', 'high');
    });

    function webjti_render_pk_metabox($post) {
        wp_nonce_field('webjti_save_pk_meta', 'webjti_pk_nonce');
        $tipe_program  = get_post_meta($post->ID, '_pk_tipe_program', true);
        if (!$tipe_program) {
            $terms = wp_get_post_terms($post->ID, 'tipe_program_khusus', ['fields' => 'slugs']);
            if (!empty($terms) && !is_wp_error($terms)) {
                $tipe_program = $terms[0];
            }
        }
        $persyaratan   = get_post_meta($post->ID, '_pk_persyaratan', true);
        $biaya_blocks  = get_post_meta($post->ID, '_pk_biaya_blocks', true);
        $timeline_rows = get_post_meta($post->ID, '_pk_timeline_rows', true);
        $kontak        = get_post_meta($post->ID, '_pk_kontak', true);

        $format_biaya  = get_post_meta($post->ID, '_pk_format_biaya', true) ?: 'tabel';
        $biaya_pendaftaran = get_post_meta($post->ID, '_pk_biaya_pendaftaran', true);
        $biaya_ipi = get_post_meta($post->ID, '_pk_biaya_ipi', true);
        $biaya_ukt = get_post_meta($post->ID, '_pk_biaya_ukt_list', true);
        $biaya_mitra_list = get_post_meta($post->ID, '_pk_biaya_mitra_list', true);
        $biaya_catatan = get_post_meta($post->ID, '_pk_biaya_catatan', true);

        // decode stored JSON if any
        $biaya_blocks  = $biaya_blocks ? json_decode($biaya_blocks, true) : [];
        $timeline_rows = $timeline_rows ? json_decode($timeline_rows, true) : [];
        $biaya_mitra_list = $biaya_mitra_list ? json_decode($biaya_mitra_list, true) : [];
        ?>
        <style>
            .webjti-repeatable { border:1px solid #e2e8f0; border-radius:6px; padding:12px; margin-bottom:12px; background:#fff; }
            .webjti-row { margin-bottom:10px; }
            .webjti-actions { margin-top:8px; }
            .webjti-field-required { color:#e11d48; font-weight:bold; }
            .webjti-notice-box { background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #16a34a; padding:12px; margin-bottom:16px; border-radius:4px; }
            .webjti-validation-box { background:#fef2f2; border:1px solid #fecaca; border-left:4px solid #e11d48; padding:12px; margin-bottom:16px; border-radius:4px; }
        </style>

        <div class="webjti-validation-box" id="pk_validation_wrapper">
            <label for="pk_tipe_program" style="display:block; font-size:14px; font-weight:700; margin-bottom:6px; color:#1e293b;">
                <?php _e('Tipe Program Khusus', 'webjti'); ?> <span class="webjti-field-required">* (Wajib Dipilih)</span>
            </label>
            <select id="pk_tipe_program" name="pk_tipe_program" required style="width:100%; max-width:450px; padding:8px 12px; font-size:14px; border-radius:4px; border:1px solid #cbd5e1;">
                <option value=""><?php _e('-- Pilih Tipe Program Khusus --', 'webjti'); ?></option>
                <option value="rpl" <?php selected($tipe_program, 'rpl'); ?>>Rekognisi Pembelajaran Lampau (RPL)</option>
                <option value="alih_jenjang" <?php selected($tipe_program, 'alih_jenjang'); ?>>Alih Jenjang</option>
                <option value="double_degree" <?php selected($tipe_program, 'double_degree'); ?>>Double Degree</option>
                <option value="kelas_internasional" <?php selected($tipe_program, 'kelas_internasional'); ?>>Kelas Internasional</option>
            </select>
            <p class="description" style="margin-top:6px; color:#475569; font-size:12px;">
                <?php _e('Item CPT ini akan otomatis terhubung & ditampilkan pada halaman virtual program khusus yang dipilih (RPL, Alih Jenjang, Double Degree, atau Kelas Internasional).', 'webjti'); ?>
            </p>
        </div>

        <h4><?php _e('Persyaratan', 'webjti'); ?></h4>
        <p>
            <textarea id="pk_persyaratan" name="pk_persyaratan" rows="4" style="width:100%;"><?php echo esc_textarea($persyaratan); ?></textarea>
        </p>

        <h4><?php _e('Rincian Biaya', 'webjti'); ?></h4>
        
        <div class="webjti-row" style="margin-bottom: 15px; padding: 10px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 4px;">
            <label style="font-weight: 700; display: block; margin-bottom: 8px;">Format Rincian Biaya</label>
            <label style="margin-right: 20px;"><input type="radio" name="pk_format_biaya" value="tabel" <?php checked($format_biaya, 'tabel'); ?>> Tabel (Alih Jenjang / RPL)</label>
            <label><input type="radio" name="pk_format_biaya" value="list" <?php checked($format_biaya, 'list'); ?>> List (Kelas Internasional / Double Degree)</label>
        </div>

        <p class="webjti-row" style="margin-bottom: 15px;"><label><strong>Biaya Pendaftaran</strong></label>
        <input type="text" name="pk_biaya_pendaftaran" value="<?php echo esc_attr($biaya_pendaftaran); ?>" placeholder="Rp 300.000" style="width:100%; max-width:450px;" /></p>

        <div id="pk_biaya_tabel_wrapper" style="display: <?php echo $format_biaya === 'tabel' ? 'block' : 'none'; ?>;">
            <div id="pk_biaya_container">
                <?php if (!empty($biaya_blocks)) : ?>
                    <?php foreach ($biaya_blocks as $i => $block) :
                        $kelompok  = isset($block['kelompok']) ? $block['kelompok'] : '';
                        $bidang    = isset($block['bidang']) ? $block['bidang'] : (isset($block['title']) ? $block['title'] : '');
                        $ipi_utama = isset($block['ipi_utama']) ? $block['ipi_utama'] : (isset($block['content']) ? $block['content'] : '');
                        $ipi_psdku = isset($block['ipi_psdku']) ? $block['ipi_psdku'] : '';
                        $ipi_luar  = isset($block['ipi_luar']) ? $block['ipi_luar'] : '';
                        $ukt       = isset($block['ukt']) ? $block['ukt'] : '';
                    ?>
                    <div class="webjti-repeatable" data-index="<?php echo $i; ?>" style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px; margin-bottom:12px;">
                        <p class="webjti-row"><label><strong>Kelompok Program (Contoh: Transfer ke Sarjana Terapan)</strong></label>
                        <input type="text" name="pk_biaya_kelompok[]" value="<?php echo esc_attr($kelompok); ?>" placeholder="Transfer ke Sarjana Terapan" style="width:100%;" /></p>

                        <p class="webjti-row"><label><strong>Program Studi Lanjutan / Bidang (Contoh: Rekayasa / Sarjana Terapan TI)</strong></label>
                        <input type="text" name="pk_biaya_bidang[]" value="<?php echo esc_attr($bidang); ?>" placeholder="Rekayasa" style="width:100%;" /></p>

                        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap:10px; margin-top:8px;">
                            <p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (Utama)</strong></label>
                            <input type="text" name="pk_biaya_ipi_utama[]" value="<?php echo esc_attr($ipi_utama); ?>" placeholder="Rp2.500.000" style="width:100%;" /></p>

                            <p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (PSDKU)</strong></label>
                            <input type="text" name="pk_biaya_ipi_psdku[]" value="<?php echo esc_attr($ipi_psdku); ?>" placeholder="Rp10.000.000" style="width:100%;" /></p>

                            <p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (Luar Polinema)</strong></label>
                            <input type="text" name="pk_biaya_ipi_luar[]" value="<?php echo esc_attr($ipi_luar); ?>" placeholder="Rp12.500.000" style="width:100%;" /></p>

                            <p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">UKT / Semester</strong></label>
                            <input type="text" name="pk_biaya_ukt[]" value="<?php echo esc_attr($ukt); ?>" placeholder="Rp6.500.000" style="width:100%;" /></p>
                        </div>

                        <p class="webjti-actions" style="margin-top:10px;"><button type="button" class="button webjti-remove"><?php _e('Hapus Rincian Ini', 'webjti'); ?></button></p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <p><button type="button" class="button button-secondary" id="pk_add_biaya"><?php _e('+ Tambah Rincian Biaya', 'webjti'); ?></button></p>
        </div>

        <div id="pk_biaya_list_wrapper" style="display: <?php echo $format_biaya === 'list' ? 'block' : 'none'; ?>; padding: 15px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc;">
            <p class="webjti-row"><label><strong>IPI Rekayasa (Polinema)</strong></label>
            <input type="text" name="pk_biaya_ipi" value="<?php echo esc_attr($biaya_ipi); ?>" placeholder="Rp 22.500.000" style="width:100%;" /></p>
            
            <p class="webjti-row"><label><strong>UKT / Semester</strong></label>
            <input type="text" name="pk_biaya_ukt_list" value="<?php echo esc_attr($biaya_ukt); ?>" placeholder="Rp 15.375.000 / semester" style="width:100%;" /></p>

            <h5 style="margin-top: 15px; margin-bottom: 10px; font-size: 13px;">Estimasi Biaya Tambahan Kampus Mitra</h5>
            <div id="pk_biaya_mitra_container">
                <?php if (!empty($biaya_mitra_list)) : ?>
                    <?php foreach ($biaya_mitra_list as $i => $mitra) : 
                        $m_label = isset($mitra['label']) ? $mitra['label'] : '';
                        $m_nominal = isset($mitra['nominal']) ? $mitra['nominal'] : '';
                        $m_currency = isset($mitra['currency']) ? $mitra['currency'] : 'CNY';
                    ?>
                    <div class="webjti-repeatable" data-index="<?php echo $i; ?>" style="background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:12px; margin-bottom:12px; display: flex; gap: 10px; align-items: flex-end;">
                        <div style="flex: 2;"><label><strong>Label/Deskripsi</strong></label><input type="text" name="pk_biaya_mitra_label[]" value="<?php echo esc_attr($m_label); ?>" placeholder="Akomodasi / Asrama" style="width:100%;" /></div>
                        <div style="flex: 1;"><label><strong>Nominal</strong></label><input type="text" name="pk_biaya_mitra_nominal[]" value="<?php echo esc_attr($m_nominal); ?>" placeholder="7.200" style="width:100%;" /></div>
                        <div style="flex: 1;"><label><strong>Mata Uang</strong></label><input type="text" name="pk_biaya_mitra_currency[]" value="<?php echo esc_attr($m_currency); ?>" placeholder="CNY" style="width:100%;" /></div>
                        <div><button type="button" class="button webjti-remove">Hapus</button></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <p><button type="button" class="button button-secondary" id="pk_add_biaya_mitra"><?php _e('+ Tambah Biaya Mitra', 'webjti'); ?></button></p>

            <h5 style="margin-top: 15px; margin-bottom: 10px; font-size: 13px;">Catatan Tambahan</h5>
            <p>
                <textarea name="pk_biaya_catatan" rows="3" style="width:100%;" placeholder="Catatan: UKT belum termasuk biaya visa..."><?php echo esc_textarea($biaya_catatan); ?></textarea>
            </p>
        </div>

        <h4><?php _e('Timeline', 'webjti'); ?></h4>
        <div id="pk_timeline_container">
            <?php if (!empty($timeline_rows)) : ?>
                <?php foreach ($timeline_rows as $i => $row) :
                    $date = isset($row['date']) ? $row['date'] : '';
                    $desc = isset($row['desc']) ? $row['desc'] : '';
                ?>
                <div class="webjti-repeatable" data-index="<?php echo $i; ?>">
                    <p class="webjti-row"><label><strong><?php _e('Tanggal / Periode', 'webjti'); ?></strong></label>
                    <input type="text" name="pk_timeline_date[]" value="<?php echo esc_attr($date); ?>" placeholder="Contoh: 15 Agt - 30 Sep 2026" style="width:100%;" /></p>
                    <p class="webjti-row"><label><strong><?php _e('Deskripsi / Judul Kegiatan', 'webjti'); ?></strong></label>
                    <input type="text" name="pk_timeline_desc[]" value="<?php echo esc_attr($desc); ?>" style="width:100%;" /></p>
                    <p class="webjti-actions"><button type="button" class="button webjti-remove"><?php _e('Hapus', 'webjti'); ?></button></p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <p><button type="button" class="button" id="pk_add_timeline"><?php _e('Tambah Tanggal Timeline', 'webjti'); ?></button></p>

        <h4><?php _e('Kontak Hubung', 'webjti'); ?></h4>
        <p>
            <input type="text" id="pk_kontak" name="pk_kontak" value="<?php echo esc_attr($kontak); ?>" style="width:100%;" />
            <small class="description"><?php _e('Contoh: email, nomor telepon, atau link pendaftaran.', 'webjti'); ?></small>
        </p>

        <script>
        (function(){
            var formatRadios = document.querySelectorAll('input[name="pk_format_biaya"]');
            var tabelWrapper = document.getElementById('pk_biaya_tabel_wrapper');
            var listWrapper = document.getElementById('pk_biaya_list_wrapper');
            var mitraContainer = document.getElementById('pk_biaya_mitra_container');
            var addMitraBtn = document.getElementById('pk_add_biaya_mitra');

            if (formatRadios.length) {
                formatRadios.forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        if (this.value === 'tabel') {
                            tabelWrapper.style.display = 'block';
                            listWrapper.style.display = 'none';
                        } else {
                            tabelWrapper.style.display = 'none';
                            listWrapper.style.display = 'block';
                        }
                    });
                });
            }

            var biayaContainer = document.getElementById('pk_biaya_container');
            var addBiayaBtn = document.getElementById('pk_add_biaya');
            var timelineContainer = document.getElementById('pk_timeline_container');
            var addTimelineBtn = document.getElementById('pk_add_timeline');

            function makeMitraRow(label, nominal, currency) {
                var wrapper = document.createElement('div');
                wrapper.className = 'webjti-repeatable';
                wrapper.style.cssText = 'background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:12px; margin-bottom:12px; display: flex; gap: 10px; align-items: flex-end;';
                wrapper.innerHTML = '<div style="flex: 2;"><label><strong>Label/Deskripsi</strong></label><input type="text" name="pk_biaya_mitra_label[]" value="'+(label||'')+'" placeholder="Akomodasi / Asrama" style="width:100%;" /></div>'+
                    '<div style="flex: 1;"><label><strong>Nominal</strong></label><input type="text" name="pk_biaya_mitra_nominal[]" value="'+(nominal||'')+'" placeholder="7.200" style="width:100%;" /></div>'+
                    '<div style="flex: 1;"><label><strong>Mata Uang</strong></label><input type="text" name="pk_biaya_mitra_currency[]" value="'+(currency||'CNY')+'" placeholder="CNY" style="width:100%;" /></div>'+
                    '<div><button type="button" class="button webjti-remove">Hapus</button></div>';
                attachRemove(wrapper);
                return wrapper;
            }

            function makeBiayaBlock(kelompok, bidang, ipi_utama, ipi_psdku, ipi_luar, ukt){
                var wrapper = document.createElement('div');
                wrapper.className = 'webjti-repeatable';
                wrapper.style.cssText = 'background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:12px; margin-bottom:12px;';
                wrapper.innerHTML = '<p class="webjti-row"><label><strong>Kelompok Program (Contoh: Transfer ke Sarjana Terapan)</strong></label>'+
                    '<input type="text" name="pk_biaya_kelompok[]" value="'+(kelompok||'')+'" placeholder="Transfer ke Sarjana Terapan" style="width:100%;" /></p>'+
                    '<p class="webjti-row"><label><strong>Program Studi Lanjutan / Bidang (Contoh: Rekayasa / Sarjana Terapan TI)</strong></label>'+
                    '<input type="text" name="pk_biaya_bidang[]" value="'+(bidang||'')+'" placeholder="Rekayasa" style="width:100%;" /></p>'+
                    '<div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap:10px; margin-top:8px;">'+
                    '<p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (Utama)</strong></label><input type="text" name="pk_biaya_ipi_utama[]" value="'+(ipi_utama||'')+'" placeholder="Rp2.500.000" style="width:100%;" /></p>'+
                    '<p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (PSDKU)</strong></label><input type="text" name="pk_biaya_ipi_psdku[]" value="'+(ipi_psdku||'')+'" placeholder="Rp10.000.000" style="width:100%;" /></p>'+
                    '<p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">IPI (Luar Polinema)</strong></label><input type="text" name="pk_biaya_ipi_luar[]" value="'+(ipi_luar||'')+'" placeholder="Rp12.500.000" style="width:100%;" /></p>'+
                    '<p class="webjti-row" style="margin:0;"><label><strong style="font-size:12px;">UKT / Semester</strong></label><input type="text" name="pk_biaya_ukt[]" value="'+(ukt||'')+'" placeholder="Rp6.500.000" style="width:100%;" /></p>'+
                    '</div>'+
                    '<p class="webjti-actions" style="margin-top:10px;"><button type="button" class="button webjti-remove">Hapus Rincian Ini</button></p>';
                attachRemove(wrapper);
                return wrapper;
            }

            function makeTimelineRow(date, desc){
                var wrapper = document.createElement('div');
                wrapper.className = 'webjti-repeatable';
                wrapper.innerHTML = '<p class="webjti-row"><label><strong>Tanggal / Periode</strong></label>'+
                    '<input type="text" name="pk_timeline_date[]" value="'+(date||'')+'" placeholder="Contoh: 15 Agt - 30 Sep 2026" style="width:100%;" /></p>'+
                    '<p class="webjti-row"><label><strong>Deskripsi / Judul Kegiatan</strong></label>'+
                    '<input type="text" name="pk_timeline_desc[]" value="'+(desc||'')+'" style="width:100%;" /></p>'+
                    '<p class="webjti-actions"><button type="button" class="button webjti-remove">Hapus</button></p>';
                attachRemove(wrapper);
                return wrapper;
            }

            function attachRemove(node){
                var btn = node.querySelector('.webjti-remove');
                if(btn){
                    btn.addEventListener('click', function(){ node.parentNode.removeChild(node); });
                }
            }

            if(addBiayaBtn){
                addBiayaBtn.addEventListener('click', function(){
                    biayaContainer.appendChild(makeBiayaBlock());
                });
            }
            if (addMitraBtn) {
                addMitraBtn.addEventListener('click', function(){
                    mitraContainer.appendChild(makeMitraRow());
                });
            }
            if(addTimelineBtn){
                addTimelineBtn.addEventListener('click', function(){
                    timelineContainer.appendChild(makeTimelineRow());
                });
            }

            // attach existing remove buttons
            document.querySelectorAll('.webjti-remove').forEach(function(b){
                b.addEventListener('click', function(){ b.closest('.webjti-repeatable').remove(); });
            });

            // Client-side validation before publish/update
            var postForm = document.querySelector('form#post');
            if(postForm){
                postForm.addEventListener('submit', function(e){
                    var select = document.getElementById('pk_tipe_program');
                    if(select && !select.value){
                        e.preventDefault();
                        alert('VALIDASI GAGAL: Harap pilih Tipe Program Khusus (RPL, Alih Jenjang, Double Degree, atau Kelas Internasional) sebelum menyimpan!');
                        select.style.borderColor = '#e11d48';
                        select.style.boxShadow = '0 0 0 3px rgba(225,29,72,0.25)';
                        select.focus();
                        var publishBtn = document.getElementById('publish');
                        if(publishBtn){
                            publishBtn.classList.remove('disabled');
                        }
                        return false;
                    }
                });
            }
        })();
        </script>
        <?php
    }

    // Save meta for Program Khusus
    add_action('save_post', function($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset($_POST['webjti_pk_nonce']) || !wp_verify_nonce($_POST['webjti_pk_nonce'], 'webjti_save_pk_meta')) return;
        if (!isset($_POST['post_type']) || 'program_khusus' !== $_POST['post_type']) return;

        // Save & Validate Tipe Program Khusus
        $tipe_program = isset($_POST['pk_tipe_program']) ? sanitize_text_field($_POST['pk_tipe_program']) : '';
        if ($tipe_program) {
            update_post_meta($post_id, '_pk_tipe_program', $tipe_program);
            wp_set_object_terms($post_id, $tipe_program, 'tipe_program_khusus', false);
        }

        // Persyaratan
        if (array_key_exists('pk_persyaratan', $_POST)) {
            update_post_meta($post_id, '_pk_persyaratan', sanitize_textarea_field($_POST['pk_persyaratan']));
        }

        // Kontak
        if (array_key_exists('pk_kontak', $_POST)) {
            update_post_meta($post_id, '_pk_kontak', sanitize_text_field($_POST['pk_kontak']));
        }

        $format_biaya = isset($_POST['pk_format_biaya']) ? sanitize_text_field($_POST['pk_format_biaya']) : 'tabel';
        update_post_meta($post_id, '_pk_format_biaya', $format_biaya);

        if (array_key_exists('pk_biaya_pendaftaran', $_POST)) update_post_meta($post_id, '_pk_biaya_pendaftaran', sanitize_text_field($_POST['pk_biaya_pendaftaran']));
        if (array_key_exists('pk_biaya_ipi', $_POST)) update_post_meta($post_id, '_pk_biaya_ipi', sanitize_text_field($_POST['pk_biaya_ipi']));
        if (array_key_exists('pk_biaya_ukt_list', $_POST)) update_post_meta($post_id, '_pk_biaya_ukt_list', sanitize_text_field($_POST['pk_biaya_ukt_list']));
        if (array_key_exists('pk_biaya_catatan', $_POST)) update_post_meta($post_id, '_pk_biaya_catatan', wp_kses_post($_POST['pk_biaya_catatan']));

        // Biaya Mitra List
        $mitra_list = [];
        if (!empty($_POST['pk_biaya_mitra_label']) && is_array($_POST['pk_biaya_mitra_label'])) {
            $labels = $_POST['pk_biaya_mitra_label'];
            $nominals = isset($_POST['pk_biaya_mitra_nominal']) && is_array($_POST['pk_biaya_mitra_nominal']) ? $_POST['pk_biaya_mitra_nominal'] : [];
            $currencies = isset($_POST['pk_biaya_mitra_currency']) && is_array($_POST['pk_biaya_mitra_currency']) ? $_POST['pk_biaya_mitra_currency'] : [];

            foreach ($labels as $i => $l) {
                $lbl = sanitize_text_field($l);
                $nom = isset($nominals[$i]) ? sanitize_text_field($nominals[$i]) : '';
                $cur = isset($currencies[$i]) ? sanitize_text_field($currencies[$i]) : 'CNY';
                if ($lbl || $nom) {
                    $mitra_list[] = ['label' => $lbl, 'nominal' => $nom, 'currency' => $cur];
                }
            }
        }
        update_post_meta($post_id, '_pk_biaya_mitra_list', wp_json_encode($mitra_list));

        // Biaya blocks (kelompok, bidang, ipi_utama, ipi_psdku, ipi_luar, ukt) - save as JSON
        $biaya_blocks = [];
        if (!empty($_POST['pk_biaya_bidang']) && is_array($_POST['pk_biaya_bidang'])) {
            $bidangs    = $_POST['pk_biaya_bidang'];
            $kelompoks  = isset($_POST['pk_biaya_kelompok']) && is_array($_POST['pk_biaya_kelompok']) ? $_POST['pk_biaya_kelompok'] : [];
            $ipi_utamas = isset($_POST['pk_biaya_ipi_utama']) && is_array($_POST['pk_biaya_ipi_utama']) ? $_POST['pk_biaya_ipi_utama'] : [];
            $ipi_psdkus = isset($_POST['pk_biaya_ipi_psdku']) && is_array($_POST['pk_biaya_ipi_psdku']) ? $_POST['pk_biaya_ipi_psdku'] : [];
            $ipi_luars  = isset($_POST['pk_biaya_ipi_luar']) && is_array($_POST['pk_biaya_ipi_luar']) ? $_POST['pk_biaya_ipi_luar'] : [];
            $ukts       = isset($_POST['pk_biaya_ukt']) && is_array($_POST['pk_biaya_ukt']) ? $_POST['pk_biaya_ukt'] : [];

            foreach ($bidangs as $i => $bd) {
                $bidang    = sanitize_text_field($bd);
                $kelompok  = isset($kelompoks[$i]) ? sanitize_text_field($kelompoks[$i]) : '';
                $ipi_utama = isset($ipi_utamas[$i]) ? sanitize_text_field($ipi_utamas[$i]) : '';
                $ipi_psdku = isset($ipi_psdkus[$i]) ? sanitize_text_field($ipi_psdkus[$i]) : '';
                $ipi_luar  = isset($ipi_luars[$i]) ? sanitize_text_field($ipi_luars[$i]) : '';
                $ukt       = isset($ukts[$i]) ? sanitize_text_field($ukts[$i]) : '';

                if ($bidang || $kelompok || $ipi_utama || $ipi_psdku || $ipi_luar || $ukt) {
                    $biaya_blocks[] = [
                        'kelompok'  => $kelompok,
                        'bidang'    => $bidang,
                        'ipi_utama' => $ipi_utama,
                        'ipi_psdku' => $ipi_psdku,
                        'ipi_luar'  => $ipi_luar,
                        'ukt'       => $ukt,
                    ];
                }
            }
        } elseif (!empty($_POST['pk_biaya_title']) && is_array($_POST['pk_biaya_title'])) {
            // Legacy fallback
            $titles = $_POST['pk_biaya_title'];
            $contents = isset($_POST['pk_biaya_content']) && is_array($_POST['pk_biaya_content']) ? $_POST['pk_biaya_content'] : [];
            foreach ($titles as $i => $t) {
                $title = sanitize_text_field($t);
                $content = isset($contents[$i]) ? wp_kses_post($contents[$i]) : '';
                if ($title || $content) {
                    $biaya_blocks[] = ['title' => $title, 'content' => $content];
                }
            }
        }
        update_post_meta($post_id, '_pk_biaya_blocks', wp_json_encode($biaya_blocks));

        // Timeline rows (date + desc) - save as JSON
        $timeline = [];
        if (!empty($_POST['pk_timeline_date']) && is_array($_POST['pk_timeline_date'])) {
            $dates = $_POST['pk_timeline_date'];
            $descs = isset($_POST['pk_timeline_desc']) && is_array($_POST['pk_timeline_desc']) ? $_POST['pk_timeline_desc'] : [];
            foreach ($dates as $i => $d) {
                $date = sanitize_text_field($d);
                $desc = isset($descs[$i]) ? sanitize_text_field($descs[$i]) : '';
                if ($date || $desc) {
                    $timeline[] = ['date' => $date, 'desc' => $desc];
                }
            }
        }
        update_post_meta($post_id, '_pk_timeline_rows', wp_json_encode($timeline));
    });

    // Add admin columns for Program Khusus list
    add_filter('manage_program_khusus_posts_columns', function($columns) {
        $new = [];
        foreach ($columns as $key => $label) {
            $new[$key] = $label;
            if ('title' === $key) {
                $new['pk_tipe_col'] = __('Tipe Program', 'webjti');
                $new['pk_biaya_col'] = __('Biaya', 'webjti');
                $new['pk_timeline_col'] = __('Timeline', 'webjti');
                $new['pk_kontak_col'] = __('Kontak', 'webjti');
            }
        }
        return $new;
    });

    add_action('manage_program_khusus_posts_custom_column', function($column, $post_id) {
        if ('pk_tipe_col' === $column) {
            $tipe = get_post_meta($post_id, '_pk_tipe_program', true);
            $labels = [
                'rpl'                 => 'RPL',
                'alih_jenjang'        => 'Alih Jenjang',
                'double_degree'       => 'Double Degree',
                'kelas_internasional' => 'Kelas Internasional',
            ];
            if ($tipe && isset($labels[$tipe])) {
                echo '<span style="background:#e0f2fe; color:#0369a1; padding:3px 8px; border-radius:4px; font-weight:600; font-size:12px;">' . esc_html($labels[$tipe]) . '</span>';
            } else {
                echo '<span style="color:#94a3b8; font-style:italic;">Belum dipilih</span>';
            }
        } elseif ('pk_biaya_col' === $column) {
            $biaya_json = get_post_meta($post_id, '_pk_biaya_blocks', true);
            $biaya_blocks = $biaya_json ? json_decode($biaya_json, true) : [];
            echo esc_html(count($biaya_blocks) . ' Item');
        } elseif ('pk_timeline_col' === $column) {
            $timeline_json = get_post_meta($post_id, '_pk_timeline_rows', true);
            $timeline = $timeline_json ? json_decode($timeline_json, true) : [];
            echo esc_html(count($timeline) . ' Agenda');
        } elseif ('pk_kontak_col' === $column) {
            echo esc_html(get_post_meta($post_id, '_pk_kontak', true));
        }
    }, 10, 2);

    // Dropdown filter by Tipe Program in WP Admin list
    add_action('restrict_manage_posts', function($post_type) {
        if ('program_khusus' !== $post_type) return;
        $selected = isset($_GET['tipe_program_filter']) ? sanitize_text_field($_GET['tipe_program_filter']) : '';
        ?>
        <select name="tipe_program_filter">
            <option value=""><?php _e('Semua Tipe Program', 'webjti'); ?></option>
            <option value="rpl" <?php selected($selected, 'rpl'); ?>>RPL</option>
            <option value="alih_jenjang" <?php selected($selected, 'alih_jenjang'); ?>>Alih Jenjang</option>
            <option value="double_degree" <?php selected($selected, 'double_degree'); ?>>Double Degree</option>
            <option value="kelas_internasional" <?php selected($selected, 'kelas_internasional'); ?>>Kelas Internasional</option>
        </select>
        <?php
    });

    add_action('pre_get_posts', function($query) {
        if (!is_admin() || !$query->is_main_query()) return;
        if ('program_khusus' === $query->get('post_type') && !empty($_GET['tipe_program_filter'])) {
            $query->set('meta_key', '_pk_tipe_program');
            $query->set('meta_value', sanitize_text_field($_GET['tipe_program_filter']));
        }
    });

    // Temp flush to register the new CPT rewrite slugs
    flush_rewrite_rules(false);
}

add_action('init', 'webjti_register_theme_post_types');

/**
 * Override taxonomy labels and unregister legacy laboratory taxonomy from lecturer CPT
 */
add_action('init', function() {
    global $wp_taxonomies;

    // 1. Unregister laboratory taxonomy from lecturer CPT
    unregister_taxonomy_for_object_type('laboratory', 'lecturer');
    unregister_taxonomy_for_object_type('laboratories', 'lecturer');
    unregister_taxonomy_for_object_type('laboratorium', 'lecturer');

    // 2. Translate 'expertise' taxonomy labels to 'Bidang Keahlian'
    if (isset($wp_taxonomies['expertise'])) {
        $wp_taxonomies['expertise']->label = __('Bidang Keahlian', 'webjti');
        if (isset($wp_taxonomies['expertise']->labels)) {
            $wp_taxonomies['expertise']->labels->name = __('Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->singular_name = __('Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->menu_name = __('Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->all_items = __('Semua Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->edit_item = __('Edit Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->update_item = __('Update Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->add_new_item = __('Tambah Bidang Keahlian', 'webjti');
            $wp_taxonomies['expertise']->labels->search_items = __('Cari Bidang Keahlian', 'webjti');
        }
    }

    // 3. Translate 'campus_location' taxonomy labels to 'Lokasi Kampus'
    if (isset($wp_taxonomies['campus_location'])) {
        $wp_taxonomies['campus_location']->label = __('Lokasi Kampus', 'webjti');
        if (isset($wp_taxonomies['campus_location']->labels)) {
            $wp_taxonomies['campus_location']->labels->name = __('Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->singular_name = __('Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->menu_name = __('Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->all_items = __('Semua Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->edit_item = __('Edit Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->update_item = __('Update Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->add_new_item = __('Tambah Lokasi Kampus', 'webjti');
            $wp_taxonomies['campus_location']->labels->search_items = __('Cari Lokasi Kampus', 'webjti');
        }
    }
}, 99);

/**
 * Hide Slug and Description fields on Bidang Keahlian (expertise taxonomy) admin screens,
 * and ensure automatic generation of slug from term name.
 */
add_action('admin_head', function() {
    $screen = get_current_screen();
    if ($screen && isset($screen->taxonomy) && in_array($screen->taxonomy, ['expertise', 'campus_location', 'staff_department'], true)) {
        echo '<style>
            .form-field.term-slug-wrap,
            .form-field.term-description-wrap,
            tr.form-field.term-slug-wrap,
            tr.form-field.term-description-wrap,
            .column-description {
                display: none !important;
            }
        </style>';
    }
});

add_filter('manage_edit-expertise_columns', function($columns) {
    if (isset($columns['description'])) {
        unset($columns['description']);
    }
    return $columns;
});

add_filter('manage_edit-campus_location_columns', function($columns) {
    if (isset($columns['description'])) {
        unset($columns['description']);
    }
    return $columns;
});

add_filter('manage_edit-staff_department_columns', function($columns) {
    if (isset($columns['description'])) {
        unset($columns['description']);
    }
    return $columns;
});

add_filter('wp_insert_term_data', function($data, $taxonomy) {
    if (in_array($taxonomy, ['expertise', 'campus_location', 'staff_department'], true)) {
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = sanitize_title($data['name']);
        }
    }
    return $data;
}, 10, 2);

/**
 * Dynamic CPT Label & Submenu Translator for all 10 CPTs shown in admin sidebar
 */
function webjti_translate_external_cpt_labels($args, $post_type) {
    $translations = [
        'history_timeline' => [
            'name'          => 'Linimasa Sejarah',
            'singular_name' => 'Linimasa Sejarah',
            'menu_name'     => 'Linimasa Sejarah',
            'item'          => 'Linimasa Sejarah',
        ],
        'history_timelines' => [
            'name'          => 'Linimasa Sejarah',
            'singular_name' => 'Linimasa Sejarah',
            'menu_name'     => 'Linimasa Sejarah',
            'item'          => 'Linimasa Sejarah',
        ],
        'achievement' => [
            'name'          => 'Prestasi',
            'singular_name' => 'Prestasi',
            'menu_name'     => 'Prestasi',
            'item'          => 'Prestasi',
        ],
        'achievement_member' => [
            'name'          => 'Anggota Prestasi',
            'singular_name' => 'Anggota Prestasi',
            'menu_name'     => 'Anggota Prestasi',
            'item'          => 'Anggota Prestasi',
        ],
        'lecturer_certification' => [
            'name'          => 'Sertifikasi Dosen',
            'singular_name' => 'Sertifikasi Dosen',
            'menu_name'     => 'Sertifikasi Dosen',
            'item'          => 'Sertifikasi Dosen',
        ],
        'lecturer_course' => [
            'name'          => 'Mata Kuliah Dosen',
            'singular_name' => 'Mata Kuliah Dosen',
            'menu_name'     => 'Mata Kuliah Dosen',
            'item'          => 'Mata Kuliah Dosen',
        ],
        'lecturer_publication' => [
            'name'          => 'Publikasi Dosen',
            'singular_name' => 'Publikasi Dosen',
            'menu_name'     => 'Publikasi Dosen',
            'item'          => 'Publikasi Dosen',
        ],
        'lecturer_education' => [
            'name'          => 'Pendidikan Dosen',
            'singular_name' => 'Pendidikan Dosen',
            'menu_name'     => 'Pendidikan Dosen',
            'item'          => 'Pendidikan Dosen',
        ],
        'lecturer_educations' => [
            'name'          => 'Pendidikan Dosen',
            'singular_name' => 'Pendidikan Dosen',
            'menu_name'     => 'Pendidikan Dosen',
            'item'          => 'Pendidikan Dosen',
        ],
        'organization_structure' => [
            'name'          => 'Struktur Organisasi',
            'singular_name' => 'Struktur Organisasi',
            'menu_name'     => 'Struktur Organisasi',
            'item'          => 'Struktur Organisasi',
        ],
        'organization_position' => [
            'name'          => 'Jabatan Organisasi',
            'singular_name' => 'Jabatan Organisasi',
            'menu_name'     => 'Jabatan Organisasi',
            'item'          => 'Jabatan Organisasi',
        ],
        'information' => [
            'name'          => 'Informasi',
            'singular_name' => 'Informasi',
            'menu_name'     => 'Informasi',
            'item'          => 'Informasi',
        ],
        'staff' => [
            'name'          => 'Tenaga Kependidikan',
            'singular_name' => 'Tenaga Kependidikan',
            'menu_name'     => 'Tenaga Kependidikan',
            'item'          => 'Tenaga Kependidikan',
        ],
    ];

    if (isset($translations[$post_type])) {
        $t = $translations[$post_type];
        $item = $t['item'];

        $labels = [
            'name'               => $t['name'],
            'singular_name'      => $t['singular_name'],
            'menu_name'          => $t['menu_name'],
            'name_admin_bar'     => $t['name'],
            'add_new'            => 'Tambah Baru',
            'add_new_item'       => 'Tambah ' . $item . ' Baru',
            'new_item'           => $item . ' Baru',
            'edit_item'          => 'Edit ' . $item,
            'view_item'          => 'Lihat ' . $item,
            'all_items'          => 'Semua ' . $t['name'],
            'search_items'       => 'Cari ' . $item,
            'not_found'          => 'Tidak ada ' . strtolower($item) . ' ditemukan.',
            'not_found_in_trash' => 'Tidak ada ' . strtolower($item) . ' di Sampah.',
        ];

        if (isset($args['labels']) && is_array($args['labels'])) {
            $args['labels'] = array_merge($args['labels'], $labels);
        } else {
            $args['labels'] = $labels;
        }

        if ($post_type === 'achievement_member') {
            $args['show_in_menu'] = 'edit.php?post_type=achievement';
        } elseif (in_array($post_type, ['lecturer_education', 'lecturer_educations', 'lecturer_certification', 'lecturer_certificati', 'sertifikasi_dosen', 'lecturer_publication', 'lecturer_course'], true)) {
            $args['show_in_menu'] = 'edit.php?post_type=lecturer';
        }
    }

    return $args;
}
add_filter('register_post_type_args', 'webjti_translate_external_cpt_labels', 99, 2);

/**
 * Force override global $wp_post_types object labels on init priority 999
 */
add_action('init', function() {
    global $wp_post_types, $wp_taxonomies;

    // Translate staff_department taxonomy labels to Departemen Staff
    if (isset($wp_taxonomies['staff_department'])) {
        $wp_taxonomies['staff_department']->label = __('Departemen Staff', 'webjti');
        if (isset($wp_taxonomies['staff_department']->labels)) {
            $wp_taxonomies['staff_department']->labels->name = __('Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->singular_name = __('Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->menu_name = __('Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->all_items = __('Semua Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->edit_item = __('Edit Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->update_item = __('Update Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->add_new_item = __('Tambah Departemen Staff', 'webjti');
            $wp_taxonomies['staff_department']->labels->search_items = __('Cari Departemen Staff', 'webjti');
        }
    }

    $targets = [
        'history_timeline'       => 'Linimasa Sejarah',
        'history_timelines'      => 'Linimasa Sejarah',
        'achievement'            => 'Prestasi',
        'achievement_member'     => 'Anggota Prestasi',
        'lecturer_certification' => 'Sertifikasi Dosen',
        'lecturer_certificati'   => 'Sertifikasi Dosen',
        'sertifikasi_dosen'      => 'Sertifikasi Dosen',
        'lecturer_course'        => 'Mata Kuliah Dosen',
        'lecturer_publication'   => 'Publikasi Dosen',
        'lecturer_education'     => 'Pendidikan Dosen',
        'lecturer_educations'    => 'Pendidikan Dosen',
        'organization_structure' => 'Struktur Organisasi',
        'organization_position'  => 'Jabatan Organisasi',
        'information'            => 'Informasi',
        'staff'                  => 'Tenaga Kependidikan',
    ];

    foreach ($targets as $cpt => $label_title) {
        if (isset($wp_post_types[$cpt])) {
            $obj = $wp_post_types[$cpt];
            $obj->label = $label_title;
            if ($cpt === 'achievement_member') {
                $obj->show_in_menu = 'edit.php?post_type=achievement';
            } elseif (in_array($cpt, ['lecturer_education', 'lecturer_educations', 'lecturer_certification', 'lecturer_certificati', 'sertifikasi_dosen', 'lecturer_publication', 'lecturer_course'], true)) {
                $obj->show_in_menu = 'edit.php?post_type=lecturer';
            }
            if (isset($obj->labels)) {
                $obj->labels->name               = $label_title;
                $obj->labels->singular_name      = $label_title;
                $obj->labels->menu_name          = $label_title;
                $obj->labels->name_admin_bar     = $label_title;
                $obj->labels->add_new            = 'Tambah Baru';
                $obj->labels->add_new_item       = 'Tambah ' . $label_title . ' Baru';
                $obj->labels->new_item           = $label_title . ' Baru';
                $obj->labels->edit_item          = 'Edit ' . $label_title;
                $obj->labels->view_item          = 'Lihat ' . $label_title;
                $obj->labels->all_items          = 'Semua ' . $label_title;
                $obj->labels->search_items       = 'Cari ' . $label_title;
                $obj->labels->not_found          = 'Tidak ada ' . strtolower($label_title) . ' ditemukan.';
                $obj->labels->not_found_in_trash = 'Tidak ada ' . strtolower($label_title) . ' di Sampah.';
            }
        }
    }
}, 999);

/**
 * Reconstruct CPT submenus cleanly under Prestasi and Tenaga Pengajar in WP Admin sidebar
 */
add_action('admin_menu', function() {
    global $submenu;

    // 1. Remove standalone top-level menus for sub-CPTs
    remove_menu_page('edit.php?post_type=achievement_member');
    remove_menu_page('edit.php?post_type=lecturer_education');
    remove_menu_page('edit.php?post_type=lecturer_educations');
    remove_menu_page('edit.php?post_type=lecturer_certification');
    remove_menu_page('edit.php?post_type=lecturer_certificati');
    remove_menu_page('edit.php?post_type=sertifikasi_dosen');
    remove_menu_page('edit.php?post_type=lecturer_publication');
    remove_menu_page('edit.php?post_type=lecturer_course');
    remove_menu_page('edit.php?post_type=mata_kuliah');
    remove_menu_page('edit.php?post_type=mk_spesialis');
    remove_menu_page('edit.php?post_type=bahan_kajian');
    remove_menu_page('edit.php?post_type=bidang_keahlian');
    remove_menu_page('edit.php?post_type=profil_lulusan');
    remove_menu_page('edit.php?post_type=capaian_lulusan');
    remove_menu_page('edit.php?post_type=peta_jalan_cpl');

    // 2. Clean reconstruction for Prestasi submenu
    if (isset($submenu['edit.php?post_type=achievement'])) {
        $submenu['edit.php?post_type=achievement'] = [
            0 => [
                'Semua Prestasi',
                'edit_posts',
                'edit.php?post_type=achievement',
                'Semua Prestasi'
            ],
            1 => [
                'Anggota Prestasi',
                'edit_posts',
                'edit.php?post_type=achievement_member',
                'Anggota Prestasi'
            ],
        ];
    }

    // 3. Clean reconstruction for Tenaga Pengajar submenu
    if (isset($submenu['edit.php?post_type=lecturer'])) {
        global $wp_post_types;

        $cert_slug = 'lecturer_certification';
        if (isset($wp_post_types['lecturer_certificati'])) {
            $cert_slug = 'lecturer_certificati';
        } elseif (isset($wp_post_types['sertifikasi_dosen'])) {
            $cert_slug = 'sertifikasi_dosen';
        }

        $edu_slug = 'lecturer_education';
        if (!isset($wp_post_types['lecturer_education']) && isset($wp_post_types['lecturer_educations'])) {
            $edu_slug = 'lecturer_educations';
        }

        $submenu['edit.php?post_type=lecturer'] = [
            0 => [
                'Semua Tenaga Pengajar',
                'edit_posts',
                'edit.php?post_type=lecturer',
                'Semua Tenaga Pengajar'
            ],
            1 => [
                'Pendidikan Dosen',
                'edit_posts',
                'edit.php?post_type=' . $edu_slug,
                'Pendidikan Dosen'
            ],
            2 => [
                'Sertifikasi Dosen',
                'edit_posts',
                'edit.php?post_type=' . $cert_slug,
                'Sertifikasi Dosen'
            ],
            3 => [
                'Publikasi Dosen',
                'edit_posts',
                'edit.php?post_type=lecturer_publication',
                'Publikasi Dosen'
            ],
            4 => [
                'Mata Kuliah Dosen',
                'edit_posts',
                'edit.php?post_type=lecturer_course',
                'Mata Kuliah Dosen'
            ],
            5 => [
                'Bidang Keahlian',
                'manage_categories',
                'edit-tags.php?taxonomy=expertise&post_type=lecturer',
                'Bidang Keahlian'
            ],
            6 => [
                'Lokasi Kampus',
                'manage_categories',
                'edit-tags.php?taxonomy=campus_location&post_type=lecturer',
                'Lokasi Kampus'
            ],
        ];
    }

    // 4. Clean reconstruction for Tenaga Kependidikan (Staff) submenu
    if (isset($submenu['edit.php?post_type=staff'])) {
        $submenu['edit.php?post_type=staff'] = [
            0 => [
                'Semua Tenaga Kependidikan',
                'edit_posts',
                'edit.php?post_type=staff',
                'Semua Tenaga Kependidikan'
            ],
            1 => [
                'Departemen Staff',
                'manage_categories',
                'edit-tags.php?taxonomy=staff_department&post_type=staff',
                'Departemen Staff'
            ],
        ];
    }

    // 5. Clean reconstruction for Program Studi submenu
    if (isset($submenu['edit.php?post_type=study_program'])) {
        $submenu['edit.php?post_type=study_program'] = [
            0 => [
                'Semua Program Studi',
                'edit_posts',
                'edit.php?post_type=study_program',
                'Semua Program Studi'
            ],
            1 => [
                'Tambah Program Studi',
                'edit_posts',
                'post-new.php?post_type=study_program',
                'Tambah Program Studi'
            ],
            2 => [
                'Profil Lulusan',
                'edit_posts',
                'edit.php?post_type=profil_lulusan',
                'Profil Lulusan'
            ],
            3 => [
                'Capaian Lulusan',
                'edit_posts',
                'edit.php?post_type=capaian_lulusan',
                'Capaian Lulusan'
            ],
            4 => [
                'Peta Jalan CPL',
                'edit_posts',
                'edit.php?post_type=peta_jalan_cpl',
                'Peta Jalan CPL'
            ],
            5 => [
                'Mata Kuliah',
                'edit_posts',
                'edit.php?post_type=mata_kuliah',
                'Mata Kuliah'
            ],
            6 => [
                'Mata Kuliah Spesialis',
                'edit_posts',
                'edit.php?post_type=mk_spesialis',
                'Mata Kuliah Spesialis'
            ],
            7 => [
                'Bahan Kajian',
                'edit_posts',
                'edit.php?post_type=bahan_kajian',
                'Bahan Kajian'
            ],
            8 => [
                'Bidang Keahlian',
                'edit_posts',
                'edit.php?post_type=bidang_keahlian',
                'Bidang Keahlian'
            ],
            9 => [
                'Kategori Prodi',
                'manage_categories',
                'edit-tags.php?taxonomy=kategori_program_studi&post_type=study_program',
                'Kategori Prodi'
            ],
            10 => [
                'Tabel Capaian',
                'manage_categories',
                'edit-tags.php?taxonomy=capaian_lulusan_tabel&post_type=study_program',
                'Tabel Capaian'
            ],
        ];
    }
}, 99999);

/**
 * Remove /program-khusus/ slug from program_khusus CPT URLs
 */
function webjti_remove_program_khusus_slug( $post_link, $post, $leavename ) {
    if ( 'program_khusus' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'webjti_remove_program_khusus_slug', 10, 3 );

function webjti_parse_request_program_khusus( $query ) {
    if ( ! $query->is_main_query() || is_admin() ) {
        return;
    }
    // When WP parses a root-level slug (like /rpl/), it usually sets the 'name' or 'pagename' query var.
    if ( isset( $query->query['name'] ) && !isset( $query->query['post_type'] ) ) {
        $query->set( 'post_type', array( 'post', 'page', 'program_khusus' ) );
    } elseif ( isset( $query->query['pagename'] ) && !isset( $query->query['post_type'] ) ) {
        $query->set( 'post_type', array( 'post', 'page', 'program_khusus' ) );
    }
}
add_action( 'pre_get_posts', 'webjti_parse_request_program_khusus' );
