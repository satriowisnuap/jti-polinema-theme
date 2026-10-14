<?php
/**
 * Member Card Component
 *
 * @package WebJTI_Theme
 */

$member = $args['member'] ?? null;

if (!$member) {
  return;
}

$role_class = str_replace('_', '-', strtolower($member['role'] ?? 'anggota'));
?>

<article class="member-card">

  <div class="member-card__header">

    <div class="member-card__avatar">
      <div class="member-card__avatar-frame">
        <img
          src="<?php echo esc_url($member['photo']); ?>"
          alt="<?php echo esc_attr($member['name']); ?>"
        >
      </div>
    </div>

    <span class="member-card__badge <?php echo esc_attr($role_class); ?>">
      <?php echo esc_html($member['role_label'] ?? 'Anggota'); ?>
    </span>

  </div>

  <div class="member-card__footer">

    <div class="member-card__info">

      <h3 class="member-card__name">
        <?php echo esc_html($member['name']); ?>
      </h3>

      <p class="member-card__id">
        <?php echo esc_html($member['identifier']); ?>
      </p>

    </div>

    <?php if (!empty($member['linkedin'])) : ?>

      <a
        href="<?php echo esc_url($member['linkedin']); ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="member-card__linkedin"
        aria-label="LinkedIn Profile"
      >
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logos/linkedin.png'); ?>"
          alt="LinkedIn"
          style="width: 20px; height: 20px; object-fit: contain; display: block;"
        >
      </a>

    <?php else : ?>
      
      <div class="member-card__linkedin member-card__linkedin--disabled">
        <img
          src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logos/linkedin.png'); ?>"
          alt="LinkedIn"
          style="width: 20px; height: 20px; object-fit: contain; display: block; filter: grayscale(1); opacity: 0.5;"
        >
      </div>

    <?php endif; ?>

  </div>

</article>