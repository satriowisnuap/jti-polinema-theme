/* ========================================
   SEARCH TOOLBAR
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const searchInputs =
    document.querySelectorAll('.search-input');

  if (!searchInputs.length) return;

  searchInputs.forEach((input) => {

    input.addEventListener('input', () => {

      const query =
        input.value.toLowerCase().trim();

      const cards =
        document.querySelectorAll('.search-card');

      cards.forEach((card) => {

        const searchableText =
          card.textContent.toLowerCase();

        const isVisible =
          searchableText.includes(query);

        card.style.display =
          isVisible ? '' : 'none';

      });

    });

  });

});