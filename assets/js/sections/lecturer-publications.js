document.addEventListener('DOMContentLoaded', () => {

  const sections = document.querySelectorAll('[data-publications]');

  sections.forEach(section => {

    const grid = section.querySelector('[data-publication-grid]');
    if (!grid) return;

    const tabs = section.querySelectorAll('.filter-list.segmented .filter-btn');

    // Preserve wrapper items (.slider-item or .publication-card)
    let items = Array.from(grid.children);
    if (!items.length) return;

    /*
    ========================================
    SORTING & DYNAMIC BADGE TOGGLE
    ========================================
    */

    const sortCards = type => {
      const sorted = [...items];

      sorted.sort((a, b) => {
        const cardA = a.classList.contains('publication-card') ? a : (a.querySelector('.publication-card') || a);
        const cardB = b.classList.contains('publication-card') ? b : (b.querySelector('.publication-card') || b);

        const valA = Number(type === 'citations' ? (cardA.dataset.citations || 0) : (cardA.dataset.year || 0));
        const valB = Number(type === 'citations' ? (cardB.dataset.citations || 0) : (cardB.dataset.year || 0));

        return type === 'oldest' ? (valA - valB) : (valB - valA);
      });

      // Toggle badges visibility
      const hideCitationsBadges = (type === 'latest' || type === 'oldest');

      items.forEach(item => {
        const card = item.classList.contains('publication-card') ? item : (item.querySelector('.publication-card') || item);
        const highlightBadge = card.querySelector('.badge--section, .publication-card__badge--highlight');
        const neutralBadge = card.querySelector('.publication-card__badge--neutral');

        if (hideCitationsBadges) {
          if (highlightBadge) highlightBadge.style.display = 'none';
          if (neutralBadge) neutralBadge.style.display = 'none';
        } else {
          if (highlightBadge) highlightBadge.style.display = 'inline-flex';
          if (neutralBadge) neutralBadge.style.display = 'inline-flex';
        }
      });

      grid.innerHTML = '';

      sorted.forEach(item => {
        grid.appendChild(item);
      });
    };

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        sortCards(tab.dataset.sort);
      });
    });

    sortCards('citations');

  });

});