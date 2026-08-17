@extends('public.layouts.brand')

@section('title', 'Galeri Editorial — CoreMemory')

@section('content')
    @php($images = [
        ['malay-wedding-portrait.webp', 'Aisyah & Faris', 'Pelamin'],
        ['malay-wedding-detail.webp', 'Hantaran rasa', 'Detail'],
        ['malay-wedding-reception.webp', 'Raikan cinta', 'Resepsi'],
        ['malay-wedding-portrait.webp', 'Detik bersua', 'Akad nikah'],
        ['malay-wedding-reception.webp', 'Langkah baharu', 'Bersanding'],
        ['malay-wedding-detail.webp', 'Seni henna', 'Detail'],
    ])
    <section class="bg-[#faf6ef] px-4 pb-20 pt-24 text-[#2b2013] md:pb-28 md:pt-32"><div class="mx-auto max-w-6xl"><div class="max-w-2xl" data-reveal><p class="text-xs font-semibold uppercase tracking-[.3em] text-[#a66b76]">CoreMemory · Gallery I</p><h1 class="font-display mt-4 text-6xl tracking-tight md:text-8xl">Momen yang<br><em class="font-normal text-[#b77d86]">ditinggalkan.</em></h1><p class="mt-5 max-w-md leading-8 text-[#715f51]">Sampel editorial perkahwinan Melayu—daripada pelamin hingga momen kecil yang menyentuh hati.</p></div><div class="mt-12 columns-2 gap-4 md:columns-3">@foreach($images as $index => [$file, $title, $label])<figure class="mb-4 break-inside-avoid overflow-hidden rounded-2xl bg-[#eadfd4]" data-reveal><img class="w-full object-cover transition duration-700 hover:scale-105 {{ $index % 3 === 1 ? 'aspect-[4/5]' : ($index % 3 === 2 ? 'aspect-[16/10]' : 'aspect-[3/4]') }}" src="{{ asset('images/corememory/'.$file) }}" alt="{{ $title }}"><figcaption class="flex items-center justify-between p-4"><span class="font-display text-xl">{{ $title }}</span><span class="text-[10px] uppercase tracking-[.18em] text-[#a66b76]">{{ $label }}</span></figcaption></figure>@endforeach</div></div></section>
    @include('public.partials.design-switcher')
@endsection
