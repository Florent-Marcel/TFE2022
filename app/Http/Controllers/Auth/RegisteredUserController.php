<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
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
     * @param $status display a message on the page
     * @return \Inertia\Response
     */
    public function viewUpdate($status = '')
    {
        return Inertia::render('Auth/Update', [
            'status' => $status,
        ]);
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
            'firstname' => 'required|string|max:128',
            'lastname' => 'required|string|max:128',
        ]);

        Auth::user()->email = $request->email;
        Auth::user()->firstname = $request->firstname;
        Auth::user()->lastname = $request->lastname;

        auth::user()->save();

        return self::viewUpdate(__('success.profil_edited'));
    }

    /**
     * Show the profil of the connected user
     */
    public function view(){
        $user = auth()->user();
        return Inertia::render('Auth/Profil', [
            'user' => $user,
            'tickets' => Ticket::getByUser($user->id)
        ]);
    }

    public function viewDelete(){
        return Inertia::render('Auth/ProfilDelete');
    }

    public function delete(Request $request){
        $request->validate([
            'password' => ['required', 'string'],
            'confirm' => ['accepted']
        ]);

        $user = $request->user();

        if (! Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $user->softDeleteRGPD();

        return redirect(RouteServiceProvider::HOME);
    }

    public function viewPasswordEdit($status=""){
        return Inertia::render('Auth/ProfilPasswordEdit', [
            "status" => $status
        ]);
    }

    public function passwordEdit(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $request->user();

        if (! Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->current_password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return self::viewPasswordEdit(__('passwords.edited'));
    }
}
