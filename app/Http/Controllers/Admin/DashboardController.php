<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth('admin')->user();

        // Produtos para a aba Products (pode ser paginação depois)
        $products = Product::orderBy('category')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'description',
                'price',
                'category',
                'image_path',
                'active',
                'created_at',
                'updated_at'
            ]);

        // Capacidades do usuário
        $can = [
            'create'     => Gate::allows('create-products'),
            'edit_image' => Gate::allows('edit-product-image'),
        ];

        return Inertia::render('admin/dashboard', [
            'admin'      => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role,
                'profile_image' => $admin->profile_image,
            ],
            'csrfToken'  => csrf_token(),
            'products'   => $products,
            'can'        => $can,
        ]);
    }

    // Endpoint para métricas do Overview (gráficos)
    public function metrics()
    {
        // Contagem por status
        $byStatus = Order::selectRaw('status, COUNT(*) as qty')
            ->groupBy('status')
            ->pluck('qty', 'status');

        // Vendas por categoria (somatório de itens por categoria)
        $byCategory = Product::selectRaw('category, COUNT(*) as qty')
            ->groupBy('category')
            ->pluck('qty', 'category');

        // Pedidos dos últimos 7 dias (por dia)
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $count = Order::whereDate('created_at', $day)->count();
            $days->push([
                'date' => $day->format('Y-m-d'),
                'qty'  => $count,
            ]);
        }

        return response()->json([
            'ordersByStatus'    => $byStatus,
            'productsByCategory' => $byCategory,
            'ordersLast7Days'   => $days,
        ]);
    }
}
