@extends('public.layouts.brand')

@section('title', 'Pakej & Harga — ' . $brand->name)
@section('description', 'Semua pakej dan harga ' . $brand->name . ' — terbuka, tiada perlu tanya.')

@section('content')
    <section class="relative overflow-hidden">
        <div class="glow-field opacity-70"></div>
        <div class="relative mx-auto max-w-6xl px-4 pb-16 pt-20 text-center">
            <h1 class="font-display text-4xl font-bold text-fg text-glow md:text-5xl">Pakej &amp; Harga</h1>
            <p class="mt-4 text-fg/60">Semua harga terbuka di sini. Pilih pakej, dan hubungi kami untuk tarikh.</p>
        </div>
    </section>

    <section class="relative mx-auto max-w-6xl px-4 pb-28">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($packages as $package)
                <div data-reveal style="transition-delay: {{ $loop->index * 80 }}ms"
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
                        @foreach ($package->items as $item)
                            <li class="flex items-start gap-2 {{ $item->is_included ? '' : 'text-fg/30 line-through' }}">
                                <span class="mt-0.5 {{ $item->is_included ? 'text-brand-primary' : 'text-fg/20' }}">
                                    {{ $item->is_included ? '✓' : '✕' }}
                                </span>
                                <span>{{ $item->label }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @if ($package->addons->isNotEmpty())
                        <p class="mt-6 text-xs font-semibold uppercase tracking-wider text-fg/30">Add-on tersedia</p>
                        <p class="mt-1 text-xs text-fg/50">{{ $package->addons->pluck('name')->join(', ') }}</p>
                    @endif

                    <div class="mt-7 flex flex-col gap-2">
                        <a href="{{ route('packages.show', $package) }}"
                           class="block rounded-full bg-brand-primary py-2.5 text-center text-sm font-semibold text-black transition hover:brightness-110">
                            Lihat Butiran
                        </a>
                        <a href="{{ $brand->whatsappUrl($package->whatsappMessage()) }}" target="_blank" rel="noopener"
                           class="block rounded-full border border-fg/15 py-2.5 text-center text-sm font-semibold text-fg/80 transition hover:border-fg/30">
                            Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
