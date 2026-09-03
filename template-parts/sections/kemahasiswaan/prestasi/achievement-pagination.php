<?php
$max_pages = $args['max_pages'] ?? 1;
$paged     = $args['paged'] ?? 1;

if ($max_pages > 1) : ?>

<div class="prestasi-pagination">

  <div class="page-info">
    <?php echo sprintf(esc_html__('Halaman %d dari %d', 'webjti'), $paged, $max_pages); ?>
  </div>

  <div class="pagination-container">
    <?php
    echo paginate_links([
      'total'     => $max_pages,
      'current'   => $paged,
      'prev_text' => '<i class="ph ph-caret-left"></i>',
      'next_text' => '<i class="ph ph-caret-right"></i>',
    ]);
    ?>
  </div>

</div>

<?php endif; ?>