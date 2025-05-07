<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificăm dacă există utilizatori și produse
        $users = User::all();
        $products = Product::all();
        
        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('Nu există utilizatori sau produse pentru a crea comenzi.');
            return;
        }
        
        // Nume de clienți pentru comenzi
        $customerNames = [
            'Alexandru Popescu',
            'Maria Ionescu',
            'Ion Dumitrescu',
            'Elena Popa',
            'Andrei Stoica',
            'Ana Vasile',
            'Mihai Georgescu',
            'Cristina Stan',
            'Gabriel Dinu',
            'Laura Munteanu'
        ];
        
        // Adrese pentru livrare
        $addresses = [
            'Strada Victoriei 25, București',
            'Bulevardul Unirii 10, Cluj-Napoca',
            'Strada Republicii 15, Iași',
            'Aleea Teilor 7, Timișoara',
            'Bulevardul Carol I, 22, Brașov',
            'Strada Mihai Eminescu 18, Constanța',
            'Piața Libertății 3, Oradea',
            'Strada Traian 12, Sibiu',
            'Bulevardul Ferdinand 45, Arad',
            'Strada Avram Iancu 33, Craiova'
        ];
        
        // Statusuri posibile pentru comenzi
        $statuses = ['pending', 'processing', 'completed', 'cancelled', 'refunded'];
        
        // Metode de plată
        $paymentMethods = ['card', 'transfer bancar', 'ramburs', 'PayPal'];
        
        // Generăm 20 de comenzi
        for ($i = 1; $i <= 20; $i++) {
            // Alegem un utilizator aleatoriu sau null (pentru comenzi anonime)
            $user = $users->random();
            
            // Alegem un număr aleatoriu de produse pentru comandă (între 1 și 5)
            $orderProducts = $products->random(rand(1, 5));
            
            // Calculăm subtotalul
            $subtotal = 0;
            $orderProductsData = [];
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal += $price * $quantity;
                
                $orderProductsData[$product->id] = [
                    'quantity' => $quantity,
                    'price' => $price
                ];
            }
            
            // Calculăm taxe, livrare și discount
            $tax = $subtotal * 0.19; // TVA 19%
            $shipping = rand(0, 2) === 0 ? 0 : rand(15, 30); // Uneori livrare gratuită
            $discount = rand(0, 3) === 0 ? rand(5, 20) : 0; // Uneori oferim discount
            
            // Calculăm totalul
            $total = $subtotal + $tax + $shipping - $discount;
            
            // Data comenzii - în ultimele 30 de zile
            $date = Carbon::now()->subDays(rand(0, 30))->subHours(rand(1, 24));
            
            // Creăm comanda
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $customerNames[array_rand($customerNames)],
                'customer_email' => 'client' . $i . '@example.com',
                'customer_phone' => '07' . rand(10000000, 99999999),
                'shipping_address' => $addresses[array_rand($addresses)],
                'billing_address' => rand(0, 3) > 0 ? $addresses[array_rand($addresses)] : null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'discount' => $discount,
                'total' => $total,
                'status' => $statuses[array_rand($statuses)],
                'notes' => rand(0, 5) === 0 ? 'Notă pentru comandă #' . $i : null,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_id' => 'PAYMENT' . rand(100000, 999999),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            
            // Atașăm produsele la comandă
            $order->products()->attach($orderProductsData);
        }
        
        $this->command->info('Au fost create 20 de comenzi de test.');
    }
}
