<?php
/**
 * Vision Section
 *
 * @package WebJTI_Theme
 */

$vision_content = get_field('visi_content');

if (!$vision_content) {
  $vision_content = 
    '<p class="vision-lead">Pusat Unggulan Teknologi Informasi Nasional dan Internasional</p>' .
    '<p class="vision-desc">Menjadi Jurusan yang unggul dan menjadi rujukan dalam pendidikan vokasi di bidang teknologi informasi tingkat nasional maupun internasional yang berdaya saing global.</p>';
}

ob_start();

?>

<div class="vision-section">

  <div class="vision-section__content">

    <?php
    echo wp_kses_post(
      $vision_content
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
      'Visi Jurusan',

    'icon' =>
      'ph-target',

    'content' =>
      $content,

    'section_slug' => 'visi',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);