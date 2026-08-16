import * as THREE from 'three';

export function brandColor(varName, fallback) {
    const value = getComputedStyle(document.documentElement).getPropertyValue(varName).trim();

    return new THREE.Color(value || fallback);
}

const SOFTWARE_RENDERER_MARKERS = ['swiftshader', 'llvmpipe', 'software', 'basic render'];

/**
 * True when WebGL is only available via a CPU software rasterizer (no real
 * GPU) — e.g. SwiftShader/llvmpipe, common in headless/CI/some virtualized
 * or remote-desktop setups. Real-time PBR rendering there drops enough
 * frames to visibly compete with CSS hover transitions, so we skip the 3D
 * scene entirely on these and keep just the CSS glow-field behind it.
 */
function hasSoftwareRendererOnly() {
    try {
        const probe = document.createElement('canvas');
        const gl = probe.getContext('webgl2') || probe.getContext('webgl');

        if (!gl) {
            return true;
        }

        const info = gl.getExtension('WEBGL_debug_renderer_info');
        const renderer = (info ? gl.getParameter(info.UNMASKED_RENDERER_WEBGL) : gl.getParameter(gl.RENDERER)) || '';

        return SOFTWARE_RENDERER_MARKERS.some((marker) => renderer.toLowerCase().includes(marker));
    } catch {
        return true;
    }
}

/**
 * Common boilerplate for a page-hero Three.js scene: renderer/camera/lighting
 * setup, resize handling, a requestAnimationFrame loop that pauses under
 * prefers-reduced-motion, when the tab is hidden, AND when the canvas has
 * scrolled out of view — without this last one, every hero keeps rendering
 * full-tilt while the visitor is reading content further down the page.
 * `setup(scene, ctx)` builds the scene's own objects and returns an
 * `update(elapsed)` callback (or nothing, for a static scene).
 */
export function mountHeroScene(containerId, setup) {
    const container = document.getElementById(containerId);

    if (!container || hasSoftwareRendererOnly()) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const primary = brandColor('--brand-primary', '#a855f7');
    const secondary = brandColor('--brand-secondary', '#22d3ee');

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(0, 0.5, 7.5);

    const renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true, powerPreference: 'low-power' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1));
    container.appendChild(renderer.domElement);

    const keyLight = new THREE.DirectionalLight(0xffffff, 1.3);
    keyLight.position.set(4, 5, 6);
    scene.add(keyLight);

    const fillLight = new THREE.DirectionalLight(secondary, 0.7);
    fillLight.position.set(-5, -2, 3);
    scene.add(fillLight);

    scene.add(new THREE.AmbientLight(0xffffff, 0.35));

    const update = setup(scene, { primary, secondary, camera });

    const resize = () => {
        const { clientWidth, clientHeight } = container;

        if (!clientWidth || !clientHeight) {
            return;
        }

        camera.aspect = clientWidth / clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(clientWidth, clientHeight);
    };

    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(container);
    resize();

    if (prefersReducedMotion || typeof update !== 'function') {
        renderer.render(scene, camera);
        return;
    }

    let frameId = null;
    let isVisible = true;
    const clock = new THREE.Clock();

    // Ambient decoration, not a game loop — capping at ~30fps halves the
    // GPU work per second, leaving headroom for CSS hover/transition
    // compositing on buttons that sit over the canvas.
    const frameInterval = 1000 / 30;
    let lastFrameTime = 0;

    const animate = (now) => {
        frameId = requestAnimationFrame(animate);

        if (now - lastFrameTime < frameInterval) {
            return;
        }

        lastFrameTime = now;
        update(clock.getElapsedTime());
        renderer.render(scene, camera);
    };

    const stop = () => {
        if (frameId !== null) {
            cancelAnimationFrame(frameId);
            frameId = null;
        }
    };

    const start = () => {
        if (frameId === null && isVisible && !document.hidden) {
            animate();
        }
    };

    start();

    const visibilityObserver = new IntersectionObserver(
        (entries) => {
            isVisible = entries[0].isIntersecting;
            isVisible ? start() : stop();
        },
        { threshold: 0 }
    );
    visibilityObserver.observe(container);

    document.addEventListener('visibilitychange', () => {
        document.hidden ? stop() : start();
    });
}
