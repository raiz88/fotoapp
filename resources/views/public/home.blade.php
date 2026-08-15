@extends('public.layouts.brand')

@section('title', $brand->name . ' — ' . $brand->tagline)
@section('description', $brand->tagline)

@push('scripts')
    @vite(['resources/js/home.js'])
@endpush

@section('content')
    {{-- Hero --}}
    <section class="relative flex min-h-[85vh] items-center overflow-hidden">
        <div class="glow-field"></div>
        <div id="home-hero-canvas" class="absolute inset-0 z-[1]" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto max-w-3xl px-4 text-center">
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">{{ $brand->name }}</p>
            <h1 class="font-display mx-auto mt-6 max-w-2xl text-5xl font-bold leading-[1.05] tracking-tight text-fg text-glow md:text-7xl">
                {{ $brand->tagline }}
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-fg/60">
                A dedicated photographer for your convocation day — from solo portraits to group photos.
            </p>
            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="#booking"
                   class="rounded-full bg-brand-primary px-8 py-3.5 font-semibold text-black shadow-[0_0_40px_-10px_var(--brand-primary)] transition hover:brightness-110">
                    Book Now
                </a>
                <a href="#packages" class="glow-border rounded-full px-8 py-3.5 font-semibold text-fg">
                    View Packages
                </a>
            </div>
        </div>
    </section>

    {{-- About the photographer --}}
    <section id="about" class="relative mx-auto max-w-2xl px-4 py-24">
        <div class="text-center" data-reveal>
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Behind the Lens</p>
            <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">Meet Your Photographer</h2>
        </div>

        <div data-reveal style="transition-delay: 100ms" class="glass-card glow-border mt-10 rounded-3xl p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-primary/15 font-display text-xl font-semibold text-brand-primary">
                CC
            </div>
            <p class="mt-5 text-fg/70">
                {{ $brand->name }} is a one-person operation — every session is shot and edited personally,
                start to finish, so you get the same style and quality every time. No hand-offs, no
                second-guessing who's behind the camera on your big day.
            </p>
            @if ($brand->instagram_handle)
                <a href="https://instagram.com/{{ $brand->instagram_handle }}" target="_blank" rel="noopener"
                   class="mt-4 inline-block text-sm font-semibold text-brand-primary">
                    {{ '@'.$brand->instagram_handle }}
                </a>
            @endif
        </div>
    </section>

    {{-- Packages --}}
    <section id="packages" class="relative mx-auto max-w-2xl px-4 py-24">
        <div class="text-center" data-reveal>
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Packages</p>
            <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">Choose Your Package</h2>
        </div>

        <div class="mt-14 space-y-10">
            @forelse ($packages as $package)
                <div data-reveal style="transition-delay: {{ $loop->index * 100 }}ms"
                     class="glass-card glow-border overflow-hidden rounded-3xl">
                    @if ($package->cover_image_path)
                        <img src="{{ asset($package->cover_image_path) }}" alt="{{ $package->name }}"
                             data-full-src="{{ asset($package->cover_image_path) }}"
                             class="package-image-trigger w-full cursor-pointer transition duration-300 hover:brightness-110">
                    @endif

                    <div class="p-6 text-center">
                        <a href="#booking" data-package-id="{{ $package->id }}"
                           class="book-package-link inline-block rounded-full bg-brand-primary px-8 py-3 text-sm font-semibold text-black transition hover:brightness-110">
                            Book This Package
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-fg/50">Packages will be listed here soon.</p>
            @endforelse
        </div>
    </section>

    {{-- Terms & Conditions --}}
    <section id="terms" class="relative overflow-hidden py-24">
        @if ($brand->code === 'ceritaconvo')
            <div class="absolute inset-x-0 top-0 h-72 overflow-hidden">
                <img src="{{ asset('images/terms-bg.jpg') }}" alt="" class="h-full w-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[var(--color-ink)]"></div>
            </div>
        @endif
        <div class="glow-field opacity-60"></div>

        <div class="relative z-10 mx-auto max-w-2xl px-4">
            <div class="text-center" data-reveal>
                <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Terms &amp; Conditions</p>
                <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">Please Read Before Booking</h2>
            </div>

            @if ($brand->default_terms)
                <ul class="glass-card mt-12 space-y-4 rounded-3xl p-8 text-sm text-fg/70" data-reveal>
                    @foreach (preg_split('/\r?\n/', trim($brand->default_terms)) as $line)
                        @continue(trim($line) === '')
                        <li class="flex items-start gap-3">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-primary"></span>
                            <span>{{ $line }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-12 text-center text-fg/50">Terms &amp; conditions will be updated soon.</p>
            @endif
        </div>
    </section>

    {{-- Gallery --}}
    <section id="gallery" class="relative mx-auto max-w-2xl px-4 py-24">
        <div class="text-center" data-reveal>
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Gallery</p>
            <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">Our Work</h2>
        </div>

        @foreach (['Solo Photography' => 'solo', 'Group Photography' => 'group'] as $label => $key)
            <div class="mt-14">
                <h3 class="font-display text-center text-xl font-semibold text-fg" data-reveal>{{ $label }}</h3>
                <div class="mt-6 space-y-4">
                    @foreach (range(1, 4) as $i)
                        <div data-reveal
                             class="glow-border relative flex aspect-square items-center overflow-hidden rounded-2xl"
                             style="transition-delay: {{ ($i - 1) * 60 }}ms; background: radial-gradient(120% 120% at 20% 10%, color-mix(in srgb, var(--brand-primary) {{ 25 + ($i % 4) * 10 }}%, #0e0e13), #050507 80%);">
                            <span class="m-auto text-xs font-semibold uppercase tracking-[0.2em] text-fg/40">Sample {{ $i }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <p class="mt-10 text-center text-sm text-fg/40">
            Want to see our full portfolio? <a href="#contact" class="font-semibold text-brand-primary">Get in touch</a>.
        </p>
    </section>

    {{-- Contact --}}
    <section id="contact" class="relative mx-auto max-w-2xl px-4 py-24 text-center">
        <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary" data-reveal>Contact</p>
        <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl" data-reveal>Get In Touch</h2>
        <p class="mx-auto mt-3 max-w-md text-sm text-fg/50" data-reveal>
            Follow us or reach out directly — we'd love to hear from you.
        </p>

        <div class="mt-12 grid gap-5 sm:grid-cols-2">
            @if ($brand->instagram_handle)
                <a href="https://instagram.com/{{ $brand->instagram_handle }}" target="_blank" rel="noopener"
                   data-reveal class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-pink-500/15 text-pink-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.06 2 .25 2.4.42.6.24 1 .53 1.5 1s.76.9 1 1.5c.17.4.36 1.2.42 2.4.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.06 1.2-.25 2-.42 2.4a4 4 0 01-1 1.5 4 4 0 01-1.5 1c-.4.17-1.2.36-2.4.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.06-2-.25-2.4-.42a4 4 0 01-1.5-1 4 4 0 01-1-1.5c-.17-.4-.36-1.2-.42-2.4C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.06-1.2.25-2 .42-2.4a4 4 0 011-1.5 4 4 0 011.5-1c.4-.17 1.2-.36 2.4-.42C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.15 0-3.52 0-4.76.07-1 .04-1.5.2-1.86.34-.47.18-.8.4-1.15.75s-.57.68-.75 1.15c-.14.36-.3.86-.34 1.86C3.07 9.28 3.07 9.65 3.07 12s0 2.72.07 3.96c.04 1 .2 1.5.34 1.86.18.47.4.8.75 1.15s.68.57 1.15.75c.36.14.86.3 1.86.34 1.24.06 1.61.07 4.76.07s3.52 0 4.76-.07c1-.04 1.5-.2 1.86-.34.47-.18.8-.4 1.15-.75s.57-.68.75-1.15c.14-.36.3-.86.34-1.86.06-1.24.07-1.61.07-3.96s0-2.72-.07-3.96c-.04-1-.2-1.5-.34-1.86a3 3 0 00-.75-1.15 3 3 0 00-1.15-.75c-.36-.14-.86-.3-1.86-.34C15.52 4 15.15 4 12 4zm0 3.4a4.6 4.6 0 110 9.2 4.6 4.6 0 010-9.2zm0 1.8a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6zm5.8-2a1.08 1.08 0 11-2.16 0 1.08 1.08 0 012.16 0z"/></svg>
                    </span>
                    <div>
                        <p class="font-display font-semibold text-fg">Instagram</p>
                        <p class="text-sm text-fg/50">{{ '@'.$brand->instagram_handle }}</p>
                    </div>
                </a>
            @endif

            @if ($brand->tiktok_handle)
                <a href="{{ 'https://tiktok.com/@'.$brand->tiktok_handle }}" target="_blank" rel="noopener"
                   data-reveal style="transition-delay: 80ms" class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-fg/10 text-fg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M16.6 5.82a4.28 4.28 0 01-3.1-1.32V14.5a5.68 5.68 0 11-4.9-5.63v2.4a3.28 3.28 0 103.24 3.23V2h2.5a4.27 4.27 0 001.26 3.02 4.28 4.28 0 003 1.24V8.7a6.75 6.75 0 01-1.99-.29z"/></svg>
                    </span>
                    <div>
                        <p class="font-display font-semibold text-fg">TikTok</p>
                        <p class="text-sm text-fg/50">{{ '@'.$brand->tiktok_handle }}</p>
                    </div>
                </a>
            @endif

            @if ($brand->whatsapp_number)
                <a href="{{ $brand->whatsappUrl('Hi ' . $brand->name . ', I have a question.') }}" target="_blank" rel="noopener"
                   data-reveal style="transition-delay: 160ms" class="glass-card glow-border flex items-center gap-4 rounded-2xl p-6 sm:col-span-2">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-500/15 text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.6 1.4 5.2L2 22l4.9-1.3C8.4 21.5 10.1 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.6 0-3.1-.4-4.4-1.2l-.3-.2-3 .8.8-2.9-.2-.3C4.4 15 4 13.5 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8z"/></svg>
                    </span>
                    <div>
                        <p class="font-display font-semibold text-fg">WhatsApp</p>
                        <p class="text-sm text-fg/50">{{ $brand->whatsapp_number }}</p>
                    </div>
                </a>
            @endif
        </div>
    </section>

    {{-- Booking --}}
    <section id="booking" class="relative mx-auto max-w-xl px-4 py-24">
        <div class="text-center" data-reveal>
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Booking</p>
            <h2 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">Book Your Session</h2>
            <p class="mt-3 text-sm text-fg/50">
                Pick a date and time slot first — we'll let you know right away if it's already taken.
            </p>
        </div>

        @if (session('booking_confirmed'))
            <div class="mt-8 rounded-2xl border border-brand-primary/40 bg-brand-primary/10 px-5 py-4 text-center text-sm font-medium text-fg">
                Your booking is confirmed! We'll reach out shortly to confirm the details.
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}" class="glass-card glow-border mt-8 rounded-3xl p-8" data-reveal style="transition-delay: 120ms">
            @csrf

            <div>
                <label for="customer_name" class="text-sm font-medium text-fg/80">Full Name</label>
                <input type="text" name="customer_name" id="customer_name" required value="{{ old('customer_name') }}"
                       class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                @error('customer_name')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="customer_phone" class="text-sm font-medium text-fg/80">Phone Number</label>
                <input type="text" name="customer_phone" id="customer_phone" required value="{{ old('customer_phone') }}"
                       class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                @error('customer_phone')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="booking_date" class="text-sm font-medium text-fg/80">Date</label>
                <input type="date" name="booking_date" id="booking_date" required value="{{ old('booking_date') }}"
                       min="{{ now()->toDateString() }}"
                       class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                @error('booking_date')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="time_slot" class="text-sm font-medium text-fg/80">Time Slot</label>
                <select name="time_slot" id="time_slot" required
                        class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                    <option value="" disabled {{ old('time_slot') ? '' : 'selected' }}>Select a time slot</option>
                    @foreach ($timeSlots as $key => $label)
                        <option value="{{ $key }}" {{ old('time_slot') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('time_slot')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="package_id" class="text-sm font-medium text-fg/80">Package</label>
                <select name="package_id" id="package_id"
                        class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">
                    <option value="">Not sure yet</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" {{ (string) old('package_id') === (string) $package->id ? 'selected' : '' }}>
                            {{ $package->name }} — {{ $package->price_cents->format() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <label for="notes" class="text-sm font-medium text-fg/80">Notes (optional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-2 w-full rounded-xl border border-fg/10 bg-fg/5 px-4 py-2.5 text-sm text-fg focus:border-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-primary/30">{{ old('notes') }}</textarea>
            </div>

            <button type="submit"
                    class="mt-7 w-full rounded-full bg-brand-primary py-3 font-semibold text-black shadow-[0_0_30px_-8px_var(--brand-primary)] transition hover:brightness-110">
                Confirm Booking
            </button>
        </form>
    </section>

    {{-- Package image modal (tap to zoom in and read package details) --}}
    <div id="package-image-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-4">
        <button id="package-image-modal-close" type="button" aria-label="Close"
                class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-fg/10 text-fg">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
        <img id="package-image-modal-img" src="" alt="" class="max-h-full max-w-full rounded-2xl object-contain">
    </div>
@endsection
