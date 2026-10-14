<?php
/**
 * Lecturer Expertise Section
 *
 * @package WebJTI_Theme
 */

$lecturer = $args['lecturer'] ?? null;
$skills = $args['skills'] ?? ($lecturer['skills'] ?? []);

if (empty($skills)) {
  $skills =
    webjti_get_term_names(
      get_the_ID(),
      'expertise'
    );
}

if (empty($skills)) {

  $skills =
    get_field(
      'bidang_keahlian'
    );

}

if (!$skills) {
  return;
}

/*
========================================
NORMALIZE DATA
========================================
*/

if (!is_array($skills)) {

  $skills =
    explode(',', $skills);

}

$skills =
  array_filter(
    array_map(
      'trim',
      $skills
    )
  );

if (empty($skills)) {
  return;
}

ob_start();

?>

<div class="lecturer-expertise">

  <div class="lecturer-expertise__list">

    <?php foreach ($skills as $skill) : ?>

      <span class="staff-tag expertise-tag">

        <?php
        echo esc_html($skill);
        ?>

      </span>

    <?php endforeach; ?>

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
      'Bidang Keahlian',

    'icon' =>
      'ph-fire-simple',

    'content' =>
      $content,

  ]
);