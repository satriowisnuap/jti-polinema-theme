/* ========================================
   FILTER TOOLBAR
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const filterButtons =
    document.querySelectorAll('.filter-btn');

  if (!filterButtons.length) return;

  filterButtons.forEach((button) => {

    button.addEventListener('click', () => {

      const filterValue =
        button.dataset.filter ||
        button.dataset.campus;

      /* Active State */
      filterButtons.forEach((btn) => {
        btn.classList.remove('active');
      });

      button.classList.add('active');

      /* Filter Target */
      const groups = document.querySelectorAll(
        '[data-filter-slug], [data-campus-slug]'
      );

      groups.forEach((group) => {

        const groupValue =
          group.dataset.filterSlug ||
          group.dataset.campusSlug;

        const isVisible =
          filterValue === 'semua' ||
          filterValue === groupValue;

        group.style.display =
          isVisible ? '' : 'none';

      });

    });

  });

});