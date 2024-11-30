<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LocalAuthController extends Controller
{
    public function selectUserForm()
    {
        $users = User::limit(5)->get();

        return view('local-auth', compact('users'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
