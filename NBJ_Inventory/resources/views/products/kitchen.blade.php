<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="15"> 
    <title>Kitchen Monitor</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .order-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        
        .order-card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 10px solid gray; }
        
        /* Status Colors */
        .status-Ongoing { border-left-color: #3498db; } /* Blue - New */
        .status-Preparing { border-left-color: #f39c12; } /* Orange - Cooking */
        .status-ReadyforPickup { border-left-color: #2ecc71; } /* Green - Pickup */
        .status-WaitingforConfirmation { border-left-color: #8e44ad; background-color: #fdf2f8; } /* Purple/Pink - Handshake */

        .btn { padding: 10px; width: 100%; border: none; cursor: pointer; color: white; font-weight: bold; margin-top: 10px; border-radius: 5px;}
        .btn-cook { background-color: #f39c12; }
        .btn-ready { background-color: #2ecc71; }
        .btn-finish { background-color: #333; }
        
        h2 { margin: 0 0 10px 0; }
        .time { color: #777; font-size: 0.9em; margin-bottom: 15px; display: block;}
    </style>
</head>
<body>

    <div class="header">
        <a href="{{ url('/dashboard') }}" style="position: absolute; left: 20px; top: 20px; text-decoration: none; background: #333; color: white; padding: 10px 15px; border-radius: 5px; font-weight: bold; font-size: 0.9em;">
            ← BACK TO DASHBOARD
        </a>

        <h1>👨‍🍳 KITCHEN MONITOR</h1>
        
        @if(auth()->user()->branch_id == 1)
            <h3 style="color: #666; background: #eee; padding: 5px; display:inline-block;">📍 MACTAN BRANCH</h3>
        @elseif(auth()->user()->branch_id == 2)
             <h3 style="color: #666; background: #eee; padding: 5px; display:inline-block;">📍 APAS BRANCH</h3>
        @else
            <h3 style="color: red; background: #ffe6e6; padding: 5px; display:inline-block;">🛡️ SUPER ADMIN VIEW (ALL BRANCHES)</h3>
        @endif
    </div>

    <div class="order-grid">
        @if($orders->count() == 0)
            <p style="text-align:center; width:100%;">No active orders.</p>
        @endif

        @foreach($orders as $order)
            {{-- str_replace removes spaces so 'Ready for Pickup' becomes 'ReadyforPickup' for the CSS class --}}
            <div class="order-card status-{{ str_replace(' ', '', $order->remarks) }}">
                <h2>Order #{{ $order->id }}</h2>
                <span class="time">Placed: {{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</span>
                <p><strong>Status:</strong> {{ $order->remarks }}</p>
                <p><strong>Total Items:</strong> {{ $order->total_quantity }}</p>
                
                <hr>

                @if($order->remarks == 'Ongoing')
                    <form action="{{ route('kitchen.update', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Preparing">
                        <button type="submit" class="btn btn-cook">🔥 START COOKING</button>
                    </form>

                @elseif($order->remarks == 'Preparing')
                    <form action="{{ route('kitchen.update', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Ready for Pickup">
                        <button type="submit" class="btn btn-ready">✅ READY FOR PICKUP</button>
                    </form>

                @elseif($order->remarks == 'Ready for Pickup')
                    <div style="text-align: center; color: green; font-weight: bold; margin-bottom: 10px;">
                        ⏳ WAITING FOR CUSTOMER...
                    </div>
                    
                    {{-- Fallback: Allows cashier to force complete if customer forgets to click button --}}
                    <form action="{{ route('kitchen.update', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="btn btn-finish" style="opacity: 0.5; font-size: 0.8em;">Force Complete (Manual)</button>
                    </form>

                @elseif($order->remarks == 'Waiting for Confirmation')
                    {{-- NEW BLOCK: This appears when customer clicks "I Received My Order" --}}
                    <div style="background-color: #e8c7c7; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 10px;">
                        <h3 style="color: #c0392b; margin: 0;">⚠️ CONFIRMATION</h3>
                        <p style="margin: 5px 0 0 0;">Customer says they have the food.</p>
                    </div>

                    <form action="{{ route('kitchen.update', $order->id) }}" method="POST">
                        @csrf
                        {{-- Final Step: Mark as Completed --}}
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="btn btn-ready" style="background-color: #8e44ad;">
                            ✅ CONFIRM & CLOSE
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

</body>
</html>