<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Atributele care pot fi asignate în masă.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'status',
        'category',
        'image',
        'brand',
        'model',
        'sku',
        'weight',
        'dimensions',
        'warranty',
        'featured'
    ];

    /**
     * Atributele care trebuie convertite.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'featured' => 'boolean',
    ];

    /**
     * Verifică dacă produsul este în stoc
     * 
     * @return bool
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Verifică dacă produsul are stoc redus
     * 
     * @return bool
     */
    public function hasLowStock()
    {
        return $this->stock > 0 && $this->stock <= 5;
    }

    /**
     * Obține statusul stocului formatat
     * 
     * @return string
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= 5) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    /**
     * Obține comenzile pentru acest produs
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    /**
     * Obține recenziile pentru acest produs
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculează rating-ul mediu al produsului
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    /**
     * Numărul total de recenzii
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
} 