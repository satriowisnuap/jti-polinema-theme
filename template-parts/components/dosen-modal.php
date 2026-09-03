<?php
/**
 * Dosen Portal Links Modal
 *
 * @package WebJTI_Theme
 */

$modal_title = get_theme_mod('jti_dosen_modal_title', 'Portal Layanan Dosen');
$modal_desc  = get_theme_mod('jti_dosen_modal_desc', 'Akses cepat ke berbagai sistem layanan untuk Dosen Politeknik Negeri Malang.');

$default_modal_links = [
    1 => ['url' => 'https://siakad.polinema.ac.id', 'title' => 'SIAKAD POLINEMA', 'desc' => 'Sistem Informasi Akademik', 'icon' => 'ph-chalkboard-teacher'],
    2 => ['url' => 'https://spada.polinema.ac.id', 'title' => 'SPADA POLINEMA', 'desc' => 'Sistem Pembelajaran Daring', 'icon' => 'ph-books'],
    3 => ['url' => 'https://lms.jti.polinema.ac.id', 'title' => 'LMS JTI', 'desc' => 'Learning Management System JTI', 'icon' => 'ph-monitor-play'],
    4 => ['url' => 'https://mail.google.com/a/polinema.ac.id', 'title' => 'Email Dosen', 'desc' => 'Akses Email @polinema.ac.id', 'icon' => 'ph-envelope-simple'],
    5 => ['url' => 'https://jti.polinema.ac.id', 'title' => 'Portal JTI', 'desc' => 'Website Jurusan Teknologi Informasi', 'icon' => 'ph-globe'],
];
?>

<div id="dosen-modal" class="mahasiswa-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="dosen-modal-title">
    <div class="mahasiswa-modal__overlay" tabindex="-1"></div>
    <div class="mahasiswa-modal__content">
        <button type="button" class="mahasiswa-modal__close" aria-label="Tutup modal">
            <i class="ph ph-x"></i>
        </button>
        <div class="mahasiswa-modal__header">
            <h3 id="dosen-modal-title"><?php echo esc_html($modal_title); ?></h3>
            <?php if (!empty($modal_desc)) : ?>
                <p><?php echo esc_html($modal_desc); ?></p>
            <?php endif; ?>
        </div>
        <div class="mahasiswa-modal__body">
            <div class="mahasiswa-modal__grid">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    $def = $default_modal_links[$i];
                    $url   = get_theme_mod("jti_dosen_modal_url_{$i}", $def['url']);
                    $title = get_theme_mod("jti_dosen_modal_title_{$i}", $def['title']);
                    $desc  = get_theme_mod("jti_dosen_modal_desc_{$i}", $def['desc']);
                    $icon  = get_theme_mod("jti_dosen_modal_icon_{$i}", $def['icon']);

                    if (!empty($url) && !empty($title)) :
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="mahasiswa-modal__item">
                            <div class="mahasiswa-modal__item-icon">
                                <i class="ph <?php echo esc_attr($icon); ?>"></i>
                            </div>
                            <div class="mahasiswa-modal__item-text">
                                <h4><?php echo esc_html($title); ?></h4>
                                <span><?php echo esc_html($desc); ?></span>
                            </div>
                        </a>
                        <?php
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</div>
