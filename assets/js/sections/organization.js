/**
 * Organization Structure Section Interactivity
 *
 * @package WebJTI_Theme
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Accordion Toggle Sub-positions (Only 1 active panel allowed at a time)
  const toggleButtons = document.querySelectorAll('.org-toggle-btn');
  const panels = document.querySelectorAll('.org-expanded-panel');

  if (toggleButtons.length) {
    toggleButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        const targetId = btn.getAttribute('data-target');
        if (!targetId) return;

        const targetPanel = document.getElementById('panel-' + targetId);
        const isCurrentlyExpanded = btn.classList.contains('org-toggle-btn--active');

        // Close ALL other open toggle buttons & panels
        toggleButtons.forEach(function (otherBtn) {
          otherBtn.classList.remove('org-toggle-btn--active');
          otherBtn.setAttribute('aria-expanded', 'false');
          const otherIcon = otherBtn.querySelector('.org-toggle-btn__icon');
          if (otherIcon) {
            otherIcon.classList.remove('ph-caret-up');
            otherIcon.classList.add('ph-caret-down');
          }
        });

        panels.forEach(function (otherPanel) {
          otherPanel.style.display = 'none';
          otherPanel.classList.remove('org-expanded-panel--active');
        });

        // Open ONLY the clicked panel if it was not open previously
        if (!isCurrentlyExpanded) {
          btn.classList.add('org-toggle-btn--active');
          btn.setAttribute('aria-expanded', 'true');
          const icon = btn.querySelector('.org-toggle-btn__icon');
          if (icon) {
            icon.classList.remove('ph-caret-down');
            icon.classList.add('ph-caret-up');
          }
          if (targetPanel) {
            targetPanel.style.display = 'block';
            targetPanel.classList.add('org-expanded-panel--active');
          }
        }
      });
    });
  }

  // 2. Branch Category Tabs Filtering
  const tabButtons = document.querySelectorAll('.org-tab-btn');
  const branches = document.querySelectorAll('.org-section-branch');

  if (tabButtons.length && branches.length) {
    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        const targetTab = btn.getAttribute('data-tab');
        if (!targetTab) return;

        // Update active tab button state
        tabButtons.forEach(function (b) {
          b.classList.remove('org-tab-btn--active');
        });
        btn.classList.add('org-tab-btn--active');

        // Show/hide branches
        branches.forEach(function (branch) {
          const branchCategory = branch.getAttribute('data-branch');
          if (targetTab === 'all' || branchCategory === targetTab) {
            branch.style.display = 'block';
          } else {
            branch.style.display = 'none';
          }
        });
      });
    });
  }
});
