@extends('public.layouts.brand')

@section('title', 'CoreMemory — Raja Sehari')
@section('description', 'CoreMemory merakam momen Raja Sehari dengan sentuhan editorial dan penuh emosi.')

@section('content')
    <section class="relative isolate overflow-hidden bg-[#faf6ef] pb-20 pt-28 text-[#2b2013] md:pb-28 md:pt-36">
        <div class="absolute inset-0 -z-10 opacity-70 [background:radial-gradient(circle_at_78%_32%,#e7c9cf,transparent_29%),radial-gradient(circle_at_16%_88%,#ead9ae,transparent_34%)]"></div>
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 lg:grid-cols-[.9fr_1.1fr] lg:gap-20">
            <div data-reveal>
                <p class="text-xs font-semibold uppercase tracking-[.32em] text-[#a66b76]">CoreMemory presents</p>
                <h1 class="font-display mt-5 text-6xl leading-[.9] tracking-tight text-[#2b2013] sm:text-7xl lg:text-8xl">Untuk hari yang<br><em class="font-normal text-[#b77d86]">sekali seumur hidup.</em></h1>
                <p class="mt-7 max-w-md text-base leading-8 text-[#715f51]">Koleksi visual Raja Sehari yang halus, sinematik dan jujur—supaya setiap detik terasa hidup, lama selepas majlis berakhir.</p>
                <div class="mt-9 flex flex-wrap gap-3">
                    <a href="#rsvp" class="rounded-full bg-[#2b2013] px-6 py-3 text-sm font-semibold text-[#faf6ef] transition hover:-translate-y-0.5 hover:bg-[#8c5d63]">Sahkan Kehadiran</a>
                    <a href="#itinerary" class="rounded-full border border-[#bda99a] px-6 py-3 text-sm font-semibold text-[#564233] transition hover:border-[#8c5d63] hover:text-[#8c5d63]">Lihat Atur Cara</a>
                </div>
                <p class="mt-12 text-xs uppercase tracking-[.18em] text-[#9c8776]">Sabtu · 20 Disember 2026 · Shah Alam</p>
            </div>
            <div class="relative min-h-[420px] lg:min-h-[520px]" data-reveal>
                <div class="absolute inset-4 rounded-[3rem] border border-[#d7c0af] bg-white/30"></div>
                <canvas id="wedding-rings-canvas" class="absolute inset-0 h-full w-full" aria-label="Cincin perkahwinan 3D berputar perlahan"></canvas>
                <div class="absolute bottom-5 left-5 rounded-2xl border border-white/70 bg-white/50 px-4 py-3 text-xs tracking-wide text-[#725b4b] backdrop-blur-md">A &amp; F <span class="mx-2 text-[#b77d86]">✦</span> 20.12.26</div>
            </div>
        </div>
    </section>

    <section class="bg-[#f1e7db] py-20 text-[#2b2013] md:py-28">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 md:grid-cols-2">
            <div class="relative" data-reveal>
                <img class="h-[480px] w-full rounded-[2rem] object-cover" src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1000&q=85" alt="Pasangan pengantin tersenyum di hari perkahwinan">
                <div class="absolute -bottom-5 -right-3 rounded-2xl bg-[#b77d86] px-6 py-5 text-center text-[#fff8f1] shadow-xl"><span class="block font-display text-3xl">A + F</span><span class="text-[10px] uppercase tracking-[.2em]">Raja Sehari</span></div>
            </div>
            <div data-reveal>
                <p class="text-xs font-semibold uppercase tracking-[.3em] text-[#a66b76]">The bride &amp; groom</p>
                <h2 class="font-display mt-5 text-5xl leading-tight tracking-tight md:text-6xl">Aisyah<br><em class="font-normal text-[#b77d86]">&amp; Faris</em></h2>
                <p class="mt-6 max-w-md leading-8 text-[#715f51]">Dengan penuh kesyukuran, kami menjemput anda untuk bersama meraikan permulaan perjalanan kami. Kehadiran dan doa anda amat bermakna buat kami sekeluarga.</p>
                <div class="mt-8 grid max-w-sm grid-cols-2 gap-6 border-t border-[#d4bdac] pt-6 text-sm"><div><p class="text-[#9c8776]">Puteri kepada</p><p class="mt-1 font-semibold">Haji Ahmad &amp; Hajah Salmah</p></div><div><p class="text-[#9c8776]">Putera kepada</p><p class="mt-1 font-semibold">Encik Fauzi &amp; Puan Mariam</p></div></div>
            </div>
        </div>
    </section>

    <section id="itinerary" class="bg-[#faf6ef] py-20 text-[#2b2013] md:py-28">
        <div class="mx-auto max-w-4xl px-4"><div class="text-center" data-reveal><p class="text-xs font-semibold uppercase tracking-[.3em] text-[#a66b76]">20 Disember 2026</p><h2 class="font-display mt-4 text-5xl tracking-tight md:text-6xl">Atur cara <em class="font-normal text-[#b77d86]">majlis.</em></h2><p class="mx-auto mt-4 max-w-md leading-7 text-[#715f51]">Dewan Seri Melati, Shah Alam · Mohon hadir 15 minit lebih awal.</p></div>
            <div class="relative mx-auto mt-14 max-w-2xl before:absolute before:bottom-8 before:left-[17px] before:top-8 before:w-px before:bg-[#d4bdac]">
                <article class="relative grid grid-cols-[48px_1fr] gap-5 pb-11" data-reveal><div class="z-10 grid h-9 w-9 place-items-center rounded-full border border-[#b77d86] bg-[#faf6ef] text-xs text-[#a66b76]">01</div><div><p class="text-xs font-semibold uppercase tracking-[.17em] text-[#a66b76]">10:30 pagi</p><h3 class="font-display mt-1 text-3xl">Majlis Akad Nikah</h3><p class="mt-2 leading-7 text-[#715f51]">Penyatuan dua hati dalam suasana yang sederhana dan penuh restu.</p></div></article>
                <article class="relative grid grid-cols-[48px_1fr] gap-5 pb-11" data-reveal><div class="z-10 grid h-9 w-9 place-items-center rounded-full border border-[#b77d86] bg-[#faf6ef] text-xs text-[#a66b76]">02</div><div><p class="text-xs font-semibold uppercase tracking-[.17em] text-[#a66b76]">12:30 tengah hari</p><h3 class="font-display mt-1 text-3xl">Ketibaan Pengantin</h3><p class="mt-2 leading-7 text-[#715f51]">Sambutan keluarga dan sesi fotografi bersama tetamu.</p></div></article>
                <article class="relative grid grid-cols-[48px_1fr] gap-5" data-reveal><div class="z-10 grid h-9 w-9 place-items-center rounded-full border border-[#b77d86] bg-[#faf6ef] text-xs text-[#a66b76]">03</div><div><p class="text-xs font-semibold uppercase tracking-[.17em] text-[#a66b76]">01:00 petang</p><h3 class="font-display mt-1 text-3xl">Majlis Bersanding</h3><p class="mt-2 leading-7 text-[#715f51]">Raikan detik bahagia di pelamin bersama keluarga dan sahabat tersayang.</p></div></article>
            </div>
        </div>
    </section>

    <section id="rsvp" class="relative overflow-hidden bg-[#68474a] py-20 text-[#fff8f1] md:py-28">
        <div class="absolute inset-0 opacity-30 [background:radial-gradient(circle_at_10%_10%,#e8c8a8,transparent_28%),radial-gradient(circle_at_88%_88%,#d88c9a,transparent_30%)]"></div>
        <div class="relative mx-auto grid max-w-5xl gap-10 px-4 md:grid-cols-[.85fr_1.15fr] md:items-center"><div data-reveal><p class="text-xs font-semibold uppercase tracking-[.3em] text-[#f4d3bd]">RSVP</p><h2 class="font-display mt-4 text-5xl leading-tight md:text-6xl">Kehadiran anda<br>adalah <em class="font-normal text-[#f1c4b3]">hadiah.</em></h2><p class="mt-5 max-w-sm leading-7 text-[#f7dfd2]">Sila sahkan kehadiran sebelum 6 Disember 2026 untuk membantu kami menyambut anda dengan sebaiknya.</p></div>
            <form id="rsvp-form" class="rounded-[2rem] border border-white/25 bg-white/10 p-6 shadow-2xl backdrop-blur-xl sm:p-8" data-reveal><div class="grid gap-5 sm:grid-cols-2"><label class="text-sm">Nama penuh<input required name="name" class="mt-2 w-full rounded-xl border border-white/25 bg-white/10 px-4 py-3 text-[#fff8f1] outline-none placeholder:text-white/55 focus:border-[#f1c4b3]" placeholder="Nama anda"></label><label class="text-sm">Bilangan tetamu<select name="guests" class="mt-2 w-full rounded-xl border border-white/25 bg-[#855b5e] px-4 py-3 text-[#fff8f1] outline-none focus:border-[#f1c4b3]"><option>1 orang</option><option>2 orang</option><option>3 orang</option><option>4 orang</option></select></label></div><label class="mt-5 block text-sm">Kehadiran<div class="mt-2 grid grid-cols-2 gap-3"><label class="cursor-pointer rounded-xl border border-white/25 px-4 py-3 text-center has-[:checked]:border-[#f1c4b3] has-[:checked]:bg-white/15"><input class="sr-only" checked type="radio" name="attendance" value="hadir">Hadir, insya-Allah</label><label class="cursor-pointer rounded-xl border border-white/25 px-4 py-3 text-center has-[:checked]:border-[#f1c4b3] has-[:checked]:bg-white/15"><input class="sr-only" type="radio" name="attendance" value="tidak hadir">Tidak dapat hadir</label></div></label><label class="mt-5 block text-sm">Ucapan <textarea name="message" rows="3" class="mt-2 w-full rounded-xl border border-white/25 bg-white/10 px-4 py-3 text-[#fff8f1] outline-none placeholder:text-white/55 focus:border-[#f1c4b3]" placeholder="Titipkan doa dan ucapan buat pengantin"></textarea></label><button class="mt-6 rounded-full bg-[#fff8f1] px-6 py-3 text-sm font-semibold text-[#68474a] transition hover:-translate-y-0.5 hover:bg-[#f1c4b3]" type="submit">Hantar RSVP</button><p id="rsvp-message" class="mt-4 hidden text-sm text-[#f5ddbf]">Terima kasih. RSVP anda telah diterima.</p></form>
        </div>
    </section>
    @include('public.partials.design-switcher')
@endsection
