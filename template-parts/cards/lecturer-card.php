<?php
/**
 * Lecturer Card Template
 * WebJTI Theme
 *
 * @package WebJTI_Theme
 */

$lecturer = $args['lecturer'] ?? null;

if (!$lecturer) {
  return;
}

// Retrieve the study program robustly with correct fallbacks (handling ACF Post Object 'study_program' field)
$study_program_name = '';
$study_program_field = get_field('study_program', $lecturer['id']);

if ($study_program_field) {
  if (is_object($study_program_field)) {
    $study_program_name = $study_program_field->post_title;
  } elseif (is_numeric($study_program_field)) {
    $study_program_name = get_the_title($study_program_field);
  } elseif (is_array($study_program_field)) {
    $study_program_name = isset($study_program_field['post_title']) 
      ? $study_program_field['post_title'] 
      : get_the_title($study_program_field['ID'] ?? ($study_program_field['id'] ?? 0));
  } else {
    $study_program_name = $study_program_field;
  }
}

if (empty($study_program_name)) {
  $study_program_name = get_field('program_studi', $lecturer['id']) 
    ?: ($lecturer['study_program'] ?? ($lecturer['title'] ?? '-'));
}

// Format the display title (e.g. "Dosen D4 Teknik Informatika")
$study_program = $study_program_name;
if ($study_program !== '-' && stripos($study_program, 'dosen') === false) {
  $study_program = 'Dosen ' . $study_program;
}

?>

<article class="lecturer-card" data-node-id="1274:23738" data-name="Card 3">

  <div class="lecturer-card__inner" data-node-id="1274:23739" data-name="Program Card 5">

    <!-- Avatar and Identity Header -->
    <div class="lecturer-card__top-area" data-node-id="1274:23740">

      <div class="lecturer-card__avatar-circle" data-node-id="1274:23741">

        <div class="lecturer-card__avatar-image" data-node-id="1274:23742" data-name="image 132">

          <img 
            src="<?php echo esc_url($lecturer['photo']); ?>" 
            alt="<?php echo esc_attr($lecturer['name']); ?>" 
            class="lecturer-card__img"
          >

        </div>

      </div>

      <div class="lecturer-card__identity" data-node-id="1274:23743" data-name="Program Card 2 Content">

        <h3 class="lecturer-card__name" data-node-id="1274:23744">

          <?php echo esc_html($lecturer['name']); ?>

        </h3>

        <p class="lecturer-card__study-program" data-node-id="1274:23745">

          <?php echo esc_html($study_program); ?>

        </p>

      </div>

    </div>

    <!-- Separator Divider -->
    <div class="lecturer-card__divider" data-node-id="1274:23747"></div>

    <!-- Metadata Grid Details -->
    <div class="lecturer-card__details-grid" data-node-id="1274:23748">

      <!-- NIP & NIDN Columns -->
      <div class="lecturer-card__meta-row" data-node-id="1274:23749">

        <div class="lecturer-card__meta-col" data-node-id="1274:23750">

          <span class="lecturer-card__meta-label" data-node-id="1274:23751">NIP</span>

          <span class="lecturer-card__meta-val" data-node-id="1274:23752">

            <?php echo esc_html($lecturer['nip']); ?>

          </span>

        </div>

        <div class="lecturer-card__meta-col" data-node-id="1274:23753">

          <span class="lecturer-card__meta-label" data-node-id="1274:23754">NIDN</span>

          <span class="lecturer-card__meta-val" data-node-id="1274:23755">

            <?php echo esc_html($lecturer['nidn']); ?>

          </span>

        </div>

      </div>

      <!-- Bidang Keahlian Row -->
      <div class="lecturer-card__skills" data-node-id="1274:23756">

        <span class="lecturer-card__meta-label" data-node-id="1274:23757">

          <?php esc_html_e('Bidang Keahlian', 'webjti'); ?>

        </span>

        <div class="lecturer-card__tags-row" data-node-id="1274:23758">

          <?php if (!empty($lecturer['skills'])) : ?>

            <?php foreach ($lecturer['skills'] as $skill) : ?>

              <span class="staff-tag">

                <?php echo esc_html($skill); ?>

              </span>

            <?php endforeach; ?>

            <!-- The dynamic more badge, populated and toggled by JS -->
            <div class="tag-more" style="display: none;" data-node-id="1302:3574" data-name="Badge">

              <div aria-hidden="true" class="tag-more-bg"></div>

              <span class="tag-more-text"></span>

              <!-- Hover Tooltip Popup for overflow skills -->
              <div class="expertise-tooltip">

                <span class="expertise-tooltip__title">

                  <?php esc_html_e('Keahlian Lainnya', 'webjti'); ?>

                </span>

                <ul class="expertise-tooltip__list"></ul>

              </div>

            </div>

          <?php else : ?>

            <span class="lecturer-card__empty">

              <?php esc_html_e('Belum ditentukan', 'webjti'); ?>

            </span>

          <?php endif; ?>

        </div>

      </div>

      <!-- Laboratorium Row -->
      <?php 
      $lab_name = !empty($lecturer['laboratory']) ? trim($lecturer['laboratory']) : '';
      if (!empty($lab_name) && $lab_name !== '-' && strtolower($lab_name) !== 'tidak ada') : 
        $lab_url = !empty($lecturer['laboratory_url']) ? $lecturer['laboratory_url'] : (function_exists('webjti_get_lecturer_laboratory_url') ? webjti_get_lecturer_laboratory_url($lecturer['id']) : '');
      ?>
        <div class="lecturer-card__lab" data-node-id="1302:3554">

          <span class="lecturer-card__meta-label" data-node-id="1302:3555">

            <?php esc_html_e('Laboratorium', 'webjti'); ?>

          </span>

          <p class="lecturer-card__lab-val" data-node-id="1302:3556">

            <?php if (!empty($lab_url)) : ?>
              <a href="<?php echo esc_url($lab_url); ?>"><?php echo esc_html($lab_name); ?></a>
            <?php else : ?>
              <?php echo esc_html($lab_name); ?>
            <?php endif; ?>

          </p>

        </div>
      <?php endif; ?>

    </div>

  </div>

  <!-- Footer Action Button -->
  <a 
    href="<?php echo esc_url($lecturer['permalink']); ?>" 
    class="lecturer-card__footer" 
    data-node-id="1274:23762" 
    data-name="Program Card 1 Button"
  >

    <div class="lecturer-card__footer-content" data-node-id="1274:23763" data-name="Button">

      <span class="lecturer-card__footer-text" data-node-id="1274:23765">

        <?php esc_html_e('Lihat Detail', 'webjti'); ?>

      </span>

      <div class="lecturer-card__footer-icon" data-node-id="1274:23766" data-name="ArrowUpRight">

        <i class="ph ph-arrow-up-right"></i>

      </div>

    </div>

  </a>

</article>