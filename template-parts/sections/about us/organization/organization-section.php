<?php
/**
 * Organization Section Template Part
 *
 * @package WebJTI_Theme
 */

$org_data = webjti_get_organization_structure();

$head              = $org_data['head'];
$secretary         = $org_data['secretary'];
$coordinators      = $org_data['coordinators'];
$lab_heads         = $org_data['lab_heads'];
$committees        = $org_data['committees'];
$academic_advisors = $org_data['academic_advisors'];

// Ensure strict accordion behavior: only 1 coordinator panel can be open at a time
$has_opened = false;
foreach ($coordinators as &$coord) {
  if (!empty($coord['is_expanded']) && !$has_opened) {
    $has_opened = true;
    $coord['is_expanded'] = true;
  } else {
    $coord['is_expanded'] = false;
  }
}
unset($coord);

ob_start();
?>

<div class="org-structure-wrapper">
  <div class="org-canvas">

    <div class="org-leadership-tree">
      <!-- Tier 1: Ketua Jurusan (Top Center) -->
      <div class="org-leadership-top">
        <?php $href = !empty($head['lecturer_id']) ? get_permalink($head['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($head['name']) . '/'); ?>
        <a href="<?php echo esc_url($href); ?>" class="org-card org-card--head">
          <div class="org-card__avatar-wrapper">
            <img
              src="<?php echo esc_url($head['photo']); ?>"
              alt="<?php echo esc_attr($head['name']); ?>"
              class="org-card__avatar"
              loading="lazy"
            />
          </div>
          <div class="org-card__details">
            <h3 class="org-card__name"><?php echo esc_html($head['name']); ?></h3>
            <p class="org-card__position"><?php echo esc_html($head['position']); ?></p>
          </div>
        </a>
      </div>

      <!-- Vertical stem line from Ketua Jurusan down to junction -->
      <div class="org-tree-stem-v"></div>

      <!-- Side Staff Junction Row: Sekretaris Jurusan on Left -->
      <div class="org-staff-row">
        <!-- Left Side: Sekretaris Jurusan Card + Horizontal Stem Line -->
        <div class="org-staff-left">
          <?php $href = !empty($secretary['lecturer_id']) ? get_permalink($secretary['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($secretary['name']) . '/'); ?>
          <a href="<?php echo esc_url($href); ?>" class="org-card org-card--secretary">
            <div class="org-card__avatar-wrapper">
              <img
                src="<?php echo esc_url($secretary['photo']); ?>"
                alt="<?php echo esc_attr($secretary['name']); ?>"
                class="org-card__avatar"
                loading="lazy"
              />
            </div>
            <div class="org-card__details">
              <h3 class="org-card__name"><?php echo esc_html($secretary['name']); ?></h3>
              <p class="org-card__position"><?php echo esc_html($secretary['position']); ?></p>
            </div>
          </a>
          <div class="org-tree-stem-h"></div>
        </div>

        <!-- Center Trunk Stem Line -->
        <div class="org-tree-stem-center"></div>

        <!-- Right Side Space (Keeps Layout Perfectly Symmetrical) -->
        <div class="org-staff-right"></div>
      </div>

      <!-- Vertical stem line from junction down to branch selector -->
      <div class="org-tree-stem-v"></div>
    </div>

    <!-- Branch Category Tabs -->
    <div class="org-branch-tabs" role="tablist">
      <button type="button" class="org-tab-btn org-tab-btn--active" data-tab="all">
        <i class="ph ph-squares-four"></i> Semua Unit
      </button>
      <button type="button" class="org-tab-btn" data-tab="prodi">
        <i class="ph ph-graduation-cap"></i> Koordinator Prodi (4)
      </button>
      <button type="button" class="org-tab-btn" data-tab="labs">
        <i class="ph ph-microscope"></i> Kepala Lab (8)
      </button>
      <button type="button" class="org-tab-btn" data-tab="affairs">
        <i class="ph ph-users-three"></i> Kemahasiswaan & TA
      </button>
    </div>

    <!-- Branch 1: Koordinator Program Studi (4 Prodi) -->
    <div class="org-section-branch org-section-branch--prodi" data-branch="prodi">
      <div class="org-branch-header">
        <h4 class="org-branch-title"><i class="ph ph-graduation-cap"></i> Koordinator Program Studi</h4>
      </div>

      <div class="org-grid org-grid--4col">
        <?php foreach ($coordinators as $index => $coord) : 
          $is_expanded = !empty($coord['is_expanded']);
          $coord_id = esc_attr($coord['id']);
          $href = !empty($coord['lecturer_id']) ? get_permalink($coord['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($coord['name']) . '/');
        ?>
          <div class="org-coord-column" data-coord-id="<?php echo $coord_id; ?>">
            <a href="<?php echo esc_url($href); ?>" class="org-card org-card--coord">
              <div class="org-card__avatar-wrapper">
                <img
                  src="<?php echo esc_url($coord['photo']); ?>"
                  alt="<?php echo esc_attr($coord['name']); ?>"
                  class="org-card__avatar"
                  loading="lazy"
                />
              </div>
              <div class="org-card__details">
                <h3 class="org-card__name"><?php echo esc_html($coord['name']); ?></h3>
                <p class="org-card__position"><?php echo esc_html($coord['position']); ?></p>
              </div>
            </a>

            <?php if (!empty($coord['expandable']) || !empty($coord['member_count'])) : ?>
              <button
                type="button"
                class="org-toggle-btn <?php echo $is_expanded ? 'org-toggle-btn--active' : ''; ?>"
                data-target="<?php echo $coord_id; ?>"
                aria-expanded="<?php echo $is_expanded ? 'true' : 'false'; ?>"
              >
                <span class="org-toggle-btn__text"><?php echo esc_html($coord['member_count']); ?> Sub-Jabatan</span>
                <i class="ph <?php echo $is_expanded ? 'ph-caret-up' : 'ph-caret-down'; ?> org-toggle-btn__icon" aria-hidden="true"></i>
              </button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Expanded Panels for Sub-coordinators -->
      <?php foreach ($coordinators as $index => $coord) : 
        if (empty($coord['members'])) continue;
        $is_expanded = !empty($coord['is_expanded']);
        $coord_id = esc_attr($coord['id']);
      ?>
        <div
          class="org-expanded-panel <?php echo $is_expanded ? 'org-expanded-panel--active' : ''; ?>"
          id="panel-<?php echo $coord_id; ?>"
          style="<?php echo $is_expanded ? '' : 'display: none;'; ?>"
        >
          <div class="org-expanded-panel__header">
            <span>Struktur Kelengkapan: <?php echo esc_html($coord['program']); ?></span>
          </div>
          <div class="org-grid org-grid--auto">
            <?php foreach ($coord['members'] as $member) : 
              $href = !empty($member['lecturer_id']) ? get_permalink($member['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($member['name']) . '/');
            ?>
              <a href="<?php echo esc_url($href); ?>" class="org-card org-card--member">
                <div class="org-card__avatar-wrapper">
                  <img
                    src="<?php echo esc_url($member['photo']); ?>"
                    alt="<?php echo esc_attr($member['name']); ?>"
                    class="org-card__avatar"
                    loading="lazy"
                  />
                </div>
                <div class="org-card__details">
                  <h3 class="org-card__name"><?php echo esc_html($member['name']); ?></h3>
                  <p class="org-card__position"><?php echo esc_html($member['position']); ?></p>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Branch 2: Kepala Laboratorium (8 Laboratories) -->
    <div class="org-section-branch org-section-branch--labs" data-branch="labs">
      <div class="org-branch-header">
        <h4 class="org-branch-title"><i class="ph ph-microscope"></i> Kepala Laboratorium Riset & Pembelajaran</h4>
      </div>

      <div class="org-grid org-grid--4col">
        <?php foreach ($lab_heads as $lab) : 
          $href = !empty($lab['lecturer_id']) ? get_permalink($lab['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($lab['name']) . '/');
        ?>
          <a href="<?php echo esc_url($href); ?>" class="org-card org-card--lab">
            <div class="org-card__badge-icon">
              <i class="ph <?php echo esc_attr($lab['icon']); ?>"></i>
            </div>
            <div class="org-card__avatar-wrapper">
              <img
                src="<?php echo esc_url($lab['photo']); ?>"
                alt="<?php echo esc_attr($lab['name']); ?>"
                class="org-card__avatar"
                loading="lazy"
              />
            </div>
            <div class="org-card__details">
              <h3 class="org-card__name"><?php echo esc_html($lab['name']); ?></h3>
              <p class="org-card__position"><?php echo esc_html($lab['position']); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Branch 3: Kemahasiswaan & Tugas Akhir -->
    <div class="org-section-branch org-section-branch--affairs" data-branch="affairs">
      <div class="org-branch-header">
        <h4 class="org-branch-title"><i class="ph ph-users-three"></i> Pembimbing Kemahasiswaan & Majelis Tugas Akhir</h4>
      </div>

      <div class="org-grid org-grid--2col">
        <?php foreach ($committees as $comm) : 
          $href = !empty($comm['lecturer_id']) ? get_permalink($comm['lecturer_id']) : home_url('/tenaga-pengajar/' . sanitize_title($comm['name']) . '/');
        ?>
          <a href="<?php echo esc_url($href); ?>" class="org-card org-card--committee">
            <div class="org-card__avatar-wrapper">
              <img
                src="<?php echo esc_url($comm['photo']); ?>"
                alt="<?php echo esc_attr($comm['name']); ?>"
                class="org-card__avatar"
                loading="lazy"
              />
            </div>
            <div class="org-card__details">
              <h3 class="org-card__name"><?php echo esc_html($comm['name']); ?></h3>
              <p class="org-card__position"><?php echo esc_html($comm['position']); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Branch 4: Dosen Pembimbing Akademik -->
    <div class="org-section-branch org-section-branch--advisors" data-branch="advisors">
      <div class="org-card org-card--banner">
        <div class="org-card__banner-icon">
          <i class="ph ph-chalkboard-teacher"></i>
        </div>
        <div class="org-card__banner-content">
          <h3 class="org-card__banner-title"><?php echo esc_html($academic_advisors['title']); ?></h3>
          <p class="org-card__banner-desc"><?php echo esc_html($academic_advisors['description']); ?></p>
        </div>
      </div>
    </div>

  </div><!-- .org-canvas -->
</div><!-- .org-structure-wrapper -->

<?php
$content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title'              => 'Struktur Organisasi',
    'icon'               => 'ph-tree-structure',
    'content'            => $content,
    'section_slug'       => 'struktur-organisasi',
    'allow_custom_title' => true,
    'allow_custom_icon'  => true,
  ]
);