<?php
/**
 * Alur Section (Praktik Kerja Lapangan / Magang Timeline)
 * Dynamic tracks for Magang categories + Optional Informative Box per section
 *
 * @package WebJTI_Theme
 */

$alur_data = webjti_get_magang_alur();

ob_start();
?>

<div class="alur-section timeline-section tabs-container alur-tabs-container">

  <?php if (count($alur_data) > 1) : ?>
  <!-- Dynamic Tabs Navigation Header -->
  <div class="alur-tabs-header" role="tablist" aria-label="Jenis Magang">
    <?php foreach ($alur_data as $index => $category) : ?>
      <button
        type="button"
        class="tab-btn alur-tab-btn <?php echo $index === 0 ? 'active' : ''; ?>"
        role="tab"
        id="tab-magang-<?php echo esc_attr($category['slug']); ?>"
        aria-controls="panel-magang-<?php echo esc_attr($category['slug']); ?>"
        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
      >
        <i class="ph-bold <?php echo (strpos(strtolower($category['slug']), 'mandiri') !== false) ? 'ph-user-gear' : 'ph-users-three'; ?>" aria-hidden="true"></i>
        <span><?php echo esc_html($category['name']); ?></span>
      </button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php foreach ($alur_data as $index => $category) : ?>
  <!-- Tab Panel: <?php echo esc_html($category['name']); ?> -->
  <div
    class="tab-panel alur-tab-panel <?php echo $index === 0 ? 'active' : ''; ?>"
    id="panel-magang-<?php echo esc_attr($category['slug']); ?>"
    role="tabpanel"
    aria-labelledby="tab-magang-<?php echo esc_attr($category['slug']); ?>"
  >
    <?php 
    // Show Info Box if enabled for this term
    if (!empty($category['show_info'])) : ?>
      <div class="alur-info-box alur-info-box--<?php echo esc_attr($category['info_type']); ?>">
        <div class="alur-info-box__icon">
          <i class="ph-fill <?php echo esc_attr($category['info_icon']); ?>" aria-hidden="true"></i>
        </div>
        <div class="alur-info-box__content">
          <?php if (!empty($category['info_title'])) : ?>
            <h4 class="alur-info-box__title"><?php echo esc_html($category['info_title']); ?></h4>
          <?php endif; ?>
          <div class="alur-info-box__text">
            <?php echo wp_kses_post($category['info_content']); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!empty($category['items'])) : ?>
      <div class="alur-section__container alur-container timeline-container">
        <?php foreach ($category['items'] as $item_index => $item) : ?>
          <?php
          get_template_part(
            'template-parts/sections/kemahasiswaan/magang/alur-item',
            null,
            [
              'item'  => $item,
              'index' => $item_index + 1,
            ]
          );
          ?>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p class="alur-section__empty timeline-section__empty">
        <?php esc_html_e('Belum ada data alur magang.', 'webjti'); ?>
      </p>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>

</div>

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title'              => 'Alur pengajuan magang mahasiswa:',
    'icon'               => 'ph-steps',
    'content'            => $content,
    'section_slug'       => 'alur-magang',
    'allow_custom_title' => true,
    'allow_custom_icon'  => true,
  ]
);

