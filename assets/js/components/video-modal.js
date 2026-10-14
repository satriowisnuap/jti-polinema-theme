/* ========================================
   VIDEO MODAL
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const modal =
    document.getElementById('videoModal');

  if (!modal) return;

  const iframe =
    modal.querySelector('iframe');

  const closeButton =
    modal.querySelector(
      '.video-modal-close'
    );

  const triggerButtons =
    document.querySelectorAll(
      '[data-video-id]'
    );

  if (!iframe || !closeButton)
    return;

  /* ========================================
     OPEN MODAL
  ======================================== */

  const openModal = (videoId) => {

    const videoUrl =
      `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;

    iframe.src = videoUrl;

    modal.classList.add('active');

    document.body.style.overflow =
      'hidden';

  };

  /* ========================================
     CLOSE MODAL
  ======================================== */

  const closeModal = () => {

    modal.classList.remove(
      'active'
    );

    iframe.src = '';

    document.body.style.overflow =
      '';

  };

  /* ========================================
     TRIGGERS
  ======================================== */

  triggerButtons.forEach((button) => {

    button.addEventListener(
      'click',
      () => {

        const videoId =
          button.dataset.videoId ||
          'aJYMCM1aEcA';

        openModal(videoId);

      }
    );

  });

  /* ========================================
     CLOSE EVENTS
  ======================================== */

  closeButton.addEventListener(
    'click',
    closeModal
  );

  modal.addEventListener(
    'click',
    (event) => {

      if (event.target === modal) {
        closeModal();
      }

    }
  );

  document.addEventListener(
    'keydown',
    (event) => {

      if (
        event.key === 'Escape' &&
        modal.classList.contains('active')
      ) {

        closeModal();

      }

    }
  );

});