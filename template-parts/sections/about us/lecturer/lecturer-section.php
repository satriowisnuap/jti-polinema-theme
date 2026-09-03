<?php
/**
 * Lecturer Section Template
 * WebJTI Theme (Figma High-Fidelity)
 *
 * @package WebJTI_Theme
 */

$lecturers = webjti_get_lecturers(['posts_per_page' => -1]);

if (empty($lecturers)) {
  return;
}

// 1. Group lecturers by Campus Location
$grouped_by_campus = [];
foreach ($lecturers as $lecturer) {
  $campus = 'Kampus Utama';
  if (!empty($lecturer['campus_location'])) {
    if (is_array($lecturer['campus_location'])) {
      $campus = !empty($lecturer['campus_location'][0]) ? $lecturer['campus_location'][0] : 'Kampus Utama';
    } else {
      $campus_parts = explode(',', $lecturer['campus_location']);
      $campus = trim($campus_parts[0]);
    }
  }
  if (empty($campus)) {
    $campus = 'Kampus Utama';
  }

  if (!isset($grouped_by_campus[$campus])) {
    $grouped_by_campus[$campus] = [];
  }
  $grouped_by_campus[$campus][] = $lecturer;
}

// Order campuses by creation order (term_id ASC - campus created first comes at top)
$campus_terms = get_terms([
    'taxonomy'   => 'campus_location',
    'hide_empty' => false,
    'orderby'    => 'term_id',
    'order'      => 'ASC',
]);

$ordered_campuses = [];

if (!empty($campus_terms) && !is_wp_error($campus_terms)) {
    foreach ($campus_terms as $t) {
        if (isset($grouped_by_campus[$t->name])) {
            $ordered_campuses[$t->name] = $grouped_by_campus[$t->name];
        }
    }
}

// Append any remaining grouped campuses preserving first-created order
foreach ($grouped_by_campus as $c => $list) {
    if (!isset($ordered_campuses[$c])) {
        $ordered_campuses[$c] = $list;
    }
}

// Sort lecturer names alphabetically (A-Z) within each campus group
foreach ($ordered_campuses as $c => &$list) {
    usort($list, function($a, $b) {
        return strcasecmp($a['name'], $b['name']);
    });
}
unset($list);

// 2. Group lecturers by Campus -> Study Program (for individual filtered campus grids)
$grouped_by_campus_and_prodi = [];
foreach ($ordered_campuses as $campus => $list) {
  $grouped_by_campus_and_prodi[$campus] = [];
  foreach ($list as $lecturer) {
    $prodi = 'Teknik Informatika';
    if (!empty($lecturer['study_program'])) {
      if (is_array($lecturer['study_program'])) {
        $prodi = !empty($lecturer['study_program'][0]) ? $lecturer['study_program'][0] : 'Teknik Informatika';
      } else {
        $prodi_parts = explode(',', $lecturer['study_program']);
        $prodi = trim($prodi_parts[0]);
      }
    }
    if (empty($prodi)) {
      $prodi = 'Teknik Informatika';
    }

    if (!isset($grouped_by_campus_and_prodi[$campus][$prodi])) {
      $grouped_by_campus_and_prodi[$campus][$prodi] = [];
    }
    $grouped_by_campus_and_prodi[$campus][$prodi][] = $lecturer;
  }

  // Sort lecturers alphabetically (A-Z) within each study program
  foreach ($grouped_by_campus_and_prodi[$campus] as $prodi => &$prodi_list) {
    usort($prodi_list, function($a, $b) {
      return strcasecmp($a['name'], $b['name']);
    });
  }
  unset($prodi_list);
}

?>

<section class="lecturer-section" data-node-id="1269:22343">

  <!-- ========================================
     TOP TOOLBAR (FILTER & SEARCH)
  ======================================== -->
  <div class="lecturer-filter-bar" data-node-id="926:19886">
    
    <!-- Left Segmented Control Options -->
    <div class="filter-list segmented" data-node-id="926:19887">
      <button class="filter-btn active" data-campus="all" data-node-id="926:19888">
        <span class="filter-btn-text"><?php esc_html_e('Semua', 'webjti'); ?></span>
      </button>
      <?php foreach (array_keys($ordered_campuses) as $index => $campus) : ?>
        <button class="filter-btn" data-campus="<?php echo esc_attr($campus); ?>" data-node-id="926:19892">
          <span class="filter-btn-text"><?php echo esc_html($campus); ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Right Custom Search Input -->
    <div class="search-toolbar" data-node-id="926:19904">
      <i class="ph ph-magnifying-glass"></i>
      <input 
        type="text" 
        class="search-input lecturer-search-input" 
        placeholder="<?php esc_attr_e('Cari Dosen atau Keahlian...', 'webjti'); ?>" 
        data-node-id="926:19907"
      >
    </div>

  </div>

  <!-- ========================================
     MODE 1: ALL CAMPUSES (SLIDERS VIEW)
  ======================================== -->
  <div class="lecturer-campus-group-wrapper">

    <?php foreach ($ordered_campuses as $campus => $campus_lecturers) : ?>

      <div class="lecturer-campus-section" data-campus="<?php echo esc_attr($campus); ?>" data-node-id="934:19945">

        <!-- Section Header -->
        <div class="lecturer-section__header" data-node-id="934:19946">
          
          <div class="lecturer-section__title-block" data-node-id="989:8588">
            <h2 class="lecturer-section__title"><?php echo esc_html($campus); ?></h2>
            <div class="lecturer-section__badge">
              <span class="lecturer-section__badge-text" data-total="<?php echo count($campus_lecturers); ?>">
                <?php echo sprintf(esc_html__('%d Tenaga Pengajar', 'webjti'), count($campus_lecturers)); ?>
              </span>
            </div>
          </div>

          <!-- Slider Nav Arrows -->
          <div class="lecturer-section__arrows" data-node-id="1274:23866">
            <button class="slider-btn-prev" aria-label="<?php esc_attr_e('Previous slide', 'webjti'); ?>">
              <i class="ph ph-arrow-left"></i>
            </button>
            <button class="slider-btn-next" aria-label="<?php esc_attr_e('Next slide', 'webjti'); ?>">
              <i class="ph ph-arrow-right"></i>
            </button>
          </div>

        </div>

        <!-- Slider Container with Sneakpeak support -->
        <div class="lecturer-slider__container">
          
          <div class="lecturer-slider__track">

            <?php foreach ($campus_lecturers as $lecturer) : ?>

              <div class="lecturer-slider__item">
                <?php
                get_template_part(
                  'template-parts/cards/lecturer-card',
                  null,
                  [
                    'lecturer' => $lecturer,
                  ]
                );
                ?>
              </div>

            <?php endforeach; ?>

          </div>

        </div>

      </div>

    <?php endforeach; ?>

  </div>

  <!-- ========================================
     MODE 2: INDIVIDUAL CAMPUSES (STUDY PROGRAM GRID VIEW)
  ======================================== -->
  <div class="lecturer-campus-group-prodi-wrapper" style="display: none;">

    <?php foreach ($grouped_by_campus_and_prodi as $campus => $prodis) : ?>

      <div class="lecturer-single-campus-wrapper" data-campus="<?php echo esc_attr($campus); ?>" style="display: none;">

        <?php foreach ($prodis as $prodi => $prodi_lecturers) : ?>

          <div class="lecturer-prodi-section" data-prodi="<?php echo esc_attr($prodi); ?>">

            <!-- Section Header (No Arrows) -->
            <div class="lecturer-section__header">
              
              <div class="lecturer-section__title-block">
                <h2 class="lecturer-section__title"><?php echo esc_html($prodi); ?></h2>
                <div class="lecturer-section__badge">
                  <span class="lecturer-section__badge-text" data-total="<?php echo count($prodi_lecturers); ?>">
                    <?php echo sprintf(esc_html__('%d Tenaga Pengajar', 'webjti'), count($prodi_lecturers)); ?>
                  </span>
                </div>
              </div>

            </div>

            <!-- Static 3-Column Grid Layout -->
            <div class="lecturer-section__grid grid-mode">

              <?php foreach ($prodi_lecturers as $lecturer) : ?>

                <div class="lecturer-grid__item">
                  <?php
                  get_template_part(
                    'template-parts/cards/lecturer-card',
                    null,
                    [
                      'lecturer' => $lecturer,
                    ]
                  );
                  ?>
                </div>

              <?php endforeach; ?>

            </div>

          </div>

        <?php endforeach; ?>

      </div>

    <?php endforeach; ?>

  </div>

  <!-- ========================================
     NO RESULTS PLACEHOLDER
  ======================================== -->
  <div class="lecturer-no-results" style="display: none; text-align: center; padding: 60px 24px;">
    <i class="ph ph-users-three" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block;"></i>
    <h3 style="color: var(--neutral-09); margin-bottom: 8px;"><?php esc_html_e('Tidak Ada Hasil', 'webjti'); ?></h3>
    <p style="color: var(--neutral-06);"><?php esc_html_e('Maaf, tidak ada tenaga pengajar yang sesuai dengan pencarian Anda.', 'webjti'); ?></p>
  </div>

</section>