@php($midnight = ($variant ?? 'editorial') === 'midnight')
<section id="packages" class="scroll-mt-20 {{ $midnight ? 'bg-[#191315] text-[#f8f0e4]' : 'bg-[#fffaf4] text-[#4a3b31]' }} py-20 md:py-28">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end" data-reveal>
            <div><p class="text-xs font-semibold uppercase tracking-[.3em] {{ $midnight ? 'text-[#d6ae75]' : 'text-[#a66b76]' }}">CoreMemory packages</p><h2 class="font-display mt-4 text-5xl tracking-tight">Pilih cara kami<br><em class="font-normal {{ $midnight ? 'text-[#d4a866]' : 'text-[#b77d86]' }}">merakam hari anda.</em></h2></div>
            <p class="max-w-xs leading-7 {{ $midnight ? 'text-[#bcaea4]' : 'text-[#78675c]' }}">Setiap pakej boleh disesuaikan mengikut perjalanan unik majlis anda.</p>
        </div>
        <div class="mt-12 grid gap-5 md:grid-cols-3">
            @forelse($packages as $package)
                <article data-reveal class="rounded-3xl border p-7 {{ $midnight ? 'border-[#d4a866]/25 bg-white/5' : 'border-[#decabb] bg-[#faf1e8]' }}">
                    @if($package->is_featured)<span class="text-[10px] font-bold uppercase tracking-[.18em] {{ $midnight ? 'text-[#d6ae75]' : 'text-[#a66b76]' }}">Paling popular</span>@endif
                    <h3 class="font-display mt-3 text-3xl">{{ $package->name }}</h3><p class="mt-2 min-h-12 text-sm leading-6 {{ $midnight ? 'text-[#bcaea4]' : 'text-[#78675c]' }}">{{ $package->tagline }}</p>
                    <p class="font-display mt-6 text-3xl {{ $midnight ? 'text-[#d4a866]' : 'text-[#8f5e62]' }}">{{ $package->price_cents->format() }}</p>
                    <ul class="mt-6 space-y-2 text-sm {{ $midnight ? 'text-[#d7c9bd]' : 'text-[#654f40]' }}">@foreach($package->items->where('is_highlight', true)->take(3) as $item)<li>✦ {{ $item->label }}</li>@endforeach</ul>
                    <a href="#contact" class="mt-7 inline-block text-xs font-bold uppercase tracking-[.15em] {{ $midnight ? 'text-[#d6ae75]' : 'text-[#a66b76]' }}">Tanya pakej →</a>
                </article>
            @empty
                <p class="text-sm">Pakej akan dikemaskini tidak lama lagi.</p>
            @endforelse
        </div>
    </div>
</section>
