<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $recommendations = $this->getRecommendations($request);
        $popularProducts = $this->getPopularProducts();
        $trendingProducts = $this->getTrendingProducts();
        
        return view('recommendations.index', compact('recommendations', 'popularProducts', 'trendingProducts'));
    }
    
    private function getRecommendations(Request $request)
    {
        $site = $request->get('site');
        $type = $request->get('type');
        $region = $request->get('region');
        
        $query = Product::select('products.*')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->where('products.is_active', true);
        
        // Filter by site if specified
        if ($site) {
            $query->join('sites', 'orders.site_id', '=', 'sites.id')
                  ->where('sites.name', $site);
        }
        
        // Filter by product type if specified
        if ($type) {
            $query->where('orders.type', $type);
        }
        
        // Filter by region if specified
        if ($region) {
            $query->where('orders.region', $region);
        }
        
        // Get products ordered by total units sold
        $recommendations = $query->select(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at',
                DB::raw('SUM(orders.units) as total_units_sold'),
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at'
            )
            ->orderBy('total_units_sold', 'desc')
            ->limit(12)
            ->get();
            
        return $recommendations;
    }
    
    private function getPopularProducts()
    {
        return Product::select(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at',
                DB::raw('SUM(orders.units) as total_units_sold')
            )
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->where('products.is_active', true)
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at'
            )
            ->orderBy('total_units_sold', 'desc')
            ->limit(8)
            ->get();
    }
    
    private function getTrendingProducts()
    {
        // Get products with recent orders (last 30 days)
        $thirtyDaysAgo = now()->subDays(30);
        
        return Product::select(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at',
                DB::raw('SUM(orders.units) as recent_units_sold'),
                DB::raw('COUNT(orders.id) as recent_order_count')
            )
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->where('products.is_active', true)
            ->where('orders.order_date', '>=', $thirtyDaysAgo)
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.category',
                'products.brand',
                'products.stock_quantity',
                'products.image_url',
                'products.is_active',
                'products.created_at',
                'products.updated_at'
            )
            ->orderBy('recent_units_sold', 'desc')
            ->orderBy('recent_order_count', 'desc')
            ->limit(6)
            ->get();
    }
    
    public function getFilterOptions()
    {
        $sites = Site::select('name')
            ->join('orders', 'sites.id', '=', 'orders.site_id')
            ->groupBy('sites.id', 'sites.name')
            ->orderBy('sites.name')
            ->pluck('name');
            
        $types = Order::select('type')
            ->whereNotNull('type')
            ->groupBy('type')
            ->orderBy('type')
            ->pluck('type');
            
        $regions = Order::select('region')
            ->whereNotNull('region')
            ->groupBy('region')
            ->orderBy('region')
            ->pluck('region');
            
        return response()->json([
            'sites' => $sites,
            'types' => $types,
            'regions' => $regions
        ]);
    }
} 