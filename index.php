<?php
/**
 * Main Index Template
 *
 * Fallback template for pages under development - WebJTI Theme.
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main under-development-page">

  <div class="container container--wide">

    <div class="under-development__wrapper">

      <!-- Illustration Image -->
      <div class="under-development__image-area">
        <img 
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholders/under maintenance.svg'); ?>" 
          alt="<?php esc_attr_e('Halaman Sedang Dikembangkan', 'webjti'); ?>" 
          class="under-development__img"
        >
      </div>

      <!-- Information Content -->
      <div class="under-development__content">
        
        <h1 class="under-development__title">
          <?php esc_html_e('Halaman Sedang Dikembangkan', 'webjti'); ?>
        </h1>
        
        <p class="under-development__subtitle">
          <?php esc_html_e('Kami sedang bekerja keras mempersiapkan halaman ini dengan fitur-fitur modern terbaik. Silakan kembali beberapa saat lagi!', 'webjti'); ?>
        </p>
        
        <div class="under-development__action">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
            <i class="ph-fill ph-house"></i>
            <span><?php esc_html_e('Kembali ke Beranda', 'webjti'); ?></span>
          </a>
        </div>

      </div>

    </div>

  </div>

</main>

<?php

get_footer();