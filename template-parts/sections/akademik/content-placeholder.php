<?php
/**
 * Akademik Content Section - Coming Soon Placeholder
 *
 * Reusable placeholder for all akademik pages.
 * Replace this file with the actual content section for each program.
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_title = get_the_title();
if (empty($page_title)) {
    $request_slug = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    $akademik_titles = [
        'd2-piranti-lunak'                => 'D2 Pengembangan Piranti Lunak Situs',
        'd3-mi-kediri'                    => 'D3 Manajemen Informatika (Kediri)',
        'd3-mi-lumajang'                  => 'D3 Manajemen Informatika (Lumajang)',
        'd4-teknik-informatika'           => 'D4 Teknik Informatika',
        'd4-sistem-informasi-bisnis'      => 'D4 Sistem Informasi Bisnis',
        's2-rekayasa-teknologi-informasi' => 'S2 Rekayasa Teknologi Informasi',
        'kelas-internasional'             => 'Kelas Internasional',
        'double-degree'                   => 'Double Degree',
        'alih-jenjang'                    => 'Alih Jenjang',
        'rpl'                             => 'Rekognisi Pembelajaran Lampau (RPL)',
        'aturan-akademik'                 => 'Aturan Akademik',
        'kalender-akademik'               => 'Kalender Akademik',
    ];
    $page_title = $akademik_titles[$request_slug] ?? '';
}
?>

<section class="akademik-coming-soon-section">

    <div class="akademik-coming-soon__inner">

        <div class="akademik-coming-soon__icon">
            <i class="ph ph-books"></i>
        </div>

        <h2 class="akademik-coming-soon__title">
            <?php echo esc_html($page_title); ?>
        </h2>

        <p class="akademik-coming-soon__description">
            Konten untuk halaman ini sedang dalam proses penyusunan. Silakan kunjungi kembali dalam waktu dekat.
        </p>

        <div class="akademik-coming-soon__actions">
            <a
                href="<?php echo esc_url(home_url('/')); ?>"
                class="btn btn--primary"
            >
                <i class="ph ph-house"></i>
                Kembali ke Beranda
            </a>
            <a
                href="<?php echo esc_url(site_url('/about-us/history')); ?>"
                class="btn btn--secondary"
            >
                <i class="ph ph-info"></i>
                Tentang Kami
            </a>
        </div>

    </div>

</section>
