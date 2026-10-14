<?php
/**
 * Ormawa Gallery Section Template
 * Exact same style, slider, and pop-up zoom as Laboratory Gallery
 *
 * @package WebJTI_Theme
 */

$galeri = $args['galeri'] ?? [];

if (empty($galeri)) {
    return;
}

$total_images = count($galeri);
?>

<section class="lab-section lab-gallery-section ormawa-gallery slider-wrapper" id="ormawa-gallery-section">
    <div class="section-header">
        <h2><i class="ph ph-images-square"></i> Galeri Kegiatan</h2>
    </div>

    <div class="lab-gallery-slider-wrap slider-container">
        <div class="lab-gallery-grid slider-track" id="ormawaGalleryGrid">
            <?php foreach ($galeri as $image) :
                if (is_numeric($image)) {
                    $src       = wp_get_attachment_image_url((int) $image, 'large') ?: wp_get_attachment_url((int) $image);
                    $full_src  = wp_get_attachment_url((int) $image);
                    $alt       = get_post_meta((int) $image, '_wp_attachment_image_alt', true) ?: get_the_title((int) $image);
                } else {
                    $src       = $image['sizes']['large'] ?? $image['url'] ?? '';
                    $full_src  = $image['url'] ?? $src;
                    $alt       = !empty($image['alt']) ? $image['alt'] : (!empty($image['title']) ? $image['title'] : 'Foto Kegiatan');
                }

                if (empty($src)) continue;
            ?>
                <div class="slider-item">
                    <div class="lab-gallery-card gallery-item" data-full="<?php echo esc_url($full_src); ?>">
                        <div class="lab-gallery-card__img-wrap">
                            <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy" />
                            <div class="lab-gallery-card__overlay">
                                <i class="ph ph-magnifying-glass-plus"></i>
                                <span>Lihat Foto</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal for Ormawa Gallery Zoom -->
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
  <img id="lightbox-img" class="lightbox-content" src="" alt="Foto Kegiatan Full">
  
  <?php if ($total_images > 1) : ?>
    <div class="prev"><i class="ph ph-caret-left"></i></div>
    <div class="next"><i class="ph ph-caret-right"></i></div>
  <?php endif; ?>
</div>
