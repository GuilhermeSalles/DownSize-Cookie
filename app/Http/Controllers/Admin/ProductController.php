<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // opcional, já carregamos na Dashboard
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        // só superadmin via gate do middleware (routes)
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', Rule::in(['cookie', 'sandwich', 'drink', 'addon', 'other'])],
            'image_path'  => ['nullable', 'string', 'max:255'],
            'active'      => ['required', 'boolean'],
        ]);

        $product = Product::create($data);

        return back()->with('message', 'Product created.');
    }

    public function update(Request $request, Product $product)
    {
        $baseRules = [
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'price'       => ['required', 'numeric', 'min:0'],
            'active'      => ['required', 'boolean'],
        ];

        // Campos restritos a superadmin:
        if (Gate::allows('edit-product-image')) {
            $baseRules['image_path'] = ['nullable', 'string', 'max:255'];
            $baseRules['category']   = [Rule::in(['cookie', 'sandwich', 'drink', 'addon', 'other'])];
        }

        $data = $request->validate($baseRules);

        $product->update($data);

        return back()->with('message', 'Product updated.');
    }
}
