<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f9; padding: 40px; }
        .card { background: white; padding: 30px; max-width: 500px; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: bold; color: #555; }
        .btn-save { background-color: #27ae60; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-size: 16px; border-radius: 4px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <a href="{{ route('dashboard') }}" class="btn-back">← Back to Dashboard</a>

    <div class="card">
        <h2>Add New Item</h2>
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 

            <label>Product Name</label>
            <input type="text" name="name" required placeholder="e.g. Burger Patty">

            <label>Description</label>
            <textarea name="description" placeholder="Optional details..."></textarea>

            <label>Category / Type</label>
            <select name="type" required>
                <option value="" disabled selected>Select a category...</option>
                <option value="Ingredients">Ingredients</option>
                <option value="Drinks">Drinks</option>
                <option value="Others">Others</option>
                <option value="Regular">Regular</option>
                <option value="Buy 1 Take 1">Buy 1 Take 1</option>
            </select>

            <label>Price (₱)</label>
            <input type="number" step="0.01" name="price" required placeholder="0.00">

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label>Initial Stock</label>
                    <input type="number" name="stock" required placeholder="0">
                </div>
                <div style="flex: 1;">
                    <label>Unit</label>
                    <select name="unit" required>
                        <option value="pcs">Pieces (pcs)</option>
                        <option value="pack">Packs</option>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="g">Grams (g)</option>
                        <option value="L">Liters (L)</option>
                        <option value="ml">Milliliters (ml)</option>
                        <option value="can">Cans</option>
                        <option value="btl">Bottles</option>
                    </select>
                </div>
            </div>

            <label>Product Image</label>
            <input type="file" name="image" accept="image/*" style="border: none; padding: 10px 0;">

            <button type="submit" class="btn-save">Save Product</button>
        </form>
    </div>

</body>
</html>