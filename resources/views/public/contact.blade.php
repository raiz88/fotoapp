@extends('public.layouts.brand')

@section('title', 'Hubungi Kami — ' . $brand->name)

@section('content')
    <section class="relative overflow-hidden">
        <div class="glow-field opacity-60"></div>
        <div class="relative mx-auto max-w-3xl px-4 pb-20 pt-20">
            <div class="text-center">
                <h1 class="font-display text-4xl font-bold text-fg text-glow md:text-5xl">Hubungi Kami</h1>
                <p class="mt-4 text-fg/60">Ada soalan tentang pakej atau tarikh? Cara paling pantas ialah WhatsApp.</p>
            </div>

            <div class="mt-14 grid gap-5 md:grid-cols-2">
                <a href="{{ $brand->whatsappUrl('Hai ' . $brand->name . ', saya nak tanya tentang pakej.') }}" target="_blank" rel="noopener"
                   data-reveal class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-500/15 text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.6 1.4 5.2L2 22l4.9-1.3C8.4 21.5 10.1 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.6 0-3.1-.4-4.4-1.2l-.3-.2-3 .8.8-2.9-.2-.3C4.4 15 4 13.5 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8z"/></svg>
                    </span>
                    <div>
                        <p class="font-display font-semibold text-fg">WhatsApp</p>
                        <p class="text-sm text-fg/50">{{ $brand->whatsapp_number }}</p>
                    </div>
                </a>

                @if ($brand->instagram_handle)
                    <a href="https://instagram.com/{{ $brand->instagram_handle }}" target="_blank" rel="noopener"
                       data-reveal style="transition-delay: 80ms" class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-pink-500/15 text-pink-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.06 2 .25 2.4.42.6.24 1 .53 1.5 1s.76.9 1 1.5c.17.4.36 1.2.42 2.4.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.06 1.2-.25 2-.42 2.4a4 4 0 01-1 1.5 4 4 0 01-1.5 1c-.4.17-1.2.36-2.4.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.06-2-.25-2.4-.42a4 4 0 01-1.5-1 4 4 0 01-1-1.5c-.17-.4-.36-1.2-.42-2.4C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.06-1.2.25-2 .42-2.4a4 4 0 011-1.5 4 4 0 011.5-1c.4-.17 1.2-.36 2.4-.42C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-1 .04-1.5.2-1.86.34-.47.18-.8.4-1.15.75s-.57.68-.75 1.15c-.14.36-.3.86-.34 1.86C3.07 9.28 3.07 9.65 3.07 12s0 2.72.07 3.96c.04 1 .2 1.5.34 1.86.18.47.4.8.75 1.15s.68.57 1.15.75c.36.14.86.3 1.86.34 1.24.06 1.61.07 4.76.07s3.52 0 4.76-.07c1-.04 1.5-.2 1.86-.34.47-.18.8-.4 1.15-.75s.57-.68.75-1.15c.14-.36.3-.86.34-1.86.06-1.24.07-1.61.07-3.96s0-2.72-.07-3.96c-.04-1-.2-1.5-.34-1.86a3 3 0 00-.75-1.15 3 3 0 00-1.15-.75c-.36-.14-.86-.3-1.86-.34C15.52 4 15.15 4 12 4zm0 3.4a4.6 4.6 0 110 9.2 4.6 4.6 0 010-9.2zm0 1.8a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6zm5.8-2a1.08 1.08 0 11-2.16 0 1.08 1.08 0 012.16 0z"/></svg>
                        </span>
                        <div>
                            <p class="font-display font-semibold text-fg">Instagram</p>
                            <p class="text-sm text-fg/50">@{{ $brand->instagram_handle }}</p>
                        </div>
                    </a>
                @endif

                @if ($brand->mail_from_address)
                    <a href="mailto:{{ $brand->mail_from_address }}"
                       data-reveal style="transition-delay: 160ms" class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-primary/15 text-brand-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z"/></svg>
                        </span>
                        <div>
                            <p class="font-display font-semibold text-fg">Emel</p>
                            <p class="text-sm text-fg/50">{{ $brand->mail_from_address }}</p>
                        </div>
                    </a>
                @endif

                @if ($brand->address)
                    <div data-reveal style="transition-delay: 240ms" class="glass-card flex items-center gap-4 rounded-2xl p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-fg/10 text-fg/70">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.5 7-11a7 7 0 10-14 0c0 4.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        </span>
                        <div>
                            <p class="font-display font-semibold text-fg">Lokasi</p>
                            <p class="text-sm text-fg/50">{{ $brand->address }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
