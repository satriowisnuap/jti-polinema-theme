<?php
/**
 * Ormawa Card Template — v2 (archive version)
 *
 * @package WebJTI_Theme
 */

$id      = get_the_ID();
$title   = get_the_title();
$url     = get_permalink();
$excerpt = get_the_excerpt();

// ACF: kategori / tipe ormawa
$kategori = get_field('category') ?: get_field('tipe') ?: '';

// ACF: website & social media links
$website   = get_field('website')   ?: get_field('website_link')   ?: get_field('web') ?: '';
$instagram = get_field('instagram') ?: get_field('instagram_link') ?: '';
$facebook  = get_field('facebook')  ?: get_field('facebook_link')  ?: '';
$tiktok    = get_field('tiktok')    ?: get_field('tiktok_link')    ?: '';
$has_socials = !empty($website) || !empty($instagram) || !empty($facebook) || !empty($tiktok);

$thumbnail_url = has_post_thumbnail()
    ? get_the_post_thumbnail_url($id, 'medium_large')
    : '';
?>

<div class="ormawa-card-v2">

  <a href="<?php echo esc_url($url); ?>" class="ormawa-card-v2__main-area">

    <div class="ormawa-card-v2__image-wrap">
      <?php if ($thumbnail_url) : ?>
        <img
          src="<?php echo esc_url($thumbnail_url); ?>"
          alt="<?php echo esc_attr($title); ?>"
          class="ormawa-card-v2__logo"
          loading="lazy"
        >
      <?php else : ?>
        <i class="ph ph-users-three ormawa-card-v2__placeholder"></i>
      <?php endif; ?>

      <?php if ($kategori) : ?>
        <span class="ormawa-card-v2__badge"><?php echo esc_html($kategori); ?></span>
      <?php endif; ?>
    </div>

    <div class="ormawa-card-v2__content">
      <h3 class="ormawa-card-v2__title"><?php echo esc_html($title); ?></h3>

      <?php if ($excerpt) : ?>
        <p class="ormawa-card-v2__excerpt"><?php echo wp_trim_words($excerpt, 20); ?></p>
      <?php endif; ?>
    </div>

  </a>

  <div class="ormawa-card-v2__footer">

    <?php if ($has_socials) : ?>
      <div class="ormawa-card-v2__socials">
        <?php if (!empty($website)) : ?>
          <a href="<?php echo esc_url($website); ?>" class="ormawa-card-v2__social-btn ormawa-card-v2__social-btn--website" target="_blank" rel="noopener noreferrer" title="Website Resmi <?php echo esc_attr($title); ?>" aria-label="Website Resmi <?php echo esc_attr($title); ?>">
            <i class="ph ph-globe"></i>
          </a>
        <?php endif; ?>

        <?php if (!empty($instagram)) : ?>
          <a href="<?php echo esc_url($instagram); ?>" class="ormawa-card-v2__social-btn ormawa-card-v2__social-btn--instagram" target="_blank" rel="noopener noreferrer" title="Instagram <?php echo esc_attr($title); ?>" aria-label="Instagram <?php echo esc_attr($title); ?>">
            <i class="ph ph-instagram-logo"></i>
          </a>
        <?php endif; ?>

        <?php if (!empty($facebook)) : ?>
          <a href="<?php echo esc_url($facebook); ?>" class="ormawa-card-v2__social-btn ormawa-card-v2__social-btn--facebook" target="_blank" rel="noopener noreferrer" title="Facebook <?php echo esc_attr($title); ?>" aria-label="Facebook <?php echo esc_attr($title); ?>">
            <i class="ph ph-facebook-logo"></i>
          </a>
        <?php endif; ?>

        <?php if (!empty($tiktok)) : ?>
          <a href="<?php echo esc_url($tiktok); ?>" class="ormawa-card-v2__social-btn ormawa-card-v2__social-btn--tiktok" target="_blank" rel="noopener noreferrer" title="TikTok <?php echo esc_attr($title); ?>" aria-label="TikTok <?php echo esc_attr($title); ?>">
            <i class="ph ph-tiktok-logo"></i>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <a href="<?php echo esc_url($url); ?>" class="ormawa-card-v2__cta">
      Lihat Detail
      <i class="ph ph-arrow-right"></i>
    </a>

  </div>

</div>
