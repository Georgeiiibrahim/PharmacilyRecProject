<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Site;
use App\Models\Order;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'authenticate']);
    }

    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_merchants' => Merchant::count(),
            'total_users' => User::count(),
            'active_products' => Product::where('is_active', true)->count(),
        ];

        // Revenue analytics
        $revenueStats = $this->getRevenueStats();
        $siteRevenue = $this->getSiteRevenue();
        $productRevenue = $this->getProductRevenue();
        
        // Geographic and payment analytics
        $regionAnalytics = $this->getRegionAnalytics();
        $cityAnalytics = $this->getCityAnalytics();
        $paymentMethodAnalytics = $this->getPaymentMethodAnalytics();
        
        // Visitor analytics
        $visitorStats = $this->getVisitorStats();
        $visitorAnalytics = $this->getVisitorAnalytics();

        return view('admin.dashboard', compact(
            'stats', 
            'revenueStats', 
            'siteRevenue', 
            'productRevenue',
            'regionAnalytics',
            'cityAnalytics',
            'paymentMethodAnalytics',
            'visitorStats',
            'visitorAnalytics'
        ));
    }

    private function getRevenueStats()
    {
        $totalRevenue = Order::sum('revenue');
        $totalOrders = Order::count();
        $totalUnits = Order::sum('units');
        
        // Monthly revenue (last 6 months)
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(order_date) as month'),
            DB::raw('YEAR(order_date) as year'),
            DB::raw('SUM(revenue) as total_revenue'),
            DB::raw('COUNT(*) as order_count')
        )
        ->whereNotNull('order_date')
        ->where('order_date', '>=', now()->subMonths(6))
        ->groupBy(DB::raw('YEAR(order_date)'), DB::raw('MONTH(order_date)'))
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'total_units' => $totalUnits,
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
            'monthly_revenue' => $monthlyRevenue
        ];
    }

    private function getSiteRevenue()
    {
        return Site::select(
            'sites.name',
            DB::raw('SUM(orders.revenue) as total_revenue'),
            DB::raw('COUNT(orders.id) as order_count'),
            DB::raw('SUM(orders.units) as total_units')
        )
        ->leftJoin('orders', 'sites.id', '=', 'orders.site_id')
        ->groupBy('sites.id', 'sites.name')
        ->orderBy('total_revenue', 'desc')
        ->get();
    }

    private function getProductRevenue()
    {
        return Product::select(
            'products.name',
            'products.category',
            DB::raw('SUM(orders.revenue) as total_revenue'),
            DB::raw('COUNT(orders.id) as order_count'),
            DB::raw('SUM(orders.units) as total_units')
        )
        ->leftJoin('orders', 'products.id', '=', 'orders.product_id')
        ->groupBy('products.id', 'products.name', 'products.category')
        ->orderBy('total_revenue', 'desc')
        ->limit(10)
        ->get();
    }

    private function getRegionAnalytics()
    {
        return Order::select(
            'region',
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(revenue) as total_revenue'),
            DB::raw('SUM(units) as total_units'),
            DB::raw('AVG(revenue) as avg_order_value')
        )
        ->whereNotNull('region')
        ->groupBy('region')
        ->orderBy('total_revenue', 'desc')
        ->limit(10)
        ->get();
    }

    private function getCityAnalytics()
    {
        return Order::select(
            'city',
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(revenue) as total_revenue'),
            DB::raw('SUM(units) as total_units'),
            DB::raw('AVG(revenue) as avg_order_value')
        )
        ->whereNotNull('city')
        ->groupBy('city')
        ->orderBy('total_revenue', 'desc')
        ->limit(10)
        ->get();
    }

    private function getPaymentMethodAnalytics()
    {
        return Order::select(
            'payment_method',
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(revenue) as total_revenue'),
            DB::raw('SUM(units) as total_units'),
            DB::raw('AVG(revenue) as avg_order_value')
        )
        ->whereNotNull('payment_method')
        ->groupBy('payment_method')
        ->orderBy('total_revenue', 'desc')
        ->get();
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function products()
    {
        $products = Product::with('merchants')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function merchants()
    {
        $merchants = Merchant::with('products')->paginate(10);
        return view('admin.merchants.index', compact('merchants'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function seedDatabase()
    {
        try {
            // Run database seeder
            \Artisan::call('db:seed');
            
            return response()->json([
                'success' => true,
                'message' => 'Database seeded successfully with sample data.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error seeding database: ' . $e->getMessage()
            ], 500);
        }
    }

    public function refreshDatabase()
    {
        try {
            // Run fresh migrations (drops all tables and recreates them)
            \Artisan::call('migrate:fresh');
            
            // Run database seeder to populate with sample data
            \Artisan::call('db:seed');
            
            return response()->json([
                'success' => true,
                'message' => 'Database refreshed and seeded successfully. You will be redirected to login page.',
                'redirect' => '/admin/login'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error refreshing database: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getVisitorStats()
    {
        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::today()->count();
        $uniqueVisitors = Visitor::distinct('session_id')->count();
        $returningVisitors = Visitor::returningVisitors()->count();
        $newVisitors = Visitor::newVisitors()->count();
        $bounceRate = $totalVisitors > 0 ? (Visitor::bounceVisitors()->count() / $totalVisitors) * 100 : 0;
        
        // Device breakdown
        $desktopVisitors = Visitor::byDevice('desktop')->count();
        $mobileVisitors = Visitor::byDevice('mobile')->count();
        $tabletVisitors = Visitor::byDevice('tablet')->count();
        
        return [
            'total_visitors' => $totalVisitors,
            'today_visitors' => $todayVisitors,
            'unique_visitors' => $uniqueVisitors,
            'returning_visitors' => $returningVisitors,
            'new_visitors' => $newVisitors,
            'bounce_rate' => round($bounceRate, 2),
            'desktop_visitors' => $desktopVisitors,
            'mobile_visitors' => $mobileVisitors,
            'tablet_visitors' => $tabletVisitors,
        ];
    }

    private function getVisitorAnalytics()
    {
        // Top pages by visits
        $topPages = Visitor::select('page_url', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('page_url')
            ->orderBy('visit_count', 'desc')
            ->limit(10)
            ->get();
            
        // Browser breakdown
        $browserStats = Visitor::select('browser', DB::raw('COUNT(*) as count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
            
        // Device breakdown
        $deviceStats = Visitor::select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->orderBy('count', 'desc')
            ->get();
            
        // Recent visitors
        $recentVisitors = Visitor::orderBy('visited_at', 'desc')
            ->limit(10)
            ->get();
            
        return [
            'top_pages' => $topPages,
            'browser_stats' => $browserStats,
            'device_stats' => $deviceStats,
            'recent_visitors' => $recentVisitors,
        ];
    }
} 