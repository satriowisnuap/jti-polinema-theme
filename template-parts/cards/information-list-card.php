<?php

$item =
  $args['item'] ?? null;

$show_divider =
  $args['show_divider'] ?? false;

if (!$item) {
  return;
}

?>

<a
  href="<?php echo esc_url($item['permalink']); ?>"
  class="information-card-link"
>
  <div class="information-card-image-wrapper">
    <img
      src="<?php echo esc_url($item['image']); ?>"
      alt="<?php echo esc_attr($item['title']); ?>"
      class="information-card-image"
      loading="lazy"
    >
  </div>

  <div class="information-card-content">
    <span class="information-tag">
      <?php echo esc_html($item['category']); ?>
    </span>
    <h4 class="information-card-title h5">
      <?php echo esc_html($item['title']); ?>
    </h4>

    <div class="information-meta">
      <div class="information-meta-item">
        <i class="ph ph-calendar"></i>
        <span><?php echo esc_html($item['date']); ?></span>
      </div>
      <div class="information-meta-item">
        <i class="ph ph-clock"></i>
        <span><?php echo esc_html($item['reading_time'] ?? '3 min'); ?></span>
      </div>
    </div>
  </div>
</a>

<?php if ($show_divider) : ?>
  <div class="information-divider"></div>
<?php endif; ?>
