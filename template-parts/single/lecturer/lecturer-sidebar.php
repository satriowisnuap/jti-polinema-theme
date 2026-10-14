<?php
/**
 * Lecturer Sidebar Summary Card
 * WebJTI Theme (Figma High-Fidelity)
 *
 * @package WebJTI_Theme
 */

$lecturer = $args['lecturer'] ?? null;

if (!$lecturer) {
  return;
}

$photo_url = !empty($lecturer['photo']) ? $lecturer['photo'] : '';
$name = !empty($lecturer['name']) ? $lecturer['name'] : '';
$position = !empty($lecturer['position']) ? $lecturer['position'] : 'Tenaga Pengajar';
$study_program = !empty($lecturer['study_program']) ? $lecturer['study_program'] : '-';
$nip = !empty($lecturer['nip']) ? $lecturer['nip'] : '-';
$nidn = !empty($lecturer['nidn']) ? $lecturer['nidn'] : '-';
$laboratory = !empty($lecturer['laboratory']) ? $lecturer['laboratory'] : '-';
$email = !empty($lecturer['email']) ? $lecturer['email'] : '-';
$office_address = !empty($lecturer['office_address']) ? $lecturer['office_address'] : '-';
$website = !empty($lecturer['website']) ? $lecturer['website'] : '-';

?>

<aside class="lecturer-sidebar" data-node-id="973:5519">

  <!-- Header section with gold circular avatar background -->
  <div class="lecturer-sidebar__header" data-node-id="973:5520">
  
    <div class="lecturer-sidebar__photo-frame" data-node-id="973:5549">
      <?php if (!empty($photo_url)) : ?>
        <img
          src="<?php echo esc_url($photo_url); ?>"
          alt="<?php echo esc_attr($name); ?>"
          data-node-id="973:5550"
        >
      <?php else : ?>
        <div class="lecturer-sidebar__photo-placeholder">
          <i class="ph ph-user" aria-hidden="true"></i>
        </div>
      <?php endif; ?>
    </div>

    <h1 class="lecturer-sidebar__name-text" data-node-id="975:5577">
      <?php echo esc_html($name); ?>
    </h1>

  </div>

  <!-- Body section with full meta list -->
  <div class="lecturer-sidebar__body" data-node-id="973:5523">
  
    <div class="lecturer-sidebar__meta-group" data-node-id="973:5525">
    
      <?php if ($nip && $nip !== '-') : ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="973:5526">
          <span class="lecturer-sidebar__detail-label" data-node-id="973:5527">NIP</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="973:5528"><?php echo esc_html($nip); ?></span>
        </div>
      <?php endif; ?>

      <?php if ($nidn && $nidn !== '-') : ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="973:5529">
          <span class="lecturer-sidebar__detail-label" data-node-id="973:5530">NIDN</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="973:5531"><?php echo esc_html($nidn); ?></span>
        </div>
      <?php endif; ?>

      <div class="lecturer-sidebar__detail-item" data-node-id="973:5532">
        <span class="lecturer-sidebar__detail-label" data-node-id="973:5533">JABATAN</span>
        <span class="lecturer-sidebar__detail-val" data-node-id="973:5534"><?php echo esc_html($position); ?></span>
      </div>

      <div class="lecturer-sidebar__detail-item" data-node-id="973:5535">
        <span class="lecturer-sidebar__detail-label" data-node-id="973:5536">PROGRAM STUDI</span>
        <span class="lecturer-sidebar__detail-val" data-node-id="973:5537"><?php echo esc_html($study_program); ?></span>
      </div>

      <?php 
      $lab_name = !empty($laboratory) ? trim($laboratory) : '';
      if (!empty($lab_name) && $lab_name !== '-' && strtolower($lab_name) !== 'tidak ada') : 
        $laboratory_url = !empty($lecturer['laboratory_url']) ? $lecturer['laboratory_url'] : (function_exists('webjti_get_lecturer_laboratory_url') ? webjti_get_lecturer_laboratory_url($lecturer['id'] ?? get_the_ID()) : '');
      ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="1302:3558">
          <span class="lecturer-sidebar__detail-label" data-node-id="1302:3559">LABORATORIUM</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="1302:3560">
            <?php if (!empty($laboratory_url)) : ?>
              <a href="<?php echo esc_url($laboratory_url); ?>"><?php echo esc_html($lab_name); ?></a>
            <?php else : ?>
              <?php echo esc_html($lab_name); ?>
            <?php endif; ?>
          </span>
        </div>
      <?php endif; ?>

    </div>

    <div class="lecturer-sidebar__meta-divider" data-node-id="973:5538"></div>

    <div class="lecturer-sidebar__meta-group" data-node-id="975:5587">

      <?php if ($email && $email !== '-') : ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="975:5601">
          <span class="lecturer-sidebar__detail-label" data-node-id="975:5602">EMAIL</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="975:5603">
            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
          </span>
        </div>
      <?php endif; ?>

      <?php if ($office_address && $office_address !== '-') : ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="975:5608">
          <span class="lecturer-sidebar__detail-label" data-node-id="975:5609">ALAMAT KANTOR</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="975:5610"><?php echo esc_html($office_address); ?></span>
        </div>
      <?php endif; ?>

      <?php if ($website && $website !== '-') : ?>
        <div class="lecturer-sidebar__detail-item" data-node-id="975:5594">
          <span class="lecturer-sidebar__detail-label" data-node-id="975:5595">WEBSITE</span>
          <span class="lecturer-sidebar__detail-val" data-node-id="975:5596">
            <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($website); ?></a>
          </span>
        </div>
      <?php endif; ?>

    </div>

  </div>

</aside>
