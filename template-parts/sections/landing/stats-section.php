<?php

$stats =
  webjti_get_campus_stats();

if (empty($stats)) {
  return;
}

?>

<section
  class="stats-section is-landing"
  aria-label="<?php esc_attr_e(
    'Statistik Kampus',
    'webjti'
  ); ?>"
>

  <div class="stats-container">

    <?php foreach ($stats as $index => $item) : ?>

      <?php
      get_template_part(
        'template-parts/cards/stats-card',
        null,
        [
          'item' => $item,
        ]
      );
      ?>

      <?php if ($index !== count($stats) - 1) : ?>

        <div
          class="stats-divider"
          aria-hidden="true"
        ></div>

      <?php endif; ?>

    <?php endforeach; ?>

  </div>

</section>