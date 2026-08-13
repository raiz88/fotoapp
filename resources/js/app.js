document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('nav-toggle');
    const menu = document.getElementById('nav-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => menu.classList.toggle('hidden'));
    }

    const revealTargets = document.querySelectorAll('[data-reveal]');

    if (revealTargets.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15 }
        );

        revealTargets.forEach((el) => observer.observe(el));
    } else {
        revealTargets.forEach((el) => el.classList.add('is-visible'));
    }

    const glowField = document.querySelector('.glow-field');

    if (glowField) {
        window.addEventListener('pointermove', (event) => {
            const x = (event.clientX / window.innerWidth - 0.5) * 20;
            const y = (event.clientY / window.innerHeight - 0.5) * 20;
            glowField.style.transform = `translate(${x}px, ${y}px)`;
        });
    }
});
