<?php
/**
 * Study Programs Section Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$programs = webjti_get_study_programs(6);

// Fetch customizer controls with fallback defaults
$badge_text = get_theme_mod('jti_prodi_badge_text', 'PROGRAM STUDI');
if (empty(trim($badge_text))) {
    $badge_text = 'PROGRAM STUDI';
}

$title_text = get_theme_mod('jti_prodi_title_text', 'Pilih Jalur Karier Teknologi yang Pas Buatmu');
if (empty(trim($title_text))) {
    $title_text = 'Pilih Jalur Karier Teknologi yang Pas Buatmu';
}

?>

<section class="study-programs-section" id="program-studi" aria-labelledby="study-programs-heading">

  <div class="container container--wide">

    <div class="section-header">

      <div class="badge badge--section">
        <?php echo esc_html($badge_text); ?>
      </div>

      <h2 class="section-title" id="study-programs-heading">
        <?php echo nl2br(esc_html($title_text)); ?>
      </h2>

    </div>

    <?php if (!empty($programs)) : ?>

      <div class="study-programs-grid">

        <?php foreach ($programs as $index => $program) : ?>

          <?php
          get_template_part(
            'template-parts/cards/study-program-card',
            null,
            [
              'program'  => $program,
              'is_first' => $index === 0,
            ]
          );
          ?>

        <?php endforeach; ?>

      </div>
      <?php 
      $total_programs = wp_count_posts('study_program')->publish;
      if ($total_programs > 6) : 
      ?>
      <div class="study-programs-action">

        <a
          href="<?php echo esc_url(
            get_post_type_archive_link('study_program') ?: home_url('/program-studi')
          ); ?>"
          class="btn btn--outline"
        >
          <?php
            esc_html_e(
              'Lihat Selengkapnya',
              'webjti'
            );
          ?>
        </a>

      </div>
      <?php endif; ?>

    <?php else : ?>

      <p class="study-programs-empty">
        <?php
        esc_html_e(
          'Belum ada data program studi.',
          'webjti'
        );
        ?>
      </p>

    <?php endif; ?>

  </div>

</section>
