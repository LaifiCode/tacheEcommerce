<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    public function create(Request $request)
    {
        
        Order::create([
            'user_id' => auth()->user()->id,
            'status' => 'en cours', 
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        
        $order = Order::find($id);
        $order->status = $request->input('status');
        $order->save();
    }

    public function viewHistory()
    {
        
        $userOrders = Order::where('user_id', auth()->user()->id)->get();
        return response()->json($userOrders, 200);

      
    }
}
