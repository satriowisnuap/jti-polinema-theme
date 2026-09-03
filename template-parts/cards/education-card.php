<?php

$education =
  $args['education'] ?? null;

if (!$education) {
  return;
}

?>

<article class="education-card">

  <div class="education-card__top">

    <div class="education-card__icon">

      <i
        class="ph-fill ph-graduation-cap"
        aria-hidden="true"
      ></i>

    </div>

    <?php if (
      $education['start_year']
      || $education['end_year']
    ) : ?>

      <span class="education-card__year">

        <?php
        echo esc_html(
          $education['start_year']
        );
        ?>

        -

        <?php
        echo esc_html(
          $education['end_year']
        );
        ?>

      </span>

    <?php endif; ?>

  </div>

  <div class="education-card__content">

    <h3 class="education-card__degree">

      <?php
      echo esc_html(
        $education['degree']
      );
      ?>

    </h3>

    <p class="education-card__institution">

      <?php
      echo esc_html(
        $education['institution']
      );
      ?>

    </p>

  </div>

</article>
