<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Merchant;
use App\Models\Site;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('merchants')->active()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('merchants');
        return view('products.show', compact('product'));
    }

    public function adminIndex()
    {
        $products = Product::with('merchants')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $merchants = Merchant::active()->get();
        return view('admin.products.create', compact('merchants'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'merchant_ids' => 'nullable|array',
            'merchant_ids.*' => 'exists:merchants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['image', 'merchant_ids']);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $product = Product::create($data);

        if ($request->has('merchant_ids')) {
            $product->merchants()->attach($request->merchant_ids);
        }

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $merchants = Merchant::active()->get();
        $product->load('merchants');
        return view('admin.products.edit', compact('product', 'merchants'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'merchant_ids' => 'nullable|array',
            'merchant_ids.*' => 'exists:merchants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['image', 'merchant_ids']);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $product->update($data);

        if ($request->has('merchant_ids')) {
            $product->merchants()->sync($request->merchant_ids);
        }

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public function importForm()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            DB::beginTransaction();
            
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Remove header row
            $headers = array_shift($rows);
            
            $importedCount = 0;
            $errors = [];
            
            foreach ($rows as $index => $row) {
                try {
                    $rowData = array_combine($headers, $row);
                    
                    // Create or find customer
                    $customer = null;
                    if (!empty($rowData['Name'])) {
                        $customer = Customer::firstOrCreate(
                            ['name' => $rowData['Name']],
                            [
                                'gender' => $this->normalizeGender($rowData['Gender'] ?? ''),
                                'city' => $rowData['City'] ?? null,
                                'region' => $rowData['Region'] ?? null,
                            ]
                        );
                    }
                    
                    // Create or find site
                    $site = null;
                    if (!empty($rowData['Site'])) {
                        $site = Site::firstOrCreate(
                            ['name' => $rowData['Site']],
                            ['description' => 'Imported from Excel']
                        );
                    }
                    
                    // Create or find product
                    $product = null;
                    if (!empty($rowData['Product'])) {
                        $product = Product::firstOrCreate(
                            ['name' => $rowData['Product']],
                            [
                                'description' => 'Imported from Excel',
                                'price' => 0, // Default price since not in Excel
                                'category' => $rowData['Type'] ?? 'General',
                                'brand' => null,
                                'stock_quantity' => 0,
                                'is_active' => true,
                            ]
                        );
                    }
                    
                    // Create order
                    if ($product && $customer && $site) {
                        // Handle revenue: try 'Revenue', then '$', then 0
                        $value = $rowData['Revenue'] ?? ($rowData['$'] ?? '');
                        $revenue = floatval(preg_replace('/[^\d.]/', '', str_replace(' ', '', $value)));

                        Order::create([
                            'customer_id' => $customer->id,
                            'product_id' => $product->id,
                            'site_id' => $site->id,
                            'units' => intval($rowData['Units'] ?? 1),
                            'revenue' => $revenue,
                            'type' => $rowData['Type'] ?? null,
                            'order_date' => $this->parseDate($rowData['ORDER DATE'] ?? null),
                            'month' => $rowData['Month'] ?? null,
                            'payment_method' => $rowData['payment method'] ?? null,
                            'region' => $rowData['Region'] ?? null,
                        ]);
                        
                        $importedCount++;
                    }
                    
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }
            
            DB::commit();
            
            $message = "Successfully imported {$importedCount} orders.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " and " . (count($errors) - 5) . " more errors.";
                }
            }
            
            return redirect()->route('admin.products')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    
    private function normalizeGender($gender)
    {
        $gender = strtolower(trim($gender));
        if (in_array($gender, ['male', 'm', 'man'])) {
            return 'male';
        } elseif (in_array($gender, ['female', 'f', 'woman'])) {
            return 'female';
        } else {
            return 'other';
        }
    }
    
    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        
        try {
            return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
} 