<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Afișează toate recenziile pentru un produs
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with('user')->paginate(10);
        return view('reviews.index', compact('product', 'reviews'));
    }

    /**
     * Afișează formularul pentru a crea o recenzie nouă
     */
    public function create(Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    /**
     * Stochează o recenzie nouă în baza de date
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
        ]);

        $review = new Review([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'approved', // sau 'pending' dacă dorim moderare
        ]);

        $review->save();

        return redirect()->route('products.show', $product)
            ->with('success', 'Recenzia a fost adăugată cu succes!');
    }

    /**
     * Afișează o recenzie specifică
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Afișează formularul pentru editarea unei recenzii
     */
    public function edit(Review $review)
    {
        // Verificăm dacă utilizatorul curent este autorul recenziei
        $this->authorize('update', $review);
        
        return view('reviews.edit', compact('review'));
    }

    /**
     * Actualizează o recenzie în baza de date
     */
    public function update(Request $request, Review $review)
    {
        // Verificăm dacă utilizatorul curent este autorul recenziei
        $this->authorize('update', $review);
        
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500',
        ]);

        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        return redirect()->route('products.show', $review->product)
            ->with('success', 'Recenzia a fost actualizată cu succes!');
    }

    /**
     * Șterge o recenzie
     */
    public function destroy(Review $review)
    {
        // Verificăm dacă utilizatorul curent este autorul recenziei
        $this->authorize('delete', $review);
        
        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('products.show', $productId)
            ->with('success', 'Recenzia a fost ștearsă cu succes!');
    }
} 