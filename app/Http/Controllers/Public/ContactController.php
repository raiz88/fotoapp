<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('public.contact', ['brand' => app(Brand::class)]);
    }
}
