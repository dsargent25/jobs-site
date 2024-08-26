<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
   public function create(){
    return view('auth.register');
   }

//    public function store(){
//     dd(request()->all());
//    }

public function store(){
    //validate
    $attributes = request()->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required', 'email', 'max:254'],
        'password' => ['required', Password::min(6), 'confirmed'],
    ]);

    $user = User::create($attributes);

    // log in

    Auth::login($user);

    // redirect somewhere

    return redirect('/jobs');

    }
}
