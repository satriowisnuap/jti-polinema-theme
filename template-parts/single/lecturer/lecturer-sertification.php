<?php
/**
 * Lecturer Certifications Section
 *
 * @package WebJTI_Theme
 */

$certification_list = $args['certifications'] ?? [];

if (empty($certification_list)) {
  $current_lecturer_id = get_the_ID();
  $certification_query = new WP_Query([
    'post_type' => ['lecturer_certification', 'sertifikasi_dosen', 'lecturer_certificati'],
    'posts_per_page' => -1,
  ]);

  if ($certification_query->have_posts()) {
    while ($certification_query->have_posts()) {
      $certification_query->the_post();

      $assigned_lecturer = get_field('lecturer');
      $is_match = false;
      if (!empty($assigned_lecturer)) {
        $items = is_array($assigned_lecturer) ? $assigned_lecturer : [$assigned_lecturer];
        foreach ($items as $item) {
          $item_id = is_object($item) ? $item->ID : $item;
          if ((int)$item_id === (int)$current_lecturer_id) {
            $is_match = true;
            break;
          }
        }
      }
      if (!$is_match) continue;
      $certification_list[] = [
        'title' => get_field('title') ?: get_field('certification_name') ?: get_field('nama_sertifikasi'),
        'institution' => get_field('issuer') ?: get_field('institution') ?: get_field('lembaga'),
        'start_year' => get_field('start_date') ?: get_field('start_year') ?: get_field('tahun_mulai'),
        'end_year' => get_field('end_date') ?: get_field('end_year') ?: get_field('tahun_selesai'),
      ];
    }
    wp_reset_postdata();
  }
}

if (empty($certification_list)) {
  return;
}

ob_start();

?>

<div class="lecturer-certifications slider-wrapper">

  <div class="lecturer-certifications__slider slider-container">

    <div class="lecturer-certifications__track slider-track">

      <?php foreach ($certification_list as $certification) : ?>

        <div class="slider-item">

          <?php
          get_template_part(
            'template-parts/cards/certification-card',
            null,
            [
              'certification' => $certification,
            ]
          );
          ?>

        </div>

      <?php endforeach; ?>

    </div>

  </div>

</div>

<?php

$content =
  ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [

    'title' =>
      'Sertifikasi',

    'icon' =>
      'ph-certificate',

    'content' =>
      $content,

  ]
);