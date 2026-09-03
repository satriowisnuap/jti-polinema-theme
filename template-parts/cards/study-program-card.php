<?php
/**
 * Study Program Card Template
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

$program = $args['program'] ?? null;

if (!$program) {
  return;
}

$card_class = 'study-program-card';

?>

<a
  href="<?php echo esc_url($program['permalink']); ?>"
  class="<?php echo esc_attr($card_class); ?>"
>

  <div class="study-program-card__inner">

    <div class="study-program-card__top">

      <div class="study-program-card__icon">
        <?php if ($program['icon_url']) : ?>
          <img
            src="<?php echo esc_url($program['icon_url']); ?>"
            alt="<?php echo esc_attr($program['title']); ?>"
          >
        <?php else : ?>
          <i class="<?php echo esc_attr($program['fallback_icon']); ?>"></i>
        <?php endif; ?>
      </div>

      <?php if (!empty($program['badge'])) : ?>
        <div class="badge badge--location">
          <span><?php echo esc_html($program['badge']); ?></span>
        </div>
      <?php endif; ?>

    </div>

    <div class="study-program-card__content">

      <h3 class="study-program-card__title">
        <?php echo esc_html($program['title']); ?>
      </h3>

      <p class="study-program-card__description">
        <?php echo esc_html($program['description']); ?>
      </p>

    </div>

  </div>

  <div class="study-program-card__footer">
    <span>
      <?php
      esc_html_e(
        'Lihat Detail',
        'webjti'
      );
      ?>
    </span>
    <i class="ph ph-arrow-up-right"></i>
  </div>

</a>