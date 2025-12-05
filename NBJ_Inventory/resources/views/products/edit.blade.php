<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f9; padding: 40px; }
        .card { background: white; padding: 30px; max-width: 500px; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: bold; color: #555; }
        .btn-save { background-color: #f39c12; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-size: 16px; border-radius: 4px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <a href="{{ route('dashboard') }}" class="btn-back">← Back to Dashboard</a>

    <div class="card">
        <h2>Edit Item: {{ $product->name }}</h2>
        
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if(Auth::user()->branch === 'Admin')
                <label>Branch (Read Only)</label>
                <input type="text" value="{{ $product->branch }}" disabled style="background-color: #eee; color: #666;">
            @endif

            <label>Product Name</label>
            <input type="text" name="name" value="{{ $product->name }}" required>

            <label>Description</label>
            <textarea name="description">{{ $product->description }}</textarea>

            <label>Category / Type</label>
            <select name="type" required>
                <option value="Ingredients" {{ $product->type == 'Ingredients' ? 'selected' : '' }}>Ingredients</option>
                <option value="Drinks" {{ $product->type == 'Drinks' ? 'selected' : '' }}>Drinks</option>
                <option value="Others" {{ $product->type == 'Others' ? 'selected' : '' }}>Others</option>
                <option value="Regular" {{ $product->type == 'Regular' ? 'selected' : '' }}>Regular</option>
                <option value="Buy 1 Take 1" {{ $product->type == 'Buy 1 Take 1' ? 'selected' : '' }}>Buy 1 Take 1</option>
            </select>

            <label>Price (₱)</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label>Current Stock</label>
                    <input type="number" name="stock" value="{{ $product->quantity }}" required>
                </div>
                <div style="flex: 1;">
                    <label>Unit</label>
                    <select name="unit" required>
                        <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                        <option value="pack" {{ $product->unit == 'pack' ? 'selected' : '' }}>Packs</option>
                        <option value="kg" {{ $product->unit == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                        <option value="g" {{ $product->unit == 'g' ? 'selected' : '' }}>Grams (g)</option>
                        <option value="L" {{ $product->unit == 'L' ? 'selected' : '' }}>Liters (L)</option>
                        <option value="ml" {{ $product->unit == 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                        <option value="can" {{ $product->unit == 'can' ? 'selected' : '' }}>Cans</option>
                        <option value="btl" {{ $product->unit == 'btl' ? 'selected' : '' }}>Bottles</option>
                    </select>
                </div>
            </div>

            <label>Change Image (Optional)</label>
            <input type="file" name="image" accept="image/*" style="border: none; padding: 10px 0;">

            <button type="submit" class="btn-save">Update Product</button>
        </form>
    </div>

</body>
</html>