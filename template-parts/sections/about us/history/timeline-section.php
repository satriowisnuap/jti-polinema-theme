<?php
/**
 * Timeline Section
 *
 * @package WebJTI_Theme
 */

$timeline_items =
  webjti_get_history_timeline();

ob_start();

?>

<div class="timeline-section">

  <?php if (!empty($timeline_items)) : ?>

    <div class="timeline-section__container timeline-container">

      <?php foreach ($timeline_items as $item) : ?>

        <?php
        get_template_part(
          'template-parts/sections/about us/history/timeline-item',
          null,
          [
            'item' => $item,
          ]
        );
        ?>

      <?php endforeach; ?>

    </div>

  <?php else : ?>

    <p class="timeline-section__empty">

      <?php
      esc_html_e(
        'Belum ada data timeline.',
        'webjti'
      );
      ?>

    </p>

  <?php endif; ?>

</div>

<?php

$content =
  ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' =>
      'Perjalanan Tahun ke Tahun',
    'icon' =>
      'ph-rocket-launch',
    'content' =>
      $content,
    'section_slug' => 'timeline',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);