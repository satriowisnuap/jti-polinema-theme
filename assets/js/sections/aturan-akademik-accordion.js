/**
 * Aturan Akademik - Accordion JS
 *
 * @package WebJTI_Theme
 */

(function () {
  'use strict';

  function initAturanAkademikAccordion() {
    var accordion = document.getElementById('aturanAkademikAccordion');
    if (!accordion) return;

    if (accordion.getAttribute('data-initialized') === 'true') return;
    accordion.setAttribute('data-initialized', 'true');

    var triggers = accordion.querySelectorAll('.aa-accordion-trigger');

    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        var item   = this.closest('.aa-accordion-item');
        var isOpen = item.classList.contains('aa-accordion-item--open');

        // Close all other open items (single-open accordion)
        accordion.querySelectorAll('.aa-accordion-item--open').forEach(function (openItem) {
          if (openItem !== item) {
            openItem.classList.remove('aa-accordion-item--open');
            var openTrigger = openItem.querySelector('.aa-accordion-trigger');
            if (openTrigger) {
              openTrigger.setAttribute('aria-expanded', 'false');
            }
          }
        });

        // Toggle clicked item
        if (isOpen) {
          item.classList.remove('aa-accordion-item--open');
          this.setAttribute('aria-expanded', 'false');
        } else {
          item.classList.add('aa-accordion-item--open');
          this.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  // Init on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAturanAkademikAccordion);
  } else {
    initAturanAkademikAccordion();
  }

})();
