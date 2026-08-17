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

    const canvas = document.getElementById('wedding-rings-canvas');

    if (canvas) {
        import('three').then((THREE) => {
        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(34, 1, 0.1, 100);
        camera.position.set(0, 0.2, 7);

        scene.add(new THREE.AmbientLight(0xffecd1, 1.7));
        const keyLight = new THREE.DirectionalLight(0xffd583, 3.2);
        keyLight.position.set(3, 4, 5);
        scene.add(keyLight);
        const rimLight = new THREE.PointLight(0xd68b9c, 12, 15);
        rimLight.position.set(-3, 1, 3);
        scene.add(rimLight);

        const rings = new THREE.Group();
        const gold = new THREE.MeshPhysicalMaterial({ color: 0xcfa65a, metalness: 0.9, roughness: 0.18, clearcoat: 0.8, clearcoatRoughness: 0.12 });
        const roseGold = new THREE.MeshPhysicalMaterial({ color: 0xc88782, metalness: 0.82, roughness: 0.22, clearcoat: 0.75 });
        const firstRing = new THREE.Mesh(new THREE.TorusGeometry(1.28, 0.18, 32, 100), gold);
        firstRing.rotation.set(0.55, -0.3, 0.35);
        const secondRing = new THREE.Mesh(new THREE.TorusGeometry(1.28, 0.18, 32, 100), roseGold);
        secondRing.rotation.set(-0.65, 0.25, -0.4);
        secondRing.position.set(0.45, 0.15, 0.15);
        rings.add(firstRing, secondRing);
        scene.add(rings);

        const resize = () => {
            const { width, height } = canvas.getBoundingClientRect();
            renderer.setSize(width, height, false);
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
        };
        resize();
        window.addEventListener('resize', resize);

        let pointerX = 0;
        canvas.addEventListener('pointermove', (event) => { pointerX = (event.offsetX / canvas.clientWidth - 0.5) * 0.45; });
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const animate = (time) => {
            if (!reduceMotion) {
                rings.rotation.y = time * 0.00035 + pointerX;
                rings.rotation.x = Math.sin(time * 0.00045) * 0.12;
                rings.position.y = Math.sin(time * 0.0007) * 0.15;
            }
            renderer.render(scene, camera);
            requestAnimationFrame(animate);
        };
        requestAnimationFrame(animate);
        });
    }

    const rsvpForm = document.getElementById('rsvp-form');
    if (rsvpForm) {
        rsvpForm.addEventListener('submit', (event) => {
            event.preventDefault();
            document.getElementById('rsvp-message').classList.remove('hidden');
            rsvpForm.reset();
        });
    }
});
