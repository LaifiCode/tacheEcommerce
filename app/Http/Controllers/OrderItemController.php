<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\OrderItem;

class OrderItemController extends Controller
{
    
    public function add(Request $request)
    {
        
        OrderItem::create([
            'order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
        ]);
    }

    public function updateQuantity(Request $request, $id)
    {
         
        $orderItem = OrderItem::find($id);
        $orderItem->quantity = $request->input('quantity');
        $orderItem->save();
    }

    public function delete($id)
    {
        
        $orderItem = OrderItem::find($id);
        $orderItem->delete();
    }
}
 