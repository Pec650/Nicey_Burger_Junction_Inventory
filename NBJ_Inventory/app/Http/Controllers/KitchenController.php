<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class KitchenController extends Controller
{
    public function index()
    {
        // 1. Get the currently logged-in user
        $user = auth()->user();

        // 2. Start building the query
        $query = DB::table('payment')
                    ->whereNotIn('remarks', ['Completed', 'Cancelled'])
                    ->orderBy('created_at', 'asc');

        // 3. APPLY BRANCH FILTER
        // If the user has a specific branch_id (not null), only show orders for that branch.
        // If the user is Admin (branch_id is null), this if-block is skipped, so they see ALL orders.
        if ($user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }

        $orders = $query->get();

        return view('products.kitchen', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');

        // 1. Update the PAYMENT table (The Transaction)
        $affected = DB::table('payment')
                      ->where('id', $id)
                      ->update(['remarks' => $status]);

        // 2. CRITICAL FIX: If the status is "Completed", update the ORDERS table too!
        if ($status == 'Completed') {
            DB::table('orders')
                ->where('payment_id', $id)
                ->update(['status' => 'Complete']); 
                // Note: We use 'Complete' (no 'd') because that is what your database expects in the orders table
        }

        if ($affected > 0) {
            return redirect()->back()->with('success', "Order #$id updated to: $status");
        } else {
            // Check if it failed because it was ALREADY set to that status
            $exists = DB::table('payment')->where('id', $id)->first();
            
            // If the status is ALREADY completed, we still need to run the order update just in case it missed it before
            if ($exists && $exists->remarks == $status) {
                 if ($status == 'Completed') {
                    DB::table('orders')->where('payment_id', $id)->update(['status' => 'Complete']);
                 }
                 return redirect()->back()->with('success', "Order synced and updated to $status");
            }

            return redirect()->back()->with('error', "Order #$id not found in 'payment' table.");
        }
    }
}