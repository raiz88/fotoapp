<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Brand;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCeritaConvo();
        $this->seedCoreMemory();
    }

    private function seedCeritaConvo(): void
    {
        $brand = Brand::where('code', 'ceritaconvo')->firstOrFail();

        $asas = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-asas'],
            [
                'name' => 'Pakej Asas',
                'tier' => 'basic',
                'tagline' => 'Untuk yang nak simpan kenangan konvo tanpa berbelanja besar',
                'description' => 'Sesi bergambar konvokesyen ringkas di studio dengan backdrop pilihan.',
                'price_cents' => 35000,
                'duration_minutes' => 30,
                'session_slots_required' => 1,
                'max_pax' => 2,
                'edited_photos_count' => 15,
                'delivery_days' => 7,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );
        $this->items($asas, [
            ['1 sesi bergambar (30 minit)', false],
            ['15 keping gambar edit', true],
            ['Softcopy resolusi tinggi', false],
            ['1 backdrop studio pilihan', false],
            ['Album cetak', false, false],
        ]);

        $premium = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-premium'],
            [
                'name' => 'Pakej Premium',
                'tier' => 'silver',
                'tagline' => 'Pilihan popular — lebih gambar, ada album cetak',
                'description' => 'Sesi konvo lebih lengkap dengan album cetak dan lebih banyak gambar edit.',
                'price_cents' => 55000,
                'was_price_cents' => 65000,
                'duration_minutes' => 45,
                'session_slots_required' => 1,
                'max_pax' => 4,
                'edited_photos_count' => 30,
                'delivery_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );
        $this->items($premium, [
            ['1 sesi bergambar (45 minit)', false],
            ['30 keping gambar edit', true],
            ['Album cetak 8R (20 muka surat)', true],
            ['Softcopy resolusi tinggi', false],
            ['2 backdrop studio pilihan', false],
            ['Props konvo percuma', false],
        ]);

        $eksklusif = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-eksklusif'],
            [
                'name' => 'Pakej Eksklusif',
                'tier' => 'gold',
                'tagline' => 'Liputan penuh indoor + outdoor untuk hari besar anda',
                'description' => 'Dua sesi (studio dan outdoor kampus) dengan album premium.',
                'price_cents' => 85000,
                'duration_minutes' => 90,
                'session_slots_required' => 2,
                'max_pax' => 6,
                'edited_photos_count' => 50,
                'delivery_days' => 10,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'published_at' => now(),
            ]
        );
        $this->items($eksklusif, [
            ['2 sesi bergambar (studio + outdoor kampus)', false],
            ['50 keping gambar edit', true],
            ['Album premium kulit (30 muka surat)', true],
            ['Softcopy resolusi tinggi', false],
            ['Extra pax sehingga 6 orang', false],
            ['1 drone shot percuma', true],
        ]);

        $extraFoto = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'extra-foto-10'],
            ['name' => 'Extra 10 Gambar Edit', 'price_cents' => 5000, 'unit' => 'unit']
        );
        $albumTambahan = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'album-tambahan'],
            ['name' => 'Album Cetak Tambahan', 'price_cents' => 8000, 'unit' => 'unit']
        );
        $extraPax = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'extra-pax'],
            ['name' => 'Extra Pax (Keluarga)', 'price_cents' => 3000, 'unit' => 'pax', 'max_qty' => 10]
        );
        $drone = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'drone-shot'],
            ['name' => 'Drone Shot', 'price_cents' => 15000, 'unit' => 'flat']
        );

        foreach ([$asas, $premium, $eksklusif] as $pkg) {
            $pkg->addons()->syncWithoutDetaching([
                $extraFoto->id => ['sort_order' => 1],
                $albumTambahan->id => ['sort_order' => 2],
                $extraPax->id => ['sort_order' => 3],
                $drone->id => ['sort_order' => 4, 'is_recommended' => $pkg->is($eksklusif)],
            ]);
        }
    }

    private function seedCoreMemory(): void
    {
        $brand = Brand::where('code', 'corememory')->firstOrFail();

        $silver = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-silver'],
            [
                'name' => 'Pakej Silver',
                'tier' => 'silver',
                'tagline' => 'Liputan akad dan resepsi untuk majlis sederhana',
                'description' => 'Liputan fotografi akad nikah dan resepsi sehingga 8 jam.',
                'price_cents' => 250000,
                'duration_minutes' => 480,
                'session_slots_required' => 1,
                'edited_photos_count' => 100,
                'delivery_days' => 21,
                'travel_included_km' => 40,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );
        $this->items($silver, [
            ['Liputan akad + resepsi (8 jam)', false],
            ['100 keping gambar edit', true],
            ['Softcopy resolusi tinggi', false],
            ['1 jurugambar', false],
            ['Album cetak', false, false],
        ]);

        $gold = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-gold'],
            [
                'name' => 'Pakej Gold',
                'tier' => 'gold',
                'tagline' => 'Liputan sepanjang hari dengan album dan highlight video',
                'description' => 'Liputan penuh sepanjang hari majlis dengan album cetak dan video highlight.',
                'price_cents' => 420000,
                'was_price_cents' => 480000,
                'duration_minutes' => 720,
                'session_slots_required' => 1,
                'edited_photos_count' => 200,
                'delivery_days' => 21,
                'travel_included_km' => 60,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );
        $this->items($gold, [
            ['Liputan sepanjang hari (12 jam)', false],
            ['200 keping gambar edit', true],
            ['Album cetak 30 muka surat', true],
            ['Video highlight same-day edit', true],
            ['2 jurugambar', false],
            ['Softcopy resolusi tinggi', false],
        ]);

        $platinum = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'pakej-platinum'],
            [
                'name' => 'Pakej Platinum',
                'tier' => 'gold',
                'tagline' => 'Pengalaman penuh — pre-wedding, majlis, dan videografi kru berganda',
                'description' => 'Pakej paling lengkap: sesi pre-wedding, liputan sepanjang hari, dan pasukan videografi.',
                'price_cents' => 650000,
                'duration_minutes' => 720,
                'session_slots_required' => 1,
                'edited_photos_count' => 300,
                'delivery_days' => 30,
                'travel_included_km' => 100,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'published_at' => now(),
            ]
        );
        $this->items($platinum, [
            ['Sesi pre-wedding (separuh hari)', false],
            ['Liputan sepanjang hari majlis (12 jam)', false],
            ['300 keping gambar edit', true],
            ['Album premium kulit (40 muka surat)', true],
            ['Videografi 2 kru + highlight video', true],
            ['3 jurugambar', false],
        ]);

        $extraJam = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'extra-jam'],
            ['name' => 'Extra Jam Liputan', 'price_cents' => 20000, 'unit' => 'hour', 'max_qty' => 4]
        );
        $droneWedding = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'drone-shot'],
            ['name' => 'Drone Shot', 'price_cents' => 30000, 'unit' => 'flat']
        );
        $sameDayEdit = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'same-day-edit'],
            ['name' => 'Same-Day Edit Video', 'price_cents' => 50000, 'unit' => 'flat']
        );
        $extraAlbum = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'extra-album'],
            ['name' => 'Extra Album', 'price_cents' => 35000, 'unit' => 'unit']
        );

        foreach ([$silver, $gold, $platinum] as $pkg) {
            $pkg->addons()->syncWithoutDetaching([
                $extraJam->id => ['sort_order' => 1],
                $droneWedding->id => ['sort_order' => 2],
                $sameDayEdit->id => ['sort_order' => 3, 'is_recommended' => $pkg->is($silver)],
                $extraAlbum->id => ['sort_order' => 4],
            ]);
        }
    }

    /**
     * @param  array<int, array{0: string, 1: bool, 2?: bool}>  $items
     */
    private function items(Package $package, array $items): void
    {
        $package->items()->delete();

        foreach ($items as $index => [$label, $highlight]) {
            $package->items()->create([
                'label' => $label,
                'is_highlight' => $highlight,
                'is_included' => $items[$index][2] ?? true,
                'sort_order' => $index,
            ]);
        }
    }
}
