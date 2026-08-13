@extends('public.layouts.brand')

@section('title', 'Galeri — ' . $brand->name)

@section('content')
    <section class="relative overflow-hidden">
        <div class="glow-field opacity-60"></div>
        <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-20 text-center">
            <h1 class="font-display text-4xl font-bold text-fg text-glow md:text-5xl">Galeri</h1>
            <p class="mt-4 text-fg/60">Contoh hasil kerja kami akan dimuat naik di sini tidak lama lagi.</p>
        </div>
    </section>

    <section class="relative mx-auto max-w-6xl px-4 pb-28">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach (range(1, 8) as $i)
                <div data-reveal
                     class="glow-border relative flex overflow-hidden rounded-2xl {{ $i % 3 === 0 ? 'aspect-[3/4] md:col-span-1' : 'aspect-square' }}"
                     style="transition-delay: {{ ($i - 1) * 60 }}ms; background: radial-gradient(120% 120% at 20% 10%, color-mix(in srgb, var(--brand-primary) {{ 25 + ($i % 4) * 10 }}%, #0e0e13), #050507 80%);">
                    <span class="m-auto text-xs font-semibold uppercase tracking-[0.2em] text-fg/40">Sampel {{ $i }}</span>
                </div>
            @endforeach
        </div>

        <p class="mt-10 text-center text-sm text-fg/40">
            Nak tengok portfolio penuh? <a href="{{ route('contact') }}" class="font-semibold text-brand-primary">Hubungi kami</a>.
        </p>
    </section>
@endsection
