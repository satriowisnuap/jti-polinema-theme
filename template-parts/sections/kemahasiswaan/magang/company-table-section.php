<?php
/**
 * Company Table Section (Perusahaan Magang)
 *
 * @package WebJTI_Theme
 */

$paged  = isset($_GET['company_paged']) ? max(1, intval($_GET['company_paged'])) : 1;
$search = isset($_GET['company_search']) ? sanitize_text_field($_GET['company_search']) : '';

$result      = webjti_get_company_partners($search, $paged, 5);
$companies   = $result['rows'];
$max_pages   = $result['max_pages'];
$total_items = $result['total'];

ob_start();
?>

<div class="company-table-section">

  <!-- Search Toolbar -->
  <div class="company-search-toolbar" style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
    <form method="GET" action="" class="company-search-form">
      
      <?php foreach ($_GET as $key => $val) : ?>
        <?php if (!in_array($key, ['company_search', 'company_paged'], true)) : ?>
          <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val); ?>">
        <?php endif; ?>
      <?php endforeach; ?>

      <div class="company-search-input-wrapper" style="position: relative; display: flex; align-items: center; max-width: 350px; width: 100%;">
        <i class="ph ph-magnifying-glass" style="position: absolute; left: 12px; color: var(--neutral-05);"></i>
        <input
          type="text"
          name="company_search"
          value="<?php echo esc_attr($search); ?>"
          placeholder="Cari nama perusahaan, bidang, atau lokasi..."
          class="company-search-input"
          autocomplete="off"
          style="width: 100%; padding: 10px 12px 10px 36px; border: 1px solid var(--neutral-03); border-radius: 6px;"
        >
      </div>

    </form>
  </div>

  <!-- Tabular Data Wrapper -->
  <div class="tabular-data-wrapper" style="overflow-x: auto; margin-bottom: 20px;">
    <table class="tabular-data-table" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: var(--neutral-01, #FAFAF9); border-bottom: 2px solid var(--neutral-03, #E7E5E4);">
          <th style="padding: 12px 16px; text-align: center; width: 60px; font-weight: 600; font-size: 13px; color: var(--neutral-08, #44403B);">NO</th>
          <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 13px; color: var(--neutral-08, #44403B);">Nama Perusahaan</th>
          <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 13px; color: var(--neutral-08, #44403B);">Bidang Industri</th>
          <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 13px; color: var(--neutral-08, #44403B);">Lokasi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($companies)) : ?>
          <?php foreach ($companies as $i => $item) : ?>
            <?php
            $row_no = (($paged - 1) * 5) + ($i + 1);
            ?>
            <tr style="border-bottom: 1px solid var(--neutral-02, #F5F5F4); transition: background 0.2s ease;">
              <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: var(--neutral-06, #79716B); font-weight: 500;">
                <?php echo esc_html(sprintf('%02d', $row_no)); ?>
              </td>
              <td style="padding: 14px 16px; font-size: 14px; font-weight: 600; color: var(--neutral-10, #1C1917);">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <span><?php echo esc_html($item['name']); ?></span>
                </div>
              </td>
              <td style="padding: 14px 16px; font-size: 14px; color: var(--neutral-07, #57534D);">
                <?php echo esc_html($item['category']); ?>
              </td>
              <td style="padding: 14px 16px; font-size: 14px; color: var(--neutral-07, #57534D);">
                <div style="display: inline-flex; align-items: center; gap: 4px;">
                  <i class="ph ph-map-pin" style="color: var(--neutral-05);"></i>
                  <span><?php echo esc_html($item['location']); ?></span>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="4" style="text-align: center; padding: 48px 16px; color: var(--neutral-05, #A6A09B);">
              <i class="ph ph-buildings" style="font-size: 40px; display: block; margin-bottom: 8px;"></i>
              <span>Tidak ada data perusahaan yang sesuai dengan pencarian Anda.</span>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination Controls -->
  <?php if ($max_pages > 1) : ?>
    <div class="company-pagination" style="display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 12px; border-top: 1px solid var(--neutral-02, #F5F5F4);">
      
      <div style="font-size: 13px; color: var(--neutral-06, #79716B);">
        Menampilkan Halaman <strong><?php echo esc_html($paged); ?></strong> dari <strong><?php echo esc_html($max_pages); ?></strong> (Total <?php echo esc_html($total_items); ?> perusahaan)
      </div>

      <div class="pagination-links" style="display: flex; gap: 6px;">
        <?php if ($paged > 1) : ?>
          <?php
          $prev_url = add_query_arg(['company_paged' => $paged - 1, 'company_search' => $search]);
          ?>
          <a href="<?php echo esc_url($prev_url); ?>" class="page-link-btn" style="padding: 6px 12px; border: 1px solid var(--neutral-03); border-radius: 6px; text-decoration: none; color: var(--neutral-08); font-size: 13px;">
            <i class="ph ph-caret-left"></i> Sebelumnya
          </a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $max_pages; $p++) : ?>
          <?php
          $page_url = add_query_arg(['company_paged' => $p, 'company_search' => $search]);
          $is_current = ($p === $paged);
          ?>
          <a href="<?php echo esc_url($page_url); ?>" class="page-link-btn <?php echo $is_current ? 'active' : ''; ?>" style="padding: 6px 12px; border: 1px solid <?php echo $is_current ? 'var(--blue-07)' : 'var(--neutral-03)'; ?>; background: <?php echo $is_current ? 'var(--blue-07)' : '#ffffff'; ?>; color: <?php echo $is_current ? '#ffffff' : 'var(--neutral-08)'; ?>; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">
            <?php echo esc_html($p); ?>
          </a>
        <?php endfor; ?>

        <?php if ($paged < $max_pages) : ?>
          <?php
          $next_url = add_query_arg(['company_paged' => $paged + 1, 'company_search' => $search]);
          ?>
          <a href="<?php echo esc_url($next_url); ?>" class="page-link-btn" style="padding: 6px 12px; border: 1px solid var(--neutral-03); border-radius: 6px; text-decoration: none; color: var(--neutral-08); font-size: 13px;">
            Selanjutnya <i class="ph ph-caret-right"></i>
          </a>
        <?php endif; ?>
      </div>

    </div>
  <?php endif; ?>

</div>

<?php
$table_content = ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [
    'title'              => 'Daftar Perusahaan & Mitra Magang:',
    'icon'               => 'ph-buildings',
    'content'            => $table_content,
    'section_slug'       => 'perusahaan-magang',
    'allow_custom_title' => true,
    'allow_custom_icon'  => true,
  ]
);
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.company-search-input');
    const form = document.querySelector('.company-search-form');
    
    if (searchInput) {
        let timeout = null;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                const url = new URL(window.location.href);
                url.searchParams.set('company_search', searchInput.value);
                url.searchParams.set('company_paged', 1);
                
                // Update URL without reload
                window.history.pushState({}, '', url);
                
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Replace table
                        const newTable = doc.querySelector('.tabular-data-wrapper');
                        const currentTable = document.querySelector('.tabular-data-wrapper');
                        if (newTable && currentTable) {
                            currentTable.innerHTML = newTable.innerHTML;
                        }
                        
                        // Replace pagination
                        const newPagination = doc.querySelector('.company-pagination');
                        const currentPagination = document.querySelector('.company-pagination');
                        
                        if (newPagination) {
                            if (currentPagination) {
                                currentPagination.innerHTML = newPagination.innerHTML;
                            } else {
                                currentTable.after(newPagination);
                            }
                        } else if (currentPagination) {
                            currentPagination.remove();
                        }
                    });
            }, 300); // 300ms debounce
        });

        // Prevent form submission since it's realtime
        form.addEventListener('submit', function(e) {
            e.preventDefault();
        });
        
        // Focus input and set cursor to end if it has value on load
        if (searchInput.value) {
            const val = searchInput.value;
            searchInput.focus();
            searchInput.value = '';
            searchInput.value = val;
        }
    }
});
</script>
