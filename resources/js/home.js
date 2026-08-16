import * as THREE from 'three';
import { mountHeroScene } from './lib/hero-scene';

/**
 * A gently rotating graduation cap (mortarboard) with a hanging tassel,
 * plus a floating diploma scroll.
 */
function buildHeroScene(scene, { primary, secondary }) {
    const capGroup = new THREE.Group();

    const boardMaterial = new THREE.MeshLambertMaterial({
        color: primary,
        metalness: 0.4,
        roughness: 0.35,
        emissive: primary,
        emissiveIntensity: 0.12,
    });

    const board = new THREE.Mesh(new THREE.BoxGeometry(2.4, 0.12, 2.4), boardMaterial);
    capGroup.add(board);

    const baseMaterial = new THREE.MeshLambertMaterial({
        color: 0x1a1420,
        metalness: 0.5,
        roughness: 0.4,
    });

    const base = new THREE.Mesh(new THREE.CylinderGeometry(0.85, 0.95, 0.6, 32), baseMaterial);
    base.position.y = -0.36;
    capGroup.add(base);

    const buttonMaterial = new THREE.MeshLambertMaterial({
        color: secondary,
        metalness: 0.7,
        roughness: 0.2,
        emissive: secondary,
        emissiveIntensity: 0.3,
    });

    const button = new THREE.Mesh(new THREE.SphereGeometry(0.11, 16, 16), buttonMaterial);
    button.position.y = 0.08;
    capGroup.add(button);

    const tasselMaterial = new THREE.MeshLambertMaterial({
        color: secondary,
        metalness: 0.6,
        roughness: 0.3,
    });

    const tasselCord = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, 1.1, 8), tasselMaterial);
    tasselCord.position.set(1.05, -0.45, 1.05);
    tasselCord.rotation.z = Math.PI / 10;
    capGroup.add(tasselCord);

    const tasselBead = new THREE.Mesh(new THREE.SphereGeometry(0.09, 12, 12), tasselMaterial);
    tasselBead.position.set(1.15, -0.98, 1.05);
    capGroup.add(tasselBead);

    capGroup.rotation.x = -0.15;
    capGroup.position.x = -1;
    scene.add(capGroup);

    const scrollMaterial = new THREE.MeshLambertMaterial({
        color: 0xf5ead6,
        metalness: 0.05,
        roughness: 0.6,
    });

    const scroll = new THREE.Mesh(new THREE.CylinderGeometry(0.16, 0.16, 1.5, 24, 1, true), scrollMaterial);
    scroll.rotation.z = Math.PI / 2.2;
    scroll.position.set(1.6, 0.3, -0.5);
    scene.add(scroll);

    const ribbonMaterial = new THREE.MeshLambertMaterial({
        color: primary,
        metalness: 0.3,
        roughness: 0.4,
    });

    const ribbon = new THREE.Mesh(new THREE.TorusGeometry(0.17, 0.03, 12, 32), ribbonMaterial);
    ribbon.rotation.x = Math.PI / 2;
    ribbon.position.set(1.6, 0.3, -0.5);
    scene.add(ribbon);

    return (elapsed) => {
        capGroup.rotation.y = elapsed * 0.9;
        capGroup.position.y = Math.sin(elapsed * 1.5) * 0.15;

        scroll.rotation.y = elapsed * 1.0;
        ribbon.rotation.y = elapsed * 1.0;
        scroll.position.y = 0.3 + Math.cos(elapsed * 1.3) * 0.12;
        ribbon.position.y = scroll.position.y;
    };
}

function initPackageBookingLinks() {
    document.querySelectorAll('.book-package-link').forEach((link) => {
        link.addEventListener('click', () => {
            const select = document.getElementById('package_id');

            if (select) {
                select.value = link.dataset.packageId;
            }
        });
    });
}

function initPackageImageModal() {
    const modal = document.getElementById('package-image-modal');
    const modalImg = document.getElementById('package-image-modal-img');
    const closeBtn = document.getElementById('package-image-modal-close');

    if (!modal || !modalImg) {
        return;
    }

    const open = (src, alt) => {
        modalImg.src = src;
        modalImg.alt = alt;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    const close = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modalImg.src = '';
    };

    document.querySelectorAll('.package-image-trigger').forEach((img) => {
        img.addEventListener('click', () => open(img.dataset.fullSrc, img.alt));
    });

    closeBtn.addEventListener('click', close);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
}

function initBookingWizard() {
    const step1 = document.getElementById('booking-step-1');
    const step2 = document.getElementById('booking-step-2');
    const nextBtn = document.getElementById('booking-next-btn');
    const backBtn = document.getElementById('booking-back-btn');
    const availabilityMsg = document.getElementById('booking-availability-msg');

    if (!step1 || !step2 || !nextBtn) {
        return;
    }

    nextBtn.addEventListener('click', async () => {
        const packageId = document.getElementById('package_id').value;
        const bookingDate = document.getElementById('booking_date').value;
        const timeSlot = document.getElementById('time_slot').value;

        if (!packageId || !bookingDate || !timeSlot) {
            availabilityMsg.textContent = 'Please choose a package, date and time slot first.';
            availabilityMsg.className = 'mt-3 text-xs text-red-400';
            return;
        }

        nextBtn.disabled = true;
        availabilityMsg.textContent = 'Checking availability…';
        availabilityMsg.className = 'mt-3 text-xs text-fg/50';

        try {
            const response = await fetch(document.getElementById('booking-form').dataset.checkAvailabilityUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ booking_date: bookingDate, time_slot: timeSlot }),
            });
            const data = await response.json();

            if (data.available) {
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
                availabilityMsg.textContent = '';
            } else {
                availabilityMsg.textContent = 'That date and time slot is already booked. Please choose another.';
                availabilityMsg.className = 'mt-3 text-xs text-red-400';
            }
        } catch {
            availabilityMsg.textContent = 'Could not check availability. Please try again.';
            availabilityMsg.className = 'mt-3 text-xs text-red-400';
        } finally {
            nextBtn.disabled = false;
        }
    });

    backBtn?.addEventListener('click', () => {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    mountHeroScene('home-hero-canvas', buildHeroScene);
    initPackageBookingLinks();
    initPackageImageModal();
    initBookingWizard();
});
