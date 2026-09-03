<?php
/**
 * Achievement Header Template
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;
$is_default = $args['is_default'] ?? false;

if (!$achievement) {
    return;
}

$title = $achievement['judul_kompetisi'] ?? get_the_title();
$date = $achievement['tanggal'] ?? '';
$year_label = $achievement['badge_tahun'] ?? ($achievement['tahun_prestasi'] ?? '-');
$winner_label = $achievement['badge_juara'] ?? ($achievement['juara'] ?? '-');
$winner_class = $achievement['badge_juara_class'] ?? '';
$level_label = $achievement['badge_tingkat'] ?? ($achievement['tingkat'] ?? '-');
$level_class = $achievement['badge_tingkat_class'] ?? '';
$winner_raw = $achievement['juara'] ?? '';

/*
========================================
BADGE IMAGE
========================================
*/
$badge_image = 'icon juara 1.png';
if ($winner_raw === 'juara_2') {
  $badge_image = 'icon juara 2.png';
} elseif ($winner_raw === 'juara_3') {
  $badge_image = 'icon juara 3.png';
} elseif ($winner_raw === 'harapan_1') {
  $badge_image = 'icon harapan 1.png';
} elseif ($winner_raw === 'harapan_2') {
  $badge_image = 'icon harapan 2.png';
} elseif ($winner_raw === 'finalis') {
  $badge_image = 'icon finalis.png';
}

$image_url = '';
if (!$is_default) {
    if (has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
} else {
    // Falls back to mock gallery cover
    $image_url = $achievement['gallery'][0]['url'] ?? '';
}
?>

<header class="achievement-header">

  <div class="achievement-header__hero">

    <div class="achievement-header__image">

      <?php if (!empty($image_url)) : ?>

        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">

      <?php else : ?>

        <div class="achievement-header__placeholder">

          <i class="ph ph-image"></i>

        </div>

      <?php endif; ?>

    </div>

    <!-- Floating Badge image in front of cover banner -->
    <div class="achievement-header__badge">

      <img
        src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/illustrations/badge.svg'); ?>"
        alt="<?php echo esc_attr($winner_label); ?>"
      >

    </div>

  </div>

  <div class="achievement-header__content">

    <div class="achievement-header__meta">

      <span class="badge-tahun">
        <?php echo esc_html($year_label); ?>
      </span>

      <span class="badge-juara <?php echo esc_attr($winner_class); ?>">
        <?php echo esc_html($winner_label); ?>
      </span>

      <span class="badge-tingkat <?php echo esc_attr($level_class); ?>">
        <?php echo esc_html($level_label); ?>
      </span>

    </div>

    <h1 class="achievement-header__title">
      <?php echo esc_html($title); ?>
    </h1>

    <div class="achievement-header__date">
      <i class="ph ph-calendar-blank"></i>
      <span>
        <?php echo esc_html($date); ?>
      </span>
    </div>

  </div>

</header>