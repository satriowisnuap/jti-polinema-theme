<?php
/**
 * Footer Social Card Template
 *
 * @package WebJTI_Theme
 */

$social_title     = get_theme_mod('jti_footer_social_title', 'Ikuti Media Sosial Kami');
$instagram_handle = get_theme_mod('jti_footer_instagram_handle', '@jtipolinema');
$instagram_url    = get_theme_mod('jti_footer_instagram_url', 'https://www.instagram.com/jtipolinema/');
$facebook_handle  = get_theme_mod('jti_footer_facebook_handle', '@jtipolinema');
$facebook_url     = get_theme_mod('jti_footer_facebook_url', 'https://www.facebook.com/jtipolinema');
$x_handle         = get_theme_mod('jti_footer_x_handle', '@jtipolinema');
$x_url            = get_theme_mod('jti_footer_x_url', 'https://x.com/jtipolinema');
$youtube_handle   = get_theme_mod('jti_footer_youtube_handle', '@jtipolinema');
$youtube_url      = get_theme_mod('jti_footer_youtube_url', 'https://www.youtube.com/@jtipolinema');

$logos_dir = get_template_directory_uri() . '/assets/images/logos/';
?>

<div class="ft-col ft-col--social">
  <div class="ft-socmed-card">
    <div class="ft-socmed-card__header">
      <h4 class="ft-socmed-card__title">
        <?php echo esc_html($social_title); ?>
      </h4>
    </div>

    <div class="ft-socmed-card__body">
      <!-- Instagram Row -->
      <?php if (!empty($instagram_url)) : ?>
        <a href="<?php echo esc_url($instagram_url); ?>" class="ft-socmed-row" target="_blank" rel="noopener noreferrer">
          <div class="ft-socmed-info">
            <img src="<?php echo esc_url($logos_dir . 'instagram.png'); ?>" alt="Instagram Logo" class="ft-socmed-icon">
            <span class="ft-socmed-handle"><?php echo esc_html($instagram_handle); ?></span>
          </div>
          <i class="ph ph-arrow-up-right ft-socmed-arrow"></i>
        </a>
      <?php endif; ?>

      <?php if (!empty($instagram_url) && (!empty($facebook_url) || !empty($x_url) || !empty($youtube_url))) : ?>
        <div class="ft-socmed-divider"></div>
      <?php endif; ?>

      <!-- Facebook Row -->
      <?php if (!empty($facebook_url)) : ?>
        <a href="<?php echo esc_url($facebook_url); ?>" class="ft-socmed-row" target="_blank" rel="noopener noreferrer">
          <div class="ft-socmed-info">
            <img src="<?php echo esc_url($logos_dir . 'facebook.png'); ?>" alt="Facebook Logo" class="ft-socmed-icon">
            <span class="ft-socmed-handle"><?php echo esc_html($facebook_handle); ?></span>
          </div>
          <i class="ph ph-arrow-up-right ft-socmed-arrow"></i>
        </a>
      <?php endif; ?>

      <?php if (!empty($facebook_url) && (!empty($x_url) || !empty($youtube_url))) : ?>
        <div class="ft-socmed-divider"></div>
      <?php endif; ?>

      <!-- X (Twitter) Row -->
      <?php if (!empty($x_url)) : ?>
        <a href="<?php echo esc_url($x_url); ?>" class="ft-socmed-row" target="_blank" rel="noopener noreferrer">
          <div class="ft-socmed-info">
            <img src="<?php echo esc_url($logos_dir . 'x.png'); ?>" alt="X Logo" class="ft-socmed-icon">
            <span class="ft-socmed-handle"><?php echo esc_html($x_handle); ?></span>
          </div>
          <i class="ph ph-arrow-up-right ft-socmed-arrow"></i>
        </a>
      <?php endif; ?>

      <?php if (!empty($x_url) && !empty($youtube_url)) : ?>
        <div class="ft-socmed-divider"></div>
      <?php endif; ?>

      <!-- YouTube Row -->
      <?php if (!empty($youtube_url)) : ?>
        <a href="<?php echo esc_url($youtube_url); ?>" class="ft-socmed-row" target="_blank" rel="noopener noreferrer">
          <div class="ft-socmed-info">
            <i class="ph-fill ph-youtube-logo ft-socmed-icon" style="font-size: 24px; color: #ff0000;"></i>
            <span class="ft-socmed-handle"><?php echo esc_html($youtube_handle); ?></span>
          </div>
          <i class="ph ph-arrow-up-right ft-socmed-arrow"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>