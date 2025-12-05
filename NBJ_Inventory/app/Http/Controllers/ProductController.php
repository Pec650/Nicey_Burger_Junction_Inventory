<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 

class ProductController extends Controller
{
    // 0. Show the Dashboard
    public function index(Request $request)
    {
        $user = Auth::user();

        // --- 1. BRANCH FILTER LOGIC ---
        $query = Product::query();

        // If NOT Admin, strictly filter by the user's branch
        if ($user->branch !== 'Admin') {
            $query->where('branch_id', $user->branch_id);
        }

        // --- 2. CALCULATE STATS (Based on the filtered list) ---
        // We clone the query so the stats match exactly what the user sees
        $statsQuery = clone $query;
        $totalStock = $statsQuery->sum('quantity');
        $lowStockCount = $statsQuery->where('quantity', '<', 10)->count();

        $valueQuery = clone $query;
        $allProducts = $valueQuery->get();
        $totalValue = 0;
        foreach($allProducts as $p) {
            $totalValue += $p->price * $p->quantity;
        }

        // --- 3. CHART DATA ---
        $chartQuery = clone $query; 
        $chartData = $chartQuery->select('type', DB::raw('count(*) as total'))
                            ->groupBy('type')
                            ->pluck('total', 'type')
                            ->all();

        $chartLabels = array_keys($chartData);
        $chartValues = array_values($chartData);

        // --- 4. SEARCH LOGIC ---
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // --- 5. PAGINATION ---
        // We restore pagination now that debugging is done
        $products = $query->whereNotNull('id')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('dashboard', [
            'products' => $products,
            'totalStock' => $totalStock,
            'lowStockCount' => $lowStockCount,
            'totalValue' => $totalValue,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'userBranch' => $user->branch // Passes real branch name (e.g. "Branch 1")
        ]);
    }

    // 1. Show Create Form
    public function create()
    {
        return view('products.create');
    }

    // 2. Store New Item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'unit' => 'required',
            'type' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = new Product();
        $user = Auth::user();

        // Auto-assign Branch: If Admin, default to Branch 1, else use user's branch
        $product->branch = ($user->branch === 'Admin') ? 'Branch 1' : $user->branch;

        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->stock;
        $product->unit = $request->unit;
        $product->description = $request->description ?? 'No description';
        $product->type = $request->type;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $product->img_dir = $filename;
        } else {
            $product->img_dir = null;
        }

        $product->save();

        $this->logHistory('Create', $product->name, "Added to {$product->branch_id}. Stock: {$product->quantity} {$product->unit}");

        return redirect()->route('dashboard')->with('success', 'New item added successfully!');
    }

    // 3. Show Edit Form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    // 4. Update Item
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'unit' => 'required',
            'type' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $changes = []; 
        if ($product->name != $request->name) $changes[] = "Name: '{$product->name}' -> '{$request->name}'";
        if ($product->price != $request->price) $changes[] = "Price: ₱{$product->price} -> ₱{$request->price}";
        if ($product->quantity != $request->stock) $changes[] = "Stock: {$product->quantity} -> {$request->stock}";
        if ($product->unit != $request->unit) $changes[] = "Unit: {$product->unit} -> {$request->unit}";
        if ($request->hasFile('image')) $changes[] = "Image photo updated";

        $logDescription = count($changes) > 0 ? implode(', ', $changes) : "Clicked update but no data changed";

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->stock;
        $product->unit = $request->unit;
        $product->type = $request->type;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $product->img_dir = $filename;
        }

        $product->save();

        $this->logHistory('Update', $product->name, $logDescription);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

    // 5. Delete Item
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->name; 
        $product->delete();
        $this->logHistory('Delete', $productName, 'Item removed from inventory');
        return redirect()->route('dashboard')->with('success', 'Product deleted successfully!');
    }

    // 6. Quick Stock Adjustment
    public function adjustStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $actionDescription = "";

        if ($request->action == 'add') {
            $product->quantity += 1;
            $actionDescription = "Stock increased (+1)";
        } elseif ($request->action == 'minus') {
            if ($product->quantity > 0) {
                $product->quantity -= 1;
                $actionDescription = "Stock decreased (-1)";
            } else {
                return back(); 
            }
        }

        $product->save();
        $this->logHistory('Stock Adjust', $product->name, $actionDescription);
        return back();
    }

    // 7. Helper Log Function
    private function logHistory($action, $productName, $description)
    {
        Transaction::create([
            'user' => Auth::user()->email,
            'action' => $action,
            'product_name' => $productName,
            'description' => $description
        ]);
    }

    // 8. Printable Report
    public function printReport()
    {
        $user = Auth::user();
        $query = Product::orderBy('name');

        if ($user->branch !== 'Admin') {
            $query->where('branch_id', $user->branch_id);
        }

        $products = $query->get();

        $totalStock = $products->sum('quantity');
        $totalValue = 0;
        foreach($products as $p) {
            $totalValue += $p->price * $p->quantity;
        }

        return view('products.report', [
            'products' => $products,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue
        ]);
    }
}