import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

export function initLucideIcons() {
    if (typeof window.lucide !== 'undefined' && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
}

export function setButtonLoading(btn, customText = null) {
    if (!btn || btn.dataset.isLoading === 'true') return false;

    btn.dataset.isLoading = 'true';
    btn.dataset.originalHtml = btn.innerHTML;
    btn.dataset.originalDisabled = btn.disabled ? 'true' : 'false';

    const rect = btn.getBoundingClientRect();
    if (rect.width > 0) {
        btn.style.minWidth = `${rect.width}px`;
    }

    let loadingText = customText || btn.getAttribute('data-loading-text');

    if (!loadingText) {
        const textContent = (btn.textContent || '').trim().toLowerCase();
        if (textContent.includes('hapus') || textContent.includes('delete') || textContent.includes('remove')) {
            loadingText = 'Menghapus...';
        } else if (textContent.includes('simpan') || textContent.includes('save') || textContent.includes('tambah') || textContent.includes('store') || textContent.includes('update') || textContent.includes('edit')) {
            loadingText = 'Menyimpan...';
        } else if (textContent.includes('kirim') || textContent.includes('send') || textContent.includes('pesan') || textContent.includes('checkout')) {
            loadingText = 'Mengirim...';
        } else if (textContent.includes('cari') || textContent.includes('track') || textContent.includes('lacak') || textContent.includes('filter') || textContent.includes('search')) {
            loadingText = 'Memproses...';
        } else if (textContent.includes('unduh') || textContent.includes('export') || textContent.includes('download')) {
            loadingText = 'Mengunduh...';
        } else if (textContent.includes('login') || textContent.includes('sign in') || textContent.includes('masuk') || textContent.includes('daftar') || textContent.includes('register')) {
            loadingText = 'Memproses...';
        } else {
            loadingText = 'Memproses...';
        }
    }

    btn.disabled = true;
    btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
    btn.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin text-current text-xs"></i> <span>${loadingText}</span>`;
    return true;
}

export function resetButtonLoading(btn) {
    if (!btn || btn.dataset.isLoading !== 'true') return;

    btn.disabled = btn.dataset.originalDisabled === 'true';
    btn.classList.remove('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
    btn.innerHTML = btn.dataset.originalHtml || btn.innerHTML;
    btn.style.minWidth = '';
    delete btn.dataset.isLoading;
    delete btn.dataset.originalHtml;
    delete btn.dataset.originalDisabled;
}

window.setButtonLoading = setButtonLoading;
window.resetButtonLoading = resetButtonLoading;

// Automatic Form Submit Listener
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (!form || form.tagName !== 'FORM') return;
    if (form.getAttribute('data-no-loading') === 'true') return;

    let submitBtn = e.submitter;
    if (!submitBtn) {
        submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
    }
    if (!submitBtn) return;

    setTimeout(() => {
        if (e.defaultPrevented) return;
        setButtonLoading(submitBtn);

        window.addEventListener('pageshow', function() {
            resetButtonLoading(submitBtn);
        }, { once: true });
    }, 0);
}, false);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucideIcons);
} else {
    initLucideIcons();
}

window.addEventListener('load', initLucideIcons);
window.initLucideIcons = initLucideIcons;


