<?php

$certification =
  $args['certification'] ?? null;

if (!$certification) {
  return;
}

?>

<article class="certification-card">

  <div class="certification-card__top">

    <div class="certification-card__icon">

      <i
        class="ph-fill ph-certificate"
        aria-hidden="true"
      ></i>

    </div>

    <?php if (
      $certification['start_year']
      || $certification['end_year']
    ) : ?>

      <span class="certification-card__year">

        <?php
        echo esc_html(
          $certification['start_year']
        );
        ?>

        <?php if (
          $certification['start_year']
          && $certification['end_year']
        ) : ?>

          -

        <?php endif; ?>

        <?php
        echo esc_html(
          $certification['end_year']
        );
        ?>

      </span>

    <?php endif; ?>

  </div>

  <div class="certification-card__content">

    <h3 class="certification-card__title">

      <?php
      echo esc_html(
        $certification['title']
      );
      ?>

    </h3>

    <p class="certification-card__institution">

      <?php
      echo esc_html(
        $certification['institution']
      );
      ?>

    </p>

  </div>

</article>