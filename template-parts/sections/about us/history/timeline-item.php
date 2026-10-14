<?php

$item =
  $args['item'] ?? null;

if (!$item) {
  return;
}

?>

<article class="timeline-item">

  <div class="timeline-item__marker timeline-marker">

    <?php if ($item['icon_url']) : ?>

      <img
        src="<?php echo esc_url($item['icon_url']); ?>"
        alt=""
        class="timeline-item__icon-image"
      >

    <?php else : ?>

      <i
        class="ph-fill <?php echo esc_attr($item['icon_class']); ?>"
        aria-hidden="true"
      ></i>

    <?php endif; ?>

  </div>

  <div class="timeline-item__content timeline-content">

    <div class="timeline-item__year timeline-year">

      <?php
      echo esc_html($item['year']);
      ?>

    </div>

    <h3 class="timeline-item__title timeline-title">

      <?php
      echo esc_html($item['title']);
      ?>

    </h3>

    <div class="timeline-item__description timeline-desc">

      <?php
      echo wp_kses_post($item['content']);
      ?>

    </div>

  </div>

</article>