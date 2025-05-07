<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Afișează lista de comenzi.
     */
    public function index()
    {
        $orders = Order::with('products')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Afișează formularul pentru a crea o comandă nouă.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    /**
     * Stochează o comandă nouă în baza de date.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'payment_method' => 'required|string|in:card,transfer bancar,ramburs,PayPal',
            'selected_products' => 'required|array',
            'selected_products.*' => 'exists:products,id',
            'products' => 'required|array'
        ]);

        // Verificăm dacă avem produse selectate
        if (!isset($validatedData['selected_products']) || empty($validatedData['selected_products'])) {
            return redirect()->back()->with('error', 'Trebuie să selectați cel puțin un produs pentru a crea o comandă.');
        }

        // Calculăm subtotalul și totalul
        $subtotal = 0;
        $productItems = [];

        foreach ($validatedData['selected_products'] as $productId) {
            $product = Product::find($productId);
            
            // Verificăm dacă produsul există și are stoc disponibil
            if ($product) {
                $quantity = isset($validatedData['products'][$productId]['quantity']) ? 
                    (int)$validatedData['products'][$productId]['quantity'] : 1;
                
                // Verificare stoc disponibil
                if ($product->stock >= $quantity && $quantity > 0) {
                    $price = $product->price;
                    $subtotal += $price * $quantity;
                    
                    $productItems[$productId] = [
                        'quantity' => $quantity,
                        'price' => $price
                    ];
                    
                    // Actualizăm stocul
                    $product->stock -= $quantity;
                    $product->status = $product->stock <= 0 ? 'out_of_stock' : ($product->stock <= 5 ? 'low_stock' : 'in_stock');
                    $product->save();
                }
            }
        }

        // Dacă nu avem produse valide, nu creăm comanda
        if (empty($productItems)) {
            return redirect()->back()->with('error', 'Nu s-a putut crea comanda: produsele nu sunt disponibile sau nu există suficient stoc.');
        }

        // Calculăm TVA și transport
        $tax = $subtotal * 0.19; // 19% TVA
        $shipping = $subtotal > 500 ? 0 : 20; // Livrare gratuită pentru comenzi peste 500 lei
        $total = $subtotal + $tax + $shipping;

        // Creăm comanda
        $order = Order::create([
            'customer_name' => $validatedData['customer_name'],
            'customer_email' => $validatedData['customer_email'],
            'customer_phone' => $validatedData['customer_phone'],
            'shipping_address' => $validatedData['shipping_address'],
            'billing_address' => $validatedData['billing_address'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => 0,
            'total' => $total,
            'status' => 'pending',
            'notes' => $validatedData['notes'],
            'payment_method' => $validatedData['payment_method'],
            'payment_id' => 'ORD-' . time()
        ]);

        // Atașăm produsele la comandă
        foreach ($productItems as $productId => $item) {
            $order->products()->attach($productId, $item);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Comanda a fost creată cu succes!');
    }

    /**
     * Afișează informațiile unei comenzi specifice.
     */
    public function show(Order $order)
    {
        $order->load('products');
        return view('orders.show', compact('order'));
    }

    /**
     * Afișează formularul pentru editarea unei comenzi.
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        $order->load('products');
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Actualizează o comandă specifică în baza de date.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'payment_method' => 'required|string|in:card,transfer bancar,ramburs,PayPal',
        ]);

        $order->update($validatedData);
        
        return redirect()->route('orders.show', $order)->with('success', 'Comanda a fost actualizată cu succes!');
    }

    /**
     * Șterge o comandă specifică din baza de date.
     */
    public function destroy(Order $order)
    {
        try {
            // Folosim tranzacție pentru a asigura integritatea datelor
            DB::beginTransaction();
            
            // Redam stocul produselor dacă comanda nu este finalizată sau rambursată
            if ($order->status !== 'completed' && $order->status !== 'refunded') {
                foreach ($order->products as $product) {
                    $product->stock += $product->pivot->quantity;
                    $product->status = $product->stock > 0 ? 
                        ($product->stock <= 5 ? 'low_stock' : 'in_stock') : 'out_of_stock';
                    $product->save();
                }
            }
            
            // Obținem ID-ul comenzii pentru mesajul de confirmare
            $orderId = $order->id;
            
            // Detașăm produsele
            $order->products()->detach();
            
            // Ștergem comanda
            $order->delete();
            
            // Confirmăm tranzacția
            DB::commit();
            
            // Redirecționăm cu mesaj de succes
            return redirect()->route('orders.index')
                ->with('success', "Comanda #$orderId a fost ștearsă cu succes!");
                
        } catch (\Exception $e) {
            // Anulăm tranzacția în caz de eroare
            DB::rollBack();
            
            // Logăm eroarea pentru depanare
            \Log::error('Eroare la ștergerea comenzii: ' . $e->getMessage());
            
            // Redirecționăm cu mesaj de eroare
            return back()->with('error', 'A apărut o eroare la ștergerea comenzii: ' . $e->getMessage());
        }
    }
    
    /**
     * Exportă lista comenzilor în format CSV.
     */
    public function export()
    {
        $orders = Order::with('products')->latest()->get();
        
        $headers = [
            'ID',
            'Client',
            'Email',
            'Telefon',
            'Adresa livrare',
            'Subtotal',
            'TVA',
            'Transport',
            'Discount',
            'Total',
            'Status',
            'Metoda plată',
            'ID Plată',
            'Data comenzii',
            'Produse'
        ];
        
        $filename = 'comenzi_' . date('Y-m-d_H-i-s') . '.csv';
        
        $handle = fopen('php://temp', 'r+');
        
        // Adăugăm UTF-8 BOM pentru Excel
        fputs($handle, "\xEF\xBB\xBF");
        
        // Adăugăm header-ul
        fputcsv($handle, $headers);
        
        // Adăugăm datele comenzilor
        foreach ($orders as $order) {
            $productsList = $order->products->map(function($product) {
                return $product->name . ' (' . $product->pivot->quantity . ' x ' . number_format($product->pivot->price, 2) . ' Lei)';
            })->implode(', ');
            
            $row = [
                $order->id,
                $order->customer_name,
                $order->customer_email,
                $order->customer_phone ?? 'N/A',
                $order->shipping_address,
                number_format($order->subtotal, 2),
                number_format($order->tax, 2),
                number_format($order->shipping, 2),
                number_format($order->discount, 2),
                number_format($order->total, 2),
                $order->status,
                $order->payment_method,
                $order->payment_id ?? 'N/A',
                $order->created_at->format('d.m.Y H:i:s'),
                $productsList
            ];
            
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        
        return Response::make($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    /**
     * Șterge o comandă din baza de date folosind ID-ul din request.
     * Această metodă este folosită când JavaScript nu reușește 
     * să seteze URL-ul corect în formular.
     */
    public function destroyDirect(Request $request)
    {
        // Validăm că există un _method=DELETE în request
        if ($request->input('_method') !== 'DELETE') {
            return back()->with('error', 'Metodă invalidă pentru ștergerea comenzii.');
        }
        
        // Folosim direct ID-ul din input, este cea mai sigură metodă
        $orderId = $request->input('order_id');
        
        // Verificare suplimentară în log
        \Log::info('Ștergere comandă: ID=' . $orderId . ', Request=' . json_encode($request->all()));
        
        // Verificăm dacă ID-ul este numeric
        if (!is_numeric($orderId)) {
            return back()->with('error', 'ID-ul comenzii este invalid. ID detectat: ' . $orderId);
        }
        
        // Găsim comanda în baza de date
        $order = Order::find($orderId);
        
        // Verificăm dacă comanda există
        if (!$order) {
            return back()->with('error', 'Comanda cu ID-ul ' . $orderId . ' nu a fost găsită.');
        }
        
        // Folosim metoda destroy existentă pentru a șterge comanda
        return $this->destroy($order);
    }
}
