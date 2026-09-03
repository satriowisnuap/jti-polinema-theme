<?php
/**
 * Footer Brand Identity Template
 *
 * @package WebJTI_Theme
 */

$footer_logo        = get_theme_mod('jti_footer_logo');
$footer_name        = get_theme_mod('jti_footer_name', 'Jurusan Teknologi Informasi');
$footer_institution = get_theme_mod('jti_footer_institution', 'Politeknik Negeri Malang');
$footer_phone       = get_theme_mod('jti_footer_phone', '(0341) 404424');
$footer_email       = get_theme_mod('jti_footer_email', 'jti@polinema.ac.id');
?>

<div class="ft-col ft-col--identity">
  <div class="ft-logos">
    <?php if (!empty($footer_logo)) : ?>
      <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php echo esc_attr($footer_name); ?>" class="ft-logo-img">
    <?php else : ?>
      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logos/Logos Jurusan.svg'); ?>" alt="JTI Polinema Logos" class="ft-logo-img">
    <?php endif; ?>
  </div>

  <div class="ft-identity-text">
    <p class="ft-name">
      <?php echo esc_html($footer_name); ?>
    </p>
    <p class="ft-institution">
      <?php echo esc_html($footer_institution); ?>
    </p>
  </div>

  <div class="ft-contact">
    <?php if (!empty($footer_phone)) : ?>
      <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $footer_phone)); ?>" class="ft-contact-row">
        <i class="ph ph-phone ft-contact-icon"></i>
        <span class="ft-contact-text"><?php echo esc_html($footer_phone); ?></span>
      </a>
    <?php endif; ?>

    <?php if (!empty($footer_email)) : ?>
      <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="ft-contact-row">
        <i class="ph ph-envelope-simple ft-contact-icon"></i>
        <span class="ft-contact-text"><?php echo esc_html($footer_email); ?></span>
      </a>
    <?php endif; ?>
  </div>
</div>