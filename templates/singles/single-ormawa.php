<?php
/**
 * Template Name: Ormawa Detail
 * Template Post Type: ormawa
 *
 * @package WebJTI_Theme
 */

get_header();

wp_enqueue_style(
    'jti-ormawa-detail',
    get_template_directory_uri() . '/assets/css/ormawa-detail.css',
    ['webjti-app']
);

wp_enqueue_style(
    'jti-laboratory-detail',
    get_template_directory_uri() . '/assets/css/laboratory-detail.css',
    ['webjti-app']
);

// We also enqueue the achievement detail css to borrow the page layout and header structure
wp_enqueue_style(
    'jti-achievement-detail',
    get_template_directory_uri() . '/assets/css/sections/achievement-detail.css',
    ['webjti-app']
);

wp_enqueue_script(
    'jti-ormawa-gallery',
    get_template_directory_uri() . '/assets/js/sections/ormawa-gallery.js',
    [],
    null,
    true  // load in footer
);

$post_id       = get_the_ID();
$title         = get_the_title();

// ACF Fields
$kategori      = get_field('category') ?: get_field('tipe') ?: '';
$sejarah       = get_field('history');
$visi          = get_field('vision');
$misi          = get_field('mission');
$tujuan        = get_field('objective');
$program_kerja = get_field('program');

// ACF Website & Social Media Fields
$website       = get_field('website')   ?: get_field('website_link')   ?: get_field('web') ?: '';
$instagram     = get_field('instagram') ?: get_field('instagram_link') ?: '';
$facebook      = get_field('facebook')  ?: get_field('facebook_link')  ?: '';
$tiktok        = get_field('tiktok')    ?: get_field('tiktok_link')    ?: '';
$has_socials   = !empty($website) || !empty($instagram) || !empty($facebook) || !empty($tiktok);

// ─── Resolve logo: featured image ───
if (has_post_thumbnail()) {
    $logo_url = get_the_post_thumbnail_url($post_id, 'large');
    $logo_alt = $title;
} else {
    $logo_url = '';
    $logo_alt = '';
}

// ─── Fetch gallery items from separate ormawa_gallery post type ───
$gallery_items = [];
$gallery_query = new WP_Query([
    'post_type'      => 'ormawa_gallery',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => 'associated_ormawa',
            'value'   => $post_id,
            'compare' => '=',
        ]
    ],
    'no_found_rows'  => true,
]);

if ($gallery_query->have_posts()) {
    while ($gallery_query->have_posts()) {
        $gallery_query->the_post();
        $photo = get_field('gallery_photo');
        $desc  = get_field('description');
        if ($photo) {
            $url       = '';
            $large_url = '';
            $alt       = '';

            if (is_array($photo)) {
                $url       = $photo['url'] ?? '';
                $large_url = $photo['sizes']['large'] ?? $url;
                $alt       = !empty($photo['alt']) ? $photo['alt'] : get_the_title();
            } elseif (is_numeric($photo)) {
                $url       = wp_get_attachment_url((int) $photo);
                $large_url = wp_get_attachment_image_url((int) $photo, 'large') ?: $url;
                $alt       = get_post_meta((int) $photo, '_wp_attachment_image_alt', true) ?: get_the_title();
            } elseif (is_string($photo)) {
                $attachment_id = attachment_url_to_postid($photo);
                if ($attachment_id) {
                    $url       = wp_get_attachment_url($attachment_id);
                    $large_url = wp_get_attachment_image_url($attachment_id, 'large') ?: $url;
                    $alt       = get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                } else {
                    $url       = $photo;
                    $large_url = $photo;
                    $alt       = get_the_title();
                }
            }

            if ($url) {
                $gallery_items[] = [
                    'url'     => $url,
                    'sizes'   => [
                        'large' => $large_url,
                    ],
                    'alt'     => $alt,
                    'title'   => get_the_title(),
                    'caption' => $desc ?: '',
                ];
            }
        }
    }
    wp_reset_postdata();
}

// ─── Resolve cover/banner image: first gallery image or placeholder ───
$cover_url = '';
if (!empty($gallery_items)) {
    $cover_url = $gallery_items[0]['url'];
} else {
    $cover_url = get_template_directory_uri() . '/assets/images/placeholders/page-header.jpg';
}
?>

<main id="primary" class="site-main single-ormawa-page">

    <div class="container container--wide single-ormawa__container">

        <div class="single-ormawa__layout">

            <!-- ==============================================
            BREADCRUMB
            =============================================== -->
            <?php
            get_template_part(
                'template-parts/components/breadcrumb',
                null,
                [
                    'current_override' => 'Detail Organisasi'
                ]
            );
            ?>

            <!-- ==============================================
            ORMAWA HEADER SECTION (Borrowed layout from achievement header)
            =============================================== -->
            <!-- ==============================================
            ORMAWA HEADER SECTION
            =============================================== -->
            <header class="ormawa-header-v2">

                <div class="ormawa-header-v2__hero">
                    <div class="ormawa-header-v2__image">
                        <?php if ($logo_url) : ?>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
                        <?php elseif (!empty($cover_url)) : ?>
                            <img src="<?php echo esc_url($cover_url); ?>" alt="<?php echo esc_attr($title); ?>">
                        <?php else : ?>
                            <div class="ormawa-header-v2__placeholder">
                                <i class="ph ph-users-three"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="ormawa-header-v2__content">

                    <div class="ormawa-header-v2__meta">
                        <span class="ormawa-header-v2__tag ormawa-header-v2__tag--section">
                            <i class="ph ph-users-three"></i> Kemahasiswaan
                        </span>
                        <?php if ($kategori) : ?>
                            <span class="ormawa-header-v2__tag ormawa-header-v2__tag--category">
                                <?php echo esc_html($kategori); ?>
                            </span>
                        <?php else : ?>
                            <span class="ormawa-header-v2__tag ormawa-header-v2__tag--category">
                                Organisasi Mahasiswa
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="ormawa-header-v2__title">
                        <?php echo esc_html($title); ?>
                    </h1>

                    <?php if ($has_socials) : ?>
                        <div class="ormawa-header-v2__links">
                            <span class="ormawa-header-v2__links-label">
                                <i class="ph ph-link-simple"></i> Tautan Resmi & Media Sosial
                            </span>
                            <div class="ormawa-header-v2__links-grid">
                                <?php if (!empty($website)) : ?>
                                    <a href="<?php echo esc_url($website); ?>" class="ormawa-action-card ormawa-action-card--website" target="_blank" rel="noopener noreferrer">
                                        <span class="ormawa-action-card__icon-wrap">
                                            <i class="ph ph-globe"></i>
                                        </span>
                                        <span class="ormawa-action-card__info">
                                            <span class="ormawa-action-card__label">Website Resmi</span>
                                            <span class="ormawa-action-card__sub">Kunjungi Situs</span>
                                        </span>
                                        <i class="ph ph-arrow-up-right ormawa-action-card__arrow"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($instagram)) : ?>
                                    <a href="<?php echo esc_url($instagram); ?>" class="ormawa-action-card ormawa-action-card--instagram" target="_blank" rel="noopener noreferrer">
                                        <span class="ormawa-action-card__icon-wrap">
                                            <i class="ph-fill ph-instagram-logo"></i>
                                        </span>
                                        <span class="ormawa-action-card__info">
                                            <span class="ormawa-action-card__label">Instagram</span>
                                            <span class="ormawa-action-card__sub">Profil Instagram</span>
                                        </span>
                                        <i class="ph ph-arrow-up-right ormawa-action-card__arrow"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($facebook)) : ?>
                                    <a href="<?php echo esc_url($facebook); ?>" class="ormawa-action-card ormawa-action-card--facebook" target="_blank" rel="noopener noreferrer">
                                        <span class="ormawa-action-card__icon-wrap">
                                            <i class="ph-fill ph-facebook-logo"></i>
                                        </span>
                                        <span class="ormawa-action-card__info">
                                            <span class="ormawa-action-card__label">Facebook</span>
                                            <span class="ormawa-action-card__sub">Halaman Resmi</span>
                                        </span>
                                        <i class="ph ph-arrow-up-right ormawa-action-card__arrow"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($tiktok)) : ?>
                                    <a href="<?php echo esc_url($tiktok); ?>" class="ormawa-action-card ormawa-action-card--tiktok" target="_blank" rel="noopener noreferrer">
                                        <span class="ormawa-action-card__icon-wrap">
                                            <i class="ph-fill ph-tiktok-logo"></i>
                                        </span>
                                        <span class="ormawa-action-card__info">
                                            <span class="ormawa-action-card__label">TikTok</span>
                                            <span class="ormawa-action-card__sub">Video Konten</span>
                                        </span>
                                        <i class="ph ph-arrow-up-right ormawa-action-card__arrow"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </header>

            <!-- ==============================================
            ORMAWA BODY SECTIONS (CONTENT BLOCKS - 1 COLUMN)
            =============================================== -->
            <div class="single-ormawa__content-blocks">

                <?php if ($sejarah) : ?>
                    <?php
                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Sejarah',
                            'icon'    => 'ph-clock-counter-clockwise',
                            'content' => $sejarah,
                        ]
                    );
                    ?>
                <?php endif; ?>

                <?php if ($visi || $misi || $tujuan) : ?>
                    <section class="content-block ormawa-vmt-block-wrapper">
                        <header class="content-block__header">
                            <div class="content-block__icon">
                                <i class="ph-fill ph-eye" aria-hidden="true"></i>
                            </div>
                            <h2 class="content-block__title">Visi, Misi & Tujuan</h2>
                        </header>
                        <div class="content-block__body">
                            <div class="ormawa-vmt-section">
                                <?php if ($visi || $misi) : ?>
                                    <div class="ormawa-vmt-grid">
                                        <?php if ($visi) : ?>
                                            <div class="ormawa-vmt-block ormawa-vmt-block--visi">
                                                <h3><i class="ph ph-eye"></i> Visi</h3>
                                                <div class="ormawa-vmt-content"><?php echo wp_kses_post($visi); ?></div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($misi) : ?>
                                            <div class="ormawa-vmt-block ormawa-vmt-block--misi">
                                                <h3><i class="ph ph-target"></i> Misi</h3>
                                                <div class="ormawa-vmt-content"><?php echo wp_kses_post($misi); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($tujuan) : ?>
                                    <div class="ormawa-vmt-block ormawa-vmt-block--tujuan">
                                        <h3><i class="ph ph-flag-banner"></i> Tujuan</h3>
                                        <div class="ormawa-vmt-content"><?php echo wp_kses_post($tujuan); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if ($program_kerja) : ?>
                    <?php
                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => 'Program Kerja',
                            'icon'    => 'ph-calendar-check',
                            'content' => $program_kerja,
                        ]
                    );
                    ?>
                <?php endif; ?>

                <!-- GALLERY SECTION -->
                <?php if (!empty($gallery_items)) : ?>
                    <div class="ormawa-gallery-section">
                        <?php
                        get_template_part(
                            'template-parts/single/ormawa/ormawa-gallery',
                            null,
                            ['galeri' => $gallery_items]
                        );
                        ?>
                    </div>
                <?php endif; ?>

            </div><!-- .single-ormawa__content-blocks -->

        </div><!-- .single-ormawa__layout -->

    </div><!-- .container -->

</main>

<?php get_footer(); ?>
