<?php

$row =
  $args['row'] ?? null;

if (!$row) {
  return;
}

?>

<tr>

  <td class="td-prodi">
    <?php echo esc_html($row['prodi']); ?>
  </td>

  <td class="td-ketua">
    <?php echo esc_html($row['ketua']); ?>
  </td>

  <td class="td-judul">
    <?php echo esc_html($row['judul']); ?>
  </td>

  <td class="td-tahun">

    <span class="badge-tahun">
      <?php echo esc_html($row['tahun']); ?>
    </span>

  </td>

  <td class="td-juara">

    <span class="badge-juara <?php echo esc_attr($row['juara_class']); ?>">
      <?php echo esc_html($row['juara']); ?>
    </span>

  </td>

  <td class="td-tingkat">

    <span class="badge-tingkat <?php echo esc_attr($row['tingkat_class']); ?>">
      <?php echo esc_html($row['tingkat']); ?>
    </span>

  </td>

  <td class="td-aksi">

    <a
      href="<?php echo esc_url($row['url']); ?>"
      class="btn-detail-table"
    >
      Detail
    </a>

  </td>

</tr>