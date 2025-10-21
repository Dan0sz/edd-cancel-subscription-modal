/**
 * @package EDD Cancel Subscription Modal
 * @author Daan van den Bergh
 * @copyright (c) 2025 Daan van den Bergh
 */
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('edd-cancel-modal');
    const closeButton = modal.querySelector('.edd-cancel-modal-close');
    const confirmButton = document.getElementById('edd-cancel-modal-confirm');
    const cancelButton = document.getElementById('edd-cancel-modal-cancel');
    const checkbox = document.getElementById('edd-cancel-confirm-checkbox');
    let originalLink = null;

    // Handle checkbox state changes
    checkbox.addEventListener('change', function () {
        confirmButton.disabled = !this.checked;
    });

    // Function to handle opening the modal
    function daanOpenModal(event) {
        event.preventDefault();
        originalLink = event.currentTarget;
        modal.style.display = 'flex';
        // Optional: Add fade-in animation
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);
    }

    // Function to handle closing the modal
    function daanCloseModal() {
        // Optional: Add fade-out animation
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
    }

    // Add click event listeners to all cancel subscription links
    document.querySelectorAll('.edd_subscription_cancel').forEach(link => {
        link.addEventListener('click', daanOpenModal);
    });

    // Close modal when clicking the × button
    closeButton.addEventListener('click', daanCloseModal);

    // Close modal when clicking outside of it
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            daanCloseModal();
        }
    });

    // Handle confirmation
    confirmButton.addEventListener('click', function () {
        if (originalLink && checkbox.checked) {
            window.location.href = originalLink.href;
        }
    });

    // Handle cancellation
    cancelButton.addEventListener('click', daanCloseModal);
});
