<?php
/**
 * Lecturer Social Media buttons Section
 * WebJTI Theme (Figma High-Fidelity)
 *
 * @package WebJTI_Theme
 */

$lecturer = $args['lecturer'] ?? null;

$linkedin = $lecturer ? ($lecturer['linkedin'] ?? '') : get_field('linkedin');
$google_scholar = $lecturer ? ($lecturer['google_scholar'] ?? '') : get_field('google_scholar');
$sinta = $lecturer ? ($lecturer['sinta'] ?? '') : get_field('sinta');
$email = $lecturer ? ($lecturer['email'] ?? '') : get_field('email');

$socials = [

  [
    'url' =>
      $linkedin,

    'label' =>
      'LinkedIn',

    'icon' =>
      get_template_directory_uri()
      . '/assets/images/logos/linkedin.png',
  ],

  [
    'url' =>
      $google_scholar,

    'label' =>
      'Google Scholar',

    'icon' =>
      get_template_directory_uri()
      . '/assets/images/logos/google scholar.png',
  ],

  [
    'url' =>
      $sinta,

    'label' =>
      'SINTA',

    'icon' =>
      get_template_directory_uri()
      . '/assets/images/logos/sinta.png',
  ],

  [
    'url' =>
      $email
        ? 'mailto:' . $email
        : '',

    'label' =>
      'Email',

    'icon' =>
      get_template_directory_uri()
      . '/assets/images/logos/gmail.svg',
  ],

];

/*
========================================
FILTER EMPTY ITEMS
========================================
*/

$socials =
  array_filter(
    $socials,
    fn($item) => !empty($item['url'])
  );

if (empty($socials)) {
  return;
}

ob_start();

?>

<div class="lecturer-social" data-node-id="975:5616">

  <div class="lecturer-social__grid" data-node-id="975:5622">

    <?php foreach ($socials as $social) : ?>

      <a
        href="<?php echo esc_url($social['url']); ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="lecturer-social__button"
        data-node-id="975:5649"
      >

        <img
          src="<?php echo esc_url($social['icon']); ?>"
          alt="<?php echo esc_attr($social['label']); ?>"
          class="lecturer-social__icon"
          data-node-id="975:5676"
        >

        <span data-node-id="975:5651">
          <?php
          echo esc_html($social['label']);
          ?>
        </span>

      </a>

    <?php endforeach; ?>

  </div>

</div>

<?php

$content =
  ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [

    'title' =>
      'Sosial Media',

    'icon' =>
      'ph-device-mobile',

    'content' =>
      $content,

  ]
);