<?php
/**
 * Lecturer Publications Section
 *
 * @package WebJTI_Theme
 */

$publication_list = $args['publications'] ?? [];
$sinta_link = $args['sinta_link'] ?? get_field('sinta');

if (empty($publication_list)) {
  $current_lecturer_id = get_the_ID();
  $publication_query = new WP_Query([
    'post_type' => 'lecturer_publication',
    'posts_per_page' => -1,
    'meta_query' => [
      [
        'key' => 'lecturer',
        'value' => $current_lecturer_id,
        'compare' => '=',
      ]
    ],
  ]);

  if ($publication_query->have_posts()) {
    while ($publication_query->have_posts()) {
      $publication_query->the_post();
      $publication_list[] = [
        'title' => get_field('publication_title') ?: get_the_title(),
        'year' => get_field('publication_year') ?: 0,
        'citations' => get_field('citation_count') ?: 0,
        'url' => get_field('publication_url') ?: '#',
        'category' => get_field('publication_category') ?: '',
      ];
    }
    wp_reset_postdata();
  }
}

if (empty($publication_list)) {
  return;
}

$total_publications = count($publication_list);

ob_start();

?>

<div
  class="lecturer-publications slider-wrapper"
  data-publications
>

  <div class="lecturer-publications__topbar">

    <div class="filter-list segmented">

      <button
        class="filter-btn active"
        data-sort="citations"
        type="button"
      >
        Paling Banyak Dikutip
      </button>

      <button
        class="filter-btn"
        data-sort="latest"
        type="button"
      >
        Terbaru
      </button>

      <button
        class="filter-btn"
        data-sort="oldest"
        type="button"
      >
        Terlama
      </button>

    </div>

    <?php if (count($publication_list) > 2) : ?>

      <div class="lecturer-publications__controls">

        <button
          class="education-slider-button slider-btn-prev"
          data-publication-prev
          aria-label="Previous Publication"
        >
          <i class="ph ph-arrow-left"></i>
        </button>

        <button
          class="education-slider-button slider-btn-next"
          data-publication-next
          aria-label="Next Publication"
        >
          <i class="ph ph-arrow-right"></i>
        </button>

      </div>

    <?php endif; ?>

  </div>

  <div class="lecturer-publications__slider slider-container">

    <div
      class="lecturer-publications__grid slider-track"
      data-publication-grid
    >

      <?php foreach ($publication_list as $publication) : ?>

        <div class="slider-item">

          <?php
          get_template_part(
            'template-parts/cards/publication-card',
            null,
            [
              'publication' => $publication,
            ]
          );
          ?>

        </div>

      <?php endforeach; ?>

    </div>

  </div>

  <div class="lecturer-publications__bottom-bar">

    <div class="lecturer-publications__total-count">
      <span>Total</span>
      <strong><?php echo esc_html($total_publications); ?></strong>
      <span>Publikasi</span>
    </div>

    <div class="lecturer-publications__actions">

      <?php if ($sinta_link) : ?>

        <a
          href="<?php echo esc_url($sinta_link); ?>"
          target="_blank"
          rel="noopener noreferrer"
          class="btn btn--outline"
        >
          <span>Lihat Semua di SINTA</span>
        </a>

      <?php endif; ?>

    </div>

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
      'Sorotan Publikasi',

    'icon' =>
      'ph-books',

    'content' =>
      $content,

  ]
);