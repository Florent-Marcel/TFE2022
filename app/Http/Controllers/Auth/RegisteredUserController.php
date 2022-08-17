<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Display the update view.
     *
     * @return \Inertia\Response
     */
    public function viewUpdate()
    {
        return Inertia::render('Auth/Update');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'firstname' => 'required|string|max:128',
            'lastname' => 'required|string|max:128',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => ['required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique('users')->ignore(Auth::user()->id),
                        ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'firstname' => 'required|string|max:128',
            'lastname' => 'required|string|max:128',
        ]);

        Auth::user()->email = $request->email;
        Auth::user()->password = Hash::make($request->password);
        Auth::user()->firstname = $request->firstname;
        Auth::user()->lastname = $request->lastname;

        auth::user()->save();

        return redirect(RouteServiceProvider::HOME);
    }

    public function view(){
        $user = auth()->user();
        return Inertia::render('Profil', [
            'user' => $user,
            'tickets' => Ticket::getByUser($user->id)
        ]);
    }
}
