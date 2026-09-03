<?php
/**
 * Achievement Metrics Section
 *
 * @package WebJTI_Theme
 */

$metrics_data = webjti_get_achievement_metrics();

$metrics = [
    [
        'icon'        => 'ph-globe',
        'title'       => esc_html__('Total Prestasi', 'webjti'),
        'value'       => $metrics_data['total'],
        'is_featured' => true,
    ],
    [
        'icon'        => 'ph-medal-military',
        'title'       => esc_html__('Tingkat Nasional', 'webjti'),
        'value'       => $metrics_data['nasional'],
        'is_featured' => false,
    ],
    [
        'icon'        => 'ph-map-trifold',
        'title'       => esc_html__('Tingkat Internasional', 'webjti'),
        'value'       => $metrics_data['internasional'],
        'is_featured' => false,
    ],
    [
        'icon'        => 'ph-book-open-text',
        'title'       => esc_html__('Lolos PKM', 'webjti'),
        'value'       => $metrics_data['pkm'],
        'is_featured' => false,
    ],
];
?>

<div class="achievement-metrics-section">
  <div class="achievement-metrics__grid">
    <?php foreach ($metrics as $metric) : ?>
      <?php
      get_template_part(
          'template-parts/cards/achievement-metric-card',
          null,
          [
              'item' => $metric,
          ]
      );
      ?>
    <?php endforeach; ?>
  </div>
</div>
