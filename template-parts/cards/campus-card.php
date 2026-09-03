<?php
/**
 * JTI Campus Card Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$campus = $args['campus'] ?? null;

if (!$campus) {
  return;
}

?>

<article class="campus-card">

  <div class="campus-card__header">
    <h3 class="campus-card__title">
      <?php echo esc_html($campus['title']); ?>
    </h3>
  </div>

  <div class="campus-card__body">

    <a
      href="<?php echo esc_url('https://www.google.com/maps/search/?api=1&query=' . urlencode($campus['address'])); ?>"
      class="campus-card__address"
      target="_blank"
      rel="noopener noreferrer"
      title="<?php esc_attr_e('Buka Google Maps', 'webjti'); ?>"
    >
      <div class="campus-card__icon">
        <i class="ph-fill ph-map-pin-line"></i>
      </div>
      <p class="campus-card__address-text">
        <?php echo esc_html($campus['address']); ?>
      </p>
    </a>

    <div class="campus-card__divider"></div>

    <div class="campus-card__email">
      <div class="campus-card__email-icon">
        <i class="ph ph-envelope-simple"></i>
      </div>
      <a href="mailto:<?php echo esc_attr($campus['email']); ?>" class="campus-card__email-text">
        <?php echo esc_html($campus['email']); ?>
      </a>
    </div>

  </div>

</article>