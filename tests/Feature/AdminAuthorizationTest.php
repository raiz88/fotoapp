<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('http://admin.localhost/dashboard')->assertRedirect('http://admin.localhost/login');
    }

    public function test_staff_cannot_manage_packages(): void
    {
        $staff = User::factory()->create(['role' => User::ROLE_STAFF]);

        $this->actingAs($staff)
            ->get('http://admin.localhost/packages')
            ->assertForbidden();
    }

    public function test_owner_can_manage_packages(): void
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);

        $this->actingAs($owner)
            ->get('http://admin.localhost/packages')
            ->assertOk();
    }

    public function test_inactive_user_is_logged_out(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_OWNER, 'is_active' => false]);

        $this->actingAs($user)
            ->get('http://admin.localhost/dashboard')
            ->assertForbidden();
    }

    public function test_owner_can_create_a_package_for_a_brand(): void
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $brand = Brand::factory()->create();

        $response = $this->actingAs($owner)->post('http://admin.localhost/packages', [
            'brand_id' => $brand->id,
            'name' => 'Pakej Test',
            'slug' => 'pakej-test',
            'price_ringgit' => '499.00',
            'is_active' => '1',
            'published_at' => '1',
        ]);

        $response->assertRedirect('http://admin.localhost/packages');
        $this->assertDatabaseHas('packages', [
            'slug' => 'pakej-test',
            'price_cents' => 49900,
        ]);
    }
}
