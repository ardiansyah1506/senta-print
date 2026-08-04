import './bootstrap';

export function initLucideIcons() {
    if (typeof window.lucide !== 'undefined' && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLucideIcons);
} else {
    initLucideIcons();
}

// Fallback observer to automatically initialize icons rendered dynamically
window.addEventListener('load', initLucideIcons);
window.initLucideIcons = initLucideIcons;

