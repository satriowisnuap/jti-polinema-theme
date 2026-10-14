<?php

$item =
  $args['item'] ?? null;

if (!$item) {
  return;
}

?>

<article class="fast-card">

  <div class="fast-card-icon">
    <?php if (!empty($item['icon_class'])) : ?>
      <i class="ph-fill <?php echo esc_attr($item['icon_class']); ?>" aria-hidden="true""></i>
    <?php elseif (!empty($item['icon'])) : ?>
      <img src="<?php echo esc_url($item['icon']); ?>" alt="" aria-hidden="true">
    <?php else : ?>
      <i class="ph-fill ph-code" aria-hidden="true""></i>
    <?php endif; ?>
  </div>

  <div class="fast-card-footer">

    <div class="fast-card-letter">
      <?php echo esc_html($item['letter']); ?>
    </div>

    <div class="fast-card-title">
      <?php echo wp_kses_post($item['title']); ?>
    </div>

  </div>

</article>