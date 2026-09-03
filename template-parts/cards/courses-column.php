<?php

$course_group =
  $args['course_group'] ?? null;

if (!$course_group) {
  return;
}

?>

<div class="course-column">

  <h3 class="course-column__title">

    <?php
    echo esc_html(
      $course_group['title']
    );
    ?>

  </h3>

  <?php if (!empty($course_group['items'])) : ?>

    <ul class="course-column__list">

      <?php foreach ($course_group['items'] as $course) : ?>

        <li class="course-column__item">

          <?php
          echo esc_html($course);
          ?>

        </li>

      <?php endforeach; ?>

    </ul>

  <?php else : ?>

    <p class="course-column__empty">

      <?php
      esc_html_e(
        'Tidak ada mata kuliah',
        'webjti'
      );
      ?>

    </p>

  <?php endif; ?>

</div>