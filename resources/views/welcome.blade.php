<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotographer — Capture the feeling</title>
    <meta name="description" content="Fotographer booking management for your next beautiful moment.">
    <style>
        :root { --ink:#f7f4ee; --muted:#a9a7ad; --line:rgba(255,255,255,.13); --violet:#9d7bff; --pink:#ff8fbb; }
        * { box-sizing:border-box; }
        body { margin:0; color:var(--ink); background:#0b0a10; font-family:Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; overflow-x:hidden; }
        .landing { min-height:100vh; position:relative; isolation:isolate; overflow:hidden; background:radial-gradient(circle at 72% 45%, #241b42 0, #100d19 34%, #0b0a10 72%); }
        .landing:before { content:""; position:absolute; width:48rem; height:48rem; right:-15rem; top:-20rem; background:rgba(137,94,255,.19); filter:blur(80px); border-radius:50%; z-index:-1; }
        .noise { position:absolute; inset:0; opacity:.035; pointer-events:none; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.8'/%3E%3C/svg%3E"); }
        .nav { width:min(1180px, calc(100% - 48px)); margin:auto; padding:28px 0; display:flex; justify-content:space-between; align-items:center; position:relative; z-index:3; }
        .brand { display:flex; align-items:center; gap:11px; font-weight:750; letter-spacing:-.04em; font-size:19px; }
        .brand-mark { width:32px; height:32px; border:1.5px solid #fff; border-radius:10px; display:grid; place-items:center; transform:rotate(10deg); }
        .brand-mark i { width:12px; height:12px; border:2px solid var(--pink); border-radius:50%; display:block; }
        .nav-links { display:flex; align-items:center; gap:28px; font-size:13px; color:var(--muted); }
        .nav-links a, .footer-link { color:inherit; text-decoration:none; transition:color .2s; }
        .nav-links a:hover, .footer-link:hover { color:#fff; }
        .nav-cta { color:#fff!important; border:1px solid var(--line); border-radius:99px; padding:10px 16px; background:rgba(255,255,255,.06); }
        .hero { width:min(1180px, calc(100% - 48px)); min-height:calc(100vh - 88px); margin:auto; display:grid; grid-template-columns: .92fr 1.08fr; align-items:center; gap:24px; padding:45px 0 90px; position:relative; }
        .eyebrow { color:#c6b5ff; letter-spacing:.19em; text-transform:uppercase; font-size:11px; font-weight:700; margin-bottom:23px; }
        h1 { font-size:clamp(52px, 7.2vw, 102px); line-height:.9; letter-spacing:-.085em; margin:0; max-width:650px; font-weight:760; }
        h1 em { color:var(--pink); font-style:normal; }
        .intro { color:var(--muted); font-size:16px; line-height:1.65; max-width:420px; margin:29px 0 32px; }
        .actions { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
        .button { text-decoration:none; color:#15111f; background:#fff; border-radius:99px; padding:14px 20px; font-weight:700; font-size:13px; transition:transform .25s, box-shadow .25s; }
        .button:hover { transform:translateY(-3px); box-shadow:0 12px 32px rgba(255,255,255,.18); }
        .button.secondary { color:#fff; background:rgba(255,255,255,.06); border:1px solid var(--line); }
        .meta { display:flex; gap:27px; margin-top:60px; color:var(--muted); font-size:12px; }
        .meta strong { color:#fff; display:block; font-size:20px; letter-spacing:-.04em; margin-bottom:4px; }
        .scene-wrap { height:620px; display:grid; place-items:center; perspective:1200px; position:relative; }
        .scene-wrap:after { content:""; position:absolute; width:360px; height:80px; bottom:90px; background:#000; filter:blur(32px); opacity:.65; border-radius:50%; }
        .scene { width:390px; height:390px; position:relative; transform-style:preserve-3d; transform:rotateX(var(--rx, -7deg)) rotateY(var(--ry, -19deg)); transition:transform .18s ease-out; z-index:1; }
        .orb { position:absolute; width:150px; height:150px; border-radius:50%; right:3px; top:22px; background:radial-gradient(circle at 34% 28%, #fce3ff 0 2%, #c889ef 9%, #6148bc 34%, #201649 72%); box-shadow:inset -16px -18px 28px #110c25, 0 0 55px rgba(173,108,255,.47); transform:translateZ(105px); }
        .orb:after { content:""; position:absolute; width:35px; height:35px; border-radius:50%; top:27px; left:38px; background:#fff; filter:blur(10px); opacity:.5; }
        .camera { position:absolute; width:330px; height:220px; left:23px; top:100px; border-radius:38px 44px 48px 32px; background:linear-gradient(135deg,#40375b 0%,#191624 48%,#0e0d13 100%); box-shadow:inset 2px 2px 3px rgba(255,255,255,.22), 19px 29px 0 #09080d, 0 35px 60px rgba(0,0,0,.38); transform:translateZ(50px); }
        .camera:before { content:""; position:absolute; width:125px; height:28px; top:-18px; left:42px; background:#28223c; border-radius:10px 13px 2px 2px; box-shadow:inset 2px 2px 3px rgba(255,255,255,.18); }
        .camera:after { content:"FOTO"; position:absolute; right:24px; top:24px; color:#d7c6ff; font:700 9px/1 monospace; letter-spacing:.16em; }
        .lens { position:absolute; width:190px; height:190px; left:69px; top:15px; border-radius:50%; background:radial-gradient(circle, #12101c 0 17%, #6d5a95 18% 21%, #29213f 23% 35%, #0c0b11 36% 47%, #574779 48% 53%, #121018 54% 72%, #382d56 73% 100%); border:9px solid #252036; box-shadow:inset 0 0 0 5px #0c0b10, 0 8px 8px #0a080e; transform:translateZ(76px); }
        .lens:after { content:""; position:absolute; inset:29px; border-radius:50%; background:radial-gradient(circle at 35% 29%, #d5bcff 0 2%, #7254bd 11%, #171126 45%, #08070b 71%); box-shadow:0 0 24px rgba(173,125,255,.33); }
        .dial { position:absolute; width:38px; height:38px; right:32px; top:34px; border-radius:50%; background:#0d0c12; border:5px solid #51476d; transform:translateZ(75px); }
        .float-card { position:absolute; z-index:2; border:1px solid var(--line); background:rgba(24,20,37,.72); backdrop-filter:blur(14px); border-radius:16px; padding:14px 16px; font-size:11px; color:var(--muted); box-shadow:0 16px 40px rgba(0,0,0,.2); }
        .float-card strong { color:#fff; display:block; margin-top:5px; font-size:14px; }
        .float-one { top:111px; left:8px; transform:rotate(-8deg); } .float-two { right:-4px; bottom:133px; transform:rotate(7deg); }
        .float-dot { display:inline-block; width:7px; height:7px; background:#74efc1; border-radius:50%; margin-right:5px; }
        .scroll { position:absolute; left:50%; bottom:29px; color:#777381; font-size:10px; letter-spacing:.16em; text-transform:uppercase; transform:translateX(-50%); }
        @media (prefers-color-scheme: light) {
            :root { --ink:#17131f; --muted:#686473; --line:rgba(23,19,31,.14); --violet:#7653df; --pink:#dd4d88; }
            body { color:var(--ink); background:#f5f3f8; }
            .landing { background:radial-gradient(circle at 72% 42%, #e8ddff 0, #f6f2fb 38%, #fff 78%); }
            .landing:before { background:rgba(194,153,255,.28); }
            .brand-mark { border-color:#17131f; }
            .nav-links a:hover, .footer-link:hover { color:#17131f; }
            .nav-cta { color:#17131f!important; background:rgba(255,255,255,.58); }
            h1 em { color:#d34b87; }
            .eyebrow { color:#7653df; }
            .button { color:#fff; background:#17131f; }
            .button:hover { box-shadow:0 12px 32px rgba(23,19,31,.2); }
            .button.secondary { color:#17131f; background:rgba(255,255,255,.55); }
            .meta strong { color:#17131f; }
            .float-card { color:#686473; background:rgba(255,255,255,.62); border-color:rgba(23,19,31,.13); box-shadow:0 16px 40px rgba(67,45,98,.14); }
            .float-card strong { color:#17131f; }
            .scroll { color:#8b8792; }
            .scene-wrap:after { opacity:.22; }
        }
        html[data-fotographer-theme="dark"] body { color:#f7f4ee; background:#0b0a10; }
        html[data-fotographer-theme="dark"] .landing { background:radial-gradient(circle at 72% 45%, #241b42 0, #100d19 34%, #0b0a10 72%); }
        html[data-fotographer-theme="dark"] .landing:before { background:rgba(137,94,255,.19); }
        html[data-fotographer-theme="dark"] .brand-mark { border-color:#fff; }
        html[data-fotographer-theme="dark"] .nav-cta { color:#fff!important; background:rgba(255,255,255,.06); }
        html[data-fotographer-theme="dark"] h1 em { color:#ff8fbb; }
        html[data-fotographer-theme="dark"] .eyebrow { color:#c6b5ff; }
        html[data-fotographer-theme="dark"] .button { color:#15111f; background:#fff; }
        html[data-fotographer-theme="dark"] .button.secondary { color:#fff; background:rgba(255,255,255,.06); }
        html[data-fotographer-theme="dark"] .meta strong, html[data-fotographer-theme="dark"] .float-card strong { color:#fff; }
        html[data-fotographer-theme="dark"] .float-card { color:#a9a7ad; background:rgba(24,20,37,.72); border-color:rgba(255,255,255,.13); box-shadow:0 16px 40px rgba(0,0,0,.2); }
        html[data-fotographer-theme="dark"] .scroll { color:#777381; }
        html[data-fotographer-theme="dark"] .scene-wrap:after { opacity:.65; }
        html[data-fotographer-theme="light"] body { color:#17131f; background:#f5f3f8; }
        html[data-fotographer-theme="light"] .landing { background:radial-gradient(circle at 72% 42%, #e8ddff 0, #f6f2fb 38%, #fff 78%); }
        html[data-fotographer-theme="light"] .landing:before { background:rgba(194,153,255,.28); }
        html[data-fotographer-theme="light"] .brand-mark { border-color:#17131f; }
        html[data-fotographer-theme="light"] .nav-cta { color:#17131f!important; background:rgba(255,255,255,.58); }
        html[data-fotographer-theme="light"] h1 em { color:#d34b87; }
        html[data-fotographer-theme="light"] .eyebrow { color:#7653df; }
        html[data-fotographer-theme="light"] .button { color:#fff; background:#17131f; }
        html[data-fotographer-theme="light"] .button.secondary { color:#17131f; background:rgba(255,255,255,.55); }
        html[data-fotographer-theme="light"] .meta strong, html[data-fotographer-theme="light"] .float-card strong { color:#17131f; }
        html[data-fotographer-theme="light"] .float-card { color:#686473; background:rgba(255,255,255,.62); border-color:rgba(23,19,31,.13); box-shadow:0 16px 40px rgba(67,45,98,.14); }
        html[data-fotographer-theme="light"] .scroll { color:#8b8792; }
        html[data-fotographer-theme="light"] .scene-wrap:after { opacity:.22; }
        @media (max-width: 800px) { .nav { width:calc(100% - 32px); } .nav-links a:not(.nav-cta) { display:none; } .hero { width:calc(100% - 32px); grid-template-columns:1fr; padding-top:42px; } .scene-wrap { height:430px; transform:scale(.77); margin:-30px 0 -55px; } .meta { margin-top:42px; } }
    </style>
</head>
<body>
<main class="landing">
    <div class="noise"></div>
    <nav class="nav">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark"><i></i></span> fotographer</a>
        <div class="nav-links"><a href="#about">About</a><a href="#work">Our work</a><a class="nav-cta" href="{{ route('dashboard') }}">Open dashboard <span>↗</span></a></div>
    </nav>
    <section class="hero" id="about">
        <div class="copy">
            <div class="eyebrow">Photography, in motion</div>
            <h1>Make it<br><em>unforgettable.</em></h1>
            <p class="intro">We turn real moments into images that stay with you. Find your date, choose your session, and let’s create something honest.</p>
            <div class="actions"><a class="button" href="{{ route('bookings.create') }}">Book a session <span>↗</span></a><a class="button secondary" href="{{ route('bookings.calendar') }}">View calendar</a></div>
            <div class="meta"><div><strong>12+</strong>years of stories</div><div><strong>240</strong>sessions captured</div><div><strong>4.9</strong>client rating</div></div>
        </div>
        <div class="scene-wrap" id="work" aria-label="Interactive 3D camera illustration">
            <div class="float-card float-one"><span class="float-dot"></span> now booking<strong>August 2026</strong></div>
            <div class="scene" id="scene"><div class="orb"></div><div class="camera"><div class="lens"></div><div class="dial"></div></div></div>
            <div class="float-card float-two">crafted with light<strong>not just a picture.</strong></div>
        </div>
    </section>
    <div class="scroll">scroll to explore &nbsp; ↓</div>
</main>
<script>
    (function () {
        const savedTheme = localStorage.getItem('fotographer-theme');
        if (savedTheme && savedTheme !== 'system') document.documentElement.setAttribute('data-fotographer-theme', savedTheme);
    })();
    const scene = document.getElementById('scene');
    window.addEventListener('pointermove', (event) => {
        const x = (event.clientX / window.innerWidth - .5) * 2;
        const y = (event.clientY / window.innerHeight - .5) * 2;
        scene.style.setProperty('--ry', `${-19 + x * 9}deg`);
        scene.style.setProperty('--rx', `${-7 - y * 7}deg`);
    });
</script>
</body>
</html>
