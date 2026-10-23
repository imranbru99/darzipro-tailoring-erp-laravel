<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\TailoringOrder;
use App\Services\TailoringDomainService;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function home()
    {
        $branches = Branch::where('is_active', true)->get();
        $featuredFabrics = Product::where('is_active', true)->where('product_type', 'fabric')->take(6)->get();
        $garmentTypes = TailoringDomainService::getGarmentTypes();

        return view('public.home', compact('branches', 'featuredFabrics', 'garmentTypes'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        $products = $query->latest()->paginate(12);
        return view('public.catalog', compact('products'));
    }
}
