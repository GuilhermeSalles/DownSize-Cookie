<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function index(): View
    {
        $cookies = Product::where('active', true)->where('category', 'cookie')->orderBy('name')->get();
        $sandwiches = Product::where('active', true)->where('category', 'sandwich')->orderBy('name')->get();
        $drinks = Product::where('active', true)->where('category', 'drink')->orderBy('name')->get();

        return view('site.index', [
            'cookies' => $cookies,
            'sandwiches' => $sandwiches,
            'drinks' => $drinks,
            // WhatsApp da Dona (deixa aqui para centralizar)
            'whats_phone' => '447850988160',
        ]);
    }
}
