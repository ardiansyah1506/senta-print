import './bootstrap';
import { createIcons, icons } from 'lucide';

function initLucideIcons() {
    createIcons({ icons });
}

document.addEventListener('DOMContentLoaded', initLucideIcons);
window.initLucideIcons = initLucideIcons;
