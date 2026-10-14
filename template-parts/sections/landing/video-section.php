<?php
/**
 * Video Profile Section Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$data = webjti_get_video_section_data();

// Fetch customizer controls with fallback defaults
$badge_text = get_theme_mod('jti_video_badge_text', 'VIDEO PROFIL');
if (empty(trim($badge_text))) {
    $badge_text = 'VIDEO PROFIL';
}

$title_text = get_theme_mod('jti_video_title_text', 'Kenali Lebih Dekat JTI Polinema Sekarang');
if (empty(trim($title_text))) {
    $title_text = 'Kenali Lebih Dekat JTI Polinema Sekarang';
}

?>

<section class="video-section" id="video-profil" aria-labelledby="video-section-heading">

  <div class="video-section__container">

    <div class="section-header">

      <div class="badge badge--section">
        <?php echo esc_html($badge_text); ?>
      </div>

      <h2 class="section-title" id="video-section-heading">
        <?php echo nl2br(esc_html($title_text)); ?>
      </h2>

    </div>

    <!-- DEBUG: Resolved Video URL is <?php echo esc_url($data['embed_url']); ?> -->
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

    <div class="video-section__action">
      <a
        href="<?php echo esc_url($data['channel_url']); ?>"
        class="btn btn-youtube"
        target="_blank"
        rel="noopener noreferrer"
      >
        <i class="ph-fill ph-youtube-logo"></i>
        <span>
          <?php
          esc_html_e(
            'Youtube Channel',
            'webjti'
          );
          ?>
        </span>
      </a>
    </div>

  </div>

</section>