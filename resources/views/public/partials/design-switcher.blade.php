@php($previewRoute = request()->routeIs('gallery') ? 'gallery' : 'home')
<aside class="fixed bottom-4 right-4 z-50 rounded-2xl border border-black/10 bg-white/90 p-2 shadow-xl backdrop-blur-md">
    <p class="px-2 pb-1 pt-0.5 text-[9px] font-bold uppercase tracking-[.18em] text-stone-500">Preview design</p>
    <div class="flex gap-1">
        <a href="{{ route($previewRoute, ['brand' => 'corememory', 'design' => 'editorial']) }}" class="rounded-xl px-3 py-2 text-xs font-semibold {{ $design === 'editorial' ? 'bg-[#6b454a] text-white' : 'text-stone-600 hover:bg-stone-100' }}">I</a>
        <a href="{{ route($previewRoute, ['brand' => 'corememory', 'design' => 'garden']) }}" class="rounded-xl px-3 py-2 text-xs font-semibold {{ $design === 'garden' ? 'bg-[#6b454a] text-white' : 'text-stone-600 hover:bg-stone-100' }}">II</a>
        <a href="{{ route($previewRoute, ['brand' => 'corememory', 'design' => 'midnight']) }}" class="rounded-xl px-3 py-2 text-xs font-semibold {{ $design === 'midnight' ? 'bg-[#6b454a] text-white' : 'text-stone-600 hover:bg-stone-100' }}">III</a>
    </div>
</aside>
