<?php

$slides = [];
for ($i = 1; $i <= 4; $i++) {
  $img = get_theme_mod("jti_hero_image_{$i}");
  if ($img) {
    $slides[] = [
      'image' => $img,
      'title' => 'Slide ' . $i
    ];
  }
}

if (empty($slides)) {
  // Fallback if no images are set
  $slides[] = [
    'image' => get_template_directory_uri() . '/assets/images/campus-placeholder.jpg',
    'title' => 'Default Slide'
  ];
}

$hero_aria_label = 'Selamat Datang';
$hero_strip_label = 'Pilih Slide';

?>

<section
  class="hero-section"
  id="hero-section"
  aria-label="<?php echo esc_attr($hero_aria_label); ?>"
>

  <?php foreach ($slides as $index => $slide) :

    $is_active =
      $index === 0;

  ?>

    <article
      class="hero-slide<?php echo $is_active ? ' is-active' : ''; ?>"
      data-slide="<?php echo esc_attr($index + 1); ?>"
      aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
      style="
        background-image:
        url('<?php echo esc_url($slide['image']); ?>');
        background-size: cover;
        background-position: center;
      "
    >

      <div
        class="hero-slide__overlay"
        aria-hidden="true"
        style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.3)); position: absolute; top: 0; left: 0; right: 0; bottom: 0;"
      ></div>

    </article>

  <?php endforeach; ?>

  <div class="hero-static-content" style="position: absolute; bottom: 10%; left: 5%; z-index: 10; width: 100%; pointer-events: none; padding-bottom: 40px; padding-left: 20px;">
    <div class="hero-slide__meta">
      <h1 class="section-title section-title--hero" style="color: #fff; text-transform: uppercase; font-weight: bold; margin-bottom: 0;">
        <?php echo nl2br(esc_html(get_theme_mod('jti_hero_title', 'SELAMAT DATANG DI JURUSAN TEKNOLOGI INFORMASI'))); ?>
      </h1>
      <p style="color: #fff; font-size: 1.5rem; margin-top: 10px;">
        <?php echo esc_html(get_theme_mod('jti_hero_subtitle', 'Politeknik Negeri Malang')); ?>
      </p>
    </div>
  </div>

  <div
    class="hero-strip"
    id="hero-strip"
    aria-label="<?php echo esc_attr($hero_strip_label); ?>"
  >

    <?php foreach ($slides as $index => $slide) :

      $is_active =
        $index === 0;

    ?>

      <button
        class="hero-thumb<?php echo $is_active ? ' is-active' : ''; ?>"
        data-target="<?php echo esc_attr($index + 1); ?>"
        aria-label="<?php echo esc_attr(
          sprintf(
            __('Tampilkan: %s', 'webjti'),
            $slide['title']
          )
        ); ?>"
        aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>"
        type="button"
      >

        <img
          src="<?php echo esc_url($slide['image']); ?>"
          alt=""
          class="hero-thumb__img"
          loading="lazy"
        >

        <div
          class="hero-thumb__progress-track"
          aria-hidden="true"
        >

          <div class="hero-thumb__progress-fill"></div>

        </div>

      </button>

    <?php endforeach; ?>

  </div>

</section>