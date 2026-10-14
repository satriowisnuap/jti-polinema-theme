<?php
/**
 * Lecturer Education Section
 *
 * @package WebJTI_Theme
 */

$education_list = $args['education'] ?? [];

if (empty($education_list)) {
  $current_lecturer_id = get_the_ID();
  $education_query = new WP_Query([
    'post_type' => ['lecturer_education', 'pendidikan_dosen'],
    'posts_per_page' => -1,
  ]);

  if ($education_query->have_posts()) {
    while ($education_query->have_posts()) {
      $education_query->the_post();

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
      $education_list[] = [
        'degree' => get_field('degree') ?: get_field('jenjang'),
        'institution' => get_field('institution') ?: get_field('institusi'),
        'start_year' => get_field('start_year') ?: get_field('tahun_mulai'),
        'end_year' => get_field('end_year') ?: get_field('tahun_selesai'),
      ];
    }
    wp_reset_postdata();

    usort($education_list, function($a, $b) {
        $a_year = intval($a['end_year'] ?: 0);
        $b_year = intval($b['end_year'] ?: 0);
        return $b_year - $a_year; // DESC
    });
  }
}

if (empty($education_list)) {
  return;
}

ob_start();

?>

<div class="lecturer-education slider-wrapper">

  <div class="lecturer-education__slider slider-container">

    <div class="lecturer-education__track slider-track">

      <?php foreach ($education_list as $education) : ?>

        <div class="slider-item">

          <?php
          get_template_part(
            'template-parts/cards/education-card',
            null,
            [
              'education' => $education,
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
      'Pendidikan',

    'icon' =>
      'ph-graduation-cap',

    'content' =>
      $content,

  ]
);