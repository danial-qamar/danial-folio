import './bootstrap';
import 'flowbite';
import Swiper from 'swiper/bundle';
import chatbox from './components/chatbox';

// Make Swiper globally available
window.Swiper = Swiper;

// Register Alpine.js components
window.setupChatbox = chatbox;

/**
 * Scroll Up Button functionality
 */
const scrollUpButton = document.getElementById('scrollUp');
if (scrollUpButton) {
    window.onscroll = function () {
        const scrollThreshold = 100;
        const shouldShow = document.body.scrollTop > scrollThreshold ||
            document.documentElement.scrollTop > scrollThreshold;
        scrollUpButton.style.display = shouldShow ? "block" : "none";
    };

    scrollUpButton.onclick = function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
}

/**
 * Repository Card Language Colors
 */
const languageColors = {
    JavaScript: '#f7df1e',
    TypeScript: '#007acc',
    PHP: '#777BB3',
    Python: '#3776AB',
    Java: '#f89820',
    Ruby: '#CC342D',
    Go: '#00ADD8',
    Rust: '#DEA584',
    HTML: '#e34c26',
    CSS: '#264de4',
};

function applyLanguageGradient(element, language) {
    const color = languageColors[language] || '#ffffff20';
    const gradientElement = element.querySelector('.language-gradient');
    if (gradientElement) {
        gradientElement.style.background = `linear-gradient(to top right, ${color}20, transparent)`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-repository-card]').forEach(card => {
        const language = card.getAttribute('data-language');
        if (language) {
            applyLanguageGradient(card, language);
        }
    });
});

/**
 * Smooth Scroll Navigation
 */
document.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href?.includes('#')) return;

        const [baseUrl, targetId] = href.split('#');

        const isCurrentPage = !baseUrl ||
            baseUrl === '/' ||
            baseUrl === window.location.pathname ||
            baseUrl === window.location.origin + window.location.pathname ||
            baseUrl === window.location.href.split('#')[0];

        if (isCurrentPage) {
            let targetSection = document.getElementById(targetId);
            if (!targetSection && targetId === 'about') {
                targetSection = document.getElementById('about-me');
            }
            if (!targetSection && targetId === 'about-me') {
                targetSection = document.getElementById('about');
            }

            if (targetSection) {
                e.preventDefault();
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
});

/**
 * Swiper Carousel Configuration
 */
if (document.querySelector('.swiper')) {
    new Swiper(".swiper", {
        slidesPerView: 5,
        loop: true,
        centerInsufficientSlides: true,
        centeredSlidesBounds: true,
        speed: 500,
        autoplay: true,
        centeredSlides: true,
    });
}

/**
 * Hero Logos Marquee Configuration
 */
document.addEventListener('DOMContentLoaded', function () {
    const heroLogosContainer = document.querySelector('.hero-logos-swiper');

    if (heroLogosContainer) {
        const speed = parseInt(heroLogosContainer.getAttribute('data-speed')) || 2;
        const direction = heroLogosContainer.getAttribute('data-direction') || 'left';

        const speedMap = {
            1: '25s',
            2: '15s',
            3: '8s'
        };

        const animationDuration = speedMap[speed] || '15s';
        const animationDirection = direction === 'right' ? 'reverse' : 'normal';

        const wrapper = heroLogosContainer.querySelector('.swiper-wrapper');
        if (wrapper) {
            const totalWidth = wrapper.scrollWidth;
            wrapper.style.width = `${totalWidth * 2}px`;
            wrapper.style.animation = `marquee-scroll ${animationDuration} linear infinite ${animationDirection}`;

            heroLogosContainer.addEventListener('mouseenter', () => {
                wrapper.style.animationPlayState = 'paused';
            });

            heroLogosContainer.addEventListener('mouseleave', () => {
                wrapper.style.animationPlayState = 'running';
            });
        }
    }
});

/**
 * Privacy Modal Management
 */
const modalEl = document.getElementById('info-popup');
if (modalEl) {
    const modalId = modalEl.getAttribute('data-modal-id');
    const privacyModal = typeof Modal !== 'undefined' ? new Modal(modalEl, { placement: 'center' }) : null;

    if (privacyModal) {
        setTimeout(() => privacyModal.show(), 100);

        const closeModalEl = document.getElementById('close-modal');
        if (closeModalEl) {
            closeModalEl.addEventListener('click', () => privacyModal.hide());
        }

        const acceptPrivacyEl = document.getElementById('confirm-button');
        if (acceptPrivacyEl) {
            acceptPrivacyEl.addEventListener('click', () => {
                privacyModal.hide();
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    function updateOpenToWorkBadges() {
        const socialNetworks = document.querySelectorAll('[data-linkedin]');
        let linkedinUrl = null;

        socialNetworks.forEach(social => {
            const url = social.getAttribute('data-linkedin');
            if (url && url !== 'null' && url !== '') {
                linkedinUrl = url;
            }
        });

        if (linkedinUrl) {
            const badges = [
                document.getElementById('open-to-work-expanded'),
                document.getElementById('open-to-work-compact'),
                document.getElementById('open-to-work-ultra-compact'),
            ];

            badges.forEach(badge => {
                if (badge && badge.textContent.includes('Open to Work')) {
                    const a = document.createElement('a');
                    a.href = linkedinUrl;
                    a.target = '_blank';
                    a.rel = 'noopener noreferrer';
                    a.className = badge.className + ' hover:underline';
                    a.textContent = badge.textContent;
                    badge.replaceWith(a);
                }
            });
        }
    }

    setTimeout(updateOpenToWorkBadges, 100);
});
