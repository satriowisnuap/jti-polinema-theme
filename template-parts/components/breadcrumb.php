<?php
/**
 * Breadcrumbs Component
 *
 * @package WebJTI_Theme
 */

$current_override = $args['current_override'] ?? '';
$hide_current     = $args['hide_current'] ?? false;

$breadcrumb = webjti_get_breadcrumb_items();
$trail = $breadcrumb['trail'];
$current_label = !empty($current_override) ? $current_override : $breadcrumb['current'];
?>

<nav class="jti-breadcrumb" aria-label="Breadcrumb">
  <div class="breadcrumb-inner">

    <?php 
    $total_crumbs = count($trail);
    $i = 0;
    foreach ($trail as $crumb) : 
      $i++;
      ?>
      <a href="<?php echo esc_url($crumb['url']); ?>" class="breadcrumb-item breadcrumb-submenu-active">
        <?php echo esc_html($crumb['label']); ?>
      </a>

      <?php if (!$hide_current || $i < $total_crumbs) : ?>
        <i class="ph ph-caret-right breadcrumb-sep" aria-hidden="true"></i>
      <?php endif; ?>

    <?php endforeach; ?>

    <?php if (!$hide_current) : ?>
      <span class="breadcrumb-item breadcrumb-active" aria-current="page">
        <?php echo esc_html($current_label); ?>
      </span>
    <?php endif; ?>

  </div>
</nav>