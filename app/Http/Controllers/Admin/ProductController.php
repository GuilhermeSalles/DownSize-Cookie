<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        // opcional, já carregamos na Dashboard
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        // Autoriza explicitamente com o guard 'admin' (sem Gate/Policy)
        $admin = auth('admin')->user();
        abort_unless($admin && strcasecmp($admin->role, 'superadmin') === 0, 403, 'Only superadmin can create products.');

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'price'       => ['required', 'numeric', 'min:0'],
            'category'    => ['required', 'in:cookie,sandwich,drink,addon,other'],
            'image_path'  => ['nullable', 'string', 'max:255'],
            'active'      => ['boolean'],
        ]);

        Product::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'category'    => $data['category'],
            'image_path'  => $data['image_path'] ?? null,
            'active'      => $data['active'] ?? true,
        ]);

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
        if (Gate::forUser(auth('admin')->user())->allows('edit-product-image')) {
            $baseRules['image_path'] = ['nullable', 'string', 'max:255'];
            $baseRules['category']   = [Rule::in(['cookie', 'sandwich', 'drink', 'addon', 'other'])];
        }


        $data = $request->validate($baseRules);

        $product->update($data);

        return back()->with('message', 'Product updated.');
    }
}
