<?php
/**
 * JTI Campus Section Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$campuses = webjti_get_campuses();

if (empty($campuses)) {
  return;
}

// Fetch customizer controls with fallback defaults
$badge_text = get_theme_mod('jti_campus_badge_text', 'CABANG JTI');
if (empty(trim($badge_text))) {
    $badge_text = 'CABANG JTI';
}

$title_text = get_theme_mod('jti_campus_title_text', 'Mengenal Kampus JTI di Berbagai Daerah');
if (empty(trim($title_text))) {
    $title_text = 'Mengenal Kampus JTI di Berbagai Daerah';
}

?>

<section class="campus-section" id="cabang-jti" aria-labelledby="campus-section-heading">

  <div class="container container--wide">

    <div class="section-header">

      <div class="badge badge--section">
        <?php echo esc_html($badge_text); ?>
      </div>

      <h2 class="section-title" id="campus-section-heading">
        <?php echo nl2br(esc_html($title_text)); ?>
      </h2>

    </div>

    <div class="campus-grid">

      <?php foreach ($campuses as $campus) : ?>

        <?php
        get_template_part(
          'template-parts/cards/campus-card',
          null,
          [
            'campus' => $campus,
          ]
        );
        ?>

      <?php endforeach; ?>

    </div>

  </div>

</section>