<?php
/**
 * Lecturer Courses Section
 *
 * @package WebJTI_Theme
 */

$odd_semester_courses = $args['courses']['odd'] ?? [];
$even_semester_courses = $args['courses']['even'] ?? [];

if (empty($odd_semester_courses) && empty($even_semester_courses)) {
  $current_lecturer_id = get_the_ID();
  $course_query = new WP_Query([
    'post_type' => ['lecturer_course', 'matkul_dosen'],
    'posts_per_page' => -1,
  ]);

  if ($course_query->have_posts()) {
    while ($course_query->have_posts()) {
      $course_query->the_post();

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
      $course_names = get_field('course_name') ?: get_field('course_names') ?: get_field('courses') ?: get_field('nama_mata_kuliah');
      $semester = strtolower(get_field('semester') ?: get_field('term') ?: '');

      $course_names = explode(',', $course_names ?: '');
      foreach ($course_names as $course) {
        $course = trim($course);
        if (!$course) {
          continue;
        }

        if (strpos($semester, 'ganjil') !== false) {
          $odd_semester_courses[] = $course;
        } else {
          $even_semester_courses[] = $course;
        }
      }
    }
    wp_reset_postdata();
  }
}

if (empty($odd_semester_courses) && empty($even_semester_courses)) {
  return;
}

ob_start();

?>

<div class="lecturer-courses">

  <div class="lecturer-courses__columns">

    <?php
    get_template_part(
      'template-parts/cards/courses-column',
      null,
      [
        'course_group' => [
          'title' =>
            'Semester Ganjil',
          'items' =>
            $odd_semester_courses,
        ]
      ]
    );
    ?>

    <?php
    get_template_part(
      'template-parts/cards/courses-column',
      null,
      [
        'course_group' => [
          'title' =>
            'Semester Genap',
          'items' =>
            $even_semester_courses,
        ]
      ]
    );
    ?>

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
      'Mata Kuliah',

    'icon' =>
      'ph-table',

    'content' =>
      $content,

  ]
);