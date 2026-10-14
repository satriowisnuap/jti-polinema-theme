<?php

$type =
  $args['type'] ?? 'news';

$title =
  $args['title'] ?? 'Informasi';

$query =
  new WP_Query([

    'post_type' =>
      $type,

    'posts_per_page' =>
      8,

    'orderby' =>
      'date',

    'order' =>
      'DESC',

  ]);

if (!$query->have_posts()) {
  return;
}

?>

<section class="information-slider">

  <div class="section-header">

    <h2 class="section-title">

      <?php
      echo esc_html($title);
      ?>

    </h2>

  </div>

  <div class="information-slider__track">

    <?php while ($query->have_posts()) : ?>

      <?php
      $query->the_post();

      $info = [

        'title' =>
          get_the_title(),

        'url' =>
          get_permalink(),

        'date' =>
          get_the_date(),

        'reading_time' =>
          jti_reading_time(),

        'excerpt' =>
          get_the_excerpt(),

        'category' =>
          strtoupper($type),

        'image' =>
          get_the_post_thumbnail_url(
            get_the_ID(),
            'medium_large'
          ),

      ];

      get_template_part(
        'template-parts/cards/info-card',
        null,
        [
          'info' => $info,
        ]
      );
      ?>

    <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>

  </div>

</section>