<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f9; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-back { text-decoration: none; color: white; background-color: #2c3e50; padding: 10px 15px; border-radius: 4px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }

        /* Action Colors */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; color: white; }
        .bg-green { background-color: #27ae60; } /* Created */
        .bg-blue { background-color: #3498db; }  /* Updated */
        .bg-red { background-color: #e74c3c; }   /* Deleted */
        .bg-orange { background-color: #e67e22; } /* Stock Adjust */
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Transaction History</h1>
            <a href="{{ route('dashboard') }}" class="btn-back">← Back to Dashboard</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Product</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('M d, h:i A') }}</td>
                        <td>{{ $log->user }}</td>
                        <td>
                            <span class="badge
                                {{ $log->action == 'Create' ? 'bg-green' : '' }}
                                {{ $log->action == 'Update' ? 'bg-blue' : '' }}
                                {{ $log->action == 'Delete' ? 'bg-red' : '' }}
                                {{ str_contains($log->action, 'Stock') ? 'bg-orange' : '' }}
                            ">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->product_name }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>