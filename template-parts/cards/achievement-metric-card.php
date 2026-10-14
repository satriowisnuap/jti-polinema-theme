<?php

$item =
  $args['item'] ?? null;

if (!$item) {
  return;
}

?>

<article class="achievement-metric-card <?php echo !empty($item['is_featured']) ? 'achievement-metric-card' : ''; ?>">

  <div class="achievement-metric-card__top">

    <i class="ph-fill <?php echo esc_attr($item['icon']); ?>"></i>

    <span>

      <?php
      echo esc_html($item['title']);
      ?>

    </span>

  </div>

  <div class="achievement-metric-card__value">

    <?php
    echo esc_html($item['value']);
    ?>

  </div>

</article>