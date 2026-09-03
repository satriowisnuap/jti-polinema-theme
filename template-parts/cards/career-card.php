<?php
/**
 * Card Template: Career Program Card
 * WebJTI Theme
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
$location = $info['location'] ?? '';
?>

<article class="info-card career-card">

  <div class="info-card__image-container">
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

  <div class="info-card__content-block">
    
    <!-- Tag -->
    <?php if (!empty($category_label)) : ?>
      <div class="info-card__tag-label">
        <?php echo esc_html($category_label); ?>
      </div>
    <?php endif; ?>

    <!-- Title -->
    <h3 class="info-card__title-heading">
      <a href="<?php echo esc_url($url); ?>">
        <?php echo esc_html($title); ?>
      </a>
    </h3>

    <!-- Excerpt -->
    <?php if (!empty($excerpt)) : ?>
      <p class="info-card__excerpt-text">
        <?php echo esc_html($excerpt); ?>
      </p>
    <?php endif; ?>

    <!-- Meta Row (Date & Location) -->
    <div class="info-card__meta-row" style="display: flex; flex-direction: column; gap: 8px;">
      <div class="info-card__meta-item" style="display: flex; align-items: center; gap: 6px; color: var(--neutral-06); font-size: 14px;">
        <i class="ph ph-calendar-blank"></i>
        <span><?php echo esc_html($date); ?></span>
      </div>
      <?php if (!empty($location) && $location !== '-') : ?>
      <div class="info-card__meta-item" style="display: flex; align-items: center; gap: 6px; color: var(--neutral-06); font-size: 14px;">
        <i class="ph ph-map-pin"></i>
        <span><?php echo esc_html($location); ?></span>
      </div>
      <?php endif; ?>
    </div>

  </div>

</article>
