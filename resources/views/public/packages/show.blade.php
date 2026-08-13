@extends('public.layouts.brand')

@section('title', $package->name . ' — ' . $brand->name)
@section('description', $package->tagline)

@section('content')
    <section class="relative overflow-hidden">
        <div class="glow-field opacity-60"></div>

        <div class="relative mx-auto max-w-4xl px-4 pb-20 pt-16">
            <a href="{{ route('packages.index') }}" class="text-sm font-semibold text-brand-primary">&larr; Semua Pakej</a>

            <div class="mt-6 flex flex-col gap-10 md:flex-row md:items-start">
                <div class="flex-1" data-reveal>
                    @if ($package->is_featured)
                        <span class="mb-2 inline-block rounded-full border border-brand-secondary/30 bg-brand-secondary/10 px-3 py-1 text-xs font-semibold text-brand-secondary">
                            Paling Popular
                        </span>
                    @endif
                    <h1 class="font-display text-4xl font-bold text-fg text-glow">{{ $package->name }}</h1>
                    <p class="mt-2 text-fg/60">{{ $package->tagline }}</p>

                    @if ($package->description)
                        <p class="mt-6 text-fg/70">{{ $package->description }}</p>
                    @endif

                    <h2 class="font-display mt-10 text-lg font-semibold text-fg">Apa yang termasuk</h2>
                    <ul class="mt-4 space-y-2.5 text-sm text-fg/70">
                        @foreach ($package->items as $item)
                            <li class="flex items-start gap-2 {{ $item->is_included ? '' : 'text-fg/30 line-through' }}">
                                <span class="mt-0.5 {{ $item->is_included ? 'text-brand-primary' : 'text-fg/20' }}">
                                    {{ $item->is_included ? '✓' : '✕' }}
                                </span>
                                <span>
                                    {{ $item->label }}
                                    @if ($item->detail)
                                        <span class="text-fg/40">— {{ $item->detail }}</span>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    @if ($package->addons->isNotEmpty())
                        <h2 class="font-display mt-10 text-lg font-semibold text-fg">Add-on Pilihan</h2>
                        <ul class="mt-4 space-y-2 text-sm text-fg/70">
                            @foreach ($package->addons as $addon)
                                <li class="glow-border flex items-center justify-between rounded-xl px-4 py-3">
                                    <span>{{ $addon->name }}</span>
                                    <span class="font-semibold text-brand-primary">
                                        +{{ $addon->price_cents->format() }}
                                        @if ($addon->unit !== 'flat' && $addon->unit !== 'unit') / {{ $addon->unit }} @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div data-reveal class="glass-card w-full shrink-0 rounded-3xl p-7 md:w-80 md:sticky md:top-24">
                    <p class="font-display text-3xl font-bold text-fg">
                        {{ $package->price_cents->format() }}
                    </p>
                    @if ($package->was_price_cents)
                        <p class="text-sm text-fg/30 line-through">{{ $package->was_price_cents->format() }}</p>
                    @endif
                    @if ($package->price_note)
                        <p class="mt-1 text-xs text-fg/40">{{ $package->price_note }}</p>
                    @endif

                    <dl class="mt-5 space-y-2 text-sm text-fg/60">
                        @if ($package->duration_minutes)
                            <div class="flex justify-between"><dt>Tempoh sesi</dt><dd class="text-fg">{{ $package->duration_minutes }} minit</dd></div>
                        @endif
                        @if ($package->edited_photos_count)
                            <div class="flex justify-between"><dt>Gambar edit</dt><dd class="text-fg">{{ $package->edited_photos_count }} keping</dd></div>
                        @endif
                        @if ($package->delivery_days)
                            <div class="flex justify-between"><dt>Tempoh siap</dt><dd class="text-fg">{{ $package->delivery_days }} hari</dd></div>
                        @endif
                        <div class="flex justify-between"><dt>Deposit</dt><dd class="text-fg">{{ $package->depositPercent() }}%</dd></div>
                    </dl>

                    <a href="{{ $brand->whatsappUrl($package->whatsappMessage()) }}" target="_blank" rel="noopener"
                       class="mt-7 block rounded-full bg-brand-primary py-3 text-center text-sm font-semibold text-black shadow-[0_0_30px_-10px_var(--brand-primary)] transition hover:brightness-110">
                        Tempah via WhatsApp
                    </a>
                    <p class="mt-3 text-center text-xs text-fg/30">
                        Sebut harga tertakluk kepada pengesahan availability tarikh.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
