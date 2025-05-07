<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Afișează lista de utilizatori
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Afișează formularul pentru adăugarea unui utilizator nou
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Stochează un utilizator nou în baza de date
     */
    public function store(Request $request)
    {
        return redirect()->route('users.index');
    }

    /**
     * Afișează informațiile unui utilizator specific
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Afișează formularul pentru editarea unui utilizator
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Actualizează un utilizator specific în baza de date
     */
    public function update(Request $request, User $user)
    {
        return redirect()->route('users.show', $user);
    }

    /**
     * Șterge un utilizator specific din baza de date
     */
    public function destroy(User $user)
    {
        return redirect()->route('users.index');
    }
}
