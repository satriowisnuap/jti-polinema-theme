<?php
/**
 * Single Information Header Section
 *
 * @package WebJTI_Theme
 */

$title = $args['title'] ?? '';
$image_url = $args['image_url'] ?? '';
$category_label = $args['category_label'] ?? 'Berita';
?>

<!-- Centered Header Area for Breadcrumb & Image (Full 800px width) -->
<div class="single-info__header-area">
    
    <!-- Breadcrumb Component -->
    <?php 
    $breadcrumb_active_label = 'Detail ' . $category_label;
    get_template_part(
        'template-parts/components/breadcrumb',
        null,
        ['current_override' => $breadcrumb_active_label]
    ); 
    ?>
    
    <!-- Hero Featured Image (16:9 Aspect Ratio) -->
    <div class="single-info__hero-container">
        <img class="single-info__hero-img" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
    </div>
    
</div>
