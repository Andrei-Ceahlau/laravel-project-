<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Determină dacă utilizatorul poate vizualiza toate recenziile.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determină dacă utilizatorul poate vizualiza o recenzie.
     */
    public function view(User $user, Review $review)
    {
        return true;
    }

    /**
     * Determină dacă utilizatorul poate crea recenzii.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determină dacă utilizatorul poate actualiza o recenzie.
     */
    public function update(User $user, Review $review)
    {
        return $user->id === $review->user_id || $user->hasRole('admin');
    }

    /**
     * Determină dacă utilizatorul poate șterge o recenzie.
     */
    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id || $user->hasRole('admin');
    }
} 