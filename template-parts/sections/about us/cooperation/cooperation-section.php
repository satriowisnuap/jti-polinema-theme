<?php
/**
 * Cooperation Content Section
 *
 * Displays cooperation (Kerjasama) content with support for ACF dynamic title,
 * rich descriptive text, optional banner image, and an optional redirect button.
 *
 * @package WebJTI_Theme
 */

$page_id = get_queried_object_id() ?: get_the_ID();

// ── ACF / Meta Field Resolution ────────────────────────────────────
$title        = webjti_field('cooperation_title', $page_id, '');
$raw_content  = webjti_field('cooperation_description', $page_id, '');
$image_url    = webjti_field('cooperation_image', $page_id, '');
$btn_show     = webjti_field('cooperation_button_show', $page_id, false);
$btn_text     = webjti_field('cooperation_button_text', $page_id, 'Ajukan Kerjasama');
$btn_url      = webjti_field('cooperation_button_url', $page_id, '');
$btn_target   = webjti_field('cooperation_button_target', $page_id, '_blank');

// Title Fallback
if (empty($title)) {
    $page_title = get_the_title($page_id);
    $title = $page_title ?: 'Inisiasi Kerjasama - Jurusan Teknologi Informasi, Politeknik Negeri Malang';
}

// Image Fallback to Featured Image if ACF image is empty
if (empty($image_url) && has_post_thumbnail($page_id)) {
    $image_url = get_the_post_thumbnail_url($page_id, 'large');
}

// Content Fallback logic
if (empty(trim(strip_tags($raw_content)))) {
    $post_obj = get_post($page_id);
    if ($post_obj && !empty(trim(strip_tags($post_obj->post_content)))) {
        $raw_content = apply_filters('the_content', $post_obj->post_content);
    } else {
        $raw_content =
            '<p><strong>Jurusan Teknologi Informasi (JTI) Polinema</strong> berkomitmen untuk menyelaraskan kurikulum akademik dengan perkembangan industri melalui sinergi yang berkelanjutan. Kami membuka ruang bagi mitra industri untuk berkolaborasi dalam bingkai Tri Dharma Perguruan Tinggi guna menciptakan ekosistem pendidikan vokasi yang relevan.</p>' .
            '<p>Kami menawarkan kerja sama yang terstruktur dalam beberapa bidang utama:</p>' .
            '<ul>' .
            '<li><strong>Pendidikan:</strong> Penyelenggaraan program magang mahasiswa (internship), kelas industri, serta keterlibatan praktisi dalam proses pengajaran.</li>' .
            '<li><strong>Penelitian dan Pengembangan:</strong> Kolaborasi riset terapan dan pengembangan produk inovatif (R&D) untuk menjawab tantangan teknis di industri.</li>' .
            '<li><strong>Pelatihan dan Sertifikasi:</strong> Penyediaan pelatihan kompetensi teknis dan sertifikasi profesional bagi mahasiswa maupun tenaga kerja industri.</li>' .
            '<li><strong>Pengabdian Masyarakat:</strong> Implementasi teknologi tepat guna secara bersama-sama untuk memberikan dampak nyata bagi masyarakat luas.</li>' .
            '<li><strong>Bentuk Kerjasama Lainnya</strong> yang merupakan simbiosis mutualisme antar pihak.</li>' .
            '</ul>';
    }
}

$content_allowed = wp_kses_allowed_html('post');
?>

<section class="cooperation-section" id="kerjasama">

    <div class="cooperation-section__card">

        <!-- ============================================================
             HEADER BLOCK
        ============================================================ -->
        <header class="cooperation-section__header">
            <div class="cooperation-section__icon-wrap">
                <i class="ph-fill ph-handshake" aria-hidden="true"></i>
            </div>
            <h1 class="cooperation-section__title">
                <?php echo esc_html($title); ?>
            </h1>
        </header>

        <!-- ============================================================
             BANNER / ILLUSTRATION IMAGE (OPTIONAL)
        ============================================================ -->
        <?php if (!empty($image_url)) : ?>
            <div class="cooperation-section__image-wrap">
                <img
                    src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($title); ?>"
                    class="cooperation-section__image"
                    loading="lazy"
                    decoding="async"
                />
            </div>
        <?php endif; ?>

        <!-- ============================================================
             DESCRIPTIVE CONTENT BODY
        ============================================================ -->
        <div class="cooperation-section__body">
            <?php echo wp_kses($raw_content, $content_allowed); ?>
        </div>

        <!-- ============================================================
             REDIRECT BUTTON (OPTIONAL)
        ============================================================ -->
        <?php if ($btn_show && !empty($btn_url)) : ?>
            <div class="cooperation-section__cta">
                <a
                    href="<?php echo esc_url($btn_url); ?>"
                    class="cooperation-section__btn"
                    target="<?php echo esc_attr($btn_target); ?>"
                    <?php echo ($btn_target === '_blank') ? 'rel="noopener noreferrer"' : ''; ?>
                >
                    <span><?php echo esc_html($btn_text); ?></span>
                    <i class="ph ph-arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
        <?php endif; ?>

    </div><!-- .cooperation-section__card -->

</section><!-- .cooperation-section -->