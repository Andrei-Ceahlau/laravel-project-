<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Gestionează căutarea în diferite entități din aplicație
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all');
        
        if (empty($query)) {
            return redirect()->back()->with('error', 'Introduceți un termen de căutare.');
        }
        
        $products = collect();
        $orders = collect();
        
        // Căutare produse
        if ($type === 'all' || $type === 'products') {
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('category', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->get();
        }
        
        // Căutare comenzi
        if ($type === 'all' || $type === 'orders') {
            $orders = Order::where('customer_name', 'like', "%{$query}%")
                ->orWhere('customer_email', 'like', "%{$query}%")
                ->orWhere('customer_phone', 'like', "%{$query}%")
                ->orWhere('payment_id', 'like', "%{$query}%")
                ->orWhere('shipping_address', 'like', "%{$query}%")
                ->orWhere('notes', 'like', "%{$query}%")
                ->with('products')
                ->get();
        }
        
        return view('search.results', [
            'query' => $query,
            'type' => $type,
            'products' => $products,
            'orders' => $orders,
            'totalResults' => $products->count() + $orders->count()
        ]);
    }
} 