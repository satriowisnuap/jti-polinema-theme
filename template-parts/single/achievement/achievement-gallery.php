<?php
/**
 * Achievement Gallery Block
 *
 * @package WebJTI_Theme
 */

$achievement = $args['achievement'] ?? null;
$is_default = $args['is_default'] ?? false;
$gallery = $args['gallery'] ?? [];

if (!$achievement) {
    return;
}

$gallery_images = [];

if ($is_default) {
    $gallery_images = $gallery;
} else {
    // Real CPT gallery query from ACF fields
    for ($i = 1; $i <= 8; $i++) {
        $image = get_field('gallery_image_' . $i) ?: get_field('foto_tambahan_' . $i);
        if ($image) {
            $url = '';
            if (is_array($image) && isset($image['url'])) {
                $url = $image['url'];
            } elseif (is_string($image)) {
                $url = $image;
            } elseif (is_numeric($image)) {
                $url = wp_get_attachment_url($image);
            }
            if (!empty($url)) {
                $gallery_images[] = ['url' => $url];
            }
        }
    }
}

if (empty($gallery_images)) {
  return;
}

ob_start();
?>

<div class="achievement-gallery">

  <div class="achievement-gallery__grid">

    <?php foreach ($gallery_images as $image) : ?>

      <div class="achievement-gallery__item gallery-item" data-full="<?php echo esc_url($image['url']); ?>">
        <img src="<?php echo esc_url($image['url']); ?>" alt="Dokumentasi Kompetisi">
        <div class="gallery-item-hover">
          <i class="ph ph-magnifying-glass-plus"></i>
        </div>
      </div>

    <?php endforeach; ?>

  </div>

</div>

<!-- Premium Lightbox Modal powered by theme's global gallery-lightbox component -->
<div id="gallery-lightbox" class="gallery-lightbox" aria-hidden="true">
  <div class="lightbox-overlay"></div>
  <div class="lightbox-toolbar">
    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-in" title="Perbesar (Zoom In)">
      <i class="ph ph-magnifying-glass-plus"></i> <span>Zoom In</span>
    </button>
    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-out" title="Perkecil (Zoom Out)">
      <i class="ph ph-magnifying-glass-minus"></i> <span>Zoom Out</span>
    </button>
    <button type="button" class="lightbox-tool-btn" id="lightbox-zoom-reset" title="Ukuran Semula">
      <i class="ph ph-arrows-out-cardinal"></i> <span>Reset</span>
    </button>
    <a class="lightbox-tool-btn lightbox-tool-btn--primary" id="lightbox-download-link" href="#" target="_blank" download title="Download">
      <i class="ph ph-download-simple"></i> <span>Download</span>
    </a>
  </div>
  <span class="lightbox-close">&times;</span>
  <img id="lightbox-img" class="lightbox-content" src="" alt="Zoomed Dokumentasi">
  
  <?php if (count($gallery_images) > 1) : ?>
    <div class="prev"><i class="ph ph-caret-left"></i></div>
    <div class="next"><i class="ph ph-caret-right"></i></div>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title' => 'Dokumentasi Kompetisi',
    'icon' => 'ph-images-square',
    'content' => $content,
  ]
);