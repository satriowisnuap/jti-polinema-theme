<div
  class="nav-search-bar"
  id="nav-search-bar"
  aria-hidden="true"
>

  <div class="nav-inner">

    <form
      role="search"
      method="get"
      action="<?php echo esc_url(home_url('/')); ?>"
      class="nav-search-form"
    >

      <label
        for="nav-search-input"
        class="screen-reader-text"
      >
        <?php esc_html_e('Cari:', 'webjti-theme'); ?>
      </label>

      <input
        type="search"
        id="nav-search-input"
        class="nav-search-input"
        placeholder="<?php esc_attr_e(
          'Cari di JTI Polinema...',
          'webjti-theme'
        ); ?>"
        value="<?php echo get_search_query(); ?>"
        name="s"
        autocomplete="off"
      >

      <button
        type="submit"
        class="nav-search-submit"
        aria-label="<?php esc_attr_e(
          'Cari',
          'webjti-theme'
        ); ?>"
      >

        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >

          <circle
            cx="8.5"
            cy="8.5"
            r="5.75"
            stroke="currentColor"
            stroke-width="1.5"
          />

          <path
            d="M13 13L17 17"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
          />

        </svg>

      </button>

    </form>

    <button
      class="nav-search-close"
      id="nav-search-close"
      aria-label="<?php esc_attr_e(
        'Tutup Pencarian',
        'webjti-theme'
      ); ?>"
      type="button"
    >

      <svg
        width="20"
        height="20"
        viewBox="0 0 20 20"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >

        <path
          d="M5 5L15 15M15 5L5 15"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
        />

      </svg>

    </button>

  </div>

</div>