<?php
/**
 * The template for displaying Ormawa Archive pages
 * Halaman daftar semua Organisasi Kemahasiswaan
 *
 * @package WebJTI_Theme
 */

get_header();

?>

<main id="primary" class="site-main ormawa-archive-page">

  <?php
  /*
  ==================================================
  PAGE HEADER
  ==================================================
  */
  get_template_part(
      'template-parts/components/page-header'
  );
  ?>

  <div class="container container--wide">

    <div class="page-layout with-sidebar">

      <?php
      /*
      ==================================================
      SIDEBAR NAVIGATION
      ==================================================
      */
      get_template_part(
          'template-parts/components/sidebar/sidebar'
      );
      ?>

      <div class="page-content ormawa-archive-content">

        <?php
        /*
        ==================================================
        DAFTAR ORMAWA — WRAPPED IN CONTENT-BLOCK
        ==================================================
        */
        ob_start();
        ?>

        <?php if (have_posts()) : ?>

          <div class="ormawa-archive-grid">
            <?php
            while (have_posts()) :
              the_post();
              get_template_part('template-parts/cards/ormawa-card');
            endwhile;
            ?>
          </div>

          <?php
          // Pagination
          the_posts_pagination([
            'prev_text' => '<i class="ph ph-arrow-left"></i> Sebelumnya',
            'next_text' => 'Selanjutnya <i class="ph ph-arrow-right"></i>',
            'class'     => 'pagination-container',
          ]);
          ?>

        <?php else : ?>

          <div class="ormawa-archive-empty">
            <i class="ph ph-users-three ormawa-archive-empty__icon"></i>
            <h2 class="ormawa-archive-empty__title">Belum ada Organisasi Kemahasiswaan</h2>
            <p class="ormawa-archive-empty__text">Data organisasi mahasiswa belum ditambahkan.</p>
          </div>

        <?php endif; ?>

        <?php
        $ormawa_content = ob_get_clean();

        get_template_part(
          'template-parts/components/content-block',
          null,
          [
            'title'              => 'Daftar Organisasi Kemahasiswaan',
            'icon'               => 'ph-users-three',
            'content'            => $ormawa_content,
            'section_slug'       => 'daftar-ormawa',
            'allow_custom_title' => true,
            'allow_custom_icon'  => true,
            'class'              => 'ormawa-list-block',
          ]
        );
        ?>

      </div><!-- .page-content -->

    </div><!-- .page-layout -->

  </div><!-- .container -->

</main>

<?php get_footer(); ?>
