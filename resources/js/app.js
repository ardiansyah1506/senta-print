import './bootstrap';
import { createIcons, icons } from 'lucide';

export function initLucideIcons() {
    if (typeof createIcons === 'function') {
        createIcons({ icons });
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

