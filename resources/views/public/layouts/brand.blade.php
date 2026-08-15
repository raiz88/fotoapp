<!doctype html>
<html lang="{{ app()->getLocale() }}" data-brand="{{ $brand->code }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', $brand->name) &mdash; {{ $brand->tagline }}</title>
    <meta name="description" content="@yield('description', $brand->tagline)" />

    <meta property="og:title" content="@yield('title', $brand->name)" />
    <meta property="og:description" content="@yield('description', $brand->tagline)" />
    <meta property="og:type" content="website" />
    @if ($brand->og_image_path)
        <meta property="og:image" content="{{ asset($brand->og_image_path) }}" />
    @endif

    @if ($brand->favicon_path)
        <link rel="icon" href="{{ asset($brand->favicon_path) }}" />
    @endif

    <style>
        :root {
            --brand-primary: {{ $brand->primary_color }};
            --brand-secondary: {{ $brand->secondary_color ?? $brand->primary_color }};
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="min-h-screen bg-ink text-fg/80 antialiased selection:bg-brand-primary/30">

    <div class="grain-overlay"></div>

    <header class="fixed inset-x-0 top-0 z-30 border-b border-fg/5 bg-ink/70 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="font-display flex items-center gap-2 text-xl font-semibold tracking-tight text-fg">
                <span class="inline-block h-2.5 w-2.5 rounded-full bg-brand-primary shadow-[0_0_12px_2px_var(--brand-primary)]"></span>
                {{ $brand->name }}
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium text-fg/70 md:flex">
                <a href="#packages" class="transition hover:text-fg">Packages</a>
                <a href="#gallery" class="transition hover:text-fg">Gallery</a>
                <a href="#contact" class="transition hover:text-fg">Contact</a>
                <a href="#booking" class="transition hover:text-fg">Book Now</a>
            </nav>

            <a href="#booking"
               class="hidden rounded-full bg-brand-primary px-5 py-2 text-sm font-semibold text-black shadow-[0_0_30px_-8px_var(--brand-primary)] transition hover:brightness-110 md:inline-block">
                Book Now
            </a>

            <button id="nav-toggle" class="text-fg md:hidden" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav id="nav-menu" class="hidden border-t border-fg/5 px-4 py-3 text-fg/80 md:hidden">
            <a href="#packages" class="block py-2">Packages</a>
            <a href="#gallery" class="block py-2">Gallery</a>
            <a href="#contact" class="block py-2">Contact</a>
            <a href="#booking" class="mt-2 block rounded-full bg-brand-primary px-4 py-2 text-center font-semibold text-black">
                Book Now
            </a>
        </nav>
    </header>

    <main class="pt-16">
        @yield('content')
    </main>

    <footer class="relative border-t border-fg/5 bg-ink-raised">
        <div class="mx-auto max-w-6xl px-4 py-14 text-sm text-fg/50">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <p class="font-display text-lg font-semibold text-fg">{{ $brand->name }}</p>
                    <p class="mt-2">{{ $brand->tagline }}</p>
                </div>
                <div>
                    <p class="font-semibold text-fg/80">Contact</p>
                    @if ($brand->whatsapp_number)
                        <p class="mt-2">WhatsApp: {{ $brand->whatsapp_number }}</p>
                    @endif
                    @if ($brand->instagram_handle)
                        <p>Instagram: {{ '@'.$brand->instagram_handle }}</p>
                    @endif
                    @if ($brand->tiktok_handle)
                        <p>TikTok: {{ '@'.$brand->tiktok_handle }}</p>
                    @endif
                    @if ($brand->address)
                        <p>{{ $brand->address }}</p>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-fg/80">Links</p>
                    <p class="mt-2"><a href="#packages" class="transition hover:text-brand-primary">Packages</a></p>
                    <p><a href="#gallery" class="transition hover:text-brand-primary">Gallery</a></p>
                    <p><a href="#contact" class="transition hover:text-brand-primary">Contact</a></p>
                    <p><a href="#booking" class="transition hover:text-brand-primary">Book Now</a></p>
                </div>
            </div>
            <p class="mt-10 text-xs text-fg/30">&copy; {{ date('Y') }} {{ $brand->legal_name ?? $brand->name }}</p>
        </div>
    </footer>

    <a href="#booking"
       class="fixed bottom-5 right-5 z-30 flex h-14 w-14 items-center justify-center rounded-full bg-brand-primary text-black shadow-[0_0_30px_-8px_var(--brand-primary)] md:hidden"
       aria-label="Book Now">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18"/><path stroke-linecap="round" d="M9 16l2 2 4-4"/></svg>
    </a>
</body>

</html>
