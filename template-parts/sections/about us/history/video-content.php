<?php
/**
 * History Video Section
 *
 * @package WebJTI_Theme
 */

$data = webjti_get_video_section_data();

ob_start();

?>

<div class="history-video">

  <div class="video-section__embed">

    <iframe
      src="<?php echo esc_url($data['embed_url']); ?>"
      title="<?php esc_attr_e(
        'Video Profil JTI Polinema',
        'webjti'
      ); ?>"
      allow="
        accelerometer;
        autoplay;
        clipboard-write;
        encrypted-media;
        gyroscope;
        picture-in-picture;
        web-share
      "
      allowfullscreen
    ></iframe>

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
      'Video Profil',
    'icon' =>
      'ph-video-camera',
    'content' =>
      $content,
    'section_slug' => 'video',
    'allow_custom_title' => true,
    'allow_custom_icon' => true,
  ]
);