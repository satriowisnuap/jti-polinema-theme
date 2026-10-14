<?php

$data =
  webjti_get_history_welcome_data();

$bg_style = '';
if (!empty($data['bg_image'])) {
  $bg_style = ' style="background-image: url(' . esc_url($data['bg_image']) . '); background-size: cover; background-position: center;"';
}

?>

<section class="welcome-section"<?php echo $bg_style; ?>>

  <div
    class="welcome-section__circles"
    aria-hidden="true"
  ></div>

  <div class="welcome-section__content">

    <h2 class="welcome-section__title">

      <?php
      echo nl2br(
        esc_html($data['title'])
      );
      ?>

    </h2>

    <button
      class="video-button"
      data-video-id="<?php echo esc_attr($data['video_id']); ?>"
      type="button"
    >

      <i class="ph-fill ph-play"></i>

      <span>

        <?php
        esc_html_e(
          'Lihat Video',
          'webjti'
        );
        ?>

      </span>

    </button>

  </div>

  <div class="welcome-section__image-wrapper">

    <div class="welcome-section__image">

      <img
        src="<?php echo esc_url($data['image']); ?>"
        alt="<?php echo esc_attr($data['name']); ?>"
      >

    </div>

    <div class="welcome-section__name-tag">

      <?php
      echo esc_html($data['name']);
      ?>

    </div>

  </div>

</section>