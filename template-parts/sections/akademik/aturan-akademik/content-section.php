<?php
/**
 * Aturan Akademik - Content Section
 * Mengambil data secara dinamis dari Custom Post Type 'aturan_akademik'
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}



// Query CPT 'aturan_akademik' diurutkan berdasarkan menu_order (Page Attributes Order) lalu title
$query_args = [
    'post_type'      => 'aturan_akademik',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'ASC'],
];

$cpt_query = new WP_Query($query_args);
$sections  = [];

if ($cpt_query->have_posts()) {
    while ($cpt_query->have_posts()) {
        $cpt_query->the_post();
        $post_id = get_the_ID();

        // Baca icon dari post meta (di-cache otomatis saat post disimpan).
        // Jika meta kosong (post lama belum pernah di-save ulang),
        // generate langsung dari judul menggunakan fungsi auto-icon.
        $cached_icon = get_post_meta($post_id, 'aa_icon', true);
        if (!empty($cached_icon)) {
            $icon = $cached_icon;
        } elseif (function_exists('webjti_get_aturan_akademik_auto_icon')) {
            $icon = webjti_get_aturan_akademik_auto_icon($post_id);
        } else {
            $icon = 'book-open';
        }


        $image   = get_field('aa_image', $post_id);
        $caption = get_field('aa_caption', $post_id) ?: '';
        $content = get_field('aa_description', $post_id) ?: '';

        $sections[] = [
            'id'      => $post_id,
            'title'   => get_the_title(),
            'content' => $content,
            'icon'    => trim(str_replace(['ph-', 'ph '], '', $icon)),
            'image'   => $image,
            'caption' => $caption,
        ];
    }
    wp_reset_postdata();
}

// Fallback Default jika belum ada post di CPT 'aturan_akademik'
if (empty($sections)) {
    $default_defs = [
        [
            'title'   => 'PROSES PEMBELAJARAN',
            'icon'    => 'chalkboard-teacher',
            'content' => '<p>Proses pembelajaran di Jurusan Teknologi Informasi dilaksanakan secara terstruktur mengacu pada kurikulum yang telah ditetapkan. Mahasiswa wajib mengikuti seluruh kegiatan perkuliahan, praktikum, serta kegiatan akademik lainnya yang telah dijadwalkan.</p>',
        ],
        [
            'title'   => 'JADWAL PERKULIAHAN',
            'icon'    => 'calendar-blank',
            'content' => '<p>Jadwal perkuliahan ditetapkan oleh program studi pada setiap awal semester dan diumumkan melalui sistem informasi akademik. Mahasiswa wajib memperhatikan jadwal kuliah yang telah ditetapkan.</p>',
        ],
        [
            'title'   => 'KETIDAKHADIRAN',
            'icon'    => 'user-minus',
            'content' => '<p>Mahasiswa yang tidak hadir dalam perkuliahan wajib memberikan keterangan resmi. Batas maksimal ketidakhadiran adalah <strong>20%</strong> dari total pertemuan. Mahasiswa yang melampaui batas ketidakhadiran tidak diperkenankan mengikuti ujian akhir semester.</p>',
        ],
        [
            'title'   => 'EVALUASI HASIL BELAJAR',
            'icon'    => 'clipboard-text',
            'content' => '<p>Evaluasi hasil belajar mahasiswa dilakukan melalui:</p><ul><li>Ujian Tengah Semester (UTS)</li><li>Ujian Akhir Semester (UAS)</li><li>Tugas dan Kuis</li><li>Praktikum dan Laporan</li></ul>',
        ],
        [
            'title'   => 'SISTEM PENILAIAN',
            'icon'    => 'star',
            'content' => '<p>Sistem penilaian menggunakan skala huruf sebagai berikut:</p><ol><li><strong>A</strong> : 80 – 100 (Sangat Baik)</li><li><strong>B</strong> : 70 – 79 (Baik)</li><li><strong>C</strong> : 60 – 69 (Cukup)</li><li><strong>D</strong> : 50 – 59 (Kurang)</li><li><strong>E</strong> : 0 – 49 (Gagal)</li></ol>',
        ],
        [
            'title'   => 'YUDISIUM',
            'icon'    => 'graduation-cap',
            'content' => '<p>Yudisium adalah pernyataan resmi kelulusan mahasiswa dari program studi. Mahasiswa dapat mengikuti yudisium setelah memenuhi seluruh persyaratan akademik yang telah ditetapkan oleh program studi.</p>',
        ],
        [
            'title'   => 'EVALUASI AKHIR STUDI',
            'icon'    => 'exam',
            'content' => '<p>Evaluasi akhir studi dilakukan untuk menentukan kelanjutan studi mahasiswa. Mahasiswa yang tidak memenuhi batas minimal SKS atau IPK dalam waktu yang ditentukan akan mendapatkan evaluasi dari program studi.</p>',
        ],
        [
            'title'   => 'STATUS AKADEMIK',
            'icon'    => 'identification-card',
            'content' => '<p>Status akademik mahasiswa terdiri dari:</p><ul><li><strong>Aktif</strong>: Mahasiswa yang terdaftar dan mengikuti perkuliahan</li><li><strong>Cuti</strong>: Mahasiswa yang tidak mengikuti perkuliahan sementara dengan izin resmi</li><li><strong>Non-aktif</strong>: Mahasiswa yang tidak melakukan registrasi tanpa keterangan</li></ul>',
        ],
        [
            'title'   => 'PREDIKAT KELULUSAN',
            'icon'    => 'trophy',
            'content' => '<p>Predikat kelulusan diberikan berdasarkan Indeks Prestasi Kumulatif (IPK) sebagai berikut:</p><ol><li><strong>Dengan Pujian (Cumlaude)</strong>: IPK ≥ 3.51</li><li><strong>Sangat Memuaskan</strong>: IPK 3.01 – 3.50</li><li><strong>Memuaskan</strong>: IPK 2.76 – 3.00</li></ol>',
        ],
    ];

    foreach ($default_defs as $def) {
        $icon = function_exists('webjti_get_aturan_akademik_auto_icon')
            ? webjti_get_aturan_akademik_auto_icon($def['title'], $def['content'])
            : $def['icon'];

        $sections[] = [
            'id'      => 0,
            'title'   => $def['title'],
            'content' => $def['content'],
            'icon'    => trim(str_replace(['ph-', 'ph '], '', $icon)),
            'image'   => null,
            'caption' => '',
        ];
    }
}
?>

<?php
ob_start();
?>

<section class="aturan-akademik-section">

    <!-- Accordion List -->
    <div class="aturan-akademik__accordion" id="aturanAkademikAccordion">

        <?php foreach ($sections as $index => $section) :
            $item_id = 'aa-item-' . $index;
            $is_open = ($index === 0);

            // Resolve image
            $img_url = '';
            $img_alt = esc_attr($section['title']);
            if (!empty($section['image'])) {
                if (is_array($section['image'])) {
                    $img_url = $section['image']['url'] ?? '';
                    $img_alt = !empty($section['image']['alt']) ? esc_attr($section['image']['alt']) : $img_alt;
                } elseif (is_numeric($section['image'])) {
                    $src = wp_get_attachment_image_src($section['image'], 'large');
                    $img_url = $src ? $src[0] : '';
                }
            }
        ?>

        <div class="aa-accordion-item <?php echo $is_open ? 'aa-accordion-item--open' : ''; ?>" id="<?php echo esc_attr($item_id); ?>">

            <button
                class="aa-accordion-trigger"
                aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
                aria-controls="<?php echo esc_attr($item_id . '-body'); ?>"
                data-target="<?php echo esc_attr($item_id . '-body'); ?>"
            >
                <span class="aa-accordion-trigger__left">
                    <span class="aa-accordion-trigger__icon-wrap">
                        <i class="ph ph-<?php echo esc_attr($section['icon']); ?>"></i>
                    </span>
                    <span class="aa-accordion-trigger__number">
                        <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                    </span>
                    <span class="aa-accordion-trigger__title">
                        <?php echo esc_html($section['title']); ?>
                    </span>
                </span>
                <span class="aa-accordion-trigger__chevron">
                    <i class="ph ph-caret-down"></i>
                </span>
            </button>

            <div
                class="aa-accordion-body"
                id="<?php echo esc_attr($item_id . '-body'); ?>"
                role="region"
            >
                <div class="aa-accordion-body__inner">

                    <?php if (!empty($section['content'])) : ?>
                        <div class="aa-accordion-body__content">
                            <?php echo $section['content']; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($img_url)) : ?>
                        <figure class="aa-accordion-body__figure">
                            <a href="<?php echo esc_url($img_url); ?>" target="_blank">
                                <img
                                    src="<?php echo esc_url($img_url); ?>"
                                    alt="<?php echo $img_alt; ?>"
                                    class="aa-accordion-body__image"
                                    loading="lazy"
                                />
                            </a>
                            <?php if (!empty($section['caption'])) : ?>
                                <figcaption class="aa-accordion-body__caption">
                                    <i class="ph ph-image"></i>
                                    <?php echo esc_html($section['caption']); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                </div>
            </div>

        </div><!-- .aa-accordion-item -->

        <?php endforeach; ?>

    </div><!-- .aturan-akademik__accordion -->

</section>

<?php
$aa_block_content = ob_get_clean();

get_template_part(
    'template-parts/components/content-block',
    null,
    [
        'title'              => 'Peraturan Akademik',
        'icon'               => 'ph-book-open',
        'content'            => $aa_block_content,
        'section_slug'       => 'peraturan-akademik',
        'allow_custom_title' => true,
        'allow_custom_icon'  => true,
        'class'              => 'aturan-akademik-block',
    ]
);

