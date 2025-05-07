<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    /**
     * Atributele care pot fi asignate în masă.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'billing_address',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'status',
        'notes',
        'payment_method',
        'payment_id'
    ];
    
    /**
     * Atributele care trebuie convertite.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    
    /**
     * Obține utilizatorul care a plasat comanda.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Obține produsele din această comandă.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    
    /**
     * Calculează subtotalul comenzii.
     */
    public function calculateSubtotal()
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });
    }
    
    /**
     * Calculează totalul comenzii.
     */
    public function calculateTotal()
    {
        return $this->subtotal + $this->tax + $this->shipping - $this->discount;
    }

    /**
     * Statutul formatat al comenzii pentru afișare.
     */
    public function getFormattedStatusAttribute()
    {
        return match ($this->status) {
            'pending' => 'În așteptare',
            'processing' => 'Procesare',
            'completed' => 'Completat',
            'cancelled' => 'Anulat',
            'refunded' => 'Rambursat',
            default => $this->status,
        };
    }
}
