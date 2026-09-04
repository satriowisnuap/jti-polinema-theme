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

  <div class="ft-social-icons" style="display: flex; gap: 16px; margin-top: 16px; align-items: center;">
    <?php
    $instagram_url = get_theme_mod('jti_footer_instagram_url', 'https://www.instagram.com/jtipolinema/');
    $facebook_url  = get_theme_mod('jti_footer_facebook_url', 'https://www.facebook.com/jtipolinema');
    $x_url         = get_theme_mod('jti_footer_x_url', 'https://x.com/jtipolinema');
    $youtube_url   = get_theme_mod('jti_footer_youtube_url', 'https://www.youtube.com/@jtipolinema');
    $logos_dir     = get_template_directory_uri() . '/assets/images/logos/';
    ?>
    
    <?php if (!empty($instagram_url)) : ?>
      <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" style="transition: opacity 0.2s; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
        <img src="<?php echo esc_url($logos_dir . 'instagram.png'); ?>" alt="Instagram" style="width: 24px; height: 24px;">
      </a>
    <?php endif; ?>

    <?php if (!empty($facebook_url)) : ?>
      <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" style="transition: opacity 0.2s; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
        <img src="<?php echo esc_url($logos_dir . 'facebook.png'); ?>" alt="Facebook" style="width: 24px; height: 24px;">
      </a>
    <?php endif; ?>

    <?php if (!empty($x_url)) : ?>
      <a href="<?php echo esc_url($x_url); ?>" target="_blank" rel="noopener noreferrer" style="transition: opacity 0.2s; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
        <img src="<?php echo esc_url($logos_dir . 'x.png'); ?>" alt="X" style="width: 24px; height: 24px;">
      </a>
    <?php endif; ?>

    <?php if (!empty($youtube_url)) : ?>
      <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" rel="noopener noreferrer" style="transition: opacity 0.2s; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
        <img src="<?php echo esc_url($logos_dir . 'youtube.png'); ?>" alt="Youtube" style="width: 35px; height: 24px;">
      </a>
    <?php endif; ?>
  </div>
</div>