<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index() {
        $bundles = Product::orderBy('name', 'ASC')
            ->active()
            ->BundleType()
            ->get();
        $bundlesFeatured = Product::orderBy('featured_order', 'ASC')
            ->active()
            ->BundleType()
            ->BundleFeatured()
            ->get();

        return view('front.bundle', compact('bundles', 'bundlesFeatured'));
    }
    public function show($slug) {
        $bundle = Product::where('slug',$slug)->firstOrFail();
        if(!$bundle) abort(404, 'Bundle Not Found.');
        return view('front.bundle-detail', compact('bundle'));
    }
}
