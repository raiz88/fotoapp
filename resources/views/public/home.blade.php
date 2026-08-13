@extends('public.layouts.brand')

@section('title', $brand->name . ' — ' . $brand->tagline)

@section('content')
    <section class="relative overflow-hidden">
        <div class="glow-field"></div>

        <div class="relative mx-auto max-w-6xl px-4 pb-28 pt-24 text-center md:pt-32">
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">{{ $brand->name }}</p>
            <h1 class="font-display mx-auto mt-6 max-w-3xl text-5xl font-bold leading-[1.05] tracking-tight text-fg text-glow md:text-7xl">
                {{ $brand->tagline }}
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-fg/60">
                Semua pakej dan harga terbuka di sini — tiada perlu tanya. Pilih, dan hubungi kami bila anda bersedia.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('packages.index') }}"
                   class="rounded-full bg-brand-primary px-8 py-3.5 font-semibold text-black shadow-[0_0_40px_-10px_var(--brand-primary)] transition hover:brightness-110">
                    Lihat Semua Pakej
                </a>
                <a href="{{ $brand->whatsappUrl('Hai ' . $brand->name . ', saya nak tanya tentang pakej.') }}" target="_blank" rel="noopener"
                   class="glow-border rounded-full px-8 py-3.5 font-semibold text-fg">
                    WhatsApp Kami
                </a>
            </div>
        </div>
    </section>

    <section class="relative mx-auto max-w-6xl px-4 pb-28">
        <div class="flex items-end justify-between" data-reveal>
            <h2 class="font-display text-3xl font-bold text-fg">Pakej Pilihan</h2>
            <a href="{{ route('packages.index') }}" class="text-sm font-semibold text-brand-primary">Lihat semua &rarr;</a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @forelse ($packages->take(3) as $package)
                <div data-reveal style="transition-delay: {{ $loop->index * 100 }}ms"
                     class="glass-card glow-border relative flex flex-col rounded-3xl p-7">
                    @if ($package->is_featured)
                        <span class="mb-3 inline-block w-fit rounded-full border border-brand-secondary/30 bg-brand-secondary/10 px-3 py-1 text-xs font-semibold text-brand-secondary">
                            Paling Popular
                        </span>
                    @endif
                    <h3 class="font-display text-xl font-semibold text-fg">{{ $package->name }}</h3>
                    <p class="mt-1 text-sm text-fg/50">{{ $package->tagline }}</p>

                    <p class="font-display mt-6 text-3xl font-bold text-fg">
                        {{ $package->price_cents->format() }}
                        @if ($package->was_price_cents)
                            <span class="ml-2 text-sm font-normal text-fg/30 line-through">{{ $package->was_price_cents->format() }}</span>
                        @endif
                    </p>
                    @if ($package->price_note)
                        <p class="text-xs text-fg/40">{{ $package->price_note }}</p>
                    @endif

                    <ul class="mt-6 flex-1 space-y-2.5 text-sm text-fg/70">
                        @foreach ($package->items->where('is_highlight', true)->take(4) as $item)
                            <li class="flex items-start gap-2">
                                <span class="mt-0.5 text-brand-primary">&check;</span>
                                <span>{{ $item->label }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('packages.show', $package) }}"
                       class="mt-7 block rounded-full bg-fg/10 py-2.5 text-center text-sm font-semibold text-fg transition hover:bg-brand-primary hover:text-black">
                        Lihat Butiran
                    </a>
                </div>
            @empty
                <p class="text-fg/50">Pakej akan dipaparkan di sini tidak lama lagi.</p>
            @endforelse
        </div>
    </section>
@endsection
