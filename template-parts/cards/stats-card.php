<?php

$item =
  $args['item'] ?? null;

if (!$item) {
  return;
}

?>

<div class="stats-item">

  <div class="stats-item__top">

    <div class="stats-icon">

      <i class="ph-fill <?php echo esc_attr($item['icon']); ?>"></i>

    </div>

    <div class="stats-value">

      <?php
      echo esc_html($item['value']);
      ?>

    </div>

  </div>

  <p class="stats-label">

    <?php
    echo esc_html($item['label']);
    ?>

  </p>

</div>