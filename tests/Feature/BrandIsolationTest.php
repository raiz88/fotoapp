<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandIsolationTest extends TestCase
{
    use RefreshDatabase;

    private Brand $ceritaconvo;

    private Brand $corememory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ceritaconvo = Brand::factory()->create([
            'code' => 'ceritaconvo',
            'domain' => 'ceritaconvo.test',
        ]);

        $this->corememory = Brand::factory()->create([
            'code' => 'corememory',
            'domain' => 'corememory.test',
        ]);
    }

    public function test_public_package_index_only_shows_its_own_brand_packages(): void
    {
        Package::factory()->create(['brand_id' => $this->ceritaconvo->id, 'name' => 'Pakej Convo Sahaja']);
        Package::factory()->create(['brand_id' => $this->corememory->id, 'name' => 'Pakej Wedding Sahaja']);

        $response = $this->get('http://ceritaconvo.test/pakej');

        $response->assertOk();
        $response->assertSee('Pakej Convo Sahaja');
        $response->assertDontSee('Pakej Wedding Sahaja');
    }

    public function test_cross_brand_package_slug_returns_404(): void
    {
        $package = Package::factory()->create([
            'brand_id' => $this->ceritaconvo->id,
            'slug' => 'pakej-hanya-convo',
        ]);

        $this->get('http://ceritaconvo.test/pakej/'.$package->slug)->assertOk();
        $this->get('http://corememory.test/pakej/'.$package->slug)->assertNotFound();
    }

    public function test_unknown_host_returns_404(): void
    {
        $this->get('http://tiada-brand-begini.test/')->assertNotFound();
    }

    public function test_inactive_brand_is_not_resolvable(): void
    {
        $inactive = Brand::factory()->create(['domain' => 'inactive.test', 'is_active' => false]);

        $this->get('http://'.$inactive->domain.'/')->assertNotFound();
    }
}
