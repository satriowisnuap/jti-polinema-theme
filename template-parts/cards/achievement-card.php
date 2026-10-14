<?php
/**
 * Card Template: Achievement Card
 * WebJTI Theme (Styled identically to Info Card Figma Node 1274-24290)
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;

if (!$achievement) {
  return;
}

$url = $achievement['url'] ?? '';
$title = $achievement['title'] ?? '';
$image = $achievement['image'] ?? '';
$excerpt = $achievement['excerpt'] ?? '';
$date = $achievement['date'] ?? '';

// Build a premium tag label from Juara & Tingkat
$tag_label = 'PRESTASI';
if (!empty($achievement['juara'])) {
  $juara_clean = ucwords(str_replace('_', ' ', $achievement['juara']));
  $tag_label = $juara_clean;
  if (!empty($achievement['tingkat'])) {
    $tag_label .= ' - ' . ucwords(str_replace('_', ' ', $achievement['tingkat']));
  }
} elseif (!empty($achievement['tingkat'])) {
  $tag_label = ucwords(str_replace('_', ' ', $achievement['tingkat']));
}

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
    <div class="info-card__tag-label" data-node-id="1727:32652">
      <?php echo esc_html($tag_label); ?>
    </div>

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

    <!-- Meta Row (Date & Trophy icon) -->
    <div class="info-card__meta-row" data-node-id="1274:24298">
      <div class="info-card__meta-item">
        <i class="ph ph-calendar-blank"></i>
        <span><?php echo esc_html($date); ?></span>
      </div>
      <div class="info-card__meta-item">
        <i class="ph ph-trophy"></i>
        <span>Prestasi</span>
      </div>
    </div>

  </div>

</article>