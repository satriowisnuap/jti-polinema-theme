<?php
/**
 * Staff Section Template
 * WebJTI Theme (Figma High-Fidelity)
 *
 * @package WebJTI_Theme
 */

$staff_list = webjti_get_staff(['posts_per_page' => -1]);

if (empty($staff_list)) {
  return;
}

// 1. Group staff by department
$grouped_by_dept = [];
foreach ($staff_list as $staff) {
  $dept = !empty($staff['department']) ? $staff['department'] : 'Administrasi Jurusan';
  if (!isset($grouped_by_dept[$dept])) {
    $grouped_by_dept[$dept] = [];
  }
  $grouped_by_dept[$dept][] = $staff;
}

// Order departments neatly matching Figma
$dept_order = ['Akademik', 'PLP', 'Administrasi Jurusan', 'Administrasi BMN', 'Teknisi Jurusan'];
$ordered_depts = [];
foreach ($dept_order as $d) {
  if (isset($grouped_by_dept[$d])) {
    $ordered_depts[$d] = $grouped_by_dept[$d];
  }
}
foreach ($grouped_by_dept as $d => $list) {
  if (!isset($ordered_depts[$d])) {
    $ordered_depts[$d] = $list;
  }
}

// Sort staff members alphabetically (A-Z) by name within each department group
foreach ($ordered_depts as $d => &$list) {
  usort($list, function($a, $b) {
    return strcasecmp($a['name'], $b['name']);
  });
}
unset($list);

// Department display names
$dept_display_names = [
  'Akademik'             => esc_html__('Akademik', 'webjti'),
  'PLP'                  => esc_html__('Pranata Laboratorium Pendidikan (PLP)', 'webjti'),
  'Administrasi Jurusan' => esc_html__('Administrasi Jurusan / Akademik', 'webjti'),
  'Administrasi BMN'     => esc_html__('Administrasi Barang Milik Negara (BMN)', 'webjti'),
  'Teknisi Jurusan'      => esc_html__('Teknisi Jurusan', 'webjti'),
];

// Helper function to render correct badge text
if (!function_exists('get_staff_badge_text')) {
  function get_staff_badge_text($department, $count) {
    if ($department === 'Akademik') {
      return sprintf(_n('%d Admin', '%d Admin', $count, 'webjti'), $count);
    } elseif ($department === 'PLP') {
      return sprintf(_n('%d Pranata', '%d Pranata', $count, 'webjti'), $count);
    } elseif ($department === 'Administrasi BMN') {
      return sprintf(_n('%d Admin', '%d Admin', $count, 'webjti'), $count);
    } elseif ($department === 'Administrasi Jurusan') {
      return sprintf(_n('%d Admin', '%d Admin', $count, 'webjti'), $count);
    } elseif ($department === 'Teknisi Jurusan') {
      return sprintf(_n('%d Teknisi', '%d Teknisi', $count, 'webjti'), $count);
    }
    return sprintf(_n('%d Staff', '%d Staff', $count, 'webjti'), $count);
  }
}

?>

<section class="staff-section" data-node-id="1269:22723">

  <!-- ========================================
     TOP TOOLBAR (FILTER & SEARCH)
  ======================================== -->
  <div class="staff-filter-bar" data-node-id="943:21681">
    
    <!-- Left Segmented Control Options -->
    <div class="filter-list segmented" data-node-id="943:21682">
      <button class="filter-btn active" data-department="all" data-node-id="943:21683">
        <span class="filter-btn-text"><?php esc_html_e('Semua', 'webjti'); ?></span>
      </button>
      <?php foreach (array_keys($ordered_depts) as $dept) : ?>
        <button class="filter-btn" data-department="<?php echo esc_attr($dept); ?>" data-node-id="943:21685">
          <span class="filter-btn-text"><?php echo esc_html($dept); ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Right Custom Search Input -->
    <div class="search-toolbar" data-node-id="943:21693">
      <i class="ph ph-magnifying-glass"></i>
      <input 
        type="text" 
        class="search-input staff-search-input" 
        placeholder="<?php esc_attr_e('Cari Nama atau Jabatan...', 'webjti'); ?>" 
        data-node-id="943:21696"
      >
    </div>

  </div>

  <!-- ========================================
     MODE 1: ALL DEPARTMENTS (SLIDERS VIEW)
  ======================================== -->
  <div class="staff-department-group-wrapper">

    <?php foreach ($ordered_depts as $dept => $dept_staff) : ?>
      <?php $display_name = $dept_display_names[$dept] ?? $dept; ?>

      <div class="staff-department-section" data-department="<?php echo esc_attr($dept); ?>" data-node-id="943:21699">

        <!-- Section Header -->
        <div class="staff-section__header" data-node-id="993:8667">
          
          <div class="staff-section__title-block" data-node-id="993:8668">
            <h2 class="staff-section__title"><?php echo esc_html($display_name); ?></h2>
            <div class="staff-section__badge">
              <span class="staff-section__badge-text" data-total="<?php echo count($dept_staff); ?>" data-dept="<?php echo esc_attr($dept); ?>">
                <?php echo get_staff_badge_text($dept, count($dept_staff)); ?>
              </span>
            </div>
          </div>

          <!-- Slider Nav Arrows -->
          <div class="staff-section__arrows" data-node-id="1274:24231">
            <button class="slider-btn-prev" aria-label="Previous slide">
              <i class="ph ph-arrow-left"></i>
            </button>
            <button class="slider-btn-next" aria-label="Next slide">
              <i class="ph ph-arrow-right"></i>
            </button>
          </div>

        </div>

        <!-- Slider Container with Sneakpeak support -->
        <div class="staff-slider__container">
          
          <div class="staff-slider__track">

            <?php foreach ($dept_staff as $staff_member) : ?>

              <div class="staff-slider__item">
                <?php
                get_template_part(
                  'template-parts/cards/staff-card',
                  null,
                  [
                    'staff' => $staff_member,
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
     MODE 2: INDIVIDUAL DEPARTMENTS (GRID VIEW)
  ======================================== -->
  <div class="staff-department-group-grid-wrapper" style="display: none;">

    <?php foreach ($ordered_depts as $dept => $dept_staff) : ?>
      <?php $display_name = $dept_display_names[$dept] ?? $dept; ?>

      <div class="staff-single-department-wrapper" data-department="<?php echo esc_attr($dept); ?>" style="display: none;">

        <div class="staff-dept-section">

          <!-- Section Header (No Arrows) -->
          <div class="staff-section__header">
            
            <div class="staff-section__title-block">
              <h2 class="staff-section__title"><?php echo esc_html($display_name); ?></h2>
              <div class="staff-section__badge">
                <span class="staff-section__badge-text" data-total="<?php echo count($dept_staff); ?>" data-dept="<?php echo esc_attr($dept); ?>">
                  <?php echo get_staff_badge_text($dept, count($dept_staff)); ?>
                </span>
              </div>
            </div>

          </div>

          <!-- Static 3-Column Grid Layout -->
          <div class="staff-section__grid grid-mode">

            <?php foreach ($dept_staff as $staff_member) : ?>

              <div class="staff-grid__item">
                <?php
                get_template_part(
                  'template-parts/cards/staff-card',
                  null,
                  [
                    'staff' => $staff_member,
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
     NO RESULTS PLACEHOLDER
  ======================================== -->
  <div class="staff-no-results" style="display: none; text-align: center; padding: 60px 24px;">
    <i class="ph ph-users-three" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block;"></i>
    <h3 style="color: var(--neutral-09); margin-bottom: 8px;"><?php esc_html_e('Tidak Ada Hasil', 'webjti'); ?></h3>
    <p style="color: var(--neutral-06);"><?php esc_html_e('Maaf, tidak ada tenaga kependidikan yang sesuai dengan pencarian Anda.', 'webjti'); ?></p>
  </div>

</section>