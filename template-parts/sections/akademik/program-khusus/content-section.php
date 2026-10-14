<?php
/**
 * Program Khusus Content Section
 *
 * Shared section used by virtual Program Khusus pages and CPT program_khusus.
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// If we are on a single program_khusus CPT, use that ID. 
// Otherwise, try to infer from the page URL if it's still being used as a fallback.
$cpt_id = 0;
if (is_singular('program_khusus')) {
    $cpt_id = get_the_ID();
} else {
    // Determine context program type for legacy Page fallback
    $context_type = 'rpl';
    if (is_page_template('templates/pages/akademik/alih-jenjang-page.php') || strpos($_SERVER['REQUEST_URI'] ?? '', 'alih-jenjang') !== false) {
        $context_type = 'alih_jenjang';
    } elseif (is_page_template('templates/pages/akademik/double-degree-page.php') || strpos($_SERVER['REQUEST_URI'] ?? '', 'double-degree') !== false) {
        $context_type = 'double_degree';
    } elseif (is_page_template('templates/pages/akademik/kelas-internasional-page.php') || strpos($_SERVER['REQUEST_URI'] ?? '', 'kelas-internasional') !== false) {
        $context_type = 'kelas_internasional';
    } elseif (is_page_template('templates/pages/akademik/rpl-page.php') || strpos($_SERVER['REQUEST_URI'] ?? '', 'rpl') !== false) {
        $context_type = 'rpl';
    }

    $cpt_query = new WP_Query([
        'post_type'      => 'program_khusus',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'   => '_pk_tipe_program',
                'value' => $context_type,
            ],
        ],
    ]);

    if (!$cpt_query->have_posts()) {
        $cpt_query = new WP_Query([
            'post_type'      => 'program_khusus',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'tax_query'      => [
                [
                    'taxonomy' => 'tipe_program_khusus',
                    'field'    => 'slug',
                    'terms'    => $context_type,
                ],
            ],
        ]);
    }

    if ($cpt_query->have_posts()) {
        $cpt_id = $cpt_query->posts[0]->ID;
    }
}

// Fetch data from CPT first, fallback to ACF options
if ($cpt_id) {
    $cpt_post = get_post($cpt_id);
    
    $deskripsi = $cpt_post->post_content ?: webjti_field('rpl_deskripsi', $cpt_id) ?: webjti_field('rpl_deskripsi');
    $persyaratan = get_post_meta($cpt_id, '_pk_persyaratan', true) ?: webjti_field('rpl_persyaratan', $cpt_id) ?: webjti_field('rpl_persyaratan');
    $kontak = get_post_meta($cpt_id, '_pk_kontak', true) ?: webjti_field('rpl_kontak', $cpt_id) ?: webjti_field('rpl_kontak');

    $format_biaya = get_post_meta($cpt_id, '_pk_format_biaya', true) ?: (webjti_field('rpl_format_biaya', $cpt_id) ?: webjti_field('rpl_format_biaya') ?: 'tabel');
    $biaya_pendaftaran = get_post_meta($cpt_id, '_pk_biaya_pendaftaran', true) ?: (webjti_field('rpl_biaya_pendaftaran', $cpt_id) ?: webjti_field('rpl_biaya_pendaftaran'));
    $biaya_ipi = get_post_meta($cpt_id, '_pk_biaya_ipi', true) ?: (webjti_field('rpl_biaya_ipi_rekayasa', $cpt_id) ?: webjti_field('rpl_biaya_ipi_rekayasa'));
    $biaya_ukt = get_post_meta($cpt_id, '_pk_biaya_ukt_list', true) ?: (webjti_field('rpl_biaya_ukt_per_semester', $cpt_id) ?: webjti_field('rpl_biaya_ukt_per_semester'));
    
    $biaya_mitra_list = [];
    $cpt_mitra = get_post_meta($cpt_id, '_pk_biaya_mitra_list', true);
    if ($cpt_mitra) {
        $decoded_mitra = json_decode($cpt_mitra, true);
        if (!empty($decoded_mitra)) {
            $biaya_mitra_list = $decoded_mitra;
        }
    }
    if (empty($biaya_mitra_list)) {
        $biaya_mitra_list = webjti_field('rpl_biaya_mitra_list', $cpt_id, []) ?: webjti_field('rpl_biaya_mitra_list', false, []);
    }
    
    $biaya_catatan = get_post_meta($cpt_id, '_pk_biaya_catatan', true) ?: (webjti_field('rpl_biaya_catatan_tambahan', $cpt_id) ?: webjti_field('rpl_biaya_catatan_tambahan'));

    $biaya_list = [];
    $cpt_biaya = get_post_meta($cpt_id, '_pk_biaya_blocks', true);
    if ($cpt_biaya) {
        $decoded_biaya = json_decode($cpt_biaya, true);
        if (!empty($decoded_biaya)) {
            $biaya_list = array_map(function($item) {
                return [
                    'kelompok_program' => $item['kelompok'] ?? '',
                    'bidang'           => $item['bidang'] ?? ($item['title'] ?? ''),
                    'ipi_utama'        => $item['ipi_utama'] ?? ($item['content'] ?? ''),
                    'ipi_psdku'        => $item['ipi_psdku'] ?? '',
                    'ipi_luar'         => $item['ipi_luar'] ?? '',
                    'ukt'              => $item['ukt'] ?? '',
                ];
            }, $decoded_biaya);
        }
    }
    if (empty($biaya_list)) {
        $biaya_list = webjti_field('rpl_biaya_list', $cpt_id, []) ?: webjti_field('rpl_biaya_list', false, []);
    }

    $timeline_list = [];
    $cpt_timeline = get_post_meta($cpt_id, '_pk_timeline_rows', true);
    if ($cpt_timeline) {
        $decoded_tl = json_decode($cpt_timeline, true);
        if (!empty($decoded_tl)) {
            $timeline_list = array_map(function($item) {
                return [
                    'date' => $item['date'] ?? '',
                    'title' => '',
                    'description' => $item['desc'] ?? '',
                ];
            }, $decoded_tl);
        }
    }
    if (empty($timeline_list)) {
        $timeline_list = webjti_field('rpl_timeline_list', $cpt_id, []) ?: webjti_field('rpl_timeline_list', false, []);
    }
} else {
    // Pure fallback if no CPT found
    $deskripsi = webjti_field('rpl_deskripsi');
    $persyaratan = webjti_field('rpl_persyaratan');
    $format_biaya = webjti_field('rpl_format_biaya') ?: 'tabel';
    $biaya_list = webjti_field('rpl_biaya_list', false, []);
    $biaya_pendaftaran = webjti_field('rpl_biaya_pendaftaran');
    $biaya_ipi = webjti_field('rpl_biaya_ipi_rekayasa');
    $biaya_ukt = webjti_field('rpl_biaya_ukt_per_semester');
    $biaya_mitra_list = webjti_field('rpl_biaya_mitra_list', false, []);
    $biaya_catatan = webjti_field('rpl_biaya_catatan_tambahan');
    $timeline_list = webjti_field('rpl_timeline_list', false, []);
    $kontak = webjti_field('rpl_kontak');
}

$featured_index = null;
foreach ($biaya_list as $index => $item) {
    $label = isset($item['label']) ? strtolower($item['label']) : '';
    if (preg_match('/pendaftaran|biaya pendaftaran/i', $label)) {
        $featured_index = $index;
        break;
    }
}

$tabs = [
    ['id' => 'deskripsi', 'label' => 'Deskripsi'],
    ['id' => 'biaya', 'label' => 'Rincian Biaya'],
    ['id' => 'persyaratan', 'label' => 'Persyaratan'],
    ['id' => 'timeline', 'label' => 'Timeline'],
    ['id' => 'kontak', 'label' => 'Kontak'],
];
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
        
        <div class="tab-panel active" data-panel="deskripsi" aria-hidden="false">
            <section class="akademik-program-section">
                <?php
                $deskripsi_content = $deskripsi ? apply_filters('the_content', $deskripsi) : '<p>Deskripsi program belum tersedia.</p>';
                get_template_part(
                    'template-parts/components/content-block',
                    null,
                    [
                        'title' => 'Deskripsi Program',
                        'icon' => 'ph-info',
                        'content' => $deskripsi_content,
                        'class' => 'content-block--strong-title',
                    ]
                );
                ?>
            </section>
        </div>

        <div class="tab-panel" data-panel="biaya" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card">
                    <h2>Rincian Biaya</h2>
                    <?php 
                    if ($format_biaya === 'list') {
                        get_template_part('template-parts/sections/akademik/program-khusus/biaya-list', null, [
                            'biaya_pendaftaran' => $biaya_pendaftaran,
                            'biaya_ipi'         => $biaya_ipi,
                            'biaya_ukt'         => $biaya_ukt,
                            'biaya_mitra_list'  => $biaya_mitra_list,
                            'biaya_catatan'     => $biaya_catatan,
                        ]);
                    } else {
                        get_template_part('template-parts/sections/akademik/program-khusus/biaya-tabel', null, [
                            'biaya_list' => $biaya_list,
                            'biaya_pendaftaran' => $biaya_pendaftaran,
                        ]);
                    }
                    ?>
                </article>
            </section>
        </div>

        <div class="tab-panel" data-panel="persyaratan" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card">
                    <h2>Persyaratan</h2>
                    <?php if ($persyaratan) : ?>
                        <?php echo apply_filters('the_content', $persyaratan); ?>
                    <?php else : ?>
                        <p>Persyaratan belum tersedia.</p>
                    <?php endif; ?>
                </article>
            </section>
        </div>

        <div class="tab-panel" data-panel="timeline" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card">
                    <h2>Timeline</h2>
                    <?php if (!empty($timeline_list)) : ?>
                        <ul class="pk-timeline">
                            <?php foreach ($timeline_list as $entry) :
                                $date = $entry['date'] ?? '';
                                $description = $entry['description'] ?? '';
                                $title = $entry['title'] ?? ''; 
                            ?>
                                <li class="pk-timeline__item">
                                    <div class="pk-timeline__icon">
                                        <div class="pk-timeline__dot"></div>
                                    </div>
                                    <div class="pk-timeline__content">
                                        <?php if ($date) : ?>
                                            <div class="pk-timeline__date"><?php echo esc_html($date); ?></div>
                                        <?php endif; ?>
                                        <?php if ($title) : ?>
                                            <h3 class="pk-timeline__title"><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>
                                        <div class="pk-timeline__desc">
                                            <?php echo wp_kses_post(wpautop($description)); ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Timeline belum tersedia.</p>
                    <?php endif; ?>
                </article>
            </section>
        </div>

        <div class="tab-panel" data-panel="kontak" aria-hidden="true">
            <section class="akademik-program-section">
                <article class="akademik-program-section__card">
                    <h2>Kontak</h2>
                    <?php if ($kontak) : ?>
                        <?php echo apply_filters('the_content', $kontak); ?>
                    <?php else : ?>
                        <p>Kontak belum tersedia.</p>
                    <?php endif; ?>
                </article>
            </section>
        </div>

    </div>
</div>
