<?php
/**
 * Card Template: Information Card
 * WebJTI Theme (Figma High-Fidelity Node 1274-24290)
 *
 * @package WebJTI_Theme
 */

$info = $args['info'] ?? null;

if (!$info) {
  return;
}

$category_label = $info['category'] ?? '';
$url = $info['url'] ?? ($info['permalink'] ?? '');
$title = $info['title'] ?? '';
$image = $info['image'] ?? '';
$excerpt = $info['excerpt'] ?? '';
$date = $info['date'] ?? '';
$reading_time = $info['reading_time'] ?? '';

?>

<article class="info-card" data-node-id="1274:24290">

  <div class="info-card__image-container" data-node-id="1274:24291">
    <a href="<?php echo esc_url($url); ?>" class="info-card__image-link">
      <?php if (!empty($image)) : ?>
        <img
          src="<?php echo esc_url($image); ?>"
          alt="<?php echo esc_attr($title); ?>"
          class="info-card__image-img"
        >
      <?php else : ?>
        <div class="info-card__placeholder">
          <i class="ph ph-image"></i>
        </div>
      <?php endif; ?>
    </a>
  </div>

  <div class="info-card__content-block" data-node-id="1274:24292">
    
    <!-- Tag -->
    <?php if (!empty($category_label)) : ?>
      <div class="info-card__tag-label" data-node-id="1727:32652">
        <?php echo esc_html($category_label); ?>
      </div>
    <?php endif; ?>

    <!-- Title -->
    <h3 class="info-card__title-heading" data-node-id="1274:24296">
      <a href="<?php echo esc_url($url); ?>">
        <?php echo esc_html($title); ?>
      </a>
    </h3>

    <!-- Excerpt -->
    <?php if (!empty($excerpt)) : ?>
      <p class="info-card__excerpt-text" data-node-id="1274:24297">
        <?php echo esc_html($excerpt); ?>
      </p>
    <?php endif; ?>

    <!-- Meta Row (Date & Reading Time) -->
    <div class="info-card__meta-row" data-node-id="1274:24298">
      <div class="info-card__meta-item">
        <i class="ph ph-calendar-blank"></i>
        <span><?php echo esc_html($date); ?></span>
      </div>
      <div class="info-card__meta-item">
        <i class="ph ph-clock"></i>
        <span><?php echo esc_html($reading_time); ?></span>
      </div>
    </div>

  </div>

</article>