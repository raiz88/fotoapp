<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index(): View
    {
        $addons = Addon::with('brand')->orderBy('brand_id')->orderBy('sort_order')->get();

        return view('admin.addons.index', ['addons' => $addons]);
    }

    public function create(): View
    {
        return view('admin.addons.form', [
            'addon' => new Addon,
            'brands' => Brand::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Addon::create($this->validated($request));

        return redirect()->route('admin.addons.index')->with('success', 'Add-on berjaya disimpan.');
    }

    public function edit(Addon $addon): View
    {
        return view('admin.addons.form', [
            'addon' => $addon,
            'brands' => Brand::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Addon $addon): RedirectResponse
    {
        $addon->update($this->validated($request));

        return redirect()->route('admin.addons.index')->with('success', 'Add-on berjaya dikemaskini.');
    }

    public function destroy(Addon $addon): RedirectResponse
    {
        $addon->delete();

        return redirect()->route('admin.addons.index')->with('success', 'Add-on dibuang.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'code' => ['required', 'string', 'max:40'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'price_ringgit' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'in:unit,hour,pax,km,flat'],
            'min_qty' => ['nullable', 'integer', 'min:1'],
            'max_qty' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        return [
            'brand_id' => $data['brand_id'],
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price_cents' => (int) round($data['price_ringgit'] * 100),
            'unit' => $data['unit'],
            'min_qty' => $data['min_qty'] ?? 1,
            'max_qty' => $data['max_qty'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $data['sort_order'] ?? 0,
        ];
    }
}
