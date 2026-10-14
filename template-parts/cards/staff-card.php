<?php
/**
 * Staff Card Template
 * WebJTI Theme (Figma High-Fidelity)
 *
 * @package WebJTI_Theme
 */

$staff = $args['staff'] ?? null;

if (!$staff) {
  return;
}

?>

<article class="staff-card" data-node-id="1678:29974" data-name="Program Card 5">

  <div class="staff-card__inner">

    <!-- Avatar and Identity Header -->
    <div class="staff-card__top-area">

      <div class="staff-card__avatar-circle">

        <div class="staff-card__avatar-image">

          <img 
            src="<?php echo esc_url($staff['photo']); ?>" 
            alt="<?php echo esc_attr($staff['name']); ?>" 
            class="staff-card__img"
          >

        </div>

      </div>

      <div class="staff-card__identity">

        <h3 class="staff-card__name">

          <?php echo esc_html($staff['name']); ?>

        </h3>

        <?php if (!empty($staff['department']) && $staff['department'] !== '-') : ?>
          <p class="staff-card__position">

            <?php echo esc_html($staff['department']); ?>

          </p>
        <?php endif; ?>

      </div>

    </div>

    <!-- Separator Divider -->
    <div class="staff-card__divider"></div>

    <!-- NIP Details -->
    <div class="staff-card__meta-row">

      <span class="staff-card__meta-label">NIP</span>

      <span class="staff-card__meta-val">

        <?php echo esc_html($staff['nip']); ?>

      </span>

    </div>

  </div>

</article>