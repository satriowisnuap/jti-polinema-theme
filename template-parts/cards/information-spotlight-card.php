<?php

$spotlight =
  $args['spotlight'] ?? null;

if (!$spotlight) {
  return;
}

?>

<div class="information-spotlight">
  <a
    href="<?php echo esc_url($spotlight['permalink']); ?>"
    class="information-spotlight-link"
  >
    <div class="information-spotlight-image-wrapper">
      <img
        src="<?php echo esc_url($spotlight['image']); ?>"
        alt="<?php echo esc_attr($spotlight['title']); ?>"
        class="information-spotlight-image"
        loading="lazy"
      >
      <span class="badge badge--spotlight">
        SPOTLIGHT
      </span>
    </div>

    <div class="information-spotlight-content">
      <span class="information-tag">
        <?php echo esc_html($spotlight['category']); ?>
      </span>

      <h3 class="information-card-title information-card-title--spotlight">
        <?php echo esc_html($spotlight['title']); ?>
      </h3>

      <?php if (!empty($spotlight['excerpt'])) : ?>
        <p class="information-spotlight-excerpt">
          <?php echo esc_html($spotlight['excerpt']); ?>
        </p>
      <?php endif; ?>

      <div class="information-meta">
        <div class="information-meta-item">
          <i class="ph ph-calendar"></i>
          <span><?php echo esc_html($spotlight['date']); ?></span>
        </div>
        <div class="information-meta-item">
          <i class="ph ph-clock"></i>
          <span><?php echo esc_html($spotlight['reading_time'] ?? '3 min'); ?></span>
        </div>
      </div>
    </div>
  </a>
</div>
