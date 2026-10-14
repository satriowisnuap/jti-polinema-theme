<?php
/**
 * Alur Item Component (Timeline Style)
 *
 * @package WebJTI_Theme
 */

$item  = $args['item'] ?? null;
$index = $args['index'] ?? 1;

if (!$item) {
  return;
}

$step_label = !empty($item['step']) ? $item['step'] : (!empty($item['year']) ? $item['year'] : sprintf('Tahap %02d', $index));
$title      = $item['title'] ?? '';
$content    = $item['content'] ?? '';
$btn_text   = $item['button_text'] ?? '';
$btn_url    = $item['button_url'] ?? '';
?>

<article class="alur-item timeline-item">

  <div class="alur-item__marker alur-marker timeline-marker">

    <?php if (!empty($item['icon_url'])) : ?>

      <img
        src="<?php echo esc_url($item['icon_url']); ?>"
        alt="<?php echo esc_attr($title); ?>"
        class="alur-item__icon-image timeline-item__icon-image"
      >

    <?php else : ?>

      <i
        class="ph-fill <?php echo esc_attr(!empty($item['icon_class']) ? $item['icon_class'] : 'ph-check-circle'); ?>"
        aria-hidden="true"
      ></i>

    <?php endif; ?>

  </div>

  <div class="alur-item__content alur-content timeline-content">

    <div class="alur-item__step alur-step timeline-year">

      <?php echo esc_html($step_label); ?>

    </div>

    <h3 class="alur-item__title alur-title timeline-title">

      <?php echo esc_html($title); ?>

    </h3>

    <?php if (!empty($content)) : ?>
      <div class="alur-item__description alur-desc timeline-desc">

        <?php echo wp_kses_post($content); ?>

      </div>
    <?php endif; ?>

    <?php if (!empty($btn_text)) : ?>
      <div class="alur-item__action">
        <a
          href="<?php echo esc_url(!empty($btn_url) ? $btn_url : '#'); ?>"
          class="alur-item__button btn-alur-submit"
          <?php echo (!empty($btn_url) && $btn_url !== '#') ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
        >
          <span><?php echo esc_html($btn_text); ?></span>
          <i class="ph-bold ph-arrow-up-right" aria-hidden="true"></i>
        </a>
      </div>
    <?php endif; ?>

  </div>

</article>