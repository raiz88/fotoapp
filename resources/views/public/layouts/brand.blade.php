<!doctype html>
<html lang="ms" data-brand="{{ $brand->code }}">

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
                <a href="{{ route('home') }}" class="transition hover:text-fg">Laman Utama</a>
                <a href="{{ route('packages.index') }}" class="transition hover:text-fg">Pakej</a>
                <a href="{{ route('gallery') }}" class="transition hover:text-fg">Galeri</a>
                <a href="{{ route('contact') }}" class="transition hover:text-fg">Hubungi</a>
            </nav>

            <a href="{{ $brand->whatsappUrl('Hai ' . $brand->name . ', saya nak tanya tentang pakej.') }}"
               target="_blank" rel="noopener"
               class="hidden rounded-full bg-brand-primary px-5 py-2 text-sm font-semibold text-black shadow-[0_0_30px_-8px_var(--brand-primary)] transition hover:brightness-110 md:inline-block">
                WhatsApp Kami
            </a>

            <button id="nav-toggle" class="text-fg md:hidden" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <nav id="nav-menu" class="hidden border-t border-fg/5 px-4 py-3 text-fg/80 md:hidden">
            <a href="{{ route('home') }}" class="block py-2">Laman Utama</a>
            <a href="{{ route('packages.index') }}" class="block py-2">Pakej</a>
            <a href="{{ route('gallery') }}" class="block py-2">Galeri</a>
            <a href="{{ route('contact') }}" class="block py-2">Hubungi</a>
            <a href="{{ $brand->whatsappUrl('Hai ' . $brand->name . ', saya nak tanya tentang pakej.') }}" class="mt-2 block rounded-full bg-brand-primary px-4 py-2 text-center font-semibold text-black">
                WhatsApp Kami
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
                    <p class="font-semibold text-fg/80">Hubungi Kami</p>
                    @if ($brand->whatsapp_number)
                        <p class="mt-2">WhatsApp: {{ $brand->whatsapp_number }}</p>
                    @endif
                    @if ($brand->instagram_handle)
                        <p>Instagram: @{{ $brand->instagram_handle }}</p>
                    @endif
                    @if ($brand->address)
                        <p>{{ $brand->address }}</p>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-fg/80">Pautan</p>
                    <p class="mt-2"><a href="{{ route('packages.index') }}" class="transition hover:text-brand-primary">Semua Pakej</a></p>
                    <p><a href="{{ route('contact') }}" class="transition hover:text-brand-primary">Hubungi</a></p>
                </div>
            </div>
            <p class="mt-10 text-xs text-fg/30">&copy; {{ date('Y') }} {{ $brand->legal_name ?? $brand->name }}</p>
        </div>
    </footer>

    <a href="{{ $brand->whatsappUrl('Hai ' . $brand->name . ', saya nak tanya tentang pakej.') }}"
       target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-30 flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-fg shadow-lg md:hidden"
       aria-label="WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.6 1.4 5.2L2 22l4.9-1.3C8.4 21.5 10.1 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.6 0-3.1-.4-4.4-1.2l-.3-.2-3 .8.8-2.9-.2-.3C4.4 15 4 13.5 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8z"/></svg>
    </a>
</body>

</html>
