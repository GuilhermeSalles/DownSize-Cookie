<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth('admin')->user();

        $products = Product::query()
            ->orderBy('category')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'description',
                'image_path',
                'price',
                'category',
                'active',
                'created_at',
                'updated_at'
            ]);

        return Inertia::render('admin/dashboard', [
            'admin'    => $admin,
            'products' => $products,
            'can'      => [
                'create'         => $admin && $admin->role === 'superadmin',
                'edit_image'     => $admin && $admin->role === 'superadmin',
            ],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $admin = auth('admin')->user();

        // Regras base (user/admin podem mudar apenas nome, descrição, preço, active)
        $rules = [
            'name'        => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:600'],
            'price'       => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'active'      => ['required', 'boolean'],
        ];

        // Só superadmin pode mexer em imagem e categoria
        if ($admin && $admin->role === 'superadmin') {
            $rules['image_path'] = ['nullable', 'string', 'max:255'];
            $rules['category']   = ['required', 'in:cookie,sandwich,drink,addon,other'];
        }

        $data = $request->validate($rules);

        // Se não for superadmin, garanta que não altere campos proibidos
        if (!$admin || $admin->role !== 'superadmin') {
            unset($data['image_path'], $data['category']);
        }

        $product->update($data);

        return back()->with('message', 'Product updated successfully.');
    }
}
