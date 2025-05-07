<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'status'
    ];

    /**
     * Obține produsul asociat cu această recenzie
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Obține utilizatorul care a lăsat recenzia
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 