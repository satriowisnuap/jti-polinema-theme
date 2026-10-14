<?php

$publication =
  $args['publication'] ?? null;

if (!$publication) {
  return;
}

$pub_url      = $publication['url'] ?? '#';
$pub_category = $publication['category'] ?? '';
$has_url      = !empty($pub_url) && $pub_url !== '#';

?>

<article
  class="publication-card"
  data-citations="<?php echo esc_attr($publication['citations']); ?>"
  data-year="<?php echo esc_attr($publication['year']); ?>"
>

  <div class="publication-card__top">

    <div class="publication-card__badges">

      <?php if ($publication['citations'] >= 10) : ?>

        <span class="publication-card__badge publication-card__badge--highlight">
          Banyak Dikutip
        </span>

      <?php endif; ?>

      <?php if ($pub_category) : ?>

        <span class="publication-card__badge publication-card__badge--category">
          <?php echo esc_html($pub_category); ?>
        </span>

      <?php endif; ?>

    </div>

    <span class="publication-card__badge publication-card__badge--neutral">

      <?php echo esc_html($publication['citations']); ?>

      Sitasi

    </span>

  </div>

  <div class="publication-card__content">

    <h3 class="publication-card__title">

      <?php echo esc_html($publication['title']); ?>

    </h3>

    <p class="publication-card__year">

      <?php echo esc_html($publication['year']); ?>

    </p>

  </div>

  <?php if ($has_url) : ?>

    <a
      href="<?php echo esc_url($pub_url); ?>"
      target="_blank"
      rel="noopener noreferrer"
      class="publication-card__button"
    >

      <span>Baca</span>

      <i class="ph ph-arrow-up-right"></i>

    </a>

  <?php else : ?>

    <span class="publication-card__button publication-card__button--disabled">
      <span>Tidak Ada Link</span>
    </span>

  <?php endif; ?>

</article>