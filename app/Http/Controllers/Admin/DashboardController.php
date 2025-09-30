<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\AdminUser;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var AdminUser|null $admin */
        $admin = auth('admin')->user();

        // Fallback robusto: usa role direto; se Gate estiver OK, ele só confirma
        $isSuper = $admin && strcasecmp($admin->role, 'superadmin') === 0;

        $canCreate = $isSuper || ($admin ? Gate::forUser($admin)->allows('create-products') : false);
        $canEditImage = $isSuper || ($admin ? Gate::forUser($admin)->allows('edit-product-image') : false);

        return Inertia::render('admin/dashboard', [
            'admin' => $admin ? [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role,
                'profile_image' => $admin->profile_image,
            ] : null,

            'csrfToken' => csrf_token(),
            'products'  => Product::orderBy('name')->get(),

            'can' => [
                'create'     => (bool) $canCreate,
                'edit_image' => (bool) $canEditImage,
            ],
        ]);
    }
    public function metrics()
    {
        // Orders por status
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as qty'))
            ->groupBy('status')
            ->pluck('qty', 'status'); // => ["pending" => 3, "confirmed" => 2, ...]

        // Products por category
        $productsByCategory = Product::select('category', DB::raw('COUNT(*) as qty'))
            ->groupBy('category')
            ->pluck('qty', 'category'); // => ["cookie" => 10, "drink" => 2, ...]

        // Orders últimos 7 dias
        $start = Carbon::now()->subDays(6)->startOfDay();
        $ordersDaily = Order::select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as qty'))
            ->where('created_at', '>=', $start)
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->keyBy('d');

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $day = Carbon::now()->subDays(6 - $i)->toDateString();
            $days[] = [
                'date' => Carbon::parse($day)->format('d/m'),
                'qty'  => (int)($ordersDaily[$day]->qty ?? 0),
            ];
        }

        return response()->json([
            'ordersByStatus'     => (object) $ordersByStatus,     // objeto p/ teu front
            'productsByCategory' => (object) $productsByCategory, // idem
            'ordersLast7Days'    => $days,
        ]);
    }
}
