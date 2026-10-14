<?php

$page_header =
  webjti_get_page_header_data();

$menu_tag =
  $page_header['menu_tag'];

$display_title =
  $page_header['display_title'];

$bg_image_url =
  $page_header['bg_image_url'];

?>

<header
  class="page-header page-header--menu"
  data-bg-url="<?php echo esc_attr($bg_image_url); ?>"
>

  <?php if ($bg_image_url) : ?>

    <div class="page-header-bg">

      <img
        src="<?php echo esc_url($bg_image_url); ?>"
        alt="<?php echo esc_attr($display_title); ?>"
      >

    </div>

  <?php endif; ?>

  <div class="page-header-overlay"></div>

  <div class="container page-header-content">

    <?php if ($menu_tag) : ?>

      <div class="badge badge--hero">

        <span>
          <?php echo esc_html($menu_tag); ?>
        </span>

      </div>

    <?php endif; ?>

    <h1 class="page-title section-title--hero">

      <?php
      echo esc_html($display_title);
      ?>

    </h1>

  </div>

</header>