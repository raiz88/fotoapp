<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();

        return view('admin.packages.index', ['packages' => $packages]);
    }

    public function create(): View
    {
        return view('admin.packages.form', [
            'package' => new Package,
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Package::create($this->validated($request));

        return redirect()->route('admin.packages.index')->with('success', 'Pakej berjaya disimpan.');
    }

    public function edit(Package $package): View
    {
        return view('admin.packages.form', [
            'package' => $package,
            'brands' => Brand::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $package->update($this->validated($request));

        return redirect()->route('admin.packages.index')->with('success', 'Pakej berjaya dikemaskini.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Pakej dibuang.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'price_ringgit' => ['required', 'numeric', 'min:0'],
            'was_price_ringgit' => ['nullable', 'numeric', 'min:0'],
            'price_note' => ['nullable', 'string', 'max:120'],
            'duration_minutes' => ['nullable', 'integer', 'min:0'],
            'max_pax' => ['nullable', 'integer', 'min:0'],
            'edited_photos_count' => ['nullable', 'integer', 'min:0'],
            'delivery_days' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        return [
            'brand_id' => $data['brand_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'tagline' => $data['tagline'] ?? null,
            'description' => $data['description'] ?? null,
            'price_cents' => (int) round($data['price_ringgit'] * 100),
            'was_price_cents' => isset($data['was_price_ringgit']) ? (int) round($data['was_price_ringgit'] * 100) : null,
            'price_note' => $data['price_note'] ?? null,
            'duration_minutes' => $data['duration_minutes'] ?? null,
            'max_pax' => $data['max_pax'] ?? null,
            'edited_photos_count' => $data['edited_photos_count'] ?? null,
            'delivery_days' => $data['delivery_days'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->boolean('published_at') ? now() : null,
            'sort_order' => $data['sort_order'] ?? 0,
        ];
    }
}
