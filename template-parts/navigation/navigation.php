<nav
  id="site-navigation"
  class="main-navigation"
  aria-label="Navigasi Utama"
>

  <div class="nav-inner">

    <?php
    get_template_part(
      'template-parts/navigation/navigation-brand'
    );
    ?>

    <?php
    get_template_part(
      'template-parts/navigation/navigation-menu'
    );
    ?>

    <?php
    get_template_part(
      'template-parts/navigation/navigation-actions'
    );
    ?>

  </div>

  <?php
  get_template_part(
    'template-parts/navigation/navigation-search'
  );
  ?>

  <?php
  get_template_part(
    'template-parts/navigation/mobile-navigation'
  );
  ?>

</nav>