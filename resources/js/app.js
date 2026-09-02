import './bootstrap';
import './translations';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Global Toast Notification Helper
window.showToast = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('toast-notify', { detail: { message, type } }));
};

// Clipboard Helper
window.copyToClipboard = function (text, successMsg = 'Berhasil disalin ke clipboard!') {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            window.showToast(successMsg, 'success');
        }).catch(() => {
            window.fallbackCopyText(text, successMsg);
        });
    } else {
        window.fallbackCopyText(text, successMsg);
    }
};

window.fallbackCopyText = function (text, successMsg) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        window.showToast(successMsg, 'success');
    } catch (err) {
        window.showToast('Gagal menyalin teks.', 'error');
    }
    document.body.removeChild(textArea);
};

// ==========================================================================
// Scroll Reveal Engine (IntersectionObserver for Show/Hide on Scroll)
// ==========================================================================
let revealObserver = null;

window.initScrollReveal = function () {
    if (revealObserver) {
        revealObserver.disconnect();
    }

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -40px 0px',
        threshold: 0.12
    };

    revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            } else {
                // Remove class when element exits viewport (Smooth hide on scroll)
                entry.target.classList.remove('is-visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-reveal]').forEach(el => {
        revealObserver.observe(el);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    window.initScrollReveal();
});

Alpine.start();
