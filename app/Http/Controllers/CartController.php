<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Afișează conținutul coșului de cumpărături
     */
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $cartTotal = 0;
        $products = [];
        
        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'reserved_stock' => $item['reserved_stock'] ?? 0,
                    'subtotal' => $product->price * $item['quantity']
                ];
                $cartTotal += $product->price * $item['quantity'];
            }
        }
        
        return view('cart.index', compact('products', 'cartTotal'));
    }
    
    /**
     * Adaugă un produs în coș
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        // Verificăm dacă există suficient stoc
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Nu există suficient stoc pentru acest produs. Doar ' . $product->stock . ' bucăți disponibile.');
        }
        
        $cart = Session::get('cart', []);
        
        // Verificăm dacă produsul este deja în coș
        if (isset($cart[$product->id])) {
            // Verificăm dacă există suficient stoc pentru cantitatea totală
            $totalQuantity = $cart[$product->id]['quantity'] + $quantity;
            $alreadyReserved = $cart[$product->id]['reserved_stock'] ?? 0;
            $needToReserve = $quantity;
            
            if (($product->stock + $alreadyReserved) < $totalQuantity) {
                return redirect()->back()->with('error', 'Nu există suficient stoc pentru acest produs. Doar ' . ($product->stock + $alreadyReserved) . ' bucăți disponibile.');
            }
            
            $cart[$product->id]['quantity'] = $totalQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
                'reserved_stock' => 0
            ];
            $needToReserve = $quantity;
        }
        
        // Scădem stocul și marcăm cât am rezervat
        try {
            DB::transaction(function() use ($product, $needToReserve, &$cart) {
                // Scădem stocul produsului
                $product->stock -= $needToReserve;
                
                // Actualizăm statusul produsului în funcție de stocul rămas
                if ($product->stock <= 0) {
                    $product->status = 'out_of_stock';
                } elseif ($product->stock <= 5) {
                    $product->status = 'low_stock';
                } else {
                    $product->status = 'in_stock';
                }
                
                $product->save();
                
                // Actualizăm cantitatea rezervată în coș
                $cart[$product->id]['reserved_stock'] = ($cart[$product->id]['reserved_stock'] ?? 0) + $needToReserve;
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'A apărut o eroare la actualizarea stocului: ' . $e->getMessage());
        }
        
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Produsul a fost adăugat în coș');
    }
    
    /**
     * Actualizează cantitatea unui produs din coș
     */
    public function update(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        $newQuantity = $request->input('quantity', 1);
        
        // Verificăm dacă produsul este în coș
        if (!isset($cart[$product->id])) {
            return redirect()->route('cart.index')->with('error', 'Produsul nu a fost găsit în coș');
        }
        
        $currentQuantity = $cart[$product->id]['quantity'];
        $reservedStock = $cart[$product->id]['reserved_stock'] ?? 0;
        
        try {
            DB::transaction(function() use ($product, $newQuantity, $currentQuantity, $reservedStock, &$cart) {
                if ($newQuantity > $currentQuantity) {
                    // Adăugăm mai multe produse - trebuie să verificăm stocul
                    $additionalQuantity = $newQuantity - $currentQuantity;
                    
                    if ($product->stock < $additionalQuantity) {
                        throw new \Exception('Nu există suficient stoc pentru acest produs. Doar ' . ($product->stock + $reservedStock) . ' bucăți disponibile.');
                    }
                    
                    // Scădem stocul
                    $product->stock -= $additionalQuantity;
                    $cart[$product->id]['reserved_stock'] = $reservedStock + $additionalQuantity;
                } elseif ($newQuantity < $currentQuantity) {
                    // Înlăturăm produse - reintroducem în stoc
                    $removedQuantity = $currentQuantity - $newQuantity;
                    $stockToReturn = min($removedQuantity, $reservedStock);
                    
                    // Returnăm stocul
                    $product->stock += $stockToReturn;
                    $cart[$product->id]['reserved_stock'] = $reservedStock - $stockToReturn;
                }
                
                // Actualizăm statusul produsului în funcție de stocul rămas
                if ($product->stock <= 0) {
                    $product->status = 'out_of_stock';
                } elseif ($product->stock <= 5) {
                    $product->status = 'low_stock';
                } else {
                    $product->status = 'in_stock';
                }
                
                $product->save();
                
                if ($newQuantity > 0) {
                    $cart[$product->id]['quantity'] = $newQuantity;
                } else {
                    // Dacă cantitatea este 0, returnăm tot stocul rezervat și eliminăm produsul din coș
                    $product->stock += $cart[$product->id]['reserved_stock'] ?? 0;
                    $product->save();
                    unset($cart[$product->id]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
        
        Session::put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Coșul a fost actualizat');
    }
    
    /**
     * Șterge un produs din coș
     */
    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            try {
                DB::transaction(function() use ($product, &$cart) {
                    // Returnăm stocul rezervat
                    $reservedStock = $cart[$product->id]['reserved_stock'] ?? 0;
                    $product->stock += $reservedStock;
                    
                    // Actualizăm statusul produsului în funcție de stocul rămas
                    if ($product->stock <= 0) {
                        $product->status = 'out_of_stock';
                    } elseif ($product->stock <= 5) {
                        $product->status = 'low_stock';
                    } else {
                        $product->status = 'in_stock';
                    }
                    
                    $product->save();
                    unset($cart[$product->id]);
                });
            } catch (\Exception $e) {
                return redirect()->route('cart.index')->with('error', 'A apărut o eroare la actualizarea stocului: ' . $e->getMessage());
            }
            
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produsul a fost eliminat din coș');
    }
    
    /**
     * Golește coșul de cumpărături
     */
    public function clear()
    {
        $cart = Session::get('cart', []);
        
        try {
            DB::transaction(function() use ($cart) {
                // Returnăm stocul pentru toate produsele din coș
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $reservedStock = $item['reserved_stock'] ?? 0;
                        $product->stock += $reservedStock;
                        
                        // Actualizăm statusul produsului în funcție de stocul rămas
                        if ($product->stock <= 0) {
                            $product->status = 'out_of_stock';
                        } elseif ($product->stock <= 5) {
                            $product->status = 'low_stock';
                        } else {
                            $product->status = 'in_stock';
                        }
                        
                        $product->save();
                    }
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'A apărut o eroare la actualizarea stocului: ' . $e->getMessage());
        }
        
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Coșul a fost golit');
    }
    
    /**
     * Procesează comanda
     */
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Coșul tău este gol');
        }
        
        // Validăm datele din formular
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:card,transfer bancar,ramburs,PayPal',
            'notes' => 'nullable|string',
        ]);
        
        try {
            DB::transaction(function() use ($cart, $validatedData) {
                // Calculăm subtotalul
                $subtotal = 0;
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $subtotal += $product->price * $item['quantity'];
                    }
                }
                
                // Calculăm taxele și transportul
                $tax = $subtotal * 0.19; // 19% TVA
                $shipping = $subtotal > 500 ? 0 : 20; // Livrare gratuită peste 500 lei
                $total = $subtotal + $tax + $shipping;
                
                // Crează o nouă comandă
                $order = new Order();
                $order->status = 'pending';
                $order->customer_name = $validatedData['customer_name'];
                $order->customer_email = $validatedData['customer_email'];
                $order->customer_phone = $validatedData['customer_phone'];
                $order->shipping_address = $validatedData['shipping_address'];
                $order->payment_method = $validatedData['payment_method'];
                $order->notes = $validatedData['notes'];
                $order->subtotal = $subtotal;
                $order->tax = $tax;
                $order->shipping = $shipping;
                $order->discount = 0;
                $order->total = $total;
                $order->payment_id = 'ORD-' . time();
                $order->save();
                
                // Adaugă produsele în comandă
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $quantity = $item['quantity'];
                        $price = $product->price;
                        
                        // Adaugăm produsul în comandă
                        $order->products()->attach($product->id, [
                            'quantity' => $quantity,
                            'price' => $price
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'A apărut o eroare la plasarea comenzii: ' . $e->getMessage());
        }
        
        // Golim coșul după finalizarea comenzii
        Session::forget('cart');
        
        // Redirecționăm către pagina de comenzi cu un mesaj de succes
        return redirect()->route('orders.index')->with('success', 'Comanda a fost plasată cu succes! Îți mulțumim pentru achiziție.');
    }
} 