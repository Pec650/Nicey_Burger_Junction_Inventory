<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBJ Inventory Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* NICEY BURGER THEME VARIABLES */
        :root {
            --primary-orange: #ff9f43;
            --primary-red: #ee5253;
            --deep-brown: #574b90; /* For contrast text */
            --bg-cream: #fdfbf7;
            --text-dark: #2d3436;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: var(--bg-cream); color: var(--text-dark); }
        
        /* Navbar with Nicey Gradient */
        .navbar { 
            background: linear-gradient(135deg, #ff9f43, #ee5253); 
            color: white; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 4px 10px rgba(238, 82, 83, 0.3); 
        }
        .navbar h3 { margin: 0; font-weight: 800; letter-spacing: 1px; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); }
        
        .btn-logout { background-color: white; color: #ee5253; border: none; padding: 8px 20px; cursor: pointer; border-radius: 20px; font-weight: bold; transition: all 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .btn-logout:hover { background-color: #ffeaa7; transform: translateY(-2px); }

        .container { padding: 40px; max-width: 1100px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #fae1dd; }
        
        /* Table Styling */
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        th { background-color: #fff0e6; font-weight: bold; color: #d35400; text-transform: uppercase; font-size: 0.85em; letter-spacing: 0.5px; border-top: 2px solid #ff9f43; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #fffdf9; }

        .empty-state { text-align: center; color: #888; padding: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 8px; }
        
        /* Stats & Chart */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; border-bottom: 5px solid #ddd; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        
        .stat-number { font-size: 2.5em; font-weight: 800; margin: 10px 0; color: #2d3436; }
        .stat-label { color: #888; font-weight: bold; text-transform: uppercase; font-size: 0.8em; letter-spacing: 1px; }
        
        /* Theme Borders */
        .border-orange { border-bottom-color: #ff9f43; }
        .border-red { border-bottom-color: #ee5253; }
        .border-green { border-bottom-color: #1dd1a1; }
        
        /* Action Buttons */
        .action-btn { padding: 12px 20px; border:none; border-radius: 8px; cursor:pointer; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; transition: filter 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none; font-size: 14px;}
        .action-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }
        
        .btn-kitchen { background-color: #574b90; color: white; } /* Purple to stand out */
        .btn-add { background-color: #ff9f43; color: white; }
        .btn-print { background-color: #a4b0be; color: white; }
        .btn-search { background-color: #ee5253; color: white; }

        /* Stock Buttons */
        .stock-btn { width: 28px; height: 28px; border-radius: 50%; border: none; color: white; cursor: pointer; font-weight: bold; display: inline-flex; justify-content: center; align-items: center; }
        .stock-plus { background-color: #1dd1a1; }
        .stock-minus { background-color: #ff6b6b; }
    </style>
</head>
<body>

    <div class="navbar">
        <div style="display:flex; align-items:center; gap: 10px;">
            <span style="font-size: 24px; cursor: default">🍔</span>
            <h3 style="cursor: default">Nicey Burger Junction | Inventory</h3>
        </div>
        
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="{{ route('kitchen.index') }}" target="_blank" style="color: white; text-decoration: none; font-weight: bold; background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 15px;">👨‍🍳 Kitchen Monitor</a>
            <a href="{{ route('history') }}" style="color: white; text-decoration: none; opacity: 0.9;">View History</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h1 style="margin: 0; color: #2d3436;">
                        Welcome, {{ Auth::user()->email }} 
                        <span style="font-size: 0.5em; vertical-align: middle; background: #2d3436; color: white; padding: 4px 10px; border-radius: 20px; letter-spacing: 1px;">
                            {{ $userBranch ?? 'Branch' }}
                        </span>
                    </h1>
                    <p style="color: #666; margin-top: 5px;">Manage your stocks and view real-time data.</p>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('kitchen.index') }}" target="_blank" style="text-decoration: none;">
                        <button class="action-btn btn-kitchen">👨‍🍳 Kitchen Monitor</button>
                    </a>

                    <a href="{{ route('products.report') }}" target="_blank" style="text-decoration: none;">
                        <button class="action-btn btn-print">🖨️ Print Report</button>
                    </a>
                    <a href="{{ route('products.create') }}" style="text-decoration: none;">
                        <button class="action-btn btn-add">🍔 Add New Item</button>
                    </a>
                </div>
            </div>
            
            <hr style="border: 0; border-top: 2px dashed #eee; margin: 30px 0;">

            <div class="stats-grid">
                <div class="stat-card border-orange">
                    <div class="stat-label">Total Items</div>
                    <div class="stat-number">{{ number_format($totalStock) }}</div>
                </div>
                <div class="stat-card border-green">
                    <div class="stat-label">Total Value</div>
                    <div class="stat-number" style="color: #27ae60;">₱{{ number_format($totalValue, 2) }}</div>
                </div>
                <div class="stat-card border-red">
                    <div class="stat-label">Low Stock Alerts</div>
                    <div class="stat-number" style="color: {{ $lowStockCount > 0 ? '#ee5253' : '#2c3e50' }}">{{ $lowStockCount }}</div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 30px; border: 1px solid #fae1dd; background: #fffdf9;">
                <h3 style="margin-top: 0; text-align: center; color: #d35400;">📦 Inventory Breakdown</h3>
                <div style="width: 300px; margin: 0 auto;">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <form action="{{ route('dashboard') }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="search" placeholder="Search ingredients or meals..." value="{{ request('search') }}" style="padding: 12px; border: 2px solid #eee; border-radius: 8px; width: 300px; outline: none; transition: border 0.3s;">
                    <button type="submit" class="action-btn btn-search">Search</button>
                    @if(request('search'))
                        <a href="{{ route('dashboard') }}" style="padding: 12px 20px; background-color: #95a5a6; color: white; text-decoration: none; border-radius: 8px; display:inline-flex; align-items:center;">Clear</a>
                    @endif
                </form>
            </div>

            <h3 style="color: #2d3436; border-left: 5px solid #ff9f43; padding-left: 10px;">Current Inventory List</h3>

            @if(isset($products) && $products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            
                            @if(Auth::user()->branch === 'Admin')
                                <th>Branch</th>
                            @endif

                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($products as $product)
    @if(empty($product->id))
        @continue
    @endif
        <tr style="background-color: {{ $product->quantity == 0 ? '#fff0f0' : ($product->quantity < 10 ? '#fffbf0' : 'white') }};">
            
            <td style="font-weight: bold; color: #888;">#{{ $product->id }}</td>
            
            <td>
                @if($product->img_dir && $product->img_dir !== 'placeholder.png')
                    @if (file_exists(public_path('images/Menu/'.$product->img_dir)))
                    <img src="{{ asset('images/Menu/'.$product->img_dir) }}" alt="Img" width="50" height="50" style="object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    @else
                    <img src="{{ asset('images/Icons/TemporaryImage.png') }}" alt="Img" width="50" height="50" style="object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    @endif
                @else
                    <div style="width: 50px; height: 50px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 10px;">No Img</div>
                @endif
            </td>

            <td style="font-weight: 600; font-size: 1.1em;">{{ $product->product_name ?? $product->name }}</td>

            @if(Auth::user()->branch === 'Admin')
                <td><span style="border: 1px solid #ccc; padding: 2px 8px; border-radius: 10px; font-size: 15px; color: #666;">{{ "Branch ".$product->branch_id }}</span></td>
            @endif

            <td><span style="background-color: #fff4e6; color: #d35400; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">{{ $product->type ?? 'Regular' }}</span></td>
            <td style="font-family: monospace; font-size: 1.1em;">₱{{ number_format($product->price ?? 0, 2) }}</td>
            
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    
                    <form action="{{ route('products.adjustStock', ['id' => $product->id]) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="action" value="minus">
                        <button type="submit" class="stock-btn stock-minus">-</button>
                    </form>
                    
                    <span style="font-weight: 800; font-size: 1.2em; min-width: 40px; text-align: center; color: #2d3436;">
                        {{ $product->quantity ?? 0 }}
                    </span>

                    <form action="{{ route('products.adjustStock', ['id' => $product->id]) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="stock-btn stock-plus">+</button>
                    </form>
                </div>
                <div style="margin-top: 5px; font-size: 0.8em; color: #777; text-align: center;">{{ $product->unit ?? 'units' }}</div>

                @if(($product->quantity ?? 0) == 0)
                    <div style="color: #ee5253; font-size: 0.75em; font-weight: bold; text-align: center; margin-top: 5px;">⚠️ OUT OF STOCK</div>
                @elseif(($product->quantity ?? 0) < 10)
                    <div style="color: #f39c12; font-size: 0.75em; font-weight: bold; text-align: center; margin-top: 5px;">⚠️ LOW STOCK</div>
                @endif
            </td>

            <td style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('products.edit', ['id' => $product->id]) }}" style="color: #3498db; text-decoration: none; font-weight: bold;">Edit</a>
                <span style="color: #ddd;">|</span>
                <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    @csrf @method('DELETE')
                    <button type="submit" style="color: #ee5253; background: none; border: none; cursor: pointer; font-weight: bold; padding: 0;">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
                </table>
            @else
                <div class="empty-state">
                    <h3>🍔 No products found.</h3>
                    <p>Get started by adding new ingredients or meals.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        @if(isset($chartLabels) && isset($chartValues))
            const ctx = document.getElementById('inventoryChart');
            new Chart(ctx, {
                type: 'doughnut', /* Changed to Doughnut for modern look */
                data: {
                    labels: {!! json_encode($chartLabels) !!}, 
                    datasets: [{
                        data: {!! json_encode($chartValues) !!}, 
                        /* UPDATED COLORS TO MATCH NICEY BURGER THEME */
                        backgroundColor: [
                            '#ff9f43', /* Orange */
                            '#ee5253', /* Red */
                            '#feca57', /* Yellow */
                            '#5f27cd', /* Purple */
                            '#1dd1a1'  /* Green */
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: { 
                    responsive: true, 
                    plugins: { 
                        legend: { position: 'bottom', labels: { padding: 20 } } 
                    },
                    cutout: '60%'
                }
            });
        @endif
    </script>
</body>
</html>