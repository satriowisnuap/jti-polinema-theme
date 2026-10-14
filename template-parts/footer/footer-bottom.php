<?php
/**
 * Footer Copyright Bar Template
 *
 * @package WebJTI_Theme
 */

$custom_copyright   = get_theme_mod('jti_footer_copyright');
$footer_name        = get_theme_mod('jti_footer_name', 'Jurusan Teknologi Informasi');
$footer_institution = get_theme_mod('jti_footer_institution', 'Politeknik Negeri Malang');
?>

<div class="ft-bottom">
  <p class="ft-copyright">
    <?php if (!empty($custom_copyright)) : ?>
      <?php echo esc_html($custom_copyright); ?>
    <?php else : ?>
      &copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html($footer_name); ?>, <?php echo esc_html($footer_institution); ?>. <?php esc_html_e('Hak Cipta Dilindungi.', 'webjti-theme'); ?>
    <?php endif; ?>
  </p>
</div>