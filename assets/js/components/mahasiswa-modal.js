document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('mahasiswa-modal');
    const trigger = document.getElementById('mahasiswa-modal-trigger');
    const closeBtn = modal ? modal.querySelector('.mahasiswa-modal__close') : null;
    const overlay = modal ? modal.querySelector('.mahasiswa-modal__overlay') : null;

    if (!modal || !trigger) return;

    function openModal(e) {
        if (e) e.preventDefault();
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeModal() {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = ''; // Restore scrolling
    }

    trigger.addEventListener('click', openModal);
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeModal);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
