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
        $this->seedCoreMemory();
    }

    private function seedCeritaConvo(): void
    {
        $brand = Brand::where('code', 'ceritaconvo')->firstOrFail();

        // Superseded by the real 2-package lineup below (CeritaConvo is a
        // solo photographer — this used to model a 3-tier studio business
        // that never existed).
        Package::where('brand_id', $brand->id)
            ->whereIn('slug', ['pakej-asas', 'pakej-premium', 'pakej-eksklusif'])
            ->get()
            ->each(fn (Package $p) => $p->addons()->detach());
        Package::where('brand_id', $brand->id)
            ->whereIn('slug', ['pakej-asas', 'pakej-premium', 'pakej-eksklusif'])
            ->delete();
        Addon::where('brand_id', $brand->id)
            ->whereIn('code', ['extra-foto-10', 'album-tambahan', 'extra-pax', 'drone-shot', 'tambahan-30-minit'])
            ->delete();

        $personal = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'photoshoot-personal'],
            [
                'name' => 'Photoshoot Personal',
                'tier' => null,
                'tagline' => 'Preconvo/postconvo — a personal photographer for you & your family',
                'description' => null,
                'price_cents' => 33000,
                'deposit_fixed_cents' => 5000,
                'cover_image_path' => 'images/packages/photoshoot-personal.jpg',
                'duration_minutes' => 60,
                'session_slots_required' => 1,
                'max_pax' => null,
                'edited_photos_count' => null,
                'delivery_days' => 21,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );
        $this->items($personal, [
            ['1 hour coverage', false],
            ['Shoot and edit', true],
            ['Unlimited photos', true],
            ['Best edited photos', true],
            ['Delivered via Google Photos', false],
        ]);

        $grouping = Package::updateOrCreate(
            ['brand_id' => $brand->id, 'slug' => 'grouping'],
            [
                'name' => 'Grouping',
                'tier' => null,
                'tagline' => 'Preconvo/postconvo — group photos, priced per head',
                'description' => "3-5 people: RM120/head (1 hour 30 minutes coverage).\n6 people and above: RM90/head (2 hours coverage).",
                'price_cents' => 9000,
                'price_note' => 'RM120/head (3-5 people) · RM90/head (6+ people)',
                'deposit_fixed_cents' => 5000,
                'cover_image_path' => 'images/packages/grouping.jpg',
                'duration_minutes' => null,
                'session_slots_required' => 1,
                'max_pax' => null,
                'edited_photos_count' => null,
                'delivery_days' => 21,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );
        $this->items($grouping, [
            ['Shoot and edit', true],
            ['Unlimited photos', true],
            ['Best edited photos', true],
            ['Delivered via Google Photos', false],
            ['Transportation included', false, false],
        ]);

        $extraTime = Addon::updateOrCreate(
            ['brand_id' => $brand->id, 'code' => 'extra-30-minutes'],
            ['name' => 'Extra 30 Minutes', 'price_cents' => 10000, 'unit' => 'unit']
        );

        foreach ([$personal, $grouping] as $pkg) {
            $pkg->addons()->syncWithoutDetaching([
                $extraTime->id => ['sort_order' => 1],
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
